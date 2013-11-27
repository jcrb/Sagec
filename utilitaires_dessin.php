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
//	programme: 			utilitaires_dessin.php													   //
//	date de création: 	14/02/2004															   //
//	auteur:				jcb																	   //
//	description:		manipulation de polygones							 				   //
//	version:			1.0																	   //
//	maj le:				14/02/2004										                       //
//																							   //  
//---------------------------------------------------------------------------------------------//
//======================================== UTILITAIRES =========================================

// Cherche si un point de coordonnées x,y est un sommet d'un polygone p
// si oui, retourne la position du point dans le polygone
// si nom retourne -1
function pt_estSommet($x,$y,$p)
{
	$n = count($p);
	//print("n = ".$n."<BR>");
	for($i = 0; $i < $n-1; $i += 2)
	{
		//print("--> ".$x." <> ".$p[$i]."<BR>");
		if($x == $p[$i])
		{
			if($y == $p[$i+1])
				return $i;
		}
	}
	return -1;
}

// Fusionne 2 polygones non recouvrants, p1 et p2
// Le nouveau polygone newP est renvoyé par la fonction
function fusionne2polygones($p1,$p2)
{
	$newP = array();
	$pCourant = $p1;
	$pAlternatif = $p2;
	$i = 0;
	$x_stop = $p1[0];
	$y_stop = $p1[1];
	$nb_sommets = 0;	
	//print("<BR> CALCULS <BR>");
	//print("X STOP = ".$x_stop." - Y STOP = ".$y_stop."<BR>");
	
	//-------------------- 1er point ---------------------------------
	$x = $pCourant[$i];
	$i++;
	$y = $pCourant[$i];
	$i++;
	$newP[] = $x;
	$newP[] = $y;
	$nb_sommets++;
	$pos = pt_estSommet($x,$y,$pAlternatif);
	//print($nb_sommets." * ".$x." * ".$y." * ".$pos."<BR>");
	if($pos >= 0)
	{
		$i = $pos + 2 ;
		if($pCourant == $p1)
		{
			$pCourant = $p2;
			$pAlternatif = $p1;
		}
		else 
		{
			$pCourant = $p1;
			$pAlternatif = $p2;
		}
	}
	if($i >= count($pCourant))$i=0;
	//print("i = ".$i."<BR>");
	$x = $pCourant[$i];
	$i++;
	$y = $pCourant[$i];
	$i++;
	//-------------------- points suivants ---------------------------------	
	while($x != $x_stop || $y != $y_stop)
	{
		
		$newP[] = $x;
		$newP[] = $y;
		$nb_sommets++;
		$pos = pt_estSommet($x,$y,$pAlternatif);
		
		//print($nb_sommets." * ".$x." * ".$y." * ".$pos."<BR>");
		
		if($pos >= 0)
		{
			$i = $pos + 2 ;
			if($pCourant == $p1)
			{
				$pCourant = $p2;
				$pAlternatif = $p1;
			}
			else 
			{
				$pCourant = $p1;
				$pAlternatif = $p2;
			}
		}
		if($i >= count($pCourant))$i=2;
		//print("i = ".$i."<BR>");
		
		$x = $pCourant[$i];
		$i++;
		$y = $pCourant[$i];
		$i++;
		
	}
	//-------------------- dernier point ---------------------------------
	$newP[] = $x;
	$newP[] = $y;
	return $newP;
}

?>
