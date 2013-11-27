<?php
/**
* @package Sagec
* @author JCB
* @version $Id: googlemap.js 29 2008-01-13 22:52:31Z jcb $
*/
?>
		// pour le menu latéral
	var side_bar_html = "";
	// tableau pour garder une trace des markers utilisé par le menu latéral
	var gmarkers = [];
	var i = 0;

	var map = null;
   var geocoder = null;
	var ville_id = <?php echo $_REQUEST['ville_ID']?>;
	
	// Fonction de création de point et utilisation des icones
	function createMarker(point,icon) 
	{
		var marker = new GMarker(point, icon);
		return marker;
	}

	// Fonction de création de point avec légende et utilisation des icones
	function createMarker2(point, legende) 
	{
		var marker = new GMarker(point, icon);
		GEvent.addListener(marker, 'click', function() {
		marker.openInfoWindowHtml(legende);
		});
		return marker;
	}

/**
	affiche une marque sur un point correspondant à une adresse
	Pharmacie de Monswiller: 20 r Gén Leclerc 67700 Monswiller 
*/
	function showAddress(address,texte) 
	{
		if(!geocoder) {
        // si le geocoder n'a pas été utilisé, on l'instancie
        geocoder = new GClientGeocoder();
    	}
		if (geocoder) 
		{
        	geocoder.getLatLng(address,function(point) 
			{
				if (!point) 
				{
					alert(address + " introuvable");
     			} 
				else 
				{
            	map.setCenter(point, 16);
              	var marker = new GMarker(point);
              	map.addOverlay(marker);
              	marker.openInfoWindowHtml(texte + '<br>'+address);
            }
          });
		}
	}

// A function to create the marker and set up the event window
// Dont try to unroll this function. It has to be here for the function closure
// Each instance of the function preserves the contends of a different instance
// of the "marker" and "html" variables which will be needed later when the event triggers.    

	function createMarker(point,html,icon) {
        var marker = new GMarker(point,icon);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
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
			//map.setMapType(G_HYBRID_TYPE); // Vue mixte

			// Création de mini icones
			var icon = new GIcon();
				//icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
				//icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
				icon.image = "./../images/marker_GREEN.png";
				icon.shadow = "./../images/marker_shadow.png";
				icon.iconSize = new GSize(12, 20);
				icon.shadowSize = new GSize(22, 20);
				icon.iconAnchor = new GPoint(6, 20);
				icon.infoWindowAnchor = new GPoint(5, 1);
				
			// création d'un marqueur pour la commune recherchée
			var maCommune = new GPoint(longitude, latitude);
			var marker = createMarker(maCommune,icon.image);
			map.addOverlay(marker);
		    
      	// Set up three markers with info windows 
     		// var point = new GLatLng(43.65654,-79.90138);
     		
     		// Création d'un panneau d'affichage si clic sur le repère communal
      	var marker = createMarker(maCommune,'<div style="width:140px">Longitude: '+longitude +' latitude: '+latitude+'. With a <a href="http://sagec67.chru-strasbourg.fr">Voir</a> Fiche technique</div>')
     		map.addOverlay(marker);

		//marker = createMarker2(eiffel, "La Gare");
		//map.addOverlay(marker);

		// un deuxième point
		//eiffel = new GPoint(longitude+0.005, latitude);
		//marker = createMarker(eiffel,icon.image);
		//map.addOverlay(marker);

		//map.addOverlay(new GPolyline(gPointArray, '#FF6600', 4, 0.5));

		
		
		
		//showAddress("20 r Général Leclerc, 67700 Monswiller, france","Pharmacie de Monswiller<br>03 88 11 17 17");
      }
    }
    
    function analyseMenu()
    {
    	var oPharma = document.getElementById('pharma');
		if(oPharma.checked)
			pharmacies(true);
		else
			pharmacies(false);
		
		var oMed = document.getElementById('med');
		if(oMed.checked)
			medecins(true);
		else
			medecins(false);
			
		var oPma = document.getElementById('pma');
		if(oPma.checked)
			pma_marche_noel(true);
		else
			pma_marche_noel(false);
    }