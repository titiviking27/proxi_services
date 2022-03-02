<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');
$sql = "SELECT * FROM blog_articles ORDER BY created_at DESC";
$query = $pdo->prepare($sql);
$query->execute();
$blog_articles = $query->fetchAll();
debug($blog_articles);
include('inc/header.php'); ?>
<section id="titre">
    <div class="wrap">
        <h1>Home</h1>
    </div>
</section>
<section id="article">
    <div class="wrap">
        <?php foreach($blog_articles as $blog_article) { ?>
            <h1><?php echo $blog_article['title']?></h1>
            <p><?php echo $blog_article['content']?></p>
            <p><?php echo $blog_article['created_at']?></p>
        <?php } ?>
    </div>
</section>
<?php include('inc/footer.php');