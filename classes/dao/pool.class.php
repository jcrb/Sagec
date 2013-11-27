<?php
require($BackToRoot."pma_connect.php");

require_once $BackToRoot."classes/objet/exception/SqlException.class.php";

/**
 * Pool de connexion. Pour on utilise juste les connxions persistantes
 * 
 * @package Objet_Import
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Dao_Pool{
	/**
	 * Connexion à la base de données pour faire les tests
	 * @var PDO
	 */
	private static $connexion = null;
	
	public static function setConnexion(&$_connexion){
		Dao_Pool::$connexion = $_connexion;
	}
	
	/**
	 *	Retourne une connexion à la base de données MySQL
	 *  @deprecated: utilser la version object -> getConnexionPdo
	 *  @return connexion à la base de données MySQL
	 */
	public static function &getConnexion (){
		$vConnexion = mysql_pconnect(SERVEUR, NOM, PASSE);
		if ($vConnexion == FALSE){
			throw new Objet_Exception_SqlException (mysql_error());
		}
		if (mysql_select_db(BASE, $vConnexion) == FALSE){
			throw new Objet_Exception_SqlException (mysql_error($vConnexion)); 
		}
		return $vConnexion;
	}
	
	public static function &getConnexionPdo(){
		if (isset (Dao_Pool::$connexion))
			return Dao_Pool::$connexion;
		
		$vConnexion = new PDO('mysql:host='.SERVEUR.';dbname='.BASE, NOM, PASSE);
		$vConnexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $vConnexion;
	}
}
?>