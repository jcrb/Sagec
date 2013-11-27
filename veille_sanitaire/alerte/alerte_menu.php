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
//---------------------------------------------------------------------------------------------------------
/**
* 	alertes sanitaires
*	@programme 		alerte_menu.php
*	@date de création: 	20/01/2007
*	@author jcb
*	@version $Id$
*	@update le 20/01/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
print("<html>");
print("<head>");
print("<title> Alertes sanitaires </title>");
print("<LINK REL=stylesheet HREF=\"../../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM name =\"alerte\" ACTION=\"cusum.php\" METHOD=\"GET\">");
?>
<ul id="menu">
	<li><a href="alerte_sau.php" target="bottom"><?php echo('Sélection');?></a>
	<li><a href="../../sagec67.php" target="middle"><?php echo('Retour');?></a>
</ul>
<?php

print("</form>");
print("</BODY>");
print("</html>");
?>