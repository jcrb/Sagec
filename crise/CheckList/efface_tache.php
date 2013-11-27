<?php
/**
  * efface_tache.php
  *
  *	modifie le contenu de la table tache:
  *	Les colonnes tache_faite est mise à n
  *	message_id et tache_heure sont mises à 0
  *
  *	Cette fonction ne peut être appelée que par RAZ
  */

$backPathToRoot = "";
require($backPathToRoot."dbConnection.php");
$requete = "UPDATE tache set tache_faite = 'n',message_ID = '', tache_heure=''";
$resultat = ExecRequete($requete,$connexion);
?>