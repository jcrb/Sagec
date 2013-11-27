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
/**																									 
*	programme: 			apa_supprime.php																	 	
*	date de création: 	21/09/2003																		
*	auteur:				jcb																				
*	description:		supprime un vecteur	
*	@version:			$Id$																			
*	maj le:				21/09/2003																		
*/																										 
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["auto_apa"])
{
	print("<H2>Vous n'êtes pas autorisé à accéder à cette zone</H2><BR>");
	echo "<a href = \"login2.php\"><H1>Continuer</H1></a><br>";
	exit();
}
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
include("utilitaires/table.php");
include("utilitairesHTML.php");
include("html.php");

print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");
print("<FORM name =\"APA\"  ACTION=\"apa_delete.php\" METHOD = \"GET\">");
// Affichage de l'en-tête
TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	TblCellule("<B>Transporteurs sanitaires</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
TblFin();

//if($apa_id)
//{
	// connexion à la base de données
	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	$query = "SELECT org_nom FROM organisme WHERE org_ID = '$_SESSION[organisation]'";
	$result = ExecRequete($query,$connect);
	$apa = LigneSuivante($result);
	print("<hr>");// barre horizontale
	TblDebut(0,"75%");
	TblDebutLigne();
		TblCellule("<H2>$apa->org_nom</H2>");
		TblCellule("<H2>Suppression d'un véhicule</H2>");
		TblCellule("<H2><a href = \"apa.php\">RETOUR</a></H2>");
	TblFinLigne();
	
	TblDebut(50,"75%");
	TblDebutLigne();
		TblCellule("<b>Sélectionner un moyen</b>");
		print("<TD>");
		SelectOrgVecteur($connect,$_SESSION[organisation]);
		print("</TD>");
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"SUPPRIMER\" NAME=\"ok\" SIZE = \"30\"> ");
	TblFinLigne();
TblFin();
//}
?>
