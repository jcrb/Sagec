<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		/uf/uf_patch.php
*	description:	met à jour dans la table service, l'USIC NHC
*						qui est en fait une UF (exception à la règle).
*						Les données ont récupérées dans journal_uf pour mettre à jour la table lits.
*						La table journal_Lits n'est pas modifiée.
*	date de création: 	17/02/2008
*	@author:			jcb
*	@version:		$Id: uf_maj.php 41 2008-03-08 14:36:50Z jcb $
*	maj le:			
*/
include_once('../date.php');
require_once("../pma_connect.php");
require_once("../pma_connexion.php");
require_once("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
?>
<head>
<title>uf_patch.php</title>
<meta name="generator" content="Bluefish 1.0.7">
<meta name="author" content="jcb">
<meta name="date" content="2009-05-17T18:12:44+0200">
<meta name="copyright" content="jcb">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=ISO-8859-1">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="expires" content="0">
</head>
<body>
	<?php
	function patche()
	{
		global $connexion;
		$requete = "SELECT * FROM journal_uf
					WHERE journal_uf.uf_ID = 474		
					AND date = (SELECT MAX(date) FROM journal_uf)
					ORDER BY date DESC
					LIMIT 1
					";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		$date = mysqlDateTime2unix($rub[date].' '.$rub[time]);
		$requete = "UPDATE lits SET 
					lits_sp = '$rub[lits_ouverts]',
					lits_installe = '$rub[lits_installes]',
					lits_dispo = '$rub[lits_dispo]',
					lits_ferme = '$rub[lits_fermes]',
					lits_supp = '$rub[lits_sup]',
					lits_occ = '$rub[lits_occupes]', 
					places_dispo = '$rub[places_dispo]',
					date_maj = '$date'
					WHERE lits.service_ID = 606
					";
		//print($requete);
		$resultat = ExecRequete($requete,$connexion);
		return 1;
	}
	
	patche();
	?>
</body>
</html>