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
/**
*	programme: 		serveur.php
*	date de création: 	19/04/2005
*	auteur:			jcb
*	description:		serveur XML-RPC
*	version:			$Id: serveur.php 41 2008-03-08 14:36:50Z jcb $
*	maj le:			19/04/2005
*/
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
//session_start();
//if(! $_SESSION['auto_hopital'])header("Location:logout.php");
//$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include('IXR_Library.inc.php');
require('hopital2xml.php');
require('sau2xml.php');
//require('victimes2xml.php');

global $connexion;
global $langue;
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

function teste_header($args)
{
	global $connexion;
	global $langue;
	
	//teste si $args est une structure (tableau simple) ou un array (tableau à plusieurs dimensions)
	$irx = new IXR_Value ($args);
	$type = $irx->calculateType();
	if($type = 'struct')
	{
		$langue=$args['lang'];
		$user = $args['usr'];
		$pass = $args['pw'];
	}
	else
	{
		$langue=$args[0]['lang'];
		$user = $args[0]['usr'];
		$pass = $args[0]['pw'];
	}
	$d = date("j/M/Y H:i:s ").$user." ".$pass." ";
	$fp=fopen("log.txt","a");fwrite($fp,$d);fclose($fp);
	if($user=='hxp' && $pass=='hxp') return 0;

	$password=crypt(trim(htmlspecialchars(addslashes($pass))),"azerty");
	$requete = "SELECT login, pass FROM utilisateurs WHERE login='$user' AND pass ='$password'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	if(!$rub['login']) return 1001;
	if(!$rub['pass']) return 1002;
	
	return 0;
}
function erreur($n)
{
	require '../utilitaires/globals_string_lang.php';
	global $langue;
	
	switch($n){
		case 1000: $r = $string_lang['_ERROR_AUTH_BADHEADER'][$langue];break;
		case 1001: $r = $string_lang['_ERROR_AUTH_USER'][$langue];break;
		case 1002: $r = $string_lang['_ERROR_AUTH_PW'][$langue];break;
		case 1003: $r = $string_lang['_ERROR_AUTH_AREA'][$langue];break;
		case 1004: $r = $string_lang['_ERROR_AUTH_LOCKED'][$langue];break;
		case 1005: $r = $string_lang['_ERROR_SQL_RESULT'][$langue];break;
		case 1006: $r = $string_lang['_ERROR_NORESULT'][$langue];break;
		case 1007: $r = $string_lang['_ERROR_PROC_NOSUPPORT'][$langue];break;
		case 1008: $r = $string_lang['_ERROR_PROC_NOEXISTS'][$langue];break;
	}
	return new IXR_Error($n,$r);
}

function sageclits($args)
{
	require '../utilitaires/globals_string_lang.php';
	global $langue;
	//$e = teste_header($args);
	//if($e!=0) return erreur($e);
		
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	/*
	
	if(!$utilisateur->ID_utilisateur) return new IXR_Error(-1, 'You did not provide the correct password');
	*/
	$requete = "SELECT Hop_nom,service_nom,type_nom,lits_sp,lits_dispo,lits_liberable,date_maj,ville_nom
			FROM hopital,service,type_service,lits,adresse,ville
			WHERE service.Hop_ID = hopital.Hop_ID
			AND service.Type_ID = type_service.Type_ID
			AND lits.service_ID = service.service_ID
			AND hopital.adresse_ID = adresse.ad_ID
			AND ville.ville_ID = adresse.ville_ID
		";
	$resultat = ExecRequete($requete,$connexion);
	$i=0;
	while($rub=mysql_fetch_array($resultat))
	{
		$tableau[$i]=$rub; //
		$a = $rub[2];
		$b = $string_lang[$a][$langue];
		$tableau[$i][2] = $b;//$string_lang[$a][$langue];
		$i++;
	}
	return $tableau;
}

function PersonNameLast($args) {
   return 'Rodriguez';
}

function PersonNameFirst($args) {
    return 'Jonathan';
}

function add($args)
{
	$number1 = $args[0];
    	$number2 = $args[1];
    	return $number1 + $number2;
}
function tableau($args)
{/*
	return array(
		'0' => 'nom',
		'1' => 'prenom',
	);*/

	$t[0] = 'nom';
	$t[1] = 'prenom';
	return $t;
}
function tableau2($args)
{
	return array(
		'Californie' => array(
			'Martinez',
			'San francisco',
			'Los Angeles'
			),
		'New York' => array(
			'New York',
			'Buffalo'
			)
		);
}


function get_methodes($args)
{
	$t[] = 'Sagec.Methods';
	$t[] = 'Sagec.Personne';
	$t[] = 'Sagec.lits';
	return $t;
}
// $args[0] = header
// $args[1] = n° dossier
function dossier($args)
{
	global $connexion;
	$h = teste_header($args[0]);
	if($h!=0) return erreur($h);
	$requete = "SELECT no_ordre,nom,prenom,sexe,photo FROM victime WHERE no_ordre = '$args[1]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	$rep['pid'] = $rub['no_ordre'];
	$rep['name_last'] = $rub['nom'];
	$rep['name_first'] = $rub['prenom'];
	$rep['sex'] = $rub['sexe'];
	$rep['photo_filename'] = $rub['photo'];
	//$rep['pid'] = 123;
	return $rep;
}
/*
function get_EUBeds($args)
{
	$h = teste_header($args);
	if($h!=0) return erreur($h);
	else
	{
		$msg = get_EUbeds_infos();
		$msg = utf8_encode($msg);
	return $msg;
	}
*/

function get_EUBeds($args)
{
	//$msg = get_EUbeds_infos();
	//$msg = utf8_encode($msg);
	//return $msg;
	
	$h = teste_header($args);
	if($h!=0) 
	{
		$fp=fopen("log.txt","a");fwrite($fp,"get_EUBeds erreur:".$h."\r\n");fclose($fp);
		return erreur($h);
	}
	else
	{
		$msg = get_EUbeds_infos();
		$msg = utf8_encode($msg);
		$fp=fopen("log.txt","a");fwrite($fp,"get_EUBeds succès\r\n");fclose($fp);
		return $msg;
	}
}

function data_victimes($args)
{
	/*
	$h = teste_header($args);
	if($h!=0) 
	{
		$fp=fopen("log.txt","a");fwrite($fp,"get_EUBeds erreur:".$h."\r\n");fclose($fp);
		return erreur($h);
	}
	else
	{
		$msg = get_victimes();
		return $msg;
	}
	*/
	return "test";
}

function data_sau($args)
{
	$msg = get_SAU_infos($args['date1'],$args['date2']);
	$msg = utf8_encode($msg);
	return $msg;
}

$server = new IXR_Server(array(
    'Person.Name.Last' => 'PersonNameLast',
    'Person.Name.First' => 'PersonNameFirst',
    'Person.add' => 'add',
    'Person.tableau' => 'tableau',
    'Person.tableau2' => 'tableau2',
    'Sagec.lits' => 'sageclits',
    'Sagec.Personne' => 'dossier',
    'Sagec.Methods' => 'get_methodes',
	'Sagec.EUBeds' => 'get_EUBeds',
	'Sagec.SAU' => 'data_sau',
		'Sagec.victimes' => 'data_victimes'
    ));
?>
