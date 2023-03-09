<?php
/*
*
*	I guess?
*
*
*/
class BaseLocation{
	public $lat;
	public $lon;
	public $street;
	public $city;
	public $state;
	public $postal_code;
	//Getters and Setters? We don't need no stinking getters and setters!
}

class Brewery extends BaseLocation{
	public $name;
	public $brewery_type;
	public $website_url;
	public $phone;
	public function __construct($name, $type, $url, $phone, $lat, $lon, $street, $city, $state, $zip){
		$this->name = $name;
		$this->brewery_type = $type;
		$this->website_url = $url;
		$this->phone = $phone;
		$this->lat = $lat;
		$this->lon = $lon;
		$this->street = $street;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
	}
	public function displayBrewery(){
		$output = '';
		$output = $this->street . ' ';
		$output .= $this->city . ', ';
		$output .= $this->state . ' ';
		$output .= $this->postal_code;
?>
		<div class="bg-dark text-success p-5 brewery-wrap">
			<h3><?= $this->name; ?></h3>
			<p>Type: <?= $this->brewery_type; ?><br />
			Address: <?= $output; ?></p>
			<div class="mt-1"><a href="https://www.google.com/maps/@<?= $this->lat ?>,<?= $this->lon ?>,16z" target="_blank"><span class="fa fa-xl fa-location-dot"></span></a>&nbsp;&nbsp;&nbsp;<?php 
			if(isset($this->website_url) && !empty($this->website_url)){ ?>
				<a target="_blank" href="<?= $this->website_url; ?>"><span class="fa fa-xl fa-cloud"></span></a>&nbsp;&nbsp;&nbsp;<?php 
			}
			if(isset($this->phone) && !empty($this->phone)){ ?>
				<a href="tel:<?= $this->phone; ?>"><span class="fa fa-xl fa-phone"></span></a><br /><?php 
			}
?>
			</div>
		</div><?php 
	}
	
}