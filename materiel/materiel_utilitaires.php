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
//
//	programme: 		materiel_utilitaires.php
//	date de création: 	20/08/2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			20/08/2004
//
//---------------------------------------------------------------------------------------------//
//=============================================================================================
//	Liste des fournisseurs
//=============================================================================================
function liste_fournisseurs($connexion,$item_select,$langue,$change="")
{
	$requete="SELECT fournisseur_ID, fournisseur_nom
			FROM fournisseur
			ORDER BY fournisseur_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_fournisseur[]\" size=\"1\" onChange='$change'>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[fournisseur_ID]\" ");
			if($item_select == $rub[fournisseur_ID]) print(" SELECTED");
			print("> $rub[fournisseur_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================================
//	Liste des acheteurs
//=============================================================================================
function liste_acheteurs($connexion,$item_select,$langue,$change="")
{
	$requete="SELECT acheteur_ID, acheteur_nom
			FROM acheteur
			ORDER BY acheteur_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_acheteur[]\" size=\"1\" onChange='$change'>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[acheteur_ID]\" ");
			if($item_select == $rub[acheteur_ID]) print(" SELECTED");
			print("> $rub[acheteur_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================================
//	Liste des matériels
//=============================================================================================
function liste_materiel($connexion,$item_select,$langue,$change="")
{
	$requete="SELECT materiel_ID, materiel_nom
			FROM materiel
			ORDER BY materiel_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"id_materiel\" size=\"1\" onChange='$change'>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[materiel_ID]\" ");
			if($item_select == $rub[materiel_ID]) print(" SELECTED");
			print("> $rub[materiel_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
?>
