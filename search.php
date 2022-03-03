<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');
$allWords = [];

if (!empty($_GET['search']) && is_string($_GET['search'])) {

    $motclef = trim(strip_tags($_GET['search']));
    echo $motclef;    

    $sql = "SELECT b_a.title, b_a.content, b_u.pseudo 
    FROM blog_articles AS b_a 
    LEFT JOIN blog_users AS b_u
    ON b_u.id = b_a.user_id 
    WHERE b_a.title LIKE :search OR b_a.content LIKE :search OR b_u.pseudo LIKE :search ";
    $query = $pdo->prepare($sql);
    $query->bindValue(':search','%'.$motclef.'%');
    $query->execute();

    $resultSearch = $query->fetchAll();

    debug($resultSearch);

}