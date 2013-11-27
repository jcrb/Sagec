<?php
/**
* vsav2pma.php
*/
$backPathToRoot = "./../"; 
include_once($backPathToRoot."dbConnection.php");

$fp = fopen("VSAV-VLI SDIS 68.csv","r");

while(!feof($fp))
{
	$ligne = fgets($fp);
	$elements = explode("\t",$ligne);
	$villeID = $elements[1];
	if($villeID!='')
	{
		$requete = "INSERT INTO adresse VALUES('','','','','$villeID','','','')";
		$result = ExecRequete($requete,$connexion);
		$adresseID = mysql_insert_id();
		print($requete."<br>");
		
		$name = "CS ".$elements[2];
		$requete = "INSERT INTO centrale VALUES('','$name',7,'$adresseID')";
		$result = ExecRequete($requete,$connexion);
		print($requete."<br>");
	}
}
fclose($fp);
?>