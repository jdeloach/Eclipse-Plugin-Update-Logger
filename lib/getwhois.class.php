<?php
/*
Version 0.1
Latest versions of this script can be found at http://www.tevine.com/projects/whois/

*/
class IPData {
	var $dl = 'whois.arin.net';
	
	function whois($domain, $server="whois.arin.net")
	{ 
	    $fp = fsockopen ($server, 43, $errnr, $errstr) or die("$errno: $errstr");
	    fputs($fp, "$domain\n");
	    while (!feof($fp))
	        echo "<pre>".fgets($fp, 2048);
	    fclose($fp); 
	} 
	
	function get_whois($domain, $server="whois.arin.net")
	{
	    $fp = fsockopen ($server, 43, $errnr, $errstr) or die("$errno: $errstr");
	    fputs($fp, "$domain\n");
	    while (!feof($fp))
	        $nt .= fgets($fp, 2048);
	    fclose($fp); 
	
		return $nt;
	}
	private function getData($ip, $database) {
		if( $database = 'primary' ) $database = "http://www.ipinfodb.com/ip_query.php?ip=".$ip."&output=xml";
		if( $database = 'secondary' ) $database = "http://backup.ipinfodb.com/ip_query.php?ip=".$ip."&output=xml";
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $database);
		curl_setopt ($c, CURLOPT_RETURNTRANSFER, TRUE);
		$content = curl_exec($c);
		curl_close($c);
		return $content;
	}
	function locateIp($ip){
		$d = $this->getData($ip, "primary");
	 
		//Use backup server if cannot make a connection
		if (!$d){
			$backup = $this->getData($ip, 'secondary');
			$answer = new SimpleXMLElement($backup);
			if (!$backup) return false; // Failed to open connection
		}else{
			$answer = new SimpleXMLElement($d);
		}
	 
		$country_code = $answer->CountryCode;
		$country_name = $answer->CountryName;
		$region_name = $answer->RegionName;
		$city = $answer->City;
		$zippostalcode = $answer->ZipPostalCode;
		$latitude = $answer->Latitude;
		$longitude = $answer->Longitude;
		$timezone = $answer->Timezone;
		$gmtoffset = $answer->Gmtoffset;
		$dstoffset = $answer->Dstoffset;
	 
		//Return the data as an array
		return array('ip' => $ip, 'country_code' => $country_code, 'country_name' => $country_name, 'region_name' => $region_name, 'city' => $city, 'zippostalcode' => $zippostalcode, 'latitude' => $latitude, 'longitude' => $longitude, 'timezone' => $timezone, 'gmtoffset' => $gmtoffset, 'dstoffset' => $dstoffset);
	}
	/*
	*$ip_data = locateIp($domain);
	* 
	*	echo "IP : " . $ip_data['ip'] . "\n";
	*	echo "Country code : " . $ip_data['country_code'] . "\n";
	*	echo "Country name : " . $ip_data['country_name'] . "\n";
	*	echo "Region name : " . $ip_data['region_name'] . "\n";
	*	echo "City : " . $ip_data['city'] . "\n";
	*	echo "Zip/postal code : " . $ip_data['zippostalcode'] . "\n";
	*	echo "Latitude : " . $ip_data['latitude'] . "\n";
	*	echo "Longitude : " . $ip_data['longitude'] . "\n";
	*	echo "Timezone : " . $ip_data['timezone'] . "\n";
	*	echo "GmtOffset : " . $ip_data['gmtoffset'] . "\n";
	*	echo "DstOffset : " . $ip_data['dstoffset'] . "\n";
	*/
}
?>
