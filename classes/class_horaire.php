<?php
/**
 *	classe_horaire.php
 * 
 *	manipule des plages horaires
 * @package Dao_Veille
 * @copyright Copyright (C) 2003 (Jean-Claude Bartier)
 * @license GNU General Public License
 * @author Jean-Claude Bartier
*/

class CHoraire()
{
	/**
	 *	type de structure: cabinet médical, radio, ide, etc.
	 */
	 private $structure_ID;
	 /**
	 *	identifiant dans la structure
	 */
	 private $identifiant_ID;
	 /**
	 *	jour de la semaine
	 */
	 private $jour_ID;
	 /**
	 *	Heure de départ: HH:MM
	 */
	 private $h1;
	 /**
	 *	Heure de fin: HH:MM
	 */
	 private $h2;
	 /**
	 *	Sur RDV ou non
	 */
	 private $rdv;
}