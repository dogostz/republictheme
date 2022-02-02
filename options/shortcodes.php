<?php

add_shortcode( 'list', 'crb_list_shortcode' );
add_shortcode( 'wpml_translate', 'crb_wpml_translations' );
add_shortcode( 'location_map', 'crb_location_map' );

# List Shortcode
function crb_list_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'href' => 'http://'
	), $atts));

	if ( empty($content) ) {
		$content = 'Please enter content.';
	}

	return '<div class="cols-list">'. apply_filters('the_content', $content) .'</div>';
}

# Custom WPML Translation Shortcode
function crb_wpml_translations( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'lang' => ''
	), $atts));
	
    $lang_active = ICL_LANGUAGE_CODE;   
	if( $lang == $lang_active ){
		return $content;
	}
}

/**
 * Displays the map
 *
 * @access      private
 * @since       1.0
 * @return      void
 */
function crb_location_map( $atts ) {

    $atts = shortcode_atts(
        array(
            'address'           => false,
            'width'             => '100%',
            'height'            => '400px',
            'enablescrollwheel' => 'true',
            'zoom'              => 15,
            'disablecontrols'   => 'true',
            'key'               => ''
        ),
        $atts
    );

    $address = $atts['address'];

    if( $address  ) :
        $coordinates = crb_map_get_coordinates( $address, false, sanitize_text_field( $atts['key'] ) );

        if( ! is_array( $coordinates ) ) {
            return;
        }

        if (!is_admin()) {
            wp_enqueue_script( 'polyfill', 'https://polyfill.io/v3/polyfill.min.js?features=default', false, 1.0, false );
            wp_enqueue_script( 'google-maps-api', '//maps.google.com/maps/api/js?key=' . sanitize_text_field( $atts['key'] ), false, 1.0, false );
            // wp_print_scripts( 'google-maps-api' );
        }

        $map_id = uniqid( 'crb_map_' ); // generate a unique ID for this map

        ob_start(); ?>
        <div class="crb_map_canvas" id="<?php echo esc_attr( $map_id ); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: <?php echo esc_attr( $atts['width'] ); ?>"></div>
        <div id="content">
            <img src="<?php echo get_template_directory_uri() ?>/images/republic-office.JPG">
        </div>
        <script type="text/javascript">
            let map, popup, Popup;
            var map_<?php echo $map_id; ?>;
            function crb_run_map_<?php echo $map_id ; ?>(){
                if (typeof(google) === "undefined") return;

                var location = new google.maps.LatLng("<?php echo $coordinates['lat']; ?>", "<?php echo $coordinates['lng']; ?>");
                var map_options = {
                    zoom: <?php echo $atts['zoom']; ?>,
                    center: location,
                    scrollwheel: <?php echo 'true' === strtolower( $atts['enablescrollwheel'] ) ? '1' : '0'; ?>,
                    disableDefaultUI: <?php echo 'true' === strtolower( $atts['disablecontrols'] ) ? '1' : '0'; ?>,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoomControl: true,
                    mapTypeControl: true,
                    scaleControl: true,
                }
                map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo $map_id ; ?>"), map_options);

                /**
                 * A customized popup on the map.
                 */
                class Popup extends google.maps.OverlayView {
                    constructor(position, content) {
                        super();
                        this.position = position;
                        content.classList.add("popup-bubble");
                        // This zero-height div is positioned at the bottom of the bubble.
                        const bubbleAnchor = document.createElement("div");
                        content.querySelector("img").style.display = "block";
                        bubbleAnchor.classList.add("popup-bubble-anchor");
                        bubbleAnchor.appendChild(content);
                        // This zero-height div is positioned at the bottom of the tip.
                        this.containerDiv = document.createElement("div");
                        this.containerDiv.classList.add("popup-container");
                        this.containerDiv.appendChild(bubbleAnchor);
                        // Optionally stop clicks, etc., from bubbling up to the map.
                        Popup.preventMapHitsAndGesturesFrom(this.containerDiv);
                    }
                    /** Called when the popup is added to the map. */
                    onAdd() {
                        this.getPanes().floatPane.appendChild(this.containerDiv);
                    }
                    /** Called when the popup is removed from the map. */
                    onRemove() {
                        if (this.containerDiv.parentElement) {
                            this.containerDiv.parentElement.removeChild(this.containerDiv);
                        }
                    }
                    /** Called each frame when the popup needs to draw itself. */
                    draw() {
                        const divPosition = this.getProjection().fromLatLngToDivPixel(
                            this.position
                        );
                        // Hide the popup when it is far out of view.
                        const display =
                            Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000
                                ? "block"
                                : "none";

                        if (display === "block") {
                            this.containerDiv.style.left = divPosition.x + "px";
                            this.containerDiv.style.top = divPosition.y + "px";
                        }

                        if (this.containerDiv.style.display !== display) {
                            this.containerDiv.style.display = display;
                        }
                    }
                }
                popup = new Popup(
                    location,
                    document.getElementById("content")
                );
                popup.setMap(map_<?php echo $map_id ; ?>);
            }

            crb_run_map_<?php echo $map_id ; ?>();
        </script>
        <?php
        return ob_get_clean();
    else :
        return __( 'This Google Map cannot be loaded because the maps API does not appear to be loaded', 'simple-google-maps-short-code' );
    endif;
}

/**
 * Retrieve coordinates for an address
 *
 * Coordinates are cached using transients and a hash of the address
 *
 * @access      private
 * @since       1.0
 * @return      void
 */
function crb_map_get_coordinates( $address, $force_refresh = false, $api_key = '' ) {

    $address_hash = md5( $address );

    $coordinates = get_transient( $address_hash );

    if ( $force_refresh || $coordinates === false ) {
        $args       = apply_filters( 'crb_map_query_args', array( 'key' => $api_key, 'address' => urlencode( $address ), 'key' => $api_key ) );
        $url        = add_query_arg( $args, 'https://maps.googleapis.com/maps/api/geocode/json' );
        $response 	= wp_remote_get( $url );

        if( is_wp_error( $response ) ) {
            return;
        }

        $data = wp_remote_retrieve_body( $response );

        if( is_wp_error( $data ) ) {
            return;
        }

        if ( $response['response']['code'] == 200 ) {

            $data = json_decode( $data );

            if ( $data->status === 'OK' ) {

                $coordinates = $data->results[0]->geometry->location;

                $cache_value['lat'] 	= $coordinates->lat;
                $cache_value['lng'] 	= $coordinates->lng;
                $cache_value['address'] = (string) $data->results[0]->formatted_address;

                // cache coordinates for 3 months
                set_transient($address_hash, $cache_value, 3600*24*30*3);
                $data = $cache_value;

            } elseif ( $data->status === 'ZERO_RESULTS' ) {
                return __( 'No location found for the entered address.', 'simple-google-maps-short-code' );
            } elseif( $data->status === 'INVALID_REQUEST' ) {
                return __( 'Invalid request. Did you enter an address?', 'simple-google-maps-short-code' );
            } else {
                return __( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'simple-google-maps-short-code' );
            }

        } else {
            return __( 'Unable to contact Google API service.', 'simple-google-maps-short-code' );
        }

    } else {
        // return cached results
        $data = $coordinates;
    }

    $data['lat'] = 43.213554;
    $data['lng'] = 27.902129;

    return $data;
}