<?php

print($_GET["depart2"]."<br>");
print("objet: ".$_GET["objet"]."<br>");

$liste=explode("|", $_GET["depart2"]);

for($i=0;$i<count($liste);$i++)
{
	print("departement ".$liste[$i]."<br>");
}

// fabrication de la liste utilis�e par mysql
$inListe = "(";
for($i=0;$i<count($liste);$i++)
	$inListe.="'".$liste[$i]."',";
$inListe = substr($inListe, 0, strlen($inListe)-1); // ote la derni�re virgule
$inListe.=")";
print($inListe);
?>