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
/** utilitaires/uf_Exel2mysql.php
* 	Récupère un fichier d' UF au format Text et les insère dans la table uf
*	date de création: 	13/01/2008		 
*	@author:		jcb		  
*	@version:	$Id: uf_Exel2mysql.php 30 2008-01-23 15:58:04Z jcb $	 
*	maj le:				
*	@package			sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../html.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$path="/home/jcb/Desktop/sagec_alsace/tables_sagec/";
//$file ="import_sagec_uf.csv";
$file ="import_haguenau_uf.csv";
print($file.'<br>');
$fp=fopen($file,"r");

while(!feof($fp))
{
		$mot = fgets($fp,4096);
		//if($mot<1)break;// éviter les enregistrements vides
		$mot = str_replace("'","\'",$mot);//protection des apostrophes
		$rep = explode("\t",$mot);
		$finess = $rep[0];
		switch($finess)
		{
			case '670780055':$hop_ID = 2;$organisme_ID = '85';break;
			case '670783273':$hop_ID = 1;$organisme_ID = '85';break;
			case '670783091':$hop_ID = 180;$organisme_ID = '85';break;
			case '670783125':$hop_ID = 0;$organisme_ID = '85';break;// steph
			case '670783133':$hop_ID = 0;$organisme_ID = '85';break;//chutz
			case '670790104':$hop_ID = 178;$organisme_ID = '85';break;
			case '670790112':$hop_ID = 179;$organisme_ID = '85';break;
			case '670783240':$hop_ID = 0;$organisme_ID = '85';break;//kuss
			case '670790161':$hop_ID = 184;$organisme_ID = '85';break;
			case '670780337':$hop_ID = 6;$organisme_ID = '90';break;
			case '670009109':$hop_ID = 3;$organisme_ID = '85';break;
		}
		// détermination pole_ID
		$pole = $rep[5];
		$requete = "SELECT pole_ID FROM pole WHERE pole_code = '$pole'";
		$resultat = ExecRequete($requete,$connexion);
		$rub = mySql_Fetch_Array($resultat);
		$pole_ID = $rub[0];
		// détermination du service
		$service = $rep[4];
		$requete = "SELECT service_ID FROM service WHERE service_code = '$service'";
		$resultat = ExecRequete($requete,$connexion);
		$rub = mySql_Fetch_Array($resultat);
		$service_ID = $rub[0];
		
		// insertion
		$requete = "INSERT INTO uf (uf_ID,uf_nom,uf_code,uf_ouverte,service_ID,pole_ID,Hop_ID,org_ID)
						VALUES('','$rep[2]','$rep[1]','$rep[3]','$service_ID','$pole_ID','$hop_ID','$organisme_ID')";
		if($service_ID == '')
		{
			echo $mot."<br>";
			print($requete."<br>");
		}
		else ExecRequete($requete,$connexion);
}

fclose($fp);
?>