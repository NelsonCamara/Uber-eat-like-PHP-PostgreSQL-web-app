<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head >  
 <?php include("connexion.inc.php")?>  
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Inscription</title>
  <link rel = "stylesheet" href = "Accueil.css"/>
  <a href = "accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>
 
 
 
 </head>
 
 
 <body>
 

  <div class="box1"> Bonjour veuillez vous inscrire <br></div>
  
    


  <form method = "post" action = "inscription_utilisateur.php">
  <input type ="text" name="nom" placeholder ="Votre nom"/><br>
  <input type ="text" name="prenom" placeholder ="Votre prenom"/><br>
  <input type ="text" name="mail" placeholder ="Votre adresse mail"/><br>
  <input type ="text" name="telephone" placeholder ="Votre numero de telephone"/><br>
  <input type ="text" name="mot_de_passe" placeholder ="mot de passe"/><br>
  <input type ="text" name="num_cb" placeholder ="Votre num de cb"/><br>
  <input type ="text" name="adresse" placeholder ="Votre adresse "/><br>
  <input type ="text" name="ville" placeholder ="Votre ville "/><br>
  
  <input type = "submit" name= "envoi" href="connexion_utilisateur.php" value="S'inscrire"/><br>
  </form>
  <?php
  $requete_clients = $cnx->query("SELECT *FROM client");

  $array = $requete_clients->fetchALL();
  $new_client_id = count($array)+1;
  $new_client_fidel_points = 0;
  if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['telephone']) && isset($_POST['mot_de_passe']) && isset($_POST['num_cb']) && isset($_POST['adresse'])){
    $prep_requete_insert_client = $cnx->prepare("INSERT INTO Client VALUES (:id_cli,:nom,:prenom,:mail,:telephone,:mdp,:num_cb,:adresse,:ville,:nb_pt_fidel);");
    $prep_requete_insert_client->bindParam(':id_cli',$new_client_id);
    $prep_requete_insert_client->bindParam(':nom',$_POST['nom']);
    $prep_requete_insert_client->bindParam(':prenom',$_POST['prenom']);
    $prep_requete_insert_client->bindParam(':mail',$_POST['mail']);
    $prep_requete_insert_client->bindParam(':telephone',$_POST['telephone']);
    $prep_requete_insert_client->bindParam(':mdp',$_POST['mot_de_passe']);
    $prep_requete_insert_client->bindParam(':num_cb',$_POST['num_cb']);
    $prep_requete_insert_client->bindParam(':adresse',$_POST['adresse']);
    $prep_requete_insert_client->bindParam(':ville',$_POST['ville']);

    $prep_requete_insert_client->bindParam(':nb_pt_fidel',$new_client_fidel_points);
    $prep_requete_insert_client->execute();
    
    echo "<div class=\"box2\">Vous êtes inscrit !<br> </a></div>";

  }
  else{
      echo "<div class=\"box2\"> Vous devez remplir tout les champs pour vous inscrire ! <br> </a></div>";
  }
  


  
  
  ?>


  </body>
 <style type="text/css" media="screen">footer{padding-bottom:90%;}</style>
</footer>
</html>