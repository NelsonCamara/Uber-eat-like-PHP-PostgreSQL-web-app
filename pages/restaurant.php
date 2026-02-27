<?php 
	//session_start();
	include("connexion.inc.php");
	/*if (isset($_SESSION['login']) && isset($_SESSION['pwd'])){*/
		
		echo "<html>";
		echo "<head>
		      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
		      <title>Restaurant</title>
		      </head>";
		echo "<body>
				<p id = \"Perso\"><a href = \"deconnexion.php\"> DECONNEXION</a></p>";

		

		echo "<TABLE BORDER = \"1\">
			  <tr>
			  	<CAPTION><h2><u>Listes des restaurant dans votre ville</u></CAPTION>
			  	<th> Nom Restaurant";
			echo"<h3>";
			  	$resultat = $cnx->query("SELECT DISTINCT nom_rest, horaire_ouverture, horaire_fermeture, prix_livraison FROM restaurant,client WHERE restaurant.ville = client.ville;");
			  	while ($donnees = $resultat->fetch()){
					echo "";
					echo " $donnees[0] <br>";
				}
				$resultat->closeCursor();
			echo"</h3>";
			echo"</th>";


			echo"<th> <u>Ouvert à</u>";
			echo"<h3>";
			  	$resultat = $cnx->query(" SELECT DISTINCT nom_rest, horaire_ouverture, horaire_fermeture, prix_livraison FROM restaurant,client WHERE restaurant.ville = client.ville;");
			  	while ($donnees = $resultat->fetch()){
					echo "";
					echo " $donnees[1] <br>";
				}
				$resultat->closeCursor();
			echo"</h3>";
			echo"</th>";

			echo"<th> <u>Ferme à</u>";
			echo"<h3>";
			  	$resultat = $cnx->query(" SELECT DISTINCT nom_rest, horaire_ouverture, horaire_fermeture, prix_livraison FROM restaurant,client WHERE restaurant.ville = client.ville;");
			  	while ($donnees = $resultat->fetch()){
					echo "";
					echo " $donnees[2] <br>";
				}
				$resultat->closeCursor();
			echo"</h3>";
			echo"</th>";

			echo"<th> <u>Prix de livraison</u>";
			echo"<h3>";
			  	$resultat = $cnx->query("SELECT DISTINCT nom_rest, horaire_ouverture, horaire_fermeture, prix_livraison FROM restaurant,client WHERE restaurant.ville = client.ville;");
			  	while ($donnees = $resultat->fetch()){
					echo "";
					echo " $donnees[3] <br>";
				}
				$resultat->closeCursor();
			echo"</h3>";
			echo"</th>";

		echo"</tr>
	</TABLE>
	</body>
	</html>";
	/*}
	else{
		echo "Vous n'êtes pas connecté";
	}*/
?>