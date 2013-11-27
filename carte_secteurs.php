<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
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
// affichage de la carte des secteurs
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$back = $_GET['back'];
if(!$back)$back = $_POST['back'];
if(!$_POST['secteur_ID'])$secteur_ID = 10;
else $secteur_ID = $_POST['secteur_ID'];

include("apa_entete.php");
print("<FORM name =\"Organisme\" ACTION=\"carte_secteurs.php\" METHOD = \"POST\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"$back\">");// pour le retour

print("<TABLE>");
print("<TR>");
print("<TD>Choisir une carte</TD>");
print("<TD>");
	print("<SELECT NAME=\"secteur_ID\" size=\"1\">");
	print("<OPTION VALUE = \"0\">Aucune carte </OPTION> \n");
	print("<OPTION VALUE=\"1\" ");if($secteur_ID=="1") print(" SELECTED");print(">Secteur 1 - Sarre-Union</OPTION>");
	print("<OPTION VALUE=\"2\" ");if($secteur_ID=="2") print(" SELECTED");print(">Secteur 2 - Ingwiller</OPTION> ");
	print("<OPTION VALUE=\"3\" ");if($secteur_ID=="3") print(" SELECTED");print(">Secteur 3 - Wissembourg</OPTION>");
	print("<OPTION VALUE=\"4\" ");if($secteur_ID=="4") print(" SELECTED");print(">Secteur 4 - Haguenau</OPTION>");
	print("<OPTION VALUE=\"5\" ");if($secteur_ID=="5") print(" SELECTED");print(">Secteur 5 - Sélestat</OPTION>");
	print("<OPTION VALUE=\"6\" ");if($secteur_ID=="6") print(" SELECTED");print(">Secteur 6 - Saverne</OPTION>");
	print("<OPTION VALUE=\"7\" ");if($secteur_ID=="7") print(" SELECTED");print(">Secteur 7 - Erstein</OPTION>");
	print("<OPTION VALUE=\"8\" ");if($secteur_ID=="8") print(" SELECTED");print(">Secteur 8 - Molsheim</OPTION>");
	print("<OPTION VALUE=\"9\" ");if($secteur_ID=="9") print(" SELECTED");print(">Secteur 9 - Strasbourg</OPTION>");
	print("<OPTION VALUE=\"10\" ");if($secteur_ID=="10") print(" SELECTED");print(">Tous les secteurs</OPTION>");
	print("<OPTION VALUE=\"11\" ");if($secteur_ID=="11") print(" SELECTED");print(">Tous les secteurs 2</OPTION>");
	print("</SELECT>");
print("</TD>");
print("<TD>");
	TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"Valider\" NAME=\"VALIDER\" ");
print("</TD>");
print("<TD>");
	TblCellule("<A HREF = \"$back\">Page précédante</A>");
print("</TD>");
print("</TR>");
print("</TABLE>");
switch($secteur_ID)
{
	case "1":$src = "src = images/secteur1.gif";break;
	case "2":$src = "src = images/secteur2.gif";break;
	case "3":$src = "src = images/secteur3.gif";break;
	case "4":$src = "src = images/secteur4.gif";break;
	case "5":$src = "src = images/secteur5.gif";break;
	case "6":$src = "src = images/secteur6.gif";break;
	case "7":$src = "src = images/secteur7.gif";break;
	case "8":$src = "src = images/secteur8.gif";break;
	case "9":$src = "src = images/secteur9.gif";break;
	case "10":$src = "src = images/implantations.gif";break;
	case "11":$src = "src = images/secteurs.gif";break;
}
print("<INPUT TYPE = \"image\" WIDTH =\"800\" HEIGTH =\"800\" $src NAME=\"anglais\"/>");
print("</FORM>");
?>
