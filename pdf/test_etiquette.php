<?php
require_once('etiquettes_pdf.php');
/*--------------------------------------------------------------------------------
Pour créer l'objet on a 2 manières :
soit on donne les valeurs d'un format personnalisé en les passant dans un tableau
soit on donne le nom d'un format AVERY
--------------------------------------------------------------------------------*/
// Exemple avec un format personnalisé
// $pdf = new PDF_Label(array('paper-size'=>'A4', 'metric'=>'mm', 'marginLeft'=>1, 'marginTop'=>1, 'NX'=>2, 'NY'=>7, 'SpaceX'=>0, 'SpaceY'=>0, 'width'=>99, 'height'=>38, 'font-size'=>14));

// Format standard
$pdf = new PDF_Label('L7163');
$pdf->AddPage();
// On imprime les étiquettes
for($i=1;$i<=20;$i++) {
    $text = sprintf("%s\n%s\n%s\n%s %s, %s", "Laurent $i", 'Immeuble Toto', 'av. Fragonard', '06000', 'NICE', 'FRANCE');
    $pdf->Add_Label($text);
}
$pdf->Output();
?> 