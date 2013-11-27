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
//	programme: 		cle_exporte.php
//	date de création: 	15/05/2005
//	auteur:			jcb
//	description:		exporte une clé de cryptage
//	version:			1.0
//	maj le:			15/05/2005
//
//--------------------------------------------------------------------------------
//
//========================== Cryptographie =================================
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_hopital'])header("Location:logout.php");

require('../gnugpg/gnuPG_class.inc');
require("../../html.php");
include("cle_menue.php");

// create the instance, giving the program path and home directory
$gpg = new gnuPG('/usr/bin/gpg', '/var/www/html/sagec3/veille_sanitaire');

	// get the keys in the keyring
	print("<br>");
	print("Exporter une clé<br><br>");
	$Keys = $gpg->ListKeys('public');
	if (is_array($Keys)) {
		print("<table>");
		for($i=0;$i<count($Keys);$i++){
			print("<tr>");
			$cle = $Keys[$i]['KeyID'];
			print("<td><A href=\"cle_exporte_execute.php?cle=$cle\">exporter</A></TD>");
			print("<td bgcolor=\"lightblue\">".$Keys[$i]['KeyID']."</td>");
			print("<td>".$Keys[$i]['UserID']."</td>");
			//print($Keys[$i]['KeyID']."  ".$Keys[$i]['UserID']."<br>");
			print("</tr>");
		}
		print("<table>");
	}
?>