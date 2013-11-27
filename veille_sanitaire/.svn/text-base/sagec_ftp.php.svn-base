<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// $this file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
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
//	programme: 		sagec_ftp.php
//	date de création: 	07/05/2005
//	auteur:			jcb
//	description:		envoie un fichier vers un serveur ftp
//	version:			1.0
//	maj le:			07/05/2005
//
//--------------------------------------------------------------------------------------------------------

//envoi ftp
//	$local nom du fichier local
//	$remote nom qu'aura le fichier sur le serveur distant
function send_file($local,$remote)
{
	$site_ftp = 'ftpperso.free.fr';
	$username = 'jeanclaude.bartier';
	$password = 'marion';
	//$local = "../test.xml.gpg";// chemin d'accès au fichier local
	//$remote = "test.xml.gpg"; //nom qu'aura le fichier sur le serveur distant
	set_time_limit(120);
	$c = ftp_connect($site_ftp) or die("Connection impossible");
	ftp_set_option($c,FTP_TIMEOUT_SEC,120);
	ftp_login($c,$username,$password)  or die("error de login ou de mot de passe");
	ftp_pasv($c, true );// mode passif sur on
	ftp_put($c,$remote,$local,FTP_BINARY) or die("Echec du transfert");//FTP_BINARY FTP_ASCII
	ftp_close($c) or die("Impossible de fermer la connexion");
}
/**
 * Class pour se connecter à un site FTP.
 *
 * @package   Sagec67
 * @author    jc bartier <jcb-bartier@wanadoo.fr>
 * @copyright Copyright (c) 2004-2005, EGM :: Ingenieria sin fronteras
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @since     2005
 * @version   $Id: gnuPG_class.inc,v 1.0.8 2005-04-24 17:03:00-05 egarcia Exp $
 */
class sagec_ftp {
	/**
	* adresse du site ftp
	* @access private
	* @var string
	*/
	var $site_ftp;
	/**
	* login
	* @access private
	* @var string
	*/
	var $username;
	/**
	* password
	* @access private$site,$login,$pass
	* @var string
	*/
	var $password;
	/**
	* variable de connexion
	* @access private
	* @var flux FTP
	*/
	var $connect;
	/**
	* Error and status messages
	* @var string
	*/
	var $error;
	/**
	* durée maximale autorisée pour tenter une connexion (secondes)
	* @var int
	*/
	var $tmax;
	/**
	* mode actif ou passif
	* @var bool
	*/
	var $passif;

	/**
	* Create the FTP object.
	*
	* Set the program path for the GNUPG and the home directory of the keyring.
	* If $this parameters are not specified, according to the OS the function derive the values.
	*
	* @param  string $site   adresse du site FTP
	* @param  string $login	code d'accès
	* @param  string $pass	mot de pase
	* @return void
	*/
	function sagec_ftp($site,$login,$pass)
	{
		$this->site_ftp = $site;
		$this->username = $login;
		$this->password = $pass;
		$this->tmax = 120;
		set_time_limit($this->tmax);
	}
	function set_tmax($t)
	{
		$this->tmax = $t;
		set_time_limit($this->tmax);
	}
	function connexion()
	{
		$this->error = "Connection en cours avec le serveur ".$this->site_ftp;
		$this->flux = ftp_connect($this->site_ftp);
		if(!$this->flux){
			$this->error = "Connection impossible";
			return false;//or die("Connection impossible");
		}
		$e = ftp_login($this->flux,$this->username,$this->password);
		if(!$e){
			$this->error = "ereur de login ou de mot de passe";
			return false;
		}
		ftp_set_option($this->flux,FTP_TIMEOUT_SEC,$this->tmax);
		$this->error = "Connection établie avec le serveur ".$this->site_ftp;
		return true;
	}
	/**
	* Commute la transmission en mode actif ou passif
	*
	* Par défaut, la connexion se fait en mode passif. L'état de la variable $passif, renseigne sur
	* le mode courant.
	*/
	function mode_passif($mode = true)
	{
		$passif = $mode;
		ftp_pasv($this->flux, $mode );// mode passif sur on
	}
	function deconnexion()
	{
		$c = ftp_close($this->flux);
		if(!$c){
			$this->error = "Impossible de fermer la connexion";
			return false;//or die("Connection impossible");
		}
		$this->error = "Connection fermée avec le serveur ".$this->site_ftp;
		$this->flux = "";
		return true;
	}
	/**
	* Envoie un fichier vers le site FTP.
	*
	* Set the program path for the GNUPG and the home directory of the keyring.
	* If $this parameters are not specified, according to the OS the function derive the values.
	*
	* @param  string $local   	nom et chemin d'accès du fichier local
	* @param  string $remote		nom et chemin d'accès du fichier sur le site FTP
	* @return true en cas de succès, flase sinon
	*/
	function put($local,$remote)
	{
		print($this->flux."<br>");
		print($remote."<br>");
		print($local."<br>");
		$e = ftp_put($this->flux,$remote,$local,FTP_BINARY);//FTP_ASCII
		if(!$e){
			$this->error = "Echec du transfert";
			print("local: ".$local."br>");
			print("remote: ".$remote."<br>");
			return false;
			}
		$this->error = "Transfert du fichier ".$local." sur ".$this->site_ftp." terminé";
		return true;
	}
	/**
	* Envoie un fichier vers le site FTP.
	*
	* Set the program path for the GNUPG and the home directory of the keyring.
	* If $this parameters are not specified, according to the OS the function derive the values.
	*
	* @param  string $local   	nom et chemin d'accès du fichier local
	* @param  string $remote		nom et chemin d'accès du fichier sur le site FTP
	* @return true en cas de succès, flase sinon
	*/
	function get($local,$remote)
	{
		$e = ftp_get($this->flux,$remote,$local,FTP_ASCII);
		if(!$e){
			$this->error = "Echec du transfert";
			return false;
		}
		$this->error = "Transfert terminé".$this->site_ftp;
		return true;
	}
	function rename($old_name,$new_name)
	{
		$e = ftp_rename($this->flux,$old_name,$new_name);
		if(!$e){
			$this->error = "Echec du renommage";
			return false;
		}
		$this->error = "Fichier a été renommé";
		return true;
	}

}
?>
