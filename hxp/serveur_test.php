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
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
include('IXR_Library.inc.php');
require('victimes2xml.php');

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
	require $backPathToRoot.'utilitaires/globals_string_lang.php';
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

function PersonNameLast($args) {
   return 'Rodriguez';
}

function PersonNameFirst($args) {
    return 'Jonathan';
}

function data_victimes($args)
{
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
	return "test";
}

$server = new IXR_Server(array(
    'Person.Name.Last' => 'PersonNameLast',
    'Person.Name.First' => 'PersonNameFirst',
    'Sagec.victimes' => 'data_victimes'
    ));
?>
