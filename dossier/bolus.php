<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		bolus.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		administration d'un médicament
//	version:			1.2
//	maj le:			30/07/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pharmacie/utilitaires_MED.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$langue = $_SESSION['langue'];
global $ordre;

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"med\"  ACTION=\"bolus.php\" METHOD=\"get\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("&nbsp;<BR>");

function select_voie($connexion,$langue,$item_select,$onChange)
{
	require '../utilitaires/globals_string_lang.php';
	$requete="SELECT voie_ID,voie_nom FROM dm_med_voie order by voie_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"voie\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[voie_ID]\" ");
			if($item_select == $rub['voie_ID']) print(" SELECTED");
			print(">". $string_lang[strtoupper($rub['voie_nom'])][$langue]."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
// enregistrement
if($_GET['valider']=='valider')
{
	$date=$_GET['date']." ".$_GET['heure'];
	$date_unix = fDatetime2unix($date);
	$requete = "INSERT INTO dm_med VALUES('','$date_unix','$_GET[dossier]','$_GET[ID_med]','$_GET[dose]','$_GET[voie]')";
	$resultat = ExecRequete($requete,$connexion);
}
//--------------------------------------------- Horodatage ----------------------------------------------
print("<fieldset>");
print("<legend>Médications administrées</legend>");
print("<table bgcolor=\"#ccccff\" width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	//$aujourdhui = date("d/m/Y");
	$maintenant = strtotime("now");
	//print($maintenant);
	$date = date("d/m/Y",$maintenant);
	print("<TD>date <input type=\"text\" name=\"date\" size=\"10\" value=$date></TD>");
	$heure = date("H:i:s",$maintenant);
	print("<TD>heure <input type=\"text\" name=\"heure\" size=\"10\" value=$heure></TD>");
	print("<TD>dossier <input type=\"text\" name=\"dossier\" size=\"10\" value=$_GET[dossier]></TD>");
	print("<TD><div align=\"center\"><input type=\"submit\" name=\"valider\" value=\"valider\"></div></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Médicament ");
		liste_medicament($connexion,"0");//$ID_med
	print("</TD>");
	print("<TD>dose <input type=\"text\" name=\"dose\" size=\"10\" value=\"\"></TD>");
	print("<TD>mg</TD>");
	print("<TD>voie ");
		select_voie($connexion,$langue,$item_select,$onChange);
	print("</TD>");
print("</TR>");
print("</table>");
print("</fieldset>");

$ordre=$_GET['ordre'];
print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
	print("<tr>");
		print("<td><a href=\"bolus.php?tri=_date&dossier=$_GET[dossier]&ordre=$ordre\">date</a></td>");
		print("<td>heure</td>");
		print("<td><a href=\"bolus.php?tri=_med&dossier=$_GET[dossier]\">Médicament</a></td>");
		print("<td>Posologie</td>");
		print("<td>voie</td>");
	print("</tr>");
	switch($_GET['tri'])
	{
		case _date:
			if($ordre='ASC')$ordre='DESC';else $ordre='ASC';$tri="date";break;
		case _med:
			$tri="special_nom";break;
		default:
			$tri="date";$ordre='ASC';break;
	}
	$requete="SELECT date, med_ID,dose,dm_med.voie_ID,special_nom,voie_nom
				FROM dm_med,med_specialite ,dm_med_voie
				WHERE dossier_id='$_GET[dossier]' 
				AND special_ID=med_ID
				AND dm_med_voie.voie_ID = dm_med.voie_ID
				order by ";
				$requete .= $tri." ".$ordre
				;
	//print($requete);
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
		$fdate=uDate2French($rub['date']);
		print("<td>$fdate</td>");
		$fheure = uDate2Frenchtime($rub['date']);
		print("<td>$fheure</td>");
		print("<td>$rub[special_nom]</td>");
		print("<td><div align=\"right\">$rub[dose]</div></td>");
		print("<td>$rub[voie_nom]</td>");
	print("</tr>");
	}
print("</table>");
