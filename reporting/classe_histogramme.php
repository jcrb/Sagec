<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
/**
//	programme: 		classe_histogramme.php
// dossier			reporting
//	date de création: 	28/02/2007
//	@author:			jcb
//	description:		Fonctionalité permise à l'administrateur
//	@v@ersion:			1.2
//	maj le:			28/02/2007
*/
//--------------------------------------------------------------------------------
//
class CHistogramme {
// Attributs
	/**
	* nombre de classe de lhistogramme. Correspond au nombre souhaité par l'utilisateur
	* plus 2 pour les valeurs qui dépassent les 2 extrèmes.
	*@var int nbDeClasses
	*/
	var $nbDeClasses;
	/**
	* étendue d'une classe
	*/
	var $etendue;
	/**
	* 
	*/
	var $borneInf;
	/**
	* limite inférieure de l'histogramme
	*/
	var $borneSup;
	/**
	* limite inférieure de l'histogramme
	*/
	var $type;
	/**
	*  Type de retour des variables
	*  VALEUR: chaque colonne représente la somme des valeurs de la colonne
	*  POURCENTAGE: chaque colonne représente un pourcentage du total
	*  PCUMUL: pourcentage cumulé. Chaque colonne de l'histogramme représente la somme
	*				des colonnes précédantes exprimé en %.
	*/
	var $sommeX;
	/**
	* somme des valeurs
	*/
	var $sommeX2;
	/**
	* somme des carrés des valeurs
	*/
	var $freq;
	/**
	* nombre de valeurs enregistrées
	*/
	var $min;
	/**
	* valeur la plus basse
	*/
	var $max;
	/**
	* valeur la plus haute
	*/
	var $val = array();
	
	/** Méthodes*/
	
	/**
	* Constructeur
	*/
	function CHistogramme($nbDeClasses,$etendue,$borneInf,$type='VALEUR'){
		$this->nbDeClasses = $nbDeClasses;
		$this->etendue = $etendue;
		$this->borneInf = $borneInf;
		$this->type = $type;
		$this->borneSup = $this->borneInf + $etendue * $this->nbDeClasses;
		for($i=0;$i<$nbDeClasses+2;$i++)
			$this->val[$i]=0;
		$this->freq = 0;
	}
	/**
	*	Ajoute des données au tableau des valeurs
	*/
	function addData($data){
		if($data < $this->borneInf) $this->val[0]++;
		elseif($data  > $this->borneSup) $this->val[$this->nbDeClasses+1]++;
		else{
			$x = 1+floor($data/$this->nbDeClasses);
			//print($data." *** ".$x."<br>");
			$this->val[$x]++;
		}
		$this->freq++;
		$this->sommeX = $data;
		$this->sommeX2 = $data * $data;
	}
	/**
	*	Transforme le tableau pour le rendre compatible avec PHPLOT
	*	première col = nom de la colonne
	* deuxième colonne = valeur
	*/
	function array2phplot(){
		$p = array();
		$n = sizeof($this->val);
		for($i = 0; $i < $n; $i++)
		{
			if($i==0)
				$p[$i][0] = "< ".$this->borneInf;
			elseif($i==$this->nbDeClasses+1)
				$p[$i][0] = "> ".$this->borneSup;
			else
				$p[$i][0] = "< ".$i*$this->etendue;
			switch($this->type){
				case 'VALEUR':
					$p[$i][1] = $this->val[$i];
					break;
				case 'POURCENTAGE':
					$p[$i][1] = 100*$this->val[$i]/$this->freq;
					break;
				case 'PCUMUL': // % cumulé
					$p[$i][1] = 100*$this->val[$i]/$this->freq;
					if($i>0)
						$p[$i][1] = 100*$this->val[$i]/$this->freq + $p[$i-1][1];
					break;
				case 'CUMUL':
					$p[$i][1] = $this->val[$i];
					if($i>0)
						$p[$i][1] = $this->val[$i] + $p[$i-1][1];
					break;
			}// end switch
		}
		return $p;
	}
	/**
	* renvoie un tableau simple contenant la valeur de chaque colonne de l'histogramme
	* le tableau comporte 2 colonnes supplémentaires:
	* - la colonne 0 correspond aux valeurs inférieure au seuil mini
	* - la colonne n+2 correspond aux valeurs supérieures au seuil maxi
	*/
	function arraySimple() {
		$p = array();
		$n = sizeof($this->val);
		for($i = 0; $i < $n; $i++)
		{
			switch($this->type){
				case 'VALEUR':
					$p[$i] = $this->val[$i];
					break;
				case 'POURCENTAGE':
					$p[$i] = 100*$this->val[$i]/$this->freq;
					break;
				case 'PCUMUL': // % cumulé
					$p[$i] = 100*$this->val[$i]/$this->freq;
					if($i>0)
						$p[$i] = 100*$this->val[$i]/$this->freq + $p[$i-1];
					break;
				case 'CUMUL':
					$p[$i] = $this->val[$i];
					if($i>0)
						$p[$i] = $this->val[$i] + $p[$i-1];
					break;
			}// end switch
		}
		return $p;
	}
	/**
	* retourne un tableau égal au noimbre de colonnes +2 contenant un descriptif pour la colonne
	* ex: <10 <20 >30
	*/
	function piedDeColonne() {
		$p = array();
		$n = sizeof($this->val);
		for($i = 0; $i < $n; $i++)
		{
			if($i==0)
				$p[$i] = "<".$this->borneInf;
			elseif($i==$this->nbDeClasses+1)
				$p[$i] = ">".$this->borneSup;
			else
				$p[$i] = "<".$i*$this->etendue;
		}
		return $p;
	}
	/**
	* retourne la moyenne
	*/
	function moyenne(){
		return $this->sommeX / $this->freq;
	}
	/**
	* retourne la variance
	*/
	function variance(){
		return ($this->sommeX2-$this->sommeX*$this->sommeX/ $this->freq)/($this->freq-1);
	}
	/**
	* retourne la fréquence totale
	*/
	function frequence(){
		return $this->freq;
	}
}


?>