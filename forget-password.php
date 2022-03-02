<?php
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');
$errors = [];

if(!empty($_POST['submitted'])) {
    // FailleXss
    $mail = trim(strip_tags($_POST['mail']));
    
    // Je vais chercher l'email
    $sql = "SELECT * FROM blog_users WHERE email = :mail";
    $query = $pdo->prepare($sql);
    $query->bindValue(':mail', $mail, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if(!empty($user)) {
        $urlBase = urlRemovelast( "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $href = $urlBase . '/modif-password.php?email=' . urlencode($mail) . '&token=' . urlencode($user['token']);
        echo '<a href="'.$href.'">Click ici tout en sachant qu\'il faut envoyer un mail pour que cela soit sécurisé</a>';
        die();
    } else {
        $errors['mail'] = 'error credentials';
    }
}

include('inc/header.php'); ?>
    <div class="wrap">
        <h2>Mot de passe oublié</h2>
        <form class="wrapform" action="" method="post" novalidate>
            <label for="mail">Email *</label>
            <input type="email" name="mail" id="mail" value="<?php getInputValue('mail'); ?>">
            <span class="error"><?php spanError($errors,'mail'); ?></span>

            <input type="submit" name="submitted" value="Connectez-Vous">
        </form>
    </div>
<?php include('inc/footer.php');