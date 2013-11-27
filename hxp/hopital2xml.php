<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//--------------------------------------------------------------------------------------------------------
/** hopital2xml.php
* 	enregistre les données du dernier évènement courant dans le fichier administrateur/sauvegarde
*	date de création: 	10/11/2004		 
*	@author:			jcb		  
*	@version:			1.1	- $Id: sauvegarde.php 10 2006-08-17 22:41:56Z jcb $	 
*	maj le:				14/08/2006	
* 	@TODO: vérifier si tout est sauvegardé 
*	@package			sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

/**
* @param nature_contact 1 = personne, 2 = organisme, 3 = vecteur, 4 = service, 5 = hopital
*/
function contact($identifiant_contact,$nature_contact)
{
	global $connect;
	$msg='';
	$requete = "SELECT valeur,contact_nom,type_contact_ID
				FROM contact
				WHERE identifiant_contact = '$identifiant_contact'
				AND nature_contact_ID = '$nature_contact'
				ORDER BY type_contact_ID
				";
	$resultat = ExecRequete($requete,$connect);
	while($rub=mysql_fetch_array($resultat))
	{
		switch($rub['type_contact_ID'])
		{
			case 7:$msg .="<Fax_number>$rub[valeur]</Fax_number>\r\n";break;
			case 1:$msg .="<Telephon_number1>$rub[valeur]</Telephon_number1>\r\n";break;
			case 8:$msg .="<Website>$rub[valeur]</Website>\r\n";break;
			case 5:$msg .="<Email>$rub[valeur]</Email>\r\n";break;
		}	
	}
	return $msg;
}

/**
* ATTENTION pour être utilisable par HXP cette fonction ne doit contenir aucun 'print'
*/
function get_EUbeds_infos()
{
	global $connect;

	$entete = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
	/*$entete = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";*/
	//$entete .="<xsd:schema xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">\r\n";
	$entete .="<rXML>\r\n";
	$entete .="<Header>\r\n";
		$entete .="<From>\r\n";
			$entete .="<Credential domain=\"SAGEC67\">\r\n";
				$entete .="<Identity>2000</Identity>\r\n";
				$entete .="<SharedSecret>string by default</SharedSecret>\r\n";
			$entete .="</Credential>\r\n";
		$entete .="</From>\r\n";
		$entete .="<To>\r\n";
			$entete .="<Credential domain=\"IES\">\r\n";
				$entete .="<Identity>1001</Identity>\r\n";
				$entete .="<SharedSecret>string by default</SharedSecret>\r\n";
			$entete .="</Credential>\r\n";
		$entete .="</To>\r\n";
		$entete .="<Sender>\r\n";
			$entete .="<Credential domain=\"SAGEC67\">\r\n";
				$entete .="<Identity>2001</Identity>\r\n";
				$entete .="<SharedSecret>string by default</SharedSecret>\r\n";
			$entete .="</Credential>\r\n";
		$entete .="</Sender>\r\n";
	$entete .="</Header>\r\n";
   

	$msg=$entete;
	
		$requete = "SELECT Hop_ID, Hop_finess,Hop_nom,Hop_DZ,type_etablissement_ID,org_nom,ville_nom,
						ville_longitude,ville_latitude,ville_ZIP,adresse.ad_zone1,pays_nom
			FROM hopital, adresse, ville,pays,organisme
			WHERE hopital.adresse_ID = adresse.ad_ID
			AND adresse.ville_ID = ville.ville_ID
			AND ville.pays_ID = pays.pays_ID
			AND ville.departement_ID IN ('67','68')
			AND hopital.org_ID = organisme.org_ID
			";
	
	$resultat = ExecRequete($requete,$connect);
	while($rub = mysql_fetch_array($resultat))
	{
	
		$today2 = date("c");// uniquement si PHP5
		$today1 = date("Y-m-j")."T".date("H:i:s").date("O");
		$msg .="<Payload>\r\n";
			$msg .="<Ressources>\r\n";
				$msg .="<ResourceData>\r\n";
                //$msg .="<ActionData date="2006-09-30T12:00:00-05:00">\r\n";
					$msg.="<ActionData date=\"$today1\">\r\n";
					$msg.="<Action>UPDATE</Action>\r\n";
            $msg .="</ActionData>\r\n";
            //---------------------------------------------------------------
				$msg .="<Resource>\r\n";
					$msg .="<Hospital>\r\n";
						$msg .="<ResourceCommonData>\r\n";
							$msg .="<ResourceID>".$rub[Hop_finess]."</ResourceID>\r\n";
							$msg .="<Location>\r\n";
								$msg .="<Latitude mapDatum=\"ED50\">".$rub[ville_latitude]."</Latitude>\r\n";
                        $msg .="<Longitude mapDatum=\"ED50\">".$rub[ville_longitude]."</Longitude>\r\n";
                        $msg .="<Altitude mapDatum=\"ED50\" unit=\"m\">".$rub[ville_altitude]."</Altitude>\r\n";
                      $msg .="</Location>\r\n";
                     
							$msg .="<Contact>\r\n";
                                $msg .="<PostalAddress addressType=\"main\">\r\n";
                                    $msg .="<Street1>".$rub[ad_zone1]."</Street1>\r\n";
								    			$msg .="<Street2>".$rub[ad_zone2]."</Street2>\r\n";
                                    $msg .="<City>".$rub[ville_nom]."</City>\r\n";
                                    $msg .="<PostalCode>".$rub[ville_ZIP]."</PostalCode>\r\n";
                                    $msg .="<Country>".$rub[pays_nom]."</Country>\r\n";
								    			$msg .="<POBox>$rub[100]</POBox>\r\n";
								    			$msg .="<Region></Region>\r\n";
                                	$msg .="</PostalAddress>\r\n";
                                	$msg .="<Communication contactType=\"main\">\r\n";
                                	$nature_contact = 5;
                                	$identifiant_contact = $rub[Hop_ID];
                                	contact($identifiant_contact,$nature_contact);
								    $msg .="<EmergencyCallStation>$rub[100]</EmergencyCallStation>\r\n";
									// analyse des contacts voir fonction contacts() 
									$msg .= contact($identifiant_contact,$nature_contact);
                         $msg .="</Communication>\r\n";
                      $msg .="</Contact>\r\n";
                      
						$msg .="</ResourceCommonData>\r\n";
						
						$msg .="<HospitalData>\r\n";
                  	$msg .="<Name>".$rub[Hop_nom]."</Name>\r\n";
                     $msg .="<HospitalGroup>".$rub[org_nom]."</HospitalGroup>\r\n";
                     $msg .="<HospitalType></HospitalType>";
                     $msg .="<ServiceCategory></ServiceCategory>";
                     switch($rub['type_etablissement_ID']){
                     	case 1: $type = "public";break;
                     	case 2: $type = "private";break;
                     	case 3: $type = "private subventioned";break;
                     }
                     $msg .="<Sponsorship>".$type."</Sponsorship>";
                     switch($rub['Hop_DZ']){
                     	case 0: $dz = "none";break;
                     	case 1: $dz = "ground";break;
                     	case 2: $dz = "roof";break;
                     	case 3: $dz = "distant";break;
                     }
                     $msg .="<Helicopter>".$dz."</Helicopter>";
                     $msg .="<Airport>Strasbourg-Entzheim</Airport>";
                     $msg .="<Comments></Comments>";
                  $msg .="</HospitalData>";
					$msg .="</Hospital>\r\n";
				$msg .="</Resource>\r\n";
			$msg .="</ResourceData>\r\n";
		$msg .="</Ressources>\r\n";
	$msg .="</Payload>\r\n";

	}
$msg .="</rXML>\r\n";

/*

	while($rub=mysql_fetch_array($resultat))
	{
		$identifiant_contact = $rub['Hop_ID'];
		$nature_contact = '5';//hopital
  		$rub[100] = "";
  		$msg .="<Hospital>\r\n";
    	$msg .="<Basic_Data>\r\n";
      	$msg .="<ID_Hospital>$rub[Hop_finess]</ID_Hospital>\r\n";
      	$msg .="<Designation>$rub[Hop_nom]</Designation>\r\n";
	  	$msg .="<Hospital_group>$rub[100]</Hospital_group>\r\n";
	  	$msg .="<Hospitaltyp>$rub[100]</Hospitaltyp>\r\n";
	  	$msg .="<Achievement_category>$rub[100]</Achievement_category>\r\n";
        switch($rub['type_etablissement_ID']){
          case 0:$rep='Undefine';break;
          case 1:$rep='public';break;
          case 2:$rep='private';break;
          case 3:$rep='private subsidized';break;}
	  	$msg .="<Working_group> $rep </Working_group>\r\n";
	  	$msg .="<Remark>$rub[100]</Remark>\r\n";
        switch($rub['Hop_DZ']){
          case 0:$rep='No';break;
          case 1:$rep='Roof';break;
          case 2:$rep='Ground';break;
          case 3:$rep='Far';break;}
	  	$msg .="<Helicopter>$rep</Helicopter>\r\n";
	  	$msg .="<Airport>Strasbourg-Entzheim</Airport>\r\n";///@todo à créer
    	$msg .="</Basic_Data>\r\n";
		
    	

    	$msg .="</Contact>\r\n";
  		$msg .="</Hospital>\r\n";
	}//end while
 	$msg .="</Hospitals>\r\n";
*/
		
	return $msg;
}

function test23()
{
	return "machin";
}

function test()
{
	$msg = get_EUbeds_infos();
	$fp = fopen("hospital.xml", 'w');
	fputs($fp, $msg);
	fclose($fp);
        
	echo 'Export XML effectue !<br><a href="hospital.xml">Voir le fichier</a>';
	echo 'Import XML effectue !<br><a href="xml2hospital.php">Voir le résultat</a>';
}

//test();
?>