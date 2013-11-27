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
*	@version:			1.1	- $Id$	 
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
define ("DEBUG",false);

// Parser XML
  //$file = "hospital.xml";
  global $deep;
  $stack = new Stack();
  global $etablisement_courant;
  global $date_courante;
  global $total_lits;
  global $total_sau;
  global $total_deces;
  global $litstotaux; // total de lits d'un �tablissement
  global $etablisement_finess;

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
/**----------------------------------------------------------------------
* Dessine l'ent�te du tableau LITS
-----------------------------------------------------------------------*/
function tableauLits()
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
		
	$deep++;
	if($deep == 3)
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
	
	//if( $name == "Hospital")
	//	enregistre_hopital();// nouvel hop, il faut enregistrer le pr�c�dant
	switch($name)
	{
		case 'MORTALITE':enregistre_deces(); break;
		case 'UF':
			if($bloc_courant == 'SAU')
				totalise_sau();
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
			else if($bloc_courant == 'LITS')
				enregistre_service();
			break;
		case 'ETAB_SERV':
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
  	global $service_courant_id;
  	global $date_courante;
  	global $organisme_courant;
  	global $total_lits;
  	global $litstotaux;
  	
  	// affichage
		print("<tr bgcolor=\"yellow\">");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_id</td>");
			print("<td>$service_courant_nom</td>");
			print("<td>Total</td>");
			
			print("<td>".$total_lits['lits_installes']."</td>");
			print("<td>$total_lits[lits_ouverts]</td>");
			print("<td>$total_lits[lits_occupes]</td>");
			print("<td>$total_lits[lits_supplementaires]</td>");
			print("<td>$total_lits[lits_disponibles]</td>");
			print("<td>$total_lits[lits_fermes]</td>");
			print("<td>$total_lits[permissions]</td>");
			print("<td>$total_lits[places_disponibles]</td>");
		print("</tr>");
	print("</table>");
	
	$litstotaux += $total_lits['lits_installes'];
	
	if(DEBUG) print("=== Enregistre service ===");
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
  	global $service_courant_id;
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
		print("<tr>");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_id</td>");
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

 /**
 * Enregistre SAU
 * source: services/epidemio/passage_sau_enregistre.php
 */
 function enregistre_sau()
 {
 	//print("=== Enregistre SAU ===<br>");
 	global $connect;
 	global $service_courant_nom;
  	global $service_courant_id;
  	global $uf_courante_nom;
  	global $uf_courante_id;
  	global $date_courante;
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
		print("<tr bgcolor=\"tomato\">");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_id</td>");
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
	
	// v�rifie si enregistrement existe d�j�
	// 23/7/05 remplacement de $_SESSION[service] par $_GET[service]
	$requete = "SELECT veille_ID FROM veille_sau WHERE date = '$date_courante'AND service_ID = '$service_courant_id'";
	$resultat = ExecRequete($requete,$connect);
	$rub = mysql_fetch_array($resultat);
	$id = $rub['veille_ID'];
	//print("UF ".$uf_courante_id);
	
	if($id == 0)
	{
		$requete = "INSERT INTO veille_sau VALUES('',
			'$service_courant_id',
			'$date_courante',
			'$total_sau[urg1a]',
			'$total_sau[urg75a]',
			'$total_sau[urg]',
			'$total_sau[hosp]',
			'$total_sau[uhcd]',
			'$total_sau[transferts],
			'0'
			)";
	}
	else
	{
		$requete = "UPDATE veille_sau SET date = '$date',
				service_ID = '$service_courant_id',
				inf_1_an = '$total_sau[urg1a]',
				sup_75_an = '$total_sau[urg75a]',
				entre1_75 ='$total_sau[urg]',
				hospitalise = '$total_sau[hosp]',
				uhcd = '$total_sau[uhcd]',
				transfert = '$total_sau[transferts]',
				ID_utilisateur = '0'
				WHERE veille_ID = '$id'
				";
	}
	//$resultat = ExecRequete($requete,$connect);
	print("<br>=== SAU ".$requete."<br>");
	resetTotalSau();
 }
 /**
 *
 */
 function enregistre_samu()
 {
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
	global $organisme_courant;
	global $service_courant_nom;
  	global $service_courant_id;
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
	
	// nom du service
	$requete = "SELECT service_ID, service_nom FROM service WHERE service_code = 'service_courant_id'";
	$resultat = ExecRequete($requete,$connect);
	$rub = mysql_fetch_array($resultat);
	$service_courant_nom = $rub['service_nom'];
	
	// sommation du nb  par services
	$total_lits['lits_installes'] += $lits_installes;
	$total_lits['lits_ouverts'] += $lits_ouverts;
	$total_lits['lits_occupes'] += $lits_occupes;
	$total_lits['lits_supplementaires'] += $lits_supplementaires;
	$total_lits['lits_disponibles'] += $lits_disponibles;
	$total_lits['places_disponibles'] += $places_disponibles;
	$total_lits['permissions']+= $permissions;
	
	// affichage
		print("<tr>");
			print("<td>$date_courante</td>");
			print("<td>$organisme_courant</td>");
			print("<td>$service_courant_id</td>");
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
	//print("</table>");

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
	$resultat = ExecRequete($requete,$connect);
	
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
	$deces = 0;
	$deces75a = 0;
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
  	global $organisme_courant;
  	global $deces;
  	global $deces75a;
  	global $connect;
  	global $service_courant_nom;
  	global $service_courant_id;
  	global $uf_courante_nom;
  	global $uf_courante_id;
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


	$data = trim($data);
	if($data != '' && $data!='\r\n')
	{
		if(DEBUG) print("[DATA] ".$balise_courante." => ".$data.'<br>');
		switch($balise_courante)
		{
			case 'id_etab':
				$etablisement_finess = $data; 
				$requete="SELECT org_ID, Hop_ID,hop_nom FROM hopital WHERE Hop_finess = '$data'";
				$resultat = ExecRequete($requete,$connect);
				$rep = mysql_fetch_array($resultat);
				$organisme_courant = $rep['org_ID'];
				$etablisement_courant= $rep['Hop_ID'];
				print("<u>Organisme courant: </u>".$organisme_courant." (".$rep['hop_nom'].")<br>");
				break;
			case 'jour':$date_courante = ($data);//print($date_courante."<br>"); 
					break;
			case 'service_nom':$service_courant_nom = $data; break;
			case 'service_id':$service_courant_id = $data; break;
			case 'nom_UF':$uf_courante_nom = $data; break;
			case 'id_UF':$uf_courante_id = $data; break;
			
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
function parse_file($file)
{
  $deep = 0;
  global $fp,$path;
  // analyse de l'ent�te
  print("<br>");
  $titre = explode('_',$file);
  print('type: '.$titre[0].'<br>');
  print('finess: '.$titre[1].'<br>');
  print('date: '.$titre[2].'<br>');
  $file = $path.$file;
  print($file.'<br>');
  print("<br>");
  
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