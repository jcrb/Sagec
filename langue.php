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

// version 1.1 correction bug drapeau: en cliquant sur un drapeau on peut accéder au bon dialogue d'entrée

include("utilitaires/table.php");
include("html.php");

print("<html>");
print("<head>");
print("<title> SAGEC 67 </title>");
print("<link rel=\"shortcut icon\" href=\"./images/sagec67.ico\"/>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");
// TITRE
print("<form action=\"login_dialogue.php\" method=\"POST\">");
?>

<table width="100%" border="1" bordercolor="#660066">
  <!--DWLayoutTable-->
  <tr>
    <td width="21%"><div align="center"><img src="images/Logo_SAGEC3.gif" width="156" height="79"></div></td>
    <td width="79%">&nbsp;</td>
  </tr>
</table>
<?php
TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule("<INPUT TYPE = \"image\" WIDTH =\"50\" HEIGTH =\"50\" src = \"images/France.gif\" NAME=\"langue\" value=\"Français\" />");
		TblCellule("<INPUT TYPE = \"image\" WIDTH =\"50\" HEIGTH =\"50\" src = \"images/Allemagne.gif\" NAME=\"langue\" value=\"Deutsch\"/>");
		TblCellule("<INPUT TYPE = \"image\" WIDTH =\"50\" HEIGTH =\"50\" src = \"images/RoyaumeUni.gif\" NAME=\"langue\" value=\"English\"/>");
	TblFinLigne();
	TblDebutLigne();
		
		TblCellule("<INPUT TYPE = SUBMIT VALUE =\"Français\" NAME=\"langue\" />");
		TblCellule("<INPUT TYPE = SUBMIT VALUE =\"Deutsch\" NAME=\"langue\"/>");
		TblCellule("<INPUT TYPE = SUBMIT VALUE =\"English\" NAME=\"langue\"/>");
		
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale
TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule(Ancre ("http://www.conference-rhin-sup.org", Image("images/entwurf6a.jpeg")),2);
		TblCellule("<H2><DIV align=\"center\">Conférence du Rhin Supérieur</DIV align=\"center\"></H2>");
		TblCellule(Ancre ("http://www.chru-strasbourg.fr",Image("images/logohus.gif")),2);
		TblCellule(" ");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("<H2><DIV align=\"center\">Oberrheinkonferenz</DIV align=\"center\"></H2>");
	TblFinLigne();
TblFin();
print("</div>");
print("</body>");
print("</form>");
print("</html>");
?>
