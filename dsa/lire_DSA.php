<?php
/**
*	lire_DSA.php
*	lit un fichier txt et met le contenu dans la table dsa
*/
require "../classe_dessin.php";
require "../carto_utilitaires.php";
require("../utilitaires_dessin.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
*	peuple la table dsa à partir du fichier dsa.txt
*/
function table_dsa()
{
	global $connexion;
	
	$fp = fopen("dsa.txt","r");
	while(!feof($fp))
	{
		$ligne = fgets($fp);
		$ligne = addslashes($ligne);
		$item = explode("\t",$ligne);
		$ville = trim($item[3]);
		$requete = "SELECT ville_ID FROM ville WHERE ville_nom LIKE '$ville%'";print($requete."<br>");
		$resultat = ExecRequete($requete,$connexion);
		$rub = mysql_fetch_array($resultat);
		$ville_ID = $rub['ville_ID'];
		if($ville_ID)
		{
			$requete = "INSERT  INTO dsa VALUES('','1','$item[0]','$ville_ID','','','$item[1]','$item[4]','$item[5]','$item[7]')";
			$resultat = ExecRequete($requete,$connexion);
			print($requete."<br>");
		}
		else print($rub['ville_ID']." introuvable<br>");
	}
	fclose($fp);
}

//function cartographie()
{
	global $connexion;
// zone réservée au dessin:
	$image_width = 660;//
	$image_heigth = 800;//
// lectures des données
	$requete = "SELECT ville_ID,ville_insee,ville_nom,ville_lambertX,ville_lambertY
					FROM ville
					WHERE ville.ville_insee BETWEEN '67000' AND '67900'
					ORDER BY ville_insee
					";
	$resultat = ExecRequete($requete,$connexion);
	while($rub = mysql_fetch_array($resultat))
	{
		$file = "../carto/contour_communes/".$rub['ville_insee'].".txt";
		if (file_exists($file))
		{
			
			$ville[$rub['ville_insee']]['nom']=$rub['ville_nom'];
			$ville[$rub['ville_insee']]['x']=$rub['ville_lambertX'];
			$ville[$rub['ville_insee']]['y']=$rub['ville_lambertY'];
			$ville[$rub['ville_insee']]['com_ID']=$rub['ville_ID'];
			
			// lire les fichiers sources correspondants. Au retour le tableau zone contient autant de sous tableaux
			// qu'il y a de départements à dessiner. Le 1er indice correspond au n° du tableau (ex.0 pour le 67), le 2ème indice
			// correspond à la suite des points x,y
			fichierTXT2array(ouvre_fichier($file),$commune[$rub['ville_insee']]);
			$requete2 = "SELECT SUM(dsa_nb) AS nb FROM dsa WHERE dsa.ville_ID= '$rub[ville_ID]'";
			$resultat2 = ExecRequete($requete2,$connexion);
			$rep = mysql_fetch_array($resultat2);
			$ville[$rub['ville_insee']]['nb_dsa']=$rep['nb'];
			if($rep['nb'])
				print($rub['ville_nom'].": ".$rep['nb']."<br>");
		}
	}
//correction de proportionalité. $U_haut,$U_bas,$U_droit ,$U_gauche sont des variables globales auto. crés par fichierTXT2array
	$univers_h = $U_haut - $U_bas;
	$univers_w = $U_droit - $U_gauche;
	if($univers_w > $univers_h)
		$image_heigth = $univers_h*$image_width/$univers_w;
	else
		$image_width = $image_heigth*$univers_w/$univers_h;
//Initialisation de la zone de dessin
	$d = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
	$peachpuff = imagecolorAllocate($d->pic,0xFF,0xda,0xB9);
	$moccasin = imagecolorAllocate($d->pic,0xFF,0xE4,0xB5);
	$bleu = imagecolorAllocate($d->pic,0x00,0x00,0xff);
	$rouge = imagecolorAllocate($d->pic,0xff,0x00,0x00);
	$blanc = imagecolorAllocate($d->pic,0xff,0xff,0xff);
// Dessin des départements et des régions
while($elem = each($commune))
{
	$dp = $d->polygoneU2E($commune[$elem['key']]);// $elem['key'] contient com_INSEE
	if($ville[$elem['key']]['nb_dsa'] != 0)
	{
		$couleur = $rouge;
		$zone[]=$dp;
	}
	else
		$couleur = $moccasin;
	$d->dessine_polygone($dp,$couleur,"");
	$rayon = 5;
	//$d->cercle($ville[$elem['key']]['x'],$ville[$elem['key']]['y']/10,$rayon,$bleu, "",$ville[$elem['key']]['nom'],"1");
	$d->cercle($ville[$elem['key']]['x'],$ville[$elem['key']]['y']/10,$rayon,$bleu, "","","1");
}

//$d->affiche_image("Cartographie SAMU 67 - ".$_GET['titre']);//
$d->enregistre_image($titre="pic.png");
print("<IMG SRC=\"pic.png\" NAME=\"logo-html\" ALT=\"cart des disponibilités\" BORDER=1 USEMAP=\"#garde\">");
}

//table_dsa();
//cartographie();
?>