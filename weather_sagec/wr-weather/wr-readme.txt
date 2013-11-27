Weather Report
v3.01b

	WHAT'S NEW for 3.01b?
		1. Excessively stupid bug smooshed. $weather variable retained data it shouldn't.
		
	WHAT'S NEW for 3.0b?
		1. Altered setup to remove need for WP users to insert the absolute path to 'wp-config.php'.
		2. Added support for an interactive weather report. See 'INTERACTIVE USAGE' for details.
		3. Added new option 'show-loc'.
		4. Smooshed a bug that in some cases at some times interfered with database access by any PHP
			functions called after get_weather. 
		5. Changed the license (license.txt) to a simpler form listed as positively GNU-compatible.
		6. Changed the output from 'echo' to 'return'. For existing users, this does mean changing
			how you call 'get_weather' slightly; please do check the USAGE section for details. I
			am sorry for the inconvenience, but believe this is a change for the better in the long
			run.
		7. There are some further alterations in the works, but time contraints currently mean I'll
			have to leave those for another day.
		
		
	WHAT'S NEW for 2.2?
		1. Resolved issues with using fsockopen() in situations where file() and fopen()
			are not allowed by the webserver.
			
			
	WHAT'S NEW for 2.1?
		1. UTC -> local date/time. Details in the section for 'show-date'.
		
		
	WHAT'S NEW for 2.0?
		1. Language settings. Currently supporting English and French. More on the way.
		2. Heading display now slightly more configurable. Can show headings on lines by
			themselves, as in previous versions, or inline.
		3. New installation notes. Hopefully more accurate than the last set. May even be
			easier.


	PURPOSE
	
		WeatherReport is a PHP script created as a plug-in for WordPress (though not limited to it).
		It creates on-the-fly weather reports for user-specified locations, based on METAR data
		collected and stored by the NWS (US), and returns the report to the calling page in the form
		of a string of text.


	INSTALLATION
	
		There are twelve files, plus language files, this readme and the license, altogether:
		
			weather-report.php
				If you are using this with WordPress, this file goes in the 'plugins' directory.
				
				If not, it should go somewhere on your website, and you should make a note of
				where you saved it.
				
		These files should go in a sub-directory below the one where you saved weather-report.php,
		named 'wr-weather'. If you want to use a different name, you'll need to update
		the configuration options at the beginning of weather-report.php.
			wr-activity.php
			wr-sky.php
			wr-temperature.php
			wr-remarks.php
			wr-doreport.php
			wr-test.php
			wr-setstation.php
			wr-weatherstation.php
			makeprettylistfile.php
			makeprettytxtfile.php
			stations.txt
			wr-[language code].php
			
		The language files currently supplied are wr-en.php and wr-fr.php. wr-pt.php is available
		as a separate download.


	USAGE
	
		WORDPRESS:
			1. Open weather-report.php in a text editor. Find the section toward the top
				for WordPress users. Uncomment the lines as directed.
				
			2. Go to the plugins page and click on 'activate'. 
		
		OTHERS:
			You will need to put this note at the beginning of all files on which you
			want to display weather data:
		
			<?php require_once ('/[path to saved location]/weather-report.php'); ?>
			
			and fill in your database config so:
		
			1. Open weather-report.php in a text editor. Find the section toward the top
				for Non-WordPress users. Uncomment the lines as directed.
				
			2. edit these with your info:
			
				$server			= "localhost";
				$loginsql		= "";
				$passsql		= "";
				$base			= "";

		(If you are a WordPress user and you want to try out various options using the supplied
		file wr-test.php, you need to create a separate weather installation and edit the database
		settings in its weather-report.php as per those for non-WP users.)
		
		BOTH:
			Once you've done whichever of those two things you need to do, you can call get_weather
			like you do other php commands from within the body of your webpage.
			
			A sample call to get_weather:
			
			<?php echo(get_weather('LFST,fr,show-date,temp-cf,dew-cf,pressure-hpa,wind-kph,activity,,<br />,1,0')); ?>
			
			What this returns, from the latest METAR filed out of the CYVR station, is:
				time (in UTC format) and date when the measurements were taken
				current temperature, in Celsius with Fahrenheit in parens
				current dewpoint, same deal
				pressure in hectoPascals, aka millibars
				windspeed in kilometers/hour
				current conditions (partly cloudy, light showers of rain, frogs, that kind of thing)
				
			In this example, each line returned is preceded by nothing at all and followed by a line break.
			If you want to format it as a unordered list, use ...,<li>,</li> instead of ...,,<br />.
			
			The "en" following the station call sign sets the language used to English. For French, use "fr".
			
			The ...,1,0 at the very end controls whether or not you see headings (such as Temperature, Dewpoint,
			Windspeed, etc) and if so, whether or not they appear on lines by themselves.
			
			You can make multiple calls to get_weather, using whatever options you please, so long as
			you specify a station at the beginning and bracketing at the end (more on that below).
			Any mis-typed options will be ignored.
			
			If you forget to specify a language, WeatherReport will default to English. Likewise, if you
			forget to specify how to display headings, the default will again be used (yes to headings,
			and yes to them on lines by themselves). This mimics the behaviour of previous versions, and
			ensures that those calls won't break if you don't want to fool with the new formatting.
			
			NOTE FOR 3.0 OR LATER:
				The change from using 'echo' in weather-report.php to using 'return' means that you will
				need to enclose your call to get_weather() inside an echo statement within your webpage
				as so:
					<?php echo(get_weather(station-options-yadda-yadda)); ?>
					
				If you are handy with PHP, you will recognise that this change allows you to pass the
				output of get_weather through hoops of your choice before you send it to your user's
				browser window. It will also allow me to tack on some modifications I've got in mind
				without necessarily screwing around with basic functionality.
				


	RUNTIME OPTIONS
	
		WeatherReport is designed to be highly customizable. That's why there are enough options
		to choke a small horse. Don't Panic, as the wise man once made a mint writing, you do not
		have to use them all. In fact, I recommend against it. :)
		
		Most all of the options are variants on a theme: simply put, they provide ways to display
		the same information, but with the emphasis on either metric or imperial (english) measuring
		systems. Within those two main methods are, depending on the thing being measured, usually
		two or three variations. For instance, wind can be measured in Knots, Meters/Second,
		Miles/Hour, or Kilometers/Hour. Precipitation is measured in inches or millimeters, and
		Air Pressure in Atmospheres or hectoPascals, or inches or millimeters of mercury.
		
		So I've set things up to where, if you prefer your temperatures in Celsius, followed by
		Fahrenheit, there's a display option that will accomodate you. If you prefer your windspeed
		in knots, with kilometers and miles on the side, there's an option for that.
		
		
	FORMATTING OPTIONS
	
		1. The STATION you want to use. Every call to get_weather from your webpage must, right at the
		very beginning, specify which weather reporting station you like. It can be a different
		one each time (I should care? I'm the option queen, after all.), but if you don't name one,
		you'll get an error message.
		
		The NWS maintains a lengthy list of stations at:
		
				<http://weather.noaa.gov/data/nsd_cccc.txt>
				
		Not all of them are active; test before you go live. They have several versions of that list,
		sorted via different criteria, that are probably more useful, but I like that one, and used the
		current version of it to make stations.txt. Poke around the NOAA site to get the others.
		
		(It used to be that all weather stations were coded with only uppercase characters; I think they've
		run out, since there's more than one live one in the list with numbers as part of the code.)


		2. The LANGUAGE you want to use. This should follow the station. If you specify a language for which
		there is no language file set up, WeatherReport will fall back on English.

			For English:	en
			For French:		fr

			If you are using an alternate language file, you will to ensure that it is declared. Open
			weather-report.php and look for the Optional Language section:
			
			/*-------------- optional language support files ---------------------------------------------*/
			@include_once ( WR_DIR . WR_SUPPORT . 'wr-fr.php');
			@include_once ( WR_DIR . WR_SUPPORT . 'wr-pt.php');

			
			If you wanted to use the Portuguese file, you would add a line below those so:
			
			@include_once ( WR_DIR . WR_SUPPORT . 'wr-pt.php');

			
			See below for steps on creating a new language translation file.
			
			
		3. The beginning and ending BRACKETS for each line, followed by the HEADING DISPLAY TOGGLES.
		These need to be the last options in each call to get_weather(). For Example:
		
				<ul>
				<?php echo(get_weather('CYVR,temp-cf,activity,wind-km,<li>,</li>,1,0')); ?>
				</ul>
			
			<li> and </li> are the line brackets, and they are followed by the heading display toggles (1,0).
		
		Line Brackets
			If the line brackets are not there, two things will happen: one, you will
			see a nasty long string of measuremental gobbledegook all over your page, and two, it will
			be missing the last two options you did want to see.
		
				Examples of beginning & ending brackets:
					...,<li>,</li>,...
					...,<p>,</p>,...
					...,,<br />,...
							
			You'll note the last one looks like only one bracket. It is; if you want each line of data
			to start as is, and end with only a line break, then don't put anything in that next-to-last
			slot, just hit the [comma] key twice and carry on.
		
			There is also:
					....,,,
				
			which is the way to go if you want no line bracketing at all, if, for instance, you prefer to
			handle line formatting and breaking outside of the call to get_weather():
		
				<?php echo(get_weather('CYVR,en,temp-cf,,,0,0')); ?><br />
				
		Heading Display Toggles
				...,1,1		- Sets the headings to display and to do so on lines by themselves
				...,1,0		- Sets the headings to display and to do so inline with the weather data
				...,0,0		- Turns off headings altogether.
				...,0,1		- Same as 0,0.


	WEATHER OPTIONS
		
		Temperatures
			temp-fc OR temp-cf
				You can call both if you want to, but there's not a lot of point. Recorded temperature, as
				either Fahrenheit (Celsius) or Celsius (Fahrenheit).
				
			dew-fc OR dew-cf
				Same as above, but this time with the dewpoint.
				
			minmax6h-fc OR minmax6h-cf
			minmax24h-fc OR minmax24h-cf
				Some weather stations record these at special times of the day. Any options that turn out to
				not be in the latest METAR will simply not display anything, so it doesn't hurt to call for
				stuff that only shows up once in a while.
				
				
		Calculated/Indices
			rel-hum
				The relative humidity, as calculated from the temperature and the dewpoint.
				
			hum-index-cf OR hum-index-fc
				The humidity index.
				
			heat-index-cf OR heat-index-fc
				Heat index, which is not the same as the humidity index. 
				
			windchill-cf OR windchill-fc
				Windchill. Requires that the temperature be less than 40(F) and the windspeed be greater than
				4mph.
		
		
		Atmospheric Pressure (barometer readings)
			pressure-inhg
				Formatted in inches of mercury, If I recall correctly, normal readings are between 31 and 29,
				and if the readings drop significantly over a short period of time, there's heavy weather
				on the way within the next twelve hours.
				
			pressure-mmhg
				Same thing, but in millimeters of mercury.
				
			pressure-atm
				Same thing in atmospheres.
				
			pressure-hpa
				And in hectoPascals, aka millibars.
				
			pressure-inhg-hpa
				A common combination.
				
			pressure-inhg-hpa-atm
				Not really common, but there it is.
				
			pressure-inhg-mmhg-hpa-atm
				Somewhat obsessive, to tell the truth.
				
				
		Pressure Detail (more barometric readings)
			(These options are intended to complement regular pressure choices. Include the 6 hr change rates,
			plus sea level pressure readings.)
			
			pressurelong-inhg
			pressurelong-mmhg
			pressurelong-atm
			pressurelong-hpa
			pressurelong-inhg-hpa
			pressurelong-inhg-hpa-atm
			pressurelong-inhg-mmhg-hpa-atm
			
			
		General Weather Stuff	
			activity
				clear, cloudy, raining, snowing, squalling
				
			visibility-kmmi OR visibility-mikm
				How far you can see before the mist and haze and smog gets in the way. In miles (kilometers)
				or kilometers (miles). If you get your weather from an airport station, you'll get visibility
				measurements for sure.
			
			precip-inmm OR precip-mmin
				If stuff has fallen from the sky in the last hour, how much, in either inches (millimeters)
				or millimeters (inches). Includes snow accumulation (or its 'water equivalent'), if any.
				
			precip6-inmm OR precip6-mmin
			precip24-inmm OR precip24-mmin
				These are like the 6 and 24 temperature readings in that not all stations report them, and
				when they do, it's at specific times of the day. Again, it doesn't hurt to specify an option
				that a given station doesn't report.
			
		Wind (includes windspeed and compass directions)
			wind-km
				Wind in kilometers/hour.
				
			wind-kt
				Wind in knots
				
			wind-mph
				Wind in miles/hour
				
			wind-kmmph OR wind-mphkm OR wind-ktkmmph
				Wind in combinations.
			
			(New in 2.0: wind direction has been separated out from windspeed.)
			wind-dir
				From whence cometh the wind. North/south/east/west and compass degrees.
				
			wind-dir-short
				Just the compass degrees.
				
		Sky
			clouds-mft OR clouds-ftm
				How many (roughly) and how high up. Also if any are 'interesting'-- towering cumulus or
				cumulonimbus clouds can cause aircraft problems and/or start thunderstorms. In either
				meters (feet) or feet (meters).
				
			cloudwatch-mft OR cloudwatch-ftm
				Many stations add in tidbits about what kind of clouds are in which part of the sky. I
				freely admit that I haven't gathered as much information as I would like about this
				practice, but I'm decoding it anyway. Sometimes the information includes height data,
				sometimes not. 
				
		Special
			runways-mft OR runways-ftm
				Runway Visual Ranges. These are only reported by airports, for some reason, can't think
				why, myself. Likely of interest only to pilots or aero-hobby-ists. Again, meters (feet)
				or feet (meters).
			
			show-glops
				Returns the entire METAR itself. Useful for testing one's settings.
			
			show-date
				Returns the UTC date reported by the weather station. If immediately followed by a
				number, such as 6 or 3 or -5, will treat that number as the number of hours offset
				from Greenwich, and will use it to convert the station's UTC time and date to
				"local time". Example:
				
					get_weather('CYVR,fr,show-date,-5,temp-cf...
					
				You are on your own so far as figuring out how many time zones separate you from ground
				zero, as well as keeping up with summer and winter time.
				
				If your weather station is in the same time zone as Greenwich, note that you should use 0
				as the offset if you want the display to say "local time".
				
				Not all weather stations report the month and year; for those that do not, the best I can
				do without writing extensive time and date functions of my own is to assume the current
				UTC month and year and hope for the best.
				
			show-loc
				Requires the file stations.txt in sub-folder wr-weather. Returns the location of the
				weather station as listed in the file. More or less "city or weather station, region, country".

			fetch-only
				Gets the latest METAR from NWS, returns nothing to the calling page. If $shelfdate is
				set to NOTIMEOUT, this setting can be used on a separate or hidden page to shift
				calls to NWS outside of requests to display your own web page. If the NWS calls seem to
				you to slow display of your webpage, this might be one possible solution, since your
				page's normal rendering would always use cached METARs from the database.
				
				Of course, there's always crontabs.
				
			remarks
				Not available in coherant form yet. Currently it consists of whatever's left over after
				everything that I can identify has been identified. Sometimes entertaining. Not entirely
				set up for non-english.
			
			about
				A short blurb with a link to the NWS site and one to my site. You don't have to use it,
				and if you do, you can re-write it.
		
		
	HOW IT WORKS
		
		Magic.
		
		Okay, not that magical. Every hour or so, thousands of weather stations (airports, automated
		repeaters, dedicated gnomes with thermometers) record the local weather in a specially
		designed format, known as METAR (it's a French acronym that roughly stands for meteorological
		observations for use in aviation, so now you know why there's so much focus on 'visibility').
		I do not know if they then send it to the NWS in the US, or if the NWS goes and gets it, but
		no matter. The NWS, however they get the METAR reports, make them available to everyone via
		a simple http (or ftp, if you must) call to their servers.
		
		That's what WeatherReport does. It fetches METARs from the NWS, decodes them into plain
		language, and returns only those parts you told it you wanted to see. In the process, it
		stores the current METAR in a table in your MySQL database, so that if you (or your users)
		reload your page, it doesn't have to keep pinging NWS, but can instead use the cached data.
		(You get to specify how long it should keep looking at the table before going to fetch a new
		METAR, by the way.)
		
		

	GENERAL, ON ALL THE TIME, CONFIGURATION SETTINGS
	
		(This part will make more sense if you read it while looking at weather-report.php, as that's
		where all this stuff is.)
	
		WR_DIR is currently set to localize wherever this file is saved.
		
		WR_SUPPORT is the directory just below, by default named 'wr-weather'. If you want
				to use a different sub-directory name, you will need to change this definition.
				Be sure to retain the slashes!
				
		$glopstable, currently set to 'wp_weather_report', holds the name of the table that
				WeatherReport uses to store METAR data. It is not weblog-specific, so there's
				no particular reason to have multiple tables if you have multiple weblogs. But
				if you want to change the name, here is where you do it.
				
		$shelfdate holds the length of time (in seconds) that a given stored METAR is considered
				valid. Its purpose is to cut down the number of times WeatherReport asks the
				NWS server for a new METAR for the same station. It is currently set to '3600',
				or one hour. 1200 would be twenty minutes. For details on using NOTIMEOUT, see
				the 'fetch-only' option in the options listing under 'Special'.


	TRANSLATION NOTES
		Creating a New Language File (wr-[language].php):
			1. Make sure you are working with the latest version.

			2. Determine the two-letter code for the language you are translating to. It may or may
				not be the same as the country code with which it is commonly associated.

			3. Copy 'wr-en.php' to a new file in the wr-weather folder, and name it
				wr-[language code].php

			4. Translate all the english words and phrases. Don't worry about the comments. Be sure
				to use html entities (eg: &eacute;) when keying in accented characters.

			5. Look for this line:
				setlocale(LC_TIME, 'en_EN');
				
				And change it to reflect your language. For example, the French code is
				'fr_FR.ISO8859-1'. The "ISO8859-1" part is, on some servers, necessary. On others,
				something else may be necessary.
				
				If you have trouble with this part, make a note and I'll look into it.

			6. Change all the function names in your file so that they end in "_[language code]"
				instead of "_en".

			7. Open weather-report.php and look for these lines:
			
			/*-------------- optional language support files ---------------------------------*/
			@include_once ( WR_DIR . WR_SUPPORT . 'wr-fr.php');
			@include_once ( WR_DIR . WR_SUPPORT . 'wr-pt.php');

				Make a new line below them for your file.
				
				
			If you send me your translation file, I will include it for use in the full package,
			and make sure it stays updated (to the best of my ability, anyway).
			

	INTERACTIVE USAGE
		Should you choose to do so, you can use the following calls to display a short form on
		your sidebar (or wherever) that visitors to your site can use to get the weather report
		for locations of interest to them:
		
			<?php echo(getuserweather('options-list-as-per-get_weather')); ?>
			<?php includestation(); ?>
			<?php linkstationlist(); ?>
			
		EXAMPLE:
			<ul>
			<?php echo(getuserweather('en,show-date,temp-cf,dew-cf,rel-hum,pressure-inhg-hpa,activity,cloudwatch-mft,<li>,</li>,1,1')); ?>
			
			<li>
			<?php includestation(); ?>
			</li>
			
			<li>
			<?php linkstationlist(); ?>
			</li>
			
			</ul>

		(You don't have to use unordered list tags. You can use line breaks or paragraphs or
		whatever.)
		
		getuserweather() takes the same options as get_weather(), except that you should omit the
			station code. (Your visitors will supply that!)
		
		includestation() makes the entry form display. All this is, is a text field for the
			station code and a button to 'make it so'.
		
		linkstationlist() creates a link to a file with a list of weather stations, so visitors
			can look up the code for the station nearest the location in which they are interested.
			
			'stations.txt' is the fallback, but there are two possibilities you might prefer:
			'stationsbyname.php' or 'stationsbyname.txt'. The latter two can be generated from
			stations.txt (after you've trimmed all the lines you don't want used) using
			makeprettytxtfile.php and makeprettylistfile.php.
			
			These generated files are, respectively, a text file with the location and station
			call letters cleaned up and sorted by name, and an html version of that same data.
			This last contains basic style info in its header; you can of course instead edit it
			to use your site's stylesheet. Actually, you can edit it to your heart's content.
			Just don't lose stations.txt, unless you do not want any checking performed against
			a local list.
			
			You do not need to generate both files, just the one you want to use. Also, you only need
			to do this once, after you're satisfied with the contents of the stations.txt file.
		
		
		HOW THIS WORKS
			Visitor enters a code, clicks the 'Display' button. The station code is
			truncated, a cookie set, and the page regenerates. During regeneration, the cookie
			is read (and validated against stations.txt) and its station code combined with the
			options list you set up, and the whole passed to get_weather(), which creates the weather
			report as per normal for that station. As long as the 'weatherstation' cookie is left alone,
			subsequent visits will continue to generate updated weather reports for that station.
		
			An invalid station code returns a short error message: station not listed.
		
			Always returns the station's location, so it's not necessary to specify 'show-loc'.
		
		POSSIBLE ISSUES/THINGS TO THINK ABOUT:
			1. stations.txt is simply a lightly reformatted version of NWS's list at:
					<http://weather.noaa.gov/data/nsd_cccc.txt>
					
				Not all of the listed stations return METARs and some of them return very old
				METARs.
				
			2. If among your site's visitors are the sort of people who will sit at
				their computers long enough to enter each and every one of the station codes
				in stations.txt, they will grow the table in your database, one record per code.
				If you think that may be an issue, you can trim stations.txt to just the ones
				you think worth keeping. You can also, from time to time, either truncate or drop
				the table using whatever MySQL interface you prefer.
				
			3. The 'weatherstation' cookie's value is revalidated every time it's accessed. This
				is a security feature to prevent someone from editing it with executable code
				and possibly hacking your site. There may be better ways to handle that, but
				I've simply chosen to revalidate it against stations.txt just like a new entry.
				
				I do not claim infallibility, of course. This is "use-at-your-own-risk" stuff.
				
			4. There are four phrases that you may wish to translate into another language:
				wr-weatherstation.php:
					Enter station code
					Display
				weather-report.php:
					station not listed
					invalid station
					
				If you supply a language code in the options for getuserweather(), the report
				itself will use the corresponding language file.
				
			5. I recommend against using an offset from Greenwich Mean Time (UTC) with 'show-date'
				when composing the options list for getuserweather().
				
			6. Should you wish to include the weather form in your CSS file, the tags to add are:
				#stationform input
				#stationsubmit
				#stationform #stationid
				
				EXAMPLE for WordPress users:
					1. Find this line in your active theme's style.css file:
						#sidebar #searchform #s {
					   change it to:
						#sidebar #searchform #s, #sidebar #stationform #stationid {
						
					2. Find:
						#sidebar #searchsubmit {
					   change it to:
						#sidebar #searchsubmit, #sidebar #stationsubmit {
						
					3. If you have a setting for #searchform input:
					   tack this onto it:
						#stationform input
						
					This will set the weather input form elements to match those of the search input.
					
		
	TRANSLATION CREDITS
		Portuguese (wr-pt.php) translation courtesy of
			Orlando (<http://www.blogosfera.letrascomgarfos.net/>)
			
		Any mistranslations are my responsiblity; I do change code around and add bits, so if
		you see an error, chances are very good that I made it.
		
		Corrections and enhancements should be sent to <pericat@pericat.ca>
		
		
	CREDITS
		I am deeply indebted to Martin Geisler (<gimpster@gimpster.com>), et. al., whose
		implementation of 'PHP Weather' (<http://sourceforge.net/projects/phpweather/>) provided
		comprehensive METAR-decoding and codifying algorithms, which were of material assistance
		to me in learning, not just the structure of METAR encodings, but of PHP itself;
		and to Marc Slagle's (<marc.slagle@fulkertconsulting.com>) WeatherNWS.pm script, which
		first encouraged me in my obsession with wanting up-to-date weather reports on my own
		site without resorting to javascript.
		
		I wrote the first version of this plugin on the eve of my migration to WordPress, purely
		because I had had a local weather report on my site and I wanted the WP incarnation to look as
		much as possible like the older MT implementation. Once I got into it, I realised how
		much customisation was possible. The WP conversion went on hold for the time it
		took for me to do what I wanted, and what I wanted grew alarmingly from, "gimme
		the local weather in the sideboard, and don't take all day to do it," to, "cool! clouds!"
			
	
	BACKGROUND and SOURCES
		I've amassed a list of several useful and informational sites on weather and
		METARS, some of which are:
		
		METAR decode sources:
			<http://www.ncdc.noaa.gov/oa/climate/conversion/swometardecoder.html>
			<http://www.ukweather.freeserve.co.uk/metarpg.htm>
			<http://weather.cod.edu/notes/metar.html>
			<http://www.homepages.mcb.net/bones/01UKAV/METAR.htm>
			<http://www.asiresource.com/metar.htm>
			<http://metar.noaa.gov/table_master.jsp?sub_menu=no&show=guide.html&dir=./documents/&title=title_helpful>
			
		EXTRACTS FROM The Federal Meteorological Handbook (FMH) Number 1:
			<http://www.met.tamu.edu/class/METAR/metar.html>
			
		This last is particularly helpful, as NOAA has taken their handbook off the air,
		and all links to it are deaddeaddead. I think they're selling it, but the version
		they sell is NOT the web version and the latter never pretended to be anything but
		an unofficial guide. I've had less luck getting non-US definitive encoding specs,
		but c'est la vie.
		
		SURFACE WEATHER OBSERVING, May, 2001, FAA:
			<http://www.faa.gov/atpubs/SWO/index.htm>
			
		This may be where the NOAA handbook went. They really should update their links. 
		
		
		For good cloud data, see:
			<http://vortex.plymouth.edu/clouds.html>
			<http://ww2010.atmos.uiuc.edu/(Gh)/guides/mtr/cld/cldtyp/home.rxml>
			<http://www.meteoswiss.ch/en/Science/Clouds/clouds.shtml>
			<http://www.meteosuisse.ch/fr/Comprendre/Records/IndexRecords.shtml>
			<http://www.wolkenatlas.de/wolken/class.htm>
			
		or just google "clouds, cumulus, cumulonimbus, altocumulus".
	
		Cloud Trivia:
				Latin		English
				-------------------------
				cumulus		heap
				stratus		layer
				cirrus		curl of hair
				nimbus		rain
		
		For a nice explanation of barometers and measuring air pressure:
			<http://www.coscosci.com/barometric/barometer.htm>
			
		I've also written extensive comments above nearly all of the decoding functions to
		document what kind of data each one is supposed to look for and from where that
		information comes. This is from the 'wind' comment in wr-activity.php:
		
		/*--------------------------------------------------------------------------------------
			Wind is considered a standard and handled as per the specs outlined here:
			http://www.met.tamu.edu/class/METAR/metar-pg6.html
			
			Nearly all stations will report wind direction and speed every hour. Peak wind speed
			and wind shifts are reported in Remarks, if any. I have not yet written functions for
			decoding these.
			
			Wind direction is by compass point, with 0 degrees assumed as 'north', 90 as 'east',
			180 as 'south' and 270 as 'west'. US and Canadian stations report the speed in knots,
			while others use either meters per second or kilometers per hour.
			
			Gusts, if any, are included in the standard reported group, noted by a preceding 'G'.
			If either speed or gusts are less than 100, the leading zero may be omitted.
			
			Thus, the format for wind is:
			
					[ddd][(s)ss](G(s)ss)KT|MPS|KMH
			
			where 'd' is degrees and 's' is speed. If the wind is variable, as wind is wont to be,
			and is no more than a light, 6KT breeze, 'VRB' may be substituted for the encoded
			direction. If it is blowing more energetically, though, as well as shifting around,
			the wind group will include only the main direction, but will be followed by another
			group indicating the shift. This group is formatted so:
			
					[ddd]V[ddd]
					
			(Unfortunately for me, anyway, that same format is used to report secondary ceiling
			heights, which are themselves preceded by 'CIG' and a space. So I have to set a flag
			to catch that.)
			
			When there is no measurable air movement, wind is reported as '00000KT' and sometimes
			as '000000KT' (or MPS or KMH). This is considered 'calm' and I'm decoding it as part
			of general sky conditions rather than wind.

		---------------------------------------------------------------------------------------*/
		
		So if you are interested in the nitty-gritty details, that's where you'll find them.
			
			
	CONTACT INFO
		
		Send bug reports, flames, or what-you-will to <pericat@pericat.ca>. 
		
		WeatherReport is licensed as Free Software. It is my intention that it be freely available
		to all, as are METARs and the weather itself.
		
		pericat
		
		Vancouver, BC, Canada (CYVR)
		21 July 2005
			
		<pericat@pericat.ca>
		<http://pericat.ca/>
			
