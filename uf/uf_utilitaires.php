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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		uf_utilitaires.php
*	description:	gestion des UF
*	date de création: 	17/02/2008
*	@author:			jcb
*	@version:		$Id: uf_utilitaires.php 41 2008-03-08 14:36:50Z jcb $
*	maj le:			
*/

/**
*	Liste déroulante des services d'un hôpital
*	@param $idHopital identifiant de l'hôpital
*	@param $idService identifiant du service
*	@param service_id identifiant du service sélectionné
*/
function fService($idHopital,$idService)
{
	global $connexion;
	$requete="SELECT service_ID, service_nom FROM service WHERE Hop_ID='$idHopital' ORDER BY service_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"service_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> Choix </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[service_ID]\" ");
		if($idService == $rub['service_ID']) print(" SELECTED");
		print(">".$rub['service_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des poles d'un hôpital
*	@param $idOrganisme identifiant de l'organisme
*	@param $idPole identifiant du pole
*	@param pole_id identifiant du pole sélectionné
*/
function fPole($idOrganisme,$idPole)
{
	global $connexion;
	$requete="SELECT pole_ID, pole_nom FROM pole WHERE org_ID='$idOrganisme' ORDER BY pole_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"pole_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[pole_ID]\" ");
		if($idPole == $rub['pole_ID']) print(" SELECTED");
		print(">".$rub['pole_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des hôpitaux
*	@param $idHopital identifiant de l'hôpital
*	@param hopital_id identifiant de l'hopital sélectionné
*/
function fHopital($idHopital)
{
	global $connexion;
	$requete="SELECT Hop_ID, Hop_nom FROM hopital WHERE Hop_ID='$idHopital' ORDER BY Hop_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"hopital_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[Hop_ID]\" ");
		if($idHopital == $rub['Hop_ID']) print(" SELECTED");
		print(">".$rub['Hop_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des organismes
*	@param $idOrganisme identifiant de l'organisme
*	@param organisme_id identifiant de l'organisme sélectionné
*/
function fOrganisme($idOrganisme)
{
	global $connexion;
	$requete="SELECT org_ID, org_nom FROM organisme WHERE org_ID='$idOrganisme' ORDER BY org_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"organisme_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[org_ID]\" ");
		if($idOrganisme == $rub['org_ID']) print(" SELECTED");
		print(">".$rub['org_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des types AGE
*	@param $idAge identifiant du type
*	@param age_id identifiant du type Invs sélectionné
*/
function fAge($idAge)
{
	global $connexion;
	$requete="SELECT uf_age_ID, uf_age_nom FROM uf_age";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"age_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non défini </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[uf_age_ID]\" ");
		if($idAge == $rub['uf_age_ID']) print(" SELECTED");
		print(">".$rub['uf_age_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des types INVS
*	@param $idInvs identifiant du type
*	@param invs_id identifiant du type Invs sélectionné
*/
function fInvs($idInvs)
{
	global $connexion;
	$requete="SELECT * FROM uf_invs ORDER BY uf_invs_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"invs_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[uf_invs_ID]\" ");
		if($idInvs == $rub['uf_invs_ID']) print(" SELECTED");
		print(">".$rub['uf_invs_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des types d'activité d'une UF
*	@param $idInvs identifiant du type
*	@param invs_id identifiant du type d'activité sélectionné
*/
function fUfActivite($idActivite)
{
	global $connexion;
	$requete="SELECT uf_activite_ID, uf_activite_nom FROM uf_activite ORDER BY uf_activite_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"activite_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[uf_activite_ID]\" ");
		if($idActivite == $rub['uf_activite_ID']) print(" SELECTED");
		print(">".$rub['uf_activite_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante de la spécialite d'une UF
*	@param $idSpecialite identifiant de la spécialité
*	@param specialite_id identifiant de la spécialité sélectionné
*/
function fUfSpecialite($idSpecialite)
{
	global $connexion;
	$requete="SELECT uf_specialite_ID, uf_specialite_nom FROM uf_specialite ORDER BY uf_specialite_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"specialite_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[uf_specialite_ID]\" ");
		if($idSpecialite == $rub['uf_specialite_ID']) print(" SELECTED");
		print(">".$rub['uf_specialite_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante de la surspécialite d'une UF
*	@param $idsurSpecialite identifiant de la surspécialité
*	@param surspecialite_id identifiant de la ssurpécialité sélectionné
*/
function fUfSurSpecialite($idsurSpecialite)
{
	global $connexion;
	$requete="SELECT uf_surspecialite_ID, uf_surspecialite_nom FROM uf_surspecialite ORDER BY uf_surspecialite_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"surspecialite_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> aucune </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[uf_surspecialite_ID]\" ");
		if($idsurSpecialite == $rub['uf_surspecialite_ID']) print(" SELECTED");
		print(">".$rub['uf_surspecialite_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante de la division d'appartenance d'une UF
*	@param $idsurSpecialite identifiant de la division: MED, CHIR...
*	@param disvision_id identifiant de la division sélectionné
*/
function fUfDivision($idDivision)
{
	global $connexion;
	$requete="SELECT * FROM uf_division ORDER BY uf_division_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"division_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> aucune </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[uf_division_ID]\" ");
		if($idDivision == $rub['uf_division_ID']) print(" SELECTED");
		print(">".$rub['uf_division_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des types de discipline d'une UF
*	@param $idInvs identifiant du type
*	@param invs_id identifiant du type d'activité sélectionné
*/
function fDiscipline($idDiscipline)
{
	global $connexion;
	$requete="SELECT * FROM uf_discipline ORDER BY uf_discipline_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"discipline_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[uf_discipline_ID]\" ");
		if($idDiscipline == $rub['uf_discipline_ID']) print(" SELECTED");
		print(">".$rub['uf_discipline_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des batiments
*	@param $idBatiment identifiant du batiment
*	@param $idOrganisme organisme
*/
function fBatiment($idOrganisme,$idBatiment)
{
	global $connexion;
	$requete="SELECT stockage_batiment_nom,stockage_batiment_ID FROM stockage_batiment WHERE Org_ID='$idOrganisme'ORDER BY stockage_batiment_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"batiment_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[stockage_batiment_ID]\" ");
		if($idBatiment == $rub['stockage_batiment_ID']) print(" SELECTED");
		print(">".$rub['stockage_batiment_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

/**
*	Liste déroulante des sites
*	@param $idBatiment identifiant du batiment
*	@param $idOrganisme organisme
*/
function fSite($idOrganisme,$idSite)
{
	global $connexion;
	$requete="SELECT site_nom,site_ID FROM sites WHERE org_ID='$idOrganisme'ORDER BY site_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"site_id\" size=\"1\">");
	print("<OPTION VALUE = \"0\"> non affecté </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[site_ID]\" ");
		if($idSite == $rub['site_ID']) print(" SELECTED");
		print(">".$rub['site_nom']."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

?>
