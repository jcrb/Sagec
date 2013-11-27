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
/** sauvegarde_TXT.php
* 	enregistre les données du dernier évènement courant dans le fichier administrateur/sauvegarde
*	Idem que Sauvegarde.php sauf que rien n'apparait à l'écran
*	date de création: 	10/11/2004		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
*	maj le:				14/08/2006	
* 	@TODO: vérifier si tout est sauvegardé 
*	@package			sagec
*
* 	TOUTE MODIF DE CE FICHIER DOIT ETRE REPORTEE DANS SAUVEGARDE.PHP
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once("../pma_connect.php");
require_once("../pma_connexion.php");
require_once '../utilitaires/requete.php';
//require_once("../html.php");
require_once("../date.php");

function sauvegarde_txt()
{
$tab = "\t";
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
$d = date("j_m_Y");
$sauvegarde = "sauvegarde_".$_SESSION[evenement].".txt";
$fp = fopen("$sauvegarde","w");
setlocale(LC_TIME,"french");
$dateFR = strFTime("%A %d %B %Y");
fwrite($fp,"Date: ".$dateFR." à ".date("H:i")."\n");

//----------------------------- Caractéristiques de l'évènement -------------------------------------------

fwrite($fp,"//================================= Evènement courant ================================"."\n");

$requete = "SELECT * FROM evenement WHERE evenement_ID = '$_SESSION[evenement]'";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);
fwrite($fp,"Evènement courant: ");
fwrite($fp,$rub[evenement_nom]."  ");
fwrite($fp,"le ".$rub[evenement_date1]."  ");
fwrite($fp,", à ".$rub[evenement_heure1]."\n");

fwrite($fp,"Plans déclenchés: ");
	$requete = 	"SELECT plan_nom,plan_courant_ID,titre,date1,date2
					FROM plan_courant,plan
					WHERE evenement_ID = '$_SESSION[evenement]'
					AND plan_courant.plan_ID = plan.plan_ID
					ORDER BY date1
					";
		$resultat = ExecRequete($requete,$connect);
		while($rub=mysql_fetch_array($resultat))
		{
			fwrite($fp,"plan :".$rub[titre]." ");
			fwrite($fp,"déclenché le :".$rub[date1]." ");
			fwrite($fp,"levé le :".$rub[date2]."\n");
		}
fwrite($fp,"\n");
//--------------------------------- Sauvegarde des structures -----------------------------------------------
fwrite($fp,"//================================= Structures Activées ================================"."\n");
$requete = 	"SELECT ts_nom,ts_localisation,ts_contact FROM temp_structure WHERE ts_active='o' ORDER BY ts_type";
$resultat = ExecRequete($requete,$connect);

while($rub=mysql_fetch_array($resultat))
{
		fwrite($fp," - ".$rub[ts_nom]." ");
		fwrite($fp," localisation: ".$rub[ts_localisation]." ");
		fwrite($fp," contacts: ".$rub[ts_contact]."\n");
}
fwrite($fp,"\n");
//--------------------------------- Sauvegarde des missions -----------------------------------------------
fwrite($fp,"//================================= Missions ================================"."\n");
$requete = "SELECT perso_affectation.*,Pers_nom,Pers_prenom,perso_cat_nom,org_nom,service_nom,fonction_nom
						FROM perso_affectation,personnel,perso_cat,organisme,service,fonction
						WHERE perso_affectation.affectation_ID = personnel.Pers_ID
						AND personnel.perso_cat_ID = perso_cat.perso_cat_ID
						AND personnel.org_ID = organisme.org_ID
						AND personnel.service_ID = service.service_ID
						AND perso_affectation.fonction_ID = fonction.fonction_ID
						";
$resultat = ExecRequete($requete,$connect);
while($rub=mysql_fetch_array($resultat))
{
		fwrite($fp," - ".$rub[fonction_nom].": ");
		fwrite($fp,$rub[Pers_nom]." ");
		fwrite($fp,$rub[Pers_prenom]."\n");
}
fwrite($fp,"\n");
//--------------------------------- Sauvegarde des moyens engagés -----------------------------------------------

fwrite($fp,"//================================= Sauvegarde des moyens engagés ================================"."\n");
$requete="SELECT * FROM vecteur WHERE Vec_Engage = 'o' ORDER BY Vec_Type";
$result = ExecRequete($requete,$connect);
while($i = LigneSuivante($result))
{
	fwrite($fp,$i->Vec_ID.$tab.$i->Vec_Nom.$tab."\n");
}
fwrite($fp,"\n");
//--------------------------------- Sauvegarde de l'organigramme -----------------------------------------------

fwrite($fp,"//================================= Sauvegarde de l'organigramme ================================"."\n");
$requete = "SELECT Pers_ID,Pers_Nom,Pers_Prenom,perso_cat_nom,local_nom
			FROM personnel,perso_cat,localisation,perso_affectation
			WHERE perso_affectation.location_ID > '0'
			AND personnel.perso_cat_ID = perso_cat.perso_cat_ID
			AND perso_affectation.location_ID = localisation.localisation_ID
			ORDER BY perso_affectation.location_ID";
$resultat = ExecRequete($requete,$connect);
while($rub=mysql_fetch_array($resultat))
{
	fwrite($fp,$rub[local_nom].$tab.$rub[Pers_Nom]." ".$rub[Pers_Prenom].$tab." (".$rub[perso_cat_nom].")\n");
}
fwrite($fp,"\n");
//--------------------------------- Répartition dans les hôpitaux -----------------------------------------------
fwrite($fp,"//========================= Répartition dans les hôpitaux ====================="."\n");
$requete="SELECT gravite, Hop_nom
					FROM victime, hopital
					WHERE victime.Hop_ID = hopital.Hop_ID
					ORDER by gravite
		";
$resultat = ExecRequete($requete,$connect);
$nombre = array();
while($rub=mysql_fetch_array($resultat))
{
	$nombre[$rub['Hop_nom']][$rub['gravite']]++;
}
$gravite = array();
$color=array("#009999","#f48b809","#ffff80","#8bf878","#999999","#dde6ee");

fwrite($fp,"U / UA / UR / U3 / DCD "."\n");
// lignes

while(list($hop) = each($nombre))
{
	while(list($g,$n) = each($nombre[$hop]))
	{
		if($hop_courant != $hop)
		{
			if($hop_courant !="")
			{
				fwrite($fp,$hop_courant." ");
				$total=0;
				for($i=0; $i<5;$i++)
				{
					if($gravite[$i]==0)
					{
						fwrite($fp,"0 / ");
					}
					else
					{
						fwrite($fp,$gravite[$i]." / ");
						$total = $total +$gravite[$i];
						$total_general[$i]+=$gravite[$i];
						$gravite[$i]=0;
					}
				}
				fwrite($fp," total: ".$total);
				fwrite($fp,"\n");
				$total_general[5]+=$total;
			}
			$hop_courant = $hop;
			$gravite[$g]=$n;
		}
		else
		{
			$gravite[$g]=$n;
		}
	}
}

	$total = 0;
	for($i=0; $i<5;$i++)
	{
		if($gravite[$i]==0)
		{
			fwrite($fp,"0 / ");
		}
		else
		{
			fwrite($fp,$gravite[$i]." / ");
			$total = $total +$gravite[$i];
			$total_general[$i]+=$gravite[$i];
			$gravite[$i]=0;
		}
	}

fwrite($fp,"\n");
$total_general[5]+=$total;

	fwrite($fp,"Total Général  ");
	for($i=0;$i<6;$i++)
	{
		fwrite($fp,$total_general[$i]." / ");
	}
fwrite($fp,"\n");

//--------------------------------- Sauvegarde du bloc note -----------------------------------------------

fwrite($fp,"//==================================== Sauvegarde du bloc-note =================================="."\n");
$requete="SELECT LB_ID,LB_Date,LB_Expediteur,LB_Message,nom
		FROM livrebord,utilisateurs
		WHERE LB_Expediteur = ID_utilisateur
		ORDER BY LB_Date ASC";
$result = ExecRequete($requete,$connect);
while($i = LigneSuivante($result))
{
	fwrite($fp,$i->LB_ID.$tab.$i->LB_Date.$tab.$i->nom.$tab.$i->LB_Message."\n");
}
fwrite($fp,"\n");
print("<br>");

fwrite($fp,"//======================================== Fin des données ======================================="."\n");
fclose($fp);
}
?>
