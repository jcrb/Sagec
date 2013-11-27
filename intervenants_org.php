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
//=============================================================================
//
//	intervenants_org.php
//	Organisation des intervenants
//	crée le 04/06/2004
// version $Id: intervenants_org.php 25 2008-01-13 10:17:33Z jcb $
//=============================================================================
session_start();
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

if($_SESSION['auto_sagec'])
{
	include_once ("intervenants_menu.php");
	menu_intervenants($_SESSION['langue']);
}

print("<html>");
print("<head>");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
$n = Null;
//-------------------------------------- Java Script ----------------------------
?>
<script>
var fenetreContact
function cree_fenetreContact(id)
{
	//args="fenetreContact","width=300, height=20, location=no,toolbar=no,scrollbars=yes,resizable=yes,directories=no,status=no";
	url="intervenant_info.php?personne_id="+id;
	fenetreContact = window.open(url, "fenetreContact","width=300, height=20, location=no,toolbar=no,scrollbars=yes,resizable=yes,directories=no,status=no");
}
</script>
<?php
print("</head>");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT Pers_ID,Pers_Nom,Pers_Prenom,perso_cat_ID,localisation_ID,fonction_ID,ts_nom,local_type_ID
				FROM personnel,temp_structure,local_type
				WHERE localisation_ID > '0'
				AND localisation_ID = ts_ID
				AND local_type_ID = ts_type
				";
$resultat = ExecRequete($requete,$connexion);
$n=0;
while($rub=mysql_fetch_array($resultat))
{
	$pers_id[] = $rub['Pers_ID'];
	$pers_nom[] = $rub['Pers_Nom']." ".$rub['Pers_Prenom'];
	$pers_cat[] = $rub['perso_cat_ID'];
	$pers_loc[] = $rub['localisation_ID'];
	$pers_fonction[] = $rub['fonction_ID'];
	$pers_loc_type[] = $rub['local_type_ID'];
	//print($pers_nom[$n]." ".$rub['ts_nom']." ".$pers_fonction[$n]." ".$pers_loc_type[$n]."<br>");
	$n ++;
}
@mysql_free_result($resultat);

function affiche($id,$nom,$cat)
{
	switch ($cat)
	{
		case "1":
		$class = "time_r";
		break;
		case "6":
		$class = "time_v";
		break;
		default:
		$class = "time";
		break;
	}
	// Accès aux informations autorisé uniquement au personnel du SAMU 
	if($_SESSION['service'] == 111)
		print("<A HREF= intervenant_saisie.php?personnelID=$id&back=intervenants_org.php class=\"$class\" OnMouseOver=javascript:cree_fenetreContact($id) OnMouseOut=javascript:fenetreContact.close()> $nom </A>");
	else 
		print("<A HREF=\"\" class=\"$class\"> $nom </A>");
	print("<BR>");
}

//================================================== SAMU =============================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> SAMU </LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"wheat\">");
print("<TR valign=\"top\">");
print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> Régulation de crise </LEGEND>");
	// reg crise = 8
	// Samu = PCFixe = 3 
	for($i = 0; $i < $n; $i++)
	{
		if($pers_fonction[$i] =='8' && $pers_loc_type[$i]=='3')
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);

			//if($pers_cat[$i]=='1') $class = "time_r";else $class = "time";
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php 				class=\"$class\"> $pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
print("</TD>");
print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> Régulation courante </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_fonction[$i] =='9' && $pers_loc_type[$i]=='3')
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
print("</TD>");
print("</TR>");
print("</TABLE>");
print("</FIELDSET>");
print("<BR>");
//============================================ Cellules de crise ==========================================
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Postes de commandement </LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"paleturquoise\">");
print("<TR valign=\"top\">");
print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> Centre Opérationel Départemental </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_loc_type[$i]== '10')
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
print("</TD>");

//============================================ PC Opérationnel ==========================================

/** sélectionne les PCO actifs */
/*
$requete = "SELECT ts_nom,ts_ID FROM temp_structure WHERE ts_active = 'o' AND ts_type = '2'";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> $rub[ts_nom] </LEGEND>");
	print("<TABLE width=\"100%\" bgcolor=\"khaki\">");
	print("<TR valign=\"top\">");
	print("</FIELDSET>");
}
*/
print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> PC Opérationel </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_loc_type[$i]== '2')
		{
			switch($pers_fonction[$i])
			{
				case '3':print("DSM: ");break;
				case '1':print("DOS: ");break;
				case '2':print("COS: ");break;
			}
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
print("</TD>");
print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> Cellule crise HUS </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_loc[$i]== '12')
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
print("</TD>");
print("</TR>");
print("</TABLE>");
print("</FIELDSET>");
print("<BR>");

//============================================ PC  ==========================================

/** sélectionne les PC actifs */
$requete = "SELECT ts_nom,ts_ID FROM temp_structure WHERE ts_active = 'o' AND ts_type = '3'";
$resultat = ExecRequete($requete,$connexion);
print("<FIELDSET>");
print("<LEGEND class=\"time\"> PC SERVICES </LEGEND>");
print("<TABLE width=\"100%\" bgcolor=\"khaki\">");
while($rub=mysql_fetch_array($resultat))
{
	print("<TR valign=\"top\">");
	print("<TD>");
	print("<FIELDSET>");
		print("<LEGEND class=\"time\"> $rub[ts_nom] </LEGEND>");
		for($i = 0; $i < $n; $i++)
		{
			if($pers_loc[$i]== $rub['ts_ID'])
			{
				affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
				//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
				//print("<BR>");
			}
		}
	print("</FIELDSET>");
	print("</TD>");
	print("</TR>");
}
print("</TABLE>");
print("</FIELDSET>");
print("<BR>");

//============================================================ PMA ==========================================
/** sélectionne les PMA actifs */
$requete = "SELECT ts_nom,ts_ID FROM temp_structure WHERE ts_active = 'o' AND ts_type = '1'";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> $rub[ts_nom] </LEGEND>");
	print("<TABLE width=\"100%\" bgcolor=\"khaki\">");
	print("<TR valign=\"top\">");
	
	print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> TRI </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_loc[$i]== $rub['ts_ID'] && ($pers_fonction[$i]=='15'||$pers_fonction[$i]=='6'))
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
	print("</TD>");
	
	print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> PMA </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_loc[$i]== $rub['ts_ID'] && ($pers_fonction[$i]=='4'||$pers_fonction[$i]=='13' || $pers_fonction[$i]=='0')) 
		{
			if($pers_fonction[$i]=='4')
			{
				print("<u>");affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);print("</u>");
			}
			else affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
	print("</TD>");
	
	print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> PRE </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_loc[$i]== $rub['ts_ID'] && ($pers_fonction[$i]=='7'||$pers_fonction[$i]=='16'))
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
	print("</TD>");
	print("</TR>");
	print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> CUMP </LEGEND>");
	for($i = 0; $i < $n; $i++)
	{
		if($pers_loc[$i]== '4')
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
			//print("<A HREF= intervenant_saisie.php?personnelID=$pers_id[$i]&back=intervenants_org.php> 				$pers_nom[$i]  </A>");
			//print("<BR>");
		}
	}
	print("</FIELDSET>");
	print("<TR>");
	print("</TR>");
	print("</TABLE>");
	print("</FIELDSET>");
}
print("<BR>");
//============================================================ POSTES de SECOURS ==========================================
/** sélectionne les Postes de secours actifs */
$requete = "SELECT ts_nom,ts_ID FROM temp_structure WHERE ts_active = 'o' AND ts_type = '13'";
$resultat = ExecRequete($requete,$connexion);
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Postes de Secours </LEGEND>");
print("<TABLE>");
while($rub=mysql_fetch_array($resultat))
{
	print("<TR>");
	print("<TD>");
	print("<FIELDSET>");
	print("<LEGEND class=\"time\"> $rub[ts_nom] </LEGEND>");
		print("<TABLE width=\"100%\" bgcolor=\"khaki\">");
			print("<TR valign=\"top\">");
			for($i = 0; $i < $n; $i++)
	{
		if($pers_loc[$i]== $rub['ts_ID'])
		{
			affiche($pers_id[$i],$pers_nom[$i],$pers_cat[$i]);
		}
	}
			print("</TR>");
		print("</TABLE>");
	print("</FIELDSET>");
	print("</TD>");
	print("</TR>");
}
print("</FIELDSET>");
print("</TABLE>");

print("</html>");
?>
