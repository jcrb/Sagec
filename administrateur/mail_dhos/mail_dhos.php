<?php
/** 
	programme mail_dhos.php
	@version $Id: mail_dhos.php 31 2008-02-12 18:02:26Z jcb $
	tableau quotidien envoy� par mail � l'ARH
*/

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once("../../arh/arh_utilitaires.php");
include_once("../../date.php");

print("<html>");
print("<head>");
print("<title>mailing</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");

$aujourdhui = uDate2French(time());// date de la veille
$hier =  uDate2French(time()-un_jour);

// Corps du message
$texte = entete();
$texte.= tableau_compact($aujourdhui);
$texte.= samu_urgences($hier);

//$texte = "Message test pour la DHOS";

$destinataire = "DHOS.ALERTES@sante.gouv.fr";
$sujet = "ARH Alsace - SAGEC";
$entetes = "From: jcb-bartier@wanadoo.fr \n";
$entetes .= "Reply-to: thiriond@arh42.com\n";
$entetes .= "Cc: jcb-bartier@wanadoo.fr \n";
$entetes .= "Cc: thiriond@arh42.com \n";
$entetes .= "Cc: aouna@arh42.com \n";
$entetes .= "Cc: arh67-alerte@sante.gouv.fr \n";
//$entetes .= "Disposition-Notification-To jcb-bartier@wanadoo.fr"; //accus� de r�ception
$entetes .= "Content-type:text/html \n";

$rep = mail($destinataire, $sujet,$texte,$entetes);

if($rep)
	print("Message de test envoy� � la DHOS");
else
	print("Echec envoi Message de test envoy� � la DHOS");
?>