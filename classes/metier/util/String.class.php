<?php
/**
 * Traitement autour des dates
 * 
 * @package Metier_Util
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Dominique NOLD
 */
class Metier_Util_String{
	/**
	 * Echape une chaine de caract�re pour l'ins�rer dans du javascript
	 * @param $_string: string, chaine de caract�re � �chaper
	 * @return string
	 */
	public static function EscapeJavascript($_string){
		return addslashes($_string); // suffit pour le moment
	}
}
?>