<?php
    require_once __DIR__."\\..\\..\\..\\includes\\connect.php";
    // Unpacking values
    $action = $_GET['action'] ?? 'add';
    $good_id = $_GET['id'] ?? null;
    // Check for valid action
    if ($action != 'add' && $action != 'update') {
        $_SESSION['error_message'] = 'Неправильное действие!';
        exit;
    }
    // Check if id is present
    if ($action == 'update' && is_null($good_id)) {
        $_SESSION['error_message'] = 'Отсудствует интедификационный номер товара!';
        exit;
    }
    // Getting goods data
    $result = null;
    $additional_info = [];
    if ($action == 'update') {
        // Main data
        $sql = <<<EOF
        SELECT `article_num`, `name`, `FK_category`, `price`, `wholesale_price`,
        `description`, `country`, `FK_shipper`, `FK_special_offer`, `supply_left`,
        `images_count`
        FROM goods WHERE good_id = :good_id;
        EOF;
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':good_id', $good_id);
        $statement->execute();
        $result = $statement->fetch();
        // Additional info
        $sql = "SELECT * FROM additional_info WHERE FK_good = :good_id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':good_id', $good_id);
        $statement->execute();
        $additional_info = $statement->fetchAll();
    }
    // Categories
    $sql = "SELECT * FROM `categories`";
    $categories = $pdo->query($sql);
    // Shippers
    $sql = "SELECT * FROM `shippers`";
    $shippers = $pdo->query($sql);
    // Categories
    $sql = "SELECT * FROM `special_offers`";
    $special_offers = $pdo->query($sql);
?>

<!-- Start of form page wrapper -->
<form id="main_form" method="post" action="actions/test.php" enctype="multipart/form-data">

    <!-- Header of the page, and name of the good -->
    <h2 flex-display="centered-list" class="page-header wide">
        <label for="i_name">Название товара: </label>
        <input class="f-24" type="text" name="fields[name]" id="i_name" value="<?= clean($result['name'] ?? '') ?>" required>
    </h2>

    <!-- List of images -->
    <div flex-display="centered-list" class="images-list" id="images_list">
        <!-- Existing images -->
        <?php for ($i = 0; $i < ($result['images_count'] ?? 0); $i++) { ?>
        <img src="../images/items_images/<?= $good_id ?>_<?= $i + 1 ?>.webp"
        alt="Изображение товара" id="img<?= $i ?>" onclick="toggle_existing_img(event)">
        <?php } ?>
        <!-- Add image button -->
        <label flex-display="centered-column" class="new-image-input" for="i_new_image">
            <img src="../images/general/cross_icon.svg" alt="Добавить">
            <p>Добавить изображения</p>
        </label>
    </div>
    <div class="hidden" id="images_info">
        <input id="i_new_image" type="file" name="images[]" accept="image/webp,image/jpeg,image/png" multiple>
    </div>

    <!-- Good descriprion -->
    <div class="company slim-wrapper descriprion-container default-container">
        <textarea name="fields[description]"><?= $result['description'] ?? '' ?></textarea>
    </div>

    <!-- Table with main characteristics -->
    <table class="default-table slim-wrapper default-container">
        <tr>
            <th colspan="2">Основная информация</th>
        </tr>
        <tr>
            <td class="info-name">Категория</td>
            <td class="info-input">
                <select type="text" name="fields[FK_category]" required>
                    <?php foreach ($categories as $row) { ?>
                    <option value="<?= $row['category_id'] ?>"
                    <?= $row['category_id'] == ($result['FK_category']  ?? '') ? 'selected="selected"' : ''?>>
                        <?= clean($row['name']) ?>
                    </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="info-name">Артикул</td>
            <td class="info-input">
                <input type="number" name="fields[article_num]" value="<?= clean($result['article_num'] ?? '') ?>" required>
            </td>
        </tr>
        <tr>
            <td class="info-name">Поставщик</td>
            <td class="info-input">
                <select type="text" name="fields[FK_shipper]" required>
                    <?php foreach ($shippers as $row) { ?>
                    <option value="<?= $row['shipper_id'] ?>"
                    <?= $row['shipper_id'] == ($result['FK_shipper'] ?? '') ? 'selected="selected"' : ''?>>
                        <?= clean($row['name']) ?>
                    </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="info-name">Страна</td>
            <td class="info-input">
                <input type="text" name="fields[country]" value="<?= clean($result['country'] ?? '') ?>" required>
            </td>
        </tr>
        <tr>
            <td class="info-name">Цена</td>
            <td class="info-input">
                <input type="number" name="fields[price]" value="<?= clean($result['price'] ?? '') ?>" min="0" step="0.01" required>
            </td>
        </tr>
        <tr>
            <td class="info-name">Оптовая цена</td>
            <td class="info-input">
                <input type="number" name="fields[wholesale_price]" value="<?= clean($result['wholesale_price'] ?? '') ?>"
                min="0" step="0.01" required>
            </td>
        </tr>
        <tr>
            <td class="info-name">Специальное предложение</td>
            <td class="info-input">
                <select type="text" name="fields[FK_special_offer]">
                    <option value="">Отсутствует</option>
                    <?php foreach ($special_offers as $row) { ?>
                    <option value="<?= $row['offer_id'] ?>"
                    <?= $row['offer_id'] == ($result['FK_special_offer']  ?? '') ? 'selected="selected"' : ''?>>
                        <?= clean($row['partner']) ?> - <?= clean($row['offer_value']) ?>%
                    </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="info-name">Остаток на складе</td>
            <td class="info-input">
                <input type="number" name="fields[supply_left]" value="<?= clean($result['supply_left'] ?? '') ?>" min="0" required>
            </td>
        </tr>
    </table>

    <!-- Table with additional information -->
    <table class="default-table slim-wrapper default-container">
        <tbody id="t_additional_info">
            <tr>
                <th colspan="3">Дополнительные характеристики</th>
            </tr>
            <?php foreach ($additional_info as $row) { ?>
            <tr>
                <input type="hidden" name="updated_info[ids][]" value="<?= $row['info_id'] ?>">
                <td class="info-input">
                    <input type="text" name="updated_info[names][]" value="<?= clean($row['name']) ?>" required>
                </td>
                <td class="info-input">
                    <input type="text" name="updated_info[values][]" value="<?= clean($row['value']) ?>" required>
                </td>
                <td class="icon-holder">
                    <button type="button" class="clear-button" onclick="remove_existing_info(<?= $row['info_id'] ?>)">
                        <img src="../images/general/trash_can_icon.svg" alt="Удалить">
                    </button>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td class="add-button-row" colspan="3">
                    <button type="button" class="clear-button with-image" onclick="add_additional_info()">
                        <img src="../images/general/cross_icon.svg" alt="Добавить">
                        Добавить
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- General hidden inputs -->
    <input type="hidden" name="table_name" value="goods">
    <?php if ($action == 'update') { ?>
    <input type="hidden" name="id" value="<?= $good_id ?>">
    <?php } ?>
    <!-- Trash can for deleted info and images -->
    <div class="hidden" id="trash"></div>
    <!-- Submit button -->
    <div class="submit-section slim-wrapper">
        <button class="clear-button green-button" type="submit">Подтвердить</button>
    </div>
</form>

<!-- Scripts all actions on page -->
<script>
    // Elements
    const img_list = document.getElementById("images_list");
    const img_info = document.getElementById("images_info");
    const file_input = document.getElementById('i_new_image');
    const add_info_table = document.getElementById('t_additional_info');
    const trash_can = document.getElementById('trash');
    // Files list
    let img_files = [];
    // Counter for file ID's
    let counter = 0;

    // Function to upload images
    function on_upload(event) {
        if (!this.files.length) return;
        // Clearing images
        img_list.childNodes.forEach(element => {
            if (element.tagName == "img") element.remove();
        });
        // Looping trough all uploaded files
        for (const file of this.files) {
            // Pushing files to global array
            let file_id = "FID" + counter++;
            img_files.push({
                file: file,
                id: file_id
            });
            // Creating new images
            const img = document.createElement("img");
            img.alt = "Изображение товара";
            img.onclick = function(e) { delete_img(e.target, file_id); };
            img_list.insertBefore(img, img_list.lastElementChild);
            // Displaying file in the image
            img.file = file;
            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        // Reseting input filelist
        this.value = null;
    }
    file_input.addEventListener('change', on_upload);

    // Function to delete images
    const delete_img = (img, file_id) => {
        for (let i = 0; i < img_files.length; i++) {
            if (img_files[i].id == file_id) {
                img_files.splice(i, 1);
                img.remove();
                return;
            }
        }
    }

    // Adding new additional info
    function add_additional_info(event) {
        // Adding new row
        const new_tr = document.createElement("tr");
        add_info_table.insertBefore(new_tr, add_info_table.lastElementChild);
        // Adding inputs
        for (let i = 0; i < 2; i++) {
            // Table data cell
            const info_td = document.createElement("td");
            info_td.classList += "info-input";
            new_tr.appendChild(info_td);
            // Input
            const input = document.createElement("input");
            input.type = "text";
            input.name = (i == 0) ? "add_info[names][]" : "add_info[values][]";
            input.required = "required";
            info_td.appendChild(input);
        }
        // Delete icon
        const icon_td = document.createElement("td");
        icon_td.classList += "icon-holder";
        new_tr.appendChild(icon_td);
        // Delete button
        const del_btn = document.createElement("button");
        del_btn.type = "button";
        del_btn.classList += "clear-button with-image";
        del_btn.onclick = delete_additional_info;
        del_btn.innerHTML = '<img src="../images/general/trash_can_icon.svg" alt="Удалить">';
        icon_td.append(del_btn);
    }

    // Deleting additional info
    function delete_additional_info(event) {
        event.target.parentElement.parentElement.parentElement.remove();
    }

    // Function to delete existing images
    function toggle_existing_img(event) {
        const img = event.target
        if (!img.classList.contains("deleted-image")) {
            // Creating input
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "removed_img[]";
            input.value = parseInt(img.id.substring(3)) + 1;
            input.id = "i_" + img.id;
            trash_can.appendChild(input);
            // Changing image class
            img.classList.add("deleted-image");
        } else {
            // Deleting input
            trash_can.querySelector("#i_" + img.id).remove();
            // Removing image class
            img.classList.remove("deleted-image");
        }
    }

    // Deleting existing info
    function remove_existing_info(entry_id) {
        // Creating input
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "removed_add_info[]";
        input.value = entry_id;
        trash_can.appendChild(input);
        // Deleting row
        event.target.parentElement.parentElement.parentElement.remove();
    }

    // Processing form
    const form = document.forms['main_form']
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        // Getting action
        const url = new URLSearchParams(document.location.search);
        const action = url.get("action");
        const path = (action === 'add') ? 'add_data.php' : 'update_data.php';
        // Check for images
        let images_count = 0;
        if (action === 'update') {
            for (let el of img_list.children) {
                if (el.tagName !== 'IMG' || el.id == '') continue;
                if (trash_can.querySelector("#i_" + el.id) == null) images_count++;
            };
        }
        if (img_files.length + images_count === 0) {
            alert("Добавте хотя бы одно изображение!");
            return;
        }
        // Create new formdata
        const form_data = new FormData(form);
        // Appending existing data
        for (const file_data of img_files) {
            form_data.append("images[]", file_data.file);
        }
        var request = new XMLHttpRequest();
        request.open("POST", "actions/" + path, false);
        request.send(form_data);
        window.location = "?page=goods";
    });
</script>