kirby-panoramio
===============

A plugin for [Kirby](http://getkirby.com/) that makes it easy to include geolocated Panoramio photos in your templates.

To install, put `panoramio.php` in your `/site/plugins` folder.

Use it like this:

	// Returns an array
    $photos = panoramio($location = 'world', $set = 'public', $qty = '20', $size = 'medium', $mapfilter = 'false');

There are a few variables. Here's a rundown (see the [Panoramio API docs](http://www.panoramio.com/api/data/api.html) for more details):

    $location    Plain-text description of the place (e.g. 'Key Largo' or 'Skåne')

    $set         The photoset to draw from. Accepted values are:
                 'public' (popular photos)
                 'full' (recent photos)
                 user ID (photos from a particular user)

    $qty         The number of photos to retrieve. Maximum is 10 million — I hope that's enough...

    $size        The size of the photos. Accepted values are:
			 	 'original'    (original resolution)
				 'medium'      (500px wide)
				 'small'       (240px wide)
				 'thumbnail'   (100px wide)
				 'square'      (60px * 60px)
				 'mini_square' (32px * 32px)

	$mapfilter   If set to 'true', Panoramio will filter the results to make them fit better on a map (less photos in the same location)

This plugin returns an array that looks like this:

    Array
    (
        [0] => stdClass Object
            (
                [height] => 500
                [latitude] => 42.341873
                [longitude] => -71.1083811
                [owner_id] => 4291456
                [owner_name] => Konstantin Khrapko
                [owner_url] => http://www.panoramio.com/user/4291456
                [photo_file_url] => http://mw2.google.com/mw-panoramio/photos/medium/44537736.jpg
                [photo_id] => 44537736
                [photo_title] => Goose chain in Muddy river. 
                [photo_url] => http://www.panoramio.com/photo/44537736
                [upload_date] => 03 December 2010
                [width] => 333
            )
        [1] => stdClass Object
            (
            	[...]
            )
    )

And here's some sample template code to get you started:

	<?php $photos = panoramio('Portugal',4494359,50,'thumbnail') ?>

	<ul class="photo-gallery">
		<?php foreach ($photos as $photo) { ?>
			<li>
				<a href="http://static.panoramio.com/photos/original/<?php echo $photo->photo_id ?>.jpg" title="<?php echo $photo->photo_title ?>"> // Manually recreating the URL syntax for the 'original' size photo so I can link to it
					<img src="<?php echo $photo->photo_file_url ?>" alt="<?php echo $photo->photo_title ?>" />
					<p class="caption"><?php echo $photo->photo_title ?></p>
				</a>
			</li>
		<? } ?>
	</ul>

## To do

- Better error handling
- Allow multiple locations