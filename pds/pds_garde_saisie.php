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
/**----------------------------------------------------------------------------------------------------	
*	programme 			pds_garde_saisie.php 
*	@date de cr�ation: 	05/11/2006
*	@author:			jcb
*	description:		saisie des m�decins de garde pour un secteur
*	@version:			1.0 - $Id$
*	maj le:				05/11/2006
*	@package			Sagec
*----------------------------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("../utilitairesHTML.php");
require("../date.php");

$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$secteur = $_REQUEST['secteur_ID'];
// transformation des dates en timestamp unix
$d1 = fDate2unix($date1);
$d2 = fDate2unix($date2);

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**=============================================================================
* SelectMG67()Cr�e une liste d�roulante avec la liste des m�decins d'un secteur
* @param	$connexion 		variable de connexion
* @param	$item_select	fonction_ID de l'organisme s�lectionn�
* @param	$secteur		secteur de garde
* @return Au retour, med_id contient le type_ID du m�decin
//=============================================================================*/
function SelectMG67_secteur($connexion,$item_select,$secteur) //med_id
{
	$requete="SELECT med_ID, med_nom FROM mg67 WHERE secteur_PDS_ID = '$secteur'ORDER BY med_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"dr[]\" size=\"1\">");
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[med_ID]\" ");
		if($item_select == $rub['med_ID']) print(" SELECTED");
		print(">".$rub['med_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

print("<form name=\"saisie\" action=\"pds_garde_enregistre.php\">");
// m�morisation des variables sous forme de variables cach�es
print("<input type=\"hidden\" name=\"date1\" value=\"$d1\">");
print("<input type=\"hidden\" name=\"date2\" value=\"$d2\">");
print("<input type=\"hidden\" name=\"secteur\" value=\"$secteur\">");

print("<p>Secteur $secteur</p>");

print("<table>");
for($i = $d1; $i <= $d2; $i+=un_jour)
{
	print("<tr>");
		print("<td>".jour_de_la_semaine($i)." ".uDate2French($i)."</td>");
		//print("<td><input type=\"text\" name=\"dr[]\" value=\"\" size= \"15\"></td>");
		print("<td>");
			SelectMG67_secteur($connexion,$item_select,$secteur); //med_id
		print("</td>");
	print("</tr>");
}
print("</table>");
print("<td><input type=\"submit\" name=\"ok\" value=\"valider\"></td>");
?>