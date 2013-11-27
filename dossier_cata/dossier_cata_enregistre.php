<?php
/**
  *	dossier_cata_enregistre.php
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."date.php");

/**
  * récupération sécurisée des données de la page saisie
  */

		//print_r($_REQUEST);
		$identifiant = Security::str2db($_REQUEST['identifiant']);

/**
  * récupération de la photographie
  */
$fichier= $_FILES['photo_victime']['name'];
$taille= $_FILES['photo_victime']['size'];
$tmp= $_FILES['photo_victime']['tmp_name'];
$type= $_FILES['photo_victime']['type'];
$erreur= $_FILES['photo_victime']['error'];
/*
echo"Nom originel => $fichier <br />";
echo"Taille => $taille <br />";
echo"Adresse temporaire sur le serveur => $tmp <br />";
echo"Type de fichier => $type <br />";
echo"Code erreur => $erreur. <br />";
*/
if($erreur == 0){
	$destination = $backPathToRoot."photos/".$identifiant.".jpg";
	//echo"nouveau nom => $destination. <br />";
	move_uploaded_file($tmp, $destination);
	chmod ($destination,07777);
	$photo = $destination;
}
else
{
	$photo = $_REQUEST['photo_victime'];
}

//echo"nouveau nom => $destination. <br />";

/**
  *	récupération des variables
  */
  
$nom = Security::str2db(ucfirst($_REQUEST['nom']));
$prenom = Security::str2db(ucfirst($_REQUEST['prenom']));
$naissance = Security::str2db($_REQUEST['naissance']);
$age1 = Security::str2db($_REQUEST['age1']);
$age2 = Security::str2db($_REQUEST['age2']);
$sexe = Security::str2db($_REQUEST['sexe']);
$gravite = Security::str2db($_REQUEST['gravite']);
$adresse = trim(Security::str2db($_REQUEST['adresse']));
$contact = trim(Security::str2db($_REQUEST['contact']));
/**
  * NE PAS METTRE SECURITY::SRT2DB
  */
$lesions = trim($_REQUEST['lesions']);
$traitement = trim($_REQUEST['traitements']);
$constantes = $_REQUEST['constantes'];

$hopital = Security::str2db($_REQUEST['ID_hopital']);
$service = Security::str2db($_REQUEST['the_service']);
$nationalite  = Security::str2db($_REQUEST['nationalite']);
$localisation  = Security::str2db($_REQUEST['localisation']);
$poste  = Security::str2db($_REQUEST['status_type']);
$victime_ID  = Security::str2db($_REQUEST['victime_ID']);
$ardoise = Security::str2db(strtoupper($_REQUEST['ardoise']));
$now = uDateTime2MySql(time());
$vecteur = Security::str2db($_REQUEST['vecteur_engage_ID']);
$nip = Security::str2db($_REQUEST['nip']);
$comment = Security::str2db($_REQUEST['comment']);
$dateTime = uDateTime2MySql(time());

//print_r($_REQUEST);


/**
  * 	Analyse du champ ardoise
  *	scinde la phrase grâce aux virgules et espacements
  *	ce qui inclus les " ", \r, \t, \n et \f
  */

$mot = preg_split("/[\s,]+/", $ardoise);
//print_r($mot);

	for($i=0;$i < sizeof($mot); $i++)
	{
		if(strlen($mot[$i])==13)	// c'est un code barre 
		/**
		 *	Si longeur de mot = exactement 13
		 * alors c'est in code barre
		 */
		{

			switch ($mot[$i][0])
			{
				/**
				 *	Commence par 1 => c'est un code traitement
				 */
				case 1:
				$ttt =(int)substr($mot[$i], 9,-2);   
				$requete = "SELECT special_nom FROM med_specialite WHERE special_ID = '$ttt'";
				$resultat = ExecRequete($requete,$connexion);
				$rep = mysql_fetch_array($resultat);
				$traitement .= '\n['.uDate2Frenchdatetime($dateTime).'] '.$rep['special_nom'];
				break;
				/**
				 *	Commence par 2 => c'est un code lésion
				 */
				case 2:
				$blessure = substr($mot[$i],-7,6);//echo $blessure;
				$requete = "SELECT FR_OMS FROM cim10_libelle WHERE SID = '$blessure'";
				$resultat = ExecRequete($requete,$connexion);
				$rep = mysql_fetch_array($resultat);
				$lesions .= '\n['.$blessure.'] '.$rep['FR_OMS'];
				break;
			}
		} 
		else 
		/**
		 *	Si ce n'est pas un code barre
		 *	on continue l'analyse
		 */
		{
				/** Saturation en O2 */
				$expression='/([0-9][0-9])%/';
				
				/** Saturation en O2 */
				if(preg_match('/([0-9][0-9])%/',$mot[$i],$result)){
					$sat = substr($result[0],0,2);
					$constantes .= "\nSaturation: ".$sat."%";
				}
				
				/** pression arterielle */
				else if(preg_match('/([0-9]+)\/([0-9]+)/',$mot[$i],$result)){
					$pa = explode("/",$result[0]);
					$pas = $pa[0];
					$pad =  $pa[1];
					//$constantes .= "\nPA systolique: ".$pas." mmHg";
					//$constantes .= "\nPA diastolique: ".$pad." mmHg";
					$constantes .= "\nPA: ".$pas."/".$pad." mmHg";
				}
				
				/** glycémie */
				else if(preg_match('/[0-9][,\.][0-9]+/',$mot[$i],$result)){
					$gly = $result[0];
					$constantes .= "\nglycémie: ".$result[0]." g/l";
				}
				
				/** frequence cardiaque */
				else if(preg_match('/[f,F][0-9][0-9]?[0-9]/',$mot[$i],$result)){
					$fc = substr($result[0],1);
					$constantes .= "\nFc: ".$fc." bpm";
				}
				
				/** frequence respiratoire */
				else if(preg_match('/[r,R][0-9][0-9]?[0-9]/',$mot[$i],$result)){
					$fc = substr($result[0],1);
					$constantes .= "\nFr: ".$fc." cycles/mn";
				}
				
				/** température */
				else if(preg_match('/[0-9][0-9]°[0-9]?/',$mot[$i],$result)){
					$temp = str_replace('°','.',$result[0]);
					$constantes .= "\ntemp: ".$temp." °C";
				}
				/** Glasgow */
				else if(preg_match('/[g,G][0-9][0-9]?/',$mot[$i],$result)){
					$glasgow = substr($result[0],1);
					$constantes .= "\nGCS: ".$glasgow;
				}
				
				/** O2 */
				else if(preg_match('/[0-9][0-9]?[l,L]/',$mot[$i],$result)){
					$gly = substr($result[0],0,-1);
					$traitement .= "\nO2: ".$gly." L/mn";
				}
				
				/** IOT x */
				else if(preg_match('/IOT[0-9]?/',$mot[$i],$result)){
					$calibre = substr($result[0],-1);//echo $result[0];
					$traitement .= "\n[DKMD001]Intubation oro-trachéale ";
					if($calibre !='T')
						$traitement .= "(calibre n°".$calibre.")";
					
				}
				/** TC avec PCI 
				  *	l'expression \b...\b permet d'identifier exactement la chaine comprise
				  *	entre les 2 marqueurs
				  */
				else if(preg_match('/\btcp\b/i',$mot[$i],$result)){
					$lesions .= "\n[...] Traumatisme crânien avec perte de connaissance initiale";
				}
				
				/** TC sans PC*/
				else if(preg_match('/\bTC\b/',$mot[$i],$result)){
					$lesions .= "\n[...] Traumatisme crânien";
				}
				
				/** Gravité UA*/
				else if(preg_match('/\bUA\b/i',$mot[$i],$result)){
					$_POST[gravite] = "1";
				}
				/** Gravité UR*/
				else if(preg_match('/\bUR\b/i',$mot[$i],$result)){
					$_POST[gravite] = "2";
				}
				/** Gravité DCD*/
				else if(preg_match('/\bDCD\b/i',$mot[$i],$result)){
					$_POST[gravite] = "5";
				}
				/** homme age*/
				else if(preg_match('/\b[h,M][0-9]?[0-9]?[0-9]/i',$mot[$i],$result)){
					$_POST[sexe] = "1";
					$age1=substr($result[0],1);0;
					$age2 =0 ;
				}
				/** femme age*/
				else if(preg_match('/\b[x][0-9]?[0-9]?[0-9]/i',$mot[$i],$result)){
					$_POST[sexe] = "2";
					$age1=substr($result[0],1);
					$age2 =0 ;
				}
				/** douleur*/
				else if(preg_match('/\b[e][0-9]?[0-9]/i',$mot[$i],$result)){
					$_POST[eva] = "2";
					$eva=substr($result[0],1);
					$constantes .= "\nEVA: ".$eva;
				}
		}
	}
$lesions = Security::str2db($lesions);
$constantes = Security::str2db(trim($constantes));
$traitement = Security::str2db($traitement);

/**
*		Enregistrement des nouvelles constantes
*/
if($fc){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','1','$fc','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
if($pas){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','2','$pas','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($pad){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','3','$pad','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($fr){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','4','$fr','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($sat){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','5','$sat','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($etco2){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','6','$etco2','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($diurese){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','7','$diurese','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($gly){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','8','$gly','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($gcs){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','9','$gcs','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($temp){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victime_ID','$dateTime','10','$temp','$qui')";
		$resultat = ExecRequete($requete,$connexion);}


if($_POST['nationalite']=='0') $_POST['nationalite'] = 999;
if($_POST['gravite']=='') $_POST['gravite'] = 11;
/**
  *	Mise à jour du dossier victime
  */
$requete = "UPDATE victime
				SET 
					no_ordre = '$identifiant',
					nom = '$nom',
					prenom = '$prenom',
					naissance = '$naissance',
					age1 = '$age1',
					age2 = '$age2',
					sexe = '$sexe',
					gravite = '$gravite',
					adresse1 = '$adresse',
					adresse2 = '$contact',
					lesions = '$lesions',
					traitement = '$traitement',
					Hop_ID = '$hopital',
					service_ID = '$service',
					pays_ID = '$nationalite',
					photo = '$photo',
					heure_maj = '$now',
					vecteur_ID = '$vecteur',
					localisation_ID = '$localisation',
					status_ID = '$poste',
					nip = '$nip',
					comment = '$comment',
					constantes = '$constantes'
				WHERE victime_ID = '$victime_ID'";
				ExecRequete($requete,$connexion);
/**
  *	mise à jour de victime_gravite
  */
  $requete="INSERT INTO victime_gravite(victime_ID,gravite_ID,localisation_ID,heure,status_ID)
  				VALUES ('$victime_ID','$gravite','$localisation','$now','$poste')";
  				ExecRequete($requete,$connexion);
  
//echo $requete;
header("Location:dossier_cata_saisie.php?identifiant=$identifiant");
?>