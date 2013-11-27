<?php

/**	services_utilitaires.php
*	Utilitaires pour l'affichage des services
*	@version:	$Id: services_utilitaires.php 31 2008-02-12 18:02:26Z jcb $	
*/

//===========================================================================
//	Table_Lits2	Affiche l'�tat des lits sous forme d'une table
//	$connexion	variable de connection
//	$hopID		identifiant d'un hopital. Par d�faut vaut 0. Dans ce cas
//			la liste de tous les services, de tous les h�pitaux est
//			renvoy�e. Sinon, seuls les services d'un hopital sont renvoy�s
//			ATTENTION: $hopID correspond � org_ID
//	$back		adresse de retour pour la fonction modifier
//============================================================================

function explode_dpt2($dpt)
{
	$requete = " AND hopital.adresse_ID = adresse.ad_ID AND adresse.ville_ID = ville.ville_ID AND ville.departement_ID IN (";
		$n=count($dpt);
		for($i=0;$i<$n; $i++)
			$requete .= "'".$dpt[$i]."',";
		$requete .= "'-1')";// rajoute un d�partement fictif pour clore la liste
	return $requete;
}

function explode_pays($dpt)
{
	$n=count($dpt);
	for($i=0;$i<$n; $i++)
		$liste .= "'".$dpt[$i]."',";
	$liste .= "'-1')";// rajoute un pays fictif pour clore la liste
	$requete = " AND hopital.adresse_ID = adresse.ad_ID AND adresse.ville_ID = ville.ville_ID AND ville.pays_ID IN (".$liste;
	return $requete;
}

//=======================================================================================
//	select_hopital_org()		Cr�e une liste d�roulante avec la liste des h�pitaux
//								appartenant au m�me organisme
//		$connexion variable de connexion
//		$item_select	Hop_ID de l'hopital s�lectionn�
//		Au retour $ID_hopital contient l'Hop_ID de l'hopital s�lectionn�
//=======================================================================================
/**
*Cr�e et affiche une liste d�roulante avec la liste des h�pitaux.
*@package utilitairesHTML.php.
*@return int $ID_hopital contient l'hopital_ID de l'�tablissement s�lectionn�.
*@param string variable de connexion.
*@param int ID de l'hopital courant.
*@param string langue ou pays courant.
*@param string action � entreprendre si la s�lection change (facultatif).
*@version 1.0
*/
function select_hopital_org($connexion,$item_select,$org_ID,$onChange="")
{
	require 'utilitaires/globals_string_lang.php';
	// lit la liste des h�pitaux dans la base de donn�es
	$requete="SELECT Hop_ID,Hop_nom FROM hopital WHERE org_ID = '$org_ID' ORDER BY Hop_nom";
	//$requete="SELECT org_ID,org_nom FROM organisme WHERE organisme_type_ID = '12'ORDER BY org_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<select name=\"ID_hopital\" size=\"1\" onChange='$onChange'>");
	$mot = $string_lang['NO_SELECT'][$langue];
	print("<OPTION VALUE = \"0\">Tous les sites</OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
			print("<OPTION VALUE=\"$rub[Hop_ID]\" ");
			if($item_select == $rub['Hop_ID']) print(" SELECTED");
			print("> $rub[Hop_nom] </OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

function select_services_org($connexion,$orgID,$type_service="0",$tri)
{
	// ordre de tri
	switch($tri)
	{
		case 'service':$t = " ORDER BY service_nom";break;
		case 'hopital':$t = " ORDER BY hop_nom";break;
		case 'type':$t = " ORDER BY service.Type_ID";break;
		case 'maj':$t = " ORDER BY date_maj";break;
		case 'ldispo':$t = " ORDER BY lits_dispo DESC";break;
		default:$t=" ORDER BY lits_dispo DESC";break;
	}

	if($type_service > 0) // sp�cialit� sp�cifique
	{
		$requete="SELECT * FROM  lits,service,hopital";//
		$requete .=" WHERE service.org_ID = '$orgID'
					AND service.Type_ID = '$type_service'
					AND lits.service_ID = service.service_ID
					AND hopital.Hop_ID = service.Hop_ID
					";//
		$requete .= $t;
	}
	else
	{
		$requete="SELECT * FROM lits, service, hopital";
		$requete .=" WHERE service.org_ID = '$orgID'
					AND lits.service_ID = service.service_ID
					AND hopital.Hop_ID = service.Hop_ID";
		$requete .= $t;
	}
	return $requete;
}

/**
*		S�lectionne des services selon certains crit�res
*		16/4/2008 les services o� Priorit�_Alerte = 9 sont exclus
*/
function select_services($connexion,$hopID="0",$type_service="0",$dpt="",$tri)
{
	// ordre de tri
	switch($tri)
	{
		case 'service':$t = " ORDER BY service_nom";break;
		case 'hopital':$t = " ORDER BY hop_nom";break;
		case 'type':$t = " ORDER BY service.Type_ID";break;
		case 'maj':$t = " ORDER BY date_maj";break;
		case 'ldispo':$t = " ORDER BY lits_dispo DESC";break;
		default:$t=" ORDER BY lits_dispo DESC";break;
	}
	// tous les h�pitaux et services
	if($hopID < 1 && $type_service < 1)
	{
		$requete="SELECT *
					FROM lits,service, hopital";
					if($dpt !="") $requete .= ",ville,adresse";
		$requete .=	" WHERE lits.service_ID = service.service_ID
					 AND hopital.Hop_ID = service.Hop_ID
					 AND service.Priorite_Alerte <> 9";
			if($dpt !="") {
				if($type_service !=10) $requete .= explode_dpt2($dpt);
				else $requete .= explode_pays($dpt);// pour les brul�s
			}
		$requete .= $t;
	}
	// tous les h�pitaux, service sp�cifique
	else if($hopID < 1 && $type_service > 0)
	{
		$requete=	"SELECT *
					FROM hopital,lits, service";
			if($dpt !="") $requete .= ",ville,adresse";
		$requete .=" WHERE service.Type_ID = '$type_service'
					AND service.Priorite_Alerte <> 9
					AND service.service_ID = lits.service_ID
					AND hopital.Hop_ID = service.Hop_ID";
			if($dpt !="") {
				if($type_service !=10) $requete .= explode_dpt2($dpt);
				else $requete .= explode_pays($dpt);// pour les brul�s
			}
		$requete .= $t;
	}
	// tous les services, h�pital sp�cifique
	else if($hopID > 0 && $type_service < 1)
	{
		$requete = "SELECT *
						FROM service,lits,hopital
						WHERE service.service_ID = lits.service_ID
						AND service.Priorite_Alerte <> 9
						AND service.Hop_ID = hopital.Hop_ID
						AND hopital.Hop_ID = '$hopID'";//AND service.Hop_ID = '$hopID'";
						
		$requete = "SELECT *
						FROM service,lits
						WHERE service.service_ID = lits.service_ID
						AND service.Priorite_Alerte <> 9
						AND service.Hop_ID = '$hopID'";
						
		$requete .= $t;
	}
	// hopital et service sp�cifique
	else
	{
		$requete=	"SELECT *
					FROM service,lits,hopital
					WHERE service.Type_ID = '$type_service'
					AND service.Priorite_Alerte <> 9
					AND service.Hop_ID = '$hopID'
					AND service.Hop_ID = hopital.Hop_ID
					AND lits.service_ID =service.service_ID
					";
				$requete .= $t;
	}
	return $requete;
	//print($requete."<BR>");
}

/**
\fn function Table_Lits3($connexion,$hopID="0",$type_service="0",$langue,$back="",$dpt="",$tri="",$modif="true")
@param $modif bool si true alors la colonne modifier est active et on a acc�s � la fiche du service
*/
function Table_Lits3($connexion,$hopID="0",$type_service="0",$langue,$back="",$dpt="",$tri="",$modif="true")
{
	MAJ_Lits_cata($connexion);
	// cr�ation et ex�cution de la requete
	$requete = select_services($connexion,$hopID,$type_service,$dpt,$tri);
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
	affichage($resultat,$langue,$back,$connexion,$modif);
}

function  Table_Lits4($connexion,$orgID="0",$type_service="0",$langue,$back="",$tri="")
{
	$requete = select_services_org($connexion,$orgID,$type_service,$tri);
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
	affichage($resultat,$langue,$back,$connexion);
}

function affichage($resultat,$langue,$back,$connexion,$modif="")
{
	require 'utilitaires/globals_string_lang.php';
	global $total_lits_dispo;
	// affichage du r�sultat
	TblDebut(0,"100%");
	$_style = "A2";
	$retour=$back."?type_s=$type_service&ID_hopital=$hopID&tri";
	TblDebutLigne("$_style");
	if($modif=='true'){
		$mot = $string_lang['MODIFIER'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"> $mot");}
	//TblCellule("<B>ID</B>");
	$mot = $string_lang['HOPITAL'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=hopital\">$mot</a>");
	$mot = $string_lang['SERVICE'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=service\">$mot</a>");
	$mot = $string_lang['TYPE'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=type\">$mot</a>");
	$mot = $string_lang['TOTAL_LITS'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_OCC'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_LIB'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_SUP'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['LITS_DISPO'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=ldispo\">$mot</a>");
	$mot = $string_lang['VICTIMES_CATA'][$langue];TblCellule("<div align=\"left\" class=\"Style24\">$mot");
	$mot = $string_lang['MAJ'][$langue];TblCellule("<div align=\"left\" class=\"Style24\"><a href=\"$retour=maj\">$mot</a>");
	TblFinLigne();

	$_style = "A5";
	$modifier = $string_lang['MODIFIER'][$langue];
	while($i = LigneSuivante($resultat))
	{
		if($_style=="A5")$_style="A6";
		else $_style="A5";
		TblDebutLigne("$_style");
		// MODFIER: on appelle Tri2 avec comme param�tre le n� d'ordre contenu
		// dans la variable 'identifiant' qui est attendue par Tri2
		$identifiant = $i->service_ID;
		// on transmet l'identifiant de l'h�pital et/ou du type de service
		if($modif=='true')
			TblCellule("<a href=\"services.php?ttservice=$identifiant&back=$back&hopID=$hopID&type_service=$type_service\" class=\"time\">$modifier</a>");
		// Affichage des donn�es de la ligne
	//TblCellule("$i->lits_ID");
	//TblCellule("<div align=\"left\" class=\"Style23\"> $identifiant");
	TblCellule("<div align=\"left\" class=\"Style23\">".Security::db2str($i->Hop_nom)."");
	$service_nom = $i->service_nom;
	$service_id = $i->service_ID;
	TblCellule("<div align=\"left\" class=\"Style23\"> $i->service_nom");
	//TblCellule("<div align=\"left\" class=\"Style23\" OnMouseOver=javascript:cree_fenetreContact($i->service_ID,$i->service_nom) OnMouseOut=javascript:fenetreContact.close()> $i->service_nom");

	$type = ChercheTypeService($i->Type_ID,$connexion);
	//$mot = $string_lang[$type->type_nom][$langue];
	$mot = $string_lang[$type][$langue];
	//------------------------------ adulte ou enfant ? -------------------
	if($i->service_adulte) $mot .= " ".$string_lang['ADULTE'][$langue];
	if($i->service_enfant) $mot .= " ".$string_lang['ENFANT'][$langue];
	if($i->age_min) $mot .= ">".$i->age_min.$string_lang['ANS'][$langue];
	TblCellule("<div align=\"left\" class=\"Style22\"> $mot");
	//---------------------------------------------------------------------
	TblCellule("<div align=\"right\" class=\"time\"> $i->lits_sp");
	TblCellule("<div align=\"right\" class=\"Style23\"> $i->lits_occ");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_liberable");
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_supp");
	//$lits_dispo = $i->lits_sp + $i->lits_supp - $i->lits_occ - $i->lits_cata;
	if($i->lits_dispo < 0) $i->lits_dispo = 0;
	TblCellule("<div align=\"center\" class=\"time_v\"><B> $i->lits_dispo</B>");
	$total_lits_dispo += $i->lits_dispo;
	$total_lits += $i->lits_sp;
	TblCellule("<div align=\"center\" class=\"Style23\"> $i->lits_cata");
	if($i->date_maj < 1)
		TblCellule(" ");
	else
	{
		$t = date("j/m/Y H:i",$i->date_maj);
		TblCellule("<div align=\"center\" class=\"Style22\">$t");
	}
	TblFinLigne();
	}
	if($total_lits > 0)
	{
		$taux_occupation = 100-100*$total_lits_dispo/$total_lits;
		print("<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>");
		print("<td>Total Lits: ".$total_lits."</td><td>Lits disponibles: ".$total_lits_dispo."</td><td>% occupation: ".$taux_occupation."</td><td>&nbsp;</td></tr>");
	}
	TblFin();
	
}
?>
