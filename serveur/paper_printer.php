<?php
/**
  *	paper_printer.php
  */
//session_start();
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require_once($backPathToRoot.'pdf/fpdf.php');

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
		$this->calcul_coef();
	}
	
	function GetCheckDigit($barcode)
	{
    //Compute the check digit
    $sum=0;
    for($i=1;$i<=11;$i+=2)
        $sum+=3*$barcode{$i};
    for($i=0;$i<=10;$i+=2)
        $sum+=$barcode{$i};
    $r=$sum%10;
    if($r>0)
        $r=10-$r;
    return $r;
	}

	function TestCheckDigit($barcode)
	{
    //Test validity of check digit
    $sum=0;
    for($i=1;$i<=11;$i+=2)
        $sum+=3*$barcode{$i};
    for($i=0;$i<=10;$i+=2)
        $sum+=$barcode{$i};
    return ($sum+$barcode{12})%10==0;
	}
	
	function EAN13($x, $y, $barcode, $h=16, $w=0.35)
	{
    	$this->Barcode($x, $y, $barcode, $h, $w, 13);
	}

	function Barcode($x, $y, $barcode, $h, $w, $len)
	{
    //Padding
    $barcode=str_pad($barcode, $len-1, '0', STR_PAD_LEFT);
    if($len==12)
        $barcode='0'.$barcode;
    //Add or control the check digit
    if(strlen($barcode)==12)
        $barcode.=$this->GetCheckDigit($barcode);
    elseif(!$this->TestCheckDigit($barcode))
        $this->Error('Incorrect check digit');
    //Convert digits to bars
    $codes=array(
        'A'=>array(
            '0'=>'0001101', '1'=>'0011001', '2'=>'0010011', '3'=>'0111101', '4'=>'0100011',
            '5'=>'0110001', '6'=>'0101111', '7'=>'0111011', '8'=>'0110111', '9'=>'0001011'),
        'B'=>array(
            '0'=>'0100111', '1'=>'0110011', '2'=>'0011011', '3'=>'0100001', '4'=>'0011101',
            '5'=>'0111001', '6'=>'0000101', '7'=>'0010001', '8'=>'0001001', '9'=>'0010111'),
        'C'=>array(
            '0'=>'1110010', '1'=>'1100110', '2'=>'1101100', '3'=>'1000010', '4'=>'1011100',
            '5'=>'1001110', '6'=>'1010000', '7'=>'1000100', '8'=>'1001000', '9'=>'1110100')
        );
    $parities=array(
        '0'=>array('A', 'A', 'A', 'A', 'A', 'A'),
        '1'=>array('A', 'A', 'B', 'A', 'B', 'B'),
        '2'=>array('A', 'A', 'B', 'B', 'A', 'B'),
        '3'=>array('A', 'A', 'B', 'B', 'B', 'A'),
        '4'=>array('A', 'B', 'A', 'A', 'B', 'B'),
        '5'=>array('A', 'B', 'B', 'A', 'A', 'B'),
        '6'=>array('A', 'B', 'B', 'B', 'A', 'A'),
        '7'=>array('A', 'B', 'A', 'B', 'A', 'B'),
        '8'=>array('A', 'B', 'A', 'B', 'B', 'A'),
        '9'=>array('A', 'B', 'B', 'A', 'B', 'A')
        );
    $code='101';
    $p=$parities[$barcode{0}];
    for($i=1;$i<=6;$i++)
        $code.=$codes[$p[$i-1]][$barcode{$i}];
    $code.='01010';
    for($i=7;$i<=12;$i++)
        $code.=$codes['C'][$barcode{$i}];
    $code.='101';
    //Draw bars
    $this->SetFillColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $allongement= 0;
    for($i=0;$i<strlen($code);$i++)
    {
    	if ($i < 3 || ($i >= 46 && $i < 49) || $i >= 92) $allongement = 2;else $allongement = 0;
        if($code[$i]=='1')
            $this->Rect($x+$i*$w, $y, $w, $h+$allongement, 'F');
    }
    //Print text under barcode
    $this->SetFont('Arial', '', 10);
    //$this->Text($x, $y+$h+11/$this->k, substr($barcode, -$len));
    $this->Text($x-2.0, $y+$h+8/$this->k,$barcode[0]);
    $this->Text($x+2.0, $y+$h+8/$this->k, substr($barcode, 1,6));
    $this->Text($x+18.0, $y+$h+8/$this->k, substr($barcode, 7,13));
	}
	
	/**
	  *	imprime un titre en haut de page
	  *	utilisé par header
	  */
	function setTitre($titre)
	{
		$this->titre = $titre;
	}
	
	/**
   *	fixe la couleur du trait
   */
	function setColor($color)
	{
		switch($color)
		{
			case rouge;$this->SetDrawColor('255','0','0');break;
			case vert;$this->SetDrawColor('51','204','0');break;
			case jaune;$this->SetDrawColor('255','255','0');break;
			case ocre;$this->SetDrawColor('255','204','0');break;
			case orange;$this->SetDrawColor('255','153','0');break;
			case bleu;$this->SetDrawColor('51','51','255');break;
			case mauve;$this->SetDrawColor('204','204','255');break;
			case gris;$this->SetDrawColor('192','192','192');break;
			case noir;$this->SetDrawColor('0','0','0');break;
			case rose;$this->SetDrawColor('255','153','255');break;
			default:$this->SetDrawColor('255','255','255');
		}
	}
	
		/**
	*Calcul des coefficients de mise à l'échelle. Ces coefficients permettent de transformer un point en coordonnées
	*univers, en coordonnées écran et réciproquement.
	*/
	function calcul_coef()
	{
		$this->U_droit = 210;
		$this->U_gauche = 0;
		$this->U_bas = 297;
		$this->U_haut = 0;
		
		$this->C_droit = 195;
		$this->C_gauche = 10;
		$this->C_bas = 277;
		$this->C_haut = 10;
		
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

	function imprime()
	{
		//$this->SetFont('Arial', '', 10);
		$this->SetXY($this->margeG,$this->margeS);
		$this->Cell(0,10,'Identifiant: ',0,0,"L");
	}
}

/**
  *	get_cle()
  *	calcule la clé du code
  */
function get_cle($code)
{
	for($i=strlen($code)-1;$i >0; $i-=2)
	{
		(int)$a = 3 * (int)$code[$i];
		(int)$b = (int)$code[$i-1];
		$mot = (int)$mot + (int)$a + (int)$b;
	}
	$clef = 0;
	while(($mot+$clef) % 10 != 0)
	{
		$clef++;
	}
	return $clef;
}


	$pays = $_REQUEST['pays'];
	$deb =  $_REQUEST['deb'];
	$fin =  $_REQUEST['fin'];
	$org =  $_REQUEST['org'];
	
	$pdf=new FPDF_cb('P');
	$pdf->SetMargins(0,0);
	$pdf->AddPage();
	
	$nb_lignes = 32;
	$nb_col = 3;
	$larg_ligne = 70;
	$haut_ligne =37;
	$marge_g = 20;
	$marge_sup = 10;
	
	$n = $deb;//compteur 

	for($i=0; $i < $nb_lignes; $i++)
	{
		$ey = $haut_ligne * $i + $i;
		for($j = 0; $j < $nb_col; $j++)
		{
			$ex =  $larg_ligne * $j;
			$code = $pays.$org.substr('00000'.$n,-5,5);
			$code .= get_cle($code);
			$pdf->EAN13($ex+$marge_g, $ey+$marge_sup, $code);
			//echo $code.'<br>';
			$n++;
		}
	}
	
	$pdf->Output();
?>