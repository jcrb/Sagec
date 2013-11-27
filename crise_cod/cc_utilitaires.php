<?php
/**
  *	cc_utilitaires.php
  *
  */
  
//=============================================================================
//	SelectFonction()
//	Crée une liste déroulante avec la liste des fonctions de la cellule de crise
//			$connexion 		variable de connexion
//			$item_select	fonction_ID de l'organisme sélectionné
//			Au retour, fonction_id contient le type_ID de la fonction
//=============================================================================
function SelectFonction($connexion,$item_select,$change=NULL) //fonction_id
{
	$requete="SELECT tache_fonction_ID, tache_fonction_nom FROM tache_fonction ORDER BY tache_fonction_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"fonction_id\" size=\"1\" onchange=\"$change\">");
	$mot="Inconnue";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[tache_fonction_ID]\" ");
		if($item_select == $rub['tache_fonction_ID']) print(" SELECTED");
		print(">".$rub['tache_fonction_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n"); 
} 
?>