<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];
    // jointure pour associer users et articles
    $sql = "SELECT b_a.title, b_a.content, b_a.created_at, b_a.image, b_u.pseudo 
    FROM blog_articles AS b_a 
    LEFT JOIN blog_users AS b_u
    ON b_u.id = b_a.user_id WHERE b_a.id = $id";
    $query = $pdo->prepare($sql);
    $query->execute();

    $blog_article = $query->fetch();

    if (empty($blog_article)) {
        die('404');
    }
} else {
    die('404');
}
include('inc/header.php'); ?>

<section class="middle">
    <div class="wrap">
        <div class="auteur">
            <h1>Titre :<?= $blog_article['title']; ?></h1>
            <p>Contenu : <?= $blog_article['content']; ?></p>
            <p>Pseudo : <?= $blog_article['pseudo']; ?></p>
            <?php
            //  Affichage de l'image si image dans l'article
            if (!empty($blog_article['image'])) { ?>
                <img src="admin/<?= $blog_article['image']; ?>" />
            <?php
            }
            ?>
            <p>Date de création : <?= date('d/m/Y', strtotime($blog_article['created_at'])); ?></p>
            <p><input type="button" value="Editer l'article" ; onclick=window.location.href='admin/editpost.php?id=<?= $_GET['id']; ?>'></p>
            <p><input type="button" value="Supprimer l'article" ; onclick=window.location.href='admin/deletepost.php?id=<?= $_GET['id']; ?>'></p>
            <hr class="hr-text">
        </div>
    </div>
</section>

<?php include('inc/footer.php');
