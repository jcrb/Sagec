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
//																										 //
//	programme: 			intervenants_synoptique.php																	 //
//	date de création: 	11/02/2004																		 //
//	auteur:				jcb																				 //
//	description:		Synoptique des intervenants engagés									 //
//	version:			1.0																				 //
//	maj le:				11/02/2004																		 //
//																										 //
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
require("pma_connect.php");
require("pma_connexion.php");
include("utilitairesHTML.php");
require_once("intervenants_menu.php");

print("<HTML>");
print("<HEAD>");
print("<META NAME=\"author JCB\"> ");
print("<TITLE>Bilan</TITLE>");
//<comment> rafraichissement automatique toutes les 30 secondes </comment>
print("<meta http-equiv=\"refresh\" content=\"30\">");
print("</HEAD>");

print("<BODY>");
print("<FORM ACTION =\"Bilan.php\">");
menu_intervenants($_SESSION['langue']);
// Date et heure du bilan
print("<fieldset>");
$mot = DateHeure($langue);
print("<legend><H2>Synoptique</H2></legend>");
// connection à la base PMA pour extraire les données nécessaires
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$table = array(array());
$requete="SELECT perso_cat_ID, localisation_ID FROM personnel WHERE arrive = 'o'";
$resultat = ExecRequete($requete,$connexion);
while($i = LigneSuivante($resultat))
{
	$table[$i->perso_cat_ID][$i->localisation_ID] ++;
	//print("cat= ".$i->perso_cat_ID." localisation= ".$i->localisation_ID."<BR>");
}
/*
for($i=0;$i<17;$i++)
	for($j=0;$j<)
*/
$requete="SELECT local_nom FROM localisation";
$resultat = ExecRequete($requete,$connexion);
print("<TABLE width=\"100%\" bgcolor=\"khaki\" cellspacing=\"0\" bordercolor=\"lavender \" BORDER=\"1\">");
// Ligne supérieure du tableau
print("<TR class=\"time\">");
print("<TD>");
while($r = LigneSuivante($resultat))
{
	print("<TD>");
	print($r->local_nom);
	print("</TD>");
}
print("<TD>NA</TD>");// les non affectés
print("</TR>");

$requete="SELECT perso_cat_nom FROM perso_cat";
$resultat = ExecRequete($requete,$connexion);
$categorie=1;
while($i = LigneSuivante($resultat))
{
// Ecriture de la 1ère colonne	
	print("<TR class=\"time\">");
	print("<TD>");
	print($i->perso_cat_nom);
	print("</TD>");
// Ecriture de la ligne correspondante du tableau 
	for($localisation = 1; $localisation < 17; $localisation ++)
	{
		print("<TD align=\"center\">");
			if($table[$categorie][$localisation] != 0)
				print($table[$categorie][$localisation]);
			else
				print("&nbsp");
		print("</TD>");
	}
	// dernière colonne = non affectés
	print("<TD align=\"center\">");
		if($table[$categorie][0] != 0)
			print($table[$categorie][0]);
		else
			print("&nbsp");
	print("</TD>");
	$categorie++;
	print("</TR>");
}
print("</TABLE>");

print("</FORM></BODY></HTML>");
?>
