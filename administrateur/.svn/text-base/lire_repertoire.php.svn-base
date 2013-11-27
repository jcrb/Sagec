<?php
/**
 * Lit et affiche le contenu d'un dossier
 * @package Sagec
 * @author JCB
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//lire ce dossier en choisissant
//les dossiers (is_dir) ou les fichiers (is_file)
?>
<script language="JavaScript">
function confirm_entry(filename)
{
	input_box=confirm("Are you sure you want to delete " + filename + " ?");
}
</script>
<?php

/**
* formate une date UNIX eu format j/m/a h:m:s
* @var $date date Unix
* @return date formatée
*/
function dd($date)
{
   return date("d/m/Y H:i:s",$date);
}

print("<form name=\"lire_repertoire\" action=\"lire_repertoire.php\">");
print("nom du répertoire à lire: <input type=\"text\" name=\"repertoire\" size=\"60\" value=\"$_REQUEST[repertoire]\">");
print(" <input type=\"submit\" name=\"valider\" value=\"ok\">");

if(isset($_REQUEST['delete']))
{
	$fichier= str_replace('//','/',$_REQUEST['fichier']);
	print($fichier."<br>");
	//chmod($fichier,777);
	unlink($fichier);
	$_REQUEST['delete']=false;
	$_REQUEST['valider']=='ok';
}
elseif($_REQUEST['valider']=='ok')
{
	//Obtenir un pointeur vers le dossier qui nous intéresse
	$prefix = "../";
	$repertoire = $_REQUEST['repertoire']."/";// on récupère le nom et on ajoute un slash terminal mon_repertoire/
	$rep = $prefix.$repertoire; // ../mon_repertoire/
	if(!$dir = @opendir($rep))
	{
		print("<br><b> Ce dossier n'existe pas. Vérifiez l'ortographe </b><br>");
	}
else
{
	print("<br> Contenu du répertoire ".$rep."<br>");
	print("dir = ".$dir."<br>");
	print("<table border=\"1\" cellspacing=\"0\" cellpadding=\"3\">");
	print("<tr>");
		print("<td>Nom</td>");
		print("<td>Taille (octets)</td>");
		print("<td>Création</td>");
		print("<td>Modification</td>");
		print("<td>Dernier accès</td>");
		print("<td>&nbsp;</td>");
		print("<td>&nbsp;</td>");
	print("</tr>");
	while ($f = readdir($dir))
	{
   		if(is_file($rep.$f))
   		{
   			print("<tr>");
      			print("<td>".$f."</td>");
      			print("<td>".filesize($rep.$f)."</td>");
      			print("<td>".dd(filectime($rep.$f))."</td>");
      			print("<td>".dd(filemtime($rep.$f))."</td>");
      			print("<td>".dd(fileatime($rep.$f))."</td>");
				$file = $rep.$f;
		print("<td><a href=\"lire_repertoire.php?delete=true&fichier=$file&repertoire=$repertoire\" onclick=\"javascript:confirm_entry('$file')\">supprimer</a></td>");
		
				print("<td><a href=\"export_fichier_sagec_execute.php?fichier=$file&ok=true\">exporter</a></td>");
	 		print("</tr>");
   		}
		elseif(is_dir($rep.$f))
   		{
			print("<tr>");
				$nom_complet=$repertoire.$f."/";
      			print("<td><b><a href=\"lire_repertoire.php?repertoire=$nom_complet&valider=ok\">".$f."</a></b></td>");
				print("<td>"."répertoire"."</td>");
				print("<td>"."&nbsp;"."</td>");
				print("<td>"."&nbsp;"."</td>");
				print("<td>"."&nbsp;"."</td>");
				print("<td>"."&nbsp;"."</td>");
			print("</tr>");
		}
	}
	print("</table>");
	//enfin fermer le dossier
 	closedir($dir);
}
}
print("</form>");
?>