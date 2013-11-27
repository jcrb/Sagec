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
//	programme: 		synoptique_sup.php
//	date de cr�ation: 	06/02/2005
//	auteur:			jcb
//	description:		Fonctionalit� permise � l'administrateur
//	version:			1.0
//	maj le:			06/02/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require '../utilitaires/globals_string_lang.php';
$langue = $_SESSION['langue'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");
if($_SESSION['auto_sagec'])
	$a = "<a href=\"../sagec67.php\" target=\"_parent\">".$string_lang['RETOUR'][$langue]."</a>";
else
	$a = "<a href=\"../login2.php\" target=\"_parent\">".$string_lang['RETOUR'][$langue]."</a>";
//$b = "<a href=\"synoptique_tendances.php\" target=\"droite\">".$string_lang['TENDANCE'][$langue]."</a>";
$mot=$string_lang['Fermetures lits'][$langue];
$mot = "Fermetures lits";
$b = "<a href=\"../services/fermeture_regionale.php\" target=\"droite\">$mot</a>";
$mot= $string_lang['QUITTER'][$langue];
$c = "<a href=\"../logout.php\" target=\"_parent\">$mot</a>";
$menu= $a." | ".$b." | ".$c;
entete_sagec2($string_lang['SYNOPTIQUE_LITS_DISPO'][$langue],"center",$menu);
?>