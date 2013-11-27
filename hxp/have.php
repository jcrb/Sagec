<?php
// création d'un document XML au format HAVE
// have.php

include ('../utilitaires/stack.php');

print("<?xml version = \"1.0\" encoding=\"ISO-8859-1\" ?>");
$normal = 0;
$number = 0;
$texte = "";
$msg = "<hospitalStatus>";
	$msg .= "<hospital>";
		$msg .= "<organizationID>"."123"."</organizationID>";//n°finess
		$msg .= "<organizationName>"."HUS-Hôpital Civil"."</organizationName>";
		$msg .= "<organizationTypeText>"."CHU"."</organizationTypeText>";
		$msg .= "<organizationLocation>"."1 place de lhôpital 67092 Strasbourg Cedex"."</organizationLocation>";
		$msg .= "<emergencyDepartementreport>";
			$msg .= "<emsTraffic>";
				$msg .= "<status>"."Normal"."</status>";		//ems_status
				$msg .= "<reason>"."---"."</reason>";			// ems_reason
				$msg .= "<commentText>"."no comment"."</commentText>";	//ems_comment
			$msg .= "</emsTraffic>";
			$msg .= "<capacity>";
				$msg .= "<triageRed>"."5"."</triageRed>";		//ems_capacity_red
				$msg .= "<triageYellow>"."10"."</triageYellow>";	//ems_capacity_yellow
				$msg .= "<triageGreen>"."20"."</triageGreen>";		//ems_capacity_green
				$msg .= "<triageBlack>"."9"."</triageBlack>";		//ems_capacity_black
				$msg .= "<commentText>"."no comment"."</commentText>";	//ems_capacity_comment
			$msg .= "</capacity>";
			$msg .= "<census>";
				$msg .= "<triageRed>"."1"."</triageRed>";		//ems_census_red
				$msg .= "<triageYellow>"."2"."</triageYellow>";	//ems_census_yellow
				$msg .= "<triageGreen>"."3"."</triageGreen>";	//ems_census_green
				$msg .= "<triageBlack>"."0"."</triageBlack>";	//ems_census_black
				$msg .= "<commentText>"."no comment"."</commentText>";	//ems_census_comment
			$msg .= "</census>";
			$msg .= "<emsOffload>";
				$msg .= "<status>".$normal."</status>";			//ems_offload_capacity
				$msg .= "<minutes>".$number."</minutes>";		//ems_offload_minutes
				$msg .= "<commentText>".$texte."</commentText>";	//ems_offload_comment
			$msg .= "</emsOffload>";
		$msg .= "</emergencyDepartementreport>";
		$msg .= "<hospitalBedCapacity>";
			$msg .= "<adultICU>";
				$msg .= "<status> avaible/notAvailable </status>";					//adult_icu_status
				$msg .= "<avaibleCount> avaible/notAvailable </avaibleCount>";				//adult_icu_count
				$msg .= "<baselineCount>".$number."</baselineCount>";					//adult_icu_baseline
				$msg .= "<additionalCapacityCount24Hr>".$number."</additionalCapacityCount24Hr>";	//adult_icu_24h
				$msg .= "<additionalCapacityCount72Hr>".$number."</additionalCapacityCount72Hr>";	//adult_icu_72h
				$msg .= "<subCategoryBedCapacity> </subCategoryBedCapacity>";
				$msg .= "<commentText>".$texte."</commentText>";					//adult_icu_comment
			$msg .= "</adultICU>";
			$msg .= "<medicalSurgical>";
				$msg .= "<status> avaible/notAvailable </status>";					//medSurg_status
				$msg .= "<avaibleCount> avaible/notAvailable </avaibleCount>";				//medSurg_count
				$msg .= "<baselineCount>".$number."</baselineCount>";					//medSurg_baseline
				$msg .= "<additionalCapacityCount24Hr>".$number."</additionalCapacityCount24Hr>";	//medSurg_24h
				$msg .= "<additionalCapacityCount72Hr>".$number."</additionalCapacityCount72Hr>";	//medSurg_72h
				$msg .= "<subCategoryBedCapacity> </subCategoryBedCapacity>";
				$msg .= "<commentText>".$texte."</commentText>";					//medSurg_comment
			$msg .= "</medicalSurgical>";
			$msg .= "<burn>";
				$msg .= "<status> avaible/notAvailable </status>";					//burn_status
				$msg .= "<avaibleCount> avaible/notAvailable </avaibleCount>";				//burn_count
				$msg .= "<baselineCount>".$number."</baselineCount>";					//burn_baseline
				$msg .= "<additionalCapacityCount24Hr>".$number."</additionalCapacityCount24Hr>";	//burn_24h
				$msg .= "<additionalCapacityCount72Hr>".$number."</additionalCapacityCount72Hr>";	//burn_72h
				$msg .= "<subCategoryBedCapacity> </subCategoryBedCapacity>";
				$msg .= "<commentText>".$texte."</commentText>";					//burn_comment
			$msg .= "</burn>";
			$msg .= "<pediatricICU>".$number."</pediatricICU>";			//ped_icu_count
			$msg .= "<pediatrics>".$number."</pediatrics>";				//ped_count
			$msg .= "<psychiatric>".$number."</psychiatric>";			//psy_count
			$msg .= "<negativeFlowIsolation>".$number."</negativeFlowIsolation>";	//peneg_count
			$msg .= "<otherIsolation>".$number."</otherIsolation>";			//isolation_count
			$msg .= "<operatingRooms>".$number."</operatingRooms>";			//oproom_count
			$msg .= "<commentText>".$texte."</commentText>";			//bed_capacity_comment
		$msg .= "</hospitalBedCapacity>";
		
		$msg .= "<serviceCoverage>";
			$msg .= "<cardiology> avaible/notAvailable </cardiology>";		//cardio_status
			$msg .= "<neonatalogy> avaible/notAvailable </neonatalogy>";		//neonat_status
			$msg .= "<neurology> avaible/notAvailable </neurology>";		//neuro_status
			$msg .= "<neurology> avaible/notAvailable </neurology>";		//neuro_status
			$msg .= "<obgyn> avaible/notAvailable </obgyn>";			//obgyn_status
			$msg .= "<facialSurgery> avaible/notAvailable </facialSurgery>";	//maxillo_status
			$msg .= "<orthopedic> avaible/notAvailable </orthopedic>";		//orthop_status
			$msg .= "<psychiatric> avaible/notAvailable </psychiatric>";		//psy_status
			$msg .= "<generalSurgery> avaible/notAvailable </generalSurgery>";	//genchir_status
			$msg .= "<commentText>".$texte."</commentText>";			//service_overage_comment
		$msg .= "</serviceCoverage>";
		
		$msg .= "<hospitalFacilityStatus>";
			$msg .= "<eocStatus> active/inactive </eocStatus>";			//eoc_status
			$msg .= "<eocPlan> active/inactive </eocPlan>";				//eoc_plan
			$msg .= "<clinicalStatus> active/inactive </clinicalStatus>";		//clinical_status
			$msg .= "<deconCapacity> active/inactive </deconCapacity>";		//decon_status
			$msg .= "<morgueCapacity> active/inactive </morgueCapacity>";		//morgue_status
			$msg .= "<facilityStatus> active/inactive </facilityStatus>";		//facility_status
			$msg .= "<securityStatus> active/inactive </securityStatus>";		//security_status
			$msg .= "<staffing> active/inactive </staffing>";			//staff_status
			$msg .= "<facilityOps> active/inactive </facilityOps>";			//facility_ops_status
			$msg .= "<clinicalOps> active/inactive </clinicalOps>";			//clinical_ops_status
			$msg .= "<commentText>".$texte."</commentText>";			//facility_status_comment
		$msg .= "</hospitalFacilityStatus>";
		
		$msg .= "<genericEntityStatus>";
			$msg .= "<ventilators>";
				$msg .= "<id></id>";
				$msg .= "<observation>";
					$msg .= "<observationName>Osiris 2</observationName>";
					$msg .= "<value>30</value>";
				$msg .= "</observation>";
			$msg .= "</ventilators>";
		$msg .= "</genericEntityStatus>";
		
		$msg .= "<massdecon>";
				$msg .= "<status> active/inactive </status>";			//mass_decon_status
		$msg .= "</massdecon>";
		
		$msg .= "<commentText>";
		$msg .= "</commentText>";
		
		$msg .= "<lastUpdateText>";
		$msg .= "</lastUpdateText>";
		
	$msg .= "</hospital>";
$msg .= "</hospitalStatus>";

$fp = fopen("have.xml", 'w+');
fputs($fp, $msg);
fclose($fp);
        
echo 'Export XML effectue !<br><a href="have.xml">Voir le fichier</a>';

// Création d'un document XML vide
$doc_xml_vide = domxml_new_xmldoc("1.0");

// Création du noeud racine pour le document XML
$ref_racine = domxml_add_root($doc_xml_vide, "element_racine");

// Création d'un enfant du noeud racine
$ref_enfant = domxml_new_child($ref_racine,"element_enfant", "valeur du noeud");

// Création d'un attribut pour le noeud enfant
$ref_attribut = domxml_set_attribute($ref_enfant, "nom_attribut", "valeur de l'attribut");

$doc_xml_vide->dump_file('carnetMysqlToXmlWithDom.xml');
echo 'Export XML effectue !<br><a href="carnetMysqlToXmlWithDom.xml">Voir le fichier</a><br>';

# /*
//EXPORTER UNE TABLE MYSQL VERS UN FICHIER XML AVEC DOMXML
# * Penser à ouvrir une connexion vers la base mysql
# * Ecrire une requête ($q) pour récupérer les données de la table
# */
#  
#     if ($q) {
#         $doc = domxml_new_doc('1.0');
#         $node = $doc->create_element('carnet');
#         $carnet = $doc->append_child($node);
#  
#         while ($row = mysql_fetch_array($q)) {
#             $node = $doc->create_element('personne');
#             $personne = $carnet->append_child($node);
#             
#             $node = $doc->create_element('nom');
#             $tmpNode = $personne->append_child($node);
#             $value = $doc->create_text_node($row['nom']);
#             $tmpNode->append_child($value);
#             
#             $node = $doc->create_element('prenom');
#             $tmpNode = $personne->append_child($node);
#  
#             $value = $doc->create_text_node($row['prenom']);
#             $tmpNode->append_child($value);
#             
#             $node = $doc->create_element('age');
#             $tmpNode = $personne->append_child($node);
#             $value = $doc->create_text_node($row['age']);
#             $tmpNode->append_child($value);
#         }
#         
#         $doc->dump_file('carnetMysqlToXmlWithDom.xml');
#         echo 'Export XML effectue !<br><a href="carnetMysqlToXmlWithDom.xml">Voir le fichier</a>';
#     }


/*
PARSER UN FICHIER XML AVEC DOMXML ET LE METTRE EN FORME AVEC XSLT
   1. - carnet.xml :
   2.  
   3. <?xml version="1.0" encoding="ISO-8859-1"?>
   4. <carnet>
   5.     <personne>
   6.         <nom>DUPONT</nom>
   7.         <prenom>Pierre</prenom>
   8.         <age>17</age>
   9.     </personne>
  10.     <personne>
  11.         <nom>DUPONT</nom>
  12.         <prenom>Jacky</prenom>
  13.         <age>46</age>
  14.     </personne>
  15.     <personne>
  16.         <nom>DUPONT</nom>
  17.         <prenom>René</prenom>
  18.         <age>23</age>
  19.     </personne>
  20. </carnet>
  21.  
  22. - carnet.xsl :
  23.  
  24. <?xml version="1.0" encoding="ISO-8859-1"?>
  25. <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  26. <xsl:output method="html" indent="no"/>
  27. <xsl:template match="/">
  28.     <html>
  29.         <head>
  30.             <meta name="author" content="orion"/>
  31.             <style type="text/css">
  32.             .bg-0 { background-color: #efefff; }
  33.             .bg-1 { background-color: #efffef; }
  34.             </style>
  35.         </head>
  36.         <body bgcolor="white" text="black">
  37.         <table><xsl:apply-templates match="carnet"/></table>
  38.         </body>
  39.     </html>
  40. </xsl:template>
  41.  
  42. <xsl:template match="carnet">
  43.     <xsl:for-each select="personne">
  44.         <tr class="bg-{position() mod 2}">
  45.             <td>Nom: <xsl:value-of select="nom"/></td>
  46.             <td>Prenom: <xsl:value-of select="prenom"/></td>
  47.             <td>Age: <xsl:value-of select="age"/> ans</td>
  48.         </tr>
  49.     </xsl:for-each>
  50. </xsl:template>
  51. </xsl:stylesheet>
  52.  
  53.  
  54. - carnet.php :
  55.  
  56. <?php
  57. $xml = domxml_open_file('carnet.xml');
  58. $xsl = domxml_xslt_stylesheet_file('carnet.xsl');
  59. $html = $xsl->process($xml);
  60. echo $html->dump_mem();
  61. ?>
  */
  
  // Parser XML
  $file = "have.xml";
  global $deep;
  $stack = new Stack();
  
  // cat en cas de balise ouvrante
  function balise_ouvrante($parser,$name,$attr)
  {
  	global $balise_courante;
	global $deep;
	global $stack;
	
	$deep++;
	$balise_courante = $name;
	$stack->push($balise_courante);
	$stack->write_stack();
	print($deep.'<br>');
  }
  // cat en cas de balise fermante
  function balise_fermante($parser,$name)
  {
  	global $deep;
	global $stack;
	global $balise_courante;
	
	$deep--;
	$element = $stack->pop();// dépile le dernier élémment
	$balise_courante = $stack->top();
	$stack->write_stack();
	print($deep.'<br>');
  }
  // cat avec le texte compris entre 2 balises
  function texte($parser, $data)
  {
  	global $balise_courante;
	global $hop;
	global $fp;
	global $stack;
	
	switch($balise_courante)
	{
		case "ORGANIZATIONID": $Hop_ID = $data;$hop[$Hop_ID]['id'] = $data;break;
		case "ORGANIZATIONNAME": $hop[$Hop_ID]['nom'] = $data;break;
		case strtoupper("organizationTypeText"): $hop[$Hop_ID]['type'] = $data;break;
		case strtoupper("status"):
			if($stack->get_element(3)==strtoupper("emsTraffic")) $hop[$Hop_ID]['ems_status'] = $data;break; 
		case strtoupper("reason"):
			if($stack->get_element(3)==strtoupper("emsTraffic")) $hop[$Hop_ID]['ems_reason'] = $data;break;
		case strtoupper("commentText"):
			if($stack->get_element(3)==strtoupper("emsTraffic")) $hop[$Hop_ID]['ems_comment'] = $data;break;
			if($stack->get_element(3)==strtoupper("capacity")) $hop[$Hop_ID]['ems_capacity_comment'] = $data;break;
			if($stack->get_element(3)==strtoupper("census")) $hop[$Hop_ID]['ems_census_comment'] = $data;break;
		case strtoupper("triageRed"):
			if($stack->get_element(3)==strtoupper("capacity")) $hop[$Hop_ID]['ems_capacity_red'] = $data;break;
			if($stack->get_element(3)==strtoupper("census")) $hop[$Hop_ID]['ems_census_red'] = $data;break;
		case strtoupper("triageYellow"):
			if($stack->get_element(3)==strtoupper("capacity")) $hop[$Hop_ID]['ems_capacity_yellow'] = $data;break;
			if($stack->get_element(3)==strtoupper("census")) $hop[$Hop_ID]['ems_census_yellow'] = $data;break;
		case strtoupper("triageGreen"):
			if($stack->get_element(3)==strtoupper("capacity")) $hop[$Hop_ID]['ems_capacity_green'] = $data;break;
			if($stack->get_element(3)==strtoupper("census")) $hop[$Hop_ID]['ems_census_green'] = $data;break;
		case strtoupper("triageBlack"):
			if($stack->get_element(3)==strtoupper("capacity")) $hop[$Hop_ID]['ems_capacity_black'] = $data;break;
			if($stack->get_element(3)==strtoupper("census")) $hop[$Hop_ID]['ems_census_black'] = $data;break;
	}
  }
  function defaut()
  {
  	return true;
  }
  function set_handlers($parser)
  {
  	xml_set_element_handler($parser,'balise_ouvrante','balise_fermante');
	xml_set_default_handler($parser,'defaut');
	xml_set_character_data_handler($parser,'texte');
  }
    /**
    * Lit une ligne du fichier XML.
    * @params handle le perseur.
    * @params array les données lues.
    * @params handle le fichier.
    */
  function lit_une_ligne($parser, $data,$fp)
  {
  	if (!xml_parse($parser, $data, feof($fp)))
    	{
        	die(sprintf("erreur XML: %s à la ligne %d",
                  xml_error_string(xml_get_error_code($parser)),
                  xml_get_current_line_number($parser)));
    	}
 }
  
  // main
  $deep = 0;
  global $fp;
  $parser = xml_parser_create();
  //xml_parser_set_option($parseur, XML_OPTION_CASE_FOLDING);
  set_handlers($parser);
  if (!($fp = fopen($file, "r"))) {die("could not open XML input");}
  while ($data = fread($fp, 4096)) 
  {
  	lit_une_ligne($parser, $data,$fp);
	/*
    if (!xml_parse($parser, $data, feof($fp)))
    {
        die(sprintf("erreur XML: %s à la ligne %d",
                  xml_error_string(xml_get_error_code($parser)),
                  xml_get_current_line_number($parser)));
    }*/
}
xml_parser_free($parser);

global $hop;
print_r($hop);

print("<table>");
print("<tr>");
	print("<td>hopital</td>");
	print("<td>".$hop[$Hop_ID]['nom']."</td>");
print("</tr>");
print("<tr>");
	print("<td>type d'hôpital</td>");
	print("<td>".$hop[$Hop_ID]['type']."</td>");
print("</tr>");
print("<tr>");
	print("<td>Status des urgences</td>");
	print("<td>".$hop[$Hop_ID]['ems_status']."</td>");
	print("<td>motif</td>");
	print("<td>".$hop[$Hop_ID]['ems_reason']."</td>");
	print("<td>commentaires</td>");
	print("<td>".$hop[$Hop_ID]['ems_comment']."</td>");
print("</tr>");
print("<tr>");
	print("<td>&nbsp;</td>");
	print("<td>&nbsp;</td>");
	print("<td>capacité</td>");
	print("<td>UA</td>");
	print("<td>".$hop[$Hop_ID]['ems_capacity_red']."</td>");
	print("<td>UR</td>");
	print("<td>".$hop[$Hop_ID]['ems_capacity_yellow']."</td>");
	print("<td>Eclopés</td>");
	print("<td>".$hop[$Hop_ID]['ems_capacity_green']."</td>");
	print("<td>DCD</td>");
	print("<td>".$hop[$Hop_ID]['ems_capacity_black']."</td>");
	print("<td>commentaire</td>");
	print("<td>".$hop[$Hop_ID]['ems_capacity_comment']."</td>");
print("</tr>");
print("<tr>");
	print("<td>&nbsp;</td>");
	print("<td>&nbsp;</td>");
	print("<td>status actuel</td>");
	print("<td>UA</td>");
	print("<td>".$hop[$Hop_ID]['ems_census_red']."</td>");
	print("<td>UR</td>");
	print("<td>".$hop[$Hop_ID]['ems_census_yellow']."</td>");
	print("<td>Eclopés</td>");
	print("<td>".$hop[$Hop_ID]['ems_census_green']."</td>");
	print("<td>DCD</td>");
	print("<td>".$hop[$Hop_ID]['ems_census_black']."</td>");
	print("<td>commentaire</td>");
	print("<td>".$hop[$Hop_ID]['ems_census_comment']."</td>");
print("</tr>");

print("</table>");
?>