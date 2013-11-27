<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		structure_temp.php
//	date de création: 	22/10/2005
//	auteur:			jcb
//	description:
//	version:		1.0
//	modifié le		22/10/2005
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
include_once("header.php");
include_once("dbConnection.php");
include_once($backPathToRoot."date.php");
include_once($backPathToRoot."login/init_security.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<!-- Ceci est spécifique de Sagec, localhost  -->
	<script src = "../utilitaires/google/key.js"></script>
	<!--
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=myKey"
      type="text/javascript"></script>
  -->
    <script>
    	var scriptTag = '<' + 'script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='+ myKey +'"type="text/javascript">'+'<'+'/script>';
    	document.write(scriptTag);
    </script>
     
     
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<!-- 
    <script src="lanxes.js" type="text/javascript"></script>
    <script src="../utilitaires/google/map_functions.js" type="text/javascript"></script> -->
    <script src="pma_data_api3.js" type="text/javascript"></script>
    <link href="map.css" rel="stylesheet" type="text/css" />
    
    
</head>
<?php
$ts = "";
$update = false;
$ts = $_REQUEST['ts_IDField'];
if(isset($ts)) /** c'est un update */
{
	$requete = "SELECT * FROM temp_structure WHERE ts_ID = '$ts'";
	$resultat = ExecRequete($requete,$connexion);
	$tempStruct = mySql_Fetch_Array($resultat);
	print("<h2>Mise à jour d'une structure temporaire</h2>");
	$update = true;
}
else
	print("<h2>Nouvelle structure temporaire</h2>");

print("<form  enctype=\"multipart/form-data\" name=\"temp_structureEnterForm\" method=\"POST\" action=\"insertNewTemp_structure.php\">");
?>
<input type="hidden" name="tsID" value="<?php echo $ts;?>" >
<input type="hidden" name="update" value="<?php echo $update;?>" >

<table cellspacing="2" cellpadding="2" border="0" width="100%">
	<tr>
		<td>

			<table cellspacing="2" cellpadding="2" border="0" width="100%">
    <tr valign="top" height="20">
        <td align="right"> <b> nom </b> </td>
        <td align="left"> <input type="text" name="thisTs_nomField" size="40" value="<?php echo Security::db2str($tempStruct[ts_nom]) ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> type </b> </td>
	<?php
		print("<TD  align=\"left\">");
			SelectLocal($connexion,$tempStruct[ts_type],$langue,'');//local_type contient le type_ID select name="thisTs_typeField"
		print("</TD>");
	?>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> localisation : </b> </td>
        <td align="left"> <textarea name="thisTs_localisationField" wrap="VIRTUAL" cols="40" rows="4"><?php echo Security::db2str($tempStruct[ts_localisation])?></textarea></td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> contact : </b> </td>
        <td align="left"> <textarea name="thisTs_contactField" wrap="VIRTUAL" cols="40" rows="4"><?php echo Security::db2str($tempStruct[ts_contact]) ?></textarea>  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> latitude : </b> </td>
        <td align="left"> <input id="lat" type="text" name="thisTs_latField" size="10" value="<?php echo Security::db2str($tempStruct[ts_lat]) ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> longitude : </b> </td>
        <td align="left"> <input id="long" type="text" name="thisTs_longField" size="10" value="<?php echo Security::db2str($tempStruct[ts_long]) ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> dépend de : </b> </td>
	
	<?php 
		print("<TD  align=\"left\">");
		SelectStructureTemporaire($connexion,$tempStruct[ts_parent_ID],$langue); // retourne l'ID de la structure temporaire mère: localisation_type
		$datetime = uDateTime2MySql(time());
		print("</TD>");
	?>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> activé : </b> </td>
	<?php
      if($tempStruct[ts_active]=='o')$check="checked"; else $check = "";
		print("<td align=\"left\"> <input type=\"checkbox\" name=\"thisTs_activeField\" value=\"o\" $check></td>");
	?>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> heure d'activation : </b> </td>
        <td align="left"> <input type="text" name="thisTs_heure_activationField" size="17" value="<? echo $datetime ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> heure d'arret : </b> </td>
        <td align="left"> <input type="text" name="thisTs_heure_arretField" size="17" value="<? echo $datetime ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> réutilisable : </b> </td>
		<?php
      	if($tempStruct[ts_reutilisable]=='o')$check="checked"; else $check = "";
			print("<td align=\"left\"> <input type=\"checkbox\" name=\"thisTs_reutilisableField\" value=\"o\" $check></td>");
		?>
    </tr>
     <tr valign="top" height="20">
     		<td align="right"><b>plan: </b></td>
     		<td align="left"><input type="input" name="fichier" value="<?php echo $tempStruct[ts_plan];?>" </td>
		</tr>
   
</table>
			
		</td>
		<td>
			<input type="checkbox" id="check"> Utiliser la carte
			<div id="map" style="width: 800px; height: 500px"></div>
		</td>
	</tr>
</table>

<input type="submit" name="submitEnterTemp_structureForm" value="Valider la fiche">
<input type="reset" name="resetForm" value="Effacer la fiche">

<?php
if($ts)
{
	print("<table  cellspacing=\"2\" cellpadding=\"2\" border=\"0\" width=\"100%\">");
	print("<tr valign=\"top\">");
		print("<td>");
		
			/** Personnels affecté */

			print("<fieldset>");
			print("<Legend>Personnels affectés</legend>");
			$requete = "SELECT * FROM perso_affectation WHERE location_ID = '$ts'";
			$resultat = ExecRequete($requete,$connexion);
			while($vecteur = mySql_Fetch_Array($resultat))
			{
				print($vecteur['Pers_Nom']."<br>");
			}
			print("</fieldset>");
		print("</td>");

	/** Vecteurs affecté */

		print("<td>");
			print("<fieldset>");
			print("<Legend>Vecteurs affectés</legend>");
			$requete = "SELECT * FROM vecteur WHERE localisation_ID = '$ts'";
			$resultat = ExecRequete($requete,$connexion);
			while($vecteur = mySql_Fetch_Array($resultat))
			{
				print($vecteur['Vec_Nom']."<br>");
			}
			print("</fieldset>");
		print("</td>");
	print("</tr>");
	print("</table>");
}
?>
</form>

<?php
    include_once("footer.php");
?> 
