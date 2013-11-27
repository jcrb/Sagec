/**
 * ppi_pmc_data.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */

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

/**
	Crée un marqueur à l'endroit point, avec l'image icon et lui associe un évènement Click
	En cas de click affiche une fenêtre avec le contenu html
*/
function createMarker(point,html,icon)
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function(){marker.openInfoWindowHtml(html);});
	return marker;
}

/*  
  load(longitude,latitude,altitude)
  Méthode principale de dessin
  @param longitude   
  @param latitude
  @param altitude
*/
function load(longitude,latitude,altitude) 
{
      if (GBrowserIsCompatible()) {

        	map = new GMap2(document.getElementById("map"));
        	
        	GEvent.addListener(map, 'mousemove', mouseMove);
        	
			// bloque le dragging de la carte
			// map.disableDragging();

			// Display the map, with some controls and set the initial location 
      	map.addControl(new GLargeMapControl());
      	map.addControl(new GMapTypeControl());
			
			// centrage de la carte sur le point recherché
        	map.setCenter(new GLatLng(latitude, longitude), altitude);
			
			// ajouter l'échelle
			map.addControl(new GScaleControl());
			
			// ajouter l'outil de zooming et choisit l'outil carte par défaut
			map.addControl(new GLargeMapControl());
			//map.setMapType(G_SATELLITE_TYPE); // Vue satelite
			map.setMapType(G_MAP_TYPE); // Vue carte
			//map.setMapType(G_HYBRID_TYPE); // Vue mixte
			
			
			// création d'un marqueur pour la commune recherchée
			var maCommune = new GPoint(longitude, latitude);
     		
     		// Création d'un panneau d'affichage si clic sur le repère communal
      	var marker = createMarker(maCommune,'<div style="width:140px">Longitude: '+longitude +' latitude: '+latitude+'. With a <a href="http://sagec67.chru-strasbourg.fr">Voir</a> Fiche technique</div>')
     		map.addOverlay(marker);
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
}