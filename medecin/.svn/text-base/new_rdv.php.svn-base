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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 			new_rdv.php
//	date de création: 	11/02/2006
//	auteur:				jcb
//	description:		Nouveau RDV pour un patient
//	version:			1.0
//	maj le:				11/02/2006
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require "../date.php";

function menu_heure($name,$debut_h,$debut_mn,$inc=5)
{
	print("<SELECT name=\"$name\" size=\"1\">");
	$debut= 0;
	$fin = 24;
	for($i=$debut;$i<$fin;$i++)
	{
		for($j=0;$j<60;$j+=$inc)
		{
			if($i<10)$h='0'.$i;else $h = $i;
			if($j < 10) $mn='0'.$j;else $mn=$j;
			if($i==$debut_h && $j==$debut_mn)
				print("<option selected>".$h.':'.$mn);
			else
				print("<option>".$h.':'.$mn);
		}
	}
	print("</SELECT>");
}

print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<LINK REL=stylesheet HREF=\"agenda.css\" TYPE =\"text/css\">");
print("</HEAD>");

print("<BODY>");

print("<form name=\"rdv\" action=\"rdv_enregistre.php?identifiant=$identifiant>");
$med_ID = addslashes($_REQUEST['medid']);// ID du médecin mg67 dont on lit la page d'agenda
print("<input type=\"hidden\" name=\"medid\" value = \"$med_ID\">");
print("<input type=\"hidden\" name=\"date\" value = \"$_GET[date]\">");

$identifiant = $_GET['id'];
if($identifiant)// il s'agit d'un Update
{
	require("../pma_connect.php");
	require("../pma_connexion.php");
	require("../pma_requete.php");
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete = "SELECT * FROM mg67_rdv WHERE rdv_ID = '$identifiant'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	$UPDATE = true;
	print("<input type=\"hidden\" name=\"medid\" value = \"$med_ID\">");
	print("<input type=\"hidden\" name = \"id_rdv\" value=\"$identifiant\">");
	print("<H3>Modifier / déplacer un rendez-vous</H3>");
}
else // nouveau RDV
{
	print("<H3>Nouveau rendez-vous</H3>");
	print("heure du rendez-vous: ".$_GET['h'].":".$_GET['m']."<br>");
	$heure_sql = $_GET['h'].":".$_GET['m'].":00";
	print("<input type=\"hidden\" name = \"date_rdv\" value=\"$_GET[date]\">");//passage de la date au format MySql
	print("<input type=\"hidden\" name = \"heure_rdv\" value=\"$heure_sql\">");//passage de la date au format MySql
	print("<input type=\"hidden\" name=\"medid\" value = \"$med_ID\">");
}


//print($date."<br>");
print("<table cellspacing=\"2\">");
	if(isset($UPDATE))
	{
		print("<tr>");
			$date = explode(' ',$rub['date_rdv']);// $date[0] = date, $date[1] = heure
			$today = usdate2fdate($date[0]);
			$hour = $date[1];
			print("<td>Date du rendez-vous</td>");
			//print("<td><input type=\"text\" name=\"date\" value=\"$today\"></td>");
			print("<TD><input TYPE=\"text\" VALUE=\"$today\" NAME=\"date_rdv\" SIZE = \"10\"><input type='button' value='...' onClick=\"window.open('../calendrier/mycalendar.php?form=rdv&elem=date_rdv','Calendrier','width=200,height=220')\">");
		print("</tr>");
		print("<tr>");
			print("<td>Heure du rendez-vous</td>");
			print("<td>");
				$time = explode(':',$hour);
				menu_heure('heure_rdv',$time[0],$time[1]);
			print("</td>");
		print("</tr>");
	}
	print("<tr>");
		print("<td>n° centaure15</td>");
		print("<td><input type=\"text\" name=\"no_samu\" value=\"$rub[no_samu]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>nom</td>");
		print("<td><input type=\"text\" name=\"nom\" value=\"$rub[nom]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>prénom</td>");
		print("<td><input type=\"text\" name=\"prenom\" value=\"$rub[prenom]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>tel</td>");
		print("<td><input type=\"text\" name=\"tel\" value=\"$rub[tel]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>age</td>");
		print("<td><input type=\"text\" name=\"age\" value=\"$rub[age]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>motif</td>");
		print("<td><input type=\"text\" name=\"motif\"value=\"$rub[motif]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"enregistrer\"></td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"annuler\"></td>");
	print("</tr>");
print("</table>");
print("</form>");
print("</BODY>");
print("</HTML>");
?>