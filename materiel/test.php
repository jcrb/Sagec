<?php
// TEST
require "../classe_dessin.php";
require "../carto_utilitaires.php";
require("../utilitaires_dessin.php");

$p1 = array();
$p2 = array();
fichierNUM2array(ouvre_fichier("../carto/POLYD.txt"),$p2);
fichierNUM2array(ouvre_fichier("../carto/POLYC.txt"),$p1);

print("Poly A<BR>");
for($i = 0; $i < count($p1)-1; $i+=2)
{
	print($p1[$i]." - ".$p1[$i+1]."<BR>");
}
print("Poly B<BR>");
for($i = 0; $i < count($p2)-1; $i+=2)
{
	print($p2[$i]." - ".$p2[$i+1]."<BR>");
}

$p3 = array();
$p3 = fusionne2polygones($p1,$p2);

print("Poly B<BR>");
for($i = 0; $i < count($p3)-1; $i+=2)
{
	print($p3[$i]." - ".$p3[$i+1]."<BR>");
}
?>
