<?php
/**
  *	gestes.php
  *
  *	©jcb 2010
  */
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
$dossier = $_RESQUEST['dossier'];

$requete = "SELECT traitement FROM victime WHERE victime_ID = '$dossier'";
$resultat = ExecRequete($requete,$connexion);
echo($requete.'<br>');
print($dossier);

?>
<h3> Gestes réalisés </h3
<table>
	<?php while($rep=mysql_fetch_array($resultat)){ ?>
	<tr>
		<td>
			<?php echo $rep[traitement]; ?>
		</td>
	</tr>
	<?php } ?>
</table>