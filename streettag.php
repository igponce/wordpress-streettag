<?php
/*
Plugin Name: Streettag
Plugin URI: http://mafiainmobiliaria.com/streettag
Description: Este plugin te permite mostrar en un post un mapa de google maps con su correspondiente entrada de streetview. Para mostrarlo hay que incorporar el tag [streettag] en el post. Necesita jQuery para funcionar.
Author: Inigo Gonzalez
Version: 1.7
Author URI: http://exocert.com
*/

// Tag Incorporado a WP
// [streettag gm_lat='', gm_long='', gm_zoom='', gs_yaw='', gs_pitch='', gs_zoom='']


function streettag_func( $atts ) {
global $post;
$post_id = $post->ID;

# Put yor Google Maps API Key Here: (should be a plugin option)
$ApiKey = "";

    extract(
            shortcode_atts(array (
                'gm_lat' => '0',
                'gm_long' => '0',
                'gm_zoom' => '14',
                'gs_yaw' => '0',
                'gs_pitch' => '0',
                'gs_zoom' => '2'
            ), $atts )
    );
    
    // Sacamos el código del mapa.
    
    $post_body = "<div id='elmapa{$post_id }' class='streettag_map_canvas'></div>";
    
    // <div id='lacalle{$post_id}' class='streettag_sv_canvas'></div>

    $post_body .= "
    <script type='text/javascript'>
    function initmap$post_id() {
            var mapa{$post_id};
            var calle{$post_id};
            var svoverlay{$post_id};
            var aquimismo{$post_id} = new google.maps.LatLng ( {$gm_lat} , " . $gm_long .") ;
            var mirar_a{$post_id} = { yaw:{$gs_yaw} , pitch: {$gs_pitch} , zoom: {$gs_zoom } };

	    var mapOpts{$post_id} = {
               center: new google.maps.LatLng ( $gm_lat , $gm_long ) ,
	       zoom: 15 // $gs_zoom
            };

            mapa{$post_id} = new google.maps.Map(document.getElementById('elmapa{$post_id}'), mapOpts{$post_id});
    }
    google.maps.event.addDomListener( window, 'load', initmap$post_id );

            // mapa{$post_id}.setCenter ( aquimismo{$post_id} , {$gm_zoom} );
            // svoverlay{$post_id} = new GStreetviewOverlay();

            // mapa{$post_id}.addOverlay (svoverlay{$post_id});

            // calle{$post_id} = new GStreetviewPanorama(document.getElementById('lacalle{$post_id}'));
            // calle{$post_id}.setLocationAndPOV ( aquimismo{$post_id}, mirar_a{$post_id} );
    </script>
        
        <script type='text/javascript' src='//maps.googleapis.com/maps/api/js?key=" . $ApiKey . "&sensor=true'>
        </script>
	<br/>
	<img src='http://maps.googleapis.com/maps/api/streetview?size=600x400&location=$gm_lat,$gm_long&zoom=$gs_zoom&heading=$gs_yaw&pitch=$gs_pitch&sensor=false'>
";


   return $post_body;   
}

add_shortcode ('streettag', 'streettag_func');

//// [bartag foo="foo-value"]
//function bartag_func($atts) {
//	extract(shortcode_atts(array(
//		'foo' => 'no foo',
//		'bar' => 'default bar',
//	), $atts));
//
//	return "foo = {$foo}";

?>
