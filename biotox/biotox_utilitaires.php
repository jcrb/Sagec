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
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			biotox_utilitaires.php															   //
//	date de création: 	02/02/2004															   //
//	auteur:				jcb																	   //
//	description:		affichage de la carte des secteurs									 								   //
//	version:			1.0																	   //
//	maj le:				02/02/2004										   //
//																							   //  
//---------------------------------------------------------------------------------------------//

//require($backPathtoRoot."login/init_security.php");

/* Liste déroulante du matériel. $type_materiel contient l'ID du matériel sélectionné
	L'option required bloque l'enregistrement si aucun item 'est choisi
	pour que cela fonctionne, il faut que l'option par défaut soit vide
*/
function liste_materiel($connexion,$item_select="")
{
	$requete="SELECT materiel_ID,materiel_nom FROM materiel ORDER BY materiel_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select required name=\"type_materiels\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE = \"-1\">Tous</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[materiel_ID]\" ");
			if($item_select == $rub[materiel_ID]) print(" SELECTED");
			print("> ".Security::db2str($rub[materiel_nom])." </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/** 
  *	Liste déroulante des villes siège de SMUR 
  *	11/11/2010
  */
function liste_ville($connexion,$item_select="")
{
	$requete="SELECT ville.ville_ID,ville.ville_nom
					FROM ville,adresse,hopital
					WHERE hopital.adresse_ID = adresse.ad_ID
					AND adresse.ville_ID = ville.ville_ID
					AND hopital.Hop_Smur = 'o'
					ORDER BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select required name=\"type_ville\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE = \"-1\">Toutes</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		$ville = Security::db2str($rub[ville_nom]);
			print("<OPTION VALUE=\"$rub[ville_ID]\" ");
			if($item_select == $rub[ville_ID]) print(" SELECTED");
			print("> $ville </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

// Liste déroulante des villes. $type_ville contient l'ID du matériel sélectionné
function liste_acheteur($connexion,$item_select="")
{
	$requete="SELECT acheteur_ID,acheteur_nom FROM acheteur ORDER BY acheteur_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select required name=\"type_acheteur\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE = \"\">Aucun</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[acheteur_ID]\" ");
			if($item_select == $rub[acheteur_ID]) print(" SELECTED");
			print("> ".Security::db2str($rub[acheteur_nom])." </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

// Liste déroulante des fournissurs. $type_fournisseur contient l'ID du matériel sélectionné
function liste_fournisseurs($connexion,$item_select="")
{
	$requete="SELECT fournisseur_ID,fournisseur_nom FROM fournisseur ORDER BY fournisseur_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select required name=\"type_fournisseur\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE = \"\">Aucun</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[fournisseur_ID]\" ");
			if($item_select == $rub[fournisseur_ID]) print(" SELECTED");
			print("> ".Security::db2str($rub[fournisseur_nom])." </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

// liste des stockage 
// Liste déroulante des fournissurs. $type_fournisseur contient l'ID du matériel sélectionné
function liste_stockage($connexion,$item_select="")
{
	$requete="SELECT stockage_batiment_ID,stockage_batiment_nom FROM stockage_batiment ORDER BY stockage_batiment_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"type_stockage\" size=\"1\" onChange='$onChange'>");
	print("<OPTION VALUE = \"0\">Inconnu</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[stockage_batiment_ID]\" ");
			if($item_select == $rub[stockage_batiment_ID]) print(" SELECTED");
			print("> ".Security::db2str($rub[stockage_batiment_nom])." </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

?>
