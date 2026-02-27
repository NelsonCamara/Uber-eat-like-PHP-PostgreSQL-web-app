<?php session_start();?>
<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head>
<?php include("connexion.inc.php")?>
 
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Rechercher Restaurant</title>
<link rel = "stylesheet" href = "Accueil.css"/>
<a href = "Accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
 
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>

 
 
 </head>
 
 
 <body>
 
  <!-- CORPS DE LA PAGE  -->
  <div class="box2">Bienvenue sur la page de recherche de nos restos !<br> </a></div>
  <form method = "post" action = "recherche_restos.php">
    <input type ="text" name="recherche" placeholder ="Votre recherche" class ="text_bar"/><br>

    <div class="select-style">
    <select name="type_recherche">
    <option value="">Choisissez votre type de recherche:</option>
    <option value="nom">Par Nom du restaurant(fonctionne avec mot clefs)</option>
    <option value="note">Par Notes</option>
    <option value="nb_avis">Par nombre d'avis</option>
    <option value="tous">Afficher tout les restos</option>
   
    </select></div><br>
    <input type = "submit" name= "envoi_recherche" value="Rechercher" class ="button"/><br>
    </form>

  <?php
  if(isset($_POST['envoi_recherche'])){
       $client_mail = $_SESSION['login'];
     
       $req_client_in_ville_sql = " SELECT page_web FROM restaurant,client WHERE mail = :mail AND client.ville = restaurant.ville";
       $req_client_in_ville = $cnx->prepare($req_client_in_ville_sql);
       $req_client_in_ville ->execute(array(':mail'=>$client_mail));
       $client_livrable_par = $req_client_in_ville->fetchALL();
       $req_opened_restos = $cnx->query("SELECT nom_rest,page_web FROM  restaurant WHERE CURRENT_TIME(0) BETWEEN horaire_ouverture AND horaire_fermeture AND id_rest NOT IN (SELECT id_rest FROM fermeture_exceptionnelle WHERE CURRENT_DATE IN (SELECT date_fermeture FROM fermeture_exceptionnelle))");
       $opened_restos = $req_opened_restos->fetchALL();
      
       if ($_POST['type_recherche'] == "nom" && isset($_POST['recherche'])){
          
          $req_by_nom_sql = "SELECT page_web,nom_rest FROM restaurant WHERE nom_rest LIKE :nom";
          $req_by_nom = $cnx->prepare($req_by_nom_sql);
          $req_by_nom->execute(array(':nom'=>'%'.$_POST['recherche'].'%'));
          $rows = $req_by_nom->fetchALL();
          foreach($rows as $cle){
            foreach($opened_restos as $restos){
              foreach($client_livrable_par as $able_to_devliver){
                if(in_array($cle['page_web'],$restos)){
                  if(in_array($cle['page_web'],$able_to_devliver)){
                    echo "<a href = '".$cle['page_web']."' class=\"boutonInscription\">".$cle['nom_rest']."</a></br>";

                  }
                  
                }

              }
              
            }
          
            
          }
       }
       if ($_POST['type_recherche'] == "note"){
          $req_note = $cnx->query('SELECT DISTINCT page_web,nom_rest FROM ( SELECT DISTINCT  page_web,nom_rest,note FROM commenter,restaurant WHERE commenter.id_rest = restaurant.id_rest ORDER BY note DESC) AS web');
          $rows = $req_note->fetchALL();
          foreach($rows as $cle){
            foreach($opened_restos as $restos){
              foreach($client_livrable_par as $able_to_devliver){
                if(in_array($cle['page_web'],$restos)){
                  if(in_array($cle['page_web'],$able_to_devliver)){
                    echo "<a href = '".$cle['page_web']."' class=\"boutonInscription\">".$cle['nom_rest']."</a></br>";

                  }
                  
                }

              }
              
            }
          
            
          }

       }
       if ($_POST['type_recherche'] == "nb_avis"){
 
          $req_nb_avis = $cnx->query("SELECT DISTINCT page_web,nom_rest FROM(SELECT  page_web ,nom_rest,count(note) AS nb_note FROM restaurant NATURAL JOIN commenter GROUP BY page_web,nom_rest,note ORDER BY note) AS WEB");
          $rows = $req_nb_avis ->fetchALL();
          foreach($rows as $cle){
            foreach($opened_restos as $restos){
              foreach($client_livrable_par as $able_to_devliver){
                if(in_array($cle['page_web'],$restos)){
                  if(in_array($cle['page_web'],$able_to_devliver)){
                    echo "<a href = '".$cle['page_web']."' class=\"boutonInscription\">".$cle['nom_rest']."</a></br>";

                  }
                  
                }

              }
              
            }
          
            
          }
       }
       if ($_POST['type_recherche'] == "tous"){
          $req_all_restos = $cnx->query("SELECT page_web,nom_rest FROM restaurant");
          $rows = $req_all_restos->fetchALL();
         
          foreach($rows as $cle){
            foreach($opened_restos as $restos){
              foreach($client_livrable_par as $able_to_devliver){
                if(in_array($cle['page_web'],$restos)){
                  if(in_array($cle['page_web'],$able_to_devliver)){
                    echo "<a href = '".$cle['page_web']."' class=\"boutonInscription\">".$cle['nom_rest']."</a></br>";

                  }
                  
                }

              }
              
            }
          
            
          }

       }
       
       
  }



 ?>
 
 </body>

</html>
