<?php 
/**
 *	passages.php
 *	content="text/plain; charset=utf-8"
 */

$backPathToRoot = "../../../jpgraph/src/";
require_once $backPathToRoot.'jpgraph.php';
require_once $backPathToRoot.'jpgraph_bar.php';
require_once $backPathToRoot.'jpgraph_date.php';
require_once $backPathToRoot.'jpgraph_line.php';

$backPathToRoot2 = "../../";
require($backPathToRoot2."dbConnection.php");

$datay= array();
$datax= array();
$finess = "670000397";	// Sélestat

$requete = "SELECT DATE_FORMAT(date_entree,'%Y-%M-%d')AS date,UNIX_TIMESTAMP(DATE(date_entree)) AS date2, COUNT(date_entree) AS passages FROM rpu 
					WHERE finess = '$finess'
					AND date_entree > '2009-01-00'
					GROUP BY date2
					ORDER BY date2";
	$resultat = ExecRequete($requete,$connexion);
	
	while($rep=mysql_fetch_array($resultat))
	{
		$datay[] = $rep[passages];// 
		$datax[] = $rep[date2];
	}
	//$datax[] = "01/01/2009";
	
$graph = new Graph(800,600);
$graph->SetScale('datelin');
 
$graph->img->SetMargin(40,40,30,130);
$graph->SetShadow();
 
$graph->title->Set("2009 - Passages SAU Sélestat");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
 
$p1 = new LinePlot($datay,$datax);
$p1->SetFillColor("orange");
//$p1->mark->SetType(MARK_FILLEDCIRCLE);
//$p1->mark->SetFillColor("red");
//$p1->mark->SetWidth(4);
$graph->Add($p1);
// Set the angle for the labels to 90 degrees
$graph->xaxis->SetLabelAngle(90);
 
$graph->Stroke();
?>