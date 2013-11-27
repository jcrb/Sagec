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
//	programme: 		cle_disponible.php
//	date de création: 	15/05/2005
//	auteur:			jcb
//	description:		clés de cryptage disponibles
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
require('../gnugpg/gnuPG_class.inc');
require("../../html.php");
include("cle_menue.php");

	// create the instance, giving the program path and home directory
	//$gpg = new gnuPG('/usr/bin/gpg', '/var/www/html/sagec3/veille_sanitaire');
	//$gpg = new gnuPG('/usr/bin/gpg', '/home/jcb/.gnupg');
	$gpg = new gnuPG('/home1/gnupg/bin/gpg', '/home1/apache/.gnupg');//HUS
	// get the keys in the keyring
	print("<br>");
	print("Liste des clés<br><br>");
	$Keys = $gpg->ListKeys('public');
	if (is_array($Keys)) {
		print("<table>");
		for($i=0;$i<count($Keys);$i++){
			print("<tr>");
			print("<td bgcolor=\"lightblue\">".$Keys[$i]['KeyID']."</td>");
			print("<td>".$Keys[$i]['UserID']."</td>");
			//print($Keys[$i]['KeyID']."  ".$Keys[$i]['UserID']."<br>");
			print("</tr>");
		}
		print("<table>");
	}
?>
