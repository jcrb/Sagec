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
  * programme: 			identifie_code.php
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
include_once("top_main.php");
include_once("menu_main.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

$code = $_REQUEST['nom'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>code</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Commentaires</legend>
		<p>
			<label for="nom" title="nom">Code barre:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $code;?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		
		<?php
		if(isset($code))
		{
			$pays = substr($code,0,3);echo $pays.'<br>';
			$organisme = substr($code,3,4);echo $organisme.'<br>';
			$victime = substr($code,7,5);echo $victime.'<br>';
			$cle = substr($code,12,1);echo $cle.'<br>';
			
			if($pays == '379') $pays = "FRANCE - IDENTIFIANT EXERCICE";
			else if($pays > 299 && $pays < 379) $pays = 'France - Frankreich';
			else if($pays > 399 && $pays < 441) $pays = 'Deutschland - Allemagne - Germany';
			else if($pays > 759 && $pays < 770) $pays = 'Schweiz - Suisse - CH';
			else if($pays > 399 && $pays < 441) $pays = 'Deutschland - Germany';
			else if($pays == 978 || $pays == 979) $pays = 'Code ISBN - Livre - Book';
			else $pays = "Identifiant Inconnu";
			
			$organisme = (int)$organisme;
			$requete = "SELECT org_nom, org_ID,adresse.ad_zone1, adresse.ad_zone2, ville_nom,ville_zip
							FROM organisme, adresse,ville
							WHERE organisme.org_ID = '$organisme'
							AND adresse.ad_ID = organisme.adresse_ID
							AND adresse.ville_ID = ville.ville_ID
							";
			$resultat = ExecRequete($requete,$connexion);
			$num_rows = mysql_num_rows($resultat);
			if($num_rows > 0){
				$ret="\n";
				$rep = mysql_fetch_array($resultat);
				$organisme = Security::db2str($rep['org_nom']);
				$contact = Security::db2str($rep['ad_zone1']).$ret.Security::db2str($rep['ad_zone2']).$ret.$rep['ville_zip'].' '.Security::db2str($rep['ville_nom']).$ret.$rep['valeur'];
				$requete = "SELECT valeur,type_contact_nom FROM contact,type_contact
								WHERE contact.type_contact_ID IN('1','7')
								AND nature_contact_ID = '2'
								AND contact.identifiant_contact = '$rep[org_ID]'
								AND contact.type_contact_ID = type_contact.type_contact_ID
								";
				$resultat = ExecRequete($requete,$connexion);
				while($rub = mysql_fetch_array($resultat))
				{
					$contact .= $rub['type_contact_nom'].':  '.$rub['valeur'].$ret;
				}
			}
			else $organisme = "Organisme non répertorié";
			?>
				<p>
					<label for="pays" title="pays">Pays:</label>
					<input type="text" name="" id="pays" title="pays" value="<? echo $pays;?>" size="50" />
				</p>
				<p>
					<label for="pays" title="pays">Organisme:</label>
					<input type="text" name="" id="pays" title="pays" value="<? echo $organisme;?>" size="50" />
				</p>
				<p>
					<label for="pays" title="pays">Contacts:</label>
					<textarea name="rem" id="rem" rows="4" cols="50"><?php echo $contact;?></textarea>
				</p>
				<p>
					<label for="pays" title="pays">Victime:</label>
					<input type="text" name="" id="pays" title="pays" value="<? echo $victime;?>" size="50" />
				</p>
			<?php
		}
		else {
		?>
			<!-- champ de type BUTTON -->
			<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
			</fieldset>
		<?php
			}
		?>
	

</form>
</body>
</html>
