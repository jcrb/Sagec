<?php
$path = "../../../jpgraph/src/";
include_once($path."jpgraph.php");
include_once($path.'jpgraph_line.php');
$backPathToRoot = "../../";
require $backPathToRoot.'date.php';

// récupère valeur moyenne lissée
$mlisse = explode(",",$_REQUEST['ml']);
// récupère les valeurs y brutes
$ydata = explode(",",$_REQUEST['v']);
// récupère les dates unix pour l'axe des X
$xdata = explode(",",$_REQUEST['d']);
for($i=0;$i<sizeof($xdata);$i++)
	$xdata[$i] = uDate2French($xdata[$i]);
// récupère le titre, débarassé de ses caractères spéciaux 
$titre = stripslashes( urldecode($_REQUEST['titre']));

// On créé l'objet Graph. Ces deux appels sont toujours necessaires.
$graph = new Graph(600,400);   
$graph->title-> Set( $titre); 
$graph->SetScale("textlin");

// Setup X-scale
$graph->xaxis->SetTickLabels($xdata);
//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->xaxis->SetLabelAngle(90);
$g = sizeof($xdata)/10;// 10 graduations
$graph->xaxis->SetTextLabelInterval($g);

// On créé un tracé
$lineplot=new LinePlot($ydata);
// On ajoutte ce tracé au graph
$graph->Add($lineplot);

// motenne lissée
if(sizeof($mlisse > 2))
{ 
	$lineplot=new LinePlot($mlisse);
	$lineplot->SetColor("red");
	$graph->Add($lineplot);
}
 
// On affiche le graphique
$graph->Stroke();
?>
	