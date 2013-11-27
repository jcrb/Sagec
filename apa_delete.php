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
/**																									
*	programme: 			apa_delete.php																	
*	date de création: 	21/08/2003																		 
*	auteur:				jcb																				
*	description:		enregistre un nouveau vecteur ou met à jour									
*	@version:			$Id$																				
*	maj le:				22/09/2003																		
*	appelé par:			apa_supprime.php
*	Variables transmises	$org_vecteur = Vec_ID du moyen à supprimer	
*/																							 
//---------------------------------------------------------------------------------------------------------
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete="DELETE FROM vecteur WHERE Vec_ID = '$_GET[org_vecteur]'";
$resultat = ExecRequete($requete,$connexion);
header("Location:apa_supprime.php");
?>
