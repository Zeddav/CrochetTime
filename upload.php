<?php

// Vérifie si tous les champs requis sont présents dans la requête POST
if (isset($_POST['Titre'], $_POST['Prix'], $_POST['Quantite'], $_FILES['image'], $_POST['Description'])) {
    $uploadDir = 'Images/'; 
    $fileKey = 'image'; 

    // Vérifie s'il n'y a pas d'erreur lors du téléchargement du fichier
    if ($_FILES[$fileKey]['error'] == 0) {
        $filename = basename($_FILES[$fileKey]['name']); 
        $uploadFile = $uploadDir . $filename; 

        // Déplace le fichier téléchargé vers le répertoire de destination
        move_uploaded_file($_FILES[$fileKey]['tmp_name'], $uploadFile);

        // Récupération des données du formulaire
        $titre = $_POST['Titre'];
        $prix = (int)$_POST['Prix']; 
        $quantite = (int)$_POST['Quantite']; 
        $desc = $_POST['Description']; 

        // Connexion à la base de données
        $bdd = "zdavaud_bd";
        $host = "lakartxela.iutbayonne.univ-pau.fr";
        $user = "zdavaud_bd";
        $pass = "zdavaud_bd";
        $link = new mysqli($host, $user, $pass, $bdd);

        // Vérifie si la connexion a échoué
        if ($link->connect_error) {
            die("Échec de la connexion : " . $link->connect_error);
        }
        mysqli_set_charset($link,"utf8mb4");
        // Recherche du prochain identifiant
        $query = "SELECT max(id)+1 as newId FROM CROCHET";
        $result = mysqli_query($link, $query);
        $newId = $result->fetch_assoc()['newId']; 

        // Insertion du nouvel article dans la base de données
        $stmt = $link->prepare("INSERT INTO CROCHET (id, titre, prix, quantite, urlimage, description) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Erreur lors de la préparation de la requête : " . $link->error);
        }

        // Liaison des paramètres et exécution de la requête
        $stmt->bind_param("isiiss", $newId, $titre, $prix, $quantite, $filename, $desc);
        $stmt->execute();

        // Ferme la requête
        $stmt->close();

        // Redirection vers la page admin après l'insertion
        header("Location: admin.php");
        exit(); 

        mysqli_close($link); // Ferme la connexion à la base de données
    } else {
        print "<p>Aucun fichier de téléchargé ou une erreur est survenue.</p>"; // Message d'erreur si le téléchargement échoue
    }
}
