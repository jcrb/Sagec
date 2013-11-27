<?php
/**
  *	accordion.php
  */
?>

<!doctype html>
<html lang="en">
<head>
	<title>jQuery UI Accordion - Default functionality</title>
	<link type="text/css" href="../ajax/jquery-ui-1.8.custom/css/ui-lightness/jquery-ui-1.8.custom.css" rel="Stylesheet" />	
	<script type="text/javascript" src="../ajax/jquery-ui-1.8.custom/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../ajax/jquery-ui-1.8.custom/js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript">
	$(function() {
		$("#accordion").accordion();
		$('input[name=dg]').is(':checked')
	});

	</script>
</head>
<body>
<form>
<div class="demo">

<div id="accordion">
	<h3><a href="#">Alerter le Directeur de garde</a></h3>
	<div><input type="checkbox" name="dg" id="dg" />Valid�
		<p>
			Passer par le standard des HUS.
		</p>
	</div>
	<h3><a href="#">Section 2</a></h3>
	<div>
		<p>
		Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
		purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
		velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
		suscipit faucibus urna.
		</p>
	</div>
	<h3><a href="#">Section 3</a></h3>
	<div>
		<p>
		Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
		Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
		ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
		lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
		</p>
		<ul>
			<li>List item one</li>
			<li>List item two</li>
			<li>List item three</li>
		</ul>
	</div>
	<h3><a href="#">Section 4</a></h3>
	<div>
		<p>
		Cras dictum. Pellentesque habitant morbi tristique senectus et netus
		et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
		faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
		mauris vel est.
		</p>
		<p>
		Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
		inceptos himenaeos.
		</p>
	</div>
</div>

</div><!-- End demo -->

<div class="demo-description">
<p>
Click headers to expand/collapse content that is broken into logical sections, much like tabs.
Optionally, toggle sections open/closed on mouseover.
</p>
<p>
The underlying HTML markup is a series of headers (H3 tags) and content divs so the content is
usable without JavaScript.
</p>
</div><!-- End demo-description -->

</form>
</body>
</html>
