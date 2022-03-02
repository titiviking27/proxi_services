<?php

function getById($id)
{
    global $pdo;
    $sql = "SELECT * FROM blog_articles WHERE id = :id ";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    return  $query->fetch();
}

$sql = "SELECT * FROM blog_articles";
$query = $pdo->prepare($sql);
$query->execute();
$article = $query->fetchAll();
