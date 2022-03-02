<?php
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');

$errors = array();
// if form soumis
if (!empty($_POST['submitted'])) {
    // Faille XSS
    $title = trim(strip_tags($_POST['title']));
    $content = trim(strip_tags($_POST['content']));
    $image = trim(strip_tags($_POST['image']));

    // Validation 
    $errors = validText($errors, $title, 'title', 3, 50);
    $errors = validText($errors, $content, 'content', 5, 150);

    if ($_FILES['image']['error'] > 0) {
        if ($_FILES['image']['error'] != 4) {
            $errors['image'] = 'Error: ' . $_FILES['image']['error'];
        } else {
            $errors['image'] = 'Veuillez renseigner une image';
        }
    } else {
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        // Taille du fichier
        $sizeMax = 2000000; // 2mo
        if ($file_size > $sizeMax || filesize($file_tmp) > $sizeMax) {
            $errors['image'] = 'Votre fichier est trop gros (max 2mo).';
        } else {
            // Type du fichier.
            $allowedMimeType = array('image/png', 'image/jpeg', 'image/jpg');
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file_tmp);
            if (!in_array($mime, $allowedMimeType)) {
                $errors['image'] = 'Veuillez télécharger une image du type jpeg ou .png';
            }
        }
    }
    if (count($errors) === 0) {
        $sql = "INSERT INTO blog_articles (title, content, user_id, created_at, status, image)
                VALUES (:title, :content, :user_id, NOW(), :status, :image)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':content', $content, PDO::PARAM_STR);
        $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindValue(':status', $status, PDO::PARAM_STR);
        $query->bindValue(':image', $image, PDO::PARAM_STR);

        $point = strrpos($file_name, '.');
        $extens = substr($file_name, $point, strlen($file_name) - $point);
        $newfile = time() . generateRandomString(12);

        if (!is_dir('upload')) {
            mkdir('upload');
        }
    }
}


include('inc/header.php'); ?>

<form class="wrap" action="" method="post" novalidate>
    <label for="title">Nom d'article</label>
    <input type="text" name="title" id="title" value="<?php getInputValue('title') ?>">
    <span class="error"><?php spanError($errors, 'title'); ?></span>

    <label for="title">Description</label>
    <input type="text" name="content" id="content" value="<?php getInputValue('content') ?>">
    <span class="error"><?php spanError($errors, 'content'); ?></span>

    <input type="file" name="image" id="image">
    <span class="error"><?php getInputValue('image'); ?></span>

    <input type="submit" name="submitted" value="Créer un article">

    <?php
    include('inc/footer.php');
