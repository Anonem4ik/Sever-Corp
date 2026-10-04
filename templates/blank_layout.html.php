<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/general/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/generic_form.css">
    <title><?= $page_title ?></title>
</head>
<body>
    <?php include __DIR__."\\error_modal.html.php"; ?>

    <main class="page">
        <?= $page_content ?>
    </main>
</body>
</html>