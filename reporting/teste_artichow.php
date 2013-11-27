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
//---------------------------------------------------------------------------------------------------------file:///home/jcb/html/sagec3/reporting/teste_artichow.php

/**
* 	
*	@programme 		teste_artichow.php
*	@date de création: 	01/03/2007
*	@author jcb
*	@version $Id$
*	@update le 01/03/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

print("<table>");
	print("<tr>");
		print("<td><a href=\"histogramme_artichow.php\">Histogramme</a></td>");
	print("</tr>");
	print("<tr>");
		print("<td><a href=\"graphe_artichow.php\">Graphe</a></td>");
	print("</tr>");
	print("<tr>");
		print("<td><a href=\"pie_artichow.php\">Camembert</a></td>");
		print("<td><a href=\"requete_pie.php\">Camembert2</a></td>");
		print("<td><a href=\"analyse_reanimation.php\">Réanimation</a></td>");
		print("<td><a href=\"analyse_usic_nhc.php\">USIC NHC</a></td>");
	print("</tr>");
print("</table>");
?>