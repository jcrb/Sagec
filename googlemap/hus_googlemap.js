/**
* pour le menu latéral
*	@version $Id: hus_googlemap.js 29 2008-01-13 22:52:31Z jcb $
*/

var side_bar_html = "";
// tableau pour garder une trace des markers utilisé par le menu latéral
var gmarkers = [];
var i = 0;
var map = null;
var geocoder = null;

/*
	Fonction de création de point et utilisation des icones
	Si la var icon est vide, c'est l'icone standard rouge qui est utilisée
*/
	function createMarker(point,icon) 
	{
		var marker = new GMarker(point, icon);
		return marker;
	}

/*
	Fonction de création de point avec légende et utilisation des icones
*/
function createMarker2(point, legende,icon) 
{
		var marker = new GMarker(point, icon);
		GEvent.addListener(marker, 'click', function() {
		marker.openInfoWindowHtml(legende);
		});
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
      	// La carte sera dessinée dans un conteneur de type <DIV> appelé "map"
        	map = new GMap2(document.getElementById("map"));
        	
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
			
			// création d'un marqueur pour la commune recherchée
			//var maCommune = new GPoint(longitude, latitude);
			//var marker = createMarker(maCommune,"");
			//map.addOverlay(marker);
			
			// Création d'un panneau d'affichage si clic sur le repère communal
			var maCommune = new GPoint(longitude, latitude);
      	var marker = createMarker2(maCommune,'<div>Longitude: '+longitude +'<br> latitude: '+latitude+'.<br><a href="http://sagec67.chru-strasbourg.fr">Voir</a> Fiche technique</div>',"")
     		map.addOverlay(marker);
      }
}
    
