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
//
//	programme: 		langue_saisie.php
//	date de création: 	03/04/2005
//	auteur:			jcb
//	description:		saisie d'une nouvelle langue
//	version:			1.0
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> Saisie d'un intervenant </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
?>
<SCRIPT>
function exite()
{
	window.opener.location.reload();
	//window.parent.opener.
	this.close();
}
</SCRIPT>
<?php

//print("<BODY onUnload=\"history.back();\" onUnload=\"this.close();\">");//
print("<BODY onUnload=\"exite();\">");
print("<FORM name =\"Intervenants\" ACTION=\"langue_enregistre.php\" METHOD=\"GET\">");
print("<input type=\"hidden\" name=\"personne_id\" value=\"$_GET[personne_id]\">");
print("Nouvelle langue parlée:<br>");
//$_GET['personne_id']);
$requete="SELECT langue_ID,langue_nom FROM langue ORDER BY langue_nom";
$resultat = ExecRequete($requete,$connexion);
print("<select name=\"id_langue\" size=\"1\">");
//$mot = $string_lang['NOUVEAU'][$langue];
print("<OPTION VALUE = \"0\">-- aucune --</OPTION> \n");
while($rub=mysql_fetch_array($resultat))
{
	print("<OPTION VALUE=\"$rub[langue_ID]\" ");
	print("> $rub[langue_nom] </OPTION> \n");
}
@mysql_free_result($resultat);
print("</SELECT>\n");
print("<br>");
print("<input type=\"submit\" name=\"ok\" value=\"valider\">");
print("</form>");
print("</BODY>");
?>
