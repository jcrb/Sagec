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
  * programme: 			dotation_biotox.php
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
$titre_principal = "Biotox - Matériel";
$sousmenu = "";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require("biotox_utilitaires.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

$dotationID = $_REQUEST['dotation_id'];
if($_REQUEST['dotation_id'] > 0)
{
	$requete = "SELECT dotation.*,materiel_nom,materiel.materiel_ID
					FROM dotation,materiel
					WHERE dotation_ID = '$dotationID' 
					AND materiel.materiel_ID = dotation.materiel_ID";

	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
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
		function acontrole(){ 
			if(document.forms[0].type_ville.value > 0 && document.forms[0].type_materiels.value > 0)
				{
					return true;
				}
				else
				{
					alert('il faut obligatoirement préciser la ville et le type de matériel');
					return false;
				}
		}
	</script>
</head>

<body onload=""> <!-- document.getElementById('nom').focus() -->

<form name="biotox" action= "dotation_biotox_enregistre.php" method = "post" onsubmit="return controle();">
<input type="hidden" name="dotationID" value="<? echo $dotationID; ?>">
<input type="hidden" name="materielID" value="<? echo $rub['materiel_ID']; ?>">
<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Matériel Biotox</legend>
		<p>
			<label for="nom" title="nom">Matériel:</label>
			<? echo liste_materiel($connexion,$item_select="$rub[materiel_ID]");?> <!-- type_materiels -->
		</p>
		<p>
			<label for="marque" title="marque">Marque:</label>
			<input type="text" name="marque" id="marque" title="marque" value="<? echo $rub['marque_ID'];?>" size="50" onFocus="_select('marque');" onBlur="deselect('marque');"/>
		</p>
		<p>
			<label for="fournisseur" title="fournisseur">Fournisseur:</label>
			<? liste_fournisseurs($connexion,$rub['fournisseur_ID']) ?>
		</p>
		<p>
			<label for="acheteur" title="acheteur">Acheteur:</label>
			<? liste_acheteur($connexion,$rub['acheteur_ID']) ?>
		</p>
		<p>
			<label for="qte" title="qte">Quantité:</label>
			<input type="text" name="qte" id="qte" title="qte" value="<? echo $rub['dotation_qte'];?>" size="50" onFocus="_select('qte');" onBlur="deselect('qte');"/>
		</p>
		<p>
			<label for="ville" title="ville">Ville:</label>
			<? liste_ville($connexion,$rub['ville_ID']);?>
		</p>
	</fieldset>
	<!-- champ de type TextArea -->
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="stock" title="stock">Stockage:</label>
			<? liste_stockage($connexion,$rub['stockage_ID']);?>		<!-- type_stockage -->
		</p>
		<p>
			<label for="rem" title="rem">Commentaire:</label>
			<textarea name="rem" id="rem" rows="2" cols="50"><?php echo Security::db2str($rub['rem'])?></textarea>
		</p>
		<p>
		<label for="date_inventaire" title="date_inventaire">Date inventaire:</label>
		<input TYPE="text" VALUE="<? echo usdate2fdate($rub['date_inventaire']);?>" NAME="date_inventaire" SIZE="10" id="date_inventaire">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=biotox&elem=date_inventaire','Calendrier','width=200,height=300')">
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Calendrier </legend>
		<p>
		<label for="date1" title="date1">Date achat:</label>
		<input TYPE="text" VALUE="<? echo usdate2fdate($rub['date_achat']);?>" NAME="date1" SIZE="10" id="date1">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=biotox&elem=date1','Calendrier','width=200,height=300')">
		</p>
		<p>
		<label for="date2" title="date2">Date péremption:</label>
		<input TYPE="text" VALUE="<? echo usdate2fdate($rub['peremption']);?>" NAME="date2" SIZE="10" id="date2">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=biotox&elem=date2','Calendrier','width=200,height=300')">
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