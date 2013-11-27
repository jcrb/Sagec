<?php
/**
*	crra_sup.php
*
*
*/
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<HTML>");
print("<HEAD>");
print("<META NAME=\"author JCB\"> ");
print("<TITLE>Satut CRRA</TITLE>");
//<comment> rafraichissement automatique toutes les 30 secondes </comment>
print("<meta http-equiv=\"refresh\" content=\"30\">");
print("</HEAD>");

print("<BODY>");
print("<FORM name =\"statut_crra\">");
print("<table width=\100%\"  bgcolor=\"azure\">");
	print("<tr>");
		print("<td width=\"200\" bgcolor=\"silver\">");
			// entête CRRA
			print("<table>");
				print("<tr><td><b></b>CRRA - SAMU 67</b></td></tr>");
				print("<tr><td>".date("d-m-Y")."</td></tr>");
				print("<tr><td>".date("H:i:s")."</td></tr>");
			print("</table>");
		print("</td>");
		print("<td width=\"500\">");
			// bargraphe
			$requete = "SELECT priorite,COUNT(*) FROM taches_crra WHERE statut = '0' GROUP BY priorite";
			$resultat = ExecRequete($requete,$connexion);
			print("<table width=\100%\">");
				while($rep=mySql_fetch_array($resultat))
				{
					print("<tr>");
					print("<td bgcolor=\"peachpuff\">Priorité ".$rep['priorite']."</td>");
					print("<td>".$rep[1]." tache(s) en attente</td>");
					print("<td>");
					print("<table border=\"1\" width=\100%\"><tr>");
					for($i=0;$i<$rep[1];$i++)
						print("<td bgcolor=\"red\">&nbsp;</td>");
					print("</tr></table>");
					print("</td>");
					print("</tr>");
				}
			print("</table>");
		print("</td>");
	print("</tr>");
print("</table>");
	


print("</FORM>");
print("</BODY>");
print("<HTML>");
?>