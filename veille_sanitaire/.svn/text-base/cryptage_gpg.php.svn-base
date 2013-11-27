<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		cryptage_gpg.php
//	date de création: 	07/05/2005
//	auteur:			jcb
//	description:		Crypte un fichier
//	version:			1.0
//	maj le:			07/05/2005
//
/**
 * Documents the class following
 * @package Sagec
 * @author JCB
 */
//--------------------------------------------------------------------------------------------------------
require('gnugpg/gnuPG_class.inc');
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("gnugpg/trousseau.php");

/**
*	Crypte un fichier
* 	@var	$filename nom complet du fichier à crypter ex: ../test.xml
*	@var	$KeyID1 Clé publique de l'expéditeur
*	@var	$KeyID2	Clé publique du receveur
*	@var	$pass	mot de passe pour déverouiller le trousseau de l'expéditeur
*	@return retourne le nom du fichier codé
*/
function crypte($filename,$KeyID1,$KeyID2,$pass)
{
	/** Récupération des données via une BD
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete="SELECT gnu_gpg_bin,gnu_gpg_ring FROM preferences";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	$gpg = new gnuPG($rub['gnu_gpg_bin'], $rub['gnu_gpg_ring']);
	*/
	print("<br>Cryptage du fichier".$filename."en cours...<br>");
	// create the instance, giving the program path and home directory
	//$gpg = new gnuPG('/usr/bin/gpg', '/var/www/html/sagec3/veille_sanitaire');
	//$gpg = new gnuPG('/usr/bin/gpg', '/home/jcb/.gnupg');
	$gpg = new gnuPG(GPG,TROUSSEAU);
	//$filename = "../test.xml";
	$f = fopen($filename,"r");
	$acoder = fread($f,filesize ($filename));
	fclose($f);
	$PublicBlock = $gpg->Encrypt($KeyID1, $pass, $KeyID2, $acoder);
	if($PublicBlock == false)
		print("Une erreur s'est produite: ".$gpg->error."<br>");
	else
	{
		print("Codage:<br>");
		print($PublicBlock."<br>");
		$filename .= ".gpg";
		$f = fopen($filename,"w");
		fwrite($f,$PublicBlock);
		fclose($f);
	}
/*
	// opération inverse pour vérifier
	$PublicBlock = $gpg->Decrypt($KeyID1, $pass, $PublicBlock);
	print("Décodage:<br>");
	print($PublicBlock."<br>");
	$filename = "../controle.xml";
	$f = fopen($filename,"w");
	fwrite($f,$PublicBlock);
	fclose($f);
*/
	return $filename;
}
/**
*	Décrypte un fichier
* 	@var	$filename nom complet du fichier à décrypter ex: ../test.xml
*	@var	$KeyID1 Clé publique de l'expéditeur
*	@var	$KeyID2	Clé publique du receveur
*	@var	$pass	mot de passe pour déverouiller le trousseau de l'expéditeur
*	@return retourne le fichier décrypté
*/
function decrypte($filename,$KeyID1,$pass)
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete="SELECT gnu_gpg_bin,gnu_gpg_ring FROM preferences";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print("Cryptage du fichier".$filename."en cours...<br>");
	// create the instance, giving the program path and home directory
	//$gpg = new gnuPG('/usr/local/bin/gpg', '/var/www/html/SAGEC67_v3/veille_sanitaire');
	$gpg = new gnuPG($rub['gnu_gpg_bin'], $rub['gnu_gpg_ring']);
	print("Décryptage en cours...<br>");
	//$KeyID1 = "31CBF89DBCB3E59E";
	$f = fopen($filename,"r");
	$adecoder = fread($f,filesize ($filename));
	fclose($f);
	// create the instance, giving the program path and home directory
	//$gpg = new gnuPG('/usr/local/bin/gpg', '/var/www/html/SAGEC67_v3/veille_sanitaire');
	$PublicBlock = $gpg->Decrypt($KeyID1, $pass, $adecoder);
	print($PublicBlock."<br>");
	//$filename = "../controle.xml";
	//$f = fopen($filename,"w");
	//fwrite($f,$PublicBlock);
	//fclose($f);
}
/**
*	Liste les clés du trousseau
* 	@var	$cle clés public ou private
*	@return liste des clés
*/
function liste_des_cles($cle='public')
{
// get the keys in the keyring
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$requete="SELECT gnu_gpg_bin,gnu_gpg_ring FROM preferences";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print("Cryptage du fichier".$filename."en cours...<br>");
	// create the instance, giving the program path and home directory
	$gpg = new gnuPG($rub['gnu_gpg_bin'], $rub['gnu_gpg_ring']);
	//$gpg = new gnuPG('/usr/local/bin/gpg', '/var/www/html/SAGEC67_v3/veille_sanitaire');
	print("<br>");
	print("Liste des clés<br><br>");
	$Keys = $gpg->ListKeys($cle);
	if (is_array($Keys)) {
		// show all the keys
		print_r($Keys);
		print("<br>");
		// export the first key in the keyring
		$PublicBlock = $gpg->Export($Keys[0]['KeyID']);
		if ($PublicBlock) {
			// show the key exported
			echo "The KEY BLOCK for {$Keys[0]['UserID']} is:\n\n";
			echo $PublicBlock . "\n";
		} else
			echo $gpg->error . "<br>";
	} 	else
		echo $gpg->error . "<br>";
}

?>
