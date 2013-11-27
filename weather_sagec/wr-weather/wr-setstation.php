<?php
$stationid = trim($_POST['stationid']);
$stationid = substr($stationid, 0, 4);
$location = $_POST['stationreferer'];


setcookie('weatherstation', $stationid, time() + 30000000, "/");

wr_redirect($location);

//copied almost verbatim from WP's own refresh-page function
function wr_redirect($location) {
	global $is_IIS;

	if ($is_IIS)
		header("Refresh: 0;url=" . $location);
	else
		header("Location: " .  $location);
}
?>