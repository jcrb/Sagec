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
/**
*	programme: 		crisehus_menu.php
*	date de cr�ation: 	08/12/2005
*	auteur:			jcb
*	description:
*	@version:		$Id: crisehus_menu.php 36 2008-02-22 16:05:49Z jcb $
*	maj le:			08/12/2005
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require("../html.php");
$langue = $_SESSION['langue'];

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"crise.css\" TYPE =\"text/css\"></HEAD>");
print("</head>");

print("<FORM name=\"arh\" method=\"get\" ACTION=\"arh_data_samu.php\" target=\"middle\">");
?>
<ul id=menu>
	
	<li><a href="etat_lits.php" target="middle"><?php echo('Etat des lits');?></a>
	
	<li><a href="formulaire_services.php" target="middle"><?php echo('Formulaire services');?></a>
	<li><a href="cc_main.php" target="_parent"><?php echo('cc_main');?></a>
	<li><a href="../login2.php" target="_parent"><?php echo('Retour au menu');?></a>
	<?php
	if($_SESSION['autorisation']>8)
	{
		print("<li><a href=\"admin.php\" target=\"middle\">Administration</a>");
	}
	?>
</ul>
<?
print("</form>");
print("</body>");
?>
