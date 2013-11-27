<?php 
/**
*	showpiegraph.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$backPathToRoot = "../../../jpgraph/src/";
require_once $backPathToRoot.'jpgraph.php';
require_once $backPathToRoot.'jpgraph_pie.php';

$x = array(); // intitule
$y = array(); // values
$w = array();

$titre = $_REQUEST['titre'];
$valeur = $_REQUEST['val'];
$w = unserialize(urldecode(stripslashes($valeur)));

foreach ($w as $intitule => $values)
{
	$x[] = $intitule;
	$y[] = $values;
}
 
$data = $y;

$graph = new PieGraph(300,200);
$graph->SetShadow();
 
$graph->title->Set($titre);
$graph->title->SetFont(FF_FONT1,FS_BOLD);
 
$p1 = new PiePlot($data);
$p1->SetLegends($x);
$p1->SetCenter(0.4);
 
$graph->Add($p1);
$graph->Stroke();

?>