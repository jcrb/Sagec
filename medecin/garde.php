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
//	programme: 			garde.php
//	date de création: 	11/02/2006
//	auteur:				jcb
//	description:		Agenda du médecin
//	version:			1.0
//	maj le:				11/02/2006
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require "../date.php";
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

//=============================================================================
//	SelectAdps()	Crée une liste déroulante avec la liste des secteurs ADPS
//					$connexion 		variable de connexion
//					$item_select	type_ID de l'état sélectionné
//		Au retour, $adps contient le type_ID
//=============================================================================
function SelectAdps($connexion,$item_select,$onChange="")
{
	$requete="SELECT secteur_adps_no,secteur_adps_nom FROM secteur_adps ORDER BY secteur_adps_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"adps\" size=\"1\" onChange='$onChange'>");
	$mot = "[aucun secteur]";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[secteur_adps_no]\" ");
		if($item_select == $rub['secteur_adps_no']) print(" SELECTED");
		print("> $rub[secteur_adps_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	SelectMedSecteur()	Crée une liste déroulante avec la liste des médecins
//					d'un secteur de PDS
//					$connexion 		variable de connexion
//					$secteur = n° du secteur concerné
//					$item_select	type_ID de l'état sélectionné
//		Au retour, $med contient le type_ID
//=============================================================================
function mois($select="",$onChange="")
{
	$m = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
	print("<select name=\"month\" size=\"1\" onChange='$onChange'>");
	for($i=0;$i<12;$i++)
	{
		$j = $i+1;
		if($j == $select)$c="selected";else $c="";
		print("<OPTION VALUE = \"$j\" $c>$m[$i]</OPTION> \n");
	}
	print("</SELECT>\n");
}
function SelectMedSecteur($connexion,$secteur,$item_select,$onChange="")
{
	$requete="SELECT med_ID,med_nom FROM mg67 WHERE secteur_pds_ID = '$secteur' ORDER BY med_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"med\" size=\"1\" onChange='$onChange'>");
	$mot = "[aucun médecin]";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[med_ID]\" ");
		if($item_select == $rub['med_ID']) print(" SELECTED");
		print("> $rub[med_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=============================================================================
//	calendar()	Affiche le calendrier correspondant au mois et à l'année précisé
//
//					$connexion 		variable de connexion
//					$tabgardes 	est un tableau contenant les jours qui doivent
//								êtres cochés
//		Le jour courant apparait en orange
//=============================================================================
function calendar($mois,$annee,$tabgardes)
{
	$date_time_array = getdate(time());
	$first_day = time()-24*60*60*($date_time_array['mday']-1);// datetime Unix du 1er jour du mois
	$date_time_first = getdate($first_day);// tableau de valeur pour le 1er jour
	$no_jour_first = $date_time_first['wday'];// n° du jour du 1er jour du mois

	$no_jour = $date_time_array['wday'];

	global $lesMois;

	$date_du_jour = getdate();
	// 1er du mois
	$pm = getdate(mktime(0,0,0,$mois,1,$annee));
	// jour correspondant au 1er du mois
	$num_premier_jour = $pm['wday'];

	$maxSemaine = 5;
	if($num_premier_jour==0)
	{
		$num_premier_jour = 7;
		$maxSemaine = 5;
	}

	//for($i=0;$i<sizeof($tabgardes);$i++)
	//	print_r("-->".$tabgardes[$i]."<br>");

	print("<table border=0 cellspacing=4 cellpadding=1>");
	print("<tr>\n");
	print("<tr>");
		print("<td align=center><b>Lu</font></b></td>");
		print("<td align=center><b>Ma</font></b></td>");
		print("<td align=center><b>Me</font></b></td>");
		print("<td align=center><b>Je</font></b></td>");
		print("<td align=center><b>Ve</font></b></td>");
		print("<td align=center><b>Sa</font></b></td>");
		print("<td align=center><b>Di</font></b></td>");
	print("</tr>");
	print("<tr>\n");

	$test=0;
	for($sem = 0; $sem < $maxSemaine; $sem++)
	{
		print("<tr>");
		for($j = 1; $j < 8; $j++)
		{
			$jourDuMois = 1-$num_premier_jour+$sem*7+$j;
			$unix_day = mktime(0,0,0,$mois,$jourDuMois,$annee);
			$jj = getdate($unix_day);//print($jourDuMois."== ".$unix_day."<br>");

			//if (in_array($tabgardes,$jj))// est ce que le médecin est de garde ce jour là. Si oui cocher la case
			if($tabgardes){
				if (in_array($unix_day,$tabgardes))
					$c = "checked";
				else
					$c="";
			}

			$lejour = $jj['mday'];
			if($lejour == 1)
			{
				$test = $test + 1;
				if($test >=2) $maxSem--;
			}
			$lemois = $lesmois[$mois-1];
			if($test == 1)
			{
				if($jj['yday']==$date_du_jour['yday'] && $annee==$date_du_jour['year'])
				{
					print("<td align=center bgcolor=orange>");
					print($lejour);
					print("<INPUT type=\"checkbox\" name=\"jour[]\" value=\"$lejour\" $c>");
				}
				else
				{
					print("<td align=center bgcolor=yellow>");
					print($lejour);
					print("<INPUT type=\"checkbox\" name=\"jour[]\" value=\"$lejour\" $c>");
				}
			}
			else
			{
				print("<td align=center bgcolor=red>");
				print("&nbsp;");
			}
			print("</td>");
		}
		print("</tr>\n");
	}
	print("</table>");
}
//=============================================================================
//	tableau_de_garde()	pour un secteur et une période donnés, recherche les
//						jours où le médecin est de garde
//			$connexion 		variable de connexion
//			$medecin		identifiant du médecin
//			$secteur		identifiant du secteur de PDS
//			$j_initial		début de la période (temps UNIX) = 1er jour du mois
//			$j_final		fin de la période = dernier jours du mois
//			$gardes 		est un tableau contenant les jours de garde
//
//=============================================================================
function tableau_de_garde($medecin,$secteur,$j_initial,$j_final)
{
	global $connexion;
	$requete = "SELECT date_debut FROM mg67_garde WHERE med_ID='$medecin' AND secteur_pds_ID='$secteur' AND date_debut BETWEEN'$j_initial'AND'$j_final' ";
	//print($requete."<br>");
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		$pm = getdate($rub['date_debut']);
		$gardes[] = mktime(0,0,0,$pm['mon'],$pm['mday'],$pm['year']);//calcule le jour de la garde à 0h)
	}
	return $gardes;
}

function affiche_gardes($medecin,$secteur,$mois,$annee,$jour)
{
// résumé de l'activité du médecin pour le mois
	print("Secteur n° ".$secteur."<br>");
	print("le docteur n° ".$medecin."<br>");
	print("est de garde: <br>");
	//print("garde: ");print_r($jour);
	for($i=0;$i<sizeof($jour);$i++)
	{
		//$j = date("j",$garde[$i]);
		$j = $jour[$i];
		$pm = getdate(mktime(0,0,0,$mois,$j,$annee));
		if($pm['wday']==0)// dimanche
		{
			$h_debut= mktime(8,0,0,$mois,$j,$annee);
			$h_fin = $h_debut + 24*60*60;
		}
		else
		{
			$h_debut= mktime(20,0,0,$mois,$j,$annee);
			$h_fin = $h_debut + 12*60*60;
		}
		print("du ".date("j/m/y H",$h_debut)." heures au ".date("j/m/y H",$h_fin)." heures<br>");
	}

}

function enregistre_tableau($medecin,$secteur,$jour,$mois,$annee)
{
	global $connexion;
	$j_initial = mktime(0,0,0,$mois,1,$annee);// 1er jour du mois (au format unix)
	$jour_mois=date("t",$j_initial);//nb de jours dans le mois
	$j_final = $j_initial + ($jour_mois)*24*60*60; // dernier jour du mois à minuit (au format unix)
	//print("dernier jour: ".date("j/m/Y h:i:s",$j_final));
	$requete = "DELETE FROM mg67_garde WHERE med_ID='$medecin'AND secteur_pds_ID='$secteur' AND date_debut BETWEEN '$j_initial' AND '$j_final'";
	$resultat = ExecRequete($requete,$connexion);
	/*
	$requete = "SELECT garde_ID FROM mg67_garde WHERE med_ID='$medecin' AND secteur_pds_ID='$secteur' AND date_debut='$h_debut' AND date_fin='$h_fin'";
	//$requete = "DELETE FROM mg67_garde WHERE med_ID='$medecin'AND secteur_pds_ID='$secteur' AND date_debut='$h_debut' AND date_fin='$h_fin'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	if(!$rub['garde_ID'])
	{
		$requete = "INSERT INTO mg67_garde VALUES('','$medecin','$secteur','$h_debut','$h_fin')";
		$resultat = ExecRequete($requete,$connexion);
	}
	*/
	for($i=0;$i<sizeof($jour);$i++)
	{
		//$j = date("j",$garde[$i]);
		$j = $jour[$i];
		$pm = getdate(mktime(0,0,0,$mois,$j,$annee));// ce jour à 0h
		if($pm['wday']==0)// dimanche, commence à 8h
		{
			$h_debut= mktime(8,0,0,$mois,$j,$annee);
			$h_fin = $h_debut + 24*60*60;
		}
		elseif($pm['wday']==6)// samedi, commence à 12h
		{
			$h_debut= mktime(12,0,0,$mois,$j,$annee);
			$h_fin = $h_debut + 12*60*60;
		}
		else // sinon commence à 20h
		{
			$h_debut= mktime(20,0,0,$mois,$j,$annee);
			$h_fin = $h_debut + 12*60*60;
		}
		$requete = "INSERT INTO mg67_garde VALUES('','$medecin','$secteur','$h_debut','$h_fin')";
		$resultat = ExecRequete($requete,$connexion);
	}

}

//=======================================================================================================
require("../html.php");
$a = "<a href=\"../blocnote_lire.php\">main courante</a>";
$b = "<a href=\"med_de_garde.php\">menu précédant</a>";
$c = "<a href=\"garde.php\">gardes</a>";
$menu = " | ".$a." | ".$b." | ";
$menu .=$c." | ";
entete_sagec2($titre="Médecin de garde du secteur","center","$menu");
print("<br>");

print("<form name=\"garde\" action=\"garde.php\">");
// variables
$jour = $_REQUEST['jour'];	// tableau contenant l'indice des jours où le médecin est de garde (voir calendrier)
$mois = $_REQUEST['month'];	// mois
$annee = 2006;				// année
$secteur = $_REQUEST['adps'];// n° du secteur de garde
$medecin = $_REQUEST['med'];	// identifiant du médecin
$gardes = array();// tableau pour stocker les jours de gardes (au format unix)
// variables déduites
$j_initial = mktime(0,0,0,$mois,1,$annee);// 1er jour du mois (au format unix)
$jour_mois=date("t",$j_initial);//nb de jours dans le mois
$j_final = $j_initial + ($jour_mois)*24*60*60; // dernier jour du mois à minuit (au format unix)

// selection du secteur de pds
SelectAdps($connexion,$_REQUEST['adps'],'document.garde.submit()');
// la sélection provoque un réffichage de la page qui permet de sélectionner les médecins du secteur
if($_REQUEST['adps'])
{
	SelectMedSecteur($connexion,$_REQUEST['adps'],$_REQUEST['med'],$onChange="document.garde.submit()");
}
// sélection du mois
mois($_REQUEST['month'],'document.garde.submit()');
// récupérer c que l'on a déjà
if($_REQUEST['month'])
{
	if($medecin && $secteur)
	{
		$gardes = tableau_de_garde($medecin,$secteur,$j_initial,$j_final);
		calendar($_REQUEST['month'],$annee,$gardes);
		affiche_gardes($medecin,$secteur,$mois,$annee,$jour);
	}
}
// validation générale
print("<input type=\"submit\" name=\"ok\" value=\"valider\" onClick=\"document.garde.submit()\">");
print("<input type=\"submit\" name=\"write\" value=\"enregistrer\" onClick=\"document.garde.submit()\">");
print("<br>");



if($_REQUEST['ok'])
{
	//$gardes = tableau_de_garde($medecin,$secteur,$j_initial,$j_final);
	// dessine le calendrier à partir du mis, de l'année et des gardes déjà prises
	//calendar($_REQUEST['month'],$annee,$gardes);
	//affiche_gardes($medecin,$secteur,$mois,$annee,$jour);
}
if($_REQUEST['write'])
{
	$gardes = tableau_de_garde($medecin,$secteur,$j_initial,$j_final);
	// dessine le calendrier à partir du mis, de l'année et des gardes déjà prises
	//calendar($_REQUEST['month'],$annee,$gardes);
	//affiche_gardes($medecin,$secteur,$mois,$annee,$jour);
	enregistre_tableau($medecin,$secteur,$jour,$mois,$annee);
}

print("</form>");
?>