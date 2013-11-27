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
//	programme: 			annuaire.php
//	date de création: 	02/01/2006
//	auteur:				jcb
//	description:
//	version:			1.0
//	maj le:				02/01/2006
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
require("../pma_requete.php");
require("../pma_connect.php");
require("../pma_connexion.php");
include("../html.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

function organisme_nom($id)
{
	global $connexion;
	$requete = "SELECT org_nom FROM organisme WHERE org_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	return $rub['org_nom'];
}
function service_nom($id)
{
	global $connexion;
	$requete = "SELECT service_nom,Hop_nom,org_nom
				FROM service,hopital,organisme
				WHERE service_ID = '$id'
				AND service.org_ID = organisme.org_ID
				AND service.Hop_ID = hopital.Hop_ID
				";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	return $rub;
}
function hopital_nom($id)
{
	global $connexion;
	$requete = "SELECT org_nom,Hop_nom
				FROM organisme,hopital
				WHERE Hop_ID = '$id'
				AND hopital.org_ID = organisme.org_ID
				OR hopital.org_ID = 0
				";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	return $rub;
}
function nom($id)
{
	global $connexion;
	$requete = "SELECT civilite_abrev,Pers_nom,Pers_prenom,service_nom,org_nom,Hop_nom
				FROM service,organisme,hopital,personnel,civilite
				WHERE Pers_ID = '$id'
				AND service.service_ID = personnel.service_ID
				AND service.org_ID = organisme.org_ID
				AND service.Hop_ID = hopital.Hop_ID
				AND civilite.civilite_ID = personnel.civilite_ID
				";
	$resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	return $rub;
}

//======================= En Tête ====================================
print("<HTML><HEAD>");
print("<TITLE>Annuaire</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</HEAD>");
//====================== Corps =======================================
print("<BODY>");
print("<FORM NAME=\"\" ACTION=\"\" METHOD=\"GET\">");
print("<input type=\"hidden\" name=\"back\" value=\"$_GET[back]\">");
entete_sagec("Annuaire");

//$requete = "SELECT * FROM contact,type_contact WHERE contact.type_contact_ID=type_contact.type_contact_ID ORDER BY identifiant_contact";
$requete = "SELECT * FROM contact,type_contact WHERE contact.type_contact_ID=type_contact.type_contact_ID AND nature_contact_ID='3' ORDER BY identifiant_contact";
$resultat = ExecRequete($requete,$connexion);

print("<br><table border=\"1\" class=\"Style24\">");
print("<TR>");
	print("<TD class=\"grise\">organisme</TD>");
	print("<TD>hopital</TD>");
	print("<TD>service</TD>");
	print("<TD>nature</TD>");
	print("<TD>contact</TD>");
	print("<TD>valeur</TD>");
print("</TR>");
//print("<TD class=\"blue\"><a href=$_GET[back]>Retour</a> </TD>");
while($rub = mysql_fetch_array($resultat))
{
	$hopital=$organisme=$service='&nbsp;';
	print("<TR>");
		if($rub['nature_contact_ID']==2)// organisme
		{
			$organisme = organisme_nom($rub['identifiant_contact']);
		}
		elseif($rub['nature_contact_ID']==4) // service
		{
			$rep = service_nom($rub['identifiant_contact']);
			$service = $rep['service_nom'];
			$organisme = $rep['org_nom'];
			$hopital = $rep['Hop_nom'];
			$contact_nom = $rub['contact_nom'];
		}
		elseif($rub['nature_contact_ID']==1) // personne
		{
			$rep = nom($rub['identifiant_contact']);
			$service = $rep['service_nom'];
			$organisme = $rep['org_nom'];
			$hopital = $rep['Hop_nom'];
			$contact_nom = $rep['civilite_abrev']." ".$rep['Pers_nom']." ".$rep['Pers_prenom'];
		}
		elseif($rub['nature_contact_ID']==5) // hopital
		{
			$rep = hopital_nom($rub['identifiant_contact']);
			$organisme = $rep['org_nom'];
			$hopital = $rep['Hop_nom'];
			$contact_nom = $rub['contact_nom'];
		}
		
		print("<TD>".$organisme."</TD>");
		print("<TD>".$hopital."</TD>");
		print("<TD>".$service."</TD>");
		print("<TD>".$rub['type_contact_nom']."</TD>");
		print("<TD>".$contact_nom."</TD>");
		print("<TD>".$rub['valeur']."</TD>");
	print("</TR>");
}
print("</table>");

print("</FORM>");
print("</BODY>");
print("</HTML>");
?>
