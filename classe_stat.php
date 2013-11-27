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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		classe_stat.php
//	date de création: 	29/07/2005
//	auteur:			jcb
//	description:		classe pour statistiques bidimensionelles. Adapté de ma version C++
//	version:			1.0
//	maj le:			29/07/2005
//
/**
* La classe CStat assure le stockage de données mono ou bidimensionelles et retourne un certain nombre
* d'indicateurs courants: moyenne, variance, etc.
*	programme: 		classe_stat.php
*	date de création: 	29/07/2005
*	@author jcb
*	@version $Id: classe_stat.php 21 2007-02-13 22:30:12Z jcb $
*	@maj le 129/07/2005
*	@package CStat
*/
//--------------------------------------------------------------------------------------------------------
class CStat {

	// Attributs
	/**
	*vecteur des x.
	*@var double
	*/
	var $vx;
	/**
	*somme des x.
	*@var double
	*/
	var $sx;
	/**
	*somme des x carré.
	*@var double
	*/
	var $sx2;
	/**
	*count x.
	*@var double
	*/
	var $nx;
	/**
	*	tableau des moyennes lissées
	*/
	var $mlisse;
	/**
	*	tableau des variances lissées
	*/
	var $vlisse;
		/**
	*
	*/
	var $cusum;
	
	// Méthodes
	/**
	* Constructeur
	*/
	function CStat(){
		$this->sx = 0;
		$this->sx2 = 0;
		$this->nx = 0;
	}
	/**
	* add()
	*/
	function addx($x){
		$this->sx += $x;
		$this->sx2 += $x*$x;
		$this->vx[]=$x;
		$this->nx++;
	}

	
	/**
	* size()
	*/
	function size(){
		return sizeof($this->vx);
	}
	function moyenne()
	{
		return $this->sx/$this->size();
	}
	function variance(){
		$v = ($this->sx2 - $this->sx*$this->sx/$this->size())/($this->size()-1);
		return $v;
	}
	function ecart_type(){
		$x = ($this->sx2 - $this->sx*$this->sx/$this->size())/($this->size()-1);
		return sqrt($x);
	}
	function min(){
		return min($this->vx);
	}
	function max(){
		return min($this->vx);
	}
	function mediane(){
		$x = $this->vx;
		sort($x);
		if($this->nx%2==0)
			$m = ($x[($this->nx)/2]+$x[($this->nx)/2-1])/2;
		else
			$m = $x[$this->nx/2];
		return $m;
	}
	function clear(){
		$this->vx = NULL;
		$this->sx = 0;
		$this->sx2 = 0;
		$this->nx = 0;
	}
	/**
	*	calcul moyenne lissée
	*	@param $w = durée du lissage
	*	@return tableau des moyennes lissées
	*/
	function moyenne_lisse($w)
	{
		$size = $this->size();
		if($size < $w) return 0;
		for($i=$w;$i<$size;$i++)
		{
			$m = 0;
			$m2 = 0;
			for($j=$i-$w;$j<$i;$j++)
			{
				$m += $this->vx[$j];
				$m2 += $this->vx[$j]*$this->vx[$j];
			}
			$this->mlisse[$i] = $m/$w;
			$this->vlisse[$i] = ($m2-$m*$m/$w)/($w-1);
		}
		return $this->mlisse;
	}
	/**
	* CUSUM
	*/
	function cusum($type)
	{
		if($type==1) $lissage = 7;
		
		$this->moyenne_lisse($lissage);
		$size = $this->size();
		for($i=$lissage;$i<$size;$i++)
		{
			/** calcul ecart-type */
			$et = sqrt($this->vlisse[$i]);
			/** calcul du cusum pour le jour i */
			$this->cusum[$i] = max(0,($this->vx[$i] - ($this->mlisse[$i]-$et))/$et);
		}
		return $this->cusum;
	}
}
?>
