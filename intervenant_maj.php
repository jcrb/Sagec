<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//----------------------------------------- SAGEC --------------------------------------------------------
//																										 //
//	programme: 			intervenant_maj																	 	 //
//	date de création: 	8/10/2003																		 //
//	auteur:				jcb																				 //
//	description:											 											 //
//	version:			1.0																				 //
//	maj le:				8/10/2003																		 //
//																										 //
//---------------------------------------------------------------------------------------------------------
session_start();
include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
include("UtilitairesHTML.php");
require("PMA_Connect.php");
require("PMA_Connexion.php");
include("Gestion_des_Intervenants.php");

// en tête
print("<html>");
print("<head>");
print("<title> Gestion des organismes </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");
// Corps
print("<FORM name =\"Intervenants\"  ACTION=\"Intervenant_saisie.php\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = "FR";
// adresse de retour mémorisée dans un champ caché
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"Intervenant_maj.php\">");

//MenuVecteurs($langue);
//$mot = $string_lang['AJOUTER_VECTEUR'][$langue];
$mot = "Ajouter / Modifier un intervenant";
Print("<H2>$mot</H2>");
TblDebut(0,"50%");
	TblDebutLigne();
		//$mot = $string_lang['SELECTIONNER_VECTEUR'][$langue];
		$mot = "Sélectionner un intervenant";
		TblCellule($mot);
		print("<TD>");
			SelectIntervenant($connexion,"0",$langue);//$org_type contient le type_ID
		print("</TD>");
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();
print("</FORM>");
print("</html>");
?>
