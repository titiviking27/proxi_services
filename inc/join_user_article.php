<?php

// jointure pour associer users et articles
$sql = "SELECT b_a.id, b_a.title, b_a.created_at, b_u.pseudo 
        FROM blog_articles AS b_a 
        LEFT JOIN blog_users AS b_u
        ON b_u.id = b_a.user_id
        ORDER BY b_a.created_at DESC";
        $query = $pdo->prepare($sql);
        $query->execute();
        
        $blog_article = $query->fetch();
