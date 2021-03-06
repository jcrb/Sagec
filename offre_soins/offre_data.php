<?php
/**
	offre_data.php
 * @version $Id$
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */
 // $Id$
session_start();
require("./../pma_connect.php");
require("./../pma_connexion.php");
require("./../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
?>
var baseIcon16 = new GIcon();
   baseIcon16.iconSize=new GSize(16,16);
   baseIcon16.shadowSize=new GSize(56,32);
   baseIcon16.iconAnchor=new GPoint(8,16);
   baseIcon16.infoWindowAnchor=new GPoint(8,0);
var baseIcon2134 = new GIcon();
   baseIcon2134.iconSize=new GSize(21,34);
   baseIcon2134.shadowSize=new GSize(42,32);
   baseIcon2134.iconAnchor=new GPoint(11,17);
   baseIcon2134.infoWindowAnchor=new GPoint(11,0);
   
var sau_ico = new GIcon(baseIcon, "../utilitaires/google/icons/icon46.png", null, "../utilitaires/google/icons/icon46s.png");
var avc_ico = new GIcon(baseIcon, "../images/pma_markers/strokeCenter.png", null, "../utilitaires/google/icons/icon16s.png");
var smur_ico = new GIcon(baseIcon2134, "../images/pma_markers/smur.png", null, "");
var helico_ico = new GIcon(baseIcon, "../images/pma_markers/helico.png", null, "../utilitaires/google/icons/icon16s.png");
var c15_ico = new GIcon(baseIcon, "../images/pma_markers/112.png", null, "../utilitaires/google/icons/icon16s.png");
var rw_ico = new GIcon(baseIcon2134, "../images/pma_markers/retWache.png", null, "");
var cs_ico = new GIcon(baseIcon2134, "../images/pma_markers/cs.png", null, "");

var sau = new Array();
var avc = new Array();
var smur = new Array();
var rw = new Array();
var helico = new Array();
var c15 = new Array();
var cs = new Array();
var assu = new Array();

var normalProj = G_NORMAL_MAP.getProjection();
var mouseTracking;

function mouseMove(mousePt)
{
	if(mouseTracking)
   {
		mouseLatLng = mousePt;
		var zoom = map.getZoom();
		var oStatusDiv = document.getElementById("mouseTrack")	
		var mousePx = normalProj.fromLatLngToPixel(mousePt, zoom);
		oStatusDiv.innerHTML = 'Latitude:   ' + mousePt.y.toFixed(6) + '<br>Longitude: ' + mousePt.x.toFixed(6) ;
	}
}

function Sau(dessine)
{
	if(sau.length < 1)
	{

		<?php
				// s�lectionne h�pital � partir de la table hopital 
    			$requete = "SELECT ad_longitude, ad_latitude,Hop_nom
    							FROM hopital, adresse WHERE Hop_SAU = 'o'
    							AND hopital.adresse_ID = adresse.ad_ID
    							";
    			// s�lectionne h�pital � partir de la table service
    			// => pour que l'hopital soit s�lectionn�, il faut que le service existe		
    			$requete = "SELECT ad_longitude, ad_latitude,Hop_nom, hopital.Hop_ID,service_nom, service_ID
    							FROM hopital, adresse, service
    							WHERE Hop_SAU = 'o'
    							AND hopital.adresse_ID = adresse.ad_ID
    							AND service.Type_ID = '1'
    							AND service.Hop_ID = hopital.Hop_ID
    							ORDER BY hopital.Hop_ID
    							";
    							
    			$resultat = ExecRequete($requete,$connexion);
    			$n = 0;
    			while($rep = mysql_fetch_array($resultat))
    			{ 	
    				echo "sau[".$n."] = new Array();\n";
    				echo "sau[".$n."]['nom'] = '".$rep['Hop_nom']."';\n";
    				echo "sau[".$n."]['long'] = '".rtrim($rep['ad_longitude'])."';\n";
    				echo "sau[".$n."]['lat'] = '".rtrim($rep['ad_latitude'])."';\n";
    				echo "sau[".$n."]['service'] = '".$rep['service_nom']."';\n";
    				echo "sau[".$n."]['ID'] = '".$rep['service_ID']."';\n";
    				$n ++;
    			}
    		?>
    		
    		var texte="test";
			// prend en compte les h�pitaux o� il existe plusieurs SAU
			var hop_courant = '';
			var contact ='';
			for (var i=0;i<sau.length;i++)
   		{
				unPoint = new GLatLng(sau[i]["lat"],sau[i]["long"]);
				if(sau[i]["nom"] != hop_courant)
				{
					hop_courant = sau[i]["nom"];
					contact = "../services.php?ttservice=" + sau[i]["ID"] + "&back=offre_soins/index.php";
					texte = '<b>'+sau[i]["nom"]+'</b><br><a href=\"'+ contact +'\">'+sau[i]["service"]+'</a><br>';
				}
				else
				{
					contact = "../services.php?ttservice=" + sau[i]["ID"] + "&back=offre_soins/index.php";
					texte = texte + '<br><a href=\"'+ contact +'\">'+sau[i]["service"]+'</a><br>';
				}
				sau[i]["marker"] = createMarker(unPoint,texte,sau_ico);
		}
    }
   
   if(dessine)
	{
		for (var i=0;i<sau.length;i++)
			map.addOverlay(sau[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<sau.length;i++)
			map.removeOverlay(sau[i]["marker"]);
	}
}

function Avc(dessine)
{
	if(avc.length < 1)
	{

		<?php
				// s�lectionne h�pital � partir de la table hopital 
    			$requete = "SELECT ad_longitude, ad_latitude,Hop_nom
    							FROM hopital, adresse WHERE Hop_stroke = 'o'
    							AND hopital.adresse_ID = adresse.ad_ID
    							";
    			// s�lectionne h�pital � partir de la table service
    			// => pour que l'hopital soit s�lectionn�, il faut que le service existe	
    			/*	
    			$requete = "SELECT ad_longitude, ad_latitude,Hop_nom, hopital.Hop_ID,service_nom, service_ID
    							FROM hopital, adresse, service
    							WHERE Hop_SAU = 'o'
    							AND hopital.adresse_ID = adresse.ad_ID
    							AND service.Type_ID = '1'
    							AND service.Hop_ID = hopital.Hop_ID
    							ORDER BY hopital.Hop_ID
    							";
    						*/
    			$resultat = ExecRequete($requete,$connexion);
    			$n = 0;
    			while($rep = mysql_fetch_array($resultat))
    			{ 	
    				echo "avc[".$n."] = new Array();\n";
    				echo "avc[".$n."]['nom'] = '".$rep['Hop_nom']."';\n";
    				echo "avc[".$n."]['long'] = '".rtrim($rep['ad_longitude'])."';\n";
    				echo "avc[".$n."]['lat'] = '".rtrim($rep['ad_latitude'])."';\n";
    				//echo "avc[".$n."]['service'] = '".$rep['service_nom']."';\n";
    				//echo "avc[".$n."]['ID'] = '".$rep['service_ID']."';\n";
    				$n ++;
    			}
    		?>

			// prend en compte les h�pitaux o� il existe plusieurs SAU
			var hop_courant = '';
			var contact ='';
			for (var i=0;i<avc.length;i++)
   		{
				unPoint = new GLatLng(avc[i]["lat"],avc[i]["long"]);
				if(avc[i]["nom"] != hop_courant)
				{
					hop_courant = avc[i]["nom"];
					contact = "../services.php?ttservice=" + avc[i]["ID"] + "&back=offre_soins/index.php";
					texte = '<div class="texte-8"><font face="Verdana" size="1"><b>'+avc[i]["nom"]+'</b></font><br><a href=\"'+ contact +'\">'+avc[i]["service"]+'</a></div><br>';
				}
				else
				{
					contact = "../services.php?ttservice=" + avc[i]["ID"] + "&back=offre_soins/index.php";
					texte = texte + '<br><a href=\"'+ contact +'\">'+ avc[i]["service"]+'</a><br>';
				}
				avc[i]["marker"] = createMarker(unPoint,texte,avc_ico);
		}
    }
   
   if(dessine)
	{
		for (var i=0;i<avc.length;i++)
			map.addOverlay(avc[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<avc.length;i++)
			map.removeOverlay(avc[i]["marker"]);
	}
}

function C15(dessine)
{
	if(c15.length < 1)
	{
		<?php
		$requete = "SELECT centrale_ID,centrale_nom,ville_longitude, ville_latitude,ville_nom, ad_longitude, ad_latitude
				FROM centrale, adresse,ville
				WHERE centrale_type_ID IN ('1','3','4')
				AND centrale.centrale_adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
    			";	
    		$resultat = ExecRequete($requete,$connexion);
    		$n = 0;
    			while($rep = mysql_fetch_array($resultat))
    			{ 	
    				if($rep['ad_latitude'] !=0 && $rep['ad_longitude']!=0)
    				{
    					$lat = $rep['ad_latitude'];
    					$lng = $rep['ad_longitude'];
    				}
    				else if($rep['ville_latitude'] !='' && $rep['ville_longitude']!='')
    				{
    					$lat = $rep['ville_latitude'];
    					$lng = $rep['ville_longitude'];
					}    				
    				echo "c15[".$n."] = new Array();\n";
    				echo "c15[".$n."]['nom'] = '".addslashes($rep['centrale_nom'])."';\n";
    				echo "c15[".$n."]['long'] = '".$lng."';\n";
    				echo "c15[".$n."]['lat'] = '".$lat."';\n";
    				$n ++;
    			}
    		?>
    	for (var i=0;i<c15.length;i++)
   	{
			unPoint = new GLatLng(c15[i]["lat"],c15[i]["long"]);
			texte = '<b>'+c15[i]["nom"]+'</b>';
			c15[i]["marker"] = createMarker(unPoint,texte,c15_ico);
		}
	}
	
	if(dessine)
	{
		for (var i=0;i<c15.length;i++)
			map.addOverlay(c15[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<c15.length;i++)
			map.removeOverlay(c15[i]["marker"]);
	}
}


function Helico(dessine)
{
	if(helico.length < 1)
	{
		<?php
		$requete = "SELECT Vec_Nom,ville_longitude, ville_latitude,ville_nom, ad_longitude, ad_latitude
				FROM vecteur, adresse,ville
				WHERE Vec_Type = '9'
				AND vecteur.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
    			";	
    		$resultat = ExecRequete($requete,$connexion);
    		$n = 0;
    			while($rep = mysql_fetch_array($resultat))
    			{ 	
    				if($rep['ad_latitude'] !=0 && $rep['ad_longitude']!=0)
    				{
    					$lat = $rep['ad_latitude'];
    					$lng = $rep['ad_longitude'];
    				}
    				else if($rep['ville_latitude'] !='' && $rep['ville_longitude']!='')
    				{
    					$lat = $rep['ville_latitude'];
    					$lng = $rep['ville_longitude'];
					}    				
    				echo "helico[".$n."] = new Array();\n";
    				echo "helico[".$n."]['nom'] = '".addslashes($rep['Vec_Nom'])."';\n";
    				echo "helico[".$n."]['long'] = '".$lng."';\n";
    				echo "helico[".$n."]['lat'] = '".$lat."';\n";
    				$n ++;
    			}
    		?>
    	for (var i=0;i<helico.length;i++)
   	{
			unPoint = new GLatLng(helico[i]["lat"],helico[i]["long"]);
			texte = '<b>'+helico[i]["nom"]+'</b>';
			helico[i]["marker"] = createMarker(unPoint,texte,helico_ico);
		}
	}
	
	if(dessine)
	{
		for (var i=0;i<helico.length;i++)
			map.addOverlay(helico[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<helico.length;i++)
			map.removeOverlay(helico[i]["marker"]);
	}
}

/**
*	Rettungswache
*/
function RW(dessine)
{
	if(rw.length < 1)
	{
		<?php
			$requete = "SELECT centrale_ID,centrale_nom,ville_longitude, ville_latitude,ville_nom, ad_longitude, ad_latitude
				FROM centrale, adresse,ville
				WHERE centrale_type_ID = '5'
				AND centrale_adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
    			";
    		$resultat = ExecRequete($requete,$connexion);
    		$n = 0;
    		while($rep = mysql_fetch_array($resultat))
    		{
    			if($rep['ad_latitude'] !=0 && $rep['ad_longitude']!=0)
    			{
    				$lat = $rep['ad_latitude'];
    				$lng = $rep['ad_longitude'];
    			}
    			else if($rep['ville_latitude'] !='' && $rep['ville_longitude']!='')
    			{
    				$lat = $rep['ville_latitude'];
    				$lng = $rep['ville_longitude'];
				}    				
    			echo "rw[".$n."] = new Array();\n";
    			echo "rw[".$n."]['nom'] = '".addslashes($rep['centrale_nom'])."';\n";
    			echo "rw[".$n."]['long'] = '".$lng."';\n";
    			echo "rw[".$n."]['lat'] = '".$lat."';\n";
    			echo "rw[".$n."]['ID'] = '".$rep['centrale_ID']."';\n";
    			$n ++;
    		}
		?>
		for (var i=0;i<rw.length;i++)
   	{
			unPoint = new GLatLng(rw[i]["lat"],rw[i]["long"]);
			texte = '<b>'+rw[i]["nom"]+'</b>';
			rw[i]["marker"] = createMarker(unPoint,texte,rw_ico);
		}
   }
   if(dessine)
	{
		for (var i=0;i<rw.length;i++)
			map.addOverlay(rw[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<rw.length;i++)
			map.removeOverlay(rw[i]["marker"]);
	}
}

/**
*	Centre de secours
*/
function CS(dessine)
{
	if(cs.length < 1)
	{
		<?php
			$requete = "SELECT centrale_ID,centrale_nom,ville_longitude, ville_latitude,ville_nom, ad_longitude, ad_latitude
				FROM centrale, adresse,ville
				WHERE centrale_type_ID = '7'
				AND centrale_adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
    			";
    		$resultat = ExecRequete($requete,$connexion);
    		$n = 0;
    		while($rep = mysql_fetch_array($resultat))
    		{
    			if($rep['ad_latitude'] !=0 && $rep['ad_longitude']!=0)
    			{
    				$lat = $rep['ad_latitude'];
    				$lng = $rep['ad_longitude'];
    			}
    			else if($rep['ville_latitude'] !='' && $rep['ville_longitude']!='')
    			{
    				$lat = $rep['ville_latitude'];
    				$lng = $rep['ville_longitude'];
				}    				
    			echo "cs[".$n."] = new Array();\n";
    			echo "cs[".$n."]['nom'] = '".addslashes($rep['centrale_nom'])."';\n";
    			echo "cs[".$n."]['long'] = '".$lng."';\n";
    			echo "cs[".$n."]['lat'] = '".$lat."';\n";
    			echo "cs[".$n."]['ID'] = '".$rep['centrale_ID']."';\n";
    			$n ++;
    		}
		?>
		for (var i=0;i<cs.length;i++)
   	{
			unPoint = new GLatLng(cs[i]["lat"],cs[i]["long"]);
			texte = '<b>'+cs[i]["nom"]+'</b>';
			cs[i]["marker"] = createMarker(unPoint,texte,cs_ico);
		}
   }
   if(dessine)
	{
		for (var i=0;i<cs.length;i++)
			map.addOverlay(cs[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<cs.length;i++)
			map.removeOverlay(cs[i]["marker"]);
	}
}

function Smur(dessine)
{
	if(smur.length < 1)
	{

		<?php
				// s�lectionne h�pital � partir de la table hopital 
				/*
    			$requete = "SELECT ad_longitude, ad_latitude,Hop_nom
    							FROM hopital, adresse WHERE Hop_Smur = 'o'
    							AND hopital.adresse_ID = adresse.ad_ID */
    							
    			$requete = "SELECT Hop_nom,ville_longitude, ville_latitude,ville_nom, ad_longitude, ad_latitude
				FROM hopital, adresse,ville
				WHERE Hop_Smur = 'o'
				AND hopital.adresse_ID = adresse.ad_ID
				AND adresse.ville_ID = ville.ville_ID
    			";
    			// s�lectionne h�pital � partir de la table service
    			// => pour que l'hopital soit s�lectionn�, il faut que le service existe	

    			$resultat = ExecRequete($requete,$connexion);
    			$n = 0;
    			while($rep = mysql_fetch_array($resultat))
    			{ 	
    				if($rep['ad_latitude'] !=0 && $rep['ad_longitude']!=0)
    				{
    					$lat = $rep['ad_latitude'];
    					$lng = $rep['ad_longitude'];
    				}
    				else if($rep['ville_latitude'] !='' && $rep['ville_longitude']!='')
    				{
    					$lat = $rep['ville_latitude'];
    					$lng = $rep['ville_longitude'];
					}    				
    				echo "smur[".$n."] = new Array();\n";
    				echo "smur[".$n."]['nom'] = '".addslashes($rep['Hop_nom'])."';\n";
    				echo "smur[".$n."]['long'] = '".$lng."';\n";
    				echo "smur[".$n."]['lat'] = '".$lat."';\n";
    				//echo "smur[".$n."]['service'] = '".$rep['service_nom']."';\n";
    				//echo "smur[".$n."]['ID'] = '".$rep['service_ID']."';\n";
    				$n ++;
    			}
    		?>
			
			// prend en compte les h�pitaux o� il existe plusieurs SAU
			var hop_courant = '';
			var contact ='';
		
			for (var i=0;i<smur.length;i++)
   		{
   			//alert(smur[i]["nom"]+' '+);
				unPoint = new GLatLng(smur[i]["lat"],smur[i]["long"]);
				if(smur[i]["nom"] != hop_courant)
				{
					hop_courant = smur[i]["nom"];
					contact = "../services.php?ttservice=" + smur[i]["ID"] + "&back=offre_soins/index.php";
					texte = '<b>'+smur[i]["nom"]+'</b><br><a href=\"'+ contact +'\">'+smur[i]["service"]+'</a><br>';
				}
				else
				{
					contact = "../services.php?ttservice=" + smur[i]["ID"] + "&back=offre_soins/index.php";
					texte = texte + '<br><a href=\"'+ contact +'\">'+ smur[i]["service"]+'</a><br>';
				}
				smur[i]["marker"] = createMarker(unPoint,texte,smur_ico);
		}
    }
   if(dessine)
	{
		for (var i=0;i<smur.length;i++)
			map.addOverlay(smur[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<smur.length;i++)
			map.removeOverlay(smur[i]["marker"]);
	}
}

/**
*	ASSU
*/
function ASSU(dessine)
{

}
		
/**
*	fait apparaitre ou disparaitre un conterneur DIV
* source http://blocnotes.jemenvol.net/5.afficher-et-masquer-une-div/
*/
function visibilite(thingId)
{
	var targetElement;
	targetElement = document.getElementById(thingId);
	if(!targetElement) alert('El�ment '+ thingId + ' introuvable');
	if (targetElement.style.display == "none")
	{
		//alert('target active: '+targetElement.style.display);
		targetElement.style.display = "inline";
	} 
	else 
	{
		//alert('target inactive: '+targetElement.style.display);
		targetElement.style.display = "none";
	}
	analyseMenu();
}

function analyseMenu()
{
	var oTracking = document.getElementById('mt');
	if(oTracking.checked) 
	{
    		mouseTracking = true;
	}
	else
	{
    		mouseTracking = false;
	}
	
	var oSau = document.getElementById('sau');
	if(oSau.checked)
		Sau(true);
	else
		Sau(false);
	
	var oAvc = document.getElementById('avc');
	if(oAvc.checked)
		Avc(true);
	else
		Avc(false);
		
	var oSmur = document.getElementById('smur');
	if(oSmur.checked)
		Smur(true);
	else
		Smur(false);
	
	var oRw = document.getElementById('rw');
	if(oRw.checked)
		RW(true);
	else
		RW(false);
		
	var oCs = document.getElementById('cs');
	if(oCs.checked)
		CS(true);
	else
		CS(false);
		
	var oHelico = document.getElementById('helico');
	if(oHelico.checked)
		Helico(true);
	else
		Helico(false);
		
	var oC15 = document.getElementById('c15');
	if(oC15.checked)
		C15(true);
	else
		C15(false);
		
	var oAssu = document.getElementById('assu');
	if(oAssu.checked)
		ASSU(true);
	else
		ASSU(false);
}