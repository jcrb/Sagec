<?php
/**
  *	liste_invites.php
  *
  *	dresse la liste des personnes ayant une autorisation d'invité
  */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");

$requete = "SELECT nom, prenom, org_nom
				FROM utilisateurs_droits, utilisateurs, organisme
				WHERE id_droits = '14'
				AND utilisateurs_droits.id_utilisateur = utilisateurs.id_utilisateur
				AND utilisateurs.org_ID = organisme.org_ID
				ORDER BY org_nom,nom, prenom
				";
$resultat = ExecRequete($requete,$connexion);
?>
<P>Liste des invités</p>
<br>
<table>
	<?php while($rep=mysql_fetch_array($resultat)){?>
	<tr>
		<td><?php echo $rep[org_nom];?></td>
		<td><?php echo $rep[nom];?></td>
		<td><?php echo $rep[prenom];?></td>
	</tr>
	<?php } ?>
</table>