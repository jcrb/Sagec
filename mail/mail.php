<?php

function mail_attachement($to , $sujet , $message , $fichier , $typemime , $nom , $reply , $from)
{
 $limite = "_parties_".md5(uniqid (rand()));

 šššš$mail_mime = "Date: ".date("l j F Y, G:i")."\n";
 šššš$mail_mime .= "MIME-Version: 1.0\n";
 šššš$mail_mime .= "Content-Type: multipart/mixed;\n";
 šššš$mail_mime .= " boundary=\"----=$limite\"\n\n";

 šššš//Le message en texte simple pour les navigateurs qui n'acceptent pas le HTML
 šššš$texte = "This is a multi-part message in MIME format.\n";
 šššš$texte .= "Ceci est un message est au format MIME.\n";
 šššš$texte .= "------=$limite\n";
 šššš$texte .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
 šššš$texte .= "Content-Transfer-Encoding: 7bit\n\n";
 šššš$texte .= $message;
 šššš$texte .= "\n\n";

 šššš//le fichier
 šššš$attachement = "------=$limite\n";
 šššš$attachement .= "Content-Type: $typemime; name=\"$nom\"\n";
 šššš$attachement .= "Content-Transfer-Encoding: base64\n";
 šššš$attachement .= "Content-Disposition: attachment; filename=\"$nom\"\n\n";

 šššš$fd = fopen( $fichier, "r" );
 šššš$contenu = fread( $fd, filesize( $fichier ) );
 ššššfclose( $fd );
 šššš$attachement .= chunk_split(base64_encode($contenu));

 šššš$attachement .= "\n\n\n------=$limite\n";
 ššššreturn mail($to, $sujet, $texte.$attachement, "Reply-to: $reply\nFrom:$from\n".$mail_mime);
 }

 ?>