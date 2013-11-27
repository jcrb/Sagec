<?php
// Used to create an html'ised version of stations.txt for use by visitors to
// your site. See wr-readme.txt for more details.
// Not intended for distribution outside of the WeatherReport package.
//
// v1.0

$stationfile = @fopen("./stations.txt", "r");

if(!$stationfile) {
	exit ("<br />Cannot open stations.txt. Make sure it is in this same directory.");
}

$stationcount = 0;
$menucount = 0;
$menufodder = "";
$catchset = "";

while(!feof($stationfile)) {
	$line = fgets($stationfile, 512);
	if (substr($line, 0, 1) == '#') {
		continue;
	}
	$parts = explode(';', $line);
	$prettyline = $parts[3] . "\t" . $parts[4] . "\t" . $parts[5] . "\t" . $parts[0];
	$stationlines[$stationcount] = $prettyline;
	$stationcount++;
	
	$firstchar = substr($prettyline, 0, 1);
	
	if (!strstr($catchset, $firstchar)) {
		$catchset .= $firstchar;
		$menufodder[$menucount] = $firstchar;
		$menucount++;
	}
	
}
fclose($stationfile);

echo ("stations.txt read. Writing stationsbyname.php...<br /><br />");


$final = @fopen("./stationsbyname.php", "w");
if(!$final) {
	exit ("<br />Cannot create stationsbyname.php. Check write permissions. If it already exists, it needs to be writable by all.");
}

@chmod("./stationsbyname.php", 0666);

sort($stationlines, SORT_STRING);
sort($menufodder, SORT_STRING);

$htmlhead =	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" ' .
			'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'. "\n" .
			'<html xmlns="http://www.w3.org/1999/xhtml">' . "\n" .
			'<head>' . "\n" . '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />'. "\n" .
			'<meta name="robots" content="noindex, nofollow" />' . "\n" .
			'<title>Weather Stations</title>' . "\n" .
			'<style>' . "\n" . '<!-- ' . "\n" .
			'body {' . "\n" .
			'margin: 20px 20px 20px 20px;' . "\n" .
			'font-family: Verdana, sans-serif;' . "\n" .
			'font-size: small;' . "\n" .
			'line-height: 140%;' . "\n" .
			'}' . "\n" .
			'h3 {margin-top: 12px;line-height: 200%;}' . "\n" .
			'dl {padding-top: 1em; padding-bottom: 1em;}' . "\n" .
			'dd {padding-left: 6px;}' . "\n" .
			'dt {font-weight: bold;}' . "\n" .
			' -->' . "\n" . '</style>' . "\n" .
			'</head>' . "\n" .
			'<body>' . "\n";

$pageend = '<h3 id="end">';

fwrite($final, $htmlhead);

for($i = 0; $i < $menucount; $i++) {
	$alphabetlinks .= '<a href="#' . $menufodder[$i] . '">' . $menufodder[$i] . '</a> | ';
}

$alphabetlinks .= '<a href="#end">BOTTOM</a></h3>' . "\n";

$key = "0";

for($i = 0; $i < $stationcount; $i++) {
	if("\n" == $stationlines[$i]) {
		continue;
	}
	$parts = explode("\t", $stationlines[$i]);
	
	if($parts[3]) {
		$firstchar = substr($parts[0], 0, 1);
		if ($firstchar != $key) {
			$key = $firstchar;
			fwrite($final, '<h3 id="' . $key . '">' . $alphabetlinks);
		}
		
// Choose which of the two line formats you want to use. Make sure it is uncommented, and
// the other one is not.

// This one puts the station location on the top line, and the station call letters
// indented on the line below it.
//		$line = '<dl><dt>' . $parts[3] . '</dt>' . "\n\t" .
//					'<dd>' . $parts[0] . ' ' . $parts[1] . ' ' . $parts[2] . '</dd></dl>' . "\n";


// This one does the opposite. I prefer it, but you may not.
		$line = '<dl><dt>' . $parts[0] . ' ' . $parts[1] . ' ' . $parts[2] . '</dt>' . "\n\t" .
					'<dd>' . $parts[3] . '</dd></dl>' . "\n";
					
// Okay, stop editing.

		fwrite($final, $line);
	}
}

fwrite($final, "\n" . $pageend . $alphabetlinks . '</body>' . "\n" . '</html>');

fflush($final);
fclose($final);

echo ("Done processing.");

?>