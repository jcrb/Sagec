<?php
$BackToRoot = "../../";

require_once $BackToRoot."classes/objet/structure/Etablissement.class.php";
require_once $BackToRoot."classes/metier/Service.class.php";
require_once $BackToRoot."classes/metier/util/Date.class.php";

$vTs = Metier_Util_Date::StringDateVersTimestamp("23/03/2009 16:59:30");
echo $vTs;

$vOrganisme = null;
$vEtablissement = new Objet_Structure_Etablissement;
$vEtablissement->setId(7);
$vServiceL = null;

$vService = new Metier_Service;

$vListeServiceLit = $vService->ChercheListeServiceDerJournalParEtab($vOrganisme, $vEtablissement, $vServiceL);

// pour la liste
foreach ($vListeServiceLit as $vServiceLit){
	echo $vServiceLit->getNom()." - ".$vServiceLit->getLitsDisponibles()." - ".Metier_Util_Date::TimestampDateVersString($vServiceLit->getDateMaj())."<br>\n";
}

// lits disponible par type de service
$vRepartitionServiceParTypeService = $vService->ListeRepartitionServiceParTypeService($vListeServiceLit);

foreach ($vRepartitionServiceParTypeService as $vTypeService=>$vNombre){
	echo $vTypeService.": ".$vNombre."<br>\n";
}

?>