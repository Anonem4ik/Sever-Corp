<?php 
    // Getting data
    $data = json_decode(file_get_contents(__DIR__."\\..\\..\\..\\json\\about_company.json"), true);
?>

<!-- Start of form page wrapper -->
<form method="post" action="actions/save_about_data.php" enctype="multipart/form-data">

    <!-- Company metrics -->
    <h3 class="page-header">Метрики компании</h3>
    <table class="default-table slim-wrapper default-container">
        <tbody id="t_metrics">
            <tr>
                <th>Название метрики</th>
                <th class="white-borders">Значение</th>
            </tr>
            <?php foreach ($data['metrics'] as $i => $metric) { ?>
            <tr>
                <td class="info-input">
                    <input type="text" name="metrics[names][]" value="<?= $metric['name'] ?>" required>
                </td>
                <td class="info-input">
                    <input type="text" name="metrics[values][]" value="<?= $metric['value'] ?>" required>
                </td>
                <td class="icon-holder">
                    <button type="button" class="clear-button" onclick="delete_metric(event)">
                        <img src="../images/general/trash_can_icon.svg" alt="Удалить">
                    </button>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td class="add-button-row" colspan="3">
                    <button type="button" class="clear-button with-image" onclick="add_metric()">
                        <img src="../images/general/cross_icon.svg" alt="Добавить">
                        Добавить
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Company description -->
    <h3 class="page-header">Описание компании</h3>
    <div class="company slim-wrapper descriprion-container default-container">
        <textarea name="description"><?= $data['company_description'] ?></textarea>
    </div>

    <!-- Snippets of company history -->
    <h3 class="page-header">История компании</h3>
    <div flex-display="centered-column" class="conpany-history__container slim-wrapper">
        <?php foreach ($data['snippets'] as $i => $snippet_text) { ?>
        <div flex-display="centered-list" class="conpany-history__snippet">
            <label for="i_change_<?= $i ?>">
                <img src="../images/history_images/snippet_image_<?= $i ?>.webp"
                id="snippet_image_<?= $i ?>" alt="history image">
            </label>
            <div class="conpany-history__snippet-text default-container">
                <textarea name="snippets[]" cols="" rows=""><?= $snippet_text ?></textarea>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- Submit button -->
    <div class="submit-section slim-wrapper">
        <button class="clear-button blue-button" type="submit">Подтвердить</button>
    </div>

    <!-- Hidden file inputs -->
    <div class="hidden" id="file_inputs">
        <?php for ($i = 0; $i < 3; $i++) { ?>
        <input id="i_change_<?= $i ?>" type="file" name="images[]" accept="image/webp,image/jpeg,image/png">
        <?php } ?>
    </div>

    <!-- Conteiner with changed images -->
    <div class="hidden" id="changed_images"></div>

</form>

<!-- Scripts -->
<script>
    // Elements
    const metric_table = document.getElementById('t_metrics');
    const file_inputs = document.getElementById('file_inputs');
    const changed_images = document.getElementById('changed_images');

    // Deleting metrics from table
    function delete_metric(event) {
        event.target.parentElement.parentElement.parentElement.remove();
    }

    // Adding metric table rows
    function add_metric(event) {
        // Checking if there is alreay five rows
        if (metric_table.childElementCount >= 6) {
            alert("Метрик не должно быть больше четырёх!");
            return;
        }
        // Adding new row
        const new_tr = document.createElement("tr");
        metric_table.insertBefore(new_tr, metric_table.lastElementChild);
        // Adding inputs
        for (let i = 0; i < 2; i++) {
            // Table data cell
            const metric_td = document.createElement("td");
            metric_td.classList += "info-input";
            new_tr.appendChild(metric_td);
            // Input
            const input = document.createElement("input");
            input.type = "text";
            input.name = (i == 0) ? "metrics[names][]" : "metrics[values][]";
            input.required = "required";
            metric_td.appendChild(input);
        }
        // Delete icon
        const icon_td = document.createElement("td");
        icon_td.classList += "icon-holder";
        new_tr.appendChild(icon_td);
        // Delete button
        const del_btn = document.createElement("button");
        del_btn.type = "button";
        del_btn.classList += "clear-button with-image";
        del_btn.onclick = delete_metric;
        del_btn.innerHTML = '<img src="../images/general/trash_can_icon.svg" alt="Удалить">';
        icon_td.append(del_btn);
    }

    // Changing images
    function change_image(event) {
        // Getting values
        const input = event.target;
        let img_num = input.id.substr(9);
        // Creating input
        let image_input = changed_images.querySelector("#i_changed_image_" + img_num);
        if (!image_input) {
            image_input = document.createElement("input");
            image_input.id = "i_changed_image_" + img_num;
            image_input.type = "hidden";
            image_input.name = "changed_images[]";
            image_input.value = img_num;
            changed_images.append(image_input);
        }
        // Displaying file in the image
        const img = document.getElementById("snippet_image_" + img_num);
        const file = input.files[0];
        img.file = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
    for (const input of file_inputs.children) input.addEventListener('change', change_image);

</script>