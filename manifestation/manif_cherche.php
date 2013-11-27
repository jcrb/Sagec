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
  * programme: 			manif_cherche.php
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
$titre_principal = "Manifestations sportives";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
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

<form name="" action= "" method = "get">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Recherche </legend>
		<p>
			Rechercher une manifestation dont le nom contient:
		</p>
		<p>
			<input type="text" name="q" value="<? echo $_REQUEST[q];?>">
		</p>
	</fieldset>
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
	<br><br>
	<p>
	<fieldset id="field1">
		<legend>Résultats </legend>
		<?php
		if($_REQUEST[ok] == $string_lang['VALIDER'][$langue])
		{
			$q = "%".Security::str2db($_REQUEST[q])."%";
			$requete = "SELECT * FROM manifestation WHERE manif_nom LIKE '$q'";
			//echo $requete;
			$resultat = ExecRequete($requete,$connexion);
			?>
			<table>
				<tr>
					<th>N°</th>
					<th>nom</th>
					<th>voir</th>
				</tr>
				<?php
					while($rep=mysql_fetch_array($resultat))
					{
					?>	<tr>
							<td><?php echo $rep['manif_ID'];?></td>
							<td><?php echo Security::db2str($rep['manif_nom']);?></td>
							<td><a href="manif_new.php?manifID=<?php echo $rep['manif_ID'];?>">voir</a></td>
						</tr>
					<?php
					}
				?></table><?php
		}
		?>
	</p>
	</fieldset>
</div>
</form>
</body>
</html>