<?php
/*
* Notes: This is just a demo of Beer Right Meow.
*/
?><!DOCTYPE html>
<html lang="en">
<head>
<!-- Site Title-->
<title>Beer Right Meow</title>
<meta charset="utf-8" />
<meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="robots" content="noindex, nofollow" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.brewery-wrap a{
	color: limegreen;
}
.brewery-wrap a:visited{
	color: darkgreen;
}
.brewery-wrap a:hover,
.brewery-wrap a:focus{
	color: green;
	outline:none;
	border:none;
}
.brewery-wrap a:active{
	color: lightgreen;
}
.error{
	color:red;
}
.fa{
	margin-top: .4em;
}
body {
  font-family: monospace;
}
</style>
</head>
<body class="bg-dark text-success text-center">
<!--
 _._     _,-'""`-._
(,-.`._,'(       |\`-/|
    `-.-' \ )-`( , o o)
          `-    \`_`"'-
-->
	<!-- Page Contents-->
	<div id="main">
		<div class="text-center">
			<div class="container mt-5 mb-2">
				<h1>Beer Right Meow</h1>
				<p>Listing of Nearby Breweries</p>
				<div><button class="btn btn-success m-3" id="reloadBtn">Reload</button></div>
			</div>
		</div>
		<div>
			<div class="container" id="searchContent">
				<!-- AJAX RESPONSE CONTENT GOES HERE -->
			</div>
		</div>
	</div>
	<div class="text-center brewery-wrap">
		<p>Thrown together by <a target="_blank" href="https://github.com/dpyoung">Dan</a> in an evening.<br />
		Data supplied by <a target="_blank" href="https://www.openbrewerydb.org/">Open Brewery DB</a><br />
		2023/03/08<br />(YYYY/MM/DD)</p>
	</div>
<div style="position:fixed;bottom:1em;right:1em;" class="text-left">
<pre>
      |\---/|                
      | ,_, |                
       \_`_/-..----.         
    ___/ `   ' ,""+ \        
   (__...'   __\    |`.___.';
     (_,...'(_,.`__)/'.....+ 
</pre>	
</div>
<!-- Java script-->
<script>
// Allow the content to change if necessary to reload. 
// This is more an example of using AJAX calls and disabling the pressed button until a response is returned.
$(document).on('click','#reloadBtn',function(){
	if(!$('#reloadBtn').hasClass('disabled')){//Post to API revealing nearby options
		$('#reloadBtn').addClass('disabled');
		getLocation();
		console.log("On the doc-load reloadBtn clicked action.");
	}
});
// Auto-load the page once ready.
$(document).ready( function(){
	if(!$('#reloadBtn').hasClass('disabled')){//Post to API revealing nearby options
		$('#reloadBtn').addClass('disabled');
		getLocation();
		console.log("On the doc-load action.");
	}
});
// Request the user's GPS location coordinates to pass to the API later.
// Note that "navigator.geolocation" does all the heavy lifting for us.
function getLocation() {
	console.log("Got to getLocation");
	navigator.geolocation.getCurrentPosition(
		function(position) {
			//alert("Lat: " + position.coords.latitude + "\nLon: " + position.coords.longitude);
			showPosition(position);
		},
		function(error){
			alert(error.message);
		}, {
			enableHighAccuracy: true, timeout : 5000, maximumAge: 0
		}
	);
}
// Called by getLocation, this performs the AJAX call to the API library-parsing PHP script.
function showPosition(position) {
	// Position objects contain coordinates with latitude and logitude....
	var latitude = position.coords.latitude;
	var longitude = position.coords.longitude;
	// Console logged message for the dev; use F12 to open dev tools in your browser.
	console.log("Got to showPosition, " + latitude + " " + longitude);
	$('#reloadBtn').addClass('disabled');
	// Display a loading message for users. This helps them understand something is going on.
	$('#searchContent').html('<p>Loading ...</p>');
	// Post the call to our AJAX script. POSTS require some data element (between { and }). 
	$.post("./ajax/fetch_and_print.php", {lat: latitude, lon: longitude}, function(result){
		// Log another message for troubleshooting.
		console.log("In the post return....");
		// Set the page content to the response from /ajax/fetch_and_print.php
		$("#searchContent").html(result);
		// Re-enable the button.
		if($('#reloadBtn').hasClass('disabled')){
			$('#reloadBtn').removeClass('disabled');
		};
	});	
}
</script>
</body>
</html>