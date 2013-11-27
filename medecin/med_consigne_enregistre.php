<?php
//med_consigne_enregistre.php
//
require "../dbConnection.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$date =$_REQUEST['date'];
$med =$_REQUEST['medid'];
$bouton1=$_REQUEST['bouton1'];
$bouton2=$_REQUEST['bouton2'];
$bouton3=$_REQUEST['bouton3'];
/*


*/
$requete = "INSERT INTO mg67_consigne VALUES('',";
if($bouton1)
	$requete .= "'$_REQUEST[doc_consignes_permanentes]','1','$date','$med') ";
elseif($bouton2)
	$requete .= "'$_REQUEST[doc_consignes_jour]','2','$date','$med') ";
elseif($bouton3)
	$requete .= "'$_REQUEST[doc_consignes_samu]','3','$date','$med') ";

//print($requete);
$resultat = ExecRequete($requete,$connexion);
header("Location:agenda.php?date=$_GET[date]&medid=$_GET[medid]");
?>