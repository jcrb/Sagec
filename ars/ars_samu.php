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
  * programme: 			ars_samu.php
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
include_once("ars_top.php");
include_once("ars_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
include_once("ars_utilitaires.php");

/**
  *	Affichege des résultats
  */
function affiche($date1,$date2,$semaine,$resultat)
{
	?>
	<p>
			<h4>Semaine <?php echo $semaine.' du '.uDate2French($date2).' au '.uDate2French($date1).'<br>';?></h4>
			<table>
			<tr>
				<td colspan="2">Affaires</td>
				<td colspan="2">Primaires</td>
				<td colspan="2">Transferts</td>
			</tr>
			<tr>
				<td>nombre</td>
				<td>moyenne</td>
				<td>nombre</td>
				<td>moyenne</td>
				<td>nombre</td>
				<td>moyenne</td>
			</tr>
			<?php while($rep=mysql_fetch_array($resultat)){?>
				<tr>
					<td><?php echo $rep[0];?></td>
					<td><?php echo $rep[3];?></td>
					<td><?php echo $rep[1];?></td>
					<td><?php echo $rep[4];?></td>
					<td><?php echo $rep[2];?></td>
					<td><?php echo $rep[5];?></td>
				</tr>
			<?php } ?>
			</table>
		</p>
	<?php
}

/**
  *	nb d'affaires, primaire, transfert réalisés au cours ce cette semaine
  *	et moyenne corresoindante
  *	Les bornes sont incluses dans la condition Between
  *	@return le résultat de la requete
  */
function activite($date1,$date2)
{
	global $connexion;
	$requete = "SELECT SUM(nb_affaires),SUM(nb_primaires),SUM(nb_secondaires),AVG(nb_affaires),AVG(nb_primaires),AVG(nb_secondaires) 
				FROM veille_samu
				WHERE date BETWEEN  '$date2' AND '$date1'
				";
				$resultat = ExecRequete($requete,$connexion);
	return $resultat;
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

<body onload="document.getElementById('nom').focus()">

<form name="dispo_main" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Activité des SAMU d'Alsace </legend>
		<?php 
			$date1 = $last_mardi;
			$date2 = $last_last_mardi;
			$semaine = semaine_courante($date2);
			$resultat1 = activite($date1,$date2);
			affiche($date1,$date2,$semaine,$resultat1);
			$resultat1 = activite($date1,$date2);
			// semaine précédante
			$date1 = $last_last_mardi;
			$date2 = $last_last_mardi  - sept_jour;
			$semaine = semaine_courante($date2);
			$resultat2 = activite($date1,$date2);
			affiche($date1,$date2,$semaine,$resultat2);
			$resultat2 = activite($date1,$date2);
			// commentaires
			
			
			$rep1=mysql_fetch_array($resultat1);
			$rep2=mysql_fetch_array($resultat2);
		?>
		<p>
		<h4>Commentaires</h4>
			<table>
				<tr>
					<td>Affaires</td>
					<td>Primaires</td>
					<td>Secondaires</td>
				</tr>
				<tr>
					<td><?php echo ceil((1-$rep2[0]/$rep1[0])*100).'%' ?></td>
					<td><?php echo ceil((1-$rep2[2]/$rep1[2])*100).'%' ?></td>
					<td><?php echo ceil((1-$rep2[4]/$rep1[4])*100).'%' ?></td>
				</tr>
			</table>
		</p>
	</fieldset>
</div>

<?php

?>

</form>
</body>
</html>