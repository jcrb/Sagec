<?php
/**
* 	apa_valide.php
*	vérifie si la lecture du dossier par l'utilisateur est autorisée
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
$no_identification = Security::esc2Db(strtoupper($_REQUEST['no_victime']));
$requete = "SELECT victime_ID,org_createur_ID FROM victime WHERE no_ordre = '$no_identification'";
$resultat = ExecRequete($requete,$connexion);
$rep = mysql_fetch_array($resultat);

if(!$rep['victime_ID'] || $rep['org_createur_ID'] == $_SESSION['organisation'])
	header("Location:apa_fiche_victime.php?no_victime=$no_identification&victimeID=$rep[victime_ID]");
else
{
	print("CET IDENTIFIANT EST DEJA UTILISE\n PAR UN AUTRE UTILISATEUR... ");
	?>
		<a href="apa_nouvelle_victime.php"> Recommencez </a>
	<?php
}
?>