<?php
/**
 * Gestion li�e aux listes
 * 
 * @author NOLDDOMI
 *
 */
class Metier_Util_Liste{
	/**
	 * Verifie si l'�lement pass� en param�tre est dans la liste
	 * @param $_objet: String
	 * @param $_liste: String[]
	 * @return true si l'object est trouv� dans la liste
	 */
	public static function estDansListe (&$_objet, &$_liste){
		$_estTrouve = false;
		foreach ($_liste as $vElement){
			$_estTrouve |= ($_objet == $vElement);
		}
		return $_estTrouve;
	}
	
	/**
	 * Supprime un �l�ment de la liste
	 * @param $_objet: String
	 * @param $_liste: String[]
	 */
	public static function supprDansListe (&$_objet, &$_liste){
		foreach ($_liste as $vIndex => $vElement){
			if ($_objet == $vElement){
				unset($_liste[$vIndex]);
			}
		}
	}
	
	/**
	 * Transforme une liste en chaine de carct�re pour mettre dans une clause where
	 * @param $_liste: String[]
	 * @return String
	 */
	public static function SqlInListe(&$_liste){
		$vListe = "";
		
		foreach ($_liste as $vElement){
			if (strlen($vListe)>0){
				$vListe .= ",";
			}
			$vListe .= $vElement;
		}
		
		return $vListe;
	}
}
?>