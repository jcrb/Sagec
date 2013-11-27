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
//-------------------------------------------------------------------------------------------------------
/**
* quelle_date.php
* Crée et affiche un calendrier
*
* @author Jean-Claude Bartier
* @version 1.0
* @copyright jcb
* @date 11/11/2004
*/
//-------------------------------------------------------------------------------------------------------
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<form name=\"tab_gard\" METHOD=\"GET\" ACTION=\"garde_assu_cus.php\" target=\"bas\">");
print("<FIELDSET>");
$aujourdui = date("Y-m-j");//date("j/m/Y");
$time = time("H:i");
//-------------------------------------------- Calendrier ------------------------------
print("<TABLE WIDTH=\"100%\">");
print("<TR>");
	print("<TD>Date</TD>");
	print("<TD><input TYPE=\"text\" VALUE=\"$aujourdui\" NAME=\"date\" SIZE = \"10\">");
	print("<input type='button' value='...' onClick= \"window.open('../mycalendar.php?form=tab_gard&elem=date', 'Calendrier','width=200,height=220')\"></TD>");
	print("<TD><input TYPE=\"submit\" VALUE=\"Valider\" NAME=\"btn1\"></TD>");
print("</TR>");
print("<TABLE>");
?>
