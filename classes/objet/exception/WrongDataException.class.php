<?php
/**
 * Exception levé lorsque la donnée ne correspond pas aux valeurs attendues
 * 
 * @package Objet_Exception
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Objet_Exception_WrongDataException extends Exception {
 	
	public function __construct($msg) {
        parent :: __construct($msg);
    }
}
?>