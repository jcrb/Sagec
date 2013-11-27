<?php
/**
*	classe badge: PDF_fichemed.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backtoPath="../pdf/";
$backPathToRoot = "../";

require_once("PDF_ImprimeSagec.php");
require_once("PDF_ListeVictimes.php");
require($backPathToRoot."hxp/victimes2xml.php");

/**
  *	classe fiche_medicale
  *
  */
class PDF_fiche_medicale extends PDF_fiche{

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
	function PDF_fiche_medicale($orientation='P')
	{
   	parent::FPDF($orientation, 'mm', 'A4');//FPDF($orientation='P', $unit='mm', $format='A4')
   	$this->titre = 'Titre';
   	$this->AliasNbPages();
		$this->SetCreator('SAGEC67');
		$this->SetAuthor('jcb');
		
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
	  *	now()
	  *	date heure courante au format jj/mm/aa hh:mm:ss
	  */
	function now()
	{
		return uDatetime2French(time());
	}
	
	function Header()
	{
    //Logo
    $this->Image('../images/Logo_SAGEC3.png',10,8,33);
    //Police Arial gras 15
    $this->SetFont('Arial','B',15);
    //Décalage à droite
    $this->Cell(80);
    //Titre
    $this->Cell(60,10,$this->titre,1,0,'C');
    $this->Cell(60);
    $this->Cell(60,10,$this->now(),1,0,'R');
    //Saut de ligne
    $this->Ln(20);
	}

//Pied de page
	function Footer()
	{
    //Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    //Police Arial italique 8
    $this->SetFont('Arial','I',8);
    //Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function imprime()
	{
		//$this->SetFont('Arial', '', 10);
		$this->SetXY($this->margeG,$this->margeS);
		$this->Cell(0,10,'Identifiant: ',0,0,"L");
	}
	/*
	function imprime_dossier($connexion, $no_dossier)
	{
		$requete = "SELECT * FROM victime WHERE no_ordre = '$no_dossier'";echo $requete;
		$resultat = ExecRequete($requete,$connexion);
		$rub = mysql_fetch_array($resultat);
		
		$x = $this->margeG;
		$y = $this->margeS;
		$lf = 8; // saut de ligne
		$tab1 = 40;
		$tab2 = 80;
		
		$this->Image('../photos/'.$rub[photo],160,30,33);
		
		//$this->SetFont('Arial', '', 10);
		$this->SetXY($x,$y);
		$this->Cell(0,10,'Identifiant: ',0,0,"L");
		$this->SetXY($x +$tab2,$y);
		$this->Cell(0,10,$rub['no_ordre'],0,0,"L");
		
		$y += $lf;
		$this->SetXY($x,$y);
		$this->Cell(0,10,'NIP: ',0,0,"L");
		$this->SetXY($x +$tab2,$y);
		$this->Cell(0,10,$rub['nip'],0,0,"L");
		
		$y += $lf;
		$this->SetXY($x,$y);
		$this->Cell(0,10,'Nom: ',0,0,"L");
		$this->SetXY($x +$tab2,$y);
		$this->Cell(0,10,$rub['nom'],0,0,"L");
		
		$y += $lf;
		$this->SetXY($x,$y);
		$this->Cell(0,10,'Prénom: ',0,0,"L");
		$this->SetXY($x +$tab2,$y);
		$this->Cell(0,10,$rub['prenom'],0,0,"L");
		
		$y += $lf;
		$this->SetXY($x,$y);
		$this->Cell(0,10,'Age: ',0,0,"L");
		$this->SetXY($x +$tab2,$y);
		$this->Cell(0,10,$rub['age1'].' ans',0,0,"L");
		
		
	}
	*/
}

/**
  *	code barre
  */
  function image_codebarre($code,$hauteur,$largeur)
  {
  		$codeEAN = new debora($code,$hauteur,$largeur);
		$codeEAN->makeImage();
		return $codeEAN;
  }
  
/**
  *	print_fiche($fiche,$rub)
  *	imprime le contenu de l'enregistrement $rub daans la page FPDF
  *	$fiche: objet FPDF
  *	$rub: le résultat d'une requête mysql
  */
function print_fiche($fiche,$rub)
{
	$x = $fiche->margeG;
	$y = $fiche->margeS;
	$lf = 8; // saut de ligne
	$tab1 = 40;
	$tab2 = 80;
	
	/** photo */
		if(strlen($rub[photo])>0)
			$fiche->Image('../photos/'.$rub[photo],160,30,33);
			
		/** code barre */
		$fiche->EAN13(160,10, $rub['no_ordre'],15,0.35);
		/*
		image_codebarre($rub['no_ordre'],90,150);
		$fiche->Image(image_codebarre('cb.png',90,150),160,30);
		*/
		
		//$fiche->SetFont('Arial', '', 10);
		$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Identifiant: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,$rub['no_ordre'],0,0,"L");
		
		$y += $lf;
		$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'NIP: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,$rub['nip'],0,0,"L");
		
		/** identité */
		$y += $lf;
		$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Nom: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,Security::db2str($rub['nom']),0,0,"L");
		
		$y += $lf;
		$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Prénom: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,Security::db2str($rub['prenom']),0,0,"L");
		
		$y += $lf;
		$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Age: ',0,0,"L");
		$x +=$tab2;
		$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,$rub['age1'].' ans',0,0,"L");
		
		/** date de création */
		$x+=$tab1;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'création: '.$rub['heure_creation'],0,0,"L");
		
		/** pays */
		$x = $fiche->margeG;$y += $lf;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Pays: ',0,0,"L");
		$fiche->SetXY($x +$tab1,$y);
		$fiche->Cell(0,10,$rub['pays_nom'],0,0,"L");
		
		/** coordonnées */
		$x = $fiche->margeG;$y += $lf;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Adresse: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,Security::db2str($rub['adresse1']),0,0,"L");
		
		$x = $fiche->margeG;$y += $lf;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Contacts: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,Security::db2str($rub['adresse2']),0,0,"L");
		
		/** lésions */
		$x = $fiche->margeG;$y += $lf;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Lésions: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->MultiCell(0,5,Security::db2str($rub['lesions']),0,"L");
		//MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
		
		/** constantes */
		$x = $fiche->margeG;$y = $fiche->getY()+2;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Constantes: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->MultiCell(0,5,Security::db2str($rub['constantes']),0,"L");
		
		/** traitements */
		$x = $fiche->margeG;$y = $fiche->getY()+2;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Traitements: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->MultiCell(0,5,Security::db2str($rub['traitement']),0,"L");

		/** commentaires */
		$x = $fiche->margeG;$y = $fiche->getY()+2;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Remarques: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->MultiCell(0,5,Security::db2str($rub['comment']),0,"L");
			
		/** hopital et service de destination */
		$x = $fiche->margeG;$y = $fiche->getY()+2;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Hôpital de destination: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,Security::db2str($rub['Hop_nom']),0,0,"L");
		
		$x = $fiche->margeG;$y += $lf;$fiche->SetXY($x,$y);
		$fiche->Cell(0,10,'Service de destination: ',0,0,"L");
		$fiche->SetXY($x +$tab2,$y);
		$fiche->Cell(0,10,Security::db2str($rub['service_nom']),0,0,"L");
}

/**
  *
  *	$victime n°ordre de la victime
  */
function imprime_fiche_individuelle($connexion,$victime)
{
	$fiche = new PDF_fiche_medicale();
	$fiche->setTitre('Fiche individuelle');
	$fiche->AddPage();
	$fiche->SetFont("Arial","",12);
	$fiche->margeS = 30;
	//$fiche->imprime_dossier($connexion, '111');
	
	$requete = "SELECT victime.*,Hop_nom, service_nom,pays_nom
					FROM victime LEFT OUTER JOIN (hopital,service) ON (victime.Hop_ID = hopital.Hop_ID AND victime.service_ID = service.service_ID),
					pays
					WHERE no_ordre = '$victime' 
					AND victime.pays_ID = pays.pays_ID
					";
		$resultat = ExecRequete($requete,$connexion);
		$rub = mysql_fetch_array($resultat);
		
		print_fiche($fiche,$rub);
		
	$fiche->Output();
}

/**
  *	affiche la liste des victimes
  *	@TOTO limiter la liste aux victimes de l'évènement courant
  *	@TOTO ajouter des modificateur pour imprimer des listes plus ou moins détaillées
  *	@TOTO heure de maj
  */
function imprime_liste($connexion)
{

	$liste = new PDF_liste_victimes('L',$connexion);// landscape, P pour portrait 
	$liste->imprime();
	
}

function imprime_tout($connexion)
{
	$fiche = new PDF_fiche_medicale();
	$fiche->setTitre('Fiche individuelle');
	
	$requete = "SELECT victime.*,Hop_nom, service_nom,pays_nom
					FROM victime LEFT OUTER JOIN (hopital,service) ON (victime.Hop_ID = hopital.Hop_ID AND victime.service_ID = service.service_ID),
					pays
					WHERE no_ordre > 0 
					AND victime.pays_ID = pays.pays_ID
					";
		$resultat = ExecRequete($requete,$connexion);
		while($rub = mysql_fetch_array($resultat))
		{
			$fiche->AddPage();
			$fiche->SetFont("Arial","",12);
			$fiche->margeS = 30;
			print_fiche($fiche,$rub);
		}
		$fiche->Output();
}

function create_xml()
{
	$msg = get_victimes();
	$fp = fopen("victimes.xml", 'w');
	fputs($fp, $msg);
	fclose($fp);
        
	echo 'Export XML effectue !<br><a href="victimes.xml">Voir le fichier</a>';
}

$imp = $_REQUEST['imp'];
$no_dossier = $_REQUEST['dossier'];
if($no_dossier > 0)
	imprime_fiche_individuelle($connexion, $no_dossier);
	
switch($imp)
{
	case 'liste':imprime_liste($connexion);break;
	case 'dossier':imprime_fiche_individuelle($connexion, $no_dossier);break;
	case 'cedossier':imprime_fiche_individuelle($connexion, $no_dossier);break;
	case 'all':imprime_tout($connexion);break;
	case 'xml':create_xml();
}




