<?php session_start();?>
<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head>
  <?php include("connexion.inc.php")?>  
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Connexion Livreur</title>
<link rel = "stylesheet" href = "Accueil.css"/>
<a href = "accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>
 
 
 
 </head>
 
 
 <body>
 
  <!-- CORPS DE LA PAGE  -->
  <div class="box1"> Livreur ? Connectez vous <br></div>
  <form method = "post" action = "connexion_livreur.php">
    <input type ="text" name="matricule" placeholder ="Votre matricule" class ="text_bar"/><br>
    <input type ="password" name="mot_de_passe" placeholder ="Votre mot de passe" class ="text_bar"/><br>
    <input type = "submit" name= "envoi" value="Se connecter" class ="button"/><br>
    </form>
  <?php
    function verif_connection($cnx){
     if (isset($_POST['matricule']) && isset($_POST['mot_de_passe'])){
       $matricule= $_POST['matricule'];
       $mdp = $_POST['mot_de_passe'];
       $_SESSION['matricule'] = $_POST['matricule'];
       $req_select = $cnx->query("SELECT matricule,mot_de_passe FROM livreur");
       $rows = $req_select->fetchALL();
       foreach($rows as $cle => $val){
         if ($matricule == $val['matricule'] && $mdp == $val['mot_de_passe']){
           echo "<div class=\"box2\">Connecté !<br> </a></div>";
           $connexion = 0;
           break;
         }
         else {
           
           $connexion = -1;
         }
       
       }
       if ($connexion == -1){
         echo "<div class=\"box2\">Matricule ou mot de passe incorrect...<br> </a></div>";
       }
       if($connexion == 0){
         echo "<a href =\"page_profil_professionnel.php\" class=\"boutonInscription\">Votre profil</a></br>";
       }
       
   
     }
   }
   verif_connection($cnx);

  ?>


 
 </body>

</html>
