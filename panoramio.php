<? function panoramio($location = 'world', $set = 'public', $qty = '20', $size = 'medium', $mapfilter = 'false'){

	// Translate $location to a bounding box of coordinates
	if($location == 'world'){
		$minx = -180;  	// 180 degrees West (International date line)
		$maxx = 180;  	// 180 degrees East (International date line)
		$miny = -90;  	// 90 degrees South (South pole)
		$maxy = 90;  	// 90 degrees North (North pole)
	}
	else {
		// Use Open Street Map's Nominatim to get the coordinates
		$geo_query = json_decode(file_get_contents('http://nominatim.openstreetmap.org/search?q='.urlencode($location).'&format=json&polygon=1'));
		foreach ($geo_query[0]->polygonpoints as $point){
			$pointsx[] = $point[0];
			$pointsy[] = $point[1];
		}
		$minx = min($pointsx);
		$maxx = max($pointsx);
		$miny = min($pointsy);
		$maxy = max($pointsy);
	}

	// Get the photos from panoramio. Limit per query is 100 photos, so we have to split it up.
	$photos = array();
	$i = 0;
	while($i < ceil($qty/100)){
		$from = $i*100;
		$to = $qty < $from+100 ? $qty : ($i+1)*100;
		$panoramio_query = json_decode(file_get_contents('http://www.panoramio.com/map/get_panoramas.php?set='.$set.'&from='.$from.'&to='.$to.'&minx='.$minx.'&miny='.$miny.'&maxx='.$maxx.'&maxy='.$maxy.'&size='.$size.'&mapfilter='.$mapfilter));
		foreach ($panoramio_query->photos as $photo) { array_push($photos, $photo); }
		$i++;
	}
	
	return $photos;

} ?>