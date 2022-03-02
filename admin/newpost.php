<?php
session_start();

require('../inc/pdo.php');
require('../inc/fonction.php');
require('./inc/request.php');
require('./inc/parameters.php');

$errors = array();
// if form soumis
if (!empty($_POST['submitted'])) {
    // Faille XSS
    debug($_FILES);
    $title = trim(strip_tags($_POST['title']));
    $content = trim(strip_tags($_POST['content']));
    $status = trim(strip_tags($_POST['status']));
    $user_id = trim(strip_tags($_SESSION['user']['id']));    

    // Validation 
    $errors = validText($errors, $title, 'title', 3, 50);
    $errors = validText($errors, $content, 'content', 5, 150);

    if (!empty($_FILES['image']) && $_FILES['image']['error'] > 0) {
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
            } else {
                // 
                $point = strrpos($file_name, '.');
                $extens = substr($file_name, $point, strlen($file_name) - $point);
                $newfile = time() . generateRandomString(12);
                move_uploaded_file($file_tmp, 'upload/' . $newfile .$extens);
                $image = 'upload/' . $newfile .$extens;
            }
        }
    }

    // Insérer le formulaire si pas d'erreurs
    if (count($errors) === 0) {

        echo $_SESSION['user']['id'];
        $sql = "INSERT INTO blog_articles (title, content, user_id, created_at, status, image)
                VALUES (:title, :content, :user_id, NOW(), :status, :image)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':content', $content, PDO::PARAM_STR);
        $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindValue(':status', $status, PDO::PARAM_STR);
        $query->bindValue(':image', $image, PDO::PARAM_STR);
        $query-> execute(); 
    }
}


include('inc/header.php'); ?>

<form class="wrap" action="" method="post" enctype="multipart/form-data" novalidate>
    <label for="title">Nom d'article</label>
    <input type="text" name="title" id="title" value="<?php getInputValue('title') ?>">
    <span class="error"><?php spanError($errors, 'title'); ?></span>

    <label for="title">Description</label>
    <input type="text" name="content" id="content" value="<?php getInputValue('content') ?>">
    <span class="error"><?php spanError($errors, 'content'); ?></span>

    <label for="title">Image</label>
    <input type="file" name="image" id="image">
    <span class="error"><?php spanError($errors, 'image'); ?></span>

    <select name="status" id="status">
        <?php foreach ($lesStatus as $value) { ?>
            <option value="<?php echo $value; ?>" <?php
                if (!empty($_POST['status']) && $_POST['status'] === $value) {
                    echo ' selected';
                } elseif (!empty($article['status'])) {
                    if ($article['status'] === $value) {
                        echo ' selected';
                    }
                }
                ?>><?php echo ucfirst($value); ?></option>
        <?php } ?>
    </select>
    <input type="submit" name="submitted" value="Créer un article">
</form>

<?php
include('inc/footer.php');
