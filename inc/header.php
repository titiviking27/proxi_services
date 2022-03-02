<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0", maximum-scale=1.0, minimum scale=1.0>
    <title>Proxi'Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container">
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul id="nav" class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.php" class="nav-link text-uppercase font-weight-bold">Home</a></li>
                    <?php 
                    if(isLogged()) { ?>
                        <li class="nav-item"><a href="logout.php" class="nav-link text-uppercase font-weight-bold">Déconnexion</a></li>                        
                    <?php
                    } else { ?>
                    <li class="nav-item"><a href="register.php" class="nav-link text-uppercase font-weight-bold">Inscription</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link text-uppercase font-weight-bold">Connexion</a></li>
                    <?php
                    }?> 
                    <li class="nav-item"><a href="admin/index.php" class="nav-link text-uppercase font-weight-bold">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="header">
        <div class="entete">
            <img src="./asset/img/caddie-bio.jpg"/>
            <h1>Proxi Service</h1>
        </div>
        <div class="content">
            <img src="./asset/img/proxi.gif" alt="">
        </div>        
    </div>
</header>