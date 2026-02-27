<?php session_start();?>
<!DOCTYPE html>
<html style="background-color:#896ABD;">
 
 <head>
<?php include("connexion.inc.php")?>
 
<!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Profil</title>
<link rel = "stylesheet" href = "Accueil.css"/>
<a href = "Accueil.html"> <p align="center"><img src ="logo1.png"> </p></a>
 
  <!-- Balise meta  -->
  <meta name="title" content="Titre de la page" />
  <meta name="description" content="description de la page"/>
  <meta name="keywords" content="mots-clé1, mots-clé2, ..."/>
 
 
 </head>
 
 
 <body>
 
  <!-- CORPS DE LA PAGE  -->
  <div class="box2">Bienvenue sur votre profil<br> </a></div>
  <?php
  if (isset($_SESSION['login'])){
    $client_mail = $_SESSION['login'];

    $req_id_cli_sql = "SELECT id_cli FROM client WHERE mail = :mail";
    $req_id_cli =$cnx->prepare($req_id_cli_sql);
    $req_id_cli->execute(array(':mail' =>$client_mail));
    $array_id = $req_id_cli->fetchALL();
    
    foreach($array_id as $id){
      $id_cli = $id['id_cli'];
      break;
    }
    $req_lst_commande_sql="SELECT num_commande,id_rest FROM commande WHERE etat = 'Livrer' AND id_cli =:id_cli" ;
    $req_lst_commande = $cnx->prepare($req_lst_commande_sql);
    $req_lst_commande->execute(array(':id_cli'=>$id_cli));
    $commandes = $req_lst_commande->fetchALL();

    $req_contenu_commande_sql ="SELECT * FROM contenir WHERE num_commande=:num_commande";
    $req_contenu_commande = $cnx->prepare($req_contenu_commande_sql);
    
    $req_nom_plat_sql = "SELECT nom_plat FROM plat WHERE id_plat = :id_plat";
    $req_nom_plat = $cnx->prepare($req_nom_plat_sql);
    
    $req_commande_non_livree_update = "UPDATE commande SET etat= 'annulee' WHERE etat != 'Livrer' AND num_commande = :num_commande AND id_cli =:id_cli";
    $req_commande_non_livree = $cnx->prepare($req_commande_non_livree_update);
    
    $req_num_commande_non_livree_sql ="SELECT num_commande FROM commande WHERE etat != 'Livrer' AND id_cli =:id_cli" ;
    $req_num_commande_non_livree = $cnx->prepare($req_num_commande_non_livree_sql);
    $req_num_commande_non_livree->execute(array(':id_cli'=>$id_cli));
    
    $num_commandes_non_livree = $req_num_commande_non_livree->fetchALL();
   

    $req_insert_note = $cnx->prepare("INSERT INTO Commenter VALUES (:id_cli,:id_rest,:note,:commentaire,:id_plat)");

    $req_point_fidel_client_sql = "SELECT point_fidel FROM client WHERE id_cli = :id_cli";
    $req_point_fidel_client = $cnx->prepare($req_point_fidel_client_sql);
    $req_point_fidel_client->execute(array(':id_cli'=>$id_cli));
    $points_fidel_array = $req_point_fidel_client->fetchALL(); 

    $req_mail_parrainage =  $cnx->query("SELECT mail FROM client");
    $array_mails = $req_mail_parrainage->fetchALL();


    $req_update_parrainage_sql ="UPDATE client SET parrain_id = :id_cli WHERE mail =:mail";
    $req_update_parrainage = $cnx->prepare($req_update_parrainage_sql);

    $req_update_etat_commandes =$cnx->query("UPDATE commande SET etat ='Livrer' WHERE etat !='Livrer'");
    $req_update_etat_commandes->execute();

    $req_update_pt_fidel_sql ="UPDATE Client SET point_fidel =:pt_fidel WHERE mail = :mail";
    $req_update_pt_fidel = $cnx->prepare($req_update_pt_fidel_sql);

    foreach($points_fidel_array as $pt_fidel){
        echo "<p>Vos points de fidélités Enjoy: ".$pt_fidel['point_fidel']."</p></br>";
        $pt_fidell = $pt_fidel['point_fidel'];
    }
    echo "<form method = 'post' action = 'page_profil_personnel.php'>
          <input type ='text' name = 'mail_client_cible' placeholder = 'Mail du client' class ='text_bar'/></br>
          <input type = 'submit' name ='parrainer' value = 'Parrainer ce client ?' class ='button'/></br>
          </form></br>";
    if (isset($_POST['parrainer'])){
        foreach($array_mails as $mails){
            if ($_POST['mail_client_cible'] == $mails['mail']){
                $mail_client_cible = $mails['mail'];
                $client_exist =0;
                break;
            }
            else {
                $client_exist =-1;
           
            }
        }
        if($client_exist == 0){
            $req_update_parrainage->execute(array(':id_cli'=>$id_cli,':mail'=>$mail_client_cible));
            $pt_fidell =$pt_fidel +50;
            $req_update_pt_fidel->execute(array(':point_fidel'=>$pt_fidell,':mail'=>$client_mail));
            echo "<p > Client parrainé !</p>";
        }
        else {
            echo "<p >L'adresse fournie ne correspond à aucun client</p>";
        }
    }
    
    echo "<p> Vos commandes en cours : </p></br>";
    foreach($num_commandes_non_livree as $non_livree){
        $req_contenu_commande->execute(array(':num_commande'=>$non_livree['num_commande']));
        $contenus = $req_contenu_commande->fetchALL();

  
        foreach($contenus as $contenu){
            $req_nom_plat->execute(array(':id_plat'=>$contenu['id_plat']));
            $plats = $req_nom_plat->fetchALL();
            foreach($plats as $plat){
                echo "<p> || Numéro de commande :".$non_livree['num_commande']." || Nom plat :".$plat['nom_plat']." || Quantité :".$contenu['nb_plat']."</p></br>";
                echo "<form method = 'post' action = 'page_profil_personnel.php'>
                      <input type = 'submit' name ='annuler' value = 'Annuler cette commande ?' class ='button'/></br>
                      </form></br>";
                if (isset($_POST['annuler'])){
                    $req_commande_non_livree->execute(array(':num_commande'=>$non_livree['num_commande'],':id_cli'=>$id_cli));
                    echo "<p>Commande annulée ! </p></br> ";

                }

            }
        }
        
    }

    echo "</br><p> Vos commandes : </p></br>";
    foreach($commandes as $commande){
        $num_commande = $commande['num_commande'];
     
        $req_contenu_commande->execute(array(':num_commande'=>$num_commande));
        $contenir = $req_contenu_commande->fetchALL();

        foreach($contenir as $contient){
            $req_nom_plat->execute(array(':id_plat'=>$contient['id_plat']));
            $plats = $req_nom_plat->fetchALL();
            foreach($plats as $plat){
                echo "<p> || Numéro de commande :".$num_commande." || Nom plat :".$plat['nom_plat']." || Quantité :".$contient['nb_plat']."</p></br>";
                echo "<form method = 'post' action = 'page_profil_personnel.php'>
                          <input type = 'number' name ='note' min ='0' max = '10' placeholder = 'Votre note' class ='input_note'/></br>
                          <input type ='text' name = 'commentaire' placeholder = 'Votre commentaire' class ='text_bar'/></br>
                          <input type = 'submit' name ='envoi_note' value = 'Noter' class ='button'/></br>
                          </form></br>";
                if (isset($_POST['envoi_note'])){
                    $req_insert_note->bindParam(':id_cli',$id_cli);
                    $req_insert_note->bindParam(':id_rest',$commande['id_rest']);
                    $req_insert_note->bindParam(':note',$_POST['note']);
                    if (isset($_POST['commentaire'])){
                        $req_insert_note->bindParam(':commentaire',$_POST['commentaire']);
                    }
                    else {
                        $req_insert_note->bindParam(':commentaire',"Le client n'as pas commente cette commande");   
                    }
                    $req_insert_note->bindParam(':id_plat',$contient['id_plat']);
                    $req_insert_note->execute();
                    echo "<p>Nous avons bien reçu vôtre avis !</p>";

                        

                }
                    

                    
                
            }
        }

    }


  }






 ?>
 
 </body>
</html>
