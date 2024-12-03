<?php
session_start(); 

// Vérifier si l'id de l'article est envoyé via le formulaire
if (isset($_POST['id_article']) && isset($_POST['qt_article'])) {
    $id_article = $_POST['id_article'];
    $qtMax_article = $_POST['qt_article'];

    // Vérifier existence du panier
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = []; 
    }

    // Si l'article est déjà dans le panier, on augmente sa quantité (si elle n'est pas déjà au max)
    if (isset($_SESSION['panier'][$id_article]) && $_SESSION['panier'][$id_article] < $qtMax_article) {
        $_SESSION['panier'][$id_article] += 1;

    } elseif (!isset($_SESSION['panier'][$id_article])) {
        // Si l'article n'est pas encore dans le panier, on l'ajoute avec une quantité de 1
        $_SESSION['panier'][$id_article] = 1;
    }

    
}

// Rediriger vers la page précédente ou une autre page
header('Location: index.php'); 
exit();
?>




