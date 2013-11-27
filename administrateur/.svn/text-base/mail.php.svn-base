<?php
// programme mail.php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once("../arh/arh_utilitaires.php");
include_once("../date.php");

print("<html>");
print("<head>");
print("<title>mailing</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");

$aujourdhui = uDate2French(time());// date de la veille
$hier =  uDate2French(time()-un_jour);

// Corps du message
//$msg = entete()."<br>";
$texte = entete();
$texte.= tableau_compact($aujourdhui);
$texte.= samu_urgences($hier);
//$msg .= entete();

//$destinataire = "DHOS.ALERTES@sante.gouv.fr";
$destinataire = "alerte-activite@arh42.com";
$sujet = "ARH Alsace - SAGEC";
$entetes = "From: jcb-bartier@wanadoo.fr \n";
$entetes .= "Reply-to: thiriond@arh42.com\n";
$entetes .= "Cc: jcb-bartier@wanadoo.fr \n";
$entetes .= "Cc: thiriond@arh42.com \n";
//$entetes .= "Cc: aouna@arh42.com \n";
//$entetes .= "Cc: arh67-alerte@sante.gouv.fr \n";
//$entetes .= "Cc: alerte-activite@arh42.com \n";

//$entetes .= "Disposition-Notification-To jcb-bartier@wanadoo.fr"; //accusé de réception
$entetes .= "Content-type:text/html \n";

// décommenter pour mailer
//$rep = mail($destinataire, $sujet,$texte,$entetes);

print($texte);


/*
Donc la solution était très simple, il suffisait de mettre le chemin complet du fichier, quand c'est lancé à partir de la tâche cron, PHP part de la racine du disque alors que lancé par Apache il part du dossier du script. Désolé de vous avoir fait chier avec ça, j'aurai dû trouver tout seul (enfin surtout bcp plus vite), simplement en lançant le script en shell. Merci quand même
*/
/*
$boundary = "-----=".md5(uniqid(rand()));
$header = "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
$header .= "\r\n";
$msg = "Ceci est un message au format MIME 1.0 multipart/mixed.\r\n";
$msg .= "--$boundary\r\n";
$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
$msg .= "Content-Transfer-Encoding:8bit\r\n";
$msg .= "\r\n";
$date = date("d/m/Y");
$msg .= "Sauvegarde du $date \r\n";
$msg .= "\r\n";
$file = "fichier.gz";
$fp = fopen($file, "rb");
$attachment = fread($fp, filesize($file));
fclose($fp);
$attachment = chunk_split(base64_encode($attachment));
$msg .= "--$boundary\r\n";
$msg .= "Content-Type: application/x-gzip; name=\"$file\"\r\n";
$msg .= "Content-Transfer-Encoding: base64\r\n";
$msg .= "Content-Disposition: inline; filename=\"$file\"\r\n";
$msg .= "\r\n";
$msg .= $attachment . "\r\n";
$msg .= "\r\n\r\n";
$msg .= "--$boundary--\r\n";
$destinataire = "destinataire_AT_gmail.com";
$expediteur   = "expediteur_AT_gmail.com";
$reponse      = $expediteur;
mail($destinataire, "Sauvegarde de la base de données du $date", $msg,
    "Reply-to: $reponse\r\nFrom: $expediteur\r\n".$header);
*/
print("</body>");
print("</html>");
?>