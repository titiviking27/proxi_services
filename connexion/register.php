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
    $pseudo    = trim(strip_tags($_POST['pseudo']));
    $mail      = trim(strip_tags($_POST['mail']));
    $password  = trim(strip_tags($_POST['password']));
    $password2 = trim(strip_tags($_POST['password2']));
    // validation
    // pseudo min 3, max 140, renseigné et unique.
    $errors = validText($errors, $pseudo,'pseudo', 3, 140);
    if(empty($errors['pseudo'])) {
        $sql = "SELECT id FROM user WHERE pseudo = :pseudo";
        $query = $pdo->prepare($sql);
        $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->execute();
        $pseudoExist = $query->fetch();
        if(!empty($pseudoExist)) {
            $errors['pseudo'] = 'Pseudo déjà pris';
        }
    }
    // email => email valid , unique et renseigné
    $errors = validEmail($errors, $mail, 'mail');
    if(empty($errors['mail'])) {
        $sql = "SELECT id FROM user WHERE mail = :mail";
        $query = $pdo->prepare($sql);
        $query->bindValue(':mail', $mail, PDO::PARAM_STR);
        $query->execute();
        $emailExist = $query->fetch();
        if(!empty($emailExist)) {
            $errors['mail'] = 'E-mail déjà pris';
        }
    }
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
        $sql = "INSERT INTO user (pseudo, mail,password, token, created_at, role) VALUES (:pseudo, :mail, :password, :token, NOW(), 'abonne')";
  
        $query = $pdo->prepare($sql);
        $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->bindValue(':mail', $mail, PDO::PARAM_STR);
        $query->bindValue(':password', $hashpassword, PDO::PARAM_STR);
        $query->bindValue(':token', $token, PDO::PARAM_STR);
        $query->execute();

      
        //header('Location: login.php');
    }
}

include('inc/header.php'); ?>
    <div class="wrap">
        <h2>Inscription</h2>
        <form class="wrapform" action="" method="post" novalidate>
            <label for="pseudo">Pseudo *</label>
            <input type="text" name="pseudo" id="pseudo" value="<?php getInputValue('pseudo'); ?>">
            <span class="error"><?php spanError($errors,'pseudo'); ?></span>

            <label for="mail">E-mail *</label>
            <input type="email" name="mail" id="mail" value="<?php getInputValue('mail'); ?>">
            <span class="error"><?php spanError($errors,'mail'); ?></span>

            <label for="password">Mot de passe *</label>
            <input type="password" name="password" id="password">
            <span class="error"><?php spanError($errors,'password'); ?></span>

            <label for="password2">Confirmation mot de passe *</label>
            <input type="password" name="password2" id="password2">

            <input type="submit" name="submitted" value="Inscrivez-Vous">
        </form>
    </div>
<?php include('inc/footer.php');
