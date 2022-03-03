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
    <script src="https://kit.fontawesome.com/4e7daa302a.js" crossorigin="anonymous"></script>
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
                    }
                    if(isLoggedAdmin()) { ?> 
                    <li class="nav-item"><a href="admin/index.php" class="nav-link text-uppercase font-weight-bold">Admin</a></li>
                    <?php
                    } ?>
                </ul>                     
            </div>
            <div class="recherche">
                <form class="search" action="" method="GET">
                    <div class="loupe">
                        <input class="form-control inps" type="search" placeholder="Recherche par mot clé" aria-label="Search" name="search" value="">
                        <a href="./search.php?search=<?php 
                            if (!empty($_GET['search'])) { 
                                echo $_GET['search']; 
                                } ?>
                                "><i class="fa-solid fa-magnifying-glass"></i></a>
                    </div>
                </form>
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
            <div class="contenu">
                <h1>Présentation</h1>
                <hr class="hr-text" >
                <p><em><strong>Nous voulons dévellopper le commerce de proximité</strong></em></p>
                <p><em><strong>Pour permettre au petits commerçants</strong></em></p>
                <p><em><strong>N'ayant pas les moyens d'investir dans un site web</strong></em></p>
                <p><em><strong>De vendre leurs produits en ligne sous formes de paniers</strong></em></p>
            </div>
        </div>        
    </div>
</header>