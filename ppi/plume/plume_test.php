<?php
/**
*	plume_test.php
*/
include("plume.php");

$pasquill = "D";
$vent = 6; // vent à 6m/s
$debit = 10; // 10g/s
$h = 50; // hauteur 

$p = new plume("D",6,10,50);
print("sigma Z: ".$p->sigmaz(500));
print("<br>");
print("sigma Y: ".$p->sigmay(500));
print("<br>");
print("Concentration au sol: ".$p->main(500,0,0)*1E6." microg/m3");
print("<br>");
print($p->isocercle_debug(7490,0,1E-5));
print("<br>");

/**
*	calcul de la plume pour une concentration donnée
*/
/*
for($i = 500;$i<7700;$i+=10)
{
	//print($i." ==> ");
	$y = $p->isocercle($i,0,1E-5);
	print($y);
	print("<br>");
	if($y < 1) break;
}
*/
?>