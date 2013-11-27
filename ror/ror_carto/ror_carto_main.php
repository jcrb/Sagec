<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			ars_deces.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$titre_principal = "ROR - Cartographie";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."utilitairesHTML.php");

$depart = Array();
/*
	isocercles
*/
	$isocercle = $_REQUEST['isocercle'];
	if($isocercle){
		$isocercle='o';
		$rayon = $_REQUEST['rayon'];
		if($rayon < 0) $rayon = 100;		// isocercles de 100 km
		$villeID = $_REQUEST['id_ville'];
		if($villeID < 0) $villeID = 1;	// Strasbourg par défaut
	}
/*
	départements à afficher
*/

if($_REQUEST["dpt"])
{
	$objet = $_REQUEST['objet'];
	$zoom = $_REQUEST['zoom'];
	
	switch($objet)
	{
		case samu:$titre="SAMU départementaux";break;
		case samu_smur: $titre = "SAMU et SMUR départementaux ".$zoom;break;
		case psm1: $titre = "PSM 1";break;
		case psm2: $titre = "PSM 2";break;
		case caisson: $titre = "Caissons hyperbares";break;
		case polyT: $titre = "Polytraumatisés";break;
		case helico: $titre = "Hélicoptères sanitaires";break;
		case rea_adulte: $titre = "Services de réanimation adultes";break;
		case rea_ped: $titre = "Services de réanimation pédiatriques";break;
		case morgue: $titre = "Morgues";break;
	}
	$depart=implode("|", $_GET["dpt"]);
	$action = "<DIV id=\"div3\" ALIGN=\"center\"><IMG SRC = \"../../carto2/carto_base.php?objet=$objet&depart2=$depart&titre=$titre&zoom=$zoom)";
	$action = "<IMG SRC = \"../../carto2/carto_base.php?objet=$objet&depart2=$depart&titre=$titre&zoom=$zoom)";
	//if($_GET['isocercle'])
	//	$action.="&ville=$_GET[id_ville]&rayon=$_GET[rayon]";
	$action.="&ville=$villeID&rayon=$rayon";
	$action .="\">";
}
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
	<script language="javascript">
		function checkBoxes (form, check) {
   		for (var c = 0; c < form.elements.length; c++)
   		if (form.elements[c].type == 'checkbox')
      		form.elements[c].checked = check;
		}
</script>
</head>

<body onload="">
<form name="menu" method="get" action="ror_carto_main.php"> <!-- carto_main.php-->
<div id="div2">
	<fieldset id="field1">
		<legend>Objets à représenter: </legend>
		<p>
			
			<select name="objet" size="1">
				<option VALUE = "samu_smur" <?php if($objet=='samu_smur')echo 'selected';?> >SAMU et SMUR</option>
				<option VALUE = "psm1" <?php if($objet=='psm1')echo 'selected';?> >PSM 1</option>
				<option VALUE = "psm2" <?php if($objet=='psm2')echo 'selected';?> >PSM 2</option>
				<option VALUE = "caisson" <?php if($objet=='caisson')echo 'selected';?> >Caison Hyperbare</option>
				<option VALUE = "polyT" <?php if($objet=='polyT')echo 'selected';?> >Polytraumatisés</option>
				<option VALUE = "helico" <?php if($objet=='helico')echo 'selected';?> >Hélicoptères</option>
				<option VALUE = "rea_adulte" <?php if($objet=='rea_adulte')echo 'selected';?> >Réanimation adulte</option>
				<option VALUE = "rea_enfant" <?php if($objet=='rea_enfant')echo 'selected';?> ">Réanimation enfant</option>
				<option VALUE = "morgue" <?php if($objet=='morgue')echo 'selected';?> >Morgues hospitalières</option>
			</select>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Départements: </legend>
		<?php
			$requete="SELECT * 
			 FROM departement,region,zone
			 WHERE departement.region_ID = region.region_ID
			 AND region.zone_ID = zone.zone_ID
			 AND zone.zone_ID = 1
			 ORDER BY departement_id";
			$resultat = ExecRequete($requete,$connexion);
			print("<table>");
			$x = 0;
			print("<TR>");
			while($rub = mysql_fetch_array($resultat))
			{
				if(in_array($rub[departement_ID], $_GET["dpt"])) $c = 'checked';else $c = '';
				print("<TD class=\"time_v\"><input type =\"checkbox\" name=\"dpt[]\" value=\"$rub[departement_ID]\" $c>$rub[departement_ID]</TD>");
					$x++;
					if($x>2){
						$x = 0;
						print("</TR><TR>");
					}
			}
			print("</TR>");
			print("</table>");
			print("<br>");
			print("<input type=\"button\" name=\"coche\" value=\"Tout cocher\"onclick=\"checkBoxes(this.form,true)\">");
			print("<input type=\"button\" name=\"decoche\" value=\"Tout décocher\"onclick=\"checkBoxes(this.form,false)\">");
		?>
		
	</fieldset>
	
	<fieldset id="field1">
		<legend>Isocercles: </legend>
		<p>Tracer <input type="checkbox" id="isocercle" name="isocercle" <?php if($isocercle=='o') echo(' CHECKED')?> /></p>
		Rayon: <input type="text" name="rayon" id="rayon" title="rayon" value="<? echo $rayon;?>" size="5"/> Km
		<p>Centré sur <?php select_ville($connexion,"1",$langue,$onChange="");?></p> <!-- id_ville -->
	</fieldset>
	
	<input type="submit" name="ok" id="valider" value="Valider"/>
</div>
<!--
	affiche la carte
-->
<div id="div3" align="center"><?php print($action);?></div>

<?php
?>

</form>
</body>
</html>