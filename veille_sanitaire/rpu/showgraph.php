<?php
/**
*	showgraph.php
*/
$backPathToRoot = "../../../jpgraph/src/";
require_once $backPathToRoot.'jpgraph.php';
require_once $backPathToRoot.'jpgraph_bar.php';

$w = unserialize(urldecode(stripslashes($_GET[week])));
$x = array();
$y = array();

foreach ($w as $week => $values)
{
	$x[] = $week;
	$y[] = $values;
}
$y[0] = 0;
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
$bplot->SetFillColor('orange');
$graph->Add($bplot);
 
// Setup the titles
$graph->title->Set('Infections respiratoires virales');
$graph->xaxis->title->Set('semaines');
$graph->yaxis->title->Set('nombre de cas');
 
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
 
// Display the graph
$graph->Stroke();
?>