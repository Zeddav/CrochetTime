<?php
    // On définit un login et un mot de passe de base
    $login_valide = "root";
    $pwd_valide = "root";

    // on teste si nos variables sont définies
    if (isset($_POST['login']) && isset($_POST['pwd'])) {
    // on vérifie les informations saisies
    if ($login_valide == $_POST['login'] && $pwd_valide == $_POST['pwd']) {
    session_start ();
    // on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) 
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['pwd'] = $_POST['pwd'];
    // on redirige notre visiteur vers une page de notre section membre
    header ('location: admin.php');
    }
    else {
    echo '<body onLoad="alert(\'Membre non reconnu...\')">';
    // puis on le redirige vers la page d'identification
    echo '<meta http-equiv="refresh" content="0;URL=identification.html">';
    }
    } else {
    echo 'Les variables du formulaire ne sont pas déclarées.';
    }
 ?>