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
//	programme: 		cron_reglage.php
//	date de création: 	15/05/2005
//	auteur:			jcb
//	description:		Front end pour définir les paramètres des envois
//	version:			1.0
//	maj le:			15/05/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
require("../../date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
print("<title> cron réglages </title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<FORM name=\"cron_saisie\" action=\"cron_enregistre.php\" method=\"post\">");
$requete = "SELECT * FROM cron";
$resultat = ExecRequete($requete,$connexion);
$rub = mysql_fetch_array($resultat);

print("<h3>Réglage des paramètres d'extraction</h3>");

print("<table>");
	print("<tr>");
		print("<td>heure d'activation</td>");
		print("<td>");
			print("<select name=\"heure\"size=\"1\">");
			for($h=0;$h<24;$h++){
				if($h==$rub['cron_heure']) $s='SELECTED';else $s='';
				print("<option value=\"$h\" $s> $h");
			}
			print("</select>");
			print("h");
			print("<select name=\"minute\"size=\"1\">");
			for($h=0;$h<60;$h++){
				if($h==$rub['cron_minute']) $s='SELECTED';else $s='';
				print("<option value=\"$h\" $s> $h");
			}
			print("</select>");
		print("</td>");
		print("</tr>");
		print("<tr>");
		print("<td>jour d'activation</td>");
		print("<td>");
			print("<select name=\"jour\"size=\"1\">");
				print("<option value=\"7\"");if($rub['cron_jour']==7)print('SELECTED');print(">tous les jours");
				print("<option value=\"1\"");if($rub['cron_jour']==1)print('SELECTED');print(">lundi");
				print("<option value=\"2\"");if($rub['cron_jour']==2)print('SELECTED');print(">mardi");
				print("<option value=\"3\"");if($rub['cron_jour']==3)print('SELECTED');print(">mercredi");
				print("<option value=\"4\"");if($rub['cron_jour']==4)print('SELECTED');print(">jeudi");
				print("<option value=\"5\"");if($rub['cron_jour']==5)print('SELECTED');print(">vendredi");
				print("<option value=\"6\"");if($rub['cron_jour']==6)print('SELECTED');print(">samedi");
				print("<option value=\"0\"");if($rub['cron_jour']==0)print('SELECTED');print(">dimanche");
			print("</select>");
		print("</td>");
	print("</tr>");
	print("<tr>");
		print("<td>adresse d'envoi</td>");
		print("<td><input type=\"text\" name=\"url\" size=\"30\" value=\"$rub[cron_adresse]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>login</td>");
		print("<td><input type=\"text\" name=\"login\" size=\"30\" value=\"$rub[cron_login]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>password</td>");
		print("<td><input type=\"password\" name=\"pass\" size=\"30\" value=\"$rub[cron_password]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>date 1 (défaut = hier)</td>");
		$hier = date("Y/m/j",mktime(0,0,0,date('m'),date('d')-1,date('Y')));
		print("<td><input type=\"text\" name=\"date1\" size=\"15\" value=\"$hier\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>date 2 (défaut = J-7)</td>");
		$j7 = date("Y/m/j",mktime(0,0,0,date('m'),date('d')-7,date('Y')));
		print("<td><input type=\"text\" name=\"date2\" size=\"15\" value=\"$j7\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>intervalle entre 2 dates</td>");
		print("<td><input type=\"text\" name=\"intervalle\" size=\"2\" value=\"$rub[cron_intervalle]\"> jours</td>");
	print("</tr>");
	print("<tr>");
		print("<td>extraction automatique</td>");
		print("<td><input type=\"submit\" name=\"start1\" value=\"start\">");
		if($rub['cron_auto']=='o')print(" activée");else print(" inactivée");print("</td>");
		print("<td><input type=\"submit\" name=\"stop1\" value=\"stop\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>extraction manuelle</td>");
		print("<td><input type=\"submit\" name=\"start2\" value=\"start\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>Sauvegarde des paramètres</td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"  OK  \"></td>");
	print("</tr>");
print("</table>");
print("</FORM>");
print("</html>");
?>
