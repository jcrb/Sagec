<?php
// Utilitaire pour créer des tables
// version 1.2
if (!isset ($ModuleTable))
{
 $ModuleTable = 1;
 // Module de production de tableaux HTML
 // Source: Ph Rigaux pp 118
 // Permet d'afficher des tables de données provenant d'une base de données ou de
 // formater la présentation d'un formulaire
 // Toutes les fonctions sont préfixées par "Tbl"
 //	Un tableau est constitué de lignes
 // Les lignes sont constituées de cellules
 
 // Exemple: création dun tableau de 1 ligne et 3 cellules
 //	TblDebut(0,"100%");
 // 	TblDebutLigne();
 // 		TblCellule();
 // 		TblCellule();
 // 		TblCellule();
 //		TblFinLigne();
 // TblFin();
//
//===================================================================================
// TblDebut			
//===================================================================================
 function TblDebut ($bordure = '1', // La bordure
                    $largeur = -1,  // "50%" occupe 50% de la largeur, "50" = 50 pixels de largeur
                    $espCell = '2', // CELLSPACING: espacement entre les cellules
                    $remplCell = '4', // CELLPADDING: espace de remplissage d'une cellule 
                    $classe=-1)// classe arbitraire permettant de définir certaines caractéristiques
								// comme la couleur de fond
 {
  $optionClasse = ""; $optionLargeur="";
  if ($classe != -1) $optionClasse = " CLASS='$classe' ";
  if ($largeur != -1) $optionLargeur = " WIDTH='$largeur' ";

  echo "<TABLE BORDER='$bordure' "		// Balise marquant le début de la table
      . " CELLSPACING='$espCell' CELLPADDING='$remplCell' " 
      . $optionLargeur .  $optionClasse . ">\n";
 }
//===================================================================================
// TblFin			Ajoute la balise fin de table et déclenche un saut de ligne
//===================================================================================
 function TblFin ()
 {
  echo "</TABLE>\n";
 }
//===================================================================================
// TblDebutLigne	Fonction débutant une ligne
//					$classe permet de définir certaines options
//					Insère la balise de début de ligne <TR>
//===================================================================================
 function TblDebutLigne ($classe=-1)
 {
  $optionClasse = "";
  if ($classe != -1) $optionClasse = " CLASS='$classe'";
  echo "<TR" . $optionClasse . ">\n";
 } 
//===================================================================================
// TblFinLigne		Insère la balise de fin de ligne </TR>
//===================================================================================
 function TblFinLigne ()
 {
  echo "</TR>\n";
 }
//===================================================================================
// TblEntete
//===================================================================================
 function TblEntete ($contenu, $nbLig=1, $nbCol=1)
 {
  echo "<TH ROWSPAN='$nbLig' COLSPAN='$nbCol'>$contenu</TH>\n";
 }
//===================================================================================
// TblDebutCellule		Insère la balise de début de cellule <TD>
//===================================================================================
 function TblDebutCellule ($classe=-1)
 {
  $optionClasse = "";
  if ($classe != -1) $optionClasse = " CLASS='$classe'";
  echo "<TD" . $optionClasse . ">\n";
 }
//===================================================================================
// TblFinCellule		Insère la balise de fin de cellule </TD>
//===================================================================================
 function TblFinCellule ()
 {
  echo "</TD>\n";
 }
//===================================================================================
// TblCellule		Insère le contenu d'une cellule entre 2 balises
//					$contenu contenu à insérer
//					$nbLig nb de lignes occupées par la cellule (défaut = 1)
//					$nbCol nb de colonnes occupées par la cellule (défaut = 1)
//					$classe classe de présentation définie dans une feuille de style
//					ex:TblCellule("Bonjour",1,1,"CENTER");
//===================================================================================
 function TblCellule ($contenu, $nbLig=1, $nbCol=1, $classe=-1)
 {
  $optionClasse = "";
  if ($classe != -1)
  	$optionClasse = " CLASS=".$classe;

  echo "<TD ROWSPAN='$nbLig' COLSPAN='$nbCol' ".$optionClasse . ">$contenu</TD>\n";
 }
} // Fin du module Table
?>
