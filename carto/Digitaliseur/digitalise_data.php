<?php
/**
* digitalise_data.php
*/
?>

	 var map;
    var polyShape;
    var polygonMode;
    var polygonDepth = "20";
    var polyPoints = [];
    var marker;
    var geocoder = null;

    var fillColor = "#0000FF"; // blue fill
    var lineColor = "#000000"; // black line
    var opacity = .5;
    var lineWeight = 2;

    var mode; // 0 ligne, 1 polygone, 2 point, 3 rien
    var mode_ligne = 0;
    var mode_polygone = 1;
    var mode_point = 2;
    var mode_null = 3;
    
    var fileMode;
    var modeTXT = 1;
    var modeKLM = 0;

    var kmlFillColor = "7dff0000"; // half-opaque blue fill
  

function load() 
{
	if (GBrowserIsCompatible()) 
	{
        map = new GMap2(document.getElementById("map"),{draggableCursor: 'crosshair', draggingCursor: 'move'});
        map.setCenter(new GLatLng(48.665556, 7.710556), 13);
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.enableDoubleClickZoom();
        keyboardhandler = new GKeyboardHandler(map);
        map.addControl(new GOverviewMapControl(new GSize(100,100)), new GControlPosition(G_ANCHOR_BOTTOM_RIGHT));
		  GEvent.addListener(map, 'click', mapClick);
        geocoder = new GClientGeocoder();
        mode = mode_ligne;
        fileMode = modeKLM;
        clearMap();
	}
}

/**
* point dans un polygone 
*/
/*
function pnpoly(xp, yp, x, y)
{ 
 var i, j, c = 0, npol = xp.length; 
 for (i = 0, j = npol-1; i < npol; j = i++) { 
  if ((((yp[i] <= y) && (y < yp[j])) ¦¦ 
((yp[j] <= y) && (y < yp[i]))) && 
(x < (xp[j] - xp[i]) * (y - yp[i]) / (yp[j] - yp[i]) + xp[i])) { 
   c =!c; 
  } 
 } 
 return c; 
} 
*/ 

// test ptInPoly(7.709827423095703, 48.667656995926166);
function ptInPoly(x, y)
{
	var i, j, c = 0, npol = polyPoints.length;
	polyPoints.push(polyPoints[0]);
	npol++;
 	for (i = 0; i < npol-1; i++) 
 	{ 
 		xpi = polyPoints[i].lat();
 		ypi = polyPoints[i].lng();
 		xpj = polyPoints[i+1].lat();
 		ypj = polyPoints[i+1].lng();
  		if ((((ypi <= y) && (y < ypj)) || ((ypj <= y) && (y < ypi))) && (x < (xpj - xpi) * (y - ypi) / (ypj - ypi) + xpi))
  		{ 
   		c =!c; 
  		} 
 	} 
 return c; 
}
   
// Clear current Map
function clearMap()
{
	map.clearOverlays();
	polyPoints = [];
	document.getElementById("coords").value ="&lt;-- Click on the map to digitize!";
}


// Toggle from Polygon PolyLine mode
function toggleDrawMode()
{
      	for( i=0;i<4;i++)
			if(document.getElementsByName("drawMode")[i].checked)
				mode = i;
		//alert(mode);
		if(mode != mode_null)
        map.clearOverlays();
      polyShape = null;
        //alert("az");
        //drawCoordinates();
}
  
/**
*	toggleFileMode()
*/
function toggleFileMode()
      {
      	for( i=0;i<2;i++)
			if(document.getElementsByName("fileMode")[i].checked)
				fileMode = i;
			
			var c = ptInPoly(48.667656995926166,7.709827423095703);
			alert(c);
}


// Delete last Point
// This function removes the last point from the Polyline/Polygon and redraws
// map.

function deleteLastPoint()
{
	map.removeOverlay(polyShape);
	// pop last element of polypoint array
	polyPoints.pop();
	drawCoordinates();
}

// mapClick - Handles the event of a user clicking anywhere on the map
// Adds a new point to the map and draws either a new line from the last point
// or a new polygon section depending on the drawing mode.
function mapClick(marker, clickedPoint)
{
	//polygonMode = document.getElementById("drawMode_polygon").checked;

	// Push onto polypoints of existing polygon
	//polyPoints.push(clickedPoint);
	drawCoordinates(clickedPoint);
}

// drawCoordinates
function drawCoordinates(pt)
{
      //Re-create Polyline/Polygon

		if(mode == mode_polygone)
		{
			// Push onto polypoints of existing polygon
      	polyPoints.push(pt);
        	polyShape = new GPolygon(polyPoints,lineColor,lineWeight,opacity,fillColor,opacity);
		}
		else if(mode == mode_ligne)
		{
			polyPoints.push(pt);
        	polyShape = new GPolyline(polyPoints,lineColor,lineWeight,opacity);
		}
	else if(mode == mode_point)
	{
		//marker = new GMarker(pt);
		//map.addOverlay(marker);
	}
	
	if(mode != mode_null)
	{
      map.clearOverlays();
      // Grab last point of polyPoints to add marker
      marker = new GMarker(pt);
      map.addOverlay(marker);
      map.addOverlay(polyShape);
      logCoordinates();
    }
}


    // logCoordinates - prints out coordinates of global polyPoints array
    //  This version only logs KML, but could be extended to log different types of output

function logCoordinates()
{

	var header = "";
	if(fileMode == modeKLM)
	{<!--
		header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" +
		"<kml xmlns=\"http://earth.google.com/kml/2.1\">\n" +
		"<Document><name>Your name of document</name><description>Your description</description>\n" +
		"<Placemark><Style>\n<LineStyle><width>" + lineWeight + "</width></LineStyle>\n<PolyStyle><color>" +
		kmlFillColor +"</color></PolyStyle>\n</Style>\n";
		-->
	}
	
	var footer="";

	// check mode
	//if (polygonMode)
	if(mode == mode_polygone)
	{
		if(fileMode == modeKLM)
		{
			header += "<Polygon><extrude>1</extrude>\n<altitudeMode>relativeToGround</altitudeMode>" +
		       "<outerBoundaryIs>\n<LinearRing>\n<coordinates>\n";

			footer = "</coordinates></LinearRing></outerBoundaryIs></Polygon></Placemark>\n</Document>\n</kml>";
		}
		else
			header+= "# polygone\n";

      // print coords header
      document.getElementById("coords").value =  header;

      // loop to print coords
		for (var i = 0; i < polyPoints.length; i++)
		{
			var lat = polyPoints[i].lat();
         var lng = polyPoints[i].lng();
	   	document.getElementById("coords").value += lng + ", " + lat + ", "+ polygonDepth + "\n";
		}
		document.getElementById("coords").value +=  footer;
	}
	else if(mode == mode_ligne)
	{
		if(fileMode == modeKLM)
		{
			header += "<LineString><tessellate>1</tessellate>\n<coordinates>\n";
			footer = "</coordinates></LineString></Placemark>\n</Document>\n</kml>";
		}
		else
			header+= "# ligne\n";
		// print coords header
		document.getElementById("coords").value =  header;
		// loop to print coords
		for (var i = 0; i< polyPoints.length; i++)
		{
          var lat = polyPoints[i].lat();
          var longi = polyPoints[i].lng();
          document.getElementById("coords").value += longi + ", " + lat + ",0\n";
		}
		document.getElementById("coords").value +=  footer;
	}
	else if(mode == mode_point)
	{

	}
}


function showAddress(address) 
{
	if (geocoder)
	{
		geocoder.getLatLng(address,
         function(point) 
         {
           if (!point) 
           {
             alert(address + " non trouvée");
           } 
           else
           {
	     			clearMap();
             	map.setCenter(point, 13);
           }
         }
       );
	}
}

window.onload = init;
window.unload = GUnload;