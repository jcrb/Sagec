<?php
/**----------------------------------------- SAGEC -----------------------------
*
* This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
* SAGEC67 is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* SAGEC67 is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* You should have received a copy of the GNU General Public License
* along with SAGEC67; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*----------------------------------------- SAGEC --------------------------------
*
*	programme: 		checklist.php
*	création: 		08/08/2009
*	auteur:			jcb
*	description:	Affiche la liste des hôpitaux à contacter
*	version:			1.0
*	maj le:			08/08/2009
*
*--------------------------------------------------------------------------------
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../formstyle.css\" TYPE =\"text/css\"></HEAD>");
print("<link rel=\"stylesheet\" media=\"print, embossed\" href=\"../impression.css\">");
print("<head>");

?>
	<body>
	<form name="check" command="post" action="checklist_enregistre.php">
<?php
$requete = "SELECT * FROM tache ORDER BY tache_priorite";
$resultat = ExecRequete($requete,$connexion);

print("<table>");
$path = $path."tache_nouvelle.php?tacheID=";
while($rep = mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td bgcolor=\"#CCFF99\">".stripslashes(utf8_decode($rep[tache_ID]))."</td>");
		print("<td bgcolor=\"#FFFF66\">".stripslashes(utf8_decode($rep[tache_nom]))."</td>");
		print("<td bgcolor=\"#FFFF99\">".stripslashes(utf8_decode($rep[tache_comment]))."</td>");
		print("<td bgcolor=\"#FFFF99\">".stripslashes($rep[tache_heure])."</td>");
		print("<td  bgcolor=\"#CCFF99\"><input type=\"checkbox\" name=\"fait[]\" value=\"$rep[tache_ID]\" ");
		if($rep[tache_faite]=='o') print("checked");
		print(" onchange=\" document.check.submit()\"></td>");
		$tache = $path.$rep['tache_ID'];
		print("<td><a href=\"$tache\">M</a></td>");
	print("</tr>");
}
print("</table>");
?>
</form>
</body>
