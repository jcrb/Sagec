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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 			agenda.php
//	date de création: 	11/02/2006
//	auteur:				jcb
//	description:		Agenda du médecin
//	version:			1.0
//	maj le:				11/02/2006
//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require "../date.php";
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<LINK REL=stylesheet HREF=\"agenda.css\" TYPE =\"text/css\">");
?>
<script language="JavaScript">
function alerte_supprimer(no,_date,med)
{
	if(confirm("Voulez-vous vraiment supprimer ce rendez-vous ?"))
	{
		location.replace("rdv_supprime.php?rdv_ID=" + no + "&back=agenda.php&date="+_date + "&medid="+ med);
	}
}
</script>
<?php
print("</HEAD>");

print("<BODY>");
print("<form name=\"agenda\" method=\"GET\" action=\"med_consigne_enregistre.php\">");
// PROVISOIRE
$med_ID = addslashes($_REQUEST['medid']);// ID du médecin mg67 dont on lit la page d'agenda
if(!$med_ID) $med_ID = $_SESSION['auto_mg'];
$requete = "SELECT * FROM mg67 WHERE med_ID = '$med_ID'";
$resultat = ExecRequete($requete,$connexion);
$doc=mysql_fetch_array($resultat);
print("<input type=\"hidden\" name=\"medid\" value=\"$med_ID\">");
print("<H3>Agenda du Dr ".$doc['med_nom']."</H3>");
//$_SESSION['medecin'] = 1;// variable de session

// Récupère la date. Si pas de date précisé, c'est la date du jour
$date = $_GET['date'];
$today = today();
if(!$date)
	$date = today();
print("<input type=\"hidden\" name=\"date\" value=\"$date\">");

// En tête
print("<h3>");
$hier = $date - 24*60*60;
$demain  = $date + 24*60*60;
print(" | ");
print("<a href=\"agenda.php?date=$hier&medid=$med_ID\">hier</a> ");
print(" | ");
print("<a href=\"agenda.php?date=$today&medid=$med_ID\">Aujourd'hui</a> ");
print(" | ");
print(jour_de_la_semaine($date).' ');
print(date("d",$date).' ');
print(" | ");
$mois = mois_courant($date);
print(" <a href=\"\">$mois</a>  ");
$an = date("Y",$date);
print(" <a href=\"\">$an</a>  ");

$semaine = semaine_courante($date);
print(" <a href\"\">semaine"." ".$semaine."</a>");
print(" | ");
print("  <a href=\"agenda.php?date=$demain&medid=$med_ID\">demain</a>");
print(" | ");
if($_REQUEST['commune'])// on enregistre une seule fois l'adresse de retour
{
	$_SESSION['retour'] = "../".$_REQUEST['back']."?commune_id=".$_REQUEST['commune'];
	//print("retour = ".$_SESSION['retour']);
}
print("<a href=\"$_SESSION[retour]\"> RETOUR </a>");
print(" | ");
print("</h3>");

// RDV du jour
$date_unix = uDate2MySql($date);
//print($date_unix."<br>");
$requete = "SELECT * FROM mg67_rdv WHERE med_ID = '$med_ID' AND TO_DAYS(date_rdv) =TO_DAYS('$date_unix')";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$rub['date_rdv'] = mysqlDateTime2u($rub['date_rdv']);
	$rdv[] = $rub;

}
// page
print("<table id=\"page\" cellspacing=\"2\">");
print("<tr>");// 1 seule ligne
print("<td>"); // 2 colonnes
// agenda
print("<table id=\"sample\" cellspacing=\"2\">");
	$debut= 8;// heure de début de la consultation
	$fin = 20;// heure de fin
	$inc = 15;// durée moyenne d'une consultation
	for($i=$debut;$i<$fin;$i++)
	{
		for($j=0;$j<60;$j+=$inc)
		{
			$time_unix =  mysqlDateTime2u($date_unix." ".$i.":".$j.":00");

			print("<tr>");
				if($j < 10) $mn='0'.$j;else $mn=$j;
				if($j==0)
					print("<td class=\"leftcol1\">".$i.":".$mn."</td>");
				else
					print("<td class=\"leftcol2\">".$i.":".$mn."</td>");
				//print("<td><a href=\"new_rdv.php?h=$i&m=$j&date=$date\" alt=\"nouveau RDV\">a</a></td>");
				for($k=0;$k<count($rdv);$k++)
				{
					if($time_unix == $rdv[$k]['date_rdv'])
					{
						if($date >= $today)// on ne peut modifier ou supprimer que le jour même
							print("<td>&nbsp;</td>");
						$nom = $rdv[$k]['nom'];
						$prenom = $rdv[$k]['prenom'];
						$age = $rdv[$k]['age'];
						$motif = $rdv[$k]['motif'];
						print("<td class=\"data\">".$nom." ".$prenom." ".$age." ans ".$motif);
						$dossier = $rdv[$k]['rdv_ID'];
						if($date >= $today)// on ne peut modifier ou supprimer que le jour même
						{
							print("<a href=\"javascript:alerte_supprimer($dossier,$date,$med_ID)\"><img alt=\"supprimer\" border=\"0\" src=\"button_drop.png\"></a>");
							print("<a href=\"new_rdv.php?id=$dossier&date=$date&medid=$med_ID\"><img alt=\"modifier\" border=\"0\" src=\"button_edit.png\"></a>");
						}
						print("</td>");
						$signal=1;
						break;
					}
				}
				if($signal)
					$signal = 0;
				else
				{
					if($date >= $today)
						print("<td><a href=\"new_rdv.php?h=$i&m=$j&date=$date&medid=$med_ID\" alt=\"nouveau RDV\">a</a></td>");
					print("<td class=\"data\">&nbsp;</td>");
				}
			print("</tr>");
		}
	}
print("</table>");
print("</td>");
//
print("<td valign=\"top\">");
print("<table border=\"0\">");

$requete = "SELECT consigne_texte,consigne_type
			FROM mg67_consigne
			WHERE mg67_ID = '$med_ID'
			AND (consigne_type IN ('2','3')AND consigne_date = '$date'
			OR consigne_type = '1')
			";
$resultat = ExecRequete($requete,$connexion);
$rubrique1 = "mettre votre texte ici";
$rubrique2 = "mettre votre texte ici";
$rubrique3 = "Bonjour, n'oubliez pas de passer régulièrement un bilan au SAMU. Merci";
while($rub=mysql_fetch_array($resultat))
{
	if($rub['consigne_type']==1)
		$rubrique1 = $rub['consigne_texte'];
	else if($rub['consigne_type']==2)
		$rubrique2 = $rub['consigne_texte'];
	elseif($rub['consigne_type']==3)
		$rubrique3 = $rub['consigne_texte'];

}

print("<tr>");
print("<td>");// partie droite de la table
	print("<fieldset>");
	print("<legend> Consignes permanentes pour le SAMU </legend>");
		print("<TEXTAREA COLS=\"60\" ROWS=\"5\" NAME=\"doc_consignes_permanentes\"> $rubrique1 </TEXTAREA>");
		print("<br><input type=\"submit\" name=\"bouton1\" value=\"valider\">");
	print("</fieldset>");
print("</td>");
print("</tr>");

print("<tr>");
print("<td>");// partie droite de la table
	print("<fieldset>");
	print("<legend> Consignes du jour pour le SAMU </legend>");
		print("<TEXTAREA COLS=\"60\" ROWS=\"5\" NAME=\"doc_consignes_jour\"> $rubrique2 </TEXTAREA>");
		print("<br><input type=\"submit\" name=\"bouton2\" value=\"valider\">");
	print("</fieldset>");
print("</td>");
print("</tr>");

print("<tr>");
print("<td>");// partie droite de la table
	print("<fieldset>");
	print("<legend> Message du SAMU au Dr.".$doc['med_nom']."</legend>");
		print("<TEXTAREA COLS=\"60\" ROWS=\"5\" NAME=\"doc_consignes_samu\"> $rubrique3 </TEXTAREA>");
		print("<br><input type=\"submit\" name=\"bouton3\" value=\"valider\">");
	print("</fieldset>");
print("</td>");
print("</tr>");

print("</table>");

print("</td>");
print("</tr>");
print("</table>");

print("</BODY>");
print("</HTML>");
?>