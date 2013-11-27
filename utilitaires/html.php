<?php
// utilitaires/HTML.php
// fonction produisant des balises HTML
// source Rigaux pp 116
if(!isset($FichierHTML))
{
	$FichierHTML = 1;
	
	// fonctions produisant des conteneurs HTML
	// exemple:
	// Ancre("http:/www.mysql.com",Image("mysql.gif"));
	
	//===================================================================================
	// Ancre		Insère un lien HTML
	//				$url		adresse du lien
	//				$libelle	intitulé qui sera affiché
	//				$classe		paramètres de présentation supplémentaires		
	//===================================================================================
	function Ancre($url,$libelle,$classe = -1)
	{
		$optionClasse = "";
		if($classe != -1)
			$optionClasse = "CLASS='$classe'";
		return "<A HREF='$url'"."$optionClasse>$libelle</A>\n";
	}
	//===================================================================================
	// Image		Affiche l'image contenue dans un fichier
	//				$url	adresse de l'image
	//				$largeur largeur de l'image. Par défaut = -1 => utilise la taille originale
	//				$hauteur idem pour la hauteur
	//				$bordure 0 = pas de bordure	
	//===================================================================================
	function Image($url,$largeur=-1,$hauteur=-1,$bordure=0)
	{
		$attrLargeur = "";
		$attrHauteur = "";
		if($largeur != -1)
			$attrLargeur = "WIDTH  = '$largeur'";
		if($hauteur != -1)
			$attrHauteur = "HEIGTH = '$hauteur'";
		return "<IMG SRC='$url'".$attrLargeur.$attrHauteur."BORDER='$bordure'>\n";
	}
	
	//Retourne la date courante
	function ma_date($langue="french")
	{
		setlocale(LC_TIME,$langue);
		$dateFR = strFTime("%A %d %B %Y");
		return $dateFR;
	}
	// Retourne l'heure courante
	function heure()
	{
		$heure = date("H:i");
		return $heure;
	}

}



?>