<?php
session_start(); // Démarre une nouvelle session ou reprend une session existante

// Informations de connexion à la base de données
$bdd = "zdavaud_bd"; 
$host = "lakartxela.iutbayonne.univ-pau.fr";
$user = "zdavaud_bd"; 
$pass = "zdavaud_bd"; 

// Création de la connexion à la base de données
$link = new mysqli($host, $user, $pass, $bdd);
if ($link->connect_error) {
    die("Échec de la connexion : " . $link->connect_error);
}
mysqli_set_charset($link,"utf8mb4");
// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['carte']) && isset($_POST['date'])) {
    $inputDate = $_POST['date']; // Récupère la date saisie par l'utilisateur
    $inputDateTime = DateTime::createFromFormat('m/y', $inputDate); // Crée un objet DateTime à partir de la date saisie
    
    $dateAjd = new DateTime(); // Crée un objet DateTime pour la date actuelle
    $dateLimite = clone $dateAjd; // Clone l'objet date actuelle
    $dateLimite->modify('+3 months'); // Modifie la date limite pour 3 mois à partir d'aujourd'hui
    
    // Vérifie si la date saisie est valide et si la première et la dernière carte sont identiques
    if ($inputDateTime > $dateLimite && $_POST['carte'][0] == $_POST['carte'][-1]) {
        // Parcourt le panier de l'utilisateur
        foreach ($_SESSION['panier'] as $id => $qt) {
            $sql = "SELECT quantite FROM CROCHET WHERE id = $id"; // Requête pour récupérer la quantité de l'article
            $result = mysqli_query($link, $sql);
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }

            if ($result) {
                $reste = $result->fetch_assoc()['quantite']; 
                // Calculer la nouvelle quantité
                $qtMaJ = $reste - $qt; // Met à jour la quantité après l'achat

                // Mettre à jour la quantité dans la base de données
                $mAj = "UPDATE CROCHET SET quantite = $qtMaJ WHERE id = $id"; // Requête de mise à jour
                $updateStmt = $link->prepare($mAj);
                $updateStmt->execute(); // Exécute la requête
            }
        }

        mysqli_close($link); // Ferme la connexion à la base de données

        // Nettoie la session et redirige vers la page d'accueil avec un message de notification
        session_unset();
        $_SESSION['notification'] = "Paiement enregistré";
        header("Location: index.php");
        exit();
    } else {
        // Redirige vers le panier si les conditions ne sont pas remplies
        header("Location: panier.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='node_modules/bootstrap/dist/css/bootstrap.css'> 
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script> 
    <title>Paiement</title>
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
    // Affiche le prix si le formulaire a été soumis
    if (isset($_POST['prix'])) {
        $prix = $_POST['prix'];
        echo "<br><h3>Prix : " . $prix . "€</h3><br>";
    }
    ?>

    <form action="paiement.php" method="post">
        Numero de carte : <input type="text" class="form-control" name="carte" required minlength=16 maxlength=16 placeholder="Ex : 12345678925478931"> 
        <br />
        Date : <input type="text" class="form-control" name="date" id="date" pattern="(0[1-9]|1[0-2])/[0-9]{2}" placeholder="Ex : 01/26"><br />
        <input type="submit" name="payer" value="Payer">
    </form>
</body>
</html>
