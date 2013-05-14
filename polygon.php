<!DOCTYPE html/>
<html>
<head>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript"
	src="http://maps.google.com/maps/api/js?sensor=false">
    </script>
<title>Parse MIF File</title>
<script type="text/javascript">
	<?
	include 'include/map.php';
	?>
        var dbMapPoints = [
            <?
				// Load and parse MIF file 
                $ret=parse_mif('tmp/norisk.mif');
                // echo JS array of polygons
                echo $ret[1];
            ?>
        ];
          
        var map = null;
        var mapDefaults = {
            zoom: 15,
            center: null,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        };
        
        $(function () {
			var cent= new google.maps.LatLng(44.580267,18.944501);
            mapDefaults.center = cent;
            map = new google.maps.Map(document.getElementById("map"), mapDefaults);
            <?
                $i=1;
                while($i<=trim($ret[0])){
                    echo 'load_polygon('.$i.');';
                    $i++;
                }
            ?>            
        });
       
        function load_polygon(pol_id) {
            var latlng = [];
            $.when($.each($.grep(dbMapPoints, function (p, i) { 
                return (p.pol_id === pol_id); 
                }), function () {
                latlng.push(new google.maps.LatLng(this.lat, this.lng));
            })).done(function () {
                mapPoly = new google.maps.Polygon({
                    paths: latlng,
                    strokeColor:'#FF0000', 
                    strokeOpacity:0.8,
                    strokeWeight: 3,
                    fillColor: '#FF0000', 
                    fillOpacity: 0.35
                });
                mapPoly.setMap(map);
            });
        }
    </script>
</head>
<body>
	<section id="placeholder">
		<div id="map" style="width: 100%; height: 100%;"></div>
	</section>
</body>
</html>
