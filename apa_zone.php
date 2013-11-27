<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
/**																									 
*	programme: 			apa_zone.php																	 	
*	date de création: 	21/09/2003																		
*	auteur:				jcb																				
*	description:		supprime un vecteur	
*	@version:			$Id: apa_zone.php 39 2008-02-28 17:59:09Z jcb $																			
*	maj le:				21/09/2003																		
*/	
require("PMA_Connect.php");
require("PMA_Connexion.php");
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
// Le fichier doit être au format tab/tab/return
// $fp = handle sur le fichier ouvert
// $$nom_tableau = nom du tableau passé en argument par &
function fichier2array($fp,&$nom_tableau)
{
	global $U_droit;
	global $U_gauche;
	global $U_haut;
	global $U_bas;
	//print($U_gauche."-".$U_droit."-".$U_haut."-".$U_bas."<BR>");
	// lecture des points du fichier
	while(!feof($fp))
	{
		$ligne = fgets($fp,100);// lit une ligne
		$part = explode("\t",$ligne);// le tableau $part stocke les éléments séparés par une tabulation
		$X = (double)$part[0];// X
		$Y = (double)$part[1];// Y
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
		//print($Y."<BR>");
		if($Y > $U_haut )$U_haut = $Y;// détermination de Y min et Y max
		if($Y < $U_bas )$U_bas = $Y;
		$nb_sommets++;	// nb de sommets du polygone
		//print($X." - ".$Y."<BR>");
	}
	fclose($fp);
	//print($U_gauche."-".$U_droit."-".$U_haut."-".$U_bas."-".$nom_tableau."<BR>");
}

$nb_sommets = 0;
// initialisation des variables qui serviront à déterminer le min et le max
$U_gauche = (double)100000;
$U_droit = (double)0;
$U_haut = (double)0;
$U_bas = (double)100000;
$i = (double)0;

$zone1 = array();
fichier2array(ouvre_fichier("carto/zone1.txt"),$zone1);
$zone2 = array();
fichier2array(ouvre_fichier("carto/zone2.txt"),$zone2);
$zone3 = array();
fichier2array(ouvre_fichier("carto/zone3.txt"),$zone3);
$zone4 = array();
fichier2array(ouvre_fichier("carto/zone4.txt"),$zone4);
$zone5 = array();
fichier2array(ouvre_fichier("carto/zone5.txt"),$zone5);
$zone6 = array();
fichier2array(ouvre_fichier("carto/zone6.txt"),$zone6);
$zone7 = array();
fichier2array(ouvre_fichier("carto/zone7.txt"),$zone7);
$zone8 = array();
fichier2array(ouvre_fichier("carto/zone8.txt"),$zone8);
$zone9 = array();
fichier2array(ouvre_fichier("carto/zone9.txt"),$zone9);

// essai de zoom
$zom = 0;
$U_gauche = $U_gauche + $zom;
$U_droit = $U_droit - $zom;
$U_haut = $U_haut - $zom;
$U_bas = $U_bas + $zom;
// taille de la feuille de dessin
$image_width = 650;
$image_heigth = 800;
// taille de la zone de dessin. $C_haut et $C_bas sont volontairement incersés
// pour tenir compte du fait que l'origine du graphique est le point haut-gauche'
$marge_haute = 20;
$marge_basse = 20;
$marge_gauche = 20;
$marge_droite = 20;
$C_haut = $marge_haute;
$C_bas = $image_heigth - $marge_basse;
$C_gauche = $marge_gauche;
$C_droit = $image_width - $marge_droite;
// calcul des coef.de transformation univers -> écran
$a8 = ($C_droit - $C_gauche) / ($U_droit - $U_gauche);
$b8 = ($C_gauche * $U_droit - $C_droit * $U_gauche) / ($U_droit - $U_gauche);
$a9 = ($C_haut - $C_bas) / ($U_haut - $U_bas);
$b9 = ($C_bas * $U_haut - $C_haut * $U_bas) / ($U_haut - $U_bas);

// mise à l'échelle des points
for( $i = 0; $i < count($zone1); $i+=2)
{
	//print($zone1[$i]." - ".$zone1[$i+1]."<BR>");
	$zone1[$i] = $a8 * $zone1[$i] + $b8;
	$zone1[$i+1] = $a9 *$zone1[$i+1] + $b9;
	//print($zone1[$i]." - ".$zone1[$i+1]."<BR>");
}

for( $i = 0; $i < count($zone2); $i+=2)
{
	$zone2[$i] = $a8 * $zone2[$i] + $b8;
	$zone2[$i+1] = $a9 *$zone2[$i+1] + $b9;
}
for( $i = 0; $i < count($zone3); $i+=2)
{
	$zone3[$i] = $a8 * $zone3[$i] + $b8;
	$zone3[$i+1] = $a9 *$zone3[$i+1] + $b9;
}
for( $i = 0; $i < count($zone4); $i+=2)
{
	$zone4[$i] = $a8 * $zone4[$i] + $b8;
	$zone4[$i+1] = $a9 *$zone4[$i+1] + $b9;
}
for( $i = 0; $i < count($zone5); $i+=2)
{
	$zone5[$i] = $a8 * $zone5[$i] + $b8;
	$zone5[$i+1] = $a9 *$zone5[$i+1] + $b9;
}
for( $i = 0; $i < count($zone6); $i+=2)
{
	$zone6[$i] = $a8 * $zone6[$i] + $b8;
	$zone6[$i+1] = $a9 *$zone6[$i+1] + $b9;
}
for( $i = 0; $i < count($zone7); $i+=2)
{
	$zone7[$i] = $a8 * $zone7[$i] + $b8;
	$zone7[$i+1] = $a9 *$zone7[$i+1] + $b9;
}
for( $i = 0; $i < count($zone8); $i+=2)
{
	$zone8[$i] = $a8 * $zone8[$i] + $b8;
	$zone8[$i+1] = $a9 *$zone8[$i+1] + $b9;
}
for( $i = 0; $i < count($zone9); $i+=2)
{
	$zone9[$i] = $a8 * $zone9[$i] + $b8;
	$zone9[$i+1] = $a9 *$zone9[$i+1] + $b9;
}
$texte = "SAMU 67";
?>

<html> 
<head> 
<!-- A coller entre les balises <head> et </head> -->

<script language="JavaScript">

ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false

// cette version de init n'est pas utilisée
function init() 
{
	if (ns4) 
		{document.captureEvents(Event.MOUSEMOVE);}
	document.onmousemove=mousemove;
}
function mousemove(e) {
if (ns4) {var mouseX=e.pageX; var mouseY=e.pageY}
if (ie4) {var mouseX=event.x; var mouseY=event.y}
status="x = "+mouseX+" , y = "+mouseY;
}
</script>

<script type="text/javascript" language="JavaScript"> 
	var Coordx = 0; 
	var Coordy = 0;
	
	// tableau pour stocker les communes et leurs coordoonées 
	var ville = new Array();
	var vx = new Array();
	var vy = new Array();
	var compteur = 0;// servira à compter le nombre de communes enregistrées
	
	e=window.event;

	// initialise l'évènement mouse move
	function init2() 
	{
		if (ns4) 
			{document.captureEvents(Event.MOUSEMOVE);}
		document.onmousemove=coord;
	}
	// récupération de la coordonnée horizontale
	function mousex(e)
	{
  		if(document.layers) {return e.x;}
  		else {return event.offsetX;}
	}
	// récupération de la coordonnée horizontale
	function mousey(e)
	{
  		if(document.layers) {return event.y;}
  		else {return event.offsetY;}
	}
	// affichage des coordonnées
	function coord(e)
	{ 
		Coordx = mousex(); 
		Coordy = mousey();
		// détection de la ville proche de la souris
		for(i = 0; i < ville.length; i++)
		{
			if(Math.abs(Coordx-vx[i])<5 && Math.abs(Coordy-vy[i])<5)
				break;
		}
		var nom = ", ";
		if(i < ville.length)
			nom += ville[i];
		else
			nom =""; 
		// écriture des informations dans la barre de status 
		status="x = " + Coordx + ", y = " + Coordy + nom;
	}
</script> 
</head> 
<body > 
<form name="carte" action="apa_zone.php" method="get">
<input type ="text" name = "ville">
<input type ="submit" name = "ok">
<?php 
// <body onLoad=init2()>
// codes d'accès à la base
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
/*
define(NOM,"root");
define(PASSE,"");
define(SERVEUR,"localhost");
define(BASE,"Carto");
$connexion = mysql_pconnect(SERVEUR,NOM,PASSE);
if(!connexion)
{
	echo("Désolé, connexion au serveur SERVEUR impossible\n");
	exit();
}
// connexion à la base
if(!mysql_select_db(BASE,$connexion))
{
	echo("Désolé, connexion à la base $pBase impossible\n");
	echo"<B>Message de MySql: </B>".mysql_error($connexion);
	exit();	
}
*/
// création de l'objet image qui contiendra la carte'
$pic=ImageCreate($image_width,$image_heigth); 
// définition des couleurs
$blanc = imagecolorAllocate($pic,255,255,255);
$col1=ImageColorAllocate($pic,200,200,200); 
$bleu=ImageColorAllocate($pic,0,0,255);  
$vert=ImageColorAllocate($pic,0,255,0);
$rouge=ImageColorAllocate($pic,255,0,0);
$black = imagecolorAllocate($pic,0,0,0);
$aliceblue = imagecolorAllocate($pic,240,248,255);
$antiquewhite = imagecolorAllocate($pic,250,235,215);
$gold = imagecolorAllocate($pic,255,215,0);
$khaki = imagecolorAllocate($pic,240,230,140);
$sandybrown = imagecolorAllocate($pic,244,164,96);
$wheat = imagecolorAllocate($pic,245,222,179);
$tomato = imagecolorAllocate($pic,255,99,71);
$thistle = imagecolorAllocate($pic,216,191,216);
$peachpuff = imagecolorAllocate($pic,255,218,185);
// le fond de l'image est blanc
imagefill($pic,0,0,$blanc);
// dessin des contours et du fond
imagefilledpolygon( $pic, $zone1, count($zone1)/2, $vert);
imagepolygon ( $pic, $zone1, count($zone1)/2, $black);
imagefilledpolygon( $pic, $zone2, count($zone2)/2, $aliceblue);
imagepolygon ( $pic, $zone2, count($zone2)/2, $black);
imagefilledpolygon( $pic, $zone3, count($zone3)/2, $antiquewhite);
imagepolygon ( $pic, $zone3, count($zone3)/2, $black);
imagefilledpolygon( $pic, $zone4, count($zone4)/2, $khaki);
imagepolygon ( $pic, $zone4, count($zone4)/2, $black);
imagefilledpolygon( $pic, $zone5, count($zone5)/2, $sandybrown);
imagepolygon ( $pic, $zone5, count($zone5)/2, $black);
imagefilledpolygon( $pic, $zone6, count($zone6)/2, $gold);
imagepolygon ( $pic, $zone6, count($zone6)/2, $black);
imagefilledpolygon( $pic, $zone7, count($zone7)/2, $wheat);
imagepolygon ( $pic, $zone7, count($zone7)/2, $black);
imagefilledpolygon( $pic, $zone8, count($zone8)/2, $thistle);
imagepolygon ( $pic, $zone8, count($zone8)/2, $black);
imagefilledpolygon( $pic, $zone9, count($zone9)/2, $tomato);
imagepolygon ( $pic, $zone9, count($zone9)/2, $black);

// dessin des villes
$requete="SELECT com_ID,com_nom,vsav,L2x,L2y FROM commune WHERE '1'";
$resultat = mysql_query($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$rub[L2y] = $rub[L2y]/10;
	// coordoonées écran du point
	$xe = $a8 * $rub[L2x] + $b8;
	$ye = $a9 * $rub[L2y] + $b9;
	$taille_min = 8;
	if($rub[vsav]>0)
	{
		$taille = $taille_min + $rub[vsav]*3;
		$color = $rouge;
		imagestring($pic,3,$xe,$ye,$rub[com_nom],$black);
	}
	else
	{
		$taille = $taille_min;
		$color = $bleu;
	}
	if($ville == $rub[com_nom] )
	{
		$color = $black;
		imagestring($pic,3,$xe,$ye,$rub[com_nom],$black);
	}
	imagearc ($pic ,$xe, $ye, $taille, $taille, 0, 360, $color );
	?> 
	
	<script language="JavaScript">
	// remplissage du tableau des villes et de leurs coordonnées
		ville[compteur] = "<?php echo($rub[com_nom]);?>";
		vx[compteur] = "<?php echo($xe);?>";
		vy[compteur] = "<?php echo($ye);?>";
		compteur++;
	</script>
	<?php
}
// impression de la légende
imagestring($pic,5,$marge_gauche,$marge_basse,"Secteurs des ASSU",$black);
// enreistrement de l'image dans un fichier
ImagePNG($pic,"pic.png"); 
// libération des ressources
ImageDestroy($pic); 
print("carto SAMU");

?> 
<!-- chargement de l'image et initialisations !-->
<img src="pic.png" border=0 onLoad=init2()> 
</form>
</body> 
</html> 
