<?php
/**----------------------------------------- SAGEC --------------------------------------------------------

 This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
 SAGEC67 is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 SAGEC67 is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with SAGEC67; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

/** utilitaires/csv2mysql.php
* 	Récupère un fichier Text et insère les données dans une table
*	date de création: 	24/12/2008		 
*	@author:		jcb		  
*	@version:	$Id$	 
*	maj le:				
*	@package			sagec
*/
/*--------------------------------------------------------------------------------------------------------*/
?>
<html>
<head>
</head>

<body>
	<!-- Le type d'encodage des données, enctype, DOIT être spécifié comme ce qui suit -->
	<form enctype="multipart/form-data" action="csv2mysql_analyse.php" method="post">
  	<!-- MAX_FILE_SIZE doit précéder le champs input de type file -->
  	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
  	<!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
  	Envoyez ce fichier : <input name="userfile" type="file" size="60" />
  	<input type="submit" value="Envoyer le fichier" />
	</form>
</form>
</body>
</html>