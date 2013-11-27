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
* 	Récupère un fichier de RPU au format txt et le range dans la table RPU
*	date de création: 	13/01/2008		 
*	@author:		jcb		  
*	@version:	$Id: uf_Exel2mysql.php 30 2008-01-23 15:58:04Z jcb $	 
*	maj le:				
*	@package			sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../../"; 
include_once($backPathToRoot."dbConnection.php");
require($backPathToRoot."html.php");

$source="/home/jcb/Documents/Programmation/rpu.txt";

$fp=fopen($source,"r");
//$fd=fopen($destination,"w");

# remove by key:
function array_remove_key ()
{
  $args  = func_get_args();
  return array_diff_key($args[0],array_flip(array_slice($args,1)));
}

$id = 1746;
$next = $id;
$enregistrement=array();

//for($i=0;$i<1000;$i++)
while(!feof($fp))
{
	$mot = fgets($fp,4096);//print("[".$mot."]<br>");
	$rep = explode("\t",$mot);//print($rep[0]."<br>");
	if($rep[0] == $next )
	{
		$z = sizeof($enregistrement);
		//print("Z= ".$z."<br>");
		if($z > 20)
		{
			$enregistrement[16].=" ".$enregistrement[17];
			$enregistrement[17] = $enregistrement[18];
			$enregistrement[18] = $enregistrement[19];
			$enregistrement[19] = $enregistrement[20];
			$enregistrement = array_remove_key ($enregistrement,"20");
			
			$value = implode("','",$enregistrement);
			print($value."***5<br>");
			$requete = "INSERT INTO rpu VALUES('$value')";
			ExecRequete($requete,$connexion);
			$enregistrement=array();
			
			$enregistrement[0] = $next;
			$next++;
			for($j=1;$j<sizeof($rep);$j++)
				$enregistrement[] = $rep[$j];
		}
		else if($z == 0)
		{
			$enregistrement[0] = $next;
			$next++;
			for($j=1;$j<sizeof($rep);$j++)
			{
				$enregistrement[] = $rep[$j];
				//print($rep[$j]);
			}
			//print("***4<br>");
		}
		else if($z == 20)
		{
			//for($k=0;$k<sizeof($enregistrement);$k++)print($enregistrement[$k]."  "."<br>");print(sizeof($enregistrement)."---------<br>");
			$value = implode("','",$enregistrement);
			print($value."***3<br>");
			$requete = "INSERT INTO rpu VALUES('$value')";
			ExecRequete($requete,$connexion);
			$enregistrement=array();
			
			$enregistrement[0] = $next;
			$next++;
			for($j=1;$j<sizeof($rep);$j++)
				$enregistrement[] = $rep[$j];
		}
		else
		{
			for($j=0;$j<sizeof($rep);$j++)
			{
				$enregistrement[] = $rep[$j];
				//print($rep[$j]);
			}
			//print("***2<br>");
		}
		
	}
	else
	{
		for($j=0;$j<sizeof($rep);$j++)
		{
				$enregistrement[] = $rep[$j];
				//print($rep[$j]);
			}
			//print("***1<br>");
	}
}

fclose($fp);
//fclose($fd);
?>