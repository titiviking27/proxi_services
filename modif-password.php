<?php
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');

$errors = [];

if(!empty($_GET['email']) && !empty($_GET['token'])) {
    $email = urldecode($_GET['email']);
    $token = urldecode($_GET['token']);

    $sql = "SELECT * FROM user WHERE mail = :email AND token = :token";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query-> execute();
    $user = $query->fetch();
    if(empty($user)) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}


if(!empty($_POST['submitted'])) {

    $password  = trim(strip_tags($_POST['password']));
    $password2 = trim(strip_tags($_POST['password2']));

    // password // => 6 caractères au minimum, identiques et renseigné
    if(!empty($password) && !empty($password2)) {
        if(mb_strlen($password) < 6) {
            $errors['password'] = 'Votre mot de passe est trop court(min 6)';
        }  elseif ($password !== $password2) {
            $errors['password'] = 'Vos mot de passe sont différents';
        }
    } else {
        $errors['password'] = 'Veuillez renseigner les deux mots de passe';
    }

    if(count($errors) === 0) {
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $token = generateRandomString(70);
        $sql = "UPDATE user SET password = :hash, token = :token WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':hash', $hashpassword, PDO::PARAM_STR);
        $query->bindValue(':token', $token, PDO::PARAM_STR);
        $query->bindValue(':id', $user['id'], PDO::PARAM_INT);
        $query-> execute();

        // UPDATE
        header('Location: login.php');
    }
}


include('inc/header.php'); ?>
    <div class="wrap">
        <h2>Modification  de votre mot de passe</h2>
        <form class="wrapform" action="" method="post" novalidate>
            <label for="password">Mot de passe *</label>
            <input type="password" name="password" id="password">
            <span class="error"><?php spanError($errors,'password'); ?></span>

            <label for="password2">Confirmation mot de passe *</label>
            <input type="password" name="password2" id="password2">

            <input type="submit" name="submitted" value="Connectez-Vous">
        </form>
    </div>
<?php include('inc/footer.php');
