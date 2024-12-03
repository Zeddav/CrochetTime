<?php
// On démarre la session 
session_start();
// Vérifier si les variables de session sont définies
if (isset($_SESSION['login']) && isset($_SESSION['pwd'])) 
{
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='node_modules/bootstrap/dist/css/bootstrap.css'>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <title>Ajout article au site</title>
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
        // Formulaire d'ajout d'enregistrement
        print "<form action='upload.php' method='POST' enctype='multipart/form-data'>";
        print "Titre <br><input type='text' name='Titre' size='20' maxlength='50'><br>";
        print "Prix<br><input type='text' name='Prix' size='20' maxlength='50'><br>";
        print "Quantité<br><input type='INT' name='Quantite' size='20' maxlength='50'><br>"; 
        print "Description<br><input type='text' name='Description' size='20' maxlength='500'><br>";
        print "Image<br><input type='file' name='image'><br><br>"; 
        
        print "<br><input type='submit' class='btn btn-primary' value='OK'></form>"; // Bouton de soumission

        // Lien pour déconnexion
        print '<br><a href="./logout.php">Déconnexion</a>';
    }
    else 
    {
        // Redirection vers la page d'identification si l'utilisateur n'est pas connecté
        header("Location: identification.html");
    }

?>
