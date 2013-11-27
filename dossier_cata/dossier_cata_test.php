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
  * programme: 			dossier_cata_saisie.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * @variables
  *	$pma				nom du pma courant
  *	$loc				ID du pma courant
  *	$poste			poste de saisie
  *	$identifiant	n° d'ordre de la victime
  *	$now				date et heure courante (unix)
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("dossier_cata_top.php");
include_once("dossier_cata_utilitaires.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
require($backPathToRoot."utilitairesHTML.php");

$identifiant = $_REQUEST['nom'];
$loc = $_REQUEST['id_pma'];
$poste = $_REQUEST['poste'];
$hop_ID = $_REQUEST['ID_hopital'];

/** découpe identifiant */
$organisme = 0;
if(strlen($identifiant)==13)
{
	$organisme = substr($identifiant,3,4);
}

/**
  *	heure courante
  */
$now = uDateTime2MySql(time());
/**
  *	Evènement courant
  */
$evenement = $_SESSION['evenement'];
/**
  *	Récupération du dossier victime
  */
$requete = "SELECT * FROM victime WHERE no_ordre = '$identifiant'";
$victime = ExecRequete($requete,$connexion);
/**
  *	Si une victime n'existe pas il faut la créer
  *	on mémorise aussi la localisation et le poste
  */
if(mysql_num_rows($victime)==0)
{
	/** create new victim */
	$requete = "INSERT INTO `pma`.`victime` (
					`victime_ID` ,`no_ordre`,`localisation_ID`,`heure_creation` ,`heure_maj` ,`evenement_ID` ,`org_createur_ID`,`pays_ID`,`poste_ID`)
					VALUES (
					NULL , '$identifiant', '$loc', '$now', '$now', '$evenement', '$organisme', '999','$poste')
					";
	$resultat = ExecRequete($requete,$connexion);
	$victime_ID =  mysql_insert_id();
	$_SESSION['localisation'] =$loc; // localisation geographique ex.pma broglie 
	$_SESSION['poste'] = $poste;// poste de saisie ex; secrétariat entrée 
}
else
{
	$rub = mysql_fetch_array($victime);
}
/**
  * nom du PMA où se fait la saisie
  */
$requete = "SELECT ts_nom FROM temp_structure WHERE ts_ID = '$_SESSION[localisation]'";
$resultat = ExecRequete($requete,$connexion);
$pma = mysql_fetch_array($resultat);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="dossier_victime.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<script type="text/javascript">
		function abcd()
		{
    		document.forms['rabot'].submit();
		}
		
		function setColor()
		{
			var color = new Array("snow","#ff000f","#ffff00","#fffafa","#40e0d0","#a9a9a9","#7fff00","#ff000f","#ffff00","#7fff00","#7fff00");
			n = document.forms.dossier.gravite. options.selectedIndex;
			//alert(n);
			document.getElementById("dossier_div2").style.backgroundColor=color[n];
		}
	</script>
</head>

<body>
	<form name="rabot" id="rabot" action="dossier_cata_enregistre.php" method="get">
	<input type="hidden" name="identifiant" value="<?php echo $identifiant;?>"/>
	<div id = "dossier_div1">
		<fieldset id="field2">
		<legend> Patient </legend>
			<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<?php echo $rub['nom'];?>" size="20" onFocus="_select('nom');" onBlur="deselect('nom');"/>
			</p>
			<p>
			<label for="prenom" title="prenom usuel">Prénom:</label>
			<input type="text" name="prenom" id="prenom" title="prenom" value="<?php echo $rub['prenom'];?>" size="20" onFocus="_select('prenom');" onBlur="deselect('prenom');"/>
			</p>
			<p>
			<label for="naissance" title="naissance">Né(e) le:</label>
			<input type="text" name="naissance" id="naissance" title="naissance" value="<?php echo $rub['naissance'];?>" size="10" onFocus="_select('naissance');" onBlur="deselect('naissance');"/>
			</p>
			<p>
			<label for="age1" title="age1">Age:</label>
			<input type="text" name="age1" id="age1" title="age1" value="<?php echo $rub['age1'];?>" size="5" onFocus="_select('age1');" onBlur="deselect('age1');"/>
			</p>
		</fieldset>
		<fieldset id="field2">
		<legend> Adresse </legend>
			<p>
			<textarea name="adresse" id="styled" >
			<?php echo Security::db2str($rub['adresse1']);?>
			</textarea>
			<!-- <textarea name="ardoise" id="rem" rows="5" cols="45"></textarea> -->
			</p>
		</fieldset>
		<fieldset id="field2">
		<legend> Contacts </legend>
			<p>
			<textarea name="contact" id="styled">
			<?php echo Security::db2str($rub['adresse2']);?>
			</textarea>
			<!-- <textarea name="ardoise" id="rem" rows="5" cols="45"></textarea> -->
			</p>
		</fieldset>
	</div>
	
	
	<div id = "dossier_div2">
		<fieldset id="field2">
		<legend> Victime </legend>
			<p>
				<label for="id" title="identifiant">Identifiant:</label>
				<input type="text" name="id" id="id" title="id" value="<?php echo $identifiant;?>" size="20" onFocus="_select('id');" onBlur="deselect('id');"/>
			</p>
			<p>
				<label for="sexe" title="sexe">Sexe:</label>
				<?php Select("sexe",$item_sexe,$rub['sexe']);?>
			</p>
			<p>
				<label for="grave" title="grave">Gravité:</label>
				<?php select_gravite($connexion,$rub['gravite'],$langue,"setColor();");?>
			</p>
		</fieldset>
				
		<fieldset id="field2">
		<legend> Localisation </legend>
			<p>
				<?php echo $pma['ts_nom'].' - '.$local[$_SESSION['poste']];?>
			</p>
		</fieldset>
		
		<fieldset id="field2">
		<legend> Contamination </legend>
		</fieldset>
		
		<fieldset id="field2">
		<legend> Destination </legend>
			<p>
				<label for="hop" title="structure de soins">Hôpital:</label>
				<?php $listeID = 1;//NE PAS MODIFIER 
				// retourne ID_hopital 
				select_hopital_visible($connexion,$rub['Hop_ID'],$langue,$listeID,"abcd()");?>
			</p>
			<p>
				<label for="service" title="service">Service:</label>
				<?php select_service2($connexion,$hop_ID,$rub['service_ID']);?>
			</p>
		</fieldset>
		
		<fieldset id="field2">
		<legend> Vecteur </legend>
		</fieldset>
	</div>
	
	<div id = "dossier_div3">
		<fieldset id="field2">
		<legend> Saisie rapide </legend>
			<p>
			<textarea name="ardoise" id="styled" onfocus="this.value=''; setbg('#e5fff3');" onblur="setbg('yellow')">constantes, lésions...</textarea>
			<!-- <textarea name="ardoise" id="rem" rows="5" cols="45"></textarea> -->
			</p>
		<input type="submit" name="ok" id="" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
		</fieldset>
		
		<fieldset id="field2">
		<legend> Constantes </legend>
		</fieldset>
		
		<fieldset id="field2">
		<legend> Lésions </legend>
		<p>
			<textarea name="lesions" id="styled">
			<?php echo Security::db2str($rub['lesions']);?>
			</textarea>
		</fieldset>
		
		<fieldset id="field2">
		<legend> Traitements </legend>
		<p>
			<textarea name="traitements" id="styled">
			<?php echo Security::db2str($rub['traitement']);?>
			</textarea>
		</fieldset>
	</div>
	
	<div id="footer">
		<input type="submit" name="ok"  id="" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	</div>
</form>
</body>
</html>