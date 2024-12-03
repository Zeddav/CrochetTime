<?php
session_start(); // Démarre ou reprend une session existante

// Vérifie si les paramètres id et action ont été passés
if (isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id']; 

    // Si l'action est 'plus', incrémente la quantité de l'article si elle est inférieure à la quantité disponible
    if ($_POST['action'] == 'plus' && $_SESSION['panier'][$id] < $_POST['qt']) {
        $_SESSION['panier'][$id]++;
    } 
    // Si l'action est 'moins', décrémente la quantité de l'article sans descendre en dessous de 1
    elseif ($_POST['action'] == 'moins' && $_SESSION['panier'][$id] > 1) {
        $_SESSION['panier'][$id]--;
    }
    header('Location: panier.php'); // Redirige vers la page du panier
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='node_modules/bootstrap/dist/css/bootstrap.css'> 
    <title>Panier</title>
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

    <h1>Articles choisis :</h1>

<?php
// Informations de connexion à la base de données
$bdd = "zdavaud_bd"; 
$host = "lakartxela.iutbayonne.univ-pau.fr";
$user = "zdavaud_bd"; 
$pass = "zdavaud_bd"; 
$link = new mysqli($host, $user, $pass, $bdd);
if ($link->connect_error) {
    die("Échec de la connexion : " . $link->connect_error); // Affiche une erreur si la connexion échoue
}
mysqli_set_charset($link,"utf8mb4");
// Vérifie si le panier n'est pas vide
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    $panier = implode(',', array_keys($_SESSION['panier']));
    
    // Requête pour récupérer les articles du panier
    $sql = "SELECT * FROM CROCHET WHERE id IN ($panier)";
    $result = $link->query($sql);
    ?>
    
    <table class='table'>
        <tr>
            <th>Titre </th>
            <th> Qte </th>
            <th> Prix (en €) </th>
            <th class=d-none> Suppr </th>
        </tr>
        
        <?php

        $total = 0;
        echo "<tbody>";
        // Affichage des articles dans le panier
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['titre'] . "</td>";
            echo "<td>
                <form action='panier.php' method='post' style='display:inline-block;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit' name='action' value='moins' class='btn btn-light'>-</button>
                </form>
                " . $_SESSION['panier'][$row['id']] . "
                <form action='panier.php' method='post' style='display:inline-block;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='qt' value='" . $row['quantite'] . "'>
                    <button type='submit' name='action' value='plus' class='btn btn-light'>+</button>
                </form>
                </td>";
            echo "<td>" . $row['prix'] . "</td>";
            echo "<td> 
                <form action='suppPanier.php' method='post'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='submit' class='btn btn-danger' name='suppr' value='X'>
                </form>
                </td>";
            echo "</tr>";
            // Calcul du total
            $total += $row['prix'] * $_SESSION['panier'][$row['id']];
        }
        echo "</tbody>";
        ?>
    </table>
    <br>

    <?php
    // Affiche le prix total
    echo "Prix total : " . $total . "€"; ?>
    
    <form method="post" action="paiement.php">
        <input type="hidden" name="prix" value="<?= $total ?>"><br>
        <button type="submit" class="btn btn-secondary">Payer</button>
    </form>
    <br><a href="./logout.php">Tout supprimer</a>
    <?php
    $link->close(); // Ferme la connexion à la base de données
} else {
    echo "Votre panier est vide."; // Message si le panier est vide
} ?>
</body>
</html>
