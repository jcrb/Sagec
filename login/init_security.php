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
//
//	programme:			init_security.php		
//	date de cr�ation:	04/06/2008
//	auteur:				dnd										
//	description:		Initialise des variables pour l'exploitation	
//	version:			1.0																 //
//
//---------------------------------------------------------------------------------------------------------

if (!isset ($_SESSION["config_magic_quotes"]))
	$_SESSION["config_magic_quotes"] = get_magic_quotes_gpc();
$config_magic_quotes = ($_SESSION["config_magic_quotes"] == 1);


/**
* utilisation Security::esc2Db($rubrique)
*/
class Security{

	// Escape String for a database use.
	function &esc2Db($str){
		//return mysql_real_escape_string($str);
		$rep = addslashes($str);
		return $rep;
	}
	
	// idem + encode en utf8	Security::str2db($str)
	function &str2db($str){
		$rep =  addslashes(utf8_encode($str));
		return $rep;
	}
	
	// idem + d�code utf Security::db2str($rubrique) 
	function &db2str($str){
		$rep =  stripslashes(utf8_decode($str));
		return $rep;
	}
}

?>
