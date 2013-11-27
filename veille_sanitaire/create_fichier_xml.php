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
//	programme: 		create_fichier_xml.php
//	date de création: 	07/06/2007
//	auteur:			jcb
//	description:	crée un fichier XML selon les specifications de l'INVS et affiche son contenu
//	version:		1.0
//	maj le:			
//
/**
 *
 * create_xml.php
 *
 * crée un fichier XML selon les specifications de l'INVS
 * @author jcb <jcb-bartierg@wanadoo.fr>
 * @version 1.0 $Id: create_xml.php 21 2007-02-13 22:30:12Z jcb $
 * @package Sagec
 */
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("cryptage_gpg.php");
include("sagec_ftp.php");
include("../date.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
*=========================================================================================================
*/
/**
 * Retourne les lits disponibles par spécialité avec un historique des n derniers jours
 * 
 * @param string $connexion paramètre de connexion à Mysql
 * @param string $date1 date la plus ancienne
 * @param string $date2 date la plus récente
 * @param array $type_service tableau de valeurs $rea = "2,4" (Réa + SI)
 * @param string $quote valeur du tag sans les chevrons. Par par ex.litsRea pour <litsRea>
 * @return text 
 */
function litsDispoParSpecialite_hopital($connexion,$date1,$date2,$type_service,$quote)
{
	$requete = "SELECT date,lits_journal.service_ID,lits_dispo,service_nom,Hop_nom,Hop_finess
				FROM lits_journal, service,hopital,ville,adresse
				WHERE lits_journal.service_ID = service.service_ID
				AND date BETWEEN '$date1' and '$date2'
				AND service.Type_ID IN ($type_service)
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				ORDER BY Hop_nom,date,service_nom
				";
	$resultat = ExecRequete($requete,$connexion);

	$rub=mysql_fetch_array($resultat);
	$texte="<ETAB_SERV>";
		$texte.="<DESCSERV>";
			$texte.="<id_etab>".$rub['Hop_finess']."</id_etab>";      // n° Finess de l'établissement'
			//$texte.="<id_serv>".$rub['Hop_nom']."</id_serv>";      // ID du service. N°Sagec A SUPPRIMER
		$texte.="</DESCSERV>";
			$texte.="<INDICATEURS>";

		$hop_courant = $rub['Hop_nom'];
		$tot=array();
		$j = 0;
		$tot[$j] += $rub['lits_dispo'];
		$date_courante= date("Y/m/d",$rub['date']);
		$lits = $rub['lits_dispo'];//$texte.="<LIT1>".$date_courante."**".$lits."</LIT1>";

	while($rub=mysql_fetch_array($resultat))
	{
		if($hop_courant == $rub['Hop_nom'])
		{
			if($date_courante == date("Y/m/d",$rub['date']))
			{
				$lits += $rub['lits_dispo'];
			}
			else
			{
				$texte.="<JOURNEE>";
					$texte.="<jour>".$date_courante."</jour>";
					$date = date("Y/m/d",$rub['date']);
					//$texte.="<id_serv>".$rub['Hop_nom']."</id_serv>";// A SUPPRIMER
					$texte.="<$quote>".$lits."</$quote>";
				$texte.="</JOURNEE>";
				$tot[$j] += $lits;
				$lits = $rub['lits_dispo'];
				
				$date_courante = date("Y/m/d",$rub['date']);
				$j++;
			}
		}
		else
		{
				$texte.="<JOURNEE>";$date_precedante = $date;
					$texte.="<jour>".$date_courante."</jour>";
					$texte.="<$quote>".$lits."</$quote>";
				$texte.="</JOURNEE>";
			$texte.="</INDICATEURS>";
		$texte.="</ETAB_SERV>";
		$date = date("Y/m/d",$rub['date']);
		$date_courante = date("Y/m/d",$rub['date']);
		$tot[$j] += $lits;

		$texte.="<ETAB_SERV>";
			$texte.="<DESCSERV>";
				$texte.="<id_etab>".$rub['Hop_finess']."</id_etab>";      // n° Finess de l'établissement'
				//$texte.="<id_serv>".$rub['Hop_nom']."</id_serv>";      // ID du service. N°Sagec A SUPPRIMER
			$texte.="</DESCSERV>";
			$texte.="<INDICATEURS>";
		$hop_courant = $rub['Hop_nom'];
		$lits = $rub['lits_dispo'];
		$j = 0;
		}
	}
		$texte.="</INDICATEURS>";
	$texte.="</ETAB_SERV>";
	return $texte;
}
/**
*=========================================================================================================
*/
/**
 * Retourne les places disponibles par spécialité avec un historique des n derniers jours
 * 
 * @param string $connexion paramètre de connexion à Mysql
 * @param string $date1 date la plus ancienne
 * @param string $date2 date la plus récente
 * @param string $quote valeur du tag sans les chevrons. Par par ex.litsRea pour <litsRea>
 * @return text 
 */
function placesDispoParSpecialite_hopital($connexion,$date1,$date2,$quote)
{
	$requete = "SELECT date,places_journal.service_ID,places_dispo,service_nom,Hop_nom,Hop_finess
				FROM places_journal, service,hopital,ville,adresse
				WHERE places_journal.service_ID = service.service_ID
				AND date BETWEEN '$date1' and '$date2'
				AND service.Hop_ID = hopital.Hop_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				ORDER BY Hop_nom,date,service_nom
				";
	$resultat = ExecRequete($requete,$connexion);

	$rub=mysql_fetch_array($resultat);
	$texte="<ETAB_SERV>";
		$texte.="<DESCSERV>";
			$texte.="<id_etab>".$rub['Hop_finess']."</id_etab>";      // n° Finess de l'établissement'
			//$texte.="<id_serv>".$rub['Hop_nom']."</id_serv>";      // ID du service. N°Sagec A SUPPRIMER
		$texte.="</DESCSERV>";
			$texte.="<INDICATEURS>";

		$hop_courant = $rub['Hop_nom'];
		$tot=array();
		$j = 0;
		$tot[$j] += $rub['lits_dispo'];
		$date_courante= date("Y/m/d",$rub['date']);
		$places = $rub['places_dispo'];//$texte.="<LIT1>".$date_courante."**".$lits."</LIT1>";

	while($rub=mysql_fetch_array($resultat))
	{
		if($hop_courant == $rub['Hop_nom'])
		{
			if($date_courante == date("Y/m/d",$rub['date']))
			{
				$places += $rub['places_dispo'];
			}
			else
			{
				$texte.="<JOURNEE>";
					$texte.="<jour>".$date_courante."</jour>";
					$date = date("Y/m/d",$rub['date']);
					//$texte.="<id_serv>".$rub['Hop_nom']."</id_serv>";// A SUPPRIMER
					$texte.="<$quote>".$lits."</$quote>";
				$texte.="</JOURNEE>";
				$tot[$j] += $lits;
				$places = $rub['places_dispo'];
				
				$date_courante = date("Y/m/d",$rub['date']);
				$j++;
			}
		}
		else
		{
				$texte.="<JOURNEE>";$date_precedante = $date;
					$texte.="<jour>".$date_courante."</jour>";
					$texte.="<$quote>".$places."</$quote>";
				$texte.="</JOURNEE>";
			$texte.="</INDICATEURS>";
		$texte.="</ETAB_SERV>";
		$date = date("Y/m/d",$rub['date']);
		$date_courante = date("Y/m/d",$rub['date']);
		$tot[$j] += $places;

		$texte.="<ETAB_SERV>";
			$texte.="<DESCSERV>";
				$texte.="<id_etab>".$rub['Hop_finess']."</id_etab>";      // n° Finess de l'établissement'
				//$texte.="<id_serv>".$rub['Hop_nom']."</id_serv>";      // ID du service. N°Sagec A SUPPRIMER
			$texte.="</DESCSERV>";
			$texte.="<INDICATEURS>";
		$hop_courant = $rub['Hop_nom'];
		$places = $rub['places_dispo'];
		$j = 0;
		}
	}
		$texte.="</INDICATEURS>";
	$texte.="</ETAB_SERV>";
	return $texte;
}

// extraction des données


/**
*	entete_INVS
*
*	Structure de l'entête du message XML
*
*	@return string $texte texte initial du message
*/
function entete_INVS($date)
{
	$nb_SAMU = '2';
	$nb_SMUR = '7';
	$nb_Urgences = '';
	$nb_EtablissementsAuto = '';

	$texte="<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
	$texte.="<INVS>\n";
	$texte.="<ARH>\n";
		$texte.="<id_arh>42</id_arh>\n";				// ID ARH 
		$texte.="<date_trans>".$date."</date_trans>\n"; // date de transmission
		$texte.="<nbEtab>".$nb_EtablissementsAuto."</nbEtab>\n";// nb d'établissements autorisés
        $texte.="<nbE_Urg>".$nb_Urgences."</nbE_Urg>\n";		// nb d'établissements ayant un service d'urgence
        $texte.="<nbSAMU>".$nb_SAMU."</nbSAMU>\n";			// nb de SAMU autorisés
		$texte.="<nbSMUR>".$nb_SMUR."</nbSMUR>\n";			// nb de SMUR autorisés
	$texte.="</ARH>\n";
	$texte.="<ENVOI>\n";

	return $texte;
}
/**
*	Activité Préhospitalière
*/
function activite_preHospitaliere($texte,$date1,$date2,$connexion)
{
	
/*	$requete = "SELECT DISTINCT date,veille_samu.service_ID,nb_affaires,nb_vsav,nb_apa,nb_primaires,nb_secondaires,Hop_finess
				FROM veille_samu,hopital,organisme,ville,service
				WHERE service.Hop_ID = hopital.Hop_ID
				AND hopital.org_ID = organisme.org_ID
				AND organisme.ville_ID = ville.ville_ID
				AND ville.region_ID = '42'
				AND date BETWEEN '$date1' and '$date2'
				";*/

$requete = "SELECT DISTINCT date,veille_samu.service_ID,nb_affaires,nb_vsav,nb_apa,nb_primaires,nb_secondaires,Hop_finess,service_nom
				FROM veille_samu,hopital,service
				WHERE veille_samu.service_ID = service.service_ID
				AND service.Hop_ID = hopital.Hop_ID
				AND date BETWEEN '$date1' and '$date2'
				ORDER BY Hop_finess, date
				";
	//print("<br>".$requete);
	$resultat = ExecRequete($requete,$connexion);
	while($rub = mysql_fetch_array($resultat))
	{
		$texte.="<ETAB_SERV>";
		$texte.="<DESCSERV>";
				$texte.="<id_etab>".$rub['Hop_finess']."</id_etab>";     // établissement
				$texte.="<id_serv>".$rub['service_nom']."</id_serv>";     // service
		$texte.="</DESCSERV>";
		$texte.="<INDICATEURS>";
				$texte.="<JOURNEE>";
					$date = date("Y/m/d",$rub['date']);
					$texte.="<jour>".$date."</jour>";                         // jour
					$texte.="<affaires>".$rub['nb_affaires']."</affaires>";   // nombre d'affaires
					$texte.="<sdis>".$rub['nb_vsav']."</sdis>";               // intervention SDIS
					$texte.="<ambu>".$rub['nb_apa']."</ambu>";                // ambulances privées
					$smur = $rub['nb_primaires']+$rub['nb_secondaires'];
					$texte.="<interv>".$smur."</interv>";                     // smur
				$texte.="</JOURNEE>";
		$texte.="</INDICATEURS>";
		$texte.="</ETAB_SERV>";
		//print("<br> => ".$rub['Hop_finess']);
	}
	return $texte;
}

/**
*========================= Activité Hospitalière ================================================
*/
function sau($texte,$date1,$date2,$connexion)
{
	$requete = "SELECT veille_sau.service_ID,
							date,
							SUM(inf_1_an) as inf_1_an,
							SUM(sup_75_an) as sup_75_an,
							SUM(entre1_75) as entre1_75,
							SUM(hospitalise) as hospitalise,
							SUM(uhcd) as uhcd,
							SUM(transfert) as transfert,
							Hop_finess,
							Hop_nom
					FROM veille_sau,hopital,service
					WHERE date BETWEEN '$date1' and '$date2'
					AND veille_sau.service_ID = service.service_ID
					AND service.Hop_ID = hopital.Hop_ID
					GROUP BY Hop_finess, date
					ORDER BY Hop_finess
					";
	$resultat = ExecRequete($requete,$connexion);
	while($sau = mysql_fetch_array($resultat))
	{
		//print(date("Y/m/d",$sau['date'])." ".$sau['Hop_finess']." ".$sau['Hop_nom']." ".$sau[inf_1_an]." ".$sau[sup_75_an]." ".$sau[entre1_75]." ".$sau[hospitalise]." ".$sau[uhcd]." ".$sau[transfert]."<br>");
	
		$texte.="<ETAB_SERV>\r\n";
			$texte.="<DESCSERV>\r\n";
					$texte.="<id_etab>".$sau['Hop_finess']."</id_etab>";      // n° Finess de l'établissement'
					$texte.="<id_serv>SAU</id_serv>";
				$texte.="</DESCSERV>\r\n";
				$texte.="<INDICATEURS>\r\n";
					$texte.="<JOURNEE>\r\n";
						$passages = $sau['inf_1_an']+$sau['sup_75_an']+$sau['entre1_75'];
						$date = date("Y/m/d",$sau['date']);
						$texte.="<jour>".$date."</jour>\r\n";                           // jour
						$texte.="<urg>".$passages."</urg>\r\n";                         // nb total de primo passage
						$texte.="<urg1a>".$sau['inf_1_an']."</urg1a>\r\n";              // moins de 1 an
						$texte.="<urg75a>".$sau['sup_75_an']."</urg75a>\r\n";           // plus de 75 ans
						$texte.="<hosp>".$sau['hospitalise']."</hosp>\r\n";             // hospitalisés service mco
						$texte.="<uhcd>".$sau['uhcd']."</uhcd>\r\n";                    // hospitalisé en Uhcd
						$texte.="<transferts>".$sau['transfert']."</transferts>\r\n";   // transférés
				$texte.="</JOURNEE>\r\n";
		$texte.="</INDICATEURS>\r\n";
		$texte.="</ETAB_SERV>\r\n";
	}
	return $texte;
}
/**
*-------------------------   Lits disponibles    ------------------------------------------------
*/
function lits_disponibles($texte,$date1,$date2,$connexion)
{
	$pediatrie="3,9,17";
	$rea = "2,4";
	$ssr = "15";
	$mco = "1,2,3,4,7,8,9,10,11,17,19";
	$texte .= litsDispoParSpecialite_hopital($connexion,$date1,$date2,$pediatrie,"litsPedia");
	$texte .= litsDispoParSpecialite_hopital($connexion,$date1,$date2,$rea,"litsRea");
	$texte .= litsDispoParSpecialite_hopital($connexion,$date1,$date2,$ssr,"litsSSR");
	$texte .= litsDispoParSpecialite_hopital($connexion,$date1,$date2,$mco,"litsMCO");
	return $texte;
}

/**
*-------------------------   places disponibles    ----------------------------------------------
*/
function places_disponibles($texte,$date1,$date2,$connexion)
{
	$texte .= placesDispoParSpecialite_hopital($connexion,$date1,$date2,"nbPlaces");
	return $texte;
}
/**
*-------------------------      DIRECTION        ------------------------------------------------
*/
function mortalite($texte,$date1,$date2,$connexion)
{
	// données de la direction
	$requete = "SELECT DISTINCT date,nb_tot_dcd,nb_dcd_sup75,Hop_finess,veille_dg.org_ID,Hop_nom
				FROM veille_dg,hopital,adresse,ville
				WHERE veille_dg.org_ID = hopital.org_ID
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
				AND ville.departement_ID IN ('67','68')
				AND date BETWEEN '$date1' and '$date2'
				ORDER BY Hop_finess, date
				";
	$resultat = ExecRequete($requete,$connexion);
	while($dg = mysql_fetch_array($resultat))
	{
		$texte.="<ETAB_SERV>";
		$texte.="<DESCSERV>";
				$texte.="<id_etab>".$dg['Hop_finess']."</id_etab>";
				//$texte.="<id_serv>".$dg['Hop_nom']."</id_serv>";
		$texte.="</DESCSERV>";
		$texte.="<INDICATEURS>";
				$texte.="<JOURNEE>";
				$date = date("Y/m/d",$dg['date']);
					$texte.="<jour>".$date."</jour>";
					$texte.="<deces>".$dg['nb_tot_dcd']."</deces>";
					$texte.="<deces75a>".$dg['nb_dcd_sup75']."</deces75a>";
				$texte.="</JOURNEE>";
		$texte.="</INDICATEURS>";
		$texte.="</ETAB_SERV>";
		//print("<br> => ".$dg['nb_tot_dcd']);
	}
	return $texte;
}

/**
* fermeture_INVS
*/
function fermeture_INVS($texte)
{
		$texte.="</ENVOI>";
	$texte.="</INVS>";
	return $texte;
}

function mail_info($succes)
{
	$destinataire = "jcb-bartier@wanadoo.fr";
	$sujet = "Message INVS";
	$entetes = "From: HUS-SAGEC67 \n";
	$entetes .= "Cc: thiriond@arh42.com \n";
	if($succes)
	{
		$texte="message envoyé et reçu";
	}
	else
	{
		$texte="Echec de la transmision du message";
	}
	$rep = mail($destinataire, $sujet,$texte,$entetes);
}
//================================================================================================
/**
* Partie principale
*
* @var string $now timestamp unix
* @var string $date timestamp exprimé sous la forme Y/m/d H:i:s
* @var string $date_fichier idem que $date mais sans les séparateurs
* @var string $nom_fichier nom du fichier pour l'INVS
*/

define("DEBUG",false);

print("<form name=\"create xml\" method=\"\">");
// heure de création du rapport
	$now = time();
	$date = date("Y/m/d H:i:s",$now);
	$date_fichier = date("YmdHis",$now);
	$date_veille = today()-un_jour;

// pour les tests--------------------------------------------------------------------
if(DEBUG)
{
	$date = "2005/10/19 12:00:00";
	$date_fichier = "20051019120000";
}
//-----------------------------------------------------------------------------------

// nom du fichier = ARH + n°région +Date de création sans séparateurs
$nom_fichier = "ARH42".$date_fichier;
$nom_fichier .= ".xml";
// Récupération des données utiles pour cron
$requete = "SELECT cron_intervalle,cron_adresse,cron_login,cron_password FROM cron";
$resultat = ExecRequete($requete,$connexion);
$crondata = mysql_fetch_array($resultat);

// intervalle d'extraction 7 jours
// date1: date d'extraction des données
// date2: date de début d'extraction des données
// cron_intervalle = date2 - date1 = 7 jours

// si date1 n'est pas précisée, alors c'est la date du jouir qui est utilisée par défaut
if($_REQUEST['date1'])
{
	$date1 = $_GET['date1'];
	$date2 = $_GET['date2'];
}
else
{
	$date2 = mktime(0,0,0,date('m'),date('j'),date('Y'));//strtotime("2005/05/22");
	$date1 = $date2 - $crondata['cron_intervalle']*24*3600;
}
// pour les tests--------------------------------------------------------------------
if(DEBUG)
{
	$date2 = strtotime("2005/10/19");
	$date1 = $date2 - $crondata['cron_intervalle']*24*3600;
}
//-----------------------------------------------------------------------------------

print("Les données seront extraites entre le ".$date1." et le ".$date2."<br>");
$texte = entete_INVS($date);
print("  - activité préhospitalière<br>");
$texte = activite_preHospitaliere($texte,$date1,$date2,$connexion);
$texte = sau($texte,$date1,$date2,$connexion);
$texte = lits_disponibles($texte,$date1,$date2,$connexion);
$texte = places_disponibles($texte,$date1,$date2,$connexion);
$texte = mortalite($texte,$date1,$date2,$connexion);
print("  - fin de l'extraction<br>");
$texte = fermeture_INVS($texte);

// enregistrement du fichier
print("  - enregistrement des données<br>");
$f = fopen($nom_fichier,"w");
fwrite($f,$texte);
fclose($f);

// impression du fichier
print("  - impression du fichier en clair<br>");
print $texte;
print("\n");

print("</form>");
?>
