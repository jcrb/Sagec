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
*	programme: 		archive_create.php							
*	date de création: 	10/04/2004								
*	auteur:			jcb									
*	description:		crée un fichier d'archives						
*	@version:		$Id: archive_create.php 39 2008-02-28 17:59:09Z jcb $					
*	maj le:			10/04/2004							
/*
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("utilitaires/table.php");
require 'utilitaires/globals_string_lang.php';
require("pma_connect.php");
require("pma_connexion.php");
require 'utilitaires/requete.php';
require("html.php");

$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

function separateur($symbole="=")
{
	for($i=0;$i<30;$i++)
		$mot=$mot.$symbole;
	return $mot."\n";
}

$filename = "archives/archive1.txt";
$tab = "\t";
$return = "\n";
$f = fopen($filename,"w");
//------------------------------- Ecriture de l'entête -----------------------------------------------------
fwrite($f,"SAGEC 67".$return);
//------------------------------- Ecriture de la main courante ---------------------------------------------
$requete="SELECT LB_ID,LB_Date,LB_Expediteur,LB_Message,nom
		FROM livrebord,utilisateurs
		WHERE LB_Expediteur = ID_utilisateur
		ORDER BY LB_Date ASC";
$result = ExecRequete($requete,$connect);
fwrite($f,$return.separateur());
fwrite($f,"Main Courante".$return);
fwrite($f,separateur().$return);
while($i = LigneSuivante($result))
{
	$ligne = $i->LB_ID.$tab.$i->LB_Date.$tab.$i->nom.$tab.$i->LB_Message.$return;
	fwrite($f,$ligne);
}
//-------------------------------- Fermeture du fichier ----------------------------------------------------
fclose($f);
?>