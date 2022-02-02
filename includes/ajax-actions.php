<?php

add_action( 'wp_ajax_nopriv_get_property_images', 'crb_ajax_property_images' );
add_action( 'wp_ajax_get_property_images', 'crb_ajax_property_images' );

function crb_ajax_property_images() {
    $propertyId = !empty($_POST['propertyId']) ? $_POST['propertyId'] : '';

    $images = crb_get_property_featured_images($propertyId);

    if (empty($images)) {
        wp_send_json_error( 'Error! This property doesn\'t have any images' );
    }

    $output = [];

    foreach ($images as $item) {
        $output[]['src'] = $item['image'];
    }

    wp_send_json_success( $output );
}