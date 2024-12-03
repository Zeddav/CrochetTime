<?php
    //Recupérer le nom d'image
    $im =  $_GET['image'];
    //Refaire le chemin
    $image="Images/".$im;
    //L'afficher
    print "<img src= $image  class='card-img-top'>";
?>