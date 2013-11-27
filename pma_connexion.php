<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//		
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			PMA_Connexion.php													   //
//	date de création: 	18/08/2003															   //
//	auteur:				jcb																	   //
//	description:				 								   //
//	version:			1.0																	   //
//	maj le:				18/08/2003															   //
//																							   //  
//---------------------------------------------------------------------------------------------//
// Connexion.php
// Utilitaire de connexion à un serveur et une base de données
// syntaxe Connexion(nom, mpot_de_passe, base, serveur);

if(!isset($fichierconnexion))
{
	// évite les pb en cas d'inclusion multiple de ce fichier'
	$fichierconnexion = 1;
	//fonction connexion: connexion à MySQL
	function connexion($pNom,$pMotPasse,$pBase,$pServeur)
	{
		// connexion au serveur
		$connexion = mysql_pconnect($pServeur,$pNom,$pMotPasse);
		if(!$connexion)
		{
			echo("Désolé, connexion au serveur $pServeur impossible\n");
			exit();
		}
		// connexion à la base
		if(!mysql_select_db($pBase,$connexion))
		{
			echo("Désolé, connexion à la base $pBase impossible\n");
			echo"<B>Message de MySql: </B>".mysql_error($connexion);
			exit();	
		}
		// on renvoie la variable de connexion
		return $connexion;
	}
	
	function close($connexion)
	{
		mysql_close($connexion);
	}
}
?>
