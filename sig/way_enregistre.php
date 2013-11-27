<?php
/**
*	way_enregistre.php
*/
$backPathToRoot = "../"; 
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."dbConnection.php");
include_once("way_utilitaires.php");

$wayID = $_REQUEST['wayID'];
$nom = Security::esc2Db($_REQUEST['nom']);
$type = Security::esc2Db($_REQUEST['type']);
$trait = Security::esc2Db($_REQUEST['trait']);
$fond = Security::esc2Db($_REQUEST['fond']);
$transparence = Security::esc2Db($_REQUEST['transparence']);
$ferme = Security::esc2Db($_REQUEST['ferme']);
$points = array();
$points = explode(",",Security::esc2Db($_REQUEST['points']));

/** mode création */
if($wayID=="")
{
	$requete = "INSERT INTO way(way_ID,way_nom,way_type,way_ferme,way_trait,way_fond,way_transparence) VALUES('','$nom','$type','$ferme','$trait','$fond','$transparence')";
	$resultat = ExecRequete($requete,$connexion);
	$wayID = mysql_insert_id();

	for($i=0; $i < sizeof($points)-1; $i+=2)
	{
		$lat = $points[$i];
		$lng = $points[$i+1];
		//print($points[$i]."  ".$points[$i+1]."<br>");
		if($lat && $lng)
		{
			$requete = "INSERT INTO nodes(node_lat,node_lng) VALUES('$lat','$lng')";
			$resultat = ExecRequete($requete,$connexion);
			$nodeID = mysql_insert_id();
			$requete = "INSERT INTO way_node(way_ID, node_ID)  VALUE ('$wayID','$nodeID')";
			$resultat = ExecRequete($requete,$connexion);
		}
	}
}
/** mode mise à jour */
else
{
	// MAJ de la table WAY
	$requete = "UPDATE way SET 
						way_nom = '$nom',
						way_type = '$type',
						way_ferme = '$ferme',
						way_trait = '$trait',
						way_fond = '$fond',
						way_transparence = '$transparence'
					WHERE way_ID = '$wayID'";
	$resultat = ExecRequete($requete,$connexion);
}


//$wid = 1;
//print deleteWay($wid);

header("Location:"."way_saisie.php?wayID=$wayID");
?>