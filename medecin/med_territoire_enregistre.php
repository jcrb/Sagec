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
//	programme: 			med_territoire_enregistre.php							
//	date de création: 	08/12/2005								
//	auteur:				jcb									
//	description:		
//	version:			1.2									
//	maj le:				08/12/2005
//													
//---------------------------------------------------------------------------------------------------------
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
$medecin = $_SESSION['member_id'];
if($_GET['ok']=="Ajouter" && isset($medecin))
{
	$com = $_GET['commune_id'];// liste des communes
	for($i=0;$i<sizeof($com);$i++)
	{
		//print($com[$i].'<br>');
		$requete = "INSERT INTO mg67_territoire VALUES('','$medecin','$com[$i]','')";
		$resultat = ExecRequete($requete,$connexion);
	}
	header("Location:med_territoire.php");
}
if($medecin=='')
	print("Identifiant ".$medecin." n'existe pas");
print("<a href=\"med_territoire.php\"> continuer </a>");
?>
