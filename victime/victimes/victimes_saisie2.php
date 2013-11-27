<?php
/**
  * victimes_saisie2.php
  *
  *	analyse l'identifiant de la victime. Si elle est connue, passe la main
  *	sinon crée un nouvel enregistrement dans la table victime
  */

$backPathToRoot = "../../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once("victime_utilitaires.php");
require_once($backPathToRoot."date.php");

/** Récupere l'identifiant de la victime */
$identifiant = Security::esc2Db(strtoupper($_REQUEST[identifiant]));
/** récupere la zone de saisie (exemple PMA Molsheim) */
$zds = $_REQUEST['zds'];
/** récupère le leiu de saisie (ex: tri) */
$localisation = $_REQUEST['localisation'];

/**
  * la gravité est fixée à indéterminé.
  * si le bracelet est de typa civic, l'identifiant est corrigé
  * et la gravité assortie à la couleur du bracelet par is_civic
  */
$gravite = 11;echo $identifiant;
$identifiant = is_civic($identifiant);

//echo $gravite;

/** La victime est-elle connue ? */
$requete = "SELECT victime_ID FROM victime WHERE no_ordre = '$identifiant' AND evenement_ID = '$_SESSION[evenement]'";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);

$victime = $rub['victime_ID'];echo $identifiant;

/**
  *	si la victime n'existe pas, on crée un dossier 
  * 	puis on récupère l'identifiant dans $victime
  */
if(!isset($victime))
{
	$date = uDateTime2MySql(time());
	$nom = '';
	$prenom = '';
	$ordre = $identifiant;
	$sexe ='';
	$age1 = '';
	$age2 = '';
	// $gravite;
	$localisation ='';
	$hopital = '';
	$service = '';
	$photo = '';
	$heure_creation = $date;
	$heure_maj = $date;
	$medicalisation = '';
	$vecteur = '';
	$signes = '';
	$lesions = '';
	$traitement = '';
	$deconta = '';
	$n = '';
	$b = '';
	$c = '';
	$evenement = $_SESSION['evenement'];
	$pays = 999;
	$naissance = '';
	$adresse1 = '';
	$adresse2 = '';
	$ville = '';
	$status = '';
	$organisme = $_SESSION['organisation'];
	$nip = 0;
	
					
	$requete = "INSERT INTO `pma`.`victime` (`victime_ID`, `nom`, `prenom`, `no_ordre`, `sexe`, `age1`, `age2`, `gravite`, `localisation_ID`, `Hop_ID`, `service_ID`,
	`photo`, `heure_creation`, `heure_maj`, `medicalisation_ID`, `vecteur_ID`, `signes`, `lesions`, `traitement`, `deconta`, `conta_N`, `conta_B`, `conta_C`, `evenement_ID`, 
	`pays_ID`, `naissance`, `adresse1`, `adresse2`, `ville`, `status_ID`, `org_createur_ID`, `nip`)
	VALUES (NULL,'$nom','$prenom','$ordre','$sexe','$age1','$age2','$gravite','$localisation','$hopital','$service','$photo','$heure_creation','$heure_maj','$medicalisation','$vecteur',
	'$signes','$lesions','$traitement','$deconta','$n','$b','$c','$evenement','$pays','$naissance','$adresse1','$adresse2','$ville','$status','$organisme','$nip') ";
	
	$resultat = ExecRequete($requete,$connexion);
	$victime = mysql_insert_id();
}
echo $victime;
?>