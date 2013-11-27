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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		uf_modifie.php
*	description:	gestion des UF
*	date de cr�ation: 	17/02/2008
*	@author:			jcb
*	@version:		$Id: uf_modifie.php 41 2008-03-08 14:36:50Z jcb $
*	maj le:			
*/
//---------------------------------------------------------------------------------------------------------
//
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("uf_utilitaires.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Uformulaire plan blanc</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link href="uf.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.getElementById('nom').focus()">
	<form id="catalogue" action="uf_enregistre.php" method="post">
	
	<div id="formtitle">Unit�s Fonctionelles - Mise � jour</div>
	
	<div id="content">
<?php

$id = $_REQUEST['id'];
if($id)
{
	/** c'est une mise � jour */
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">");
	$requete = "SELECT * FROM uf WHERE uf_ID = '$id'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
}

print("<fieldset id=\"coordonnees\">");
print("<legend> UF Id $rub[uf_ID]</legend>");

	print("<p>");
		print("<label for=\"ufCode\" title=\"ufCode\">Code UF :</label>");
		print("<input type=\"text\" id=\"ufCode\" name=\"ufCode\" title=\"Code UF\" value=\"$rub[uf_code]\"/>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"ufNom\" title=\"ufNom\">Nom UF :</label>");
		print("<input type=\"text\" id=\"ufNom\" name=\"ufNom\" size=\"20\" title=\"Nom UF\" value=\"$rub[uf_nom]\"/>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"ufOuverte\" title=\"ufOuverte\">UF ouverte :</label>");
		print("<input type=\"text\" id=\"ufOuverte\" name=\"ufOuverte\" title=\"ufOuverte\" value=\"$rub[uf_ouverte]\"/>");
		print("<span class=\"exemple\">oui = 1</span>");
	print("</p>");

	print("<p>");
		print("<label for=\"serviceNom\" title=\"serviceNom\">Nom Service :</label>");
		fService($rub['Hop_ID'],$rub['service_ID']);
		print("<span class=\"exemple\">$rub[service_ID]</span>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"poleNom\" title=\"poleNom\">Pole :</label>");
		fPole($rub['org_ID'],$rub['pole_ID']);
		print("<span class=\"exemple\">$rub[pole_ID]</span>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"hopNom\" title=\"hopNom\">H�pital :</label>");
		fhopital($rub['Hop_ID']);
		print("<span class=\"exemple\">$rub[Hop_ID]</span>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"orgNom\" title=\"orgNom\">Organisme :</label>");
		forganisme($rub['org_ID']);
		print("<span class=\"exemple\">$rub[org_ID]</span>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"invs\" title=\"invs\">Type INVS :</label>");
		fInvs($rub['type_invs']);
		//print("<span class=\"exemple\">$rub[org_ID]</span>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"ufActivite\" title=\"ufActivite\">Activit� :</label>");
		fUfActivite($rub['uf_activite_ID']);
		print("<span class=\"exemple\">$rub[uf_activite_ID]</span>");
	print("</p>");

	print("<p>");
		print("<label for=\"ufSpecialite\" title=\"ufSpecialite\">Sp�cialit� :</label>");
		fUfSpecialite($rub['uf_specialite_ID']);
		print("<span class=\"exemple\">$rub[uf_specialite_ID]</span>");
	print("</p>");
	
	print("<p>");
		print("<label for=\"ufsurSpecialite\" title=\"ufsurSpecialite\">sur Sp�cialit� :</label>");
		fUfSurSpecialite($rub['uf_surspecialite_ID']);
		print("<span class=\"exemple\">$rub[uf_surspecialite_ID]</span>");
	print("</p>");
	
print("</legend>");	


?>
</div>
	
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
			<input type="submit" name="BtnQuit" id="retour" value="Retour" />
		</p>
	</div>
	
	</form>
</body>

</html>