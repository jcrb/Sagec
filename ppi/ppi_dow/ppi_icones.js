/**
  *		ppi_icones.js
  */



var baseIcon = new GIcon();
   baseIcon.iconSize=new GSize(32,32);
   baseIcon.shadowSize=new GSize(56,32);
   baseIcon.iconAnchor=new GPoint(16,32);
   baseIcon.infoWindowAnchor=new GPoint(16,0);

var baseIcon16 = new GIcon();
   baseIcon16.iconSize=new GSize(16,16);
   baseIcon16.shadowSize=new GSize(16,16);
   baseIcon16.iconAnchor=new GPoint(8,16);
   baseIcon16.infoWindowAnchor=new GPoint(4,0);
   
var normalIcon = new GIcon();
   normalIcon.iconSize=new GSize(20,34);
   normalIcon.shadowSize=new GSize(56,20);
   normalIcon.iconAnchor=new GPoint(10,32);
   normalIcon.infoWindowAnchor=new GPoint(16,0);



var violet_ico = new GIcon(baseIcon16, path + "images/pma_markers/violet16.png", null, "");
var ico_pma = new GIcon(baseIcon,path + "images/pma_markers/pma.png", null, "");
var ico_pma2 = new GIcon(baseIcon,path + "images/pma_markers/pma2.png", null, "");
var ico_pco = new GIcon(baseIcon,path + "images/pma_markers/pco.png", null, "");
var ico_hop2 = new GIcon(baseIcon, path + "images/pma_markers/hop2.png", null, "");
var ico_hop1 = new GIcon(baseIcon, path + "images/pma_markers/hop1.png", null, "");

var ico_heb = new GIcon(baseIcon, path + "images/pma_markers/ico20.png", null, "ico20s.png");
var ico_helico = new GIcon(baseIcon, path + "images/pma_markers/helico.png", null, "");

var ico_prm = new GIcon(baseIcon, path + "images/pma_markers/ico15.png", null, "ico15s.png");
var ico_ps1 = new GIcon(baseIcon,path + "images/pma_markers/ps1.png", null, "");
var ico_cht = new GIcon(baseIcon,path + "images/pma_markers/dansymf.gif", null, "");
var ico_pt = new GIcon(baseIcon, path + "images/pma_markers/icon15.png", null, "");
var ico_pcf = new GIcon(baseIcon, path + "images/pma_markers/pc.png", null, "");
var ico_umd = new GIcon(baseIcon,path +  "images/pma_markers/umd.png", null, "");
var ico_ufd = new GIcon(baseIcon, path + "images/pma_markers/ufd.png", null, "");
var ico_pp = new GIcon(baseIcon16, path + "images/pma_markers/pointPassage16.png", null, "");// points de passage
var ico_pc = new GIcon(baseIcon, path + "images/pma_markers/pc.png", null, "");

var ico_hop = new GIcon(baseIcon,  path + "images/logo-hopital.jpg", null, "");
var ico_cod = new GIcon(baseIcon,  path + "images/sidpc.png", null, "");
var ico_pcf =new GIcon(baseIcon,  path + "images/pma_markers/pc.png", null, "");
var ico_radio =new GIcon(baseIcon,  path + "images/pma_markers/radio.png", null, "");
var ico_samu =new GIcon(baseIcon, path + "images/pma_markers/c15.png", null, "");
var ico_sdis =new GIcon(baseIcon,  path + "images/pma_markers/sdis.png", null, "");


//var ico_pma = new GIcon(baseIcon, path + "utilitaires/google/icons/icon46.png", null, "");
//var ico_pco = new GIcon(baseIcon, path + "utilitaires/google/icons/icon53.png", null, "");

var ico_bcl = new GIcon(baseIcon, "images/Police2.png", null, "");
var chim_ico = new Array;
chim_ico[1] = new GIcon(normalIcon, "utilitaires/google/icons/iconb1.png", null, "");
chim_ico[2] = new GIcon(normalIcon, "utilitaires/google/icons/iconb2.png", null, "");
chim_ico[3] = new GIcon(normalIcon, "utilitaires/google/icons/iconb3.png", null, "");

/**
*	icone type
*	retourne l'icone correspondante au type
*
*	1 	Poste médical Avancé 	PMA
*	2 	Poste de commandement opérationnel 	PCO
*	3 	Poste de commandement fixe 	PCF
*	4 	Cellule de Crise 	CC
*	5 	Centre d'hébergement 	HEBER
*	6 	Point de rassemblement des victimes 	PRV
*	7 	Point de rassemblement des moyens 	PRM
*	8 	Point de bouclage 	BOUCLAGE
*	9 	Centre Médical d'évacuation 	CME
*	10 	Centre Opérationnel Départemental 	COD
*	11 	Point de transit 	PT
*	12 	Chantier 	CHT
*	13 	Poste de secours 	PS
*	14 	Structure exposée 	SEX
*	15 	Hopital 	HOP
*	16 	Centre de consultation 	CdC
*	17 	Centre de Coordination Sanitaire et Social 	CCSS
*	18 	Unité Mobile de Décontamination 	UMD
*	19 	Unité Fixe de Décontamination 	UFD
*	20 	Point de Passage 	PP
*	21 	Poste Médical Avancé (Dur) 	PMAD
*	22 	Relais Radio PSM 	RR
*	23 	Zone poser Helico 	DZ
*  24
*	25		SAMU
*	26		SDIS
*	99 	Indéterminé 	NAN
*/
function getIcone(type)
{
	var icone;
	switch(type)
	{
				case 1: icone = ico_pma;break;
				case 2: icone = ico_pco;break;
				case 3: icone = ico_pcf;break;
				case 4: icone = ico_pcf;break;
				case 5: icone = ico_heb;break;
				//case 6: icone = ico_pcf;break;
				case 7: icone = ico_prm;break;
				case 8: icone = ico_bcl;break;
				case 9: icone = ico_pcf;break;
				case 10: icone = ico_cod;break;
				case 11: icone = ico_pt;break;
				case 12: icone = ico_cht;break;
				case 13: icone = ico_ps1;break;
				//case 14: icone = ico_pcf;break;
				case 15: icone = ico_hop2;break;
				case 18: icone = ico_umd;break;
				case 19: icone = ico_ufd;break;
				case 20: icone = ico_pp;break;
				case 21: icone = ico_pma2;break;
				case 22: icone = ico_radio;break;
				case 23: icone = ico_helico;break;
				case 25: icone = ico_samu;break;
				case 26: icone = ico_sdis;break;
				default: icone = violet_ico;
	}
	return icone;
}

