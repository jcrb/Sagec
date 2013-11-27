<?php
/**
*	Dessine une rose des vents
*	@data $alpha direction du vent en degré
* 	@return image de la rose des vents
*/
function windRose($alpha,$path="./")
{
	/* zone de dessin */
	$enveloppe = 400; 	// dimension du carré enveloppe
	$cote = 300; 		// dimension du cercle
	$x0 = $enveloppe/2; 		// coordonnées du centre
	$y0 = $x0;
	/* création d'un fond transparent */
	$im = imagecreatetruecolor($enveloppe,$enveloppe);
	// Active l'antialiasing pour une image
	//imageantialias($im, true);
	$white=imagecolorallocatealpha($im,255,255,255,127);
	$transparent = imagecolortransparent($im,$white);
	imagefill($im, 0, 0, $transparent);
	// Couleur de l'ellipse noir par défaut
	$col_ellipse = imagecolorallocate($im, 0, 0, 0);
	// On dessine l'ellipse externe
	imageellipse($im, $x0, $y0, $cote, $cote, $col_ellipse);
	// ellipse interne
	imageellipse($im, $x0, $y0, $cote-15, $cote-15, $col_ellipse);
	// direction du vent (noir par défaut)
	$color_trait =  imagecolorallocate($im, 0, 0, 0);
	$angle = $alpha;
	$trait = $cote/2;
	// position du point opposé sur le cercle (queue de la flèche)
	$x2 = $x0 + cos( deg2rad($angle-90)) * $trait;
	$y2 = $y0 + sin( deg2rad($angle-90)) * $trait;
	imageline($im,$x0,$y0,$x2,$y2,$color_trait);
	// position du point sur le cercle (pte de la flèche)
	$x2 = $x0 + cos( deg2rad($angle+90)) * $trait;
	$y2 = $y0 + sin( deg2rad($angle+90)) * $trait;
	imageline($im,$x0,$y0,$x2,$y2,$color_trait);
	
	// Dessin du triangle
	$x3 = $x0 + cos( deg2rad($angle)) * 10;
	$y3 = $y0 + sin( deg2rad($angle)) * 10;
	$x4 = $x0 - cos( deg2rad($angle)) * 10;
	$y4 = $y0 - sin( deg2rad($angle)) * 10;
	
	imageline($im,$x4,$y4,$x3,$y3,$color_trait);
	imageline($im,$x2,$y2,$x3,$y3,$color_trait);
	imageline($im,$x2,$y2,$x4,$y4,$color_trait);
	
	// dessin du polygone
	$sommet = array($x4,$y4,$x3,$y3,$x2,$y2,$x4,$y4);
	imagefilledpolygon($im, $sommet, sizeof($sommet)/2, $color_trait);
	
	// dessin des valeurs
	$font = $path."AgencyR.TTF";
	$cpolice = $color_trait;
	$font_size = 12;
	$r = $trait + 25;	// rayon plus grand
	$sizeWord = 0;
	for($i=0;$i<360;$i+=22.5)
	{
		if($i>180) // pour respecter la symétrie du texte
		{
			$a = imagettfbbox($font_size,0,$font, $i);
			$sizeWord = $a[2] - $a[0];
		}
		$x2 = $x0 + cos( deg2rad($i-90)) * $r - $sizeWord;
		$y2 = $y0 + sin( deg2rad($i-90)) * $r;
		imagettftext($im, $font_size, 0, $x2, $y2 + $font_size/2, $cpolice, $font, $i); 
	}
	
	// dessin des graduations
	for($i = 0; $i<365; $i+=10)
	{
		$x2 = $x0 + cos( deg2rad($i-90)) * $trait;
		$y2 = $y0 + sin( deg2rad($i-90)) * $trait;
		$x1 = $x0 + cos( deg2rad($i-90)) * ($trait - 15);
		$y1 = $y0 + sin( deg2rad($i-90)) * ($trait - 15);
		imageline($im,$x1,$y1,$x2,$y2,$color_trait);
	}
	
	// enregistrement de l'image
	imagepng($im,$path."rose_vent.png");
	//chmod($path."rose_vent.png",0777);
	/*
	imagegif($im,"rose_vent.gif");
	chmod("rose_vent.gif",0777);
	*/
	// On affiche l'image
	//header("Content-type: image/png");
	//imagepng($im);
	imagedestroy($im);
}
/*
$alpha = "90";
windRose($alpha);
*/
?>
