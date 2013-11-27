<?php
// lire_ccam.php

$handle = @fopen("CACTOT006.txt", "r");
if ($handle) {
  // while (!feof($handle)) 
  for($i = 0; $i < 30; $i++)
  {
      $buffer = fgets($handle, 128);
      echo $buffer;print("<br>");
      $first = substr($buffer,0,3);
      switch($first)
      {
      	case '000':
      		analyse_entete($buffer);break;
      	case '001':
      		analyse_TB01($buffer);break;
      	case '002':
      		analyse_TB02($buffer);break;
      	case '003':
      		analyse_TB03($buffer);break;
      	case '004':
      		analyse_TB04($buffer);break;
      	case '005':
      		analyse_TB05($buffer);break;
      	case '006':
      		analyse_TB06($buffer);break;
      	case '007':
      		analyse_TB07($buffer);break;
      	case '008':
      		analyse_TB08($buffer);break;
      }
   }
   fclose($handle);
}

function analyse_TB08($buffer)
{
	print("Table 008 (Jours f�ri�s)<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 4; $i++)
	{
		print("Caisse: ".substr($buffer,$start,3)."<br>");
		$start += 3;
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Type de jour f�ri�: ".substr($buffer,$start,1)."<br>");
		$start += 1;
		print("Jour f�ri� sp�cifique: ".substr($buffer,$start,8)."<br>");
		$start += 8;
	}
}
function analyse_TB07($buffer)
{
	print("Table 007 (Exon�rations)<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 2; $i++)
	{
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Seuil m�tropole: ".substr($buffer,$start,5)."<br>");
		$start += 7;
		print("Seuil antilles: ".substr($buffer,$start,5)."<br>");
		$start += 7;
		print("Seuil R�union: ".substr($buffer,$start,5)."<br>");
		$start += 7;
		print("Seuil Guyanne: ".substr($buffer,$start,5)."<br>");
		$start += 7;
	}
}

function analyse_TB06($buffer)
{
	print("Table 006 (Code modificateur - Age)<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 4; $i++)
	{
		print("Code modificateur: ".substr($buffer,$start,1)."<br>");
		$start += 1;
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Unit� de temps (J=Jour A=Ann�e): ".substr($buffer,$start,1)."<br>");
		$start += 1;
		print("Age minimum (0=pas de minimum): ".substr($buffer,$start,3)."<br>");
		$start += 3;
		print("Unit� de temps de l(age (J=Jour A=Ann�e): ".substr($buffer,$start,1)."<br>");
		$start += 1;
		print("age maximum (0=pas de maximum): ".substr($buffer,$start,3)."<br>");
		$start += 3;
	}
}

function analyse_TB05($buffer)
{
	print("Table 005 (Code nature de prestation)<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 6; $i++)
	{
		print("Nature de prestation de type forfait CCAM: ".substr($buffer,$start,3)."<br>");
		$start += 3;
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Type de forfait: ".substr($buffer,$start,1)."<br>");
		$start += 1;
	}
}

function analyse_TB04($buffer)
{
	print("Table 004 (Regroupement de sp�cialit�s)<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 6; $i++)
	{
		print("Sp�cialit�: ".substr($buffer,$start,2)."<br>");
		$start += 2;
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Clase de sp�cialit�: ".substr($buffer,$start,2)."<br>");
		$start += 2;
	}
}

function analyse_TB03($buffer)
{
	print("Table 003 (R�gles tarifaires)<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 5; $i++)
	{
		print("R�gle tarifaire: ".substr($buffer,$start,1)."<br>");
		$start += 1;
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Cofficient: ".substr($buffer,$start,1)."<br>");
		$start += 4;
	}
}

function analyse_TB02($buffer)
{
	print("Table 002 (Code association non pr�vues)<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 5; $i++)
	{
		print("Code association: ".substr($buffer,$start,1)."<br>");
		$start += 1;
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Cofficient: ".substr($buffer,$start,1)."<br>");
		$start += 4;
	}
}

function analyse_TB01($buffer)
{
	print("Table 001 (Modes de traitement impliquant un taux d'hospitalisation<br>");
	$start = 3;
	print("Rubrique: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("S�quence: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	for($i = 0; $i < 6; $i++)
	{
		print("Mode de traitement: ".substr($buffer,$start,2)."<br>");
		$start += 2;
		print("Date de d�but: ".substr($buffer,$start,8)."<br>");
		$start += 8;
		print("Date de fin: ".substr($buffer,$start,8)."<br>");
		$start += 8;
	}
}

function analyse_entete($buffer)
{
	$start = 3;
	print("Type d'�metteur: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("Num�ro d'�metteur: ".substr($buffer,$start,14)."<br>");
	$start += 14;
	print("Programme �metteur: ".substr($buffer,$start,6)."<br>");
	$start += 6;
	print("Type de destinataire: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("Num�ro de destinataire: ".substr($buffer,$start,14)."<br>");
	$start += 14;
	print("Programme destinataire: ".substr($buffer,$start,6)."<br>");
	$start += 6;
	print("Application: ".substr($buffer,$start,2)."<br>");
	$start += 2;
	print("Identification du fichier ".substr($buffer,$start,3)."<br>");
	$start += 3;
	print("Date de cr�ation du fichier ".substr($buffer,$start,8)."<br>");
	$start += 8;
	print("Information NOEMIE: ".substr($buffer,$start,24)."<br>");
	$start += 24;
	print("Num�ro chronologique: ".substr($buffer,$start,5)."<br>");
	$start += 5;
	print("Type de fichier: ".substr($buffer,$start,1)."<br>");
	$start += 1;
	print("N� de version (AAVV): ".substr($buffer,$start,4)."<br>");
	$start += 4;
}

?>

