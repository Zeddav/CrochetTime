<?php
session_start();

// Vérifie si les paramètres id et le panier sont présents dans la requête POST
if (isset($_POST['id']) && isset($_SESSION['panier'])) {
    $idToRemove = $_POST['id']; 

    // Vérifie si l'article est dans le panier avant de le supprimer
    if (isset($_SESSION['panier'][$idToRemove])) {
        unset($_SESSION['panier'][$idToRemove]); // Supprime l'article du panier
    }
    
    // Redirection vers la page du panier après suppression
    header("Location: panier.php");
    exit(); 
}
?>
