<?php
/**
* 	affiche_stock.php
* 	variables transmises: $_GET[type_ville],$_GET[type_materiels],$_GET[type_fournisseur]
*	@version $Id: affiche_stock.php 39 2008-02-28 17:59:09Z jcb $
*/
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

print($_GET[type_ville]."<BR>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT ville_ID,materiel_ID,dotation_qte , fournisseur_ID, acheteur_ID, date_achat,marque_ID
			FROM dotation
			WHERE ville_ID = '$_GET[type_ville]',
			AND materiel_ID = '$_GET[type_materiels]',
			AND fournisseur_ID = '$_GET[type_fournisseur]'
			";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
print($rub[0]." - ".$rub[1]." - ".$rub[2]." - ".$rub[3]." - ".$rub[4]."<BR>");
?>