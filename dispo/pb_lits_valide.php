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
  * programme: 			pb_lits_valide.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			dialogue de mise � jour des lits plan blanc
  *							ce fichier est appel� par:
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
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
$back = $_REQUEST['back'];
$code = Security::esc2Db($_REQUEST['nom']); // code UF ou service 
$type = Security::esc2Db($_REQUEST['type']);// type = service ou UF 
if($code != '')
{
	$requete = "SELECT * FROM lits_pb WHERE unite_ID = '$code'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	//print_r($rep);
	$requete = "SELECT Hop_ID FROM service WHERE service_code = '$code'";
	$resultat = ExecRequete($requete,$connexion);
	$rep2 = mysql_fetch_array($resultat);
	print("r�sultat ");
	print_r($rep2);
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
</head>

<body onload="document.getElementById('mat').focus()">

	<form name='pb_lits' id='pb_lits' action= '../dispo/pb_lits_enregistre.php'> 

	<input type="hidden" name="back" value="<?php echo $back;?>">
	<input type="hidden" name="hopID" value="<?php echo $rep2['Hop_ID'];?>">

	<div id="div2">
	<fieldset id="field1">
		<legend> Origine du message </legend>
		<p>
			<label for="nom" title="code du service ou de l'UF">Code Service ou UF:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<?php echo $code;?>" size="5" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="" title="C'est un service ou une UF ?">type de code:</label>
			<input type="radio" name="type" id="type"  value="service" checked/> Service
			<input type="radio" name="type" id="type"  value="uf"/> UF
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Lits disponibles </legend>
		<p>
			<label for="mat" title="Lits inoccup�s">imm�diatement:</label>
			<input type="text" name="mat" id="mat" title="mat" value="<?php echo $rep['t1'];?>" size="5" onFocus="_select('mat');" onBlur="deselect('mat');"/>
		</p>
		<p>
			<label for="mat2" title="Lits disponibles dans les 30 minutes">dans 30 mn:</label>
			<input type="text" name="mat2" id="mat2" title="mat2" value="<?php echo $rep['t2'];?>" size="5" onFocus="_select('mat2');" onBlur="deselect('mat2');"/>
		</p>
		<p>
			<label for="mat3" title="Lits disponibles dans l'heure">dans 60 mn:</label>
			<input type="text" name="mat3" id="mat3" title="mat3" value="<?php echo $rep['t3'];?>" size="5" onFocus="_select('mat3');" onBlur="deselect('mat3');"/>
		</p>
		<p>
			<label for="mat4" title="Lits disponibles dans l'heure">dans 6 heures:</label>
			<input type="text" name="mat4" id="mat4" title="mat4" value="<?php echo $rep['t4'];?>" size="5" onFocus="_select('mat4');" onBlur="deselect('mat4');"/>
		</p>
		<p>
			<label for="mat5" title="Lits disponibles dans l'heure">dans 12 heures:</label>
			<input type="text" name="mat5" id="mat5" title="mat5" value="<?php echo $rep['t5'];?>" size="5" onFocus="_select('mat5');" onBlur="deselect('mat5');"/>
		</p>
		<p>
			<label for="mat6" title="Lits disponibles dans l'heure">dans 24 heures:</label>
			<input type="text" name="mat6" id="mat6" title="mat6" value="<?php echo $rep['t6'];?>" size="5" onFocus="_select('mat6');" onBlur="deselect('mat6');"/>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Personnel disponibles </legend>
		<p>
			<label for="cadre" title="cadre">Cadres de sant�:</label>
			<input type="text" name="cadre" id="cadre" title="cadre" value="<?php echo $rep['cadre'];?>" size="5" onFocus="_select('cadre');" onBlur="deselect('cadre');"/>
		</p>
		<p>
			<label for="ide" title="ide">IDE/IADE/IBODE:</label>
			<input type="text" name="ide" id="ide" title="ide" value="<?php echo $rep['ide'];?>" size="5" onFocus="_select('ide');" onBlur="deselect('ide');"/>
		</p>
		<p>
			<label for="as" title="as">Aide-soignantes:</label>
			<input type="text" name="as" id="as" title="as" value="<?php echo $rep['ash'];?>" size="5" onFocus="_select('as');" onBlur="deselect('as');"/>
		</p>
		<p>
			<label for="med" title="med">M�decins/internes:</label>
			<input type="text" name="med" id="med" title="med" value="<?php echo $rep['med'];?>" size="5" onFocus="_select('med');" onBlur="deselect('med');"/>
		</p>
	</fieldset>
	
	<!-- champ de type BUTTON -->
	<p>
	<input type="submit" name="ok" id="" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	</p>
</div>

</form>
</body>
</html>