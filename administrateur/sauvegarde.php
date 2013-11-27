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
//--------------------------------------------------------------------------------------------------------
/** sauvegarde.php
* 	enregistre les donn�es du dernier �v�nement courant dans le fichier administrateur/sauvegarde
*	date de cr�ation: 	10/11/2004		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
*	maj le:				14/08/2006	
* 	@TODO: v�rifier si tout est sauvegard� 
*	@package			sagec
*
* 	TOUTE MODIF DE CE FICHIER DOIT ETRE REPORTEE DANS SAUVEGARDE_TXT.PHP
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("../date.php");
$tab = "\t";

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
$d = date("j_m_Y");
$sauvegarde = "sauvegarde_".$_SESSION[evenement].".txt";
$fp = fopen("$sauvegarde","w");
setlocale(LC_TIME,"french");
$dateFR = strFTime("%A %d %B %Y");
fwrite($fp,"Date: ".$dateFR." � ".date("H:i")."\n");

//----------------------------- Caract�ristiques de l'�v�nement -------------------------------------------

fwrite($fp,"//================================= Ev�nement courant ================================"."\n");

$requete = "SELECT * FROM evenement WHERE evenement_ID = '$_SESSION[evenement]'";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD>Ev�nement courant</TD>");fwrite($fp,"Ev�nement courant: ");
	print("<TD><B>$rub[evenement_nom]</B></TD>");fwrite($fp,$rub[evenement_nom]."  ");
	print("<TD> le $rub[evenement_date1]</TD>");fwrite($fp,"le ".$rub[evenement_date1]."  ");
	print("<TD> � $rub[evenement_heure1]</TD>");fwrite($fp,", � ".$rub[evenement_heure1]."\n");
print("</TR>");
print("</table><br>");

print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
print("<TR>");
	print("<TD>Plans d�clench�s</TD>");fwrite($fp,"Plans d�clench�s: ");
	print("<TD>");
		print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
		print("<TR>");
			print("<TD>Plan</TD>");
			print("<TD>Titre</TD>");
			print("<TD>Activ�</TD>");
			print("<TD>Lev�</TD>");
		print("</TR>");
		$requete = 	"SELECT plan_nom,plan_courant_ID,titre,date1,date2
					FROM plan_courant,plan
					WHERE evenement_ID = '$_SESSION[evenement]'
					AND plan_courant.plan_ID = plan.plan_ID
					ORDER BY date1
					";
		$resultat = ExecRequete($requete,$connect);
		while($rub=mysql_fetch_array($resultat))
		{
			print("<TR>");
			//print("<TD>$rub[plan_nom]</TD>");
			print("<TD><A HREF=\"evenement_plan.php?maj=$rub[plan_courant_ID]\">$rub[plan_nom]</A></TD>");;
			print("<TD>$rub[titre]</TD>");fwrite($fp,"plan :".$rub[titre]." ");
			print("<TD>".usdate2fdate($rub['date1'])."</TD>");fwrite($fp,"d�clench� le :".$rub[date1]." ");
			print("<TD>".usdate2fdate($rub['date2'])."</TD>");fwrite($fp,"lev� le :".$rub[date2]."\n");
			print("</TR>");
		}
		print("</table>");
	print("</TD>");
print("</TR>");
print("</table><br>");
fwrite($fp,"\n");
//--------------------------------- Sauvegarde des structures -----------------------------------------------
fwrite($fp,"//================================= Structures Activ�es ================================"."\n");
$requete = 	"SELECT ts_nom,ts_localisation,ts_contact FROM temp_structure WHERE ts_active='o' ORDER BY ts_type";
$resultat = ExecRequete($requete,$connect);
print("Structures activ�es<br>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
while($rub=mysql_fetch_array($resultat))
{
	print("<TR>");
		print("<TD>$rub[ts_nom]</TD>");fwrite($fp," - ".$rub[ts_nom]." ");
		print("<TD>$rub[ts_localisation]</TD>");fwrite($fp," localisation: ".$rub[ts_localisation]." ");
		print("<TD>$rub[ts_contact]</TD>");fwrite($fp," contacts: ".$rub[ts_contact]."\n");
	print("</TR>");
}
print("</table><br>");
fwrite($fp,"\n");
//--------------------------------- Sauvegarde des missions -----------------------------------------------
fwrite($fp,"//================================= Missions ================================"."\n");
$requete = "SELECT Pers_nom,Pers_prenom,fonction_nom
						FROM personnel,fonction
						WHERE personnel.Pers_fonction IS NOT NULL
						AND personnel.Pers_fonction = fonction.fonction_ID
						";
$resultat = ExecRequete($requete,$connect);
print("<br>Missions<br>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
while($rub=mysql_fetch_array($resultat))
{
	print("<TR>");
		print("<TD>$rub[fonction_nom]</TD>");fwrite($fp," - ".$rub[fonction_nom].": ");
		print("<TD>$rub[Pers_nom]</TD>");fwrite($fp,$rub[Pers_nom]." ");
		print("<TD>$rub[Pers_prenom]</TD>");fwrite($fp,$rub[Pers_prenom]."\n");
	print("</TR>");
}
print("</table><br>");
fwrite($fp,"\n");
//--------------------------------- Sauvegarde des moyens engag�s -----------------------------------------------
print("<br>Moyens engag�s<br>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");

fwrite($fp,"//================================= Sauvegarde des moyens engag�s ================================"."\n");
$requete="SELECT * FROM vecteur WHERE Vec_Engage = 'o' ORDER BY Vec_Type";
$result = ExecRequete($requete,$connect);
while($i = LigneSuivante($result))
{
	print("<TR>");
	fwrite($fp,$i->Vec_ID.$tab.$i->Vec_Nom.$tab."\n");
	print("<TD>$i->Vec_ID</TD>");
	print("<TD>$i->Vec_Nom</TD>");
	print("</TR>");
}
fwrite($fp,"\n");
print("</table>");
print("<br>");
//--------------------------------- Sauvegarde de l'organigramme -----------------------------------------------
print("<br>Personnels engag�s (SAMU 67)<br>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");

fwrite($fp,"//================================= Sauvegarde de l'organigramme ================================"."\n");
$requete = "SELECT Pers_ID,Pers_Nom,Pers_Prenom,perso_cat_nom,personnel.localisation_ID,local_nom
			FROM personnel,perso_cat,localisation
			WHERE personnel.localisation_ID > '0'
			AND personnel.perso_cat_ID = perso_cat.perso_cat_ID
			AND personnel.localisation_ID = localisation.localisation_ID
			ORDER BY personnel.localisation_ID";
//$resultat = ExecRequete($requete,$connect);
while($rub=mysql_fetch_array($resultat))
{
	print("<TR>");
	fwrite($fp,$rub[local_nom].$tab.$rub[Pers_Nom]." ".$rub[Pers_Prenom].$tab." (".$rub[perso_cat_nom].")\n");
	print("<TD>$rub[local_nom]</TD>");
	print("<TD>$rub[Pers_Nom]</TD>");
	print("<TD>$rub[Pers_Prenom]</TD>");
	print("<TD>$rub[perso_cat_nom]</TD>");
	print("</TR>");
}
print("</table>");
print("<br>");
fwrite($fp,"\n");
//--------------------------------- R�partition dans les h�pitaux -----------------------------------------------
fwrite($fp,"//========================= R�partition dans les h�pitaux ====================="."\n");
$requete="SELECT gravite, Hop_nom
					FROM victime, hopital
					WHERE victime.Hop_ID = hopital.Hop_ID
					ORDER by gravite
		";
$resultat = ExecRequete($requete,$connect);
$nombre = array();
while($rub=mysql_fetch_array($resultat))
{
	//print("<TR><TD>x $rub[gravite]  $rub[org_nom]</TD></TR>");
	$nombre[$rub['Hop_nom']][$rub['gravite']]++;
}
$gravite = array();
$color=array("#009999","#f48b809","#ffff80","#8bf878","#999999","#dde6ee");

print("<fieldset>");
print("<legend><font face=\"arial\" size=\"2\">R�partition des victimes dans les h�pitaux</font></legend>");
print("<Table  width=\"75%\" BORDER=\"0\" CELLSPACING=\"1\" CELLPADDING=\"0\">");
// en t�te du tableau
print("<TR>");
print("<TD WIDTH=\"300\" BGCOLOR=\"#dde6ee\">&nbsp;</TD>");
print("<TD WIDTH=\"45\" bgcolor=\"#000099\"><CENTER><B><FONT COLOR=\"#ffffff\" size=\"4\" FACE=\"arial\">U</B></FONT></TD>");
print("<TD WIDTH=\"45\" bgcolor=\"#ff0000\"><CENTER><B><FONT COLOR=\"#ffffff\" FACE=\"arial\">UA</B></FONT></TD>");
print("<TD WIDTH=\"45\" bgcolor=\"#ffff00\"><CENTER><B><FONT COLOR=\"#000000\" FACE=\"arial\">UR</B></FONT></TD>");
print("<TD WIDTH=\"45\" bgcolor=\"#00ff00\"><CENTER><B><FONT COLOR=\"#000000\" FACE=\"arial\">U3</B></FONT></TD>");
print("<TD WIDTH=\"45\" bgcolor=\"#000000\"><CENTER><B><FONT COLOR=\"#ffffff\" FACE=\"arial\">DCD</B></FONT></D>");
print("<TD WIDTH=\"80\" bgcolor=\"#dde6ee\"><CENTER><B><FONT COLOR=\"#000000\" FACE=\"arial\">Total</B></FONT></TD>");
print("</TR>");fwrite($fp,"U / UA / UR / U3 / DCD "."\n");
// lignes

while(list($hop) = each($nombre))
{
	while(list($g,$n) = each($nombre[$hop]))
	{
		if($hop_courant != $hop)
		{
			if($hop_courant !="")
			{
				print("<TR>");
				print("<TD WIDTH=\"300\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\">$hop_courant</font></TD>");fwrite($fp,$hop_courant." ");
				$total=0;
				for($i=0; $i<5;$i++)
				{
					if($gravite[$i]==0)
					{
						print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><CENTER>&nbsp;</TD>");
						fwrite($fp,"0 / ");
					}
					else
					{
						print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><FONT size=\"2\"><CENTER>$gravite[$i]</font></TD>");
						fwrite($fp,$gravite[$i]." / ");
						$total = $total +$gravite[$i];
						$total_general[$i]+=$gravite[$i];
						$gravite[$i]=0;
					}
				}
				print("<TD WIDTH=\"80\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"><CENTER>$total</font></TD>");
				fwrite($fp," total: ".$total);
				print("</TR>");fwrite($fp,"\n");
				$total_general[5]+=$total;
			}
			$hop_courant = $hop;
			$gravite[$g]=$n;
		}
		else
		{
			$gravite[$g]=$n;
		}
		//print("<TR><TD> $hop $g $n</TD></TR>");
	}
}
print("<TR>");
	print("<TD WIDTH=\"\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"> $hop_courant</font></TD>");
	$total = 0;
	for($i=0; $i<5;$i++)
	{
		if($gravite[$i]==0)
		{
			print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><CENTER>&nbsp;</TD>");
			fwrite($fp,"0 / ");
		}
		else
		{
			print("<TD WIDTH=\"45\" bgcolor=\"$color[$i]\"><FONT size=\"2\"><CENTER>$gravite[$i]</font></TD>");
			fwrite($fp,$gravite[$i]." / ");
			$total = $total +$gravite[$i];
			$total_general[$i]+=$gravite[$i];
			$gravite[$i]=0;
		}
	}
	print("<TD WIDTH=\"80\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"><CENTER>$total</font></TD>");
print("</TR>");fwrite($fp,"\n");
$total_general[5]+=$total;
print("<TR>");
	print("<TD WIDTH=\"\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"> &nbsp;</font></TD>");
	fwrite($fp,"Total G�n�ral  ");
	for($i=0;$i<6;$i++)
	{
		print("<TD WIDTH=\"\" BGCOLOR=\"#dde6ee\"><FONT size=\"2\"><CENTER>$total_general[$i]</font></TD>");
		fwrite($fp,$total_general[$i]." / ");
	}
print("</TR>");fwrite($fp,"\n");
print("</Table>");
print("</fieldset>");
fwrite($fp,"\n");
//--------------------------------- Sauvegarde du bloc note -----------------------------------------------
print("<br>Main courante<br>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");

fwrite($fp,"//==================================== Sauvegarde du bloc-note =================================="."\n");
$requete="SELECT LB_ID,LB_Date,LB_Expediteur,LB_Message,nom
		FROM livrebord,utilisateurs
		WHERE LB_Expediteur = ID_utilisateur
		ORDER BY LB_Date ASC";
$result = ExecRequete($requete,$connect);
while($i = LigneSuivante($result))
{
	print("<TR>");
	fwrite($fp,$i->LB_ID.$tab.$i->LB_Date.$tab.$i->nom.$tab.$i->LB_Message."\n");
	print("<TD>$i->LB_ID</TD>");
	print("<TD>$i->LB_Date</TD>");
	print("<TD>$i->nom</TD>");
	print("<TD>$i->LB_Message</TD>");
	print("</TR>");
}
print("</table>");
fwrite($fp,"\n");
print("<br>");

fwrite($fp,"//======================================== Fin des donn�es ======================================"."\n");
fclose($fp);
?>
