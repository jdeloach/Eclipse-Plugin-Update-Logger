<?php
require('lib/getwhois.class.php');

$gAPI = ''; //your key from google for maps!

$whois = new IPData;
$data = $whois->locateIp($_GET['ip']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps JavaScript API Example: LocalSearch Control</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php print $gAPI;?>"
      type="text/javascript"></script>
    <script type="text/javascript">
      function initialize() {
        var map;
        if (GBrowserIsCompatible()) {
          var mapOptions = {
            googleBarOptions : {
              style : "new"
            }
          }
          map = new GMap2(document.getElementById("map_canvas"), mapOptions);
          map.setMapType(G_HYBRID_MAP);
          map.setCenter(new GLatLng(<?php print $data['latitude'] . ", " . $data['longitude'];?>), 6);     
          map.setUIToDefault();
          map.openInfoWindowHtml(map.getCenter(), "<h5><?php print $data['city'] . ', ' . $data['region_name']; ?> <br /> <?php print $data['country_name'] . " " . $data['zippostalcode']; ?></h5>");        
          }
      }
    </script>
  </head>

  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 300px; height: 300px"></div>
    <?php $whois->whois($_GET['ip']); ?>
  </body>
</html>

