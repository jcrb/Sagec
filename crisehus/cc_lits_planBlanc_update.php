<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */
/** ---------------------------------------------------------------------------------
  * programme: 			cc_lits_planBlanc_update.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			wrapper pour dispo. 
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Direction Générale - Mise à jour des lits disponibles";
include_once("cc_top.php");
include_once("cc_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';

$back = $backPathToRoot."crisehus/cc_lits_planBlanc_update.php";
require $backPathToRoot.'dispo/lits_planBlanc_query.php';
?>



<?php
?>

</form>
</body>
</html>
  
?>