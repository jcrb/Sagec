<?php
/**
 * Exception liée aux erreurs retournées par mysql
 * 
 * @package Objet_Exception
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Exception_SqlException extends Exception {
 	
	public function __construct($msg) {
        parent :: __construct($msg);
    }
}
?>