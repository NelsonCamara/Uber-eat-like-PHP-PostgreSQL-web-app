<?php

/*
 * création d'objet PDO de la connexion qui sera représenté par la variable $cnx
 */
$user = "postgres";
$pass = "nelson2014";
try {
    $cnx = new PDO ('pgsql:host=localhost;dbname=Projet',$user,$pass) ;
}
catch (PDOException $e) {
    echo "ERREUR : La connexion a échouée";
    echo "Error: " . $e;

}
?>