<?php
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "SELECT b_a.id, b_a.title, b_a.content, b_a.created_at, b_u.pseudo 
    FROM blog_articles AS b_a 
    LEFT JOIN blog_users AS b_u
    ON b_u.id = :id
    ORDER BY b_a.created_at DESC";

    $query = $pdo->prepare($sql);
    $query->bindValue(':id',$id, PDO::PARAM_INT);
    $query->execute();
    $blog_article = $query->fetch();

    debug($blog_article);
    if(empty($blog_article)) { die('404'); }
} else {
    die('404');
}
include('inc/header.php'); ?>
<div class="auteur">
    <h1>Titre :<?= $blog_article['title']; ?></h1>
    <p>Contenu : <?= $blog_article['content']; ?></p>
    <p>Pseudo : <?= $blog_article['pseudo']; ?></p>
    <p>Date de création : <?= date('d/m/Y',strtotime($blog_article['created_at'])); ?></p>
    <hr class="hr-text">
</div>

<?php include('inc/footer.php');