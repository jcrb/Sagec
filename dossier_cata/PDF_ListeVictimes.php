<?php
/**
  *	classe PDF_ListeVictimes.php
  *	imprime la liste des victimes
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backtoPath="../pdf/";
$backPathToRoot = "../";
require_once($backPathToRoot."dbConnection.php");

require_once("PDF_ImprimeSagec.php");

/**
  *	class liste_victimes
  *
  */
class PDF_liste_victimes extends PDF_fiche{

	function PDF_liste_victimes($orientation='P',$connexion)
	{
		parent::PDF_fiche($orientation);
		$this->connexion = $connexion;
	}
	
	function Header()
	{
		// Restaure les dimensions à chaque changement de page 
		parent::Header();
		/*
		$this->x = $this->margeG;
		$this->y = $this->margeS;
		$this->lf = 8; // saut de ligne
		$this->SetXY($this->x,$this->y);
		*/
		//$this->Cell(0,10,'Identifiant: ',0,0,"L");
		//$this->Cell(100,10,'marge sup:'.$this->y,0,0,"R");
	}
	
	function Footer()
	{
		parent::Footer();
	}
	
	function imprime()
	{
		$this->setTitre('Liste des victimes');
		$this->AddPage();
		$this->SetFont("Arial","",10);
		$this->margeS = 30;
	
		$this->x = $this->margeG;
		$this->y = $this->margeS;
		$this->lf = 8; // saut de ligne
		$this->SetXY($this->x,$this->y);
		
		/** recherche le nom le plus long */
		$requete = "SELECT nom FROM victime WHERE CHAR_LENGTH(nom) = (SELECT MAX(CHAR_LENGTH(nom)) FROM victime) ";
		$resultat = ExecRequete($requete,$this->connexion);
		$rep = mysql_fetch_array($resultat);
		$max_name = $rep['nom'];

		/** recherche le prenom le plus long */
		$requete = "SELECT prenom FROM victime WHERE CHAR_LENGTH(prenom) = (SELECT MAX(CHAR_LENGTH(prenom)) FROM victime) ";
		$resultat = ExecRequete($requete,$this->connexion);
		$rep = mysql_fetch_array($resultat);
		$max_prenom = $rep['prenom'];
	
		$requete = "SELECT victime.*,gravite_nom 
					FROM victime,gravite 
					WHERE victime.gravite = gravite.gravite_ID 
					ORDER BY nom";
		$resultat = ExecRequete($requete,$this->connexion);
		
		while($rub = mysql_fetch_array($resultat))
		{
			$i++;

			$this->x = $this->margeG;$this->y += $this->lf;$this->SetXY($this->x,$this->y);
			$this->Cell(5,10,$i,0,0,"R");
		
			$this->x += 6;
			$this->SetXY($this->x,$this->y);
			$this->Cell(30,10,$rub['no_ordre'],0,0,"R");
		
			$this->x += 35;
			$this->SetXY($this->x,$this->y);
			$this->Cell(30,10,$rub['nom'],0,0,"L");
		
			$this->x += $this->GetStringWidth($max_name)+ 5;
			$this->SetXY($this->x,$this->y);
			$this->Cell(30,10,Security::db2str($rub['prenom']),0,0,"L");
		
			$this->x += $this->GetStringWidth($max_prenom)+ 5;
			$this->SetXY($this->x,$this->y);
			if($rub['sexe']==1)$sexe='H';else $sexe='F';
			$this->Cell(5,10,$sexe.' '.$rub['age1'],0,0,"R");
		
			$this->x += 12;
			$this->SetXY($this->x,$this->y);
			$this->Cell(5,10,$rub['gravite_nom'],0,0,"R");
		}
	$this->Output();
	}
}

?>