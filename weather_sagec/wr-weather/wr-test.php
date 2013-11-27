<?php

// Use this file to test promising options and so forth.

require ('../weather-report.php')

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
	<title>Weather Report</title>
	<style>
	<!-- 
	body {
		margin:				30px 20px 20px 0px;
		font-family:		Optima, Verdana, sans-serif;
		font-size:			small;
		line-height:		140%;
	}
	
	//-->
	</style>

</head>

<body>

<ul>
	<?php echo (getuserweather('en,show-glops,show-date,temp-fc,dew-fc,temp-cf,dew-cf,minmax6h-cf,minmax6h-fc,minmax24h-cf,minmax24h-fc,rel-hum,hum-index-fc,hum-index-cf,heat-index-cf,heat-index-fc,windchill-cf,windchill-fc,pressure-inhg,pressure-mmhg,pressure-atm,pressure-hpa,pressure-inhg-hpa,pressure-inhg-hpa-atm,pressure-inhg-mmhg-hpa-atm,pressurelong-inhg-mmhg-hpa-atm,activity,visibility-kmmi,visibility-mikm,precip-inmm,precip-mmin,precip6-inmm,precip6-mmin,precip24-inmm,precip24-mmin,wind-km,wind-kt,wind-mph,wind-kmmph,wind-mphkm,wind-ktkmmph,wind-dir,wind-dir-short,clouds-mft,clouds-ftm,cloudwatch-mft,cloudwatch-ftm,runways-ftm,runways-mft,remarks,about,<li>,</li>,1,0')); ?>
</ul>
<ul>
	<li>
		<?php if (function_exists(includestation)) {
			includestation();
		} ?>
	</li>
	<li>
		<?php if (function_exists(linkstationlist)) {
			linkstationlist();
		} ?>
	</li>
</ul>

<ul>
	<?php echo (get_weather('CYVR,en,show-glops,show-loc,show-date,-7,temp-fc,dew-fc,temp-cf,dew-cf,minmax6h-cf,minmax6h-fc,minmax24h-cf,minmax24h-fc,rel-hum,hum-index-fc,hum-index-cf,heat-index-cf,heat-index-fc,windchill-cf,windchill-fc,pressure-inhg,pressure-mmhg,pressure-atm,pressure-hpa,pressure-inhg-hpa,pressure-inhg-hpa-atm,pressure-inhg-mmhg-hpa-atm,pressurelong-inhg-mmhg-hpa-atm,activity,visibility-kmmi,visibility-mikm,precip-inmm,precip-mmin,precip6-inmm,precip6-mmin,precip24-inmm,precip24-mmin,wind-km,wind-kt,wind-mph,wind-kmmph,wind-mphkm,wind-ktkmmph,wind-dir,wind-dir-short,clouds-mft,clouds-ftm,cloudwatch-mft,cloudwatch-ftm,runways-ftm,runways-mft,remarks,about,<li>,</li>,1,0')); ?>
</ul>
</body>
</html>