<?php
// header.php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require '../utilitaires/globals_string_lang.php';
include("../utilitaires/table.php");
include("../utilitairesHTML.php");

print("<!DOCTYPE html PUBLIC \"-//W3C/DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">");
print("<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\">");

print("<head>");
	print("<title>titre �vocateur</title>");
	print("<meta http-equiv=\"Content-type\" content=\"text/html; charset = iso-8859-15\" />");
	print("<meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />");
	print("<meta http-equiv=\"Content-Language\" content=\"fr\" />");
	print("<link rel=\"stylesheet\" type=\"text/css\" href=\"style1.css\">");// compl�ter avec l'adresse de la feuille de style
print("</head>");
/*
print("<body>");
	print("<div id=\"conteneur\">");		
		print("<h1 id=\"header\"><a><span>Structures temporaires</span></a></h1>");

		print("<ul id=\"menu\">");
			print("<li><a href=\"structure_temp.php\">Nouvelle structure</a></li>");
			print("<li><a href=\"ListeTemp_Structure.php\">Liste des structures</a></li>");
			print("<li><a href=\"InsertUpdateTemp_structure.php\">Insert / Update</a></li>");
			print("<li><a href=\"../sagec67.php\">Retour</a></li>");
		print("</ul>");
	print("</div>");
print("</body>");
*/
?>