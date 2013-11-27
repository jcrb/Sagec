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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		download.php								//
//	date de cr?ation: 	10/04/2004								//
//	auteur:			jcb									//
//	description:		Export d'un fichier text vers le client					//
//	version:		1.0									//
//	maj le:			10/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
$langue = $_SESSION['langue'];
if(! $_SESSION['auto_sagec'])header("Location:langue.php");

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../html.php");
//require("utilitaires/table.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> afficher un produit </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
entete_sagec("Identification d'un produit");
print("<FORM name =\"soustaches\"  ACTION=\"./recherche_produit.php\" METHOD=\"post\" TARGET=\"_TOP\">");
print("<H2>Produit recherché:</H2>");

print("<TABLE width=\"100%\">");
	print("<TR>");
		print("<TD>nom</TD>");
		print("<TD>code CAS</TD>");
		print("<TD>code UN</TD>");
	print("</TR>");

	// recherche du produit
	$requete = "SELECT * FROM produitsChimiques ";
	if($_POST["un"] > 0)
		$requete = $requete."WHERE chem_un = '$_POST[un]'";
	else if($_POST[cas] > 0)
		$requete = $requete."WHERE chem_cas = '$_POST[cas]'";
	else if($_POST[nom] !="")
		$requete = $requete."WHERE chem_nom = '$_POST[nom]'";
	if($requete !="")
	{
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			print("<TR>");
			print("<TD>$rub[chem_nom]</TD>");
			print("<TD>$rub[chem_cas]</TD>");
			print("<TD>$rub[chem_un]</TD>");
			print("</TR>");
		}
	}
	else print("Produit inconnu<BR>");

	// Identification du danger
	$requete = "SELECT * FROM danger WHERE danger_code = '$_POST[danger]'";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
			print("<TR>");
			print("<TD>Danger</TD>");
			print("<TD COLSPAN=\"2\">$rub[danger_texte]</TD>");
			print("</TR>");
	}
	//else print("Code de danger inconnu<BR>");
print("</TABLE>");
?>
