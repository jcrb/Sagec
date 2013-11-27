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
* utilitaire_tr.php
* permet de saisir le tableau de garde des ASSU sur la CUS et de le modifier
*
* @author Jean-Claude Bartier
* @version 1.3
* @copyright jcb
*/
//-------------------------------------------------------------------------------------------------------

require("../pma_requete.php");

/**
* maj_tabGarde()
* met à jour le tableau de roulement des ASSU CUS en fonction de la date et de l'heure
* @param int variable de connexion
* @return rien
*/
function maj_tabGarde($connexion)
{
	$aujourdui = date("Y-m-j");
	$heure = date("H:i");
	if($heure > "20" && $heure < "8" )
	{
		$periode = "N";
	}
	else
	{
		$periode = "J";
	}
	// on supprime tous les enregistrements de la table
	$requete = "DELETE FROM apa_tour";
	$resultat = ExecRequete($requete,$connexion);

	$requete="INSERT INTO apa_tour (SELECT org_ID, ordre FROM garde_cus WHERE date = '$aujourdui' AND periode = '$periode')";
	$resultat = ExecRequete($requete,$connexion);
}
/**
* getHeureCourante()
* retourne l'heure courante
* @return string heure courante sous forme hh:mm
*/
function getHeureCourante()
{
	return time("H:i");
}
/**
* getDateCourante()
* retourne la date courante
* @return string date courante au format aaaa-mm-jj
*/
function getDateCourante()
{
	return date("Y-m-j");
}
/**
* getPeriodeCourante()
* retourne la période courante
* @return char J (jour) ou N (nuit)
*/
function getPeriodeCourante()
{
	$heure = getHeureCourante();
	if($heure > "20:00" && $heure < "08:00")
	{
		$periode = "N";
	}
	else
	{
		$periode = "J";
	}
	return $periode;
}
?>
