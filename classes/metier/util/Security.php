<?php
if (!isset($BackToRoot)){
	$BackToRoot="../../../SAGEC67/";
}

class Metier_Util_Security{
	/**
	 * V�rifie si la variable pass�e en param�tre est conforme aux attentes de l'application
	 * @param $_variable: variable � v�rifier
	 * @param $_type: type de la donn�e
	 * @param $_default: valeur � mettre par d�faut
	 * @return variable v�rifi�e
	 */
	public static function escape($_variable, $_type="string", $_default="nothing"){
		switch ($_type){
			case "string":
				if (!is_string($_variable)){
					$_variable = strval($_variable);
				}
				$_variable = addslashes($_variable);
				break;
			case "integer":
				if (!is_integer($_variable)){
					$_variable = intval($_variable);
				}
				break;
			case "double":
				if (!is_double($_variable)){
					$_variable = doubleval($_variable);
				}
				break;
			case "boolean":
				if (!is_bool($_variable)){
					$_variable =  !($_variable == 0 || $_variable == FALSE || $_variable == NULL || $_variable == NIL);
				}
				break;
			default:
				break;
		}
		return $_variable;
	}
}
?>