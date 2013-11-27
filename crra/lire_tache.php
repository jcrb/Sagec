<?php
/**
* lire_tache.php
* @author JCB
* @date    nov 2007
* @version $Id$
*/
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<HTML><HEAD><TITLE>lire_tache</TITLE>");
print("<LINK REL=stylesheet HREF=\"crra2.css\" TYPE =\"text/css\"></HEAD>");
print("<META NAME=\"author JCB\"> ");
//<comment> rafraichissement automatique toutes les 30 secondes </comment>
print("<meta http-equiv=\"refresh\" content=\"30\">");
print("</head>");

function getnom($id)
{
	global $connexion;
	$query = "SELECT nom, prenom FROM utilisateurs WHERE ID_utilisateur = '$id'";
	$result = ExecRequete($query,$connexion);
	$utilisateur = mySql_fetch_array($result);print($utilisateur[nom]);
	return $utilisateur;
}

print("<form name=\"lire_tache\" method=\"get\"action=\"\">") ;
$requete = "SELECT * FROM taches_crra ORDER BY statut,priorite";
$resultat = ExecRequete($requete,$connexion);
$now = date("Y-m-d H:i:s");
print("<table>") ;
	print("<tr>");
		print("<th>Date/heure</th>");
		print("<th>Attente</th>");
		print("<th>N° dossier</th>");
		print("<th width=\"10px\"> U </th>");
		print("<th>Instructions</th>");
		print("<th>Demandeur</th>");
		print("<th>Effecteur</th>");
		print("<th>Statut</th>");
		print("<th>Action</th>");
	print("</tr>");
while($rep=mySql_fetch_array($resultat))
{
	$texte =  "&nbsp;";
	if($rep['statut']=='0')
	{
		$delai =  round(date(strtotime($now)- strtotime($rep['first_time']))/60);	
		if($rep['priorite']==1)
			$bgcolor = "tomato";
		else if($rep['priorite']==2)
			$bgcolor = "gold";
		else if($rep['priorite']==3)
			$bgcolor = "palegoldenrod";
	}
	else 
	{
		$bgcolor="ivory";
		$delai =  round(date(strtotime($rep['last_time'])- strtotime($rep['first_time']))/60);
	}
		
	print("<tr bgcolor=\"$bgcolor\">") ;
		print("<td>".date("H:i:s",strtotime($rep['first_time']))."</td>");
		print("<td>".$delai."</td>");
		print("<td>".$rep['no_dossier']."</td>");
      print("<td>".$rep['priorite']."</td>");
      
      if($rep['vl'])
      {
      	$texte .= "Sortie VL";
      	if($rep['renfort'])
      	{
      		$texte .= " avec Renfort<br>";
      		if($rep['ar'])
      			$texte .= "Sortie AR<br>";
      	}
      	else $texte .= "<br>";
      }
      else if($rep['ar'])
      {
      	$texte .= "Sortie AR";
      	if($rep['renfort'])
      		$texte .= " avec Renfort<br>";
      }
      if($rep['d67'])
      {
      	$texte .= "Sortie D67";
      }
      
      /**
      *	SDIS
      */
      if($rep['fs'])
      {
      	$texte .= "Demande FS au CTA<br>";
      }
      if($rep['vsav'])
      {
      	$texte .= "Demande VSAV au CTA<br>";
      }
      if($rep['vlinf'])
      {
      	$texte .= "Demande VL INFIRMIER au CTA<br>";
      }
      if($rep['galien'])
      {
      	$texte .= "Demande GALIEN au CTA<br>";
      }
      /**
      *	AUTRES ENVOIS
      */
      if($rep['assu'])
      {
      	$texte .= "Envoi ASSU<br>";
      }
      if($rep['med'])
      {
      	$texte .= "Envoi MEDECIN LIBERAL<br>";
      }
      if($rep['pol'])
      {
      	$texte .= "Demande assistance POLICE<br>";
      }
      if($rep['vsp'])
      {
      	$texte .= "Envoi véhicule PREMIER SECOURS<br>";
      }
      /**
      *	ACTIONS REGULATEUR
      */
      if($rep['reg'])
      {
      	$texte .= "A REGULER<br>";
      }
      if($rep['bilan'])
      {
      	$texte .= "BILAN en attente<br>";
      }
      if($rep['complet'])
      {
      	$texte .= "DOSSIER INCOMPLET<br>";
      }
      if($rep['close'])
      {
      	$texte .= "Dossier à FERMER<br>";
      }
      if($rep['transfert'])
      {
      	$texte .= "Lancer TRANSFERT<br>";
      }
      if($rep['adm'])
      {
      	$texte .= " ? <br>";
      }
      
      /**
      *	Affichage des instructions
      */
      print("<td>".$texte."</td>");
      
      // demandeur
      $titre = getnom($rep['redacteur_ID']);
      $nom = $titre['nom'];
      print("<td>$nom</td>");
      // effecteur
      $titre = getnom($rep['effecteur_ID']);
      $nom = $titre['nom'];
       print("<td>$nom</td>");
      //statut
      if($rep['statut']=='0')
      	print("<td> A FAIRE </td>");
      else
      	print("<td> Fait </td>");
      // action
      print("<td><a href=\"traiter_tache.php?tache=$rep[tache_ID]\">traiter</a></td>");
        
	print("</tr>") ;
}
print("</table>") ;
print("</form>") ;
print("</html>") ;
?>