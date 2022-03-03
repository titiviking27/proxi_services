<?php

session_start();

require('../inc/pdo.php');
require('../inc/fonction.php');
require('./inc/request.php');
require('./inc/parameters.php');

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $article = getById($id);
    if (empty($article)) {
        die('404');
    }
} else {
    die('404');
}

$sql = "UPDATE blog_articles SET modified_at = NOW(), status = :status WHERE id = :id";;
$query = $pdo->prepare($sql);
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->bindValue(':status', 'draft', PDO::PARAM_STR);
$query->execute();

include('inc/header.php');

echo '<h2>Article Supprimé</h2>';

include('inc/footer.php');
