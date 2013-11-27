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
  * programme: 			lits_planBlanc_query.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			dialogue de mise à jour des lits plan blanc
  *							ce fichier est appelé par:
  *							- dispo/lits_olanBlanc.php
  *							- crisehus/cc_lits_planBlanc_update.php	 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
require $backPathToRoot.'utilitaires/globals_string_lang.php';
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
	<script type="text/javascript">
	//<![CDATA[

    	function validation()
    	{
    		var alerte='';

  			if(document.pb_lits.nom.value == "")
  			{
    			alerte="Le code UF ou service est obligatioire";
  			}
  			if(!document.pb_lits.type[0].checked && !document.pb_lits.type[1].checked)
  			{
    			alerte="Type: Préciser s'il s'agit d'un code UF ou un code service";
  			}
  			
  			if(alerte !='')
  			{
    			alert(alerte);
    			return false;
  			}
  			else
  				return true;
    	}
    //]]>
	</script>
	
</head>

<body onload="document.getElementById('nom').focus()">

<form name='pb_lits' id='pb_lits' action= '../dispo/pb_lits_valide.php' method = 'get' onsubmit='return validation()'> 

<input type="hidden" name="back" value="<?php echo $back;?>">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Origine du message </legend>
		<p>
			<label for="nom" title="code du service ou de l'UF">Code Service ou UF:</label>
			<input type="text" name="nom" id="nom" title="nom" value="" size="5" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="" title="C'est un service ou une UF ?">type de code:</label>
			<input type="radio" name="type" id="type"  value="service" checked/> Service
			<input type="radio" name="type" id="type"  value="uf"/> UF
		</p>
		<!-- champ de type BUTTON -->
		<input type="submit" name="ok" id="submit" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	</fieldset>

	
</div>

<?php
?>

</form>
</body>
</html>