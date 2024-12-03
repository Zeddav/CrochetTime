<?php
session_start();

// Informations de connexion à la base de données
$bdd = "zdavaud_bd";
$host = "lakartxela.iutbayonne.univ-pau.fr";
$user = "zdavaud_bd";
$pass = "zdavaud_bd";

// Connexion à la base de données
$link = new mysqli($host, $user, $pass, $bdd);

// Vérification de la connexion
if ($link->connect_error) {
    die("Échec de la connexion : " . $link->connect_error);
}
mysqli_set_charset($link,"utf8mb4");
// Vérification que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $titre = $link->real_escape_string(trim($_POST['titre']));
    $prix = (float)$_POST['prix'];
    $quantite = (int)$_POST['quantite'];
    $description = $link->real_escape_string(trim($_POST['description']));
    
    // Gestion de l'image
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Vérifier le type de fichier
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowedTypes)) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        } 
    }

    // Mise à jour de l'article
    $sql = "UPDATE CROCHET SET titre = '$titre', prix = $prix, quantite = $quantite" . ($image ? ", urlimage = '$image'" : "") . ", description = '$description' WHERE id = $id";
    $link->query($sql);

    header("Location: admin.php");
}

// Fermeture de la connexion
$link->close();
?>