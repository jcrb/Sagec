<?php
/**----------------------------------------- SAGEC -----------------------------
*
* This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
* SAGEC67 is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* SAGEC67 is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* You should have received a copy of the GNU General Public License
* along with SAGEC67; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*----------------------------------------- SAGEC --------------------------------
*
*	programme: 		hopital_renseignement.php
*	création: 		08/08/2009
*	auteur:			jcb
*	description:	Affiche la liste des hôpitaux à contacter
*	version:			1.0
*	maj le:			08/08/2009
*
*--------------------------------------------------------------------------------
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");

$hopID = $_REQUEST['hopID'];
$hopnom = $_REQUEST['hopnom'];
$requete = "SELECT valeur, type_contact_nom, contact_nom
				FROM contact,type_contact
				WHERE identifiant_contact = '$hopID'
				AND nature_contact_ID = '5'
				AND contact.type_contact_ID = type_contact.type_contact_ID
				";
$resultat = ExecRequete($requete,$connexion);
while($rep = mysql_fetch_array($resultat))
{
	print($rep[contact_nom]."  ".$rep[type_contact_nom]."  ".$rep[valeur]."<br>");
}
print("<br>");
/**
*	Recherche tous les services de l'hôpital pour lesquels il existe une information
*	de contact
*/
$requete = "SELECT valeur, type_contact_nom, contact_nom,service_nom
				FROM contact,type_contact,service,hopital
				WHERE identifiant_contact = service.service_ID
				AND nature_contact_ID = '4'
				AND contact.type_contact_ID = type_contact.type_contact_ID
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.Hop_ID = '$hopID'
				ORDER BY service_nom
				";
$resultat = ExecRequete($requete,$connexion);
while($rep = mysql_fetch_array($resultat))
{
	print($rep[service_nom]."  ".$rep[contact_nom]."  ".$rep[type_contact_nom]."  ".$rep[valeur]."<br>");
}
?>

<a href="../fiche_hopital.php?hopID=<?php echo $hopID; ?>">fiche hopital</a>