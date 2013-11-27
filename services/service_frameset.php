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
//												//
//	programme: 		service_frameset.php						//
//	date de cr?ation: 	19/04/2004							//
//	auteur:			jcb								//
//	description:										//
//	version:		1.0								//
//	maj le:			11/04/2004
//												//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

print("<html>");

print("<head>");
print("<title>SAGEC67 - Gestion des services; </title>");
print("<meta name=\"keywords\" content=\"\" lang=\"fr\">");
print("<LINK REL = \"stylesheet\" TYPE = \"text/css\" HREF = \"service.css\">");
print("</head>");

print("<frameset frameborder=\"1\" border=\"1\" framespacing=\"0\" rows=\"97,*\">");
  print("<frame name=\"sup\" src=\"service_head.php\" marginheight=\"0\" marginwidth=\"0\" scrolling=\"no\" noresize>");
  print("<frameset frameborder=\"2\" border=\"2\" framespacing=\"0\" cols=\"212,*\">");

  	 print("<frame name=\"left\" src=\"service_menu.php\" marginheight=\"5\" marginwidth=\"15\" scrolling=\"yes\">");
	 print("<frame name=\"midle\" src=\"service_liste.php\" id=\"midle\" marginheight=\"5\" marginwidth=\"15\" scrolling=\"yes\">");

print("</frameset>");

// si les frames ne sont pas support?es
print("<noframes>");
	print("body bgcolor=\"#FFFFFF\">");
 	print("<p>Cette page utilise des cadres, mais votre navigateur ne les prend pas en charge.</p>");
print("</body>");
print("</noframes>");
print("</html>");
?>
