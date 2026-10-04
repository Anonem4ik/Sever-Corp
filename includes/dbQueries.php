<?php

// Insert row into table
function insert_data(PDO $pdo, string $table, array $values) {
    $sql = "INSERT INTO `$table` (";
    foreach ($values as $col => $_) {
        $sql .= "`$col`, ";
    }
    $sql = rtrim($sql, ', ') . ') VALUES (';
    foreach ($values as $col => $_) {
        $sql .= ":$col, ";
    }
    $sql = rtrim($sql, ', ') . ')';
    $statement = $pdo->prepare($sql);
    foreach ($values as $col => $val) {
        $statement->bindValue(':'.$col, $val);
    }
    $statement->execute();
}

// Delete rows from tabel
function delete_data(PDO $pdo, string $table, array $values) {
    $sql = "DELETE FROM $table WHERE ";
    $conditions = [];
    foreach ($values as $col => $_) {
        $conditions[] = "`$col` = :$col";
    }
    $sql .= implode(" AND ", $conditions);
    $statement = $pdo->prepare($sql);
    foreach ($values as $col => $val) {
        $statement->bindValue(':'.$col, $val);
    }
    $statement->execute();
}

// Select by some conditions
function getBy(PDO $pdo, string $table, array $values, bool $all=false) {
    $sql = "SELECT * FROM `$table` WHERE ";
    $conditions = [];
    foreach ($values as $col => $_) {
        $conditions[] = "`$col` = :$col";
    }
    $sql .= implode(" AND ", $conditions);
    $statement = $pdo->prepare($sql);
    foreach ($values as $col => $val) {
        $statement->bindValue(':'.$col, $val);
    }
    $statement->execute();
    if ($all) return $statement->fetchAll();
    else return $statement->fetch();
}

// List of categories
function getAllOrdered(PDO $pdo, string $col) {
    $sql = "SELECT * FROM categories ORDER BY `$col`";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    return $statement;
}