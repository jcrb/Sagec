<?php
//----------------------------------------- SAGEC ------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//------------------------------------------------------------------------------
/** 
*	teste_page.php
* 	teste affichage limité à qq lignes
*	date de création: 		 
*	@author:			jcb		  
*	@version:	$Id$	 
*	maj le:				
*	@package			sagec
*/
//------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("uf_utilitaires.php");
$langue = $_SESSION['langue'];
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
	print("<title>page_test</title>");
	print("<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />");
	print("<link href=\"uf.css\" rel=\"stylesheet\" type=\"text/css\" />");
print("</head>");

print("<body>");
echo '<form action="'.$page.'" method="get">';

$nombre = 25;  // on va afficher 5 résultats par page.
// récupération du nom de la page   
$path_parts = pathinfo($_SERVER['PHP_SELF']);
$page = $path_parts['basename'];

// nb enregistrements dans la table
$requete = "SELECT COUNT(uf_ID) FROM uf";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
$total= $rub['0'];
$nb_page = ceil($total/$nombre);

if($_REQUEST['btn']==' >> ')
{
	$limite = $total - $total % $nombre;
	$page_courante  = $nb_page;
}

else if($_REQUEST['btn']==' > ')
{
	$limite = $_REQUEST['limite2'];
	$page_courante  = $_REQUEST['page_courante'] + 1;
}
else if($_REQUEST['btn']==' < ')
{
	$limite = $_REQUEST['limite1'];
	$page_courante  = $_REQUEST['page_courante'] - 1;
}
else
{
	$limite = 0; // si on arrive sur la page pour la première fois, on met limite à 0.
	$page_courante = 1;
}

print("<div id=\"formtitle\">Unités Fonctionelles - Mise à jour</div>");

print("<div id=\"content\">");
print("<fieldset id=\"coordonnees\">");
print("<legend> UF Id $rub[uf_ID]</legend>");

$requete = 'select * FROM uf ORDER BY uf_code ASC limit '.$limite.','.$nombre;
$resultat = ExecRequete($requete,$connexion);
print("<table>");
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td>$rub[uf_ID]</td>");
		print("<td>$rub[uf_code]</td>");
		print("<td>$rub[uf_nom]</td>");
		print("<td><a href=\"uf_create.php?ufID=$rub[uf_ID]\">modifier</td>");
	print("</tr>");
}
print("</table>");
print("</legend>");
print("</div>");

$limitesuivante = $limite + $nombre;
$limiteprecedente = $limite - $nombre;

print("<div id=\"formfooter\" align=\"center\">");
print("<p>");			
print("<table class=\"curseur\" >");//border-color:none;
print("<tr>");
	print("<td class=\"curseur\">");
		echo '<input type="submit" value=" << " name="btn">';
	print("</td>");
	print("<td class=\"curseur\">");
		if($limite != 0) 
		{
    		echo '<input type="submit" value=" < " name="btn">';
    		echo '<input type="hidden" value="'.$limiteprecedente.'" name="limite1">';
    		echo '<input type="hidden" value="'.$page_courante.'" name="page_courante">';
		}
		else print("&nbsp;");
	print("</td>");
	print("<td class=\"curseur\">");
		print($page_courante." / ".$nb_page);
	print("</td>");
	print("<td class=\"curseur\">");
		if($limitesuivante < $total)
		{
    		echo '<input type="submit" value=" > " name="btn">';
    		echo '<input type="hidden" value="'.$limitesuivante.'" name="limite2">';
    		echo '<input type="hidden" value="'.$page_courante.'" name="page_courante">';                
		}
		else print("&nbsp;");
	print("</td>");
	print("<td class=\"curseur\">");
		echo '<input type="submit" value=" >> " name="btn">';
	print("</td>");
print("</tr>");
print("</table>");
print("</p>");
print("</div>");

echo '</form>';

print("</body>");
print("</html>");
?>
