 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Map code</title>
    <style type="text/css">
    v\:* {
      behavior:url(#default#VML);
    }
    </style>
    <script src="http://maps.google.com/maps?file=api&v=2&key=abcdefg"
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    // Google Map code generator
    // Mobilefish.com
    // http://www.mobilefish.com/services/googlemap/googlemap.php
    var map = null;
    var geocoder = null;
    function load() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"), {draggableCursor: 'crosshair', draggingCursor: 'move'});
        map.setCenter(new GLatLng(48.669523,7.707369), 12);
        map.addControl(new GLargeMapControl(), new GControlPosition(G_ANCHOR_TOP_LEFT));
        map.addControl(new GMapTypeControl(), new GControlPosition(G_ANCHOR_TOP_RIGHT));
        map.setMapType(G_HYBRID_MAP);
        map.addControl(new GScaleControl(), new GControlPosition(G_ANCHOR_BOTTOM_RIGHT));
        map.addControl(new GOverviewMapControl(new GSize(100,100)), new GControlPosition(G_ANCHOR_TOP_LEFT));
        map.enableDoubleClickZoom();
        keyboardhandler = new GKeyboardHandler(map);
        geocoder = new GClientGeocoder();
      }
    }
    function showAddress(address) {
      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              alert(address + " not found");
            } else {
              map.setCenter(point, 13);
              var marker = new GMarker(point);
              map.addOverlay(marker);
              marker.openInfoWindowHtml(address);
            }
          }
        );
      }
    }
    //]]>
    </script>
  </head>
  <body onload="load()" onunload="GUnload()">
    <form action="#" name="inputFormGoogleMap">
      <input type="text" size="60" name="address" value="" />
      <input type="button" value="Search" onclick="javascript:showAddress(document.inputFormGoogleMap.address.value); return false" />
    </form>
    <div id="map" style="width:500px; height:500px"></div>
  </body>
</html>
{draggableCursor: 'crosshair', draggingCursor: 'move'}