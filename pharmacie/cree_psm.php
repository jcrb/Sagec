<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		cree_psm.php
//	date de cr?ation: 	15/10/2004
//	auteur:			jcb
//	description:		enregistre les caract?ristiques d'un m?dicament
//	version:			1.0
//	maj le:			15/10/2004
//
//--------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

$requete="DROP TABLE IF EXISTS `psm2`";
$resultat = ExecRequete($requete,$connexion);
$requete="CREATE TABLE psm2 (
  `malle_ID` smallint(6) NOT NULL auto_increment,
  `lot` varchar(10) NOT NULL default '',
  `malle_nom` char(1) NOT NULL default '',
  `malle_no` tinyint(4) NOT NULL default '0',
  KEY `malle_ID` (`malle_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1";
$resultat = ExecRequete($requete,$connexion);

function polyvalent($lot,$malle,$m,$n,$connexion)
{
	for($i=$m;$i<$n+1;$i++)
	{
		$requete="INSERT INTO psm2 VALUES('','$lot','$malle','$i')";
		$resultat = ExecRequete($requete,$connexion);
	}
}

polyvalent("polyvalent","A",1,10,$connexion);
polyvalent("polyvalent","B",1,10,$connexion);
polyvalent("polyvalent","C",1,10,$connexion);
polyvalent("polyvalent","D",1,10,$connexion);
polyvalent("principal","1",11,66,$connexion);
polyvalent("principal","2",11,66,$connexion);


?>