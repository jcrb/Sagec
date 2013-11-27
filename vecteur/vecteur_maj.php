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
/**																										
*	programme: 			vecteur_maj.php																	 	 
*	date de création: 09/09/2003																		
*	auteur:				jcb																				 
*	description:		Enregistre les modification d'état des vecteurs
*							et tient à jour le journal des modifications								 											
*	@version $Id$																				 
*	maj le:				12/08/2008																		
*/																										 
//---------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_apa'])header("Location:langue.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$back = $_REQUEST['back']; /* adresse de retour*/
$date_maj = date("Y-m-j H:i:s");

$requete = "SELECT Vec_ID,Vec_Etat FROM vecteur WHERE org_ID = '$_SESSION[organisation]'";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$id = $rub[Vec_ID];
	if(isset($_REQUEST[$id]) && $_REQUEST[$id]=="on")// la case est cochée 
	{
		if($rub[Vec_Etat] != 2)// la valeur 2 correspond à un vecteur disponible
		{ 
			$requete = "INSERT INTO apa_journal values('','$id','2','$date_maj')"; 
			ExecRequete($requete,$connexion);
		}
		$requete="UPDATE vecteur SET Vec_Etat = '2' WHERE Vec_ID = '$id'";
		ExecRequete($requete,$connexion);
		//print("Request: ".$requete."<br>");
	}
	else // la case n'est pas cochée ou a été décochée 
	{
		if($rub[Vec_Etat] != 1)// la valeur 1 correspond à un vecteur indisponible
		{ 
			$requete = "INSERT INTO apa_journal values('','$id','1','$date_maj')"; 
			ExecRequete($requete,$connexion);
		}
		$requete="UPDATE vecteur SET Vec_Etat = '1' WHERE Vec_ID = '$id'";
		ExecRequete($requete,$connexion);
	}
}
@mysql_free_result($resultat);
header("Location:$back");
?>
