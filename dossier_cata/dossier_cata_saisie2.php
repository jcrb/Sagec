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
  * programme: 			dossier_cata_saisie2.php
  * date de cr�ation: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * @variables
  *	$pma				nom du pma courant
  *	$loc				ID du pma courant
  *	$poste			poste de saisie
  *	$identifiant	n� d'ordre de la victime
  *	$now				date et heure courante (unix)
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$identifiant = $_REQUEST['nom'];
$titre_principal = $_SESSION['PMA']."&nbsp;<a href=\"dossier_cata_saisie.php?nom=$identifiant&ecran=G\">(version grand �cran)</a>";
include_once("dossier_cata_top.php");
require_once("cata_menu_top.php");
include_once("dossier_cata_utilitaires.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");
require($backPathToRoot."utilitairesHTML.php");

$poste = $_REQUEST['poste'];
$hop_ID = $_REQUEST['ID_hopital'];

/** d�coupe identifiant */
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
  *	Ev�nement courant
  */
$evenement = $_SESSION['evenement'];
/**
  *	R�cup�ration du dossier victime
  */
$requete = "SELECT * FROM victime WHERE no_ordre = '$identifiant'";
$victime = ExecRequete($requete,$connexion);

$loc = $_SESSION['PMA_ID'];

/**
  *	Si une victime n'existe pas il faut la cr�er
  *	on m�morise aussi la localisation et le poste
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
	$_SESSION['localisation'] = $loc; // localisation geographique ex.pma broglie 
	$_SESSION['poste'] = $poste;// poste de saisie ex; secr�tariat entr�e 
	
	/** met a jour la table victime_gravire */
	$requete="INSERT into victime_gravite(victime_ID,gravite_ID,localisation_ID,heure,status_ID)Values ('$victime_ID','','$loc','$now','$poste')";
	$resultat = ExecRequete($requete,$connexion);
	
}
else
{
	$rub = mysql_fetch_array($victime);
	$victime_ID =  $rub['victime_ID'];
}
/**
  * nom du PMA o� se fait la saisie
  */
$requete = "SELECT ts_nom FROM temp_structure WHERE ts_ID = '$_SESSION[localisation]'";
$resultat = ExecRequete($requete,$connexion);
$pma = mysql_fetch_array($resultat);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<!--<meta http-equiv="content-type" content="" content; charset=ISO-8859-15" >-->
	<meta http-equiv="content-type" content="""text/ht; charset=ISO-8859-1" >
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
			n = document.forms.rabot.gravite.options.selectedIndex;
			document.getElementById("couleur").style.backgroundColor=color[n];
		}
		function setbg(color)
		{
			//document.getElementById("styled").style.background=color
		} 
	</script>
</head>

<body onLoad="setColor()">
	<form name="rabot" id="rabot" action="dossier_cata_enregistre.php" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="identifiant" value="<?php echo $identifiant;?>"/>
	<input type="hidden" name="localisation" value="<?php echo $loc;?>"/>
	<input type="hidden" name="poste" value="<?php echo $poste;?>"/> 
	<input type="hidden" name="victime_ID" value="<?php echo $victime_ID;?>"/>
	<input type="hidden" name="ecran" value="<?php echo 'P';?>"/>
<div>

	<div id = "dossier_div4">
	
	<!--
	<!-- Colonne du milieu -->
	<!-- -->
	
		<fieldset id="field2">
		<legend> Victime </legend>
			<div id="couleur">
			<p>
				<label for="id" title="identifiant">Identifiant:</label>
				<input type="text" name="id" id="id" title="id" readonly value="<?php echo $identifiant;?>" size="20" onFocus="_select('id');" onBlur="deselect('id');"/>
			</p>
			<p>
				<label for="nip" title="Numero Identifiant Patient">NIP:</label>
				<input type="text" name="nip" id="nip" title="Identifiant Hospitalier" value="<?php echo $rub['nip'];?>" size="15" onFocus="_select('nip');" onBlur="deselect('nip');"/>
			</p>
			<p>
				<label for="sexe" title="sexe">Sexe:</label>
				<?php Select("sexe",$item_sexe,$rub['sexe']);?>
			</p>
			<p>
				<label for="grave" title="grave">Gravit�:</label>
				<?php select_gravite($connexion,$rub['gravite'],$langue,"setColor();");?>
			</p>
			
			</div>
		</fieldset>
		<input type="submit" name="ok" id="soumettre" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
				
		<fieldset id="field2">
		<legend> Localisation </legend>
			<p>
				<?php echo $_SESSION['PMA_ID'].'     '.$_SESSION['PMA'].'  '.$_SESSION['poste'];?>
			</p>
		</fieldset>
		
		<fieldset id="field2">
		<legend> Contamination </legend>
		</fieldset>
		
	<!--
	<!-- Colonne de gauche -->
	<!-- -->
	
		<fieldset id="field2">
		<legend> Patient </legend>
			<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<?php echo $rub['nom'];?>" size="20" onFocus="_select('nom');" onBlur="deselect('nom');"/>
			</p>
			<p>
			<label for="prenom" title="prenom usuel">Pr�nom:</label>
			<input type="text" name="prenom" id="prenom" title="prenom" value="<?php echo $rub['prenom'];?>" size="20" onFocus="_select('prenom');" onBlur="deselect('prenom');"/>
			</p>
			<p>
			<label for="naissance" title="naissance">N�(e) le:</label>
			<input type="text" name="naissance" id="naissance" title="naissance" value="<?php echo $rub['naissance'];?>" size="10" onFocus="_select('naissance');" onBlur="deselect('naissance');"/>
			</p>
			<p>
			<label for="age1" title="age1">Age:</label>
			<input type="text" name="age1" id="age1" title="age1" value="<?php echo $rub['age1'];?>" size="5" onFocus="_select('age1');" onBlur="deselect('age1');"/>
			et/ou <?php age2($connexion,$rub['age2']) ?>
			</p>
			<label for="nation" title="nationalit�">Nationalit�:</label>
				<?php nationalite($connexion,$rub['pays_ID']) ?>
			</p>
		</fieldset>
		<fieldset id="field2">
		<legend> Adresse </legend>
			<p>
			<textarea name="adresse" id="styled" onfocus="setbg('#e5fff3');" onblur="setbg(adresse','yellow')"><?php echo trim(Security::db2str($rub['adresse1']));?>
			</textarea>
			<!-- <textarea name="ardoise" id="rem" rows="5" cols="45"></textarea> -->
			</p>
		</fieldset>
		<fieldset id="field2">
		<legend> Contacts </legend>
			<p>
			<textarea name="contact" id="styled"><?php echo Security::db2str($rub['adresse2']);?>
			</textarea>
			</p>
		</fieldset>
		<fieldset id="field2">
		<legend> <?php echo 'Photographie';?> </legend>
			<p>
				<img src="<?php echo $rub['photo'];?>" alt="Photographie" height="72" width="72" align="middle" border="0">
				<input type="hidden" name="photo_victime" value="<?php echo $rub['photo'];?>">
				<input type="file" name="photo_victime" size="10" onchange="abcd()">
			</p>
		</fieldset>
	
	
	<!--
	<!-- Colonne de droite -->
	<!-- -->
	 <!-- ATTENTION les champs flottants doivent �tre mis en premier
												 ceci explique pourquoi la colonne 3 est plac�e avant la colonne 2 -->
		<fieldset id="field2">
		<legend> Saisie rapide </legend>
			<p>
			<textarea name="ardoise" id="styled" onfocus="this.value=''; setbg('#e5fff3');" onblur="setbg('yellow')">constantes, l�sions...</textarea>
			<!-- <textarea name="ardoise" id="rem" rows="5" cols="45"></textarea> -->
			</p>
		<!--<input type="submit" name="ok" id="soumettre" value="<? echo $string_lang['VALIDER'][$langue];?>"/>-->
		</fieldset>
		
		<fieldset id="field2">
			<legend> Constantes </legend>
			<p>
				<textarea name="constantes" id="styled2"><?php echo Security::db2str($rub['constantes']);?>
				</textarea>
			</p>
		</fieldset>
		
		<fieldset id="field2">
			<legend> L�sions </legend>
			<p>
				<textarea name="lesions" id="styled2"><?php echo Security::db2str($rub['lesions']);?>
				</textarea>
			</p>
		</fieldset>
		
		<fieldset id="field2">
			<legend> Traitements </legend>
			<p>
				<textarea name="traitements" id="styled2"><?php echo Security::db2str($rub['traitement']);?>
				</textarea>
			</p>
		</fieldset>
		<input type="submit" name="ok" id="soumettre" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	

		<fieldset id="field2">
		<legend> Destination </legend>
			<p>
				<label for="hop" title="structure de soins">H�pital:</label>
				<?php $listeID = 1;//NE PAS MODIFIER 
				// retourne ID_hopital 
				select_hopital_visible($connexion,$rub['Hop_ID'],$langue,$listeID,"abcd()");?>
			</p>
			<p>
				<label for="service" title="service">Service:</label>
				<?php select_service2($connexion,$rub['Hop_ID'],$rub['service_ID']);?>
			</p>
		</fieldset>
		
		<fieldset id="field2">
			<legend> Vecteur </legend>
			<p>
				<label for="moyen" title="moyen de transport">moyen:</label>
				<?php SelectVecteurEngages($connexion,$rub['vecteur_ID']);?> <!-- r�ponse: vecteur_engage_ID -->
				<!--
				<input type="text" name="moyen" id="moyen" title="moyen" value="<?php echo $rub['moyen'];?>" size="20" onFocus="_select('moyen');" onBlur="deselect('moyen');"/>
				-->
			</p>
		</fieldset>

		<fieldset id="field2">
			<legend> Commentaires </legend>
			<p>
				<textarea name="comment" id="styled" onfocus="this.align='left'; setbg('#e5fff3');" onblur="setbg('yellow')"><?php echo trim($rub['comment']);?></textarea>
			</p>
		</fieldset>

<!--
<!-- Footer -->
<!--
</div>

	<div id="footer">
		<input type="submit" name="ok" id="" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	</div>
 -->
	
</form>
</body>
</html>