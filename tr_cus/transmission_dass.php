<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//
//----------------------------------------- SAGEC ---------------------------------------------//
//
//	programme: 		transmission_dass.php
//	date de cr?ation: 	23/10/2004
//	auteur:			jcb
//	description:		Envoi la tbleau de sortie des ASSU par mail à la DASS sous forme d'un
//					fichier joint.
//	version:			1.0
//	maj le:			23/04/2004
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include "../libmail.php";

print("<html>");
print("<head>");
print("<title>DASS </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");
print("<form name=\"mail\" method=\"get\" ACTION=\"imprime_dass.php\">");
//print("<form name=\"mail\" method=\"get\" ACTION=\"transmission_dass.php\">");

function sendmail($file)
{
	$m= new Mail; // create the mail
	$m->From( "SAGEC67" );
	$m->To( "jcb-bartier@wanadoo.fr" );
	$m->Subject( "the subject of the mail" );

	$message= "Hello world!\nthis is a test of the Mail class\nplease ignore\nThanks.";
	$m->Body( $message);	// set the body
	//$m->Cc( "someone@somewhere.fr");
	//$m->Bcc( "someoneelse@somewhere.fr");
	$m->Priority(4) ;	// set the priority to Low
	//$m->Attach( "$file", "text" ) ;	// attach a file of type image/gif
	$m->Send();	// send the mail
	echo "the mail below has been sent:<br><pre>", $m->Get(), "</pre>";
}

function create_file($date,$resultat)
{
	$file = "AssuCUS_".$date.".txt";
	$fp = fopen($file,"w");
	while($rub=mysql_fetch_array($resultat))
	{
		$chaine = $rub[date]."\t".$rub[dossier]."\t".$rub[org_nom]."\t";
		if($rub[dispo]=='o')
			$chaine .= "disponible";
		else
			$chaine .= "indisponible";
		$chaine .= "\n";
		$ligne = fputs($fp,$chaine);
	}
	fclose($fp);
	return $file;
}

function imprime($resultat, $date)
{
	print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style24\">");
	print("<tr>");
	print("<TD> SAMU 67 - Centre 15 du Bas-Rhin</td>");
	$d = date("Y-m-d");
	print("<TD class=\"DROITE\"> $d </td>");
	print("</tr>");
	print("<tr>");
	print("<TD>Hôpitaux Universitaires de Strasbourg</td>");
	print("<TD class=\"DROITE\"> Tour de rôle des ASSU sur la CUS </td>");
	print("</tr>");
	print("<tr>");
	print("<TD>&nbsp;</td>");
	$j = explode("-",$date);
	$d = $j[2]."/".$j[1]."/".$j[0];
	print("<TD class=\"DROITE\"> Journée du $d </td>");
	print("</tr>");
	print("</table>");

	print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<tr>");
		print("<td>$rub[date]</td>");
		print("<td align=\"right\">$rub[dossier]</td>");
		print("<td>$rub[org_nom]</td>");
		if($rub[dispo]=='o')
			$chaine = "disponible";
		else
			$chaine = "indisponible";
		print("<td>$chaine</td>");
		print("</tr>");
	}
	print("</table>");
}

if($_GET["ok"])
{
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$d = $_GET[date]."%";
	$requete = "SELECT date,dossier,dispo,org_nom
			FROM apa_tour_enregistre,organisme
			WHERE organisme.org_ID = apa_tour_enregistre.org_ID
			AND date LIKE '$d'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete);
	//$file=create_file($_GET[date],$resultat);
	//sendmail($file);
	imprime($resultat,$date);
}

$d = date("Y-m-d");
print("Journée à transmettre <input type=\"text\" name=\"date\" value=\"$d\">");
print("<input type=\"submit\" name=\"ok\" value=\"envoyer\">");
print("</form>");
print("</body>");
print("</html>");
?>
