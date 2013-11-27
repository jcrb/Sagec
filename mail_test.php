<?php
/**
  *	mail_test.php
  *	essai d'envoi de fax � partir du serveur de fax des HUS
  */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once("date.php");

print("<html>");
print("<head>");
print("<title>mailing</title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");

$aujourdhui = uDate2French(time());// date de la veille

// Corps du message
$texte = "";
$texte.= "MESSAGE DE TEST";

$destinataire = "00388115999@fax.hus";
$sujet = "SAGEC Alsace";
$entetes = "From: samu.67@chru-strasbourg.fr \n";
//$entetes .= "Reply-to: samu.67@chru-strasbourg.fr\n";
//$entetes .= "Cc: jcb-bartier@wanadoo.fr \n";
//$entetes .= "Cc: thiriond@arh42.com \n";

//$entetes .= "Disposition-Notification-To jcb-bartier@wanadoo.fr"; //accus� de r�ception
$entetes .= "Content-type:text/html \n";

//d�commenter pour mailer
$rep = mail($destinataire, $sujet,$texte,$entetes);

print($texte);


/*
Donc la solution �tait tr�s simple, il suffisait de mettre le chemin complet du fichier, 
quand c'est lanc� � partir de la t�che cron, PHP part de la racine du disque alors que
lanc� par Apache il part du dossier du script. D�sol� de vous avoir fait chier avec �a, 
j'aurai d� trouver tout seul (enfin surtout bcp plus vite), simplement en lan�ant le script en shell.
*/

print("</body>");
print("</html>");
?>
