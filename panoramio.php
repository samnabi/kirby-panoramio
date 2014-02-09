<? function panoramio($minx = -180, $maxx = 180, $miny = -90, $maxy = 90, $set = 'public', $qty = '20', $size = 'medium', $mapfilter = 'false'){

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