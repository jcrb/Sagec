<?php
$BackToRoot = "../../";

require_once $BackToRoot."classes/dao/veille/EvenementSpecial.class.php";

require_once $BackToRoot."classes/objet/veille/EvtSpe.class.php";
require_once $BackToRoot."classes/objet/veille/EvtSpeChamp.class.php";

require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";

//$vEtablissement = new Objet_Structure_Etablissement;
//$vEtablissement->setId(6);
//
//$vListeEvenement = Dao_Veille_EvenementSpecial::ChercheEvtSpParEtablissement($vEtablissement);
//var_dump($vListeEvenement);

//$vEvenement = new Objet_Veille_EvtSpe();
//$vEvenement->setId(1);
//
//$vListeData = Dao_Veille_EvenementSpecial::ChercheDonneesPourEvenement($vEvenement);
//var_dump($vListeData);

//$vEvenement = new Objet_Veille_EvtSpe();
//$vEvenement->setId(1);
//
//$vListeChamps =  Dao_Veille_EvenementSpecial::ChercheChampsParEvenement($vEvenement);
//var_dump($vListeChamps);

require_once $BackToRoot."classes/dao/structure/administratif/Region.class.php";
require_once $BackToRoot."classes/dao/structure/Etablissement.class.php";

$vRegionObj = Dao_Structure_Administratif_Region::getInstance();
$vRegion =$vRegionObj->ChercheRegionParCode(42);
		
var_dump (Dao_Structure_Etablissement::ChercheEtablissementParStrucAdministrative($vRegion));
?>