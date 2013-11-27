<?php

// ce script doit �tre appel� par un formulaire

// Exemple:
// Ex�cuter le fichier se trouvant � l'adresse
// http://localhost/happynewyear.php � nouvel an:
//
// url : http://localhost/happynewyear.php
// minute: 0
// heure : 0
// jour de la semaine: *
// mois : 1
// jour du mois : 1

// Pr�paration de la requ�te
// ces donn�es viennent d'un formulaire

$url        = $_POST['url'];
$minute        = $_POST['minute'];
$heure        = $_POST['heure'];
$dayweek    = $_POST['dayweek'];
$day        = $_POST['day'];
$month        = $_POST['month'];

// The time and date fields are:
//
// field allowed values
// ----- --------------
// minute 0-59
// hour 0-23
// day of month 1-31
// month 0-12 (or names, see below)
// day of week 0-7 (0 or 7 is Sun, or use names)
//
// A field may be an asterisk (*), which always stands for ``first-last''.

$texte = $minute." ".$heure." ".$day." ".$month." ".$dayweek." ";

// pour ex�cuter un script php en ligne de commande: php -f
$texte .= "php -f ".$url;

// Ecriture de la requ�te dans un fichier (pensez aux droits)

$fichier = "cront.cron";
$fil = fopen($fichier,'a');
if(fputs($fil,$texte."\n"))
echo "La requete ".$texte." a ete enregistree<BR>";
else     {
echo "Erreur! La requete ".$texte." n'a pas ete enregistree!";
exit();
}

// Ex�cution de cron avec votre username � la place de YOURUSERNAME

if(passthru('crontab YOURUSERNAME cront.cron'))
     echo "La requete ".$texte." a ete ajoutee a la liste des taches";
else     echo "Erreur! La requete ".$texte." n'a pas ete ajoutee a la liste des taches!";
?>
