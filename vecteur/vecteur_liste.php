<?php
  
	$requete = "SELECT * FROM vecteur WHERE org_ID = '$_SESSION[organisation]'";
	$resultat = ExecRequete($requete,$connexion);

 ?>
 			<table>
			<?php while($rub=mysql_fetch_array($resultat)){?>
				<tr>
					<td><?php echo$rub['Vec_Nom']; ?></td>
					<td><a href="vecteur_ajout_wraper.php?ttvecteur=<?php echo $rub['Vec_ID'];?>">modifier</a></td>
					<td><a href="">supprimer</a></td>
				</tr>
			<?php } ?>
			</table>
