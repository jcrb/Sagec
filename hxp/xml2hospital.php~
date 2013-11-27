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
/** xml2hospital.php
* 	enregistre les données du dernier évènement courant dans le fichier administrateur/sauvegarde
*	date de création: 	10/11/2004		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
*	maj le:				14/08/2006	
* 	@TODO: vérifier si tout est sauvegardé 
*	@package			sagec
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
include ('../utilitaires/stack.php');

$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

// Parser XML
  $file = "hospital.xml";
  global $deep;
  $stack = new Stack();
  
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
	
	$deep++;
	$balise_courante = $name;
	$stack->push($balise_courante);
	$stack->write_stack();
	print($deep.'<br>');
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
	
	$deep--;
	$element = $stack->pop();// dépile le dernier élémment
	$balise_courante = $stack->top();
	$stack->write_stack();
	print($deep.'<br>');
	if( $name == "Hospital")
		enregistre_hopital();// nouvel hop, il faut enregistrer le précédant
  }
/** ---------------------------------------------------------------------
Analyse du texte présent entre les 2 balises
@param $parser un objet parseur
@param $data texte
------------------------------------------------------------------------*/
function enregistre_hopital()
{
  global $hop;
	global $connect;

	print("------------------------ Enregistre Hopital -------------------------<br>");
  $requete = "SELECT Hop_ID FROM hopital WHERE Hop_finess = '$hop[Hop_finess]'";
  $resultat = ExecRequete($requete,$connect);
  $rub = mysql_fetch_array($resultat);
  if($rub['Hop_ID'])
  {
    // l'hopital existe
    $requete = "UPDATE hopital SET 
                Hop_Nom = '$hop[Hop_nom]' 
                WHERE Hop_ID = '$rub[Hop_ID]'";
  }
  else
  {
    // nouvel hopital
    $requete = "INSERT INTO hopital 
                ('Hop_ID,Hop_nom)
                VALUES('','$hop[Hop_nom]')
                ";
  }
  // $resultat = ExecRequete($requete,$connect);
  print($requete);print("<br>");
}
/** ---------------------------------------------------------------------
Analyse du texte présent entre les 2 balises
@param $parser un objet parseur
@param $data texte
------------------------------------------------------------------------*/
  function texte($parser, $data)
  {
  	global $balise_courante;
	global $hop;
	global $fp;
	global $stack;

	if($data != ''&& $data!='\r\n')
	{
		print($balise_courante." -> ".$data.'<br>');
	
		switch($balise_courante)
		{
        
		case "ID_Hospital":$hop['Hop_finess'] = $data;break;
        case "Designation":$hop['Hop_nom'] = $data;break;
        case "Working_group":
          switch($data){
            case 'Undefine':$hop['type_etablissement_ID']= 0;break;
            case 'public':$hop['type_etablissement_ID']= 1;break;
            case 'private':$hop['type_etablissement_ID']= 2;break;
            case 'private subsidized':$hop['type_etablissement_ID']= 3;break;}
          break;
	    case "Helicopter":
          switch($data){
            case 'No':$hop['Hop_DZ']=0;break;
            case 'Roof':$hop['Hop_DZ']=1;break;
            case 'Ground':$hop['Hop_DZ']=2;break;
            case 'Far':$hop['Hop_DZ']=3;break;}
          break;
        case 'Degree_of_longitude':$rub['ville_longitude']= $data;break;
        case 'Degree_of_latitude':$rub['ville_latitude']= $data;break;
		case 'Country':$rub['country']= $data;break;
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
  $deep = 0;
  global $fp;
	// création du parser
  $parser = xml_parser_create("ISO-8859-1");
	// les balises ne sont pas transformées en majuscules
  xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
  set_handlers($parser);
  if (!($fp = fopen($file, "r"))) {die("could not open XML input");}
  while ($data = fread($fp, 4096)) 
  {
	print($data.'<br>');
	//$data = utf8_encode($data);
  	lit_une_ligne($parser, $data,$fp);
  }
xml_parser_free($parser);


?>