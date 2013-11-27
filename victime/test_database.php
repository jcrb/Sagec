<?php
/**
*	test_database.php
*/
// indique que la réponse renvoyée sera de type text
header("Content-Type: text/plain");

$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");

if($_REQUEST['cible'] == 'service')
{
	$hopID = $_REQUEST['source'];
	$requete="SELECT service_ID, service_nom FROM service WHERE Hop_ID='$hopID' AND Priorite_Alerte < 9 ORDER BY service_nom";
}
else
{
	$serviceID = $_REQUEST['source'];
	$requete="SELECT uf_ID, uf_nom FROM uf WHERE service_ID='$serviceID' ORDER BY uf_nom";
}


$resultat = ExecRequete($requete,$connexion);
$debut = true;
$nbColonnes = mysql_num_fields($resultat);
echo "{\"listeServices\":[";
if(mysql_num_rows($resultat))
{
	while($rub=mysql_fetch_array($resultat))
	{
		if($debut)
		{
			echo "{";
			$debut = false;
		}
		else
		{
			echo ",{";
		}
		for($j=0;$j<$nbColonnes;$j++)
		{
			$colonne = mysql_field_name($resultat,$j);
			echo "\"".$colonne."\":\"".utf8_encode($rub[$colonne])."\"";
			if($j != $nbColonnes-1) echo ",";
		}
		echo "}";
	}// end while
}
echo "]}";
?>