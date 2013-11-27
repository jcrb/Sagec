<?php
// Used to create a more readable version of stations.txt for use by visitors to
// your site. See wr-readme.txt for more details.
// Not intended for distribution outside of the WeatherReport package.
//
// v1.0

$stationfile = @fopen("./stations.txt", "r");

if(!$stationfile) {
	exit ("Cannot open stations.txt. Make sure it is in this same directory.<br />");
}

$stationcount = 0;

while(!feof($stationfile)) {
	$line = fgets($stationfile, 512);
	if (substr($line, 0, 1) == '#') {
		continue;
	}

	$parts = explode(';', $line);
	$prettyline = $parts[3] . "\t" . $parts[4] . "\t" . $parts[5] . "\t" . $parts[0] . "\n";
	$stationlines[$stationcount] = $prettyline;
	$stationcount++;

}

fclose($stationfile);

echo ("stations.txt read. Writing stationsbyname.txt...<br />");

$final = @fopen("./stationsbyname.txt", "w");
if(!$final) {
	exit ("<br />Cannot create stationsbyname.txt. Check write permissions. If it already exists, it needs to be writable by all.");
}

@chmod("./stationsbyname.txt", 0666);

sort($stationlines, SORT_STRING);

for($j = 0; $j < $stationcount; $j++) {
	fwrite($final, $stationlines[$j]);
}
fclose($final);

echo ("<br />Done processing.");
exit();
?>