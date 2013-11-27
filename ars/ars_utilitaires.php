<?php
/**
  *	ars_utilitaires.php
  *
  */
$backPathToRoot = "../";
require_once($backPathToRoot."date.php");

/** nb de jpours écoulés depuis mardi
  * date("w",time()) retourne le jour de la semaine courant sous la forme dimanche = 0, mardi = 2
  * date("w",time())-2 retourne le nb de jours écoulés depuis mardi
  * multiplié par le nb de secondes dans un jour
  * date unix actuelle - nb de secondes écoulées depuis le dernier mardi => date du dernier mardi
  */
$last_mardi = (time()-(date("w",time())-2)*un_jour);

/**
  * une fois que l'on a le dernier mardi, il suffit de retrancher 7 jours
  * pour obtenir la date du mardi précédant
  */
$last_last_mardi = $last_mardi - sept_jour;

/**
  * semaine courante
  */
$semaine_courante = semaine_courante($last_last_mardi);

?>