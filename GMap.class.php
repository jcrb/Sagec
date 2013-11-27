<?php
/**
 * Project:     GMap: classe interface pour Google Map API
 * File:        GMap.class.php
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please send a e-mail to
 * jcb-bartier@wanadoo.fr
 * 
 * @link http://www.phpinsider.com/php/code/GoogleMapAPI/
 * @copyright 2006 JCB
 * @author JC Bartier <jcb-bartier@wanadoo.fr>
 * @package SAGEC67
 * @version 1.0
 */

class GMap {
//================================= VARIABLES ==========================================
    /**
     * version number
     *
     * @var string
     */
    var $_version = '1.0';

 	/**
     * identifiant de la carte et du conteneur <DIV>, ou apparaitra la carte
     * the GoogleMapAPI object.
     *
     * @var string
     */
    var $map_id = null;

	/**
     * sidebar <div> used along with this map.
     *
     * @var string
     */
    var $sidebar_id = null;

	    /**
     * determines if sidebar is enabled
     *
     * @var boolean
     */
    var $sidebar = true;    

    /**
     * determines if to/from directions are included inside info window
     *
     * @var boolean
     */
    var $directions = true;

	/**
     * Identifiant spécifique fournit par google map pour ce programme.
     * (http://maps.google.com/apis/maps/signup.html)
	 *
     * @var string
     */
    var $api_key = 'ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS5u1nAG4uSd7t1qAnJ_TFOSdaPdBQ7Vq8M6vT5wPThrBtK6O6z4mB3Og';//localhost
	//var $api_key = 'ABQIAAAAOiFPV0Y5zzLw7M6z-aRD5RS4M0VztE0O-QJMMgCt9di7cKfD1RRqOuGcbIuRW0zmeP9ety1-dA17AA';//HUS

/**
     * default map type (G_NORMAL_MAP/G_SATELLITE_MAP/G_HYBRID_MAP)
     *
     * @var boolean
     */
    var $map_type = 'G_NORMAL_MAP';
	
	/**
     * utiliser onLoad() pour charger le code javascript de la carte.
     * si activé, il faut inclure dans la page web:
     * <html onload="onLoad()">
     *
     * @var string
     */
    var $onload = true;
    
    /**
     * centrage de la carte: latitude (horizontal)
     * calculated automatically as markers
     * are added to the map.
     *
     * @var float
     */
    var $center_lat = 48.585;

    /**
     * centrage de la carte: longitude (vertical)
     * calculated automatically as markers
     * are added to the map.
     *
     * @var float
     */
    var $center_lon = 7.736;
    
    /**
     * active les contrôles (zoom/move/center)
     *
     * @var boolean
     */
    var $map_controls = true;

	/**
     * determine le niveau de zoom par défaut
     *
     * @var integer
     */
    var $zoom = 13;

    /**
     * determine la largeur de la carte par défaut
     *
     * @var integer
     */
    var $width = '500px';
    
    /**
     * determine la hauteur de la carte par défaut
     *
     * @var integer
     */
    var $height = '500px';

    /**
     * message qui apparait si le browser est incompatible avec Google Maps.
     * set to empty string to disable.
     *
     * @var integer
     */
    var $browser_alert = 'Désolé, Google Maps API est incompatible avec cet explorateur internet.';
    
    /**
     * message qui apparait si javascript est inactivé.
     * set to empty string to disable.
     *
     * @var string
     */
    var $js_alert = '<b>Javascript doit être activé pour pouvoir utiliser Google Maps.</b>';

	 /**
     * determines the map control type
     * small -> show move/center controls
     * large -> show move/center/zoom controls
     *
     * @var string
     */
    var $control_size = 'large';

    /**
     * enables map type controls (map/satellite/hybrid)
     *
     * @var boolean
     */
    var $type_controls = true;

/**
     * enables scale map control
     *
     * @var boolean
     */
    var $scale_control = true;

    /**
     * enables overview map control
     *
     * @var boolean
     */
    var $overview_control = false;  

/**
     * list of added markers
     *
     * @var array
     */
    var $_markers = array();
    
    /**
     * maximum longitude of all markers
     * 
     * @var float
     */
    var $_max_lon = -1000000;
    
    /**
     * minimum longitude of all markers
     *
     * @var float
     */
    var $_min_lon = 1000000;
    
    /**
     * max latitude
     *
     * @var float
     */
    var $_max_lat = -1000000;
    
    /**
     * min latitude
     *
     * @var float
     */
    var $_min_lat = 1000000;

 /**
     * list of added polylines
     *
     * @var array
     */
    var $_polylines = array();    
    
    /**
     * icon info array
     *
     * @var array
     */
    var $_icons = array();

//================================= METHODES ===========================================
    /**
     * class constructor
     *
     * @param string $map_id the id for this map
     */
    function GMap($map_id = 'map') {
        $this->map_id = $map_id;
        $this->sidebar_id = 'sidebar_' . $map_id;
    }

	/**
     * écrit l'entête javascript de la carte(se place entre <head></head>)
     * 
     */
    function printHeaderJS() {
        echo $this->getHeaderJS();   
    }
    
    /**
     * retourne l'entête javascript de la carte(se place entre  <head></head>)
     * 
     */
    function getHeaderJS() {
        return sprintf('<script src="http://maps.google.com/maps?file=api&v=2&key=%s" type="text/javascript" charset="utf-8"></script>', $this->api_key);
    }  

	/**
     * retourne le code javascript pour dessiner la carte
     * 
     */
    function getMapJS() {
        $_output = '<script type="text/javascript" charset="utf-8">' . "\n";
        $_output .= '//<![CDATA[' . "\n";
        $_output .= "/*************************************************\n";
        $_output .= " * Created with GoogleMapAPI " . $this->_version . "\n";
        $_output .= " * Author: Monte Ohrt <monte AT ohrt DOT com>\n";
        $_output .= " * Copyright 2005-2006 New Digital Group\n";
        $_output .= " * http://www.phpinsider.com/php/code/GoogleMapAPI/\n";
        $_output .= " *************************************************/\n"; 
		// méthodes spécifiques en fonction des choix de l'utilisateur 
		$_output .= 'var points = [];' . "\n";
        $_output .= 'var markers = [];' . "\n";
        $_output .= 'var counter = 0;' . "\n";
        if($this->sidebar) {        
            $_output .= 'var sidebar_html = "";' . "\n";
            $_output .= 'var marker_html = [];' . "\n";
        }

        if($this->directions) {        
            $_output .= 'var to_htmls = [];' . "\n";
            $_output .= 'var from_htmls = [];' . "\n";
        }        

		if(!empty($this->_icons)) {
            $_output .= 'var icon = [];' . "\n";
            for($i = 0; $this->_icons[$i]; $i++) {
                $info = $this->_icons[$i];

                // hash the icon data to see if we've already got this one; if so, save some javascript
                $icon_key = md5(serialize($info));
                if(!is_numeric($exist_icn[$icon_key])) {
                    $exist_icn[$icon_key] = $i;

                    $_output .= "icon[$i] = new GIcon();\n";   
                    $_output .= sprintf('icon[%s].image = "%s";',$i,$info['image']) . "\n";   
                    if($info['shadow']) {
                        $_output .= sprintf('icon[%s].shadow = "%s";',$i,$info['shadow']) . "\n";
                        $_output .= sprintf('icon[%s].shadowSize = new GSize(%s,%s);',$i,$info['shadowWidth'],$info['shadowHeight']) . "\n";   
                    }
                    $_output .= sprintf('icon[%s].iconSize = new GSize(%s,%s);',$i,$info['iconWidth'],$info['iconHeight']) . "\n";   
                    $_output .= sprintf('icon[%s].iconAnchor = new GPoint(%s,%s);',$i,$info['iconAnchorX'],$info['iconAnchorY']) . "\n";   
                    $_output .= sprintf('icon[%s].infoWindowAnchor = new GPoint(%s,%s);',$i,$info['infoWindowAnchorX'],$info['infoWindowAnchorY']) . "\n";
                } else {
                    $_output .= "icon[$i] = icon[$exist_icn[$icon_key]];\n";
                }
            }
        }
                           
        $_output .= 'var map = null;' . "\n";

		if($this->onload) {
           $_output .= 'function onLoad() {' . "\n";   
        }
                
        if(!empty($this->browser_alert)) {
            $_output .= 'if (GBrowserIsCompatible()) {' . "\n";
        }

        $_output .= sprintf('var mapObj = document.getElementById("%s");',$this->map_id) . "\n";
        $_output .= 'if (mapObj != "undefined" && mapObj != null) {' . "\n";
        $_output .= sprintf('map = new GMap2(document.getElementById("%s"));',$this->map_id) . "\n";
        if(isset($this->center_lat) && isset($this->center_lon)) {
            $_output .= sprintf('map.setCenter(new GLatLng(%s, %s), %s, %s);', $this->center_lat, $this->center_lon, $this->zoom, $this->map_type) . "\n";
        }
		if($this->map_controls) {
          if($this->control_size == 'large')
              $_output .= 'map.addControl(new GLargeMapControl());' . "\n";
          else
              $_output .= 'map.addControl(new GSmallMapControl());' . "\n";
        }
        if($this->type_controls) {
            $_output .= 'map.addControl(new GMapTypeControl());' . "\n";
        }
        
        if($this->scale_control) {
            $_output .= 'map.addControl(new GScaleControl());' . "\n";
        }

        if($this->overview_control) {
            $_output .= 'map.addControl(new GOverviewMapControl());' . "\n";
        }
        
        $_output .= $this->getAddMarkersJS();

        $_output .= $this->getPolylineJS();

        if($this->sidebar) {
            $_output .= sprintf('document.getElementById("%s").innerHTML = "<ul class=\"gmapSidebar\">"+ sidebar_html +"</ul>";', $this->sidebar_id) . "\n";
        }

        $_output .= '}' . "\n";        
		$_output .= '}}' . "\n";

		$_output .= "/*************************************************/\n";
		$_output .= '//]]>' . "\n";
        $_output .= '</script>' . "\n";
        return $_output;
	}

	    /**
     * print map javascript (put just before </body>, or in <header> if using onLoad())
     * 
     */
    function printMapJS() {
        echo $this->getMapJS();
    }

/**
     * print map (put at location map will appear)
     * 
     */
    function printMap() {
        echo $this->getMap();
    }

    /**
     * return map
     * 
     */
    function getMap() {
        $_output = '<script type="text/javascript" charset="utf-8">' . "\n" . '//<![CDATA[' . "\n";
        $_output .= 'if (GBrowserIsCompatible()) {' . "\n";
        if(strlen($this->width) > 0 && strlen($this->height) > 0) {
            $_output .= sprintf('document.write(\'<div id="%s" style="width: %s; height: %s"></div>\');',$this->map_id,$this->width,$this->height) . "\n";
        } else {
            $_output .= sprintf('document.write(\'<div id="%s"></div>\');',$this->map_id) . "\n";     
        }
        $_output .= '}';

        if(!empty($this->js_alert)) {
            $_output .= ' else {' . "\n";
            $_output .= sprintf('document.write(\'%s\');', $this->js_alert) . "\n";
            $_output .= '}' . "\n";
        }

        $_output .= '//]]>' . "\n" . '</script>' . "\n";

        if(!empty($this->js_alert)) {
            $_output .= '<noscript>' . $this->js_alert . '</noscript>' . "\n";
        }

        return $_output;
    }

/**
     * overridable function for generating js to add markers
     */
    function getAddMarkersJS() {
        $SINGLE_TAB_WIDTH = 88;    // constant: width in pixels of each tab heading (set by google)
        $i = 0;
        $_output = '';
        foreach($this->_markers as $_marker) {
            if(is_array($_marker['html'])) {
                // warning: you can't have two tabs with the same header. but why would you want to?
                $ti = 0;
                $num_tabs = count($_marker['html']);
                $tab_obs = array();
                foreach($_marker['html'] as $tab => $info) {
                    if($ti == 0 && $num_tabs > 2) {
                        $width_style = sprintf(' style=\"width: %spx\"', $num_tabs * $SINGLE_TAB_WIDTH);
                    } else {
                        $width_style = '';
                    }
                    $tab = str_replace('"','\"',$tab);
                    $info = str_replace('"','\"',$info);
                    $tab_obs[] = sprintf('new GInfoWindowTab("%s", "%s")', $tab, '<div id=\"gmapmarker\"'.$width_style.'>' . $info . '</div>');
                    $ti++;
                }
                $iw_html = '[' . join(',',$tab_obs) . ']';
            } else {
                $iw_html = sprintf('"%s"',str_replace('"','\"','<div id="gmapmarker">' . $_marker['html'] . '</div>'));
            }
            $_output .= sprintf('var point = new GLatLng(%s,%s);',$_marker['lat'],$_marker['lon']) . "\n";         
            $_output .= sprintf('var marker = createMarker(point,"%s",%s, %s);',
                                str_replace('"','\"',$_marker['title']),
                                $iw_html,
                                $i) . "\n";
            //TODO: in above createMarker call, pass the index of the tab in which to put directions, if applicable
            $_output .= 'map.addOverlay(marker);' . "\n";
            $i++;
        }
        return $_output;
    }
    
/**
     * overridable function to generate polyline js
     */
    function getPolylineJS() {
        $_output = '';
        foreach($this->_polylines as $_polyline) {
            $_output .= sprintf('var polyline = new GPolyline([new GLatLng(%s,%s),new GLatLng(%s,%s)],"%s",%s,%s);',
                    $_polyline['lat1'],$_polyline['lon1'],$_polyline['lat2'],$_polyline['lon2'],$_polyline['color'],$_polyline['weight'],$_polyline['opacity'] / 100.0) . "\n";
            $_output .= 'map.addOverlay(polyline);' . "\n";
        }
        return $_output;
    }

/**
     * adds a map marker by address
     * 
     * @param string $address the map address to mark (street/city/state/zip)
     * @param string $title the title display in the sidebar
     * @param string $html the HTML block to display in the info bubble (if empty, title is used)
     */
    function addMarkerByAddress($address,$title = '',$html = '') {
        if(($_geocode = $this->getGeocode($address)) === false)
            return false;
        return $this->addMarkerByCoords($_geocode['lon'],$_geocode['lat'],$title,$html);
    }

    /**
     * print sidebar (put at location sidebar will appear)
     * 
     */
    function printSidebar() {
        echo $this->getSidebar();
    }    

    /**
     * return sidebar html
     * 
     */
    function getSidebar() {
        return sprintf('<div id="%s"></div>',$this->sidebar_id) . "\n";
    }    

	/**
     * mémorise la clé Google Map API
     *
     * @param string $key
     */
    function setAPIKey($key) {
        $this->api_key = $key;   
    }

	/**
     * sets the width of the map
     *
     * @param string $width
     */
    function setLargeur($width) {
        if(!preg_match('!^(\d+)(.*)$!',$width,$_match))
            return false;

        $_width = $_match[1];
        $_type = $_match[2];
        if($_type == '%')
            $this->width = $_width . '%';
        else
            $this->width = $_width . 'px';
        
        return true;
    }

    /**
     * sets the height of the map
     *
     * @param string $height
     */
    function setHauteur($height) {
        if(!preg_match('!^(\d+)(.*)$!',$height,$_match))
            return false;

        $_height = $_match[1];
        $_type = $_match[2];
        if($_type == '%')
            $this->height = $_height . '%';
        else
            $this->height = $_height . 'px';
        
        return true;
    }        

    /**
     * sets the default map zoom level
     *
     * @param string $level
     */
    function setZoomLevel($level) {
        $this->zoom = (int) $level;
    } 
}
?>