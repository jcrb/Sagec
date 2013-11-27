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
//	programme: 		apa_menu.php
//	date de création: 	08/12/2005
//	auteur:			jcb
//	description:		
//	version:		1.0
//	maj le:			08/12/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."html.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
$langue = $_SESSION['langue'];
?>

<HTML>
	<HEAD>
		<TITLE>Sauvegarde</TITLE>
		<LINK REL=stylesheet HREF="../brules/brule.css" TYPE ="text/css">
		<title>menu associations</title>");
		<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
	"</head>

<FORM name="arh" method="get" ACTION="arh_data_samu.php" target="middle">

<ul id=menu>
	<li><a href="asso_main.php">Association</a>
	<li><a href="">Moyens</a>
	<li><a href="">Organisation</a>
	<li><a href="">Victimes</a>
	<li><a href="">Documents</a>
	<li><a href="">Postes de secours</a>
	<li><a href="">Changer de mot de passe</a>
	<li><a href="">Quitter la session</a>
</ul>

</form>
</body>
</html>