<?
// quelle_date.php
print("<FORM name=\"date\" method=\"get\" ACTION=\"lits_dispo.php\" target=\"middle\">");
$today = time()-24*60*60;
$today = date("j/m/Y",$today);// date de la veille par d�faut
print("Compte rendu pour la journ�e du<br>");
print("<input type=\"text\" name=\"date\" value=\"$today\" size=\"10\"><br>");
print("<input type=\"submit\" name=\"ok\" value=\"Ex�cuter\" size=\"\"><br>");
?>