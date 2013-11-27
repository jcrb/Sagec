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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		materiel_lot.php
//	date de cr�ation: 	01/10/2004
//	auteur:			jcb
//	description:		saisie des caract�ristiques d'un m�dicament
//	version:			1.0
//	maj le:			01/10/2004
//
//--------------------------------------------------------------------------------------------------------

session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
include("utilitaires_materiel.php");
include("utilitaires_MED.php");

print("<html>");
print("<head>");
print("<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\">");
print("<title> M�dicaments </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = stylesheet TYPE = \"text/css\" HREF = \"pharma.css\">");
print("</head>");

print("<BODY BGCOLOR=\"#ffffff\" >");
print("<FORM name =\"materiel\"  ACTION=\"lot_enregistre.php\" METHOD=\"GET\">");

//========================================= MISE A JOUR ? =======================================
if($_GET['lot'])// c'est une mise � jour
{
	$requete="SELECT * FROM med_lot WHERE med_lot_ID = '$_GET[lot]'";
	$resultat = ExecRequete($requete,$connexion);
	$lot=mysql_fetch_array($resultat);
	print("<p>Lot enregistr�</p>");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[lot]\">");
}
else
	print("<p>Nouveau lot</p>");

//======================================== AFFICHAGE ============================================
print("<table width=\"100%\">");
print("<tr>");
	print("<td>mat�riel: </td>");//-------------------------- m�dicament
	print("<td>");
		//liste_med2($connexion,$lot[medic_ID]);//$ID_med
		select_materiels($connexion,$item_select,$onChange="");
	print("</td>");
print("</tr>");
print("<tr>");
	print("<td>quantit�: </td>");//---------------------------- quantit�
	print("<td>");
		print(" <input type=\"text\" value=\"$lot[med_lot_qte]\" size=\"3\" name=\"qte\">");
	print("</td>");
print("</tr>");
print("<tr>");
	print("<td>stock actuel: </td>");//---------------------------- stock
	print("<td>");
		print(" <input type=\"text\" value=\"$lot[stock_actuel]\" size=\"3\" name=\"stock\">");
	print("</td>");
print("<tr>");
	print("<td>date de p�remption: </td>");//------------------ p�remption
	if($_GET['lot']) $val=$lot[med_lot_perime];
	else $val="aaaa-mm-jj";
	print("<td><input type=\"text\" value=\"$val\" size=\"10\" name=\"peremption\"></td>");
print("</tr>");
//------------------------------ r�cup�rer les donn�es pour la suite ---------------------------
$requete="SELECT med_localisation, conteneur_nom, conteneur_no
		FROM  stock_conteneur
		WHERE conteneur_ID = '$lot[conteneur_ID]'
		";
$resultat = ExecRequete($requete,$connexion);
$local=mysql_fetch_array($resultat);
//----------------------------------------------------------------------------------------------
print("<tr>");
	print("<td>appartenance: </td>");
	print("<td>");
		select_med_localisation($connexion,$local['med_localisation']);//$ID_medlocal
	print("</td>");
print("</tr>");
/*
print("<tr>");
	print("<td>localisation: ");
	select_stockage($connexion,$lot[stockage_ID]); //$ID_stockage
	print("</td>");
print("</tr>");
*/
print("<tr>");
	print("<td>rangement: </td>");

		//select_rangement($connexion,$lot[rangement_ID]); ////$ID_rangement
		//select_psm($connexion,$lot[rangement_ID]); //ID_psm
	print("<td>");
		select_psm($connexion,$local['conteneur_nom']);
	print("</td>");
print("</tr>");
print("<tr>");
	print("<td>identifiant: </td>");
	print("<td><input type=\"text\" value=\"$local[conteneur_no]\" size=\"5\" name=\"identifiant\"></td>");
print("</tr>");
print("</table>");
print("<input type=\"hidden\" name=\"cat\" value=\"2\">"); // il s'agit d'un mat�riel

if($_GET['lot'])
{
	print("<input type=\"submit\" value=\"modifier\" name=\"ok\">");
	print("    <input type=\"submit\" value=\"dupliquer\" name=\"ok\">");
	print("    <input type=\"submit\" value=\"supprimer\" name=\"ok\" onClick=\"return confirmSubmit('Voulez-vous vraiment d�truire ce lot ?');\"><br>");
}
else
	print("<input type=\"submit\" value=\"enregistrer\" name=\"ok\"><br>");

print("</FORM>");
print("</html>")
?>