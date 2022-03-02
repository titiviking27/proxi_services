<?php

function getById($id) {
    global $pdo;
    $sql = "SELECT * FROM users WHERE id = :id ";
    $query = $pdo->prepare($sql);
    // protection injection SQL
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    return  $query->fetch();
}