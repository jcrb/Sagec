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
  * programme: 			objets.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			choisir un objet � repr�senter
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."utilitairesHTML.php");
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
	<!-- si imprimante -->
	<link rel="stylesheet" type="text/css" href="ma_feuille_css_imprimante.css" media="print" />
	<!-- si TABLE -->
	<link rel="stylesheet" href="../js/css/jquery.dataTables.css" />
	<link rel="stylesheet" href="../js/css/TableTools.css" />
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	
	<script src="../js/TableTools.min.js"></script>
	<script src="../js/ZeroClipboard.js"></script>
	
	<script src="../js/startDataTables.js"></script>
	
	<script language="javascript">

function checkBoxes (form, check) {
���for (var c = 0; c < form.elements.length; c++)
���	if (form.elements[c].type == 'checkbox')
������	form.elements[c].checked = check;
}
</script>
</head>

<body onload="">
<form name="menu" method="get" action="carto_main.php">

<?php
print("<fieldset class=\"time_r\">");
print("<legend>objets � repr�senter</legend>");
	print("<select name=\"objet\" size=\"1\">");
	print("<OPTION VALUE = \"samu_smur\">SAMU et SMUR</OPTION>");
	print("<OPTION VALUE = \"samu\">SAMU</OPTION>");
	print("<OPTION VALUE = \"sau\">SAU</OPTION>");
	print("<OPTION VALUE = \"psm1\">PSM 1</OPTION>");
	print("<OPTION VALUE = \"psm2\">PSM 2</OPTION>");
	print("<OPTION VALUE = \"caisson\">Caissons hyperbares</OPTION>");
	print("<OPTION VALUE = \"polyT\">Polytraumatis�s</OPTION>");
	print("<OPTION VALUE = \"helico\">H�licopt�res</OPTION>");
	print("<OPTION VALUE = \"rea_adulte\">R�animations Adultes</OPTION>");
	print("<OPTION VALUE = \"rea_ped\">R�animations p�diatriques</OPTION>");
	print("<OPTION VALUE = \"morgue\">Morgues</OPTION>");
	print("</select>\n");
print("</fieldset>");

print("<fieldset class=\"time_v\">");
print("<legend>Choisir les d�partements</legend>");
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
	print("<TD class=\"time_v\"><input type =\"checkbox\" name=\"dpt[]\" value=\"$rub[departement_ID]\">$rub[departement_ID]</TD>");
	$x++;
	if($x>2)
	{
		$x = 0;
		print("</TR><TR>");
	}
}
?>

</TR>
</table>
<br>
<input type="button" name="coche" value="Tout cocher" onclick="checkBoxes(menu,true)">
<input type="button" name="decoche" value="Tout d�cocher" onclick="checkBoxes(this.form,false)">

<legend>
	<input type ="checkbox" name="isocercle" checked > Isocercles centr�s sur 
	<?php select_ville($connexion,"1",$langue,$onChange=""); // id_ville 
	 ?> avec un rayon de 
	<input type="text" name="rayon" value="20" size="5"> km
</legend>

<br>
<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
</fieldset>



</form>
</body>
</html>