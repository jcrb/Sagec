<form method="post" id="stationform" action="<?php echo (weatherdocloc() . 'wr-setstation.php'); ?>">
	<p>
		<input type="text" value="<?php echo ($_COOKIE['weatherstation']); ?>" name="stationid" id="stationid" />
		<label for="stationid">Enter station code</label>
		<input type="hidden" value="<?php echo($_SERVER['REQUEST_URI']); ?>" name="stationreferer" />
	</p>
	
	<p>
		<input type="submit" id="stationsubmit" value="Display" />
	</p>
</form>