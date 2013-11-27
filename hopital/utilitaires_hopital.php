<?php
//----------------------------------------- SAGEC ------------------------------

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
//------------------------------------------------------------------------------
/** 
*	utilitaires_hopital.php
* 	Calcul du score PDL
*	date de création: 		 
*	@author:			jcb		  
*	@version:	$Id$	 
*	maj le:				
*	@package			sagec
*/
//------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("./../pma_connect.php");
require("./../pma_connexion.php");
require("./../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
*	crée la liste des hôpitaux avec DZ
*/
function liste_hop_dz($hop_dz,$item_select)
{
	global $connexion;
	$requete = "SELECT Hop_ID,Hop_nom
			FROM hopital
			WHERE Hop_DZ <> 0";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"".$hop_dz."\" size=\"1\">");
	print("<OPTION VALUE = \"0\">[pas de service] </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[Hop_ID]\" ");
			if($item_select == $rub['Hop_ID']) print(" SELECTED");
			print("> $rub[Hop_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
?>
