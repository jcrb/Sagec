<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		test_uf_maj.php
*	description:	gestion des UF
*	date de création: 	17/02/2008
*	@author:			jcb
*	@version:		$Id$
*	maj le:			
*/
//---------------------------------------------------------------------------------------------------------
//
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("uf_maj.php");

print("<table>");
	print("<tr>");
		print("<a href=
	print("</tr>");
print("</table>");
?>