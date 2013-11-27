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
/**
* La classe CDessin définit une zone de dessin capable de recevoir des coordoonées dans le système
* de mesure de l'utilisateur et de les afficher à la résolution de l'écran.
*	programme: 		classe_dessin.php
*	date de création: 	31/01/2004
*	@author jcb
*	@version $Id: classe_dessin.php 3 2006-07-27 22:18:23Z jcb $
*	@maj le 29/07/2005
*	@package Sagec
*
*	REMARQUE: utilise les fontes présentes dans /usr/share/fonts/truetype
*/
//---------------------------------------------------------------------------------------------//
require_once "sagec.conf";
class CDessin
{
	// Attributs
	/**
	*coefficients de transformation des données réelles en coordonnées écran.
	*@var double
	*/
	var $a8,$a9,$b8,$b9;
	/**
	*marges de la fenêtre de dessin. Par défaut chacune vaut 20 pixels
	*@var integer
	*/
	var $marge_haute,$marge_basse,$marge_gauche,$marge_droite;
	/**
	*Largeur et hauteur de la fenêtre de dessin en pixels
	*@var integer
	*/
	var $image_heigth,$image_width;
	/**
	*Limites du rectangle de dessin en coordonnées utilisateurs (m, km, etc...).
	*@var double
	*/
	var $U_droit,$U_gauche,$U_haut,$U_bas;
	/**
	*couleurs par défaut
	*@var integer
	*/
	var $pic, $blanc, $noir;
	/**
	*position courante du crayon en pixels.
	*@var integer
	*/
	var $xcourant,$ycourant;
	/**
	*Couleur courante, utilisée par défaut par le crayon.
	*@var integer
	*/
	var $couleur_courante;
	
	/**
	* fontes true type utilisables
	* php va chercher les fontes dans le dossier /usr/share/fonts/truetype
	*/
	var $myFont = 'freefont/FreeMono';
	var $myFont_bold = 'freefont/FreeMonoBold';
	var $myFont_italique = 'freefont/FreeMonoOblique';
	var $myFont_gras_italique = 'freefont/FreeMonoBoldOblique';

	//=============================================================================================================
	// Méthodes
	//=============================================================================================================
	/**
	*Constructeur d'un objet de dessin.
	*@return un pointeur sur la classe dessin
	*@final
	*@since 1.0
	*@param integer hauteur de l'image à l'écran (en pixels).
	*@param integer largeur de l'image à l'écran (en pixels).
	*@param double point haut (y) du rectangle utilisateur (coordonnées de l'utilisteur).
	*@param double point gauche (x) du rectangle utilisateur (coordonnées de l'utilisteur).
	*@param double point bas (y) du rectangle utilisateur (coordonnées de l'utilisteur).
	*@param double point droit (x) du rectangle utilisateur (coordonnées de l'utilisteur).
	*@param mixed pointeur sur une zone de mémoire dessin allouée par imagecreatetruecolor. Si cette valeur est vide,
	*le constructeur se charge de la réserver.
	*/
	function CDessin($hauteur_image,$largeur_image,$univers_top,$univers_left,$univers_bottom,$univers_right,$image="")
	{
		$this->image_heigth = $hauteur_image;
		$this->image_width =$largeur_image;
		$this->U_droit= $univers_right;
		$this->U_gauche= $univers_left;
		$this->U_haut= $univers_top;
		$this->U_bas= $univers_bottom;
		if($image=="")
			$this->pic = imagecreatetruecolor($this->image_width,$this->image_heigth);
			//$this->pic = ImageCreate($this->image_width,$this->image_heigth);
		else
			$this->pic = $image;
		$this->initialise();
		$this->calcul_coef();
	}
	/**
	*Re-Initialisation de l'objet dessin. On garde la même disposition mais la taille de l'univers est modifiée
	*ce qui permet de superposer des images d'échelles différentes sur le même graphe.
	*/
	function setUnivers($univers_top,$univers_left,$univers_bottom,$univers_right)
	{
		$this->U_droit= $univers_right;
		$this->U_gauche= $univers_left;
		$this->U_haut= $univers_top;
		$this->U_bas= $univers_bottom;
		$this->calcul_coef();
		$this->xcourant = 0;
		$this->ycourant = 0;
	}
	/**
	*Redéfinit les marges par défaut. La zone de dessin et les coefficients de transformation sont automatiquement
	*réajustés.
	*/
	function setMarges($haute,$basse,$gauche,$droite)
	{
		$this->marge_haute = $haute;
		$this->marge_basse = $basse;
		$this->marge_gauche = $gauche;
		$this->marge_droite = $droite;
		$this->C_haut = $this->marge_haute;
		$this->C_bas = $this->image_heigth - $this->marge_basse;
		$this->C_gauche = $this->marge_gauche;
		$this->C_droit = $this->image_width - $this->marge_droite;
		$this->calcul_coef();
	}
	/**
	*Initialisation de l'objet dessin. Cette méthode est appelée par le contructeur pour définir un certain nombre
	*de valeurs par défaut.
	*/
	function initialise()
	{
		$this->marge_haute = 20;
		$this->marge_basse = 20;
		$this->marge_gauche = 20;
		$this->marge_droite = 20;
		$this->C_haut = $this->marge_haute;
		$this->C_bas = $this->image_heigth - $this->marge_basse;
		$this->C_gauche = $this->marge_gauche;
		$this->C_droit = $this->image_width - $this->marge_droite;
		//$this->pic=ImageCreate($this->image_width,$this->image_heigth);
		// définition de 2 couleurs de base
		$this->blanc = imagecolorAllocate($this->pic,255,255,255);
		$this->noir = imagecolorAllocate($this->pic,0,0,0);
		$this->couleur_courante = $this->noir;
		// le fond de l'image est blanc. Il y a 2 méthodes possibles. imagefill() semble ne pas fonctionner
		// sur le serveur des HUS
		//imagefill($this->pic,0,0,$this->blanc);
		ImageFilledRectangle($this->pic,0,0,$this->image_width,$this->image_heigth,$this->blanc);
		$this->xcourant = 0;
		$this->ycourant = 0;
	}
	/**
	*Calcul des coefficients de mise à l'échelle. Ces coefficients permettent de transformer un point en coordonnées
	*univers, en coordonnées écran et réciproquement.
	*/
	function calcul_coef()
	{
		// calcul des coef.de transformation univers -> écran
		$this->a8 = ($this->C_droit - $this->C_gauche) / ($this->U_droit - $this->U_gauche);
		$this->b8 = ($this->C_gauche * $this->U_droit - $this->C_droit * $this->U_gauche) / ($this->U_droit - $this->U_gauche);
		$this->a9 = ($this->C_haut - $this->C_bas) / ($this->U_haut - $this->U_bas);
		$this->b9 = ($this->C_bas * $this->U_haut - $this->C_haut * $this->U_bas) / ($this->U_haut - $this->U_bas);
		
		//print("C_droit = ".$this->C_droit."<BR>");
		//print("C_gauche = ".$this->C_gauche."<BR>");
		//print("U_droit = ".$this->U_droit."<BR>");
		//print("U_gauche = ".$this->U_gauche."<BR>");
		
		//print("a8 = ".$this->a8."<BR>");
		//print("b8 = ".$this->b8."<BR>");
		//print("a9 = ".$this->a8."<BR>");
		//print("b9 = ".$this->a8."<BR>");
	}
	/**
	*Transforme une abcisse rélle, en abcisse écran (pixel).
	*@param double abcisse x d'un point de l'univers
	*@return integer abcisse du point en coordonnées écran
	*/
	function xe($x)
	{
		return $this->a8 * $x + $this->b8;
	}
	/**
	*Transforme une ordonnée rélle, en ordonnée écran (pixel).
	*@param double ordonnée y d'un point de l'univers
	*@return integer ordonnée du point en coordonnées écran
	*/
	function ye($y)
	{
	 	return $this->a9 * $y + $this->b9;
	}
	/**
	*Lève la pointe du crayon et la déplace vers le point de coordonnées univers $x,$y.
	*@param double abcisse x d'un point de l'univers
	*@param double ordonnée y d'un point de l'univers
	*/
	function va_en($x,$y)// se déplace au point x,y en coordonnées univers
	{
		$this->xcourant = $this->xe($x);
		$this->ycourant = $this->ye($y);
	}
	/**
	*Déplace la pointe du crayon depuis le point courant vers le point de coordonnées univers $x,$y
	*en traçant une ligne.
	*@param double abcisse x d'un point de l'univers
	*@param double ordonnée y d'un point de l'univers
	*/
	function trace_vers($x,$y)
	{
		imageline ($this->pic ,$this->xcourant ,$this->ycourant ,$this->xe($x) ,$this->ye($y), $this->couleur_courante);
		$this->xcourant = $this->xe($x);
		$this->ycourant = $this->ye($y);
	}
	/**
	*trace une ligne entre les points (x1,y1) et (x2,y2)
	*@param double abcisse x d'un point de l'univers
	*@param double ordonnée y d'un point de l'univers
	*@param double abcisse x d'un point de l'univers
	*@param double ordonnée y d'un point de l'univers
	*/
	function line($x1,$y1,$x2,$y2)
	{
		imageline ($this->pic ,$this->xe($x1) ,$this->ye($y1) ,$this->xe($x2) ,$this->ye($y2), $this->couleur_courante);
		$this->xcourant = $this->xe($x2);
		$this->ycourant = $this->ye($y2);
	}
	/**
	*Dessine un symbole en forme de haltères représentant l'échelle d'une carte avec son titre
	*@param échelle de la carte: ex 50 = 50 km
	*/
	function echelle($km)// distance à représenter.ex 50 = 50 km
	{

		$x1 = $this->xe($this->U_gauche);
		$x2 = $this->xe($this->U_gauche + $km);
		$y = $this->C_bas + 10;
		imageline ($this->pic ,$x1 ,$y ,$x2 ,$y, $this->noir);
		imageline ($this->pic ,$x1 ,$y-5 ,$x1 ,$y+5, $this->noir);
		imageline ($this->pic ,$x2 ,$y-5 ,$x2 ,$y+5, $this->noir);
		$titre = $km." km";
		//imagestring($this->pic,3,$x2+10,$y-5,$titre,$this->noir);
		$this->writetxt(8,0,$x2,$y,10,4,$this->noir,$titre);
	}
	/**
	*Dessine un texte en utilisant la fonte arial si elle est présente ou une fonte système par défaut
	*@param taille de la fonte en points.
	*@param angle d'écriture (ne fonctionne qu'avec les fontes true type).
	*@param abcisse du début du texte en pixels.
	*@param ordonnée du début du texte en pixels.
	*@param décalage horizontal du texte en pixels.
	*@param décalage vertical du texte en pixels.
	*@param couleur du texte.
	*@param texte à afficher.
	*/
	function writetxt($fontsize,$fontangle,$x,$y,$dx,$dy,$color,$texte)
	{
		if(!is_file($this->arial) || !extension_loaded('freetype'))
		{
			$xe = $x+$dx-8;
			$ye = $y+$dy-12;
			if($fontsize > 10)$fontsize=5;
			else $fontsize = 3;
			imagestring($this->pic,$fontsize,$xe,$ye,$texte, $color);
		}
		else // écrit avec une fonte true type
		{
			$xe = $x + $dx;
			$ye = $y + $dy;
			imagettftext($this->pic,$fontsize,$fontangle,$xe,$ye,$color,$this->myFont,$texte);
		}
	}
	/**
	*Transforme un polygone réel, en polygone écran (pixel).
	*@param array Tableau contenant la liste des points constituant le polygone sous la forme
	*$polygone = array(x1,y1,x2,y2,...,xn,yn).
	*@return array contenant les mêmes points mais en coordonnées écran.
	*/
	function polygoneU2E($poly) // transforme un polugone univers en coord. écran
	{
		$n=count($poly);
		for( $i = 0; $i < $n; $i+=2)
		{
			$polyE[$i] = $this->a8 * $poly[$i] + $this->b8;
			$polyE[$i+1] = $this->a9 *$poly[$i+1] + $this->b9;
		}
		return $polyE;
	}
	function dessine_polygone($poly, $couleur_fond="", $couleur_trait="")
	{
		if(!$couleur_fond)$couleur_fond = $this->blanc;
		if(!$couleur_trait)$couleur_trait = $this->noir;
		imagefilledpolygon( $this->pic, $poly, count($poly)/2, $couleur_fond);
		imagepolygon ( $this->pic, $poly, count($poly)/2, $couleur_trait);
	}
	/**
	*Enregistre une image dans un fichier sans l'afficher
	*@var string ($titre) chemin d'accès au fichier
	*/
	function enregistre_image($titre="pic.png")
	{
		// enregistrement de l'image dans un fichier
		ImagePNG($this->pic,$titre);
		// libération des ressources
		ImageDestroy($this->pic);
	}
	function affiche_image($titre="")
	{
		// impression de la légende
		//imagestring($this->pic,5,$this->marge_gauche,$this->marge_basse,$titre,$this->noir);
		$fontsize = 12;
		$fontangle = 0;
		$this->writetxt($fontsize,$fontangle,$this->marge_gauche,$this->marge_basse,0,-8,$this->noir,$titre);
		// enregistrement de l'image dans un fichier
		ImagePNG($this->pic,"pic.png");
		// Affichage de l'image
		Header("Content-type: image/png");
		ImagePNG($this->pic);
		// libération des ressources
		ImageDestroy($this->pic);
		//print("carto SAMU 67");
		//print("<img src=\"pic.png\" border=\"0\" onLoad=\"init2()\"> ");
	}
	function cercle($x,$y,$rayon="5",$couleur_fond="", $couleur_trait="",$titre="",$plein="")
	{
		$xe = $this->xe($x);
		$ye = $this->ye($y);
		//print($x." / ".$y." / ".$rayon."<BR>");
		if(!$couleur_trait)$couleur_trait = $this->noir;
		if(!$plein)
			imagearc ($this->pic ,$xe, $ye, $rayon, $rayon, 0, 360, $this->noir );
		else
			imagefilledellipse ( $this->pic ,$xe, $ye, $rayon, $rayon, $couleur_fond);
		// dessin des légendes
		$fontsize = 15;
		$fontangle = 0;
		$dx = -15;
		$dy = 18;
		$color = $this->noir;
		$this->writetxt($fontsize,$fontangle,$xe,$ye,$dx,$dy,$color,$titre);
	}
	/**
	*Dessine un cercle vide centré sur le point(x,y) de rayon R et dans la couleur C.
	*@param abcisse x du point en coordonnées réelles
	*@param abcisse y du point en coordonnées réelles
	*@param rayon du cercle en coordonnées réelles
	*@param couleur du cercle (noir par défaut)
	*/
	function isocercle($x,$y,$rayon,$couleur="")
	{
		$xe = $this->xe($x);
		$ye = $this->ye($y);
		$re = $this->ye($y)-$this->ye($y + $rayon);
		if($couleur=="")$couleur=$this->noir;
		imagearc ($this->pic ,$xe, $ye, $re*2, $re*2, 0, 360, $couleur);
		//$fp=fopen("test","w");
		//fwrite($fp,$xe.",".$ye.",".$re." ".$this->ye($y + $rayon)." ".$this->ye($y)."\n");
		//fclose($fp);
	}
	/** Dessine un rectangle plein
	*@param xg abcisse du point sup/gauche
	*@param yh ordonnée du point sup/gauche
	*@param xd abcisse du point sup/droit
	*@param yb ordonnée du point sup/droit
	*@param c couleur de remplissage
	*/
	function rectangle($xg,$yh,$xd,$yb,$c)
	{
		$x1 = $this->xe($xg);
		$y1 = $this->ye($yh);
		$x2 = $this->xe($xd);
		$y2 = $this->ye($yb);
		ImageFilledRectangle($this->pic,$x1,$y1,$x2,$y2,$c);
	}
	
	/**
	  * écrit un mot aux coordonnées réelles x,y avec le déxalage dx, dy en pixels
	  *	@param mot: mot à écrire
	  *	@param x: abcisse
	  *	@param y: ordonnée
	  *	@param dx: décalage/abcisse, défaut = 0
	  *	@param dy: décalage/ordonnée, défaut = 0
	  *	@param color: couleur de la fonte ($rouge=ImageColorAllocate($d->pic,255,0,0);)
	  *	@param font_size: taille de la police, défaut 10
	  *	@param alignment: alignement, défaut L (left)
	  *	@param fonte: graisse de la fonte (B = gras, I = italique, IB = italique gras, N = normal)
	  * 	@param angle: orientation du mot
	  */
	function ecrire($mot,$x,$y,$dx="",$dy="",$color="0",$font_size="10",$alignment='L',$fonte="N",$angle=0)
	{
		//$angle = 0;
		//$police = imageloadfont("carto2/public_rnibmoonfonts.ttf");
		//$arial = "/var/www/html/SAGEC67_v3/fontes/arial.ttf";
		//global $SAGEC_PATH;
		//$arial = $SAGEC_PATH."fontes/arial.ttf";
		switch($fonte){
			case 'N':$fff = $this->myFont;break;
			case 'B':$fff = $this->myFont_bold;break;
			case 'I':$fff = $this->myFont_italique;break;
			case 'IB':$fff = $this->myFont_gras_italique;break;
			default:$fff = $this->myFont;
		}
		//$police = 3;
		$xe = $this->xe($x) + $dx;
		$ye = $this->ye($y) + $dy;
		//print($xe." / ".$ye." / ".$mot."<BR>");
		if($color==0)$color = $this->noir;
		//imagestring($this->pic,$police,$xe,$ye,$mot, $color);
		//check width of the text
		if(function_exists('imagettfbbox'))
		{
   			$bbox = imagettfbbox ($font_size, $angle, $fff, $mot);
   			$textWidth = $bbox[2] - $bbox[0];
		}
		else
		{
			$textWidth=strlen($mot)*imagefontwidth($police);
		}
   		switch ($alignment)
		{
       		case "R":
           		$xe -= $textWidth;
           	break;
       		case "C":
           		$xe -= $textWidth / 2;
           	break;
		}
		if(function_exists('imagettftext'))
		{
			imagettftext($this->pic,$font_size,$angle,$xe,$ye,$color,$fff,$mot);
		}
		else
		{
			$dy = -12;
			$font_size = $police;
			imagestring($this->pic,$font_size,$xe,$ye+$dy,$mot, $color);
		}

	}
	
	/**
	  *	écrit un mot aux coordonnées en pixels x,y avec le déxalage dx, dy en pixels
	  *
	  */
	function pprint($mot,$x,$y,$dx="",$dy="",$color="0",$font_size="10",$alignment='L',$angle=0)
	{
		//global $SAGEC_PATH;
		//$arial = $SAGEC_PATH."fontes/arial.ttf";
		$arial = $this->myFont;
		//$police = 3;
		$xe = $x + $dx;
		$ye = $y + $dy;
		//print($xe." / ".$ye." / ".$mot."<BR>");
		if($color==0)$color = $this->noir;
		//imagestring($this->pic,$police,$xe,$ye,$mot, $color);
		//check width of the text
		if(function_exists('imagettfbbox'))
		{
   			$bbox = imagettfbbox ($font_size, $angle, $arial, $mot);
   			$textWidth = $bbox[2] - $bbox[0];
		}
		else
		{
			$textWidth=strlen($mot)*imagefontwidth($police);
		}
   		switch ($alignment)
		{
       		case "R":
           		$xe -= $textWidth;
           	break;
       		case "C":
           		$xe -= $textWidth / 2;
           	break;
		}
		if(function_exists('imagettftext'))
		{
			imagettftext($this->pic,$font_size,$angle,$xe,$ye,$color,$arial,$mot);
		}
		else
		{
			$dy = -12;
			$font_size = $police;
			imagestring($this->pic,$font_size,$xe,$ye+$dy,$mot, $color);
		}

	}
	function ecrire2()
	{
		$corps = 30;
		/* Le chemin du fichier de police True Type */
		$font = "/WINNT/fonts/arialbi.ttf";
		$texte = "Texte TrueType";
		/* ImageTtfBBox retourne les dimensions du texte */
		$size =ImageTtfBBox($corps,0,$font,$texte);
		$dx = abs($size[2]-$size[0]);
		$dy = abs($size[5]-$size[3]);
		$xpad=10;
		$ypad=10;
		$im = ImageCreate($dx+$xpad,$dy+$ypad);
		$fond = ImageColorAllocate($im,255,255,255);
		$couleur = ImageColorAllocate($im,255,210,100);
		/* ImageTtfText dessine le texte en partant de la ligne de base du premier caractère */
		ImageTtfText($im,$corps,0,(int)($xpad/2),$dy-(int)($ypad/2),$couleur,$font,$texte);
		ImagePng($im,"texte_truetype.png");
		ImageDestroy($im);
	}
	/** Dessine une grillehorizontale
	*@param $ymax ordonnée la plus haute
	*@param $ymin ordonnée la plus basse
	*@param $yinc incrément entre 2 lignes
	*@param $yinter ligne horizontale intermédiaire plus épaisse. 0 pour ne pas en mettre
	*@param $xmin abcisse minimale du trait
	*@param $xmax abcisse maximale du trait
	*@param $c1 couleur du trait usuel
	*@param $c2 couleur du trait épais
	*/
	function grilleH($ymax,$ymin,$yinc,$yinter,$xmin,$xmax,$c1,$c2)
	{
		// lignes horizontales tracées toutes les 10 points
		for($i = $ymin;$i<=$ymax;$i+=$yinc)
		{
			if($yinter !=0 && $i%$yinter ==0)
			{
				$this->couleur_courante = $c2;
				$decal_x = -4;
				$decal_y = 5;
				$this->ecrire($i,$xmin,$i,$decal_x,$decal_y,$c2,10,'R');
			}
			else
			{
				$this->couleur_courante = $c1;
			}
			$this->line($xmin,$i,$xmax,$i);
		}
	}
	function grilleV($xmin,$xmax,$xinc,$xinter,$ymin,$ymax,$c1,$c2)
	{
		$jour = 24*60*60;//secondes
		$an = 365*$jour;
		$mois = 31*$jour;
		$this->couleur_courante = $c2;
		// lignes verticales tracées toutes les heures
		$tmin = $xmin;
		$tdepart = strtotime($tmin);
		for($i=$xmin;$i<=$xmax;$i+=$xinc)
		{
			if($i == $xmin)
			{
				$this->couleur_courante = $c1;
				$t0 = date("M",$i);
				$this->ecrire($t0,$i,$ymin,0,30,$c2,10,'C');
				$t0 = date('j',$i);
				$this->ecrire($t0,$i,$ymin,0,15,$c2,10,'C');
				$this->line($i,$ymin,$i,$ymax);
			}
			if(date('j',$i)==1)
			{
				$this->couleur_courante = $c1;
				$t0 = date("M",$i);
				$this->ecrire($t0,$i,$ymin,0,30,$c2,10,'C');
				$t0 = date('j',$i);
				$this->ecrire($t0,$i,$ymin,0,15,$c2,10,'C');
				$this->line($i,$ymin,$i,$ymax);
			}
			else if(date('j',$i)%$xinter==0)
			{
				$this->couleur_courante = $c2;
				$t0 = date('j',$i);
				$this->ecrire($t0,$i,$ymin,0,15,$c2,10,'C');
				$this->line($i,$ymin,$i,$ymax);
			}

			$tmin += $xinc;
			//if($tmin>$an)$tmin=1;
			//$d->ecrire($t0,$i,$ymin,0,15,$c2,10,'C');
		}
	}
}
?>
