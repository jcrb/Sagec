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
	print("<title>titre évocateur</title>");
	print("<meta http-equiv=\"Content-type\" content=\"text/html; charset = iso-8859-15\" />");
	print("<meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />");
	print("<meta http-equiv=\"Content-Language\" content=\"fr\" />");
	print("<link rel=\"stylesheet\" type=\"text/css\" href=\"style1.css\">");// compléter avec l'adresse de la feuille de style
print("</head>");

print("<body>");
	print("<div id=\"conteneur\">");
		print("<h1 id=\"header\"><a><span>Communes</span></a></h1>");

		print("<ul id=\"menu\">");
			print("<li><a href=\"commune_nouvelle.php\">Nouvelle </a></li>");
			print("<li><a href=\"commune_listing.php\">Liste</a></li>");
			print("<li><a href=\"commune_cherche.php\">Cherche</a></li>");
			print("<li><a href=\"../moyens_commune.php\">Retour</a></li>");
		print("</ul>");
	print("</div>");
print("</body>");
?>