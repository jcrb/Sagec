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
//
//	programme: 		a.php
//	@date de création: 	2004
//	@author:			jcb
//	description:
//	@version:			1.0
//	maj le:			2004
// @version $Id: a.php 23 2007-09-21 03:50:41Z jcb $
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
require("pma_requete.php");
require("pma_connect.php");
require("pma_connexion.php");

//======================= En Tête ====================================
print("<HTML><HEAD>");
print("<TITLE>a</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</HEAD>");
//====================== Corps =======================================
print("<BODY>");
print("<FORM NAME=\"\" ACTION=\"\" METHOD=\"POST\">");

print("</FORM>");
print("</BODY>");
print("</HTML>");
?>