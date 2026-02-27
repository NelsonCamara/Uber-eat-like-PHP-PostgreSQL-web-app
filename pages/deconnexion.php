<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head>
  <?php include("connexion.inc.php")?>  
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Connexion Livreur</title>
<link rel = "stylesheet" href = "Accueil.css"/>
<a href="accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>
 
 
 
 </head>

<?php
	session_start ();
	//On détruit les variables de la session
	session_unset ();
	//on détruit notre session
	session_destroy ();
?>

<body>
	<div class="box2"><p>Vous êtes deconnecté </p></a></div>


</html>