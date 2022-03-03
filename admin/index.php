<?php
session_start();
require('../inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');
// debug($_SESSION);
include('inc/header.php'); ?>
<div class="wrap">
    <h1>Admin index</h1>
    <nav>
        <ul id="buttons">
            <li><a href="../index.php">Home</a></li>
            <br>
            <li><a href="./newpost.php">Nouvel Article</a></li>
        </ul>
    </nav>
</div>
<?php
include('inc/footer.php');
