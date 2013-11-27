<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//-------------------------------------------------------------------------------------------------------
/**
* enregistre_garde_cus.php
* enregistre le tableau de garde des ASSU sur la CUS
*
* @author Jean-Claude Bartier
* @version 1.0
* @copyright jcb
* @date 11/11/2004
*/
//-------------------------------------------------------------------------------------------------------
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("utilitaire_tr.php");
if($_GET[date] !="")
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	// on efface tous les enregistrements correspondants à la journée à enregistrer
	$requete="DELETE FROM garde_cus WHERE date='$_GET[date]'";
	$resultat = ExecRequete($requete,$connexion);
	// on enregistre les nouvelles données
	// - date du jour
	// - org_ID de l'entreprise
	// - l'ordre d'appel
	// dans la table, les 5 premiers enregistrements correspondent au jour, les 5 suivants à la nuit
	$t = $_GET['ID_assu'];
	for($i=0;$i<count($t);$i++)
	{
		if($i%2!=0 && $t[$i]>0)$max_nuit++;
		if($i%2==0 && $t[$i]>0)$max_jour++;
	}
	//print($max_jour." ".$max_nuit."<br>");
	// enregistrement pour la nuit
	$ordre = $max_nuit-1;
	for($i=0;$i<count($t);$i++)
	{
		if($i%2!=0 && $t[$i]>0){
			$requete = "INSERT INTO garde_cus VALUES('$_GET[date]','$t[$i]','$ordre','N')";
			$ordre--;
			$resultat = ExecRequete($requete,$connexion);
			//print($requete."<br>");
		}
	}
	// enregistrement pour le jour
	$ordre = $max_jour-1;
	for($i=0;$i<count($t);$i++)
	{
		if($i%2==0 && $t[$i]>0){
			$requete = "INSERT INTO garde_cus VALUES('$_GET[date]','$t[$i]','$ordre','J')";
			$ordre--;
			$resultat = ExecRequete($requete,$connexion);
			//print($requete."<br>");
		}
	}
	maj_tabGarde($connexion);
}
header("Location:garde_assu_cus.php?date=$_GET[date]");
?>
