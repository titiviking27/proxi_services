<?php
session_start();
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');
debug($_SESSION);
include('inc/header.php'); ?>
<div class="wrap">
    <h1>Home</h1>
</div>
<?php
include('inc/footer.php');