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
  * programme: 			intervenants.php
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
$titre_principal="Secrétariat - Plan blanc";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
include($backPathToRoot."login/init_security.php");
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");

/**
  *	liste des personnels
  */
$requete = "SELECT Pers_ID,Pers_Nom, Pers_Prenom,rpps,perso_cat_nom 
				FROM personnel,perso_cat 
				WHERE personnel.perso_cat_ID = perso_cat.perso_cat_ID
				AND visible = 'o'
				ORDER BY Pers_Nom
				";
$resultat = ExecRequete($requete,$connexion);

/**
 *		algorithme de Luhn
 *		vérifie qu'un code barre est exact
 *		source: wikipedia
 *		ne fonctionne pas avec EAN13 ?????
 */
function isLuhnNum($num)
{
	//longueur de la chaine $num
	$length = strlen($num);
	if($length < 2) return false;
	//resultat de l'addition de tous les chiffres
	$tot = 0;
	for($i=$length-1;$i>=0;$i--)
	{
		$digit = substr($num, $i, 1);

		if ((($length - $i) % 2) == 0)
		{
			$digit = $digit*2;
			if ($digit>9)
			{
				$digit = $digit-9;
			}
		}
		$tot += $digit;
	}
	return (($tot % 10) == 0);
}

$mot=$string_lang['GESTION_INTERVENANT'][$langue];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des intervenants</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('code').focus()">

<form name="arrivant" action= "intervenants_arrive_enregistre.php" method = "post">

<?php

?>
<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Enregistrement arrivant</legend>
		<!--<p>
			<label for="type" title="type">Mouvement :</label>
			<input type="radio" name="mouvement" id="type" title="type" checked value="1" onFocus="_select('type');" onBlur="deselect('type');" onClick="document.getElementById('code').focus();"/> Arrivée
			<input type="radio" name="mouvement" id="type" title="type" value="2" onFocus="_select('type');" onBlur="deselect('type');" onClick="document.getElementById('code').focus();"/> Départ
		</p>-->
		<p>
			<label for="code" title="code">Code Barre:</label>
			<input type="text" name="code" id="code" title="code" value="" size="50" onFocus="_select('code');" onBlur="deselect('code');"/>
		</p>
		<p>
			<label for="id" title="id">Nom:</label>
			<select name="id" id="id" title="id" onchange="document.arrivant.submit();">
				<option value="0">code barre</option>
				<?php while($rep=mysql_fetch_array($resultat)){?>
				<option value="<?php echo $rep['Pers_ID'];?>"><?php echo $rep['Pers_Nom']." ".$rep['Pers_Prenom'];?></option>
				<?php } ?>
			</select>
		</p>

	</fieldset>
	
	<input type="submit" name="ok" id="valider" value="Valider"/><br><br><br>
	
	<fieldset id="field1">
		<legend>Personnel déjà enregistré</legend>
		<table class="noprint">
			<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Métier</th>
			<th>Heure arrivée</th>
			<th>Heure départ</th>
			<th>Affectation</th>
			</tr>
		<?php
			$requete = "SELECT Pers_ID,Pers_Nom,Pers_Prenom,heure_arrive, heure_depart,perso_cat_nom,ts_nom
							FROM personnel,perso_cat,perso_affectation
							LEFT OUTER JOIN (temp_structure) ON ts_ID = location_ID
							WHERE heure_arrive > 0
							AND personnel.Pers_ID = perso_affectation.personnel_ID
							AND perso_cat.perso_cat_ID = personnel.perso_cat_ID
							ORDER BY Pers_Nom";
			$resultat = ExecRequete($requete,$connexion);
			while($rub=mysql_fetch_array($resultat))
			{
				print("<tr>");
					print("<td><a href=\"intervenant_affectation.php?nom=$rub[Pers_Nom]&prenom=$rub[Pers_Prenom]&id=$rub[Pers_ID]\">$rub[Pers_Nom]</a></td>");
					print("<td>$rub[Pers_Prenom]</td>");
					print("<td>$rub[perso_cat_nom]</td>");
					print("<td>$rub[heure_arrive]</td>");
					if($rub[heure_depart] > 0)
						print("<td>$rub[heure_depart]</td>");
					else
						print("<td>&nbsp;</td>");
					print("<td>".Security::db2str($rub['ts_nom'])."</td>");
				print("</tr>");
			}
		?>
		</table>
	</fieldset>
	
</div>

</form>
</body>
</html>