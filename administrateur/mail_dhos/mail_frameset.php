<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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

/**
	programme: 			mail_frameset.php
	date de création: 	4/12/2005
	@author:				jcb
	description:		permet de créer/modifier une table cron
	@version:			$Id: mail_frameset.php 31 2008-02-12 18:02:26Z jcb $
	maj le:				4/12/2005
*/
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
print("<html>");
print("<head>");
print("<title>SAGEC67 - cron </title>");
print("<meta name=\"keywords\" content=\"\" lang=\"fr\">");
print("</head>");
//==============================  frameset  ===============================================================
print("<frameset frameborder=\"1\" border=\"1\" framespacing=\"0\" rows=\"100,*\">");
// frame supérieure
print("<frame name=\"sup\" src=\"\" marginheight=\"0\" marginwidth=\"0\" scrolling=\"no\" noresize>");
// frame inférieure
// division de la frame inférieure en 2 sous frame, droite et gauche
print("<frameset frameborder=\"1\" border=\"1\" framespacing=\"0\" cols=\"212,*\">");
// sous-frame inférieure gauche
print("<frame name=\"gauche\" src=\"mail_menu.php\" marginheight=\"1\" marginwidth=\"1\" scrolling=\"yes\" frameborder=\"1\">");
// sous-frame inférieure droite
print("<frame name=\"middle\" src=\"lire_cron.php\" marginheight=\"5\" marginwidth=\"5\" scrolling=\"yes\" frameborder=\"1\">");
print("</frameset>");
print("</frameset>");

//===============================   si les frames ne sont pas supportées  ===================================
print("<noframes>");
	print("body bgcolor=\"#FFFFFF\">");
 	print("<p>Cette page utilise des cadres, mais votre navigateur ne les prend pas en charge.</p>");
print("</body>");
print("</noframes>");
print("</html>");
?>
