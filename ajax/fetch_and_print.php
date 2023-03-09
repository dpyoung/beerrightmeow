<?php
/*
*	NAME: Fetch.php
*	PURPOSE: To fetch and print responses from a JSON API
*	MOTIVE: To demonstrate how to do this.
*	NOTES: This will output many pre-styled divs. You could just assign non-bootstrap classes to those divs to style differently.
*/
require_once('../include/utilities.php');
require_once('../include/brewery.php');

$commenceSearch = false;
// Per Page sets a maximum response number. 25 Breweries is plenty to find around you. Right?
$per_page = 25;
// If you want to try different latitudes and longitudes, here's Phoenix, AZ:
$lat = '33.491';
$lon = '-112.105';

//33.4912194,-112.1058582
// Note for the professionals out there: cycle through the entire $_POST array and filter your submissions with a utility include.
// This is left here to demonstrate how we're sanitizing some input.
// Remember, kids: trust no one.
if(isset($_POST['per_page'])){
	$per_page = cleanInput($_POST['per_page']);
}
if(isset($_POST['lat'])){
	$lat = cleanInput($_POST['lat']);
	if(floatval($lat)){
		$lat = round($lat, 4);
	}
}
if(isset($_POST['lon'])){
	$lon = cleanInput($_POST['lon']);
	if(floatval($lon)){
		$lon = round($lon, 4);
	}
}
if(isset($lat) && isset($lon)){
	$commenceSearch = true;
}
// Example URL to see how the data is structured. Try putting this in POSTMAN or INSOMNIA.
// GET https://api.openbrewerydb.org/breweries?by_dist=38.8977,77.0365&per_page=3


// Brewery Database API URL
$url = "https://api.openbrewerydb.org/breweries?by_dist={$lat},{$lon}&per_page={$per_page}";

// Simple example to get data.
$resource = curl_init($url);
// Need some returned data
curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
// We know the return data type is going to be JSON; specify it here.
curl_setopt($resource, CURLOPT_HTTPHEADER, array("Accept: application/json"));

// Execute the request.
$result = curl_exec($resource);
// Get request info if we need to debug.
$info = curl_getinfo($resource);
// Get the code to see if we actually got results or just an error.
$code = curl_getinfo($resource, CURLINFO_HTTP_CODE);

// If we had a 200 response code, the server responded correctly.
if($code == '200'){
	// Decode the JSON object to manipulate it.
	$result = json_decode($result);
}else{
	$result = null;
	echo "Non-200 code; cannot check resource.";
}

$breweries = $result;

if($commenceSearch){
	foreach($breweries??[] as $brewery){
		$breweryObject = new Brewery(
			$brewery->name,
			$brewery->brewery_type,
			$brewery->website_url,
			$brewery->phone,
			$brewery->latitude,
			$brewery->longitude,
			$brewery->street,
			$brewery->city,
			$brewery->state,
			$brewery->postal_code);
		$breweryObject->displayBrewery();
	}
}else{
	echo "<div><p class=\"text-danger\">This is returned when no (or inadequate) parameters are passed.</p></div>";
}
