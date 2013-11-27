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
//	programme: 				ppi_menu.php
//	date de création: 	29/10/2008 
//	auteur:					jcb
//	description:		
//	version:					1.0
//	maj le:					29/10/2008 
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require '../utilitaires/globals_string_lang.php';
include_once("../dbConnection.php");
$langue = $_SESSION['langue'];
?>
<HTML>
<HEAD>
<title>menu PPI</title>
<link rel="stylesheet" type="text/css" href="hopital2.css" />
</head>

<?php
print("<FORM name=\"arh\" method=\"get\" ACTION=\"arh_data_samu.php\" target=\"middle\">");
//$string_lang[$langue]["INTROCUCTION"];
?>
<ul id=menu>
	<li><a href="hopitaux_par_zone.php" target="middle"><?php echo($string_lang['HOPITAUX'][$langue]);?></a>
	<li><a href="hopital_synthese.php" target="middle"><?php echo($string_lang['SYNTHESE'][$langue]." 1");?></a>
	<li><a href="hopital_voir_synthese.php" target="middle"><?php echo($string_lang['SYNTHESE'][$langue]." 2");?></a>
	<li><a href="choix_hopital.php" target="middle"><?php echo($string_lang['LISTE'][$langue]." 1");?></a>
	<li><a href="voir_hopital.php" target="middle"><?php echo($string_lang['LISTE'][$langue]." 2");?></a> 
</ul>
<?
print("</form>");
print("</body>");
print("</html>");
?>
