<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//---------------------------------------------------------------------------------------------------------
/**
* 	alertes sanitaires
*	@programme 		alerte_menu.php
*	@date de création: 	20/01/2007
*	@author jcb
*	@version $Id$
*	@update le 20/01/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$path = "../../";
require($path."pma_connect.php");
require($path."pma_connexion.php");
require($path."pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

function liste_indicateurs($i=1)
{
	?>
			<option value="null" <?php if($i==0)echo 'selected';?>>&nbsp;</option>
			<option value="passage" <?php if($i==1)echo 'selected';?> >Passage aux urgences</option>
			<option value="inf_1_an" <?php if($i==2)echo 'selected';?> >Passage aux urgences (moins de 1 an)</option>
			<option value="sup_75_an" <?php if($i==3)echo 'selected';?> >Passage aux urgences (plus de 75 ans)</option>
			<option value="entre1_75" <?php if($i==4)echo 'selected';?> >Passage aux urgences (entre 1 et 75 ans)</option>
			<option value="hospitalise" <?php if($i==5)echo 'selected';?> > Hospitalisations</option>
			<option value="uhcd" <?php if($i==6)echo 'selected';?> >Hospitalisé en UHCD</option>
			<option value="transfert" <?php if($i==7)echo 'selected';?> >transfert vers un autre établissement</option>
		</select>
	<?php
}
function liste_valeurs($i=1)
{
?>
			<option value="null" <?php if($i==0)echo 'selected';?>>&nbsp;</option>
			<option value="nb" <?php if($i==1)echo 'selected';?>>Nombre</option>
			<option value="mm" <?php if($i==2)echo 'selected';?>>Moyenne mobile (7 jours)</option>
			<option value="cusum" <?php if($i==3)echo 'selected';?>>Cusum</option>
			<option value="seuil1" <?php if($i==4)echo 'selected';?>>Seuil + 1DS</option>
		</select>
	<?php
}
function sujet()
{
	?>
	<select name="sujet" size="1">
		<OPTION VALUE = "sau" >Activité des services d'urgence</OPTION>
		<OPTION VALUE = "samu" >Activité des SAMU</OPTION>
	</select>
	<?php
}

$radio = $_REQUEST['select'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
		<title> Alertes sanitaires </title>
		<LINK REL=stylesheet HREF="../../pma.css" TYPE ="text/cs\">
		<LINK REL=stylesheet HREF="alerte.css" TYPE ="text/css">
		<LINK REL=stylesheet HREF="../../../css/formstyle.css" TYPE ="text/css">

		<script src="../../ajax/ajax.js" type="text/javascript"></script>
		<script src="../../ajax/JSON.js" type="text/javascript"></script>
		
		<link type="text/css" href="../../../jquery-ui-1.7.2/css/ui-lightness/jquery-ui-1.7.1.custom.css" rel="Stylesheet" />	
		<script type="text/javascript" src="../../../jquery-ui-1.7.2/jquery-1.3.2.min.js"></script>
		
		<link type="text/css" href="../../../jquery-ui-1.7.2/themes/base/ui.all.css" rel="stylesheet" />
		<script type="text/javascript" src="../../../jquery-ui-1.7.2/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="../../../jquery-ui-1.7.2/ui/ui.core.js"></script>
		<script type="text/javascript" src="../../../jquery-ui-1.7.2/ui/ui.datepicker.js"></script>
		<link type="text/css" href="../demos.css" rel="stylesheet" />
		
		
		<script src="affiche.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function() {
			$("#datepicker").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
			});
	</script>

	</head>

<body>
<FORM name ="alerte" ACTION="test1.php" METHOD="GET">

<div id="formtitle">Analyse de l'activité</div>

<div id="content">
	<fieldset id="coordonnees">
	<legend>Sujet</legend>
	<p>
		<label for="sujet" title="sujet">sujet :</label>
		<?php sujet(); ?>
	</p>
	</fieldset>
</div>
<div id="content">
	<fieldset id="coordonnees">
	<legend>Indicateurs</legend>
	<p>
		<label for="indicateur" title="indicateur">Indicateur 1:</label>
		<select name="indic1" size="1"><?php liste_indicateurs(1); ?>
		<select name="valeur1" size="1"><?php liste_valeurs(1); ?>
	</p>
	<p>
		<label for="indicateur" title="indicateur">Indicateur 2:</label>
		<select name="indic2" size="1"><?php liste_indicateurs(1); ?>
		<select name="valeur2" size="1"><?php liste_valeurs(2); ?>
	</p>
	<p>
		<label for="indicateur" title="indicateur">Indicateur 3:</label>
		<select name="indic3" size="1"><?php liste_indicateurs(0); ?>
		<select name="valeur3" size="1"><?php liste_valeurs(0); ?>
	</p>
	<p>
		<label for="indicateur" title="indicateur">Indicateur 4:</label>
		<select name="indic4" size="1"><?php liste_indicateurs(0); ?>
		<select name="valeur4" size="1"><?php liste_valeurs(0); ?>
	</p>
	</fieldset>
</div>
<div id="content">
	<fieldset id="coordonnees">
	<legend>Sélection</legend>
	<p>
		<label for="indicateur" title="indicateur">espace:</label>
		<input type="radio" name="radio" value="region" onclick="liste('region');" <? if($radio=='region')echo 'checked' ?> >Région
		<input type="radio" name="radio" value="departement" onclick="liste('departement');" <? if($radio=='departement')echo 'checked' ?> >Département
		<img id="charge" src="../../ajax/ajax_loader/attente1.gif"/></td>
		<input type="radio" name="radio" value="entite" onclick="liste('entite');" <? if($radio=='entite')echo 'checked' ?> >Entité
		<input type="radio" name="radio" value="etablissement" onclick="liste('etablissement');" <? if($radio=='etablissement')echo 'checked' ?> >Etablissement
		<select name="id_item" size="1" style="width: 20"><option>_______________________________________</option></SELECT>
	</p>
	<p>
		<label for="periode" title="periode">Période:</label>
		<?php
			$au = date("j/m/Y");
			$du = date("j/m/Y",date("U")-60*24*60*60);
		?>

<div class="demo">

<p>

		Du: 
		<!-- <input type="text" id="datepicker" size="8"> -->
		<input type="text" name="du" value="<?php echo $du; ?>" size="8"> au
		<input type="text" name=" au" value="<?php echo $au; ?>" size="8">
	</p>
	<p>
		<label for="restitution" title="restitution">Restitution:</label>
		<select name="restitution" size="1">
			<option>Courbe</option>
			<option>Tableau</option>
		</select>
	</p>
	</fieldset>
</div>

<div id="content">
	<fieldset id="coordonnees">
	<legend>Options</legend>
	<p>
		<label for="lissage" title="lissage">lissage (jours):</label>
		<input type="text" name="lissage" id = "lissage" value="7" size="5">
	</p>
	<p>
		<label for="methode" title="methode">Méthode:</label>
		<select name="methode" size="1">
			<OPTION VALUE = "c1" >Cusum C1</OPTION>
			<OPTION VALUE = "c2" SELECTED>Cusum C2</OPTION>
		</select>
	</p>
	<p>
		<label for="seuil" title="seuil">seuil de détection:</label>
		<input type="text" name="seuil" id="seuil" value="2" size="5">
	</p>
	<p>
		<label for="sensibilite" title="sensibilite">Sensibilité:</label>
		<input type="text" name="sensibilite" id="sensibilite" value="0.8" size="5">
	</p>
	</fieldset>
</div>

<div id="formfooter">
	<p>			
	<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
	<input type="reset" name="BtnClear" id="annul" value="Annuler" />
	</p>
</div>

<?php

print("</form>");
print("</BODY>");
print("</html>");
?>