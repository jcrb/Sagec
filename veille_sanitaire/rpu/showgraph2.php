<?php
/**
*	showgraph2.php
*/
$backPathToRoot = "../../../jpgraph/src/";
require_once $backPathToRoot.'jpgraph.php';
require_once $backPathToRoot.'jpgraph_bar.php';

$w = unserialize(urldecode(stripslashes($_GET[week])));
$w2 = unserialize(urldecode(stripslashes($_GET[week2])));
$x = array();
$y = array();
$y2 = array();

foreach ($w as $week => $values)
{
	$x[] = $week;
	$y[] = $values;// non hospitalisés
}
foreach ($w2 as $week => $values)
{
	//$x[] = $week;
	$y2[] = $values;// hospitalisés 
}

$y[0] = 0;
$y2[0] = 0;

// on soustrait de la série 1 (total des données) la série 2 (patients hospitalisés
// pour que la somme des 2 ne dépasse pas le nb total de consultations.
for($i=0;$i<sizeof($y);$i++)
{
	//print($y[$i]."  ".$y2[$i]."  "."<br>");
	$y[$i] = $y[$i] - $y2[$i];
}

// Create the graph. These two calls are always required
$graph = new Graph(800,500);
$graph->SetScale('textlin');
 
// Add a drop shadow
$graph->SetShadow();
 
// Adjust the margin a bit to make more room for titles
$graph->SetMargin(40,30,20,40);
 
// Create a bar pot
$bplot = new BarPlot($y);
$graph->xaxis->SetTickLabels($x);

// Adjust fill color
// Create two bar plots
$b1plot = new BarPlot($y);
$b1plot->SetFillColor('orange');
$b2plot = new BarPlot($y2);
$b2plot->SetFillColor('blue');
 
// Create the accumulated bar plot
$gbplot = new AccBarPlot(array($b2plot,$b1plot));
 
// Add the accumulated plot to the graph
$graph->Add($gbplot);

 
// Setup the titles
$graph->title->Set('Infections respiratoires virales (bleu = hospitalisées)');
$graph->xaxis->title->Set('semaines');
$graph->yaxis->title->Set('nombre de cas');
 
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
 
// Display the graph
$graph->Stroke();
?>