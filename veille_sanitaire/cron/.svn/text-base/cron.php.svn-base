<?php

// ce script doit être appelé par un formulaire

// Exemple:
// Exécuter le fichier se trouvant à l'adresse
// http://localhost/happynewyear.php à nouvel an:
//
// url : http://localhost/happynewyear.php
// minute: 0
// heure : 0
// jour de la semaine: *
// mois : 1
// jour du mois : 1

// Préparation de la requête
// ces données viennent d'un formulaire

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

// pour exécuter un script php en ligne de commande: php -f
$texte .= "php -f ".$url;

// Ecriture de la requête dans un fichier (pensez aux droits)

$fichier = "cront.cron";
$fil = fopen($fichier,'a');
if(fputs($fil,$texte."\n"))
echo "La requete ".$texte." a ete enregistree<BR>";
else     {
echo "Erreur! La requete ".$texte." n'a pas ete enregistree!";
exit();
}

// Exécution de cron avec votre username à la place de YOURUSERNAME

if(passthru('crontab YOURUSERNAME cront.cron'))
     echo "La requete ".$texte." a ete ajoutee a la liste des taches";
else     echo "Erreur! La requete ".$texte." n'a pas ete ajoutee a la liste des taches!";
?>
