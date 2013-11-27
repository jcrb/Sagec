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
//----------------------------------------- SAGEC ---------------------------------------------
//
//	programme: 		carto_utilitaires.php
//	date de création: 	31/01/2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			31/01/2004
//
//---------------------------------------------------------------------------------------------

// initialisation des variables qui serviront à déterminer le min et le max
$U_gauche = (double)100000;
$U_droit = (double)0;
$U_haut = (double)0;
$U_bas = (double)100000;

// Ouvre un fichier en mode lecture et retourne un handle
function ouvre_fichier($nom_fichier)
{
	$fp = fopen($nom_fichier,"r");
	if(!$fp)
	{
		print("Echec de l'ouverture du fichier ".$nom_fichier);
		exit;
	}
	else return $fp;
}

// Parse les éléments d'un fichier dans un tableau. Le parsing se fait ligne par lignes
// Le fichier doit être au format NUM: col0 = identifiant, col1 = X, col2 = Y, col3 = zone
// La structure d'une ligne est de type TEXT: tab/tab/return
// $fp = handle sur le fichier ouvert
// $$nom_tableau = nom du tableau passé en argument par &
// les variables globales sont a initialiser par l'utilisateur'
function fichierNUM2array($fp,&$nom_tableau)
{
	global $U_droit;
	global $U_gauche;
	global $U_haut;
	global $U_bas;
	
	$nb_sommets=Null;
	//print($U_gauche."-".$U_droit."-".$U_haut."-".$U_bas."<BR>");
	// lecture des points du fichier
	while(!feof($fp))
	{
		$ligne = fgets($fp,255);// lit une ligne
		$part = explode("\t",$ligne);// le tableau $part stocke les éléments séparés par une tabulation
		$nom = $part[0];
		$X = (double)$part[1];// X
		$Y = (double)$part[2];// Y
		$nom_tableau[] =$X;// enregistrement de X
		//print($X." - ");
		if($X > $U_droit)	// détermination de X min et X max
			$U_droit = $X;
		if($X < $U_gauche )
		{
			//print($U_gauche."-".$X."<BR>");
			$U_gauche = $X;
		}
		$nom_tableau[] = $Y;// enregistrement de Y
		//array_unshift($nom_tableau,$Y);
		//print($Y."<BR>");
		if($Y > $U_haut )$U_haut = $Y;// détermination de Y min et Y max
		if($Y < $U_bas )$U_bas = $Y;
		$nb_sommets++;	// nb de sommets du polygone
		//print($X." - ".$Y."<BR>");
	}
	fclose($fp);
	//print($U_gauche."-".$U_droit."-".$U_haut."-".$U_bas."-".$nom_tableau."<BR>");
	return $nom;
}

// Parse les éléments d'un fichier dans un tableau. Le parsing se fait ligne par lignes
// Le fichier doit être au format Text simple: col0 = X, col1 = Y
// La structure d'une ligne est de type TEXT: tab/tab/return
// $fp = handle sur le fichier ouvert
// $$nom_tableau = nom du tableau passé en argument par &
// les variables globales sont a initialiser par l'utilisateur'
function fichierTXT2array($fp,&$nom_tableau)
{
	global $U_droit;
	global $U_gauche;
	global $U_haut;
	global $U_bas;
	
	$nb_sommets=Null;
	//print($U_gauche."-".$U_droit."-".$U_haut."-".$U_bas."<BR>");
	// lecture des points du fichier
	while(!feof($fp))
	{
		$ligne = fgets($fp,255);// lit une ligne
		$part = explode("\t",$ligne);// le tableau $part stocke les éléments séparés par une tabulation
		$X = (double)$part[0];// X
		$Y = (double)$part[1];// Y
		if($X!=0 && $Y!=0)
		{
			$nom_tableau[] =$X;// enregistrement de X
			//print($X." - ");
			if($X > $U_droit)	// détermination de X min et X max
				$U_droit = $X;
			if($X < $U_gauche )
			{
				//print($U_gauche."-".$X."<BR>");
				$U_gauche = $X;
			}
			$nom_tableau[] = $Y;// enregistrement de Y
			//array_unshift($nom_tableau,$Y);
			//print($Y."<BR>");
			if($Y > $U_haut )$U_haut = $Y;// détermination de Y min et Y max
			if($Y < $U_bas )$U_bas = $Y;
			$nb_sommets++;	// nb de sommets du polygone
			//print($X." - ".$Y."<BR>");
		}
	}
	fclose($fp);
	//print($U_gauche."-".$U_droit."-".$U_haut."-".$U_bas."-".$nom_tableau."<BR>");
	return $nom;
}


/**
/*	$fp handle sur un fichier
/*	$table tableau pour les données  PAS TERMINE
*/
function file2array($fp,&$table)
{
	$ligne = fgets($fp,255);// lit une ligne
	$part = explode("\t",$ligne);
	$n=sizeof($part);
	rewind($fp);
	while(!feof($fp))
	{
		$ligne = fgets($fp,255);// lit une ligne
		$part = explode("\t",$ligne);
		for($i=0;$i>$n;$i++)
		{
			$table[] = (double)$part[$i];
		}
	}
}

function add_enveloppe($e1,$e2)
{
	if($e1[0]<$e2[0]) $e3[0]=$e1[0]; else $e3[0]=$e2[0];//x1
	if($e1[2]>$e2[2]) $e3[2]=$e1[2]; else $e3[2]=$e2[2];//x2
	if($e1[1]<$e2[1]) $e3[1]=$e1[1]; else $e3[1]=$e2[1];//y1
	if($e1[3]>$e2[3]) $e3[3]=$e1[3]; else $e3[3]=$e2[3];//x2
	return $e3;
}

class polygone {
	//===========================================================================================================
	// Attributs
	//===========================================================================================================
	/**
	*array pour le stockage des points du polygone.Un polygone est un tableau unidimensionnel
	*où se succdèdent les coordonnées x et y de chaque point. L'ordre des points est très important.
	*@var double
	*/
	var $table;
	/**
	/* tableau de 4 éléments contenant le rectangle enveloppant le polygone
	/* dans l'ordre Xmin,Ymin,Xmax,Ymax
	*/
	var $enveloppe;

	//=============================================================================================================
	// Méthodes
	//=============================================================================================================

	/**
	/*Constructeur
	*/
	function polygone(){}

	function getPolygone(){
		return $this->table;
	}
	function getEnveloppe(){
		return $this->enveloppe;
	}

	/**
	/*$fp handle sur un fichier. Les données doivent être au format tab/tab/return
	*/
	function file2polygone($fp)
	{
		while(!feof($fp))
		{
			$ligne = fgets($fp,255);// lit une ligne
			$part = explode("\t",$ligne);
			$this->table[] = (double)$part[0];//x
			$this->table[] = (double)$part[1];//y
		}
	}
	/**
	/*calcule les dimensions du rectangle entourant le polygone
	*/
	function enveloppe()
	{
		$n = sizeof($this->table);
		$minx = $this->table[0];
		$maxx = $minx;
		$miny = $this->table[1];
		$maxy = $miny;
		for($i=2;$i<$n-1;$i+=2)
		{
			if($minx > $this->table[$i]) $minx = $this->table[$i];
			if($maxx < $this->table[$i]) $maxx = $this->table[$i];

			if($miny > $this->table[$i+1]) $miny = $this->table[$i+1];
			if($maxy < $this->table[$i+1]) $maxy = $this->table[$i+1];
		}
		$this->enveloppe[0]=$minx;
		$this->enveloppe[1]=$miny;
		$this->enveloppe[2]=$maxx;
		$this->enveloppe[3]=$maxy;
	}
	/**
	/*retourne le plus petit rectangle entglobant 2 enveloppes
	/* les 2 enveloppes ne sont pas nécessairement jointives
	/* $e2 enveloppe ajoutée
	/* $e1 enveloppe courante
	/* $e3 enveloppe résultante
	*/
	function add_enveloppe($e2)
	{
		$e1 = $this->enveloppe;
		if($e1[0]<$e2[0]) $e3[0]=$e1[0]; else $e3[0]=$e2[0];//x1
		if($e1[2]>$e2[2]) $e3[2]=$e1[2]; else $e3[2]=$e2[2];//x2

		if($e1[1]<$e2[1]) $e3[1]=$e1[1]; else $e3[1]=$e2[1];//y1
		if($e1[3]>$e2[3]) $e3[3]=$e1[3]; else $e3[3]=$e2[3];//x2
		return $e3;
	}

}// end classe polygone
?>
