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
//	programme: 			med_new_dispo.php							
//	date de création: 	08/12/2005								
//	auteur:				jcb									
//	description:		Nouivelle disponibilité du médecin	
//	version:			1.0									
//	maj le:				08/12/2005				
//													
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

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
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</HEAD>");

print("<BODY>");

print("<FORM name =\"dispo\"  ACTION=\"med_dispo_enregistre.php\" target=\"_blank\" METHOD=\"GET\">");
print("<Table width=\"100%\" class=\"time\">");
print("<TR>");
	print("<TD align=\"right\">Je suis: </TD>");
	print("<TD><input type=\"radio\" name=\"dispo\"  value=\"1\">disponible pour une urgence (SSM)</TD>");
print("</TR>");
print("<TR>");
	print("<TD>&nbsp;</TD>");
	print("<TD><input type=\"radio\" name=\"dispo\"  value=\"2\">disponible pour une visite</TD>");
print("</TR>");
print("<TR>");
	print("<TD>&nbsp;</TD>");
	print("<TD><input type=\"radio\" name=\"dispo\"  value=\"3\">disponible pour une consultation</TD>");
print("</TR>");
print("<TR>");
	print("<TD>&nbsp;</TD>");
	print("<TD><input type=\"radio\" name=\"dispo\"  value=\"4\">absent</TD>");
print("</TR>");
print("<TR>");
	print("<TD align=\"right\">du: </TD>");
	$today = date('d/m/Y',time());
	$hour = date('H:i',time());
	print("<TD><input TYPE=\"text\" VALUE=\"$today\" NAME=\"date1\" SIZE = \"10\"><input type='button' value='...' onClick=\"window.open('../calendrier/mycalendar.php?form=dispo&elem=date1','Calendrier','width=200,height=220')\">");
	print(" à partir de "); 
		menu_heure('heure1',8,0,5);
	print("heure</TD>");
print("</TR>");
print("<TR>");
	print("<TD align=\"right\">au: </TD>");
	//print("<TD><input type=\"text\" name=\"date2\"  value=\"$today\">");
	print("<TD><input TYPE=\"text\" VALUE=\"$today\" NAME=\"date2\" SIZE = \"10\"><input type='button' value='...' onClick=\"window.open('../calendrier/mycalendar.php?form=dispo&elem=date2','Calendrier','width=200,height=220')\">");
	print(" jusque "); 
		menu_heure('heure1',20,0,5);
	print("heure</TD>");
	//print(" jusque <input type=\"text\" name=\"heure2\"  size=\"5\" value=\"$hour\"> heure</TD>");
print("</TR>");
print("<TR>");
	print("<TD align=\"right\">je suis joignable au: </TD>");
	print("<TD><input type=\"text\" name=\"tel\"  value=\"06 18 89 99 12\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD align=\"right\">message au SAMU: </TD>");
	print("<TD><textarea name=\"msg\" rows=\"2\" cols=\"40\"></textarea></TD>");
print("</TR>");
print("<TR>");
	print("<TD>&nbsp;</TD>");
	print("<TD><input type=\"submit\" name=\"ok\" value=\"valider\"></textarea></TD>");
print("</TR>");
print("</Table>");

print("</FORM>");
print("</BODY>");
print("</HTML>");
?>