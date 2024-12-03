<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='node_modules/bootstrap/dist/css/bootstrap.css'>
    <link rel="stylesheet" href="styles.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <title>Crochet'Time</title>
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

    <main>
        <h1>Les doudous en crochet</h1>
        <?php
        // Informations de connexion à la base de données
        $bdd = "zdavaud_bd";
        $host = "lakartxela.iutbayonne.univ-pau.fr";
        $user = "zdavaud_bd";
        $pass = "zdavaud_bd";

        // Connexion à la base de données
        $link = mysqli_connect($host, $user, $pass, $bdd) or die("Impossible de se connecter à la base de données");
        mysqli_set_charset($link, "utf8mb4");
        // Requête pour récupérer les articles
        $query = "SELECT * FROM CROCHET";
        $result = mysqli_query($link, $query);

        // Vérification de la connexion
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }

        mysqli_close($link); // Fermeture de la connexion
        ?>

        <div class="row row-cols-5">
            <?php
            // Boucle pour afficher chaque article
            foreach ($result as $item) {
                if ($item['quantite'] > 0) { // Vérifie si la quantité est disponible
            ?>
                    <a href="article.php?image=<?= $item['urlimage'] ?>&id=<?= $item['id'] ?>&titre=<?= $item['titre'] ?>&prix=<?= $item['prix'] ?>&quantite=<?= $item['quantite'] ?>&desc=<?= $item['description'] ?>" class="col mb-3">
                        <div class="card" style="width: 13rem;">
                            <img src="imagesPetites.php?image=<?= $item['urlimage'] ?>" class="card-img-top" alt="">
                            <div class="card-body bg-primary">
                                <h5><?= $item['titre'] ?> <br> <?= $item['prix'] ?> € </h5>
                                <p> Qte : <?= $item['quantite'] ?> </p>
                                <!-- Formulaire pour ajouter au panier -->
                                <form method="post" action="ajoutPanier.php">
                                    <input type="hidden" name="id_article" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="qt_article" value="<?= $item['quantite'] ?>">
                                    <button type="submit" class="btn btn-secondary">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </a>
            <?php }
            } ?>
        </div>
    </main>
    <div id="notifications"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="Notify.js"></script>
    <script>
        $(document).ready(function() {
            var notification = <?php echo json_encode($_SESSION['notification'] ?? null); ?>; // Récupération de la notification
            if (notification) {
                Notify(notification, null, null, 'success'); // Affiche la notification
                <?php unset($_SESSION['notification']); ?> // Supprime la notification de la session après l'affichage
            }
        });
    </script>
</body>

</html>