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
//		
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			biotox_image.php													   //
//	date de création: 	02/02/2004															   //
//	auteur:				jcb																	   //
//	description:		Création de cartes
//						ATTENTION: CE PROGRAMME NE DOIT COMPORTER AUCUNE SORTIE D'ECRAN
//						FAIT APPEL A HEADER									 				   //
//	version:			1.0																	   //
//	maj le:				02/02/2004										                       //
//																							   //  
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete="SELECT materiel_nom FROM materiel WHERE materiel_ID = '$_GET[type_materiels]'";
//print($requete);
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);

print("<DIV ALIGN=\"center\"><H2>Zone de Défense EST - Coordination Zonale - Cartographie SAMU 67</H2><BR>");
print("Type de matériel: ".$rub[0]."</DIV><BR>");

//include("biotox_carto.php");
print("<IMG SRC = \"biotox_carto.php?type_materiel=$_REQUEST[type_materiels]\">");
//print("<IMG SRC = \"pic.png\">");
?>
