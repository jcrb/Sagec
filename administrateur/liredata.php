<?php
// analyse des décisions de la régulation
// programme centaure
// lecture des données texte
//================================================================================
print("<BODY>");
print("<FORM name=\"menu\" method=\"get\" action=\"fichier_analyses.php\">");
print("<table>");
print("<tr>");// fichier à charger
	print("<td>Fichier source</td>");
	print("<td><input type=\"file\" lang=\"fr\" name=\"fichier\" size=\"50\"/td>");
print("</tr>");
print("<tr>");// fichier à charger
	print("<td>Chemin d'accès</td>");
	print("<td><input type=\"file\" lang=\"fr\" name=\"chemin\" size=\"50\"/td>");
print("</tr>");
print("<tr>");
	print("<td>options</td>");
	print("<td><input type=\"radio\" checked name=\"opt\" value=\"1\">fusionne la table et le fichier</td>");
print("</tr>");
print("<tr>");
	print("<td>&nbsp;</td>");
	print("<td><input type=\"radio\" name=\"opt\" value=\"2\">le fichier annule et remplace la table</td>");
print("</tr>");
print("<tr>");
	print("<td>&nbsp;</td>");
	print("<td><input type = \"submit\" name = \"ok\" value=\"OK\"></td>");
print("</tr>");
print("</table>");
print("</form>");
?>
