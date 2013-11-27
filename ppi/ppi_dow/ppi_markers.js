/**
  *	ppi_markers.js
  * boite à outils spécialisées dns l'affichage des marqueurs
  */
  
/**
 * addMarker
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
 * addMarker
 * @access public
 * @return void
 **/
function addMapMarker(latitude,longitude,description,mapp){
	var marker = new GMarker(new GLatLng(latitude,longitude));
	GEvent.addListener(marker,'click',
		function(){
			marker.openInfoWindowHtml(description);
		}
	)
	mapp.addOverlay(marker);
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
	GEvent.addListener(marker, "click", function() 
	{
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
