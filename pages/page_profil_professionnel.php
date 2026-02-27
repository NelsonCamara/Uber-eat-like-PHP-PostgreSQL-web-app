<?php session_start();?>
<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head>
<?php include("connexion.inc.php")?>
 
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>Profil Livreur</title>
<link rel = "stylesheet" href = "Accueil.css"/>
<a href = "accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>
 </head>
 
 
 <body>
 <?php
 $matricule =$_SESSION['matricule'];
 
 $ancien_statut =0;
 $req_commande_livrable_sql ="SELECT num_commande FROM commande,client,livreur WHERE matricule =:matricule AND client.ville = livreur.ville AND commande.etat ='En attente'";
 $req_commande_livrable = $cnx->prepare($req_commande_livrable_sql);
 $req_commande_livrable ->execute(array(':matricule'=>$matricule));
 $req_contenu_commande_sql ="SELECT * FROM contenir WHERE num_commande=:num_commande";
 $req_contenu_commande = $cnx->prepare($req_contenu_commande_sql);
 $array_commandes = $req_commande_livrable->fetchALL();
     
 $req_nom_plat_sql = "SELECT nom_plat FROM plat WHERE id_plat = :id_plat";
 $req_nom_plat = $cnx->prepare($req_nom_plat_sql);
 

 $req_livre_commande_sql = "UPDATE commande SET etat= 'En livraison' WHERE etat = 'En attente' AND num_commande = :num_commande ";
 $req_livre_commande = $cnx->prepare($req_livre_commande_sql);


 $req_etat_livreur_sql = "SELECT etat FROM livreur WHERE matricule =:matricule";
 $req_etat_livreur = $cnx->prepare($req_etat_livreur_sql);
 $req_etat_livreur->execute(array(':matricule'=>$matricule));
 $etat_livreurs = $req_etat_livreur->fetchALL();

 $req_update_ville_sql = "UPDATE livreur SET ville =:ville WHERE matricule =:matricule";
 $req_update_ville = $cnx->prepare($req_update_ville_sql);

 $req_update_statut_sql = "UPDATE livreur SET etat =:etat WHERE matricule =:matricule";
 $req_update_statut = $cnx->prepare($req_update_statut_sql);


 foreach($etat_livreurs as $etats){
     $statut = $etats['etat'];
 }



 echo "<form method = 'post' action = 'page_profil_professionnel.php'>
      <div class=\"select-style2\">
       <select name = 'statuts'>
       <option value = 'En Ligne'>En Ligne</option>
       <option value = 'Hors Ligne'>Hors Ligne</option>
       <option value = 'En Attente de Commande'>Attente de Commande</option>
       <option value = 'En livraison'>En livraison</option>
       </select></div>
       <input type = 'submit' name ='statut' value = 'Changer mon statut ?' class ='button'/></br>
       </form></br>";
 if (isset($_POST['statut'])){
    $ancien_statut =-1;
    $new_statut = $_POST['statuts'];
    $req_update_statut->execute(array(':etat'=>$new_statut,':matricule'=>$matricule));
    echo "<p> Votre statut :".$new_statut."</p></br>";
    }
 
 if ($ancien_statut == 0){
    echo "<p> Votre statut :".$statut."</p></br>";
 }
 

 




 foreach($array_commandes as $commande){
     $num_commande = $commande['num_commande'];
     $req_contenu_commande->execute(array(':num_commande'=>$non_livree['num_commande']));
     $contenus = $req_contenu_commande->fetchALL();
     foreach($contenir as $contient){
        $req_nom_plat->execute(array(':id_plat'=>$contient['id_plat']));
        $plats = $req_nom_plat->fetchALL();
        foreach($plats as $plat){
            echo "<div class=\"box2\"><p> </br>
             Numéro de commande :".$num_commande." </br>
             Nom plat :".$plat['nom_plat']." </br>
             Quantité :".$contenu['nb_plat']."</p></br></a></div>";
            echo "<form method = 'post' action = 'page_profil_professionnel.php'>
                      <input type = 'submit' name ='livrer' value = 'Livrer cette commande ?' class ='button'/></br>
                      </form></br>";
            if (isset($_POST['livrer'])){
                $req_livre_commande->execute(array(':num_commande'=>$num_commande));

            }
            
        }    
    } 
     

     

 }

echo "<form method = 'post' action = 'page_profil_professionnel.php'> 
<input type = 'text'  name ='ville' placeholder ='Ville' class ='text_bar'/></br>
<input type = 'submit'  name ='couvrir' value = 'Couvrir cette ville ?' class ='button'/></br>
</form></br>";
if (isset($_POST['couvrir'])){
    if (isset($_POST['ville'])){
        $ville =$_POST['ville'];
        $req_update_ville->execute(array(':ville'=>$ville,':matricule'=>$matricule));
        echo "<p> Ville changée! Vous couvrez maintenant ".$ville."</p>";
        }
    }

 



?>
  
 
 </body>

</html>
