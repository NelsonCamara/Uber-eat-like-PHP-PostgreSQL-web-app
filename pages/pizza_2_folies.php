<?php session_start();?>
<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head>
<?php include("connexion.inc.php")?>
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>Pizza Hut</title>
<link rel = "stylesheet" href = "Accueil.css"/>
<a href = "accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
 
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>
 
 </head>
 
 
 <body>
 
  <!-- CORPS DE LA PAGE  -->
  <h2>Bienvenue chez Pizza 2 folies</h2></br>

  <?php
      $id_rest = 10;
      $req_plats_sql ="SELECT id_plat,nom_plat,prix,description_plat FROM plat WHERE id_rest =:id_rest";
      $req_plats = $cnx->prepare($req_plats_sql);
      $req_plats->execute(array(':id_rest'=>$id_rest));
      $array_plats = $req_plats->fetchALL();
      $insert_contenir =$cnx->prepare("INSERT INTO Contenir VALUES (:num_commande,:id_plat,:nb_plat);");
  
      $prix = 0;
      $req_commande = $cnx->query("SELECT num_commande FROM commande");
      $array_commande = $req_commande->fetchALL();
      $new_num_commande = count($array_commande)+1;
  
  
      $timestamp = date("Y-m-d H:i:s");
      $etat = "En preparation";
      $client_mail = $_SESSION['login'];
      $req_id_cli_sql = "SELECT id_cli,point_fidel FROM client WHERE mail = :mail";
      $req_id_cli =$cnx->prepare($req_id_cli_sql);
      $req_id_cli->execute(array(':mail' =>$client_mail));
      $array_id = $req_id_cli->fetchALL();
      foreach($array_id as $id){
        $id_cli = $id['id_cli'];
        $pt_fidel = $id['point_fidel'];
        break;
      }
      $req_matricule_sql = "SELECT matricule FROM livreur,client WHERE livreur.ville = client.ville AND id_cli = :id_cli AND etat = 'En Ligne'";
      $req_matricule = $cnx->prepare($req_matricule_sql);
      $req_matricule->execute(array(':id_cli' =>$id_cli));
      $array_livreurs = $req_matricule->fetchALL();

      $req_update_pt_fidel_sql ="UPDATE Client SET point_fidel =:pt_fidel WHERE mail = :mail";
      $req_update_pt_fidel = $cnx->prepare($req_update_pt_fidel_sql);
      
      if (count($array_livreurs)>0){
        foreach($array_livreurs as $livreurs){
          $matricule = $livreurs['matricule'];
          break;
        }

        foreach($array_plats as $plat){
          echo "<div class=\"box2\"><p>Nom :".$plat['nom_plat']." || Prix :".$plat['prix']." </br>
               Description :".$plat['description_plat']." </br></p></a></div>";
          echo "<form method = 'post' action = 'pizza_2_folies.php'>
                <input type = 'number' name ='quantite' min ='1' max = '10' placeholder = 'Quantité' class ='input_quantite'/></br>
                <input type = 'submit' name ='commander' value = 'Ajouter ce plat ?' class = 'button'/></br>
                </form></br>";
          if (isset($_POST['commander'])){
            $req_update_etat_livreur_sql = "UPDATE livreur SET etat = 'En livraison' WHERE matricule = :matricule";
            $req_update_etat_livreur = $cnx->prepare($req_update_etat_livreur_sql);
            $req_update_etat_livreur->execute(array(':matricule' => $matricule));
            $pt_fidel =$pt_fidel +50;
            $req_update_pt_fidel->execute(array(':point_fidel'=>$pt_fidel,':mail'=>$client_mail));
            
            $prep_insert_commande = $cnx->prepare("INSERT INTO Commande VALUES (:num_commande,:time_stamp,:etat,:matricule,:id_cli,:id_rest);");
            $prep_insert_commande->bindParam(':num_commande',$new_num_commande);
            $prep_insert_commande->bindParam(':time_stamp',$timestamp);
            $prep_insert_commande->bindParam(':etat',$etat);
            $prep_insert_commande->bindParam(':matricule',$matricule);
            $prep_insert_commande->bindParam(':id_cli',$id_cli);
            $prep_insert_commande->bindParam(':id_rest',$id_rest);
            $prep_insert_commande->execute();
    
            $prix= $prix+$_POST['quantite']*$plat['prix'];
            $insert_contenir->bindParam(':num_commande',$new_num_commande);
            $insert_contenir->bindParam(':id_plat',$plat['id_plat']);
            $insert_contenir->bindParam(':nb_plat',$_POST['quantite']);
            $insert_contenir->execute();
            echo"<div class=\"box2\"><h3>Prix :".$prix."</br>
            Commande bien enregistrée ! </h3></a></div>";
    
    
    
          }
        }

      }
      else{
        echo"<div class=\"box2\"><h3>Aucun Livreur dispo pour votre commande</br>
        </h3></a></div>";

      }
      
      









  ?>
  <h3> Informations utiles sur votre restaurant:</h3></br>
  <?php
       $req_info_restos = $cnx->query("SELECT adresse,ville,horaire_ouverture,horaire_fermeture,prix_livraison  FROM restaurant WHERE nom_rest = 'Pizza 2 folies'");
       $infos_array = $req_info_restos->fetchALL();
       foreach($infos_array as $info_resto){
        echo "<div class=\"box2\"><p> Adresse :".$info_resto['adresse']." </br>
              Ville :".$info_resto['ville']." </br>
              Horaires d'ouverture".$info_resto['horaire_ouverture']." </br>
              Horaires de fermeture".$info_resto['horaire_fermeture']." </br>
              Prix de la livraison : ".$info_resto['prix_livraison']."</p></br></div>";

       }
  ?>

  

 
 </body>
</html>