<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Old bd
$db = mysqli_connect('MySQL-8.0', 'root', '', 'sever_corp');
if (!$db) die("Ошибка подключения к БД!");

// Connection to BD trough PDO
try {
    $pdo = new PDO('mysql:host=MySQL-8.0;dbname=sever_corp', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<pre>";
    echo "Internal server error when connection to BD!\n";
    echo "In file <b>".$e->getFile()."</b> on line ".$e->getLine().".\n";
    echo "Message: ".$e->getMessage();
    echo "</pre>";
}