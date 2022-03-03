<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');
require('vendor/autoload.php');

use JasonGrimes\Paginator;
// nombres d'articles par page
$itemsPerPage = 3;
// page courrent par defaut
$urlPattern = 'index.php?currentPage=(:num)';
$currentPage = 1;
if (!empty($_GET['currentPage'])) {
    $currentPage = $_GET['currentPage'];
}

// le pattern
$offset = $currentPage * $itemsPerPage - $itemsPerPage;

// jointure pour associer users et articles
$sql = "SELECT b_a.id, b_a.title, b_a.status, b_a.created_at, b_u.pseudo 
        FROM blog_articles AS b_a 
        LEFT JOIN blog_users AS b_u
        ON b_u.id = b_a.user_id
        ORDER BY b_a.created_at DESC
        LIMIT $itemsPerPage OFFSET $offset";
$query = $pdo->prepare($sql);
$query->execute();
$blog_articles = $query->fetchAll();


$sql = "SELECT COUNT(id) FROM blog_articles";
$query = $pdo->prepare($sql);
$query->execute();
$totalItems = $query->fetchColumn();

$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

include('inc/header.php');
?>
<section id="titre">
    <div class="wrap" id="title">
        <br>
        <h1>Home</h1>

        <h4 class="paginator">Page <?= $currentPage; ?></h4>
        <span class="paginator"><?= $paginator; ?></span>


    </div>
</section>
<section id="article">
    <div class="wrap">
        <?php foreach ($blog_articles as $blog_article) { ?>
            <?php if ($blog_article['status'] == 'publish') { ?>
                <br>
                <h1 class="article_title"><?php echo $blog_article['title'] ?></h1>
                <p><?php echo $blog_article['pseudo'] ?></p>
                <p><?= date('d/m/Y à H:i', strtotime($blog_article['created_at'])); ?></p>
                <hr class="hr-text">
                <a class="details" href="single.php?id=<?= $blog_article['id'] ?>">Détail de l'article</a>
                <hr class="hr-text">

        <?php }
        }
        ?>

        <h4 class="paginator">Page <?= $currentPage; ?></h4>
        <span class="paginator"><?= $paginator; ?></span>
    </div>
</section>
<?php
include('inc/footer.php');
