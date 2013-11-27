MAX_ROLLS = 20;
MAX_ARRAY = 4;
var vRollsCount = 0;
var aRolls = new Array(MAX_ROLLS);
bLockName = "";
var vLockNb = 0;

/************************************************************
Nom : ro_Change
Fonction : Change une image dans un "roll over"
Variable : bImgId = nom de l'image
           vMode = indice de l'image
Auteur : Xavier CANY
Date : 6 Novembre 1998
**************************************************************/
function ro_Change( bImgId, vMode )
{
  for( i=0; i<vRollsCount; i++)
    if( aRolls[i][0] == bImgId ){
      if( bImgId == bLockName )
        return;
      document.images[bImgId].src = aRolls[i][vMode+1].src;
      return;
    }

  aRolls[vRollsCount] = new Array( MAX_ARRAY );
  aRolls[vRollsCount][0] = bImgId;
  for( i = 0; i < MAX_ARRAY; i++ ){
    aRolls[vRollsCount][i+1] = new Image;
    aRolls[vRollsCount][i+1].src = document.images[bImgId].src.substring(0,document.images[bImgId].src.lastIndexOf("/"))+"/"+bImgId+"_"+i+".gif";
//    alert( "aRolls["+vRollsCount+"]["+(i+1)+"].src = "+aRolls[vRollsCount][i+1].src );
  }

  document.images[bImgId].src = aRolls[vRollsCount][vMode+1].src;

  vRollsCount++;
  return;

}

/************************************************************
Nom : ro_Lock
Fonction : Bloque une image dans un "roll over"
Variable : bImgId = nom de l'image
           vNb = indice de l'image pour l'unlock
Auteur : Xavier CANY
Date : 10 Novembre 1998
**************************************************************/
function ro_Lock( bImgId, vNb )
{

  if( bLockName != "" && bLockName != bImgId ){
    bTemp = bLockName;
    bLockName = bImgId;
    ro_Change( bTemp, vLockNb )
  }
  else
    bLockName = bImgId;

  vLockNb = vNb;

}
