<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');

// debug($_SESSION);
$sql = "SELECT b_a.id, b_a.title, b_a.created_at, b_u.pseudo 
        FROM blog_articles AS b_a 
        LEFT JOIN blog_users AS b_u
        ON b_u.id = b_a.user_id
        ORDER BY b_a.created_at DESC";
$query = $pdo->prepare($sql);
$query->execute();
$blog_articles = $query->fetchAll();

include('inc/header.php'); ?>
<section id="titre">
    <div class="wrap" id="title">
        <h1>Home</h1>
    </div>
</section>
<section id="article">
    <div class="wrap">
    <?php foreach($blog_articles as $blog_article) { ?>
        <h1><?php echo $blog_article['title']?></h1>
        <p><?php echo $blog_article['pseudo']?></p>
        <p><?= date('d/m/Y à H:i', strtotime($blog_article['created_at']));?></p>
        <a href="single.php?id=<?= $blog_article['id']?>">Détail de l'article</a>
        <hr class="hr-text">
    <?php
    } 
    ?>
    </div>
</section>
<?php 
include('inc/footer.php');