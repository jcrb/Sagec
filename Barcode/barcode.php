<?php


print("<html>");
print("<head>");
print("<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-15\">");
print("</head>");

print("<body>");
print("<form name = \"barcode\" action=\"barcode.php\" method=\"get\" enctype=\"text/plain\">");
print("<table cellpadding=\"2\" cellspacing=\"2\" border=\"0\" frame=\"\" rules=\"\">");
$max_etiquette = 15;

if($_REQUEST['ok']=='Valider')
{
	$id = $_REQUEST['id'];
	$val = $_REQUEST['val'];
}

print("<tr>");
	print("<th bgcolor=\"#FFA500\" width=\"15\">Identifiant</th>");
	print("<th bgcolor=\"#FFA500\">Valeur (max.12 caractères)</th>");
	print("<th bgcolor=\"#FFA500\">Code barre</th>");
print("</tr>");
	for($i=0; $i<$max_etiquette;$i++)
	{
		print("<tr>");
			print("<td><input type=\"text\" name=\"id[]\" value=\"$id[$i]\"></td>");
			print("<td align=\"center\"><input type=\"text\" name=\"val[]\" value=\"$val[$i]\" maxlength=\"13\"></td>");
			if($val[$i])
			{
				$code = substr("000000000000".$val[$i],-12);
				print("<TD align=\"center\"><IMG SRC=\"code_barre_fabrique.php?ean=$code&largeur=130&hauteur=45\"></TD>");
			}
		print("</tr>");
	} /* fin de boucle*/ 
print("</table>");
print("<input type=\"submit\" name=\"ok\" value=\"Valider\">");
print("</form>");
print("</body>");
print("</html>");

?>
