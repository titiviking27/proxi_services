<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0", maximum-scale=1.0, minimum scale=1.0>
    <title>Proxi Service</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>
<header>
    <div class="header">
        <div class="entete">
            <img src="./asset/img/caddie-bio.jpg"/>
            <h1>Proxi Service</h1>
        </div>
        <div class="content">
            <img src="./asset/img/proxi.gif" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if(isLogged()) { ?>
                <li><a href="logout.php">Déconnexion</a></li>
                <?php if(isLoggedAdmin()) { ?>
                    <li><a href="admin/index.php">Admin</a></li>
                    <?php } ?>
                <?php } else { ?>
                <li><a href="register.php">Inscription</a></li>
                <li><a href="login.php">Connexion</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>