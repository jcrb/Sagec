<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
/**
* 	apa_entete.php
* 	Affichage de l'en-tête
*	@version $Id: apa_entete.php 39 2008-02-28 17:59:09Z jcb $
*/

include("utilitaires/table.php");
include("html.php");
TblDebut(0,"100%");
	TblDebutLigne();
	TblCellule(Image('images/SAMU.jpeg',50,50));
	TblCellule("<B>Transporteurs sanitaires privés</B>",1,1,"TITRE");
	TblCellule("SAMU 67",1,1);
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale
?>
