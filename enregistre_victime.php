<?php
//----------------------------------------- SAGEC --------------------------------------------------------
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//---------------------------------------------------------------------------------------------
//	programme: 		enregistre_victime.php
//	date de création: 	18/08/2003
//	auteur:			jcb
//	version:			1.3
//	maj le:			13/11/2004
//---------------------------------------------------------------------------------------------
/**
* enregistre_victime.php
* Crée ou met à jour un enregistrement de la table victime
* @author Jean-Claude Bartier
* @copyright 2003-2005 (Jean-Claude Bartier)
* @package SAGEC67
*/
session_start();
$backPathToRoot = ""; 
include_once("dbConnection.php");
include_once("login/init_security.php");
include_once("date.php");

/**
  *	met à jour la table victime_gravite
  * 	uniquement si les paramètres ont changés depuis le dernier enregistrement
  */
function enregistre_gravite($connexion,$victime_ID,$gravite,$localisation_ID,$heure,$status)
{
	$requete = "SELECT * FROM victime_gravite WHERE victime_ID = '$victime_ID' ORDER BY heure LIMIT 1";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	if($gravite != $rep['gravite_ID'] || $localisation_ID != $rep['localisation_ID'] || $status != $rep['status_ID'])
	{
		$requete="INSERT INTO victime_gravite VALUES (
		'$victime_ID',
		'$gravite',
		'$localisation_ID',
		'$heure',
		'$status',
		'',
		''
		)";
		$resultat = ExecRequete($requete,$connexion);
		//print($requete);
	}
}

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
	$destination = "photos/".$_POST[no_identification].".jpg";
	//echo"nouveau nom => $destination. <br />";
	move_uploaded_file($tmp, $destination);
	chmod ($destination,07777);
}
//echo"nouveau nom => $destination. <br />";

$victimeID = $_REQUEST['victimeID'];
// mémorise dans une variable de session la localisation du poste de saisie 
$_SESSION['localisation_poste'] = $_REQUEST['localisation_type'];
$_SESSION['poste_saisie'] = $_REQUEST['status_type'];

$nom = Security::esc2Db(strtoupper($_REQUEST[nom]));
$prenom = Security::esc2Db(strtoupper($_REQUEST[prenom]));
$no_identification = Security::esc2Db(strtoupper($_REQUEST[no_identification]));
$naissance = Security::esc2Db(strtoupper($_REQUEST[naissance]));
$adresse1 = Security::esc2Db(strtoupper($_REQUEST[adresse1]));
$adresse2 = Security::esc2Db(strtoupper($_REQUEST[adresse2]));
$ville = Security::esc2Db(strtoupper($_REQUEST[ville]));
$signes = Security::esc2Db(strtoupper($_REQUEST[signes]));
$lesions = Security::esc2Db(strtoupper($_REQUEST[lesions]));
$traitement = Security::esc2Db(strtoupper($_REQUEST[traitement]));
$age1 = Security::esc2Db(strtoupper($_REQUEST[age1]));
$age2 = Security::esc2Db(strtoupper($_REQUEST[age2]));

$pas = Security::esc2Db(strtoupper($_REQUEST[pas]));
$pad = Security::esc2Db(strtoupper($_REQUEST[pad]));
$fc = Security::esc2Db(strtoupper($_REQUEST[fc]));
$fr = Security::esc2Db(strtoupper($_REQUEST[fr]));
$gcs = Security::esc2Db(strtoupper($_REQUEST[gcs]));
$sat = Security::esc2Db(strtoupper($_REQUEST[sat]));
//$dateTime = mysqlDateTime2u($_REQUEST['heure_courante']);
$dateTime = uDateTime2MySql(time());
$qui = $_SESSION['member_ID'];


/**
  *	Analyse de l'ardoise
  */
$ardoise="";
$mot = Array();
$result = Array();

$ardoise = Security::esc2Db(strtoupper($_REQUEST[ardoise]));
	
// scinde la phrase grâce aux virgules et espacements
// ce qui inclus les " ", \r, \t, \n et \f
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
					$lesions .= "\nSaturation: ".$sat."%";
				}
				
				/** pression arterielle */
				else if(preg_match('/([0-9]+)\/([0-9]+)/',$mot[$i],$result)){
					$pa = explode("/",$result[0]);
					$pas = $pa[0];
					$pad =  $pa[1];
					$lesions .= "\nPA systolique: ".$pas." mmHg";
					$lesions .= "\nPA diastolique: ".$pad." mmHg";
				}
				
				/** glycémie */
				else if(preg_match('/[0-9][,\.][0-9]+/',$mot[$i],$result)){
					$gly = $result[0];
					$lesions .= "\nglycémie: ".$result[0]." g/l";
				}
				
				/** frequence cardiaque */
				else if(preg_match('/[f,F][0-9][0-9]?[0-9]/',$mot[$i],$result)){
					$fc = substr($result[0],1);
					$lesions .= "\nFc: ".$fc." bpm";
				}
				
				/** frequence respiratoire */
				else if(preg_match('/[r,R][0-9][0-9]?[0-9]/',$mot[$i],$result)){
					$fc = substr($result[0],1);
					$lesions .= "\nFr: ".$fc." cycles/mn";
				}
				
				/** température */
				else if(preg_match('/[0-9][0-9]°[0-9]?/',$mot[$i],$result)){
					$temp = str_replace('°','.',$result[0]);
					$lesions .= "\ntemp: ".$temp." °C";
				}
				/** Glasgow */
				else if(preg_match('/[g,G][0-9][0-9]?/',$mot[$i],$result)){
					$glasgow = substr($result[0],1);
					$lesions .= "\nGCS: ".$glasgow;
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
					$_POST[sexe] = "2";
					$eva=substr($result[0],1);
					$lesions .= "\nEVA: ".$eva;
				}
		}
	}


if($fc){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','1','$fc','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
if($pas){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','2','$pas','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($pad){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','3','$pad','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($fr){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','4','$fr','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($sat){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','5','$sat','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($etco2){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','6','$etco2','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($diurese){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','7','$diurese','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($gly){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','8','$gly','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($gcs){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','9','$gcs','$qui')";
		$resultat = ExecRequete($requete,$connexion);}
	if($temp){
		$requete = "INSERT INTO dm_constantes2 VALUES('$victimeID','$dateTime','10','$temp','$qui')";
		$resultat = ExecRequete($requete,$connexion);}


if($_POST['nationalite']=='0') $_POST['nationalite'] = 999;
if($_POST['gravite']=='') $_POST['gravite'] = 11;

	$requete="UPDATE victime SET 	nom = '$nom',
					prenom = '$prenom',
					no_ordre = '$no_identification',
					sexe = '$_POST[sexe]',
					age1 = '$age1',
					age2 = '$age2',
					gravite = '$_POST[gravite]',
					localisation_ID ='$_POST[localisation_type]',
					Hop_ID ='$_POST[ID_hopital]',
					service_ID ='$_POST[the_service]',
					heure_maj = '$_POST[heure_courante]',
					medicalisation_ID = '$_POST[devenir]',
					vecteur_ID = '$_POST[vecteur_disponible_ID]',
					signes = '$signes',
					lesions = '$lesions',
					traitement = '$traitement',
					conta_N = '$_POST[N]',
					conta_B = '$_POST[B]',
					conta_C = '$_POST[C]',
					evenement_ID = '$_SESSION[evenement]',
					pays_ID = '$_POST[nationalite]',
					naissance = '$naissance',
					adresse1 = '$adresse1',
					adresse2 = '$adresse2',
					ville = '$ville',
					status_ID = '$_POST[status_type]'
					";
					if($destination)
						$requete.=",photo = '$destination' ";
				$requete.=" WHERE no_ordre = '$_POST[victime]'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
enregistre_gravite($connexion,$_POST['victimes'],$_POST['gravite'],$_POST['localisation_type'],$_POST['heure_courante'],$_POST['status_type']);

// modifier l'état du vecteur si un vecteur est affecté à la victime
if($_POST['vecteur_disponible_ID'])
{
	$requete = "UPDATE vecteur SET Vec_Etat = '5' WHERE Vec_ID = '$_POST[vecteur_disponible_ID]'";
	$resultat = ExecRequete($requete,$connexion);
}
//print($requete);
header("Location:victimes_saisie.php?identifiant=$_POST[no_identification]");
?>
