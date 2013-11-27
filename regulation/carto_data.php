<?php
/**
*	carto_data.php
*/
$backpath="../";
include($backpath."dbConnection.php");
include($backpath."login/init_security.php");
include($backpath."utilitaires/google/orthodro.php");
?>

var path = "../";
var startZoom = 15;
var normalProj = G_NORMAL_MAP.getProjection();

var baseIcon = new GIcon();
   baseIcon.iconSize=new GSize(32,32);
   baseIcon.shadowSize=new GSize(56,32);
   baseIcon.iconAnchor=new GPoint(16,32);
   baseIcon.infoWindowAnchor=new GPoint(16,0);
   
var baseIcon16 = new GIcon();
   baseIcon16.iconSize=new GSize(16,16);
   baseIcon16.shadowSize=new GSize(25,16);
   baseIcon16.iconAnchor=new GPoint(8,16);
   baseIcon16.infoWindowAnchor=new GPoint(8,0);

var baseIcon2134 = new GIcon();
   baseIcon2134.iconSize=new GSize(21,34);
   baseIcon2134.shadowSize=new GSize(25,16);
   baseIcon2134.iconAnchor=new GPoint(8,16);
   baseIcon2134.infoWindowAnchor=new GPoint(11,0);
   
/**
 *
 * @access public
 * @return void
 **/
 
function mouseMove()
{
}

function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	//map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	GEvent.addListener(map, 'mousemove', mouseMove);
}

function init(lat,lng)
{
	if(GBrowserIsCompatible())
	{
		centerLatitude = lat;
		centerLongitude =  lng;
		var location = new GLatLng(centerLatitude,centerLongitude);
		var description = "";
		map = new GMap2(document.getElementById("map"));
		setControles();
		
		map.setCenter(location,startZoom);
		map.addOverlay(new GMarker(location));
		
		// oStatusDiv.innerHTML = navigator.appName;
		// tracé des isocercles de 5 km 
		for($i=1;$i<4;$i++)
		{
			var circleA = cercle(lat,lng,5*$i,'red',0,3);
			map.addOverlay(circleA);
		}
		
		path ="../../../";
		
		assu();
		smur();
		helico();
		medecin();
		vsav();
		dsa();
		pharmacies();
	}
}

/**
*	Cercle:renvoie un objet GPolygon décrivant un cercle
*	lat: latitude du centre
* 	lng: longitude du centre
* 	rayon: rayon du cercle en km
*	color: couleur du cercle
*	transparence: entre  0 et 1
*	epaisseur: épaisseur du trait
*/
function cercle(lat,lng,rayon,color,transparence,epaisseur)
{
	var center = new GLatLng(lat,lng);
	var circlepoints = new Array();
	with (Math)
	{
		var rLat = (rayon/6378.8) * (180/PI);
		var rLng = rLat/cos(center.lat() * (PI/180));
		for (var a = 0 ; a < 361 ; a+=10 ) 
		{
			var aRad = a*(PI/180);
			var x = center.lng() + (rLng * cos(aRad));
			var y = center.lat() + (rLat * sin(aRad));
			var point = new GLatLng(parseFloat(y),parseFloat(x));
			circlepoints.push(point);
		}
	}
	var couleur_trait = color;
	var epaisseur_trait = epaisseur;
	var transparence_trait = 0.5;
	var a_circle = new GPolygon(circlepoints, couleur_trait,epaisseur_trait,transparence_trait,color, transparence);
	return a_circle;
}

/**
* Calcul de la distance orthodromique entre deux points
* @version $Id: brule_cherche.php 35 2008-02-19 22:50:08Z jcb $
* @author JCB
* @param [in] $latA  latitude du point A
* @param [in] $longA longitude du point A
* @param [in] $latB  latitude du point B
* @param [in] $longB longitude du point B
* @return distance en km
*/
function orthodro(latA,longA,latB,longB)
{
	var deg2rad = Math.PI/180;
	var ortho =  Math.acos(Math.cos(deg2rad*latA)*Math.cos(deg2rad*latB)*Math.cos(deg2rad*(longA-longB))+Math.sin(deg2rad*(latA))*Math.sin(deg2rad*(latB)));
	//return $ortho * 6366;
	return ortho * 6378;
}

/**
	Crée un marqueur à l'endroit point, avec l'image icon et lui associe un évènement Click
	En cas de click affiche une fenêtre avec le contenu html
*/
function createMarker(point,html,icon)
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
	map.addOverlay(marker);
	return marker;
}

/**
*	ASSU proches
*/
function assu()
{
	var assu_ico = new GIcon(baseIcon, path +"images/pma_markers/assub.png", null, "");
	<?php
	$requete = "SELECT org_ID,org_nom, ad_longitude, ad_latitude
					FROM adresse, organisme
					WHERE organisme_type_ID = '4'
					AND organisme.adresse_ID = adresse.ad_ID";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[ad_longitude] != 0){
			print("var latx = ".$rep['ad_latitude'].";");
			print("var lngx = ".$rep['ad_longitude'].";");
			print("var nom = '".addslashes($rep['org_nom'])."'"."+'<br>'".";");
			?>
			dh = Math.ceil(orthodro(latx,lngx,centerLatitude,centerLongitude));
			if(dh < 20){
				<?php
				$requete2="SELECT valeur FROM contact WHERE identifiant_contact='$rep[org_ID]' AND nature_contact_ID=2 AND type_contact_ID < 5";
				$resultat2 = ExecRequete($requete2,$connexion);
				while($rep2=mysql_fetch_array($resultat2))
				{
					if($rep2['valeur'] != "")
						print("nom = nom + '".$rep2['valeur']."';");
				}
				?>
				var location = new GLatLng(latx,lngx);
				//alert(location+','+nom+','+assu_ico);
				createMarker(location,nom,assu_ico);
			}
			<?php
		}
	}
	?>
}

/**
*	VSAV proches
*/
function vsav()
{
	var vsav_ico = new GIcon(baseIcon, path +"images/pma_markers/vsav.png", null, "");
	<?php
	$requete = "SELECT vec_nom, ad_longitude, ad_latitude
					FROM adresse, vecteur
					WHERE Vec_Type = 3
					AND adresse_ID = adresse.ad_ID
					AND ad_longitude > 0";
					
	// Technique 2 
	$requete = "SELECT vec_nom, ad_longitude, ad_latitude
					FROM adresse,vecteur,centrale
					WHERE Vec_Type = 3
					AND vecteur.centrale_ID = centrale.centrale_ID
					AND centrale.centrale_adresse_ID = adresse.ad_ID
					AND ad_longitude > 0
					";
					
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		//if($rep[ad_longitude] != 0){
			print("var latx = ".$rep['ad_latitude'].";");
			print("var lngx = ".$rep['ad_longitude'].";");
			print("var nom = '".addslashes($rep['vec_nom'])."'"."+'<br>'".";");
			?>
			dh = Math.ceil(orthodro(latx,lngx,centerLatitude,centerLongitude));
			if(dh < 20)
			{
				<?php
				/* mettre tel de la centrale compétente
				$requete2="SELECT valeur FROM contact WHERE identifiant_contact='$rep[org_ID]' AND nature_contact_ID=2 AND type_contact_ID < 5";
				$resultat2 = ExecRequete($requete2,$connexion);
				while($rep2=mysql_fetch_array($resultat2))
				{
					if($rep2['valeur'] != "")
						print("nom = nom + '".$rep2['valeur']."';");
				}*/
				
				?>
				var location = new GLatLng(latx,lngx);
				createMarker(location,nom,vsav_ico);
			}
			<?php
		//}
	}
	?>
}

/**
* Hélico
* To search by kilometers instead of miles, replace 3959 with 6371. 
*/
function helico()
{
	var helico_ico = new GIcon(baseIcon, path +"images/pma_markers/helico2.png", null, "");
	<?php
	$requete = "SELECT ad_longitude, ad_latitude, Vec_Nom
					FROM adresse, vecteur
					WHERE Vec_Type = 9
					AND vecteur.adresse_ID = adresse.ad_ID";
	$resultat = ExecRequete($requete,$connexion);
	$dh=array();
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[ad_longitude] != 0){
			print("var latx = ".$rep['ad_latitude'].";");
			print("var lngx = ".$rep['ad_longitude'].";");
			print("var nom = '".addslashes($rep['Vec_Nom'])."'"."+'<br>'".";");
			?>
			dh = Math.ceil(orthodro(latx,lngx,centerLatitude,centerLongitude));
			if(dh < 100){
				<?php
				$requete2="SELECT valeur FROM contact WHERE identifiant_contact='$rep[org_ID]' AND nature_contact_ID=2 AND type_contact_ID < 5";
				$resultat2 = ExecRequete($requete2,$connexion);
				while($rep2=mysql_fetch_array($resultat2))
				{
					if($rep2['valeur'] != "")
						print("nom = nom + '".$rep2['valeur']."';");
				}
				?>
				var location = new GLatLng(latx,lngx);
				createMarker(location,nom,helico_ico);
			}
			<?php
		}
	}
	?>
}

/**
*	SMUR
*/
function smur()
{
	var smur_ico = new GIcon(baseIcon, path +"images/pma_markers/smur.png", null, "");
	<?php
	$requete = "SELECT Hop_nom, ad_longitude, ad_latitude
					FROM adresse, hopital
					WHERE Hop_Smur = 'o'
					AND hopital.adresse_ID = adresse.ad_ID";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[ad_longitude] != 0)
		{
			print("var latx = ".$rep['ad_latitude'].";");
			print("var lngx = ".$rep['ad_longitude'].";");
			print("var nom = '".addslashes($rep['Hop_nom'])."'"."+'<br>'".";");
			?>
			dh = Math.ceil(orthodro(latx,lngx,centerLatitude,centerLongitude));
			if(dh < 100)
			{
				var location = new GLatLng(latx,lngx);
				createMarker(location,nom,smur_ico);
			}
		<?php
		}
	}
	?>
}

/**
*	Médecins
*/
function medecin()
{
	var med_ico = new GIcon(baseIcon, path +"images/pma_markers/med.png", null, "");
	<?php
	$requete = "SELECT * FROM mg67";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[lng] != 0){
			print("var latx = ".$rep['lat'].";");
			print("var lngx = ".$rep['lng'].";");
			print("var nom ='Dr '+'".addslashes($rep['med_nom'])."'"."+'<br>'+'".addslashes($rep['med_adresse'])."'+'<br>' + '".addslashes($rep['med_tel'])."';");
			?>
			dh = Math.ceil(orthodro(latx,lngx,centerLatitude,centerLongitude));
			if(dh < 10)
			{
				var location = new GLatLng(latx,lngx);
				createMarker(location,nom,med_ico);
			}
		<?php
		}
	}
	?>
}

/**
*	D�fibrillateurs
*/
function dsa()
{
	var dsa_ico = new GIcon(baseIcon2134, path +"images/pma_markers/dsa.png", null, "");
	var dsa_ico = new GIcon(baseIcon16, path +"images/pma_markers/aed.jpg", null, "");
	<?php
	$requete = "SELECT * FROM dsa";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep[dsa_lng] != 0){
			print("var latx = ".$rep['dsa_lat'].";");
			print("var lngx = ".$rep['dsa_lng'].";");
			print("var nom ='DSA '+'".addslashes($rep['dsa_site'])."'"."+'<br>'+'".addslashes($rep['dsa_adresse'])."'+'<br>' + '".addslashes($rep['dsa_tel'])."' + '<br>' + '".addslashes($rep['dsa_comment'])."';");
			?>
			dh = Math.ceil(orthodro(latx,lngx,centerLatitude,centerLongitude));
			if(dh < 5)
			{
				var location = new GLatLng(latx,lngx);
				createMarker(location,nom,dsa_ico);
			}
		<?php
		}
	}
	?>
}

/**
  *	pharmacies
  */
function pharmacies()
{
	var pharma_ico = new GIcon(baseIcon2134, path +"images/pma_markers/pharma.png", null, "");
	<?php
	$requete = "SELECT * FROM pharmacie";
	$resultat = ExecRequete($requete,$connexion);
	while($rep=mysql_fetch_array($resultat))
	{
		if($rep['lat'] != 0){
			print("var latx = ".$rep['lat'].";");
			print("var lngx = ".$rep['long'].";");
			print("var nom = '".addslashes($rep['nom'])."'"."+'<br>'+'".addslashes($rep['adresse'])
			."'+'<br>' + '".addslashes($rep['tel'])."';");
			?>
			dh = Math.ceil(orthodro(latx,lngx,centerLatitude,centerLongitude));
			if(dh < 10)
			{
				var location = new GLatLng(latx,lngx);
				createMarker(location,nom,pharma_ico);
			}
		<?php
		}
	}
	?>
}
window.onload = init;
window.unload = GUnload;