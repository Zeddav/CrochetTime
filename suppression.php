<?php
session_start(); // Démarre ou reprend une session existante

// Informations de connexion à la base de données
$bdd = "zdavaud_bd";
$host = "lakartxela.iutbayonne.univ-pau.fr";
$user = "zdavaud_bd";
$pass = "zdavaud_bd";

// Création d'une connexion à la base de données
$link = new mysqli($host, $user, $pass, $bdd);

// Vérifie si la connexion a échoué
if ($link->connect_error) {
    die("Échec de la connexion : " . $link->connect_error); 
}
mysqli_set_charset($link,"utf8mb4");
// Supprimer les enregistrements 
if (isset($_POST['id'])) {
    $idToRemove = $_POST['id']; // Récupère l'identifiant de l'enregistrement à supprimer
    $sql = "DELETE FROM CROCHET WHERE id = $idToRemove"; // Requête SQL pour supprimer l'enregistrement
    $link->query($sql); 
    header("Location: admin.php"); // Redirige vers la page admin après suppression
    exit(); 
}

$link->close(); // Ferme la connexion à la base de données
