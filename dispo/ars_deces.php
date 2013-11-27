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
$backPathToRoot = "../";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require $backPathToRoot."date.php";
/* <? echo $string_lang['DECES'][$langue];?> */

if($_GET['enregistrement'])// si la var existe, récupérer les valeurs
{
	$requete = "SELECT * FROM veille_dg WHERE veille_dg_ID='$_GET[enregistrement]'";
	$resultat = ExecRequete($requete,$connexion);
	$val = mysql_fetch_array($resultat);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<script>
	 function verifier()
 	{
 	var date = document.forms[0].elements[0].value;// date saisie
	var delim1 = date.indexOf("/");// positionnement des séparateurs
	var delim2 = date.lastIndexOf("/");
	var year = parseInt(date.substring(0,delim1),10);// isolement de l'année, du mois, du jour
	var mois = parseInt(date.substring(delim1+1,delim2),10);
	var day = parseInt(date.substring(delim2+1),10);
	date2 = new Date();// date courante
	if(year - date2.getFullYear() > 0){
		alert("Il y a un problème avec l'année");
		return false;
	}
	if(mois < 1 || mois > 12){
		alert("Il y a un problème avec le mois");
		return false;
	}
	if(day < 1 || day > 31){
		alert("Il y a un problème avec le jour");
		return false;
	}
	var d1 = parseInt(document.forms[0].elements[1].value);
	var d2 = parseInt(document.forms[0].elements[2].value);
	
	if(d2 > d1 || d1<0 || d2 <0) {
		alert(year + ' Données incohérentes'+d1+' '+d2);
		return false;
	}
	return true;
 }
 </script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="deces" action= "ars_deces_enregistre.php" method = "post" onSubmit=\"return verifier()\">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Décès intra hospitaliers </legend>
		
		<p>
		<label for="date1" title="date1">Date :</label>
		<input TYPE="text" VALUE="<?php echo aujourdhui();?>" NAME="date" SIZE="10" id="date1">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=deces&elem=date','Calendrier','width=200,height=280')">
		</p>
		<p> 
			<label for="nom" title="nom"><? echo $string_lang['NOMBRE_DE_DECES'][$langue];?></label>
			<input type="text" name="nb_deces" id="nom" title="nom" value="<? echo $val[nb_tot_dcd];?>" size="15" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="nomc" title="nomc"><? echo $string_lang['NOMBRE_DE_DECES_75'][$langue];?></label>
			<input type="text" name="nb_deces_75an" id="nomc" title="nomc" value="<?echo $val[nb_dcd_sup75];?>" size="15" onFocus="_select('nomc');" onBlur="deselect('nomc');"/>
		</p>
	</fieldset>
	
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

<?php
?>

</form>
</body>
</html>