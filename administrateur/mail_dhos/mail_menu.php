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
//----------------------------------------- SAGEC ---------------------------------------------//	
//	programme: 		mail_menu.php	
//	date de création: 	04/12/2005	
//	auteur:			jcb
//	description:
//	@version:		$d$
//	maj le:			04/12/2005
// 
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION["langue"];


print("<html>");
print("<head>");
print("<title> Menu mail </title>");
print("<LINK REL=stylesheet HREF=\"brule.css\" TYPE =\"text/css\"></HEAD>");
print("</head>");

print("<body>");
print("<FORM NAME=\"biotox_mail\">");
?>
<ul id=menu>
	<li><a href="lire_cron.php" target="middle"><?php echo('Lire la table Cron');?></a>
	<li><a href="mail_reglage.php" target="middle"><?php echo('Ajouter un script');?></a>
	<li><a href="modifie_script.php" target="middle"><?php echo('Modifier un script');?></a>
	<li><a href="supprime_script.php" target="middle"><?php echo('Supprimer un script');?></a>
</ul>
<?
print("</form>");
print("</body>");
print("</html>");
?>
