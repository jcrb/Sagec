<?php
/**
 *	programme:		lits_fermes_voir.php
 * date de création: 	12/02/2010
 * auteur:					jcb
 * description:
 * version:					1.0
 * maj le:
 */
//----------------------------------------- SAGEC ---------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//---------------------------------------------------------------------------------

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!($_SESSION['auto_hopital']||$_SESSION['auto_service']||$_SESSION['auto_organisme']))header("Location:../logout.php");
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");

$serviceID = $_REQUEST['_service'];
$nom = $_REQUEST['nom'];
$supprimer = $_REQUEST['supprimer'];

if(isset($supprimer))
{
	$requete = "DELETE FROM lits_fermes WHERE lits_ferme_id = '$supprimer'";
	ExecRequete($requete,$connexion);
	unset($supprimer);
	// tracelog ?
}

$today = mktime();//date courante
$requete = "SELECT * FROM lits_fermes WHERE service_ID = '$serviceID' ORDER BY debut";
$resultat = ExecRequete($requete,$connexion);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<meta http-equiv="content-type" content="="text/ht; charset=ISO-8859-15" ">
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="" action= "voir_lits_fermes" method = "post">

	<input type="hidden" name="_service" value="$serviceID">
	<input type="hidden" name="nom" value="$nom">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo $nom;?> </legend>
		<p>
			<label for="nom" title="nom">Fermetures prévisionnelles:</label>
		</p>
		<TABLE WIDTH="100%" CLASS="Style22">
			<tr>
			<th>modifier</th>
			<th>supprimer</th>
			<th>début</th>
			<th>fin</th>
			<th>nombre de lits fermés</th>
			<th>mise à jour</th>
			</tr>
			<?php
			while($rub=mysql_fetch_array($resultat))
			{
				print("<tr>");
				print("<th><A href=\"lits_fermes_nouveau.php?enregistrement=$rub[lits_ferme_id]&nom=$nom&serviceID=$serviceID\" >modifier</A></th>");
				print("<th><A href=\"lits_fermes_voir.php?_service=$serviceID&supprimer=$rub[lits_ferme_id]\" onclick=\"return confirm('Etes vous certain de vouloir supprimer cet enregistrement?');\">supprimer</A></th>");
				print("<td>".uDate2French($rub[debut])."</td>");
				print("<td>".uDate2French($rub[fin])."</td>");
				print("<td>$rub[nb_lits_fermes]</td>");
				print("<td>".uDate2French($rub[date_maj])."</td>");
				print("</tr>");
			}
			?>
			</table>
	</fieldset>

	
</div>

<?php
/*
$mot="Etat des fermetures de lits";
print("<H3>$mot</H3>");
$_service=$_GET['_service'];
$service_nom=$_GET['nom'];
print("");
print("");
*/
?>

</form>
</body>
</html>