<?php
require_once('../pdf/fpdf.php');
/*
class pdfEAN extends FPDF{
	function  pdfEAN13($orientation)
	{
		parent::FPDF($orientation, 'mm', 'A4');
	}
}
*/
class FPDF_cb extends FPDF{

	var $_Line_Height;            // hauteur d'une ligne
	var $_Padding;                // Padding
	var $_Metric_Doc;            // métriqye du document
	var $_COUNTX;                // position X courante
	var $_COUNTY;                // position Y courante
	var $_titre;						// titre de la page    
   var $epaisseur_trait = 2; 		//mm
	var $couleur_trait;
	var $margeG = 10;					// marge de gauche
	var $margeS = 40;
	
    /** constructeur */
	function FPDF_cb($orientation='P')
	{
   	parent::FPDF($orientation, 'mm', 'A4');//FPDF($orientation='P', $unit='mm', $format='A4')
   	$this->titre = 'Titre';
   	$this->AliasNbPages();
		$this->SetCreator('SAGEC67');
		$this->SetAuthor('jcb');
		
	}
}
?> 