<?php session_start();?>
<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head>
     <?php include("connexion.inc.php")?>   
    
 
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Connexion</title>
<link rel = "stylesheet" href = "Accueil.css"/>
<a href = "accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
 
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>
 
  <!-- Indexer et suivre 
  <meta name="robots" content="index,follow" /> -->
 

 
 
 </head>
 
 
 <body>
 
  <!-- CORPS DE LA PAGE  -->
  <div class="box1"> Bonjour veuillez vous connecter <br></div>
    <form method = "post" action = "connexion_utilisateur.php">
    <input type ="text" name="mail" placeholder ="Votre adresse mail" class ="text_bar"/><br>
    <input type ="password" name="mot_de_passe" placeholder ="Votre mot de passe" class ="text_bar"/><br>
    <input type = "submit" name= "envoi" value="Se connecter" class ="button"/><br>
    </form>

  <?php 



  function verif_connection($cnx){
    if (isset($_POST['mail']) && isset($_POST['mot_de_passe'])){
      $mail= $_POST['mail'];
      $mdp = $_POST['mot_de_passe'];
      $req_select = $cnx->query("SELECT mail,mot_de_passe FROM client");
      $rows = $req_select->fetchALL();
      foreach($rows as $cle => $val){
        if ($mail == $val['mail'] && $mdp == $val['mot_de_passe']){
          echo "<div class=\"box2\">Connecté !<br> </a></div>";
          $connexion = 0;
          $_SESSION['login'] = $mail;
          $_SESSION['mdp'] = $mdp;
          break;
        }
        else {
          
          $connexion = -1;
        }
      
      }
      if ($connexion == -1){
        echo "<div class=\"box2\"> Adresse mail ou mot de passe incorrect... <br> </a></div>";
      }
      if ($connexion == 0){
        echo "<p > Bonjour cher client si vous souhaitez rechercher un restaurant cliquez ci-dessous :</p>";
        echo "<a href =\"recherche_restos.php\" class=\"boutonInscription\">Nos restaurants partenaires</a></br>";
        echo "<p > Si vous voulez consulter votre profil cliquez ci-dessous</p></br>";
        echo "<a href =\"page_profil_personnel.php\" class=\"boutonSeConnecter\">Votre profil</a></br>";
        echo "<a href =\"deconnexion.php\" class=\"boutonSeConnecter\">DECONNEXION</a></br>";




      }
        
     
      
  
    }
  }
  verif_connection($cnx);
 
  
 ?>
 
 </body>

</html>