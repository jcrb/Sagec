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
//----------------------------------------- SAGEC ----------------------------//
/**
//	programme: 			evenement_routines.php
//	date de création: 	12/11/2004
//	@author:			jcb
//	description:
//	@version:			1.0 - $Id: evenement_maj.php 10 2006-08-17 22:41:56Z jcb $
//	maj le:				14/08/2006
*/
//----------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
  *		select_generique()
  *		@ $table	table à lister
  *		@ $order	colonne de tri
  *		@ $name		nom de la variable retournée
  *		@ $col		nom de la colonne à afficher
  *		@ $val		nom de la colonne des valeurs associées aux items
  *		@ $select	nom de la veleur affichée par défaut
  */

function select_generique($table,$order,$name,$col,$select)
{
	global $connexion;
	$requete="SELECT * FROM $table ORDER BY $order";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"$nom\" size=\"1\">");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[$val]\" ");
		if($select == $rub[$val]) print(" SELECTED");
		print(">".$rub[$col]."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/** ============================================================================
SelectGroupe()Crée une liste déroulante avec la liste des groupes de discipline
			$connexion 		variable de connexion
			$item_select	fonction_ID de l'organisme sélectionné
			Au retour, incident_type contient le type_ID de l'incident
=============================================================================*/
function categorie($item_select) //discipline_id
{
	global $connexion;
	$requete="SELECT * FROM incident_type ORDER BY type_ID";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"incident_type\" size=\"1\">");
	//$mot="Inconnu";
	//print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[type_ID]\" ");
		if($item_select == $rub['type_ID']) print(" SELECTED");
		print(">".$rub['type_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

function scategorie($item_select) //discipline_id
{
	global $connexion;
	$requete="SELECT * FROM incident_soustype ORDER BY stype_ID";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"id_scategorie\" size=\"1\">");
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[stype_ID]\" ");
		if($item_select == $rub['stype_ID']) print(" SELECTED");
		print(">".$rub['stype_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

?>
