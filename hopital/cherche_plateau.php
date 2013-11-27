<?php
//----------------------------------------- SAGEC --------------------------------------------------------
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------------------------------
/**
/*	cherche_plateau.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:".$backPathToRoot."logout.php");
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Recherche de plateaux techniques";
$sousmenu = $backPathToRoot.'lits_disponibles.php';
include_once("cherche_plateau_top.php");
//include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$back = $backPathToRoot."lits_disponibles.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>
</head>

<body>
<form name="plateau_tech" action="">
<br/>

<fieldset id="field1">
		<legend>Plateaux techniques </legend>
<table>
	<tr>
		<td><input type="checkbox" name="scanner" value="scanner" <?php if($_REQUEST['scanner']) echo 'checked' ?> >Scanner</td>
		<td><input type="checkbox" name="irm" value="irm" <?php if($_REQUEST['irm']) echo 'checked' ?> >IRM</td>
		<td><input type="checkbox" name="pet" value="pet" <?php if($_REQUEST['pet']) echo 'checked' ?> >Petscan</td>
		<td><input type="submit" name="ok" value="valider"</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="echo" value="echo" <?php if($_REQUEST['echo']) echo 'checked' ?> >Echographie</td>
		<td><input type="checkbox" name="arterio" value="arterio" <?php if($_REQUEST['arterio']) echo 'checked' ?> >Artériographie</td>
		<td>&nbsp;</td>
		<td><a href="<?php echo $back ?>"> retour </a></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="dialyse" value="dialyse" <?php if($_REQUEST['dialyse']) echo 'checked' ?> >Dialyse</td>
		<td><input type="checkbox" name="caisson" value="caisson" <?php if($_REQUEST['caisson']) echo 'checked' ?> >Caisson hyperbare</td>
	</tr>
</table>
</fieldset>
<br/>

<?php
if($_REQUEST['ok']=="valider")
{
	print("<p>Hôpitaux disposants des équipements suivants: <b>");
	$requete = "SELECT Hop_nom,Hop_ID,ad_longitude,ad_latitude,pays_nom,region_nom,territoire_nom
					FROM hopital,adresse,ville,pays,region,territoire
					WHERE Hop_finess <> 'INACTIF'
					AND hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND ville.pays_ID = pays.pays_ID
					AND ville.region_ID = region.region_ID
					AND ville.territoire_sante = territoire.territoire_ID
					";
	$m="";
		if($_REQUEST['scanner']) {$m .= " AND Hop_Scanner = 'o' "; print("Scanner ");}
		if($_REQUEST['irm']) {$m .= " AND Hop_irm = 'o' ";print("IRM ");}
		if($_REQUEST['pet']) {$m .= " AND Hop_petscan = 'o' ";print("Pet Scan ");}
		if($_REQUEST['echo']) {$m .= " AND Hop_echo = 'o' ";print("Echographie ");}
		if($_REQUEST['arterio']) {$m .= " AND Hop_angio = 'o' ";print("Angiographie ");}
		if($_REQUEST['dialyse']) {$m .= " AND Hop_dialyse = 'o' ";print("Dialyse ");}
		if($_REQUEST['caisson']) {$m .= " AND Hop_caisson = 'o' ";print("Caisson hyperbare ");}
	print("</b></p>");
	if($m=="")
	{
		print("Il faut sélectionner au moins une case...");
	}
	else
	{
		$requete .= $m." ORDER BY Hop_nom";
	
		$resultat = ExecRequete($requete,$connexion);
		$i=0;
		?>
		<fieldset id="field1">
		<legend>Réponses </legend>
			<table border="1" cellspacing="0">
			<tr>
				<td>voir</td>
				<td>Hôpital</td>
				<td>latitude</td>
				<td>longitude</td>
				<td>pays</td>
				<td>région</td>
				<td>secteur</td>
			</tr>
		<?php
		while($rep=mysql_fetch_array($resultat))
		{
			$i++;
			print("<tr>");
				print("<td><a href=\"../hopital.php?ID_hopital=$rep[Hop_ID]\">$i</a></td>");
				print("<td>".Security::db2str($rep[Hop_nom])."</td>");
				print("<td>$rep[ad_latitude]</td>");
				print("<td>$rep[ad_longitude]</td>");
				print("<td>$rep[pays_nom]</td>");
				print("<td>$rep[region_nom]</td>");
				print("<td>$rep[territoire_nom]</td>");
			print("</tr>");
		}
		print("</table>");
		
	}
}
?>
</fieldset>
</form>
</body>