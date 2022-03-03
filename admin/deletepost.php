<?php

session_start();

require('../inc/pdo.php');
require('../inc/fonction.php');
require('./inc/request.php');
require('./inc/parameters.php');

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $article = getById($id);
    debug($article);
    if (empty($article)) {
        die('404');
    }
} else {
    die('404');
}

$sql = "DELETE FROM blog_articles WHERE id = :id";
$query = $pdo->prepare($sql);
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

include('inc/header.php');

echo '<p>Article Supprimé</p>';

include('inc/footer.php');
