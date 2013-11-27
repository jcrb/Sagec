/**
 * ppi_pmc_data.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */
<?php
require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
?>

var startZoom = 15;
var normalProj = G_NORMAL_MAP.getProjection();
var mouseTracking;
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
   
var map;
var heb_ico = new GIcon(baseIcon, "../../images/EC145.jpg", null, "");
var ico_hop = new GIcon(baseIcon, "../../images/logo-hopital.jpg", null, "");
var ico_pcf = new GIcon(baseIcon, "../../images/sidpc.png", null, "");
var ico_pma = new GIcon(baseIcon, "../../utilitaires/google/icons/icon46.png", null, "");
var ico_pco = new GIcon(baseIcon, "../../utilitaires/google/icons/icon53.png", null, "");
var ico_pt = new GIcon(baseIcon, "../../utilitaires/google/icons/icon15.png", null, "");
var ico_bcl = new GIcon(baseIcon, "../../images/Police2.png", null, "");
var ico_vip = new GIcon(baseIcon16, "../../images/pma_markers/violet16.png", null, "");

var polys = [];
var labels = [];

/**
 *
 * @access public
 * @return void
 **/
function addMarker(latitude,longitude,description){
	var marker = new GMarker(new GLatLng(latitude,longitude));
	GEvent.addListener(marker,'click',
		function(){
			marker.openInfoWindowHtml(description);
		}
	)
	map.addOverlay(marker);
}
/**
	Crée un marqueur à l'endroit point, avec l'image icon et lui associe un évènement Click
	En cas de click affiche une fenêtre avec le contenu html
*/
function createMarker(point,html,icon)
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
	return marker;
}
/**
 *
 * @access public
 * @return void
 **/
function addComplexMarker(point,icon)
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {
	var tab1 = new GInfoWindowTab("Info", '<div id="tab1" class="bubble">PRM<br>Point de rassemblement des moyens<br>A4 Bretelle de sortie Reichstett</div>');
	var tab2 = new GInfoWindowTab("Moyens", '<div>VSAV Nord<br>ASSU 834<br>ASSU 835<br>AR1 Strasbourg</div>');
	var infoTabs = [tab1,tab2];
	marker.openInfoWindowTabsHtml(infoTabs);

		//var dMapDiv = document.getElementById("detailmap");
		//var detailmap = new GMap2(dMapDiv);
		//detailmap.setCenter(point , 13);

		//var CopyrightDiv = dMapDiv.firstChild.nextSibling;
		//var CopyrightImg = dMapDiv.firstChild.nextSibling.nextSibling;
		//CopyrightDiv.style.display = "none";
		//CopyrightImg.style.display = "none";

	});
	//map.addOverlay(marker);
	return marker;
}
/**
 *
 * @access public
 * @return void
 **/
function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	//map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	GEvent.addListener(map, 'mousemove', mouseMove);
}

function init()
{
	if(GBrowserIsCompatible())
	{
		<?php
		/**
		*	Récupération des paramères de centrage
		*	@data centerLatitude 
		*	@data centerLongitude 
		*	@data description 
		*/

		$requete = 	"SELECT *
		 FROM ppi
		 WHERE ppi_ID = 25
		 ";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		print("var centerLatitude = ".$rub['center_lat'].";");
		print("var centerLongitude = ".$rub['center_lng'].";");
		print("var description = '".$rub['ppi_nom']."';");
		?>
		map = new GMap2(document.getElementById("map"));
		setControles();
		var location = new GLatLng(centerLatitude,centerLongitude);
		map.setCenter(location,startZoom);
		addMarker(centerLatitude,centerLongitude,description);
		// 		oStatusDiv.innerHTML = navigator.appName;
		structures_temporaires();
		zonage();
	}
}

/**
*  Récupération des zones
*/
function zonage()
{
	<?php 
	$requete = "SELECT * FROM zone_enveloppe WHERE zenveloppe_active = 'o'";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("label = '".$rub['zenveloppe_nom']."';");
		print("colour = '".$rub['zenveloppe_couleurFond']."';");
		print("trait = '".$rub['zenveloppe_couleurTrait']."';");
		print("transparence = '".$rub['zenveloppe_transparence']."';");
		$fileName = "../../pma/zones/".$rub['zenveloppe_file'];
		$fp = fopen($fileName,"r");
		$i = 0;
		print("var pts = [];");
		// retirer la première ligne
		$mot = fgets($fp);
		while(!feof($fp))
		{
			$mot = fgets($fp);
			$coord = explode(",",$mot);
			print("pts[".$i."] = new GLatLng(".$coord[1].",".$coord[0].");");
			$i++;
		}
			?>
			// création du polygone
			transparence = transparence/100;
         var poly = new GPolygon(pts,trait,1,1,colour,transparence,{clickable:true});
         polys.push(poly);
         labels.push(label);
         map.addOverlay(poly);
         <?php
		fclose($fp);
	}
	?>
}
	
/**
*	Récupération des structures temporaires
*/
function structures_temporaires()
{
	<?php
	$requete = "SELECT * FROM temp_structure WHERE ts_active = 'o'";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("Latitude = ".$rub['ts_lat'].";");
		print("Longitude = ".$rub['ts_long'].";");
		print("nom = '".$rub['ts_nom']."';");
		print("type = ".$rub['ts_type'].";");
		//print("texte = '".addslashes($rub[ts_localisation])."';");
		?>
			point = new GLatLng(Latitude,Longitude); 
			switch(type)
			{
				case 1: icone = ico_pma;break;
				case 2: icone = ico_pco;break;
				case 3: icone = ico_pcf;break;
				case 7: icone = ico_pt;break;
				case 8: icone = ico_bcl;break;
				case 14: icone = ico_vip;break;
				
				default: icone = heb_ico;
			}
			markerH = createMarker(point,nom,icone);
			map.addOverlay(markerH);
		<?php
	}
	?>
}

function helico()
{
	pt = new GLatLng(48.596504, 7.753102);
	markerH = new GMarker(pt,heb_ico);
	map.addOverlay(markerH);
}

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
	helico();
}

window.onload = init;
window.unload = GUnload;