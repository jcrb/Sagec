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
/** xml2UF.php
* 	analyse les donn�es transmises par les h�pitaux et met � jour la BD
*	date de cr�ation: 	13/10/2007		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: xml2UF.php 44 2008-04-16 06:55:34Z jcb $	 
*	maj le:				13/10/2007	
* 	@TODO: v�rifier si tout est sauvegard� 
*	@package			sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$path = "./../sagec_echange/";

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
include ('../utilitaires/stack.php');
include ('../date.php');

$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
define ("DEBUG",false);		 // pas d'affichage du travail du parseur
define ("TRACE",true);		 // aucun affichage des fichiers lus
define ("ENREGISTRE",true);// bloque l'�x�cution des requ�tes �crivant dans la BD 

// Parser XML
  //$file = "hospital.xml";
  global $deep;
  $stack = new Stack();
  global $etablisement_courant;
  global $date_courante;
  global $date_courante_unix;
  global $total_lits;
  global $total_sau;
  global $total_deces;
  global $litstotaux; // total de lits d'un �tablissement
  global $etablisement_finess;

/**
*	V�rifie si un enregistrement existe d�j� dans la table lits_journa
*	@param $service: ID du service concern�
*	@param $date_unix: date du jour concern� au format time_stamp unix
*	@return true s'il existe au moins 1 enregistremlent et false sinon
*/
function lits_journal_existe($service,$date_unix)
{
	$requete = "SELECT service_ID FROM lits_journal WHERE date='$date_unix' AND service_ID = '$service'";
	$resultat = ExecRequete($requete,$connect);
	if(mysql_num_rows($resultat) == 0)
		return false;
	else return true;
}
/**----------------------------------------------------------------------
Met � 0 le contenu du tableau $total_lits
Ce tableau sert � faire la somme des diff�rents lits d'un service 
� partir des infos UF.
Cette fonction est appel�e � chaque appel � <SERVICE>
------------------------------------------------------------------------*/
function resetTotalLits()
{
	global $total_lits;
	$total_lits['lits_installes'] = 0;
	$total_lits['lits_ouverts'] = 0;
	$total_lits['lits_fermes'] = 0;
	$total_lits['lits_supplementaires'] = 0;
	$total_lits['lits_occupes'] = 0;
	$total_lits['lits_installes'] = 0;
	$total_lits['lits_disponibles'] = 0;
	$total_lits['places_disponibles'] = 0;
	$total_lits['permissions'] = 0;
}
/**----------------------------------------------------------------------
Met � 0 le contenu du tableau $total_deces
Ce tableau sert � faire la somme des diff�rents items d'un service 
� partir des infos UF.
Cette fonction est appel�e � chaque appel � <SAU>
------------------------------------------------------------------------*/
function resetDeces()
{
	global $total_deces;
	$total_deces['tot'] = 0;
	$total_deces['sup75'] = 0;
}
/**----------------------------------------------------------------------
Met � 0 le contenu du tableau $total_sau
Ce tableau sert � faire la somme des diff�rents items d'un service 
� partir des infos UF.
Cette fonction est appel�e � chaque appel � <SAU>
------------------------------------------------------------------------*/
function resetTotalSau()
{
	global $total_sau;
	$total_sau['urg'] = 0;
	$total_sau['urg1a'] = 0;
	$total_sau['urg75a'] = 0;
	$total_sau['hosp'] = 0;
	$total_sau['uhcd'] = 0;
	$total_sau['transferts'] = 0;
}
/**----------------------------------------------------------------------
* Dessinne l'ent�te dutableau SAU
------------------------------------------------------------------------*/
function tableauSAU()
{
	if(TRACE)
	{	
		print("<table border=\"1\" >");
		print("<tr>");
			print("<td>Date</td>");
			print("<td>Etablissement</td>");
			print("<td>service</td>");
			print("<td>nom</td>");
			print("<td>UF</td>");
			print("<td>Passages</td>");
			print("<td>moins 1 an</td>");
			print("<td>plus de 75 ans</td>");
			print("<td>Hospitalis�s</td>");
			print("<td>UHCD</td>");
			print("<td>Transferts</td>");
		print("</tr>");
	}
}
/**----------------------------------------------------------------------
* Dessine l'ent�te du tableau LITS
-----------------------------------------------------------------------*/
function tableauLits()
{
	if(TRACE)
	{
		print("<table border=\"1\">");
				print("<tr>");
					print("<td>Date</td>");
					print("<td>Etablissement</td>");
					print("<td>service</td>");
					print("<td>nom</td>");
					print("<td>UF</td>");
					print("<td>Lits install�s</td>");
					print("<td>Lits ouverts</td>");
					print("<td>Lits occup�s</td>");
					print("<td>Lits sup.</td>");
					print("<td>Lits dispo.</td>");
					print("<td>Lits ferm�s</td>");
					print("<td>Permissions</td>");
					print("<td>Places dispo.</td>");
				print("</tr>");
	}
} 
/** ---------------------------------------------------------------------
Analyse d'une balise ouvrante
@param $parser un objet parseur
@param $name nom de la balise
@param $attr attribut de la balise
------------------------------------------------------------------------*/
  function balise_ouvrante($parser,$name,$attr)
  {
  	global $balise_courante;
	global $deep;
	global $stack;
	global $bloc_courant;// SAMU, SAU ...
	global $litstotaux;
	global $organisme_courant;
	global $date_courante_unix;
	global $service_courant_ouvert;
	$date_limite = fDatetime2unix('03/04/2008');
		
	$deep++;
	/** montage d�bile li� � un bug 
	* le fichiers des HUS ont oubli� la balise <ENVOI></envoi>
	* ce qui fausse la profondeur...
	* le fichier St Vincent est bon: code organisme = 204)
	*/
/*
	if($organisme_courant == 204 && $deep == 4)
	{ 
		$bloc_courant =  $name; 
		if(DEBUG) print("Bloc courant: ".$bloc_courant."<br>");
	}
	else if($organisme_courant != 204 && $deep == 3)
	{
		$bloc_courant =  $name; 
		if(DEBUG) print("Bloc courant: ".$bloc_courant."<br>");
	}
*/
	/*
	if($deep == 4)
	{ 
		$bloc_courant =  $name; 
		if(DEBUG) print("Bloc courant: ".$bloc_courant."<br>");
	}
	*/
	if($date_courante_unix >= $date_limite && $deep == 4)
	{ 
		$bloc_courant =  $name; 
		if(DEBUG) print("Bloc courant: ".$bloc_courant."<br>");
	}
	else if($deep == 3)
	{ 
		$bloc_courant =  $name; 
		if(DEBUG) print("Bloc courant: ".$bloc_courant."<br>");
	}
	switch($name)
	{
		case 'UF':break;
		case 'ETAB_SERV':
			$litstotaux = 0;
			break;
		case 'SERVICE':
			if($bloc_courant == 'LITS')
			{
				resetTotalLits();
				tableauLits();
			}
			else if($bloc_courant == 'SAU')
			{
				resetTotalSau();
				tableauSAU();
			}
			break;
		case 'SAU': 
			resetTotalSau();
			tableauSAU();
			break;
	}
	$balise_courante = $name;
	$stack->push($balise_courante);
	if(DEBUG) print("[BAOU] ");
	if(DEBUG) $stack->write_stack();
	if(DEBUG) print($deep.'<br>');
  }
/** ---------------------------------------------------------------------
Analyse d'une balise fermante
@param $parser un objet parseur
@param $name nom de la balise
------------------------------------------------------------------------*/
  function balise_fermante($parser,$name)
  {
  	global $deep;
	global $stack;
	global $balise_courante;
	global $bloc_courant;
	global $litstotaux;
	global $service_courant_ouvert;
  	global $service_courant_nom;
  	global $service_courant_code;
  	global $uf_courante_ouverte;
	
	//if( $name == "Hospital")
	//	enregistre_hopital();// nouvel hop, il faut enregistrer le pr�c�dant
	switch($name)
	{
		case 'MORTALITE':enregistre_deces(); break;
		case 'UF':
			if(DEBUG) print("<br>Bloc courant: ".$bloc_courant."<br>");
			if($bloc_courant == 'SAU')
				totalise_sau();
			//else if($bloc_courant == 'LITS' && $uf_courante_ouverte !=0)
			else if($bloc_courant == 'LITS')
				enregistre_lits();
			break;
		case 'JOURNEE':
			if($bloc_courant == 'SAMU') enregistre_samu();
			break;
		case 'SERVICE':
			//print("Bloc courant: ".$bloc_courant."<br>");
			if($bloc_courant == 'SAU') 
				enregistre_sau();
			else if($bloc_courant == 'LITS' && $service_courant_ouvert==TRUE)
				enregistre_service();
			if(TRACE && $service_courant_ouvert==FALSE)
				print("<b>".$service_courant_nom." (".$service_courant_code.") est ferm�<br></b>");
			break;
		case 'ETAB_SERV':
			if(TRACE)
				print("<br>Total lits: ".$litstotaux."<br>");
			break;
		/*
		case 'SAU':
			enregistre_sau();
			break;*/
	}
	
	$deep--;
	$element = $stack->pop();// d�pile le dernier �l�mment
	$balise_courante = $stack->top();
	if(DEBUG) print("[BAFE] ");
	if(DEBUG) $stack->write_stack();
	if(DEBUG) print($deep.'<br>');
  }
  
/**
* Enregistre SERVICE
*/
function enregistre_service()
{
	global $connect;
 	global $service_courant_nom;
  	global $service_courant_code;
  	global $service_courant_ID;
  	global $date_courante;
  	global $date_courante_unix;
  	global $organisme_courant;
  	global $total_lits;
  	global $litstotaux;
  	global $uf_courante_id;
  	global $etablisement_courant;
  	
  	if(TRACE)
  	{
		print("<tr bgcolor=\"yellow\">");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_code</td>");
			print("<td>$service_courant_nom</td>");
			print("<td>Total</td>");
			
			print("<td>$total_lits[lits_installes]</td>");
			print("<td>$total_lits[lits_ouverts]</td>");
			print("<td>$total_lits[lits_occupes]</td>");
			print("<td>$total_lits[lits_supplementaires]</td>");
			print("<td>$total_lits[lits_disponibles]</td>");
			print("<td>$total_lits[lits_fermes]</td>");
			print("<td>$total_lits[permissions]</td>");
			print("<td>$total_lits[places_disponibles]</td>");
		print("</tr>");
		print("</table>");
	}
	
	$litstotaux += $total_lits['lits_installes'];
	
	if(DEBUG) print("=== Enregistre service ===");
	
	// maj table lits
	$requete = "SELECT lits_ID, date_maj FROM lits WHERE service_ID = '$service_courant_ID'";
	$resultat = ExecRequete($requete,$connect);
	$rep = mySql_fetch_array($resultat);
	// o v�rifie d'abord que la date de maj est bien ant�rieure � la date courante
	if($date_courante_unix >= $rep['date_maj'])
	{
		$id = $rep['lits_ID'];
		if(!$id)
		{
			$requete = "INSERT INTO lits(lits_ID,service_ID, Hop_ID,lits_sp,lits_supp,lits_occ,lits_dispo,
						date_maj,lits_installe,lits_ferme,places_dispo) 
						VALUES(
						'',
						'$service_courant_ID',
						'$etablisement_courant',
						'$total_lits[lits_installes]',
						'$total_lits[lits_supplementaires]',
						'$total_lits[lits_occupes]',
						'$total_lits[lits_disponibles]',
						'$date_courante_unix',
						'$total_lits[lits_ouverts]',
						'$total_lits[lits_fermes]',
						'$total_lits[places_disponibles]'
						)";
		}
		else
		{
			$requete = "UPDATE lits SET 
						service_ID = '$service_courant_ID',
						Hop_ID = '$etablisement_courant',
						lits_sp = '$total_lits[lits_installes]',
						lits_supp = '$total_lits[lits_supplementaires]',
						lits_occ = '$total_lits[lits_occupes]',
						lits_dispo = '$total_lits[lits_disponibles]',
						date_maj = '$date_courante_unix',
						lits_installe = '$total_lits[lits_ouverts]',
						lits_ferme = '$total_lits[lits_fermes]',
						places_dispo = '$total_lits[places_disponibles]'
						WHERE lits_ID = '$id'";
		}
		if(TRACE)
			print($requete."<br>");
	
		if(ENREGISTRE)
			$resultat = ExecRequete($requete,$connect);
	}
	
	// maj de la table lits_journal
	$requete = "SELECT date FROM lits_journal WHERE date='$date_courante_unix' AND service_ID='$service_courant_ID'";
	$resultat = ExecRequete($requete,$connect);
	if(mysql_num_rows($resultat) == 0)
		$requete = "INSERT INTO lits_journal VALUES('$date_courante_unix','$service_courant_ID','$total_lits[lits_disponibles]','0')";
	else
	{
		$requete = "UPDATE lits_journal SET 
						lits_dispo = '$total_lits[lits_disponibles]'
						WHERE date='$date_courante_unix' AND service_ID='$service_courant_ID'";
	}
	if(TRACE)
		print($requete."<br>");
	
	if(ENREGISTRE)
		$resultat = ExecRequete($requete,$connect);
	
} 

/**
* fait la somme des diff�rentes UF appartenant � un m�me SAU
*
*/
function totalise_sau()
{
	global $total_sau;
	global $urg ;
	global $urg1a;
	global $urg75a;
	global $hosp;
	global $uhcd;
	global $transferts;
	global $service_courant_nom;
  	global $service_courant_code;
  	global $uf_courante_nom;
  	global $uf_courante_id;
  	global $date_courante;
  	global $organisme_courant;
	
	// totalisation
	$total_sau['urg'] += $urg;
	$total_sau['urg1a'] += $urg1a;
	$total_sau['urg75a'] += $urg75a;
	$total_sau['hosp'] += $hosp;
	$total_sau['uhcd'] += $uhcd;
	$total_sau['transferts'] += $transferts;
	
	// tableau r�capitulatif de l'UF courante
	if(TRACE)
	{
		print("<tr>");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_code</td>");
			print("<td>$service_courant_nom</td>");
			print("<td>$uf_courante_id</td>");
			print("<td>$urg</td>");
			print("<td>$urg1a</td>");
			print("<td>$urg75a</td>");
			print("<td>$hosp</td>");
			print("<td>$uhcd</td>");
			print("<td>$transferts</td>");
		print("</tr>");
	}
}

 /**
 * Enregistre SAU
 * source: services/epidemio/passage_sau_enregistre.php
 */
 function enregistre_sau()
 {
 	//print("=== Enregistre SAU ===<br>");
 	global $connect;
 	global $service_courant_nom;
  	global $service_courant_code;
  	global $service_courant_ID;
  	global $uf_courante_nom;
  	global $uf_courante_id;
  	global $date_courante;
  	global $date_courante_unix;
  	global $organisme_courant;
  	// SAU
   global $urg ;
	global $urg1a;
	global $urg75a;
	global $hosp;
	global $uhcd;
	global $transferts;
	// tableau r�capitulatif
	global $total_sau;
	
	// tableau r�capitulatif du service
	if(TRACE)
	{
		print("<tr bgcolor=\"tomato\">");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_code</td>");
			print("<td>$service_courant_nom</td>");
			print("<td>Total</td>");
			
			print("<td>$total_sau[urg]</td>");
			print("<td>$total_sau[urg1a]</td>");
			print("<td>$total_sau[urg75a]</td>");
			print("<td>$total_sau[hosp]</td>");
			print("<td>$total_sau[uhcd]</td>");
			print("<td>$total_sau[transferts]</td>");
		print("</tr>");
		print("</table>");
	}
	
	// v�rifie si enregistrement existe d�j�
	// 23/7/05 remplacement de $_SESSION[service] par $_GET[service]
	$requete = "SELECT veille_SAU_ID FROM veille_SAU WHERE date = '$date_courante'AND uf_ID = '$uf_courante_id'";
	$resultat = ExecRequete($requete,$connect);
	$rub = mysql_fetch_array($resultat);
	$id = $rub['veille_SAU_ID'];
	if(TRACE)
		print($requete."<br>");
		
	// Enregistrement dans la table veille_SAU
	if($id == 0)
	{
		$requete = "INSERT INTO veille_SAU VALUES('',
			'$date_courante',
			'$organisme_courant',
			'$service_courant_ID',
			'$uf_courante_id',
			'$total_sau[urg]',
			'$total_sau[urg1a]',
			'$total_sau[urg75a]',
			'$total_sau[hosp]',
			'$total_sau[uhcd]',
			'$total_sau[transferts]',
			'0'
			)";
	}
	else
	{
		$requete = "UPDATE veille_SAU SET 
				passage = '$total_sau[urg]',
				inf_1an = '$total_sau[urg1a]',
				sup_75an = '$total_sau[urg75a]',
				hosp = '$total_sau[hosp]',
				uhcd = '$total_sau[uhcd]',
				transfert = '$total_sau[transferts]',
				user_ID = '0'
				WHERE veille_SAU_ID = '$id'
				";
	}
	
	if(ENREGISTRE)
		$resultat = ExecRequete($requete,$connect);
	if(TRACE)
		print("<br>=== SAU ".$requete."<br>");
	
	// enregistre dans la table veille_sau
	$requete = "SELECT veille_ID FROM veille_sau WHERE date = '$date_courante_unix'AND service_ID = '$service_courant_ID'";
	$resultat = ExecRequete($requete,$connect);
	$rub = mysql_fetch_array($resultat);
	$id = $rub['veille_ID'];
	$entre1_75 = $total_sau[urg]-$total_sau[urg1a]-$total_sau[urg75a];
	if($id == 0)// pas d'enregistrement
	{
		$requete = "INSERT INTO veille_sau VALUES('',
			'$service_courant_ID',
			'$date_courante_unix',
			'$entre1_75',
			'$total_sau[urg1a]',
			'$total_sau[urg75a]',
			'$total_sau[hosp]',
			'$total_sau[uhcd]',
			'$total_sau[transferts]',
			'0'
			)";
	}
	else
	{
		$requete = "UPDATE veille_sau SET 
				inf_1_an = '$total_sau[urg1a]',
				sup_75_an = '$total_sau[urg75a]',
				entre1_75 = '$entre1_75',
				hospitalise = '$total_sau[hosp]',
				uhcd = '$total_sau[uhcd]',
				transfert = '$total_sau[transferts]',
				ID_utilisateur = '0'
				WHERE veille_ID = '$id'
				";
	}
	if(ENREGISTRE)
		$resultat = ExecRequete($requete,$connect);
	if(TRACE)
		print("<br>=== SAU ".$requete."<br>");
		
	resetTotalSau();
 }
 /**
 *
 */
 function enregistre_samu()
 {
 	if(TRACE)
 		print("=== Enregistre SAMU ===<br>");
 	global $connect;
 }
  /**
 *
 */
 function enregistre_lits()
 {
 	//print("=== Enregistre LITS ===<br>");
 	global $connect;
 	global $date_courante;
 	global $heure_courante;
	global $organisme_courant;
	global $service_courant_nom;
  	global $service_courant_code;
  	global $uf_courante_nom;
  	global $uf_courante_id;
 	// services
	global $lits_installes;
	global $lits_ouverts;
	global $lits_occupes;
	global $lits_supplementaires;
	global $lits_disponibles;
	global $lits_fermes;
	global $places_disponibles;
	global $permissions;
	global $total_lits;
	global $service_courant_ID;
	global $uf_courante_ouverte;
	
	// nom du service
	$requete = "SELECT service_ID, service_nom 
					FROM service 
					WHERE service_code = '$service_courant_code'
					AND org_ID = '$organisme_courant'
					";
	$resultat = ExecRequete($requete,$connect);
	$rub = mysql_fetch_array($resultat);
	$service_courant_nom = $rub['service_nom'];
	$service_courant_ID = $rub['service_ID'];
	
	// sommation du nb  par services
	$total_lits['lits_installes'] += $lits_installes;
	$total_lits['lits_ouverts'] += $lits_ouverts;
	$total_lits['lits_occupes'] += $lits_occupes;
	$total_lits['lits_supplementaires'] += $lits_supplementaires;
	$total_lits['lits_disponibles'] += $lits_disponibles;
	$total_lits['places_disponibles'] += $places_disponibles;
	$total_lits['permissions']+= $permissions;
	$total_lits['lits_fermes']+= $lits_fermes;
	
	// affichage
	if(TRACE)
	{
		print("<tr>");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_code</td>");
			print("<td>$service_courant_nom</td>");
			print("<td>$uf_courante_id</td>");
			
			print("<td>$lits_installes</td>");
			print("<td>$lits_ouverts</td>");
			print("<td>$lits_occupes</td>");
			print("<td>$lits_supplementaires</td>");
			print("<td>$lits_disponibles</td>");
			print("<td>$lits_fermes</td>");
			print("<td>$permissions</td>");
			print("<td>$places_disponibles</td>");
		print("</tr>");
	}
		
	$requete = "SELECT journal_ID FROM journal_uf WHERE date = '$date_courante' AND uf_ID='$uf_courante_id'";
	$resultat = ExecRequete($requete,$connect);
	$rep = mySql_fetch_array($resultat);
	$id = $rep['journal_ID'];
	if($id == 0)
	{
		$requete = "INSERT INTO journal_uf VALUES(
						'',
						'$date_courante',
						'$heure_courante',
						'$service_courant_ID',
						'$uf_courante_id',
						'$lits_installes',
						'$lits_ouverts',
						'$lits_disponibles',
						'$lits_fermes',
						'$lits_supplementaires',
						'$lits_occupes',
						'$permissions',
						'$places_disponibles',
						'0'
						)";
	}
	else
	{
		$requete = "UPDATE journal_uf SET 
						lits_installes = '$lits_installes',
						lits_ouverts = '$lits_ouverts',
						lits_occupes = '$lits_occupes',
						lits_dispo = '$lits_disponibles',
						lits_fermes = '$lits_fermes',
						lits_sup = '$lits_supplementaires',
						lits_permissions = '$permissions',
						places_dispo = '$places_disponibles'
						WHERE journal_ID = '$id'
						";
	}
	
	// mise � jour de la table lits
	/*
		$requete2 = "UPDATE lits SET
						lits_sp = '$lits_installes',
						lits_supp = '$lits_supplementaires',
						lits_occ = '$lits_occupes',
						lits_dispo = '$lits_disponibles',
						date_maj = '$date_courante',
						lits_ferme = '$lits_fermes',
						lits_installe = '$lits_installes'
						WHERE service_ID = $service_courant_ID";
	*/
						
	if(TRACE)
	{
		print($requete."<br>");
		//print($requete2."<br>");
	}
	
	if(ENREGISTRE)
	{
		$resultat = ExecRequete($requete,$connect);
		//$resultat = ExecRequete($requete2,$connect);
	}

 }
 /**
* enregistre les d�c�s
*/
function enregistre_deces()
{
	global $date_courante;
	global $organisme_courant;
	global $deces;
  	global $deces75a;
  	global $connect;
  	global $etablisement_courant;
  	
	// v�rifie si enregistrement existe d�j�
	$requete = "SELECT deces_ID FROM veille_deces WHERE date = '$date_courante' AND Hop_ID = '$etablisement_courant'";
	$resultat = ExecRequete($requete,$connect);
	$rub = mysql_fetch_array($resultat);
	$id = $rub['deces_ID'];
	if($id == 0)
	{
		$requete = "INSERT INTO veille_deces VALUES('',
			'$date_courante',
			'$deces',
			'$deces75a',
			'$organisme_courant',
			'$etablisement_courant',
			'0'
			)";
	}
	else
	{
		$requete = "UPDATE veille_deces SET date = '$date_courante',
			deces_tot = '$deces',
			deces_sup75 = '$deces75a',
			org_ID = '$organisme_courant',
			Hop_ID = '$etablisement_courant',
			user_ID = '0'
			WHERE deces_ID = '$id'
			";
	}
	
	if(ENREGISTRE)
		$resultat = ExecRequete($requete,$connect);
	
	if(TRACE)
	{
		print("<table border=\"1\" bgcolor=\"orange\">");
		print("<tr>");
			print("<td>Date</td>");
			print("<td>Etablissement</td>");
			print("<td>D�c�s</td>");
			print("<td>dont plus de 75 ans</td>");
		print("</tr>");
		print("<tr>");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$deces75a</td>");
			print("<td>$deces75a</td>");
		print("</tr>");
		print("</table>");
	}
	
	$deces = 0;
	$deces75a = 0;
	if(TRACE)
		print($requete.'<br>');
}

/** ---------------------------------------------------------------------
Analyse du texte pr�sent entre les 2 balises
@param $parser un objet parseur
@param $data texte
------------------------------------------------------------------------*/
function texte($parser, $data)
{
  	global $balise_courante;
	global $hop;
	global $fp;
	global $stack;
	global $etablisement_courant;
  	global $date_courante;
  	global $heure_courante;
  	global $date_courante_unix;
  	global $organisme_courant;
  	global $deces;
  	global $deces75a;
  	global $connect;
  	global $service_courant_nom;
  	global $service_courant_code;
  	global $service_courant_ID;
	global $service_courant_ouvert;
  	global $uf_courante_nom;
  	global $uf_courante_id;
  	global $uf_courante_ouverte;//oui = 1, non = 0
  	// SAU
   	global $urg ;
	global $urg1a;
	global $urg75a;
	global $hosp;
	global $uhcd;
	global $transferts;
	// services
	global $lits_installes;
	global $lits_ouverts;
	global $lits_occupes;
	global $lits_supplementaires;
	global $lits_disponibles;
	global $lits_fermes;
	global $places_disponibles;
	global $permissions;
	global $etablisement_finess;
	
	$heure_courante = '10:30:00';


	$data = trim($data);
	if($data != '' && $data!='\r\n')
	{
		if(DEBUG) print("[DATA] ".$balise_courante." => ".$data.'<br>');
		switch($balise_courante)
		{
			case 'id_etab':
				$etablisement_finess = $data; 
				$requete="SELECT org_ID, Hop_ID,Hop_nom FROM hopital WHERE Hop_finess = '$data'";
				if(TRACE)
					print($requete."<br>");
				$resultat = ExecRequete($requete,$connect);
				$rep = mysql_fetch_array($resultat);
				$organisme_courant = $rep['org_ID'];
				$etablisement_courant= $rep['Hop_ID'];
				if(TRACE)
					print("<u>Organisme courant: </u>".$organisme_courant." (".$rep['Hop_nom'].")<br>");
				break;
			case 'jour':
				$date_courante = ($data);
				$date_courante_unix = mysqlDateTime2unix($data);
				if(TRACE){
					print("date courante: ".$date_courante."<br>"); 
					print("date courante unix: ".$date_courante_unix."<br>"); 
					}
					break;
			case 'service_nom':$service_courant_nom = $data; break;
			case 'service_id':
				$service_courant_code = $data; 
				$requete = "SELECT service_ID, service_nom,Priorite_Alerte FROM service WHERE service_code = '$data' AND org_ID = '$organisme_courant'";
				if(TRACE)
					print($requete."<br>");
				$resultat = ExecRequete($requete,$connect);
				$rub = mysql_fetch_array($resultat);
				$service_courant_nom = $rub['service_nom'];
				$service_courant_ID = $rub['service_ID'];
				
				if($rub['Priorite_Alerte']==9)
					$service_courant_ouvert = FALSE;
				else $service_courant_ouvert = TRUE;
				
				if(TRACE)
				{
					print("service_courant_ID = ".$service_courant_ID."<br>");
					print("service_courant_NOM = ".$service_courant_nom."<br>");
				}
				break;
			case 'nom_UF':$uf_courante_nom = $data; break;
			case 'id_UF':
				$requete = "SELECT uf_ID,uf_nom,uf_ouverte FROM uf WHERE org_ID='$organisme_courant' AND uf_code='$data'";
				$resultat = ExecRequete($requete,$connect);
				$rub = mysql_fetch_array($resultat);
				$uf_courante_id = $rub['uf_ID'];
				$uf_courante_nom = $rub['uf_nom'];
				$uf_courante_ouverte = $rub['uf_ouverte'];
				if(TRACE)
					print("UF Courante: ".$data." (".$uf_courante_nom." identifiant Sagec: ".$uf_courante_id.")<br>");
				break;
			
			// indicateurs de mortalit�
			case 'deces':$deces = $data; break;
			case 'deces75a':$deces75a = $data; break;
			
			// donn�es SAMU
			case 'affaires':$affaires = $data; break;
			case 'sdis':$sdis = $data; break;
			case 'interv':$interv = $data; break;
			case 'primaire':$primaire = $data; break;
			case 'secondaire':$secondaire = $data; break;
			case 'conseil':$conseil = $data; break;
			case 'envoi':$envoi = $data; break;
			case 'tiih':$tiih = $data; break;
			case 'neonat':$neonat = $data; break;

			// Doon�es SAU
			case 'urg':$urg = $data; break;
			case 'urg1a':$urg1a = $data; break;
			case 'urg75a':$urg75a = $data; break;
			case 'hosp':$hosp = $data; break;
			case 'uhcd':$uhcd = $data; break;
			case 'transferts':$transferts = $data; break;

			// Donn�es services
			case 'lits_installes':$lits_installes = $data; break;
			case 'lits_ouverts':$lits_ouverts = $data; break;
			case 'lits_occupes':$lits_occupes = $data; break;
			case 'lits_supplementaires':$lits_supplementaires = $data; break;
			case 'lits_disponibles':
				if($data>=0)
					$lits_disponibles = $data;
				else
					$lits_disponibles = 0;
				break;
			case 'lits_fermes':$lits_fermes = $data; break;
			case 'places_disponibles':$places_disponibles = $data; break;
			case 'permissions':$permissions = $data; break;
	    				
		}
	}
	//else print("BALISE VIDE <br>");
}
/** ---------------------------------------------------------------------
m�thode par d�faut
------------------------------------------------------------------------*/
  function defaut()
  {
  	return true;
  }
/** ---------------------------------------------------------------------
Initialisation des 3 m�thodes de base pour un parseur de type SAX
@param $parser un objet parseur
------------------------------------------------------------------------*/
  function set_handlers($parser)
  {
  	xml_set_element_handler($parser,'balise_ouvrante','balise_fermante');
	xml_set_default_handler($parser,'defaut');
	xml_set_character_data_handler($parser,'texte');
  }
/** ---------------------------------------------------------------------
Lit une ligne du fichier XML.
@param $parser le parseur.
@param $data les donn�es lues.
@param $fp le fichier source.
------------------------------------------------------------------------*/
  function lit_une_ligne($parser, $data,$fp)
  {
  	if (!xml_parse($parser, $data, feof($fp)))
    	{
        	die(sprintf("erreur XML: %s � la ligne %d",
                  xml_error_string(xml_get_error_code($parser)),
                  xml_get_current_line_number($parser)));
    	}
 }

/** ---------------------------------------------------------------------
main
@param $deep profondeur le l'analyse
@param $fp le fichier � lire
@param $parser parseur
------------------------------------------------------------------------*/
function parse_file($file_source)
{
  $deep = 0;
  global $fp,$path;
  // analyse de l'ent�te
  $titre = explode('_',$file_source);
  $file = $path.$file_source;
  if(TRACE)
  {
  		print("<br>");
  		print('type: '.$titre[0].'<br>');
  		print('finess: '.$titre[1].'<br>');
  		print('date: '.$titre[2].'<br>');
  		print($file.'<br>');
  		print("<br>");
  	}
  	else print($file_source."<br>");
  		
  
	// cr�ation du parser
  $parser = xml_parser_create("ISO-8859-1");
	// les balises ne sont pas transform�es en majuscules
  xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
  set_handlers($parser);
  if (!($fp = fopen($file, "r"))) {die("could not open XML input");}
  while ($data = fread($fp, 4096)) 
  {
	//print($data.'<br>');
	//$data = utf8_encode($data);
  	lit_une_ligne($parser, $data,$fp);
  }
	xml_parser_free($parser);
}

?>
