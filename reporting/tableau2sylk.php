<?php
//Enregistrer un tableau php en Fichier SYLK compatible Excel	
//L'avantage par rapport au CSV c'est qu'il gère la taille des colonnes et il met le titre en gras. 
//source: developpez.com auteur atchoum octobre 2006

function sylk($tableau,$nomfic)
{
   define("FORMAT_REEL",   1); // #,##0.00
   define("FORMAT_ENTIER", 2); // #,##0
   define("FORMAT_TEXTE",  3); // @
   $cfg_formats[FORMAT_ENTIER] = "FF0";
   $cfg_formats[FORMAT_REEL]   = "FF2";
   $cfg_formats[FORMAT_TEXTE]  = "FG0";
   if ($tableau)
   {
      // en-tête du fichier SYLK
      if ($nomfic==false)
         $nomfic="extraction";
      $myfile= fopen($nomfic.".xls","w+")or die("pas bien");
      fputs($myfile,"ID;Atchoum Production\n"); // ID;Pappli
      fputs($myfile,"\n");
      // formats
      fputs($myfile,"P;PGeneral\n");     
      fputs($myfile,"P;P#,##0.00\n");       // P;Pformat_1 (reels)
      fputs($myfile,"P;P#,##0\n");          // P;Pformat_2 (entiers)
      fputs($myfile,"P;P@\n");              // P;Pformat_3 (textes)
      fputs($myfile,"\n");
      // polices
      fputs($myfile,"P;EArial;M200\n");
      fputs($myfile,"P;EArial;M200\n");
      fputs($myfile,"P;EArial;M200\n");
      fputs($myfile,"P;FArial;M200;SB\n");
      fputs($myfile,"\n");
      // nb lignes * nb colonnes :  B;Yligmax;Xcolmax
      fputs($myfile,"B;Y".(count($tableau)));
      // detection du nb de colonnes
      
      for($i=0;$i < count($tableau) ;$i++)
         $tmp[$i]=count($tableau[$i]);
      $nbcol=max($tmp);
      fputs($myfile,";X".$nbcol."\n");
      fputs($myfile,"\n");
      // récupération des infos de formatage des colonnes
      for($cpt=0; $cpt< $nbcol;$cpt++)
      {
         switch(gettype($tableau[1][$cpt]))
         {
            case "integer":
               $num_format[$cpt]=FORMAT_ENTIER;   
            $format[$cpt]= $cfg_formats[$num_format[$cpt]]."R";
            break;
            case "double":
               $num_format[$cpt]=FORMAT_REEL;   
            $format[$cpt]= $cfg_formats[$num_format[$cpt]]."R";
            break;
            default:
            $num_format[$cpt]=FORMAT_TEXTE;   
            $format[$cpt]= $cfg_formats[$num_format[$cpt]]."L";
            break;
         }   
      }
      // largeurs des colonnes
      for ($cpt = 1; $cpt <= $nbcol; $cpt++)
      {
         for($t=0;$t < count($tableau);$t++)
            $tmpo[$t]= strlen($tableau[$t][$cpt-1]);
         $taille=max($tmpo);
         // F;Wcoldeb colfin largeur
         if (strlen($tableau[0][$cpt-1]) > $taille)
            $taille=strlen($tableau[0][$cpt-1]);
         if ($taille>50)
            $taille=50;
         fputs($myfile,"F;W".$cpt." ".$cpt." ".$taille."\n");
      }
      fputs($myfile,"F;W".$cpt." 256 8\n"); // F;Wcoldeb colfin largeur
      fputs($myfile,"\n");
      // en-tête des colonnes (en gras --> SDM4)
      for ($cpt = 1; $cpt <= $nbcol; $cpt++)
      {
         fputs($myfile,"F;SDM4;FG0C;".($cpt == 1 ? "Y1;" : "")."X".$cpt."\n");
         fputs($myfile,"C;N;K\"".$tableau[0][$cpt-1]."\"\n");
      }
      fputs($myfile,"\n");
      // données utiles
      $ligne = 2;
      for($i=1;$i< count($tableau);$i++)
      {
         // parcours des champs
         for ($cpt = 0; $cpt < $nbcol; $cpt++)
         {
            // format
            fputs($myfile,"F;P".$num_format[$cpt].";".$format[$cpt]);
            fputs($myfile,($cpt == 0 ? ";Y".$ligne : "").";X".($cpt+1)."\n");
            // valeur
            if ($num_format[$cpt] == FORMAT_TEXTE)
               fputs($myfile,"C;N;K\"".str_replace(';', ';;', $tableau[$i][$cpt])."\"\n");
            else
               fputs($myfile,"C;N;K".$tableau[$i][$cpt]."\n");
         }
         fputs($myfile,"\n");
         $ligne++;
      }
      // fin du fichier
      fputs($myfile,"E\n");
      fclose($myfile);
   }else
      print "fichier non créer<br>";
}
?>