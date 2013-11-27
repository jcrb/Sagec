<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//																
/**													
*	programme 			blocnote_perso_enregistre.php
*	@date de création: 	05/11/2006
*	@author:			jcb
*	description:		Enregistre une information dans la table blocnote_pds
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*/				
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

if($_GET['montexte']) // pour ne pas enregistrer une phrase vide
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$query = "INSERT INTO livrebord_perso
	 		VALUES('','$_GET[auteur]','$_GET[date]','$_GET[montexte]')";
	$result = ExecRequete($query,$connexion);
}
//L'instruction provoque le retour automatique vers le bloc-note
header("Location: blocnote_pds_lire.php");
?>
