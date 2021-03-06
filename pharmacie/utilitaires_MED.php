<?php
/*=======================================================================================
Utilitaire gestion des m�dicaments
utilitaires_MED.php
=======================================================================================*/
require("../pma_requete.php");
//=======================================================================================
//	Select_dci()		Cr�e une liste d�roulante avec les DCI connues
//					$connexion variable de connexion
//					$item_select	dci_ID du m�dicament s�lectionn�
//					Au retour $ID_dci contient la dci_ID du m�dicament s�lectionn�
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des DCI connues.
*@package utilitaires_MED.php.
*@return int $ID_dci contient l'hopital_ID de l'�tablissement s�lectionn�.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_dci($connexion,$item_select,$onChange="")
{
	$requete="SELECT dci_ID,dci_nom FROM med_dci ORDER BY dci_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_dci\" size=\"1\" onChange='$onChange'>");
	$mot = "aucune";
	print("<OPTION VALUE = \"9999\">$mot</OPTION> \n");

	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[dci_ID]\" ");
			if($item_select == $rub[dci_ID]) print(" SELECTED");
			print("> $rub[dci_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	Select_presentation()		Cr�e une liste d�roulante avec les pr�sentations de
//					m�dicaments
//					$connexion variable de connexion
//					$item_select	dci_ID du m�dicament s�lectionn�
//					Au retour $ID_presentation contient la dci_ID du m�dicament s�lectionn�
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_presentation($connexion,$item_select,$onChange="")
{
	$requete="SELECT presentation_ID,presentation_nom FROM med_presentation ORDER BY presentation_nom";
	$resultat = ExecRequete($requete,$connexion);
	//print("item: ".$item_select."<br>");
	print("<select name=\"present\" size=\"1\" onChange='$onChange'>");
	$mot = "aucune";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[presentation_ID]\"");
			if($item_select == $rub[presentation_ID])
				print(" SELECTED");
			print("> $rub[presentation_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	Select_unite()		Cr�e une liste d�roulante avec les unit�s
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_presentation contient launite_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string nom de l'objet liste. Par d�faut vaut ID_unite. Peut �tre pr�cis� � l'appel par
*l'utilisateur, ce qui permet de l'utiliser plusieurs fois dans le m�me formulaire avec des noms diff�rents.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.1
*/
function select_unite($connexion,$item_select,$nom="ID_unite",$onChange="")
{
	$requete="SELECT unite_ID,unite_abrev FROM med_unites ORDER BY unite_abrev";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"$nom\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[unite_ID]\" ");
			if($item_select == $rub[unite_ID]) print(" SELECTED");
			print("> $rub[unite_abrev] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_psm()		Cr�e une liste d�roulante avec les unit�s
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_presentation contient launite_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_psm($connexion,$item_select,$onChange="") //ID_psm
{
	$requete="SELECT lot_ID,lot_nom FROM med_psm ORDER BY lot_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_psm\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[lot_ID]\" ");
			if($item_select == $rub[lot_ID]) print(" SELECTED");
			print("> $rub[lot_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_med_localisation()		Cr�e une liste d�roulante avec les unit�s
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_presentation contient launite_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_med_localisation($connexion,$item_select,$onChange="")//$ID_medlocal
{
	$requete="SELECT local_ID,local_nom FROM med_localisation ORDER BY local_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_medlocal\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[local_ID]\" ");
			if($item_select == $rub[local_ID]) print(" SELECTED");
			print("> $rub[local_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_malle()		Cr�e une liste d�roulante avec les unit�s
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_presentation contient launite_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_malle($connexion,$item_select,$onChange="")
{
	//$requete="SELECT local_ID,local_nom FROM med_localisation ORDER BY local_nom";
	//$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_malle\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	for($i=1;$i<150;$i++)
	{
			print("<OPTION VALUE=\"$i\" ");
			if($item_select == $i) print(" SELECTED");
			print("> malle $i </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_specialites()		Cr�e une liste d�roulante avec les unit�s
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_presentation contient launite_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_specialites($connexion,$item_select,$onChange="")
{
	$requete="SELECT special_ID,special_nom FROM med_specialite WHERE categorie = '1' ORDER BY special_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_special\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[special_ID]\" ");
			if($item_select == $rub[special_ID]) print(" SELECTED");
			print("> $rub[special_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_stock()		Cr�e une liste d�roulante avec le type de stockage: psm1, psm2..
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_stock contient le med_stock_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_stock($connexion,$item_select,$onChange="") //ID_stock
{
	$requete="SELECT med_stock_ID,med_stock_nom FROM med_type_stock ORDER BY med_stock_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_stock\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[med_stock_ID]\" ");
			if($item_select == $rub[med_stock_ID]) print(" SELECTED");
			print("> $rub[med_stock_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
/**=======================================================================================
//	liste_med()		affiche un tableau des m�dicaments
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_stock contient le med_stock_ID de l'unit� s�lectionn�e
//					$type = 0: tout le contenu de la table
					$type = 1: uniquement les m�dicaments
					$type = 2: uniquement le mat�riel
					$tri colonne sur laquelle se fait le tri; d�faut nom sp�cialit�
					$ordre sens du tri
//=======================================================================================*/
function liste_med($connexion,$type = 1,$tri="",$ordre="DESC")
{
	switch($tri){
		case 1:$triage="medic_ID";break;
		case 2:$triage="special_nom";break;
		case 3:$triage="dci_nom";break;
		default:$triage="special_nom";
	}
	if($ordre=="DESC" || $ordre=="")$ordre="ASC";else $ordre="DESC";
	$requete="SELECT medic_ID,special_nom, dci_nom,presentation_nom,presentation_ID,medic_volume,unite_abrev ml,medic_dosage,medic_dosage_unite
			FROM medicament,med_specialite,med_dci,med_presentation,med_unites
			WHERE special_ID = medic_nom
			AND dci_ID = medic_dci
			AND presentation_ID = medic_presentation
			AND unite_ID = medic_volume_unite
			AND categorie = '$type'
			ORDER BY ".$triage." ".$ordre." ";
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
		print("<tr bgcolor=\"yellow\">");
			print("<td><a href=\"?tri=1&ordre=$ordre\"><b>N�</b></a></td>");
			print("<td><a href=\"?tri=2&ordre=$ordre\"><b>Sp�cialit�</b></a></td>");
			print("<td><a href=\"?tri=3&ordre=$ordre\"><b>DCI</b></a></td>");
			print("<td><b>Pr�sentation</b></td>");
		print("</tr>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
		print("<TD>");
			print("<A href=\"medicament_fiche.php?medicament=$rub[medic_ID]\">$rub[medic_ID]</A>");
		print("</TD>");
		print("<TD> $rub[special_nom]</TD>");
		print("<TD> $rub[dci_nom]</TD>");
		print("<TD>");
			print("$rub[presentation_nom]");
			if($rub[presentation_ID]=="1"||$rub[presentation_ID]=="3"||$rub[presentation_ID]=="4"||$rub[presentation_ID]=="7") print(" de ".$rub[medic_volume]." ".$rub[ml]);
			$requete="SELECT unite_abrev FROM med_unites WHERE unite_ID='$rub[medic_dosage_unite]'";
			if($rub[medic_dosage])
			{
				$resultat2 = ExecRequete($requete,$connexion);
				$unit=mysql_fetch_array($resultat2);
				print(" contenant ".$rub[medic_dosage]." ".$unit[unite_abrev]);
				@mysql_free_result($resultat2);
			}
		print("</TD>");
		print("</TR>");
	}
	print("</table>");
	@mysql_free_result($resultat);
}
//=======================================================================================
//	liste_med2()		affiche liste d�roulante des m�dicaments
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour ID_med contient le med_stock_ID de l'unit� s�lectionn�e
//=======================================================================================
function get_med($connexion, $med)
{
	$requete="SELECT medic_ID,special_nom, dci_nom,presentation_nom,medic_volume,unite_abrev ml,medic_dosage,medic_dosage_unite
			FROM medicament,med_specialite,med_dci,med_presentation,med_unites
			WHERE medic_ID = '$med'
			AND special_ID = medic_nom
			AND dci_ID = medic_dci
			AND presentation_ID = medic_presentation
			AND unite_ID = medic_volume_unite
			";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	$medoc=$rub[special_nom]." (".$rub[dci_nom].") ".$rub[presentation_nom];
	if($rub[presentation_nom]=="ampoule") $medoc.=" de ".$rub[medic_volume]." ".$rub[ml];
	$requete="SELECT unite_abrev FROM med_unites WHERE unite_ID='$rub[medic_dosage_unite]'";
	$resultat2 = ExecRequete($requete,$connexion);
	$unit=mysql_fetch_array($resultat2);
	$medoc.=" contenant ".$rub[medic_dosage]." ".$unit[unite_abrev];
	@mysql_free_result($resultat2);
	@mysql_free_result($resultat);
	return $medoc;
}
function liste_med2($connexion,$item_select)
{
	$requete="SELECT medic_ID,special_nom, dci_nom,presentation_nom,medic_volume,unite_abrev ml,medic_dosage,medic_dosage_unite
			FROM medicament,med_specialite,med_dci,med_presentation,med_unites
			WHERE special_ID = medic_nom
			AND dci_ID = medic_dci
			AND presentation_ID = medic_presentation
			AND unite_ID = medic_volume_unite
			ORDER BY special_nom
			";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>");
	print("<select name=\"ID_med\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[medic_ID]\" ");
			if($item_select == $rub[medic_ID]) print(" SELECTED");
			$medoc=$rub[special_nom]." (".$rub[dci_nom].") ".$rub[presentation_nom];
			if($rub[presentation_nom]=="ampoule") $medoc.=" de ".$rub[medic_volume]." ".$rub[ml];
			$requete="SELECT unite_abrev FROM med_unites WHERE unite_ID='$rub[medic_dosage_unite]'";
			$resultat2 = ExecRequete($requete,$connexion);
			$unit=mysql_fetch_array($resultat2);
			$medoc.=" contenant ".$rub[medic_dosage]." ".$unit[unite_abrev];
			@mysql_free_result($resultat2);
			print("> $medoc </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_stockage()		Cr�e une liste d�roulante avec le type de stockage: psm1, psm2..
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_stock contient le med_stock_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_stockage($connexion,$item_select,$onChange="") //$ID_stockage
{
	//$requete="SELECT * FROM stockage ORDER BY stockage_batiment";
	$requete="SELECT * FROM stockage";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_stockage\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[stockage_ID]\" ");
			if($item_select == $rub[stockage_ID]) print(" SELECTED");
			$mot=$rub[stockage_batiment]." (".$rub[stockage_etage].") ".$rub[stockage_local];
			print("> $mot </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	select_rangement()		Cr�e une liste d�roulante avec le type de stockage: psm1, psm2..
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//					Au retour $ID_stock contient le med_stock_ID de l'unit� s�lectionn�e
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec une liste d�roulante des presentation de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_presentation contient l'presentation_ID de la presentation s�lectionn�e.
*@param string variable de connexion.
*@param int ID de la DCI courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_rangement($connexion,$item_select,$onChange="") //$ID_rangement
{
	$requete="SELECT * FROM stock_rangement ORDER BY rangement_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_rangement\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[rangement_ID]\" ");
			if($item_select == $rub[rangement_ID]) print(" SELECTED");
			$mot=$rub[rangement_nom];
			print("> $mot </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	get_stockage()		Renvoie une chaine de caract�res contenant le description d'un
//					lieu de stockage
//					$connexion variable de connexion
//					$i stockage_ID � d�crire
//=======================================================================================
function get_stockage($connexion,$i)
{
	$requete="SELECT * FROM stockage WHERE stockage_ID = '$i'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	return $rub[stockage_batiment]." (".$rub[stockage_etage].") ".$rub[stockage_local];
}
//=======================================================================================
//stockage_table		affiche le contenu de la table stockage
//					$connexion variable de connexion
//=======================================================================================
function stockage_table($connexion)
{
	$requete="SELECT stockage_ID,stockage_batiment_nom,stockage_etage,stockage_local,org_nom
	 		FROM stockage,organisme,stockage_batiment
			WHERE organisme.org_ID = stockage.org_ID
			AND stockage_batiment.stockage_batiment_ID = stockage.stockage_batiment_ID
			";
	$resultat = ExecRequete($requete,$connexion);
	print("<table>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
		print("<TD><A href=\"local_saisie.php?local=$rub[stockage_ID]\">$rub[stockage_ID]</A></TD>");
		$mot=$rub[stockage_batiment_nom]." (".$rub[stockage_etage].") ".$rub[stockage_local];
		print("<TD>$mot</TD>");
		print("<TD>$rub[org_nom]</TD>");
		print("</TR>");
	}
	print("</table>");
	@mysql_free_result($resultat);
}
//=============================================================================
//	Selectlocal()	Cr�e une liste d�roulante avec la liste locaux de stockage
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme s�lectionn�
//						Au retour, $org_type contient le type_ID
//=============================================================================
function Selectlocal($connexion,$item_select,$langue,$onChange="")
{
	require '../utilitaires/globals_string_lang.php';
	// lit la liste des h�pitaux dans la base de donn�es
	$requete="SELECT org_ID,org_nom FROM organisme ORDER BY org_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"org_type\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[org_ID]\" ");
		if($item_select == $rub[org_ID]) print(" SELECTED");
		print(">$rub[org_nom]</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

//=============================================================================
//	SelectBatiment()	Cr�e une liste d�roulante avec la liste batiments de stockage
//						$connexion 		variable de connexion
//						$item_select	type_ID de l'organisme s�lectionn�
//						Au retour, $ID_batiment contient le type_ID
//=============================================================================
function SelectBatiment($connexion,$org_ID,$item_select,$langue,$onChange="")
{
	require '../utilitaires/globals_string_lang.php';
	// lit la liste des h�pitaux dans la base de donn�es
	$requete="SELECT DISTINCT stockage_batiment.stockage_batiment_ID,stockage_batiment_nom
			FROM stockage_batiment, stockage
			WHERE stockage.org_ID = '$org_ID'
			AND stockage.stockage_batiment_ID = stockage_batiment.stockage_batiment_ID
			";

	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"ID_batiment\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['ALL_ETATS'][$langue];
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[stockage_batiment_ID]\" ");
		if($item_select == $rub[stockage_batiment_ID]) print(" SELECTED");
		print(">$rub[stockage_batiment_nom]</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	liste_lot()		affiche le contenu d'un lot
//					$connexion variable de connexion
//					$item_select	unite_ID de l'unit� s�lectionn�e
//=======================================================================================
function liste_lot($connexion,$tri="")
{
	switch($tri)
	{
		case 'stockage':$mode_tri = "ORDER BY med_stock_nom, conteneur_nom";break;
		case 'localisation':$mode_tri = "ORDER BY stockage_batiment, conteneur_nom";break;
		case 'medicament':$mode_tri = "ORDER BY special_nom, conteneur_nom";break;
		case 'date':$mode_tri = "ORDER BY med_lot_perime, conteneur_nom ,special_nom";break;
		case 'conteneur':$mode_tri = "ORDER BY conteneur_nom ,special_nom";break;
		default:$mode_tri = "ORDER BY special_nom, conteneur_nom";break;
	}
	
	$requete="SELECT med_lot_ID,med_lot.medic_ID,med_lot_qte,med_lot_perime,med_lot.conteneur_ID,lot_nom,conteneur_nom,conteneur_no,special_nom,med_stock_nom,
						stockage_batiment,stockage_etage,stockage_local
			FROM med_lot,stock_conteneur,med_psm,med_specialite,medicament,med_type_stock,stockage
			WHERE med_lot.conteneur_ID = stock_conteneur.conteneur_ID
			AND stock_conteneur.conteneur_nom = med_psm.lot_ID
			AND special_ID = medicament.medic_nom
			AND medicament.medic_ID = med_lot.medic_ID
			AND med_type_stock.med_stock_ID = stock_conteneur.med_type_stock
			AND stock_conteneur.conteneur_ID = med_lot.conteneur_ID
			AND stock_conteneur.stockage_ID = stockage.stockage_ID
	";
	$requete.= $mode_tri;
	
	$resultat = ExecRequete($requete,$connexion);
	print("<table width=\"100%\">");

	print("<TR>");
		print("<TD>ref.</TD>");
		print("<Td><a href=\"medicament_liste.php?tri=medicament\"> m�dicament</a></Td>");
		print("<TD>quantit�</TD>");
		print("<TD><a href=\"medicament_liste.php?tri=date\">p�remption</a></TD>");
		print("<TD><a href=\"medicament_liste.php?tri=conteneur\">conteneur</a></TD>");
		print("<TD><a href=\"medicament_liste.php?tri=localisation\">localisation</a></TD>");
		print("<TD><a href=\"medicament_liste.php?tri=stockage\">stockage</a></TD>");
	print("</TR>");

	while($rub=mysql_fetch_array($resultat))
	{
		//$stockage = get_stockage($connexion,$rub[stockage_ID]);
		$stockage = $rub[stockage_batiment]." (".$rub[stockage_etage].") ".$rub[stockage_local];
		//$medoc = get_med($connexion, $rub[medic_ID]);
		print("<TR>");
		print("<TD class\"verda\" width=\"10\"><A href=\"medicament_lot.php?lot=$rub[med_lot_ID]\">$rub[med_lot_ID]</A></TD>");
		print("<TD class\"verda\">$rub[special_nom]</TD>");
		print("<TD class\"verda\" align=\"right\">$rub[med_lot_qte]</TD>");
		print("<TD class\"verda\">$rub[med_lot_perime]</TD>");
		print("<TD class\"verda\"> $rub[lot_nom]$rub[conteneur_no]</TD>");
		//print("<TD>$rub[local_nom] $rub[rangement_nom] $rub[rangement_code]</TD>");
		print("<TD class\"verda\">$stockage</TD>");
		print("<TD class\"verda\"> $rub[med_stock_nom]</TD>");
		print("</TR>");
	}
	print("</table>");
	@mysql_free_result($resultat);
}
//=======================================================================================
//	liste_famille()	liste d�roulante des familles de m�dicaments
//					$connexion variable de connexion
//					$item_select	ID_famille de l'unit� s�lectionn�e
//					Au retour $ID_famille[] contient les famille_ID. en effet un
//					m�dicament peut appartenir � plusieurs familles.
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante des familles de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_famille contient le famille_ID.
*@param string variable de connexion.
*@param int ID de la famille courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function liste_famille($connexion,$item_select,$onChange="") //$ID_famille
{
	$requete="SELECT * FROM med_famille ORDER BY famille_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_famille[]\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[famille_ID]\" ");
			if($item_select == $rub[famille_ID]) print(" SELECTED");
			$mot=$rub[famille_nom];
			print("> $mot </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
//=======================================================================================
//	liste_medicament()	liste d�roulante des m�dicaments
//					$connexion variable de connexion
//					$item_select	ID_famille de l'unit� s�lectionn�e
//					Au retour $ID_famille[] contient les famille_ID.
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante des familles de m�dicaments.
*@package utilitaires_MED.php.
*@return int $ID_med contient le nom du m�dicament.
*@param string variable de connexion.
*@param int ID de la famille courante.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function liste_medicament($connexion,$item_select,$onChange="") //$ID_med
{
	$requete="SELECT * FROM med_specialite WHERE categorie = 1 ORDER BY special_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_med\" size=\"1\" onChange='$onChange'>");
	$mot = "--Choisir--";
	print("<OPTION VALUE = \"0\">$mot</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[special_ID]\" ");
			if($item_select == $rub['special_ID']) print(" SELECTED");
			$mot=$rub['special_nom'];
			print("> $mot </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}
?>
