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
//		
//----------------------------------------- SAGEC ---------------------------------------------//
//																							   //
//	programme: 			PMA_Requete.php															   //
//	date de création: 	18/08/2003															   //
//	auteur:				jcb																	   //
//	description:											 								   //
//	version:			1.0																	   //
//	maj le:				18/08/2003															   //
//																							   //  
//---------------------------------------------------------------------------------------------//
// Source MySQL et PHP pp 114
if(!isset($FichierExecRequete))
{
	$FichierExecRequete = 1;
	// exécution d'une requête en SQL
	function ExecRequete($requete,$connexion)
	{
		$resultat = mysql_query($requete,$connexion);
		if($resultat)
		{
			return $resultat;
		}
		else
		{
			echo "<B> Erreur dans l'éxécution de la requête'$requete'.</B><BR>";
			echo("<B>Message de MySql: </B>" .mysql_error($connexion));
			exit();
		}
	}// fin fonction ExecRequete
	
	function LigneSuivante($resultat)
	// récupère une ligne de résultat dans une base de données
	{
		return mysql_fetch_object($resultat);
	}
}// fin de fonction
?>
