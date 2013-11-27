<?php
// export_xls.php
//PHP: exporter vers un fichier Excel
//Tuesday 22 November 2005 at 8:48

//Voici un code PHP utilisé pour exporter des données d?une base de données MySQL vers un fichier Excel (.csv ou .xls):
//ce fichier montre un exemple permettant de generer un fichier excel (on peut remplacer le .csv par .xls)
/*
//parametres de connexion a la bdd
include("config.php");

//Premiere ligne = nom des champs (si on en a besoin)
//$csv_output = "p_nom,p_email";
//$csv_output .= "\n";

//Requete SQL
$query = "SELECT ...
FROM ...
WHERE ...
";
$result = mysql_query($query)
or die('Erreur SQL !<br />' . $query . '<br />' . mysql_error());

//Boucle sur les resultats
while($row = mysql_fetch_array($result)) {
$csv_output .= "$row[p_nom] $row[p_prenom],$row[p_nom],$row[p_prenom],$row[p_email]\n";
}
*/
$f = fopen('cusum.txt','r');
$csv_output="";
while(!feof($f))
{
	$p = fgets($f,1000);
	$p = str_replace ("\t",",", $p);// remplace les tabultion par des virgules
	$csv_output.=$p;
}
fclose($f);

header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=cusum_" . date("Ymd").".xls");
print $csv_output;
exit;
?> 