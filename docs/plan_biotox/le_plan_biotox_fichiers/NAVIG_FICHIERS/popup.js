bNavigatorName = navigator.appName;
bNavigatorVer = parseInt(navigator.appVersion);

/************************************************************
Nom : pu_Open
Fonction : Ouvre une page dans un pop-up
Variable : bUrl = URL de la page
           bName = nom de la pop-up
           bWidth = largeur de la pop-up
           bHeight = hauteur de la pop-up
Auteur : Xavier CANY
Date : 4 Avril 1997
**************************************************************/
function pu_Open(bUrl, bName, bWidth, bHeight)
{
  var viewerpop = window.open(bUrl,bName,'location=no,toolbar=no,directories=no,menubar=no,resizable=yes,scrollbars=auto,status=no,width='+bWidth+',height='+bHeight);
  if( bNavigatorName == "Netscape" && bNavigatorVer >= 3 )
    viewerpop.focus();
  else if( bNavigatorName=="Microsoft Internet Explorer" && bNavigatorVer > 3 )
    viewerpop.focus();
}

