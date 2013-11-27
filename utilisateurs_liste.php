<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2004 (Jean-Claude Bartier).
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
//
//	programme: 		utilisateurs_liste.php
//	date de création: 	02/01/2004
//	auteur:			jcb
//	description:
//	version:			1.1
//	maj le:			7/07/2005
//---------------------------------------------------------------------------------------------//
//Liste des vecteurs
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require 'utilitaires/globals_string_lang.php';
include("utilisateurs_menu.php");

print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//========================================================================
//	Table_Vecteurs	Affiche l'état des vecteurs sous forme d'une table
//	$connexion			variable de connexion	
//	$type	Si = 0 (valeur par défaut)affiche tous les types de vecteurs		
//========================================================================

TblDebut(0,"100%");
$_style = "A2";
TblDebutLigne("$_style");
	$modifier = StrToUpper($string_lang['MODIFIER'][$langue]);TblCellule("<B>$modifier</B>");
	$supprimer = StrToUpper($string_lang['SUPPRIMER'][$langue]);TblCellule("<B>$supprimer</B>");
	TblCellule("<B><a href=\"utilisateurs_liste.php?tri=id\">ID</a></B>");
	$mot = StrToUpper($string_lang['NOM'][$langue]);
	TblCellule("<B><a href=\"utilisateurs_liste.php?tri=nom\">$mot</a></B>");
	$mot = StrToUpper($string_lang['PRENOM'][$langue]);TblCellule("<B>$mot</B>");
	$mot = StrToUpper($string_lang['ORGANISME'][$langue]);
	TblCellule("<B><a href=\"utilisateurs_liste.php?tri=org\">$mot</a></B>");
	$mot = StrToUpper($string_lang['MAIL'][$langue]);
	TblCellule("<B>$mot</B>");
TblFinLigne();
// lire les enregistrements
$tri=$_GET['tri'];
$requete="SELECT nom,prenom,email,ID_utilisateur,org_nom
		FROM utilisateurs,organisme
		WHERE organisme.org_ID = utilisateurs.org_ID ";
		switch($tri)
		{
			case 'id':$requete.="ORDER BY ID_utilisateur";break;
			case 'nom':$requete.="ORDER BY nom";break;
			case 'org':$requete.="ORDER BY org_nom";break;
			default:$requete.="ORDER BY nom";
		}
	//print($requete);
$resultat = ExecRequete($requete,$connexion);
$_style = "A5";
$modifier=StrToLower($modifier);
$supprimer=StrToLower($supprimer);
while($i = LigneSuivante($resultat))
{
	if($_style=="A5")$_style="A6";
	else $_style="A5";
	TblDebutLigne("$_style");
	// Affichage des données de la ligne
	$identifiant = $i->ID_utilisateur;
	TblCellule("<a href=\"utilisateurs_ajout.php?utilisateur=$identifiant\" SIZE=\"10\">$modifier</a>");
	TblCellule("<a href=\"utilisateurs_delete.php?utilisateur=$identifiant\">$supprimer</a>");
	TblCellule("$i->ID_utilisateur");
	TblCellule("$i->nom");
	TblCellule("$i->prenom");
	TblCellule("$i->org_nom");
	TblCellule("$i->email");
	TblFinLigne();
}
TblFin();
?>
