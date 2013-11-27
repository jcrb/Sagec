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
//													//
//	programme: 		apa_territoire_enregistre.php							//
//	date de création: 	03/10/2003								//
//	auteur:			jcb									//
//	description:		associe une liste de communes à une APA avec les délais de route	//
//	version:		1.2									//
//	maj le:			02/11/2003	suppression bouton recherche				//
//													//
//---------------------------------------------------------------------------------------------------------
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_GET['ok']=="valider")
{
	$requete = "INSERT INTO apa_territoire VALUES('$_SESSION[organisation]','$_GET[commune_id]','$_GET[delai]')";
	$resultat = ExecRequete($requete,$connexion);
}
else if($_GET['ok']=="supprimer")
{
	$requete = "DELETE FROM apa_territoire WHERE com_ID = '$_GET[territoire_id]'";
	$resultat = ExecRequete($requete,$connexion);
}
header("Location:apa_territoire.php")
?>
