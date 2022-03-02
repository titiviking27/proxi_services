<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');
if(isLogged()) {
    header('Location: index.php');
}

$errors = [];
if(!empty($_POST['submitted'])) {
    // FailleXss
    // je sécurise et récup les données    
    $login    = trim(strip_tags($_POST['login']));
    $password = trim(strip_tags($_POST['password']));

    // requête pour récupérer le use lié au login
    $sql = "SELECT * FROM blog_users WHERE pseudo = :login OR email = :login";
    $query = $pdo->prepare($sql);
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query-> execute();
    $user = $query->fetch();
    // si user est renseigné
    if(!empty($user)) {
        // Vérification du password
        if(password_verify($password, $user['password'] )) {
            // je renseigne la session
            $_SESSION['user'] = array(
                'id'     => $user['id'],
                'pseudo' => $user['pseudo'],
                'email'  => $user['mail'],
                'role'   => $user['role'],
                'ip'     => $_SERVER['REMOTE_ADDR']
            );

            /// redirection vers l'index front
            header('Location: index.php');
        } else {
            $errors['login'] = 'Error credentials';
        }
    } else {
        $errors['login'] = 'Error credentials';
    }
}
include('inc/header.php'); ?>
    <div class="wrap">
        
        <!-- ------------   Formulaire de connexion  -->
        <form class="wrapform" action="" method="post" novalidate>

        <!-- ------- INPUT PSEUDO -->
            <label for="login">Pseudo Or Email *</label>
            <input type="text" name="login" id="login" value="<?php getInputValue('login'); ?>">
            <span class="error"><?php spanError($errors,'login'); ?></span>

            <!-- ------- INPUT PASSWORD -->
            <label for="password">Mot de passe *</label>
            <input type="password" name="password" id="password">

            <!-- ----- VALIDER  -->
            <input type="submit" name="submitted" value="Connectez-Vous">
            <p><a href="forget-password.php">Mot de passe oublié</a></p>
        </form>
    </div>
<?php include('inc/footer.php');