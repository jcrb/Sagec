<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//---------------------------------------------------------------------------------------------------------
/**
* 	
*	@programme 		pie_artichow.php
*	@date de création: 	01/03/2007
*	@author jcb
*	@version $Id$
*	@update le 01/03/2007
*	@version 1.0
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once "../artichow/Pie.class.php";
require("../date.php");

$value = $_REQUEST['values'];
$value = unserialize($_REQUEST['values']);
$titre = $_REQUEST['titre'];
//
$colors = array(new LightOrange, new LightPurple);
$graph = new Graph(500,250);
$graph->title->set($titre);
$graph->setAntiAliasing(TRUE);
$plot = new Pie($value,$colors);
$plot->setCenter(0.3,0.53);
$plot->setAbsSize(200,200);
$plot->setStartAngle(234);

$plot->setLegend(array('lits disponibles','lits occupés'));
$plot->setLabelPosition(-40);
$plot->setPadding(2,2,2,2);
$plot->legend->setPosition(2.0);

$graph->add($plot);
$graph->draw();
?>