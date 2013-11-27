<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 		cle_valide_execute.php
//	date de création: 	15/05/2005
//	auteur:			jcb
//	description:		exporte une clé de cryptage
//	version:			1.0
//	maj le:			15/05/2005
//
/**
 * Documents the class following
 * @package Sagec
 * @author JCB
 */
//
//========================== Cryptographie =================================
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_hopital'])header("Location:logout.php");
//
require('../gnugpg/gnuPG_class.inc');
require("trousseau.php");
//
// create the instance, giving the program path and home directory
//$gpg = new gnuPG('/usr/bin/gpg', '/var/www/html/sagec3/veille_sanitaire');// SAGEC
$gpg = new gnuPG('/home1/gnupg/bin/gpg', '/home1/apache/.gnupg');//HUS
//
if($_GET['cle'])
{
	$cle1 = "MA_CLEF";
	$pass = 'PASS';
	// signature
	$err = $gpg->SignKey($cle1, $pass, $_GET['cle'],3);
	if($err == false) 
		print($gpg->error);
	else print('OK');print($gpg->error);
	//$e = $gpg->Export($_GET['cle']);
	//if(!$e) print("erreur: ".$gpg->error."<br>");
}