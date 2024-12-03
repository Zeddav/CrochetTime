<?php 
//Démarre la session
session_start(); ?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='node_modules/bootstrap/dist/css/bootstrap.css'> 
    <link rel="stylesheet" href="styles.css"> 
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script> 
    <title>Crochet</title>
</head>
<body class='container'>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Crochet'Time</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> 
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Doudous</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="identification.html">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="panier.php">Panier</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php
    // Récupération des paramètres passés dans l'URL
    $id = $_GET['id']; 
    $image = $_GET['image'];
    $titre = $_GET['titre']; 
    $prix = $_GET['prix']; 
    $quantite = $_GET['quantite']; 
    $description = $_GET['desc']; 

    // Construction du chemin d'accès à l'image
    $imagePath = "Images/" . $image; 
    ?>

    <div class="container text-center">
        <h1><?= $titre ?></h1><br> 
        <div class="row mt-4">
            <div class="col-md-6">
                 <!-- Affiche l'image de l'article -->
                <img src="<?= $imagePath ?>" alt="<?= $titre ?>" class="img-fluid"><br>
            </div>
            <div class="col-md-6 text-start">
                <!-- Affiche les informations -->
                <br><p><strong>Prix : </strong> <?= $prix ?> €</p> 
                <p><strong>Quantité disponible :</strong> <?= $quantite ?></p> 
                <p><strong>Description :</strong> <?= $description ?></p><br> 
                <div class="d-flex justify-content-start gap-2">
                    <!-- Ajout au panier -->
                    <form method="post" action="ajoutPanier.php" class="me-2">
                        <input type="hidden" name="id_article" value="<?= $id ?>"> 
                        <input type="hidden" name="qt_article" value="<?= $quantite ?>"> 
                        <button type="submit" class="btn btn-primary">Ajouter au panier</button> 
                    </form>
                    <!-- Lien pour retourner à la page précédente -->
                    <a href="index.php" class="btn btn-secondary">Retour</a> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>
