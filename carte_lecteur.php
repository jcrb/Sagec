<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			carte_lecteur.php															   //
//	date de création: 	31/01/2004															   //
//	auteur:				jcb																	   //
//	description:		affichage de la carte des secteurs									 								   //
//	version:			1.0																	   //
//	maj le:				31/01/2004										   //
//																							   //  
//---------------------------------------------------------------------------------------------//
//
/*
print("<HEAD><TITTLE>Lecteur de cartes</TITTLE></HEAD>");
print("<FRAMESET COLS=\"170,*\">");
print("<FRAME NAME=\"sidebar\" SRC=\"menu_carte.php\" FRAMEBORDER=\"YES\" NORESIZE>");
print("<FRAME NAME=\"dessin\" SRC=\"biotox_carto.php\" FRAMEBORDER=\"YES\" NORESIZE>");
print("</FRAMESET>");
* */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>

<html>

<head>
<NOFRAMES>
<title>Cartographie &quot;Biotox&quot; </title>
<meta name="keywords"
content="" lang="fr">
</NOFRAMES>
</head>

<frameset frameborder="0" border="0" framespacing="0" cols="250,*">
  <frame name="gauche" src="menu_carte.php" marginheight="0" marginwidth="0" scrolling="no" noresize>
  <frame name="centre" src="biotox_image.php" marginheight="0" marginwidth="15" scrolling="yes" >
  <noframes>
  <body bgcolor="#FFFFFF">
  <p>Cette page utilise des cadres, mais votre navigateur ne les prend pas en charge.</p>
  </body>
  </noframes>
</frameset>
</html>
