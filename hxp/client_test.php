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
*	programme: 		client_test.php
*	date de création: 	19/04/2005
*	auteur:			jcb
*	description:		serveur XML-RPC
*	version:			$Id: serveur.php 41 2008-03-08 14:36:50Z jcb $
*	maj le:			19/04/2005
*/
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
include('IXR_Library.inc.php');
//require('victimes2xml.php');

function appelle_serveur()
{
  $header['usr'] = 'ies';
  $header['pw'] = 'ies';
  $header['lang'] = 'GE';
  
  $client = new IXR_Client('http://localhost/html/sagec3/hxp/serveur_test.php');
  if (!$client->query('Person.Name.Last',$header)){
			die('Something went wrong '.$client->getErrorCode().' : '.$client->getErrorMessage());
		}
		$reponse = $client->getResponse();
		print_r($reponse);
		print('<br>');

}

appelle_serveur();
?>

