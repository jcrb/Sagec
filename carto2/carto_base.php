<?php
//Header("Content-type: image/png");
// carto_base.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."utilitairesHTML.php");
require($backPathToRoot."login/init_security.php");
require $backPathToRoot."classe_dessin.php";
require $backPathToRoot."carto_utilitaires.php";
require($backPathToRoot."utilitaires_dessin.php");
//require("../pma_requete.php");

$titre = $_REQUEST['titre'];
$objet = $_REQUEST['objet'];
$depart = $_REQUEST['depart2'];
$zoom = $_REQUEST['zoom'];

/* pour le d�boggage */
$fp = fopen('fichier.txt','w');

/**
  *	tableaux contenant la liste des d�partements � dessiner
  *	$liste = array(67,68,57,88,54,90,55);
  */
	$liste=explode("|", $_REQUEST["depart2"]);
	if(count($liste)<1)$liste = array(67);
	// fabrication de la liste utilis�e par mysql
	$inListe = "(";
	for($i=0;$i<count($liste);$i++)
		$inListe.="'".$liste[$i]."',";
	$inListe = substr($inListe, 0, strlen($inListe)-1); // ote la derni�re virgule
	$inListe.=")";
/**
  *	On cr�e un tableau de n tableaux appel� zone.
  *	Chacun de ces tableaux stockera les coordonn�es des points
  *	servant � dessiner un d�partement.
  */
$zone = array(array());

/**
  *========================================== D�but ==============================================================
  *
  *	zone r�serv�e au dessin:
  */
	$image_width = 660;//660 * 2;//$_GET[zoom];//660 440
	$image_heigth = 800;//800 * 2;//$_GET[zoom];//800 553
/**
  *	lectures des donn�es
  *	lire les fichiers sources correspondants. Au retour le tableau zone contient autant de sous tableaux
  *	qu'il y a de d�partements � dessiner. Le 1er indice correspond au n� du tableau (ex.0 pour le 67), le 2�me indice
  *	correspond � la suite des points x,y
  *	NB: c'est du gaspillage, un tableau unique suffirait:indice 0 = n� du d�partement, puis les point se suivent
  */
	for($i=0;$i<count($liste);$i++)
	{
		$file = $backPathToRoot."carto/d".$liste[$i].".txt";
		fichierNUM2array(ouvre_fichier($file),$zone[$i]);
	};
// essai Allemagne
//fichierNUM2array(ouvre_fichier("../carto/A51.txt"),$zone[$i]);
//correction de proportionalit�
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

/**
  *	Dessin des d�partements et des r�gions
  */
	for($i=0;$i <count($liste); $i++)
	{
		// Un d�partement en coord r�elles est transform� en coord.�cran
		$dp = $d->polygoneU2E($zone[$i]);
		$couleur = $moccasin;
		$d->dessine_polygone($dp,$couleur,"");
	}
/**
  *	affiche les villes avec r�animation, morques
  */
if($objet=='rea_adulte' || $objet=='rea_ped'|| $objet=='morgue')
{
  switch($objet){
  	case 'rea_adulte':$type = 2;break;
  	case 'rea_ped' :$type = 3;break;
  	case 'morgue':$type = 21;break;
	}
	/**
		mettre lits_sp pour les lits ouverts
		mettre lits_dispo pour les lits disponibles
		*/
	$requete = "SELECT SUM(lits_sp)AS lit_d,ville_nom,ville_lambertX, ville_lambertY
		FROM service,hopital,lits,ville,adresse
		WHERE service.type_ID = '$type'
		AND service.hop_ID = hopital.Hop_ID
		AND lits.service_ID = service.service_ID
		AND ville.ville_ID = adresse.ville_ID
		AND adresse.ad_ID = hopital.adresse_ID
		AND ville.departement_ID IN ".$inListe." 
		GROUP BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	
	while($rub = mysql_fetch_array($resultat))
	{
		$rayon = '10';
		if($rub[0]==0)
			$color=$rouge;
		else $color=$bleu;
		$d->cercle($rub['ville_lambertX']/1000,$rub['ville_lambertY']/1000,$rayon,$color, "",$rub['ville_nom'],"1");
		//$d->writetxt('1',0,$rub['ville_LambertX'],$rub['ville_LambertY'],0,0,$blanc,$rub[0]);
		$d->ecrire($rub['lit_d'],$rub['ville_lambertX']/1000,$rub['ville_lambertY']/1000,10,-8,0,"12",'L');
	}
}

/**
  *	 affichage des ville si�ges de SMUR et de SAMU
  */
else if($objet == 'samu' || $objet == 'samu_smur'){

	$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY,Hop_Samu
		FROM ville,hopital,adresse
		WHERE hopital.adresse_ID = adresse.ad_ID
		AND adresse.ville_ID = ville.ville_ID
		AND ville.departement_ID IN ".$inListe;
		
	$resultat = mysql_query($requete,$connexion);
	
	while($rub=mysql_fetch_array($resultat))
	{
	$rayon = '10';
	$couleur = $bleu;
	if($rub['Hop_Samu']=="o") {
		$rayon = '16';
		$couleur = $rouge;
	}
	$d->cercle($rub['ville_lambertX']/1000,$rub['ville_lambertY']/1000,$rayon,$couleur, "",Security::db2str($rub[ville_nom]),"1");
	} 	
}
/**
  *	 affichage des ville si�ges de SAU
  */
else if($objet == 'sau'){
	$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY,Hop_SAU
		FROM ville,hopital,adresse
		WHERE hopital.adresse_ID = adresse.ad_ID
		AND adresse.ville_ID = ville.ville_ID
		AND ville.departement_ID IN ".$inListe;
		
	$resultat = mysql_query($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		$rayon = '10';
		$couleur = $bleu;
		$d->cercle($rub['ville_lambertX']/1000,$rub['ville_lambertY']/1000,$rayon,$couleur, "",Security::db2str($rub[ville_nom]),"1");
	}
}

/**
  *	H�licopt�res
  */
else if($objet == 'helico'){

	$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY,ville.departement_ID,organisme.org_ID
	FROM ville, organisme,vecteur
	WHERE ville.ville_ID = organisme.ville_ID
	AND  vecteur.org_ID = organisme.org_ID
	
	AND Vec_Type = '9'
	
	AND ville.departement_ID IN ".$inListe
	;
	
	$resultat = mysql_query($requete,$connexion);
	
	while($rub=mysql_fetch_array($resultat))
	{
		$rayon = '10';
		$couleur = $bleu;
		$d->cercle($rub['ville_lambertX']/1000,$rub['ville_lambertY']/1000,$rayon,$couleur, "",Security::db2str($rub[ville_nom]),"1");
		/* pour le d�boggage */
		fwrite($fp,$rub['ville_nom'].',');
	}
}

/*
   isocercles
*/
if($_REQUEST['ville'])
{
	$requete = "SELECT ville_nom,ville_lambertX, ville_lambertY FROM ville WHERE ville_ID = '$_REQUEST[ville]'";
	$resultat = $resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	for($i=1;$i<500/$_GET['rayon'];$i++)
		$d->isocercle($rub['ville_lambertX']/1000,$rub['ville_lambertY']/1000,$_GET['rayon']*$i,"");
	$d->cercle($rub[1],$rub[2],10,$rouge, "",$rub[0],"1");
}

// �chelles
if($univers_w > 100)
	$d->echelle(50);
else
	$d->echelle(10);
	
/* Copyright Sagec */
	$copyright = "� SAGEC ALSACE";
	$size = 8;
	$angle=90;
	$d->pprint($copyright,10,300,$dx="",$dy="",$bleu,$size,'L',$angle);
	
/* pour le d�boggage */	
fclose($fp);

// Affichage de l'image
$d->affiche_image("Cartographie SAGEC ALSACE - ".$titre);
?>
