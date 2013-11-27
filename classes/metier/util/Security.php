<?php
if (!isset($BackToRoot)){
	$BackToRoot="../../../SAGEC67/";
}

class Metier_Util_Security{
	/**
	 * Vérifie si la variable passée en paramètre est conforme aux attentes de l'application
	 * @param $_variable: variable à vérifier
	 * @param $_type: type de la donnée
	 * @param $_default: valeur à mettre par défaut
	 * @return variable vérifiée
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