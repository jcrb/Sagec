<?php
/**
* traiter_tache.php
* @author JCB
* @date    nov 2007
* @version $Id$
*/
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$erreur = 0;
$tache = $_REQUEST['tache']; // tache à modifier

print("<HTML><HEAD><TITLE>lire_tache</TITLE>");
print("<LINK REL=stylesheet HREF=\"crra2.css\" TYPE =\"text/css\"></HEAD>");
print("</head>");

print("<form name=\"traiter_tache\" method=\"post\"action=\"maj_tache.php\">") ;
print("<input type=\"hidden\" name=\"order\" value=\"$tache\">");
$requete = "SELECT * FROM taches_crra WHERE tache_ID = '$tache'";
$resultat = ExecRequete($requete,$connexion);
$rep=mySql_fetch_array($resultat);

print("<table>") ;
	print("<tr>");
		print("<th>N° dossier</th>");
		print("<th width=\"10px\"> U </th>");
		print("<th>Instructions</th>");
		print("<th>Statut</th>");
		print("<th>Action</th>");
	print("</tr>");

	$texte =  "&nbsp;";
	print("<tr>") ;
		print("<td>".$rep['no_dossier']."</td>");
      print("<td>".$rep['priorite']."</td>");
      if($rep['vl'])
      {
      	$texte .= "Sortie VL";
      	if($rep['renfort'])
      		$texte .= " avec Renfort<br>";
      }
      if($rep['ar'])
      {
      	$texte .= "Sortie AR";
      	if($rep['renfort'])
      		$texte .= " avec Renfort<br>";
      }
      if($rep['d67'])
      {
      	$texte .= "Sortie D67";
      }
      print("<td>".$texte."</td>");
      // statut
      if($rep['statut']=='0')
      {
      	print("<td> A FAIRE </td>");
      	print("<td><input type=\"submit\" name=\"ok\" value=\"Tache faite\"</td>");
      	print("<td><input type=\"submit\" name=\"ok\" value=\"Modifier\"</td>");
      }
      else
      {
      	print("<td> Fait </td>");
      	print("<td><input type=\"submit\" name=\"ok\" value=\"Supprimer\"</td>");
      }
      // action
      print("<td><input type=\"submit\" name=\"ok\" value=\"Annuler\"</td>");
        
	print("</tr>") ;

print("</table>") ;
print("</form>") ;

?>