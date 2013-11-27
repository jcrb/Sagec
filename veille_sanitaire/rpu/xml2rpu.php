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
/** xml2rpu.php
* 	enregistre les données du dernier évènement courant dans le fichier administrateur/sauvegarde
*	date de création: 	10/11/2004		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
*	maj le:				14/08/2006	
* 	@TODO: vérifier si tout est sauvegardé 
*	@package			sagec

*	REMARQUE: le schema proposé par l'INVS ne respecte pas le format ISO pour les dates
*	Ces dernières doivent être transfrrmée de JJ/MM/AAAA en AAAA/MM/JJ
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
$path = $backPathToRoot."sagec_echange/statistiques/";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");
include ($backPathToRoot.'utilitaires/stack.php');


// Parser XML
  //$file = "RPU_670780691_090510.xml";
  global $deep;
  $stack = new Stack();
  $DEBUG = false;
  
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
	global $rpu;
	global $nb_da;			// compteur des diag associés
	global $rpu_da;		// tableau des diag associés
	global $nb_actes;		// compteur d'actes
	global $rpu_actes;	// tableau des actes associés à un dossier
	
	$balise_courante = $name;
	switch($balise_courante){
		case 'PATIENT':
			$rpu = Array();
		case 'LISTE_DA': 
			$nb_da = 0;
			$rpu_da = Array();
			break;	// le compteur de DA est mis à 0
		case 'LISTE_ACTES': $nb_actes = 0;$rpu_actes = Array();break;	// le compteur de DA est mis à 0
	}
	
	$deep++;
	$stack->push($balise_courante);
	if($DEBUG)$stack->write_stack();
	if($DEBUG) print($deep.'<br>');
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
	
	switch($balise_courante){
	case "PATIENT":
		enregistre_rpu();// nouvel hop, il faut enregistrer le précédant
		if($DEBUG) print("<br>=================================================================================<br>");
	}
	
	$deep--;
	$element = $stack->pop();// dépile le dernier élémment
	$balise_courante = $stack->top();
	if($DEBUG)$stack->write_stack();
	if($DEBUG) print($deep.'<br>');
  }
/** ---------------------------------------------------------------------
Analyse du texte présent entre les 2 balises
@param $parser un objet parseur
@param $data texte
------------------------------------------------------------------------*/
function enregistre_rpu()
{
	global $rpu;
	global $hop;
	global $connexion;
	global $nb_da;	// compteur diag associés 
	global $rpu_da; // tableau des DA
	global $nb_actes;		// compteur d'actes
	global $rpu_actes;	// tableau des actes associés à un dossier
	
	$requete = "INSERT INTO rpu(rpu_ID,finess ,date_extraction ,date_jour ,zip ,ville ,date_naissance ,sexe ,date_entree ,
	mode_entree ,provenance ,transport ,transport_pec ,motif ,ccmu ,diag_principal ,date_sortie ,mode_sortie ,destination ,orientation)
	VALUES(NULL,'$hop[finess]','$hop[date_extraction]','$hop[date_jour]','$rpu[cp]','$rpu[commune]','$rpu[date_naissance]','$rpu[sexe]','$rpu[date_entree]',
	 '$rpu[mode_entree]','$rpu[provenance]','$rpu[transport]','$rpu[transport_pec]','$rpu[motif]','$rpu[ccmu]','$rpu[diag_principal]', '$rpu[date_sortie]', 
	 '$rpu[mode_sortie]', '$rpu[destination]', '$rpu[orientation]')";
	$resultat = ExecRequete($requete,$connexion);
	if($DEBUG) print($requete."<br>");
	
	$idRpu = mysql_insert_id();
	
	for($i=0; $i<$nb_da;$i++)
	{
		$requete = "INSERT INTO rpu_diagAssocie VALUES('$idRpu','$rpu_da[$i]')";
		ExecRequete($requete,$connexion);
		if($DEBUG) print($requete."<br>");
	}
	for($i=0; $i<$nb_actes;$i++)
	{
		$requete = "INSERT INTO rpu_actes (rpu_ID,acte_ID) VALUES('$idRpu','$rpu_actes[$i]')";
		ExecRequete($requete,$connexion);
		if($DEBUG) print($requete."<br>");
	}

}
/** ---------------------------------------------------------------------
Analyse du texte présent entre les 2 balises
@param $parser un objet parseur
@param $data texte
------------------------------------------------------------------------*/
  function texte($parser, $data)
  {
  	global $balise_courante;
	global $rpu;
	global $hop;
	global $fp;
	global $stack;
	global $nb_da;	// compteur diag associés 
	global $rpu_da; // tableau des DA
	global $nb_actes;		// compteur d'actes
	global $rpu_actes;	// tableau des actes associés à un dossier

	if($data != ''&& $data!='\r\n')
	{
		if($DEBUG) print($balise_courante." -> ".$data.'<br>');
	
		switch($balise_courante)
		{
			case 'FINESS':$hop['finess'] = $data;break;
			case 'ORDRE':$hop['ordre'] = $data;break;
			case 'EXTRACT': $hop['date_extraction'] = uDateTime2MySql(fDateTime2unix($data));break; // jour où l'extraction a été faite
			case 'DATEDEBUT': $hop['date_jour'] = uDate2MySql(fDate2unix($data));break; // jour concerné
			case 'DATEFIN':break;
			
			//case 'PATIENT':break; // nouveau patient, remettre à 0 le tnleau des DA et TTT associés
			case 'CP':$rpu['cp'] = $data;break;
			case 'COMMUNE':$rpu['commune'] = $data;break;
			case 'NAISSANCE':$rpu['date_naissance'] = uDate2MySql(fDate2unix($data));break;
			case 'SEXE':$rpu['sexe'] = $data;break;
			case 'ENTREE':$rpu['date_entree'] = uDateTime2MySql(fDateTime2unix($data));break;
			case 'MODE_ENTREE':$rpu['mode_entree'] = $data;break;
			case 'PROVENANCE':$rpu['provenance'] = $data;break;
			case 'TRANSPORT':$rpu['transport'] = $data;break;
			case 'TRANSPORT_PEC':$rpu['transport_pec'] = $data;break;
			case 'MOTIF':$rpu['motif'] = $data;break;
			case 'HMED':$rpu['hmed'] = $data;break;
			case 'GRAVITE':$rpu['ccmu'] = $data;break;
			case 'DP':$rpu['diag_principal'] = $data;break;
			case 'SORTIE':$rpu['date_sortie'] = uDateTime2MySql(fDateTime2unix($data));break;
			case 'MODE_SORTIE':$rpu['mode_sortie'] = $data;break;
			case 'DESTINATION':$rpu['destination'] = $data;break;
			case 'ORIENT':$rpu['orientation'] = $data;break;
			
			case 'DA': $rpu_da[$nb_da]=$data;$nb_da++;break;
			case 'ACTE': $rpu_actes[$nb_actes]=$data;$nb_actes++;break;
		}
	}
  }
/** ---------------------------------------------------------------------
méthode par défaut
------------------------------------------------------------------------*/
  function defaut()
  {
  	return true;
  }
/** ---------------------------------------------------------------------
Initialisation des 3 méthodes de base pour un parseur de type SAX
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
@param $data les données lues.
@param $fp le fichier source.
------------------------------------------------------------------------*/
  function lit_une_ligne($parser, $data,$fp)
  {
  	if (!xml_parse($parser, $data, feof($fp)))
    	{
        	die(sprintf("erreur XML: %s à la ligne %d",
                  xml_error_string(xml_get_error_code($parser)),
                  xml_get_current_line_number($parser)));
    	}
 }

/** ---------------------------------------------------------------------
main
@param $deep profondeur le l'analyse
@param $fp le fichier à lire
@param $parser parseur
------------------------------------------------------------------------*/
function parseRPU($fichierRPU)
{
  $deep = 0;
  global $fp;
  global $path;
  $file = $path.$fichierRPU;
  print("parsing ".$fichierRPU."<br>");
	// création du parser
  $parser = xml_parser_create("ISO-8859-1");
	// les balises ne sont pas transformées en majuscules
  xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
  set_handlers($parser);
  if (!($fp = fopen($file, "r"))) {die("Impossible d'ouvrir le fichier ".$file);}
  while ($data = fread($fp, 4096)) 
  {
  	if($DEBUG)print("<br>=================================================================================<br>");
	if($DEBUG)print($data.'<br>');
	//$data = utf8_encode($data);
  	lit_une_ligne($parser, $data,$fp);
  }
	xml_parser_free($parser);
}

?>