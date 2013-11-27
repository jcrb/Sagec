<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 					vigie_pirate.php
//	date de création: 	18/12/2005
//	auteur:			jcb
//	description:				mise àà jour
//	version:						1.2
//	maj le:							18/12/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");

include("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require '../date.php';

$langue = $_SESSION['langue'];

// ENTETE
print("<html>");
print("<head>");
print("<title> Evènement courant </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_POST['ok'])
{
	$requete = 	"UPDATE alerte SET vigiepirate_ID = '$_POST[niveau]'";
	$resultat = ExecRequete($requete,$connect);
	$date = fdate2usdate($_POST['date']);
	$requete = 	"INSERT INTO vigiepirate VALUES('','$_POST[niveau]','$date')";
	$resultat = ExecRequete($requete,$connect);
}

// CORPS
print("<BODY>");
print("<FORM ACTION =\"vigie_pirate.php\" METHOD=\"POST\">");

$requete = 	"SELECT vigiepirate_ID FROM alerte";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);

print("<table>");
print("<TR>");
	print("<TD>Le plan Vigie Pirate est au niveau</TD>");
	$niveaux=array("BLANC","JAUNE","ORANGE","ROUGE","ECARLATE");
	print("<TD>");
		print("<select name=\"niveau\" size=\"1\" onChange='$change'>");
		for($i=0;$i<count($niveaux);$i++)
		{
			print("<OPTION VALUE=\"$i\" ");
			if($i==$rub['vigiepirate_ID']) print(" SELECTED");
			print(">$niveaux[$i] </OPTION> \n");
		}
		print("</SELECT>\n");
	print("</TD>");
print("</TR>");

print("<TR>");
	print("<TD>à compter du</TD>");
	$today = date('j/m/Y');
	print("<TD><input type=\"text\" name=\"date\" size=\"12\" value=\"$today\"></TD>");
print("</TR>");

print("<TR>");
	print("<TD>&nbsp;</TD>");
	print("<TD><input type=\"submit\" name=\"ok\" value=\"valider\"></TD>");
print("</TR>");

print("<t/able>");
print("</form>");
print("</body>");
print("</html>");

?>