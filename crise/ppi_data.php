/**
 * ppi_pmc_data.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */
<?php
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

$ppi = 0;	//21

/**
*	remplace()
*	remplace les caractères \n\r, \r,\n par <br>
*	évite les plantages liées au stockage des textarea
*/
function remplace($str)
{
	
}

?>
var startZoom = 15;
var normalProj = G_NORMAL_MAP.getProjection();
var mouseTracking;
var map;
var ppi;
   
var polys = [];
var labels = [];
var cercles = new Array;
var marker_ppi = new Array;


/**
*	rend visible ou pas une div
*/
function visibilite(thingId, action)
{
	var targetElement;
	targetElement = document.getElementById(thingId) ;
	targetElement.style.display = action ;
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
		$requete = 	"SELECT plan_ID FROM plan_courant WHERE plan_courant_ID = 1";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		$ppi = $rub['plan_ID'];

		$requete = 	"SELECT center_lat,center_lng,ppi_nom FROM ppi WHERE ppi_ID = '$ppi'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		
		print("var centerLatitude = ".$rub['center_lat'].";");
		print("var centerLongitude = ".$rub['center_lng'].";");
		print("var description = '".Security::db2str($rub['ppi_nom'])."';");
		?>
		ppi = "<?php echo $ppi;?>";
		map = new GMap2(document.getElementById("map"));
		setControles();
		var location = new GLatLng(centerLatitude,centerLongitude);
		map.setCenter(location,startZoom);
		texte = "<div id='produit'><b>"+description+"</b></div><br>";
		addMarker(centerLatitude,centerLongitude,texte);

		
		stockages_associes();
				/*
		info_ppi(ppi);
		ST_preetablies();
		structures_temporaires();
		zonage();
		*/
	}
}

/**
  *	stockages_associes
  * 	regarde dans la table stockage s'il y a des éléments associés au PPI
  *	Si oui, les affiche
  */
function stockages_associes()
{
	<?php
		$requete = "SELECT stockage_industriel.*,stockage_conteneur_nom,chem_nom,unite_nom
						FROM stockage_industriel,stockage_conteneur,produitsChimiques, med_unites
						WHERE ppi_ID = '$ppi'
						AND stockage_industriel.stocki_type = stockage_conteneur.stockage_conteneur_ID
						AND stockage_industriel.produit_ID = chem_ID
						AND stocki_qte_unite = unite_ID
					  ";
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			print("Latitude = ".$rub['stocki_lat'].";");
			print("Longitude = ".$rub['stocki_lng'].";");
			print("nom = '".addslashes($rub['stocki_nom'])."';");
			print("conteneur = '".addslashes($rub['stockage_conteneur_nom'])."';");
			print("hauteur = '".$rub['stocki_hauteur']."';");
			print("diametre = '".$rub['stocki_diametre']."';");
			print("volume = '".$rub['stocki_qte']."';");
			print("unit = '".addslashes($rub['unite_nom'])."';");
			print("produit = '".addslashes($rub['chem_nom'])."';");
			
			?>
				texte = '<b>'+nom+'</b>' + '<br>' + 'Type: ' + conteneur + '<br>' + 'Hauteur (m): '+ hauteur + '<br>'
							+ 'Diametre (m): ' + 0 + '<br>' +  'Volume: ' + volume +' '+unit + '(s)' + '<br>' + 'Produit: ' + '<a href="doc.html" target="_blank">'+produit+'</a>';
				point = new GLatLng(Latitude,Longitude);
				//icone = getIcone(type); 
				markerH = createMarker(point,texte,violet_ico);
				map.addOverlay(markerH);
				addMarker(Latitude,Longitude,texte);
			<?php
		}
	?>
}

function StructTemp(visible)
{
	if(visible){
		if(marker_ppi.length < 1)
			info_ppi(ppi);
		for(i=0;i<marker_ppi.length;i++)
		{
			map.addOverlay(marker_ppi[i]);
			for(j=0;j<3;j++)
			{
				map.addOverlay(cercles[i][j]);
			}
		}		
	}
	else{
		for(i=0;i<marker_ppi.length;i++)
		{
			map.removeOverlay(marker_ppi[i]);
			for(j=0;j<3;j++)
			{
				map.removeOverlay(cercles[i][j]);
			}
		}		
	}
}


/**
*	méthode générique: dessine un cercle
*/

function cercle(lat,lng,rayon,color,transparence)
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
	var epaisseur_trait = 1;
	var transparence_trait = 0.5;
	var a_circle = new GPolygon(circlepoints, couleur_trait,epaisseur_trait,transparence_trait,color, transparence);
	return a_circle;
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
	
	var oStructTemp = document.getElementById('st');
	if(oStructTemp.checked) 
	{
    		StructTemp(true);
	}
	else
	{
    		StructTemp(false);
	}
	var oRDV = document.getElementById('rdv');
	if(oRDV.checked)
		visibilite('rose','');
	else
		visibilite('rose','none');
}
window.onload = init;
window.unload = GUnload;
