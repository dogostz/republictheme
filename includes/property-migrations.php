<?php

if (isset($_GET['migrate-rental-properties'])) {
    // crb_migrate_rentals();
    crb_migrate_base_properties();
}

function crb_migrate_base_properties() {
    global $wpdb;

    $sql = "SELECT * FROM `wp_posts` WHERE `post_title` LIKE '%под наем%' AND `post_type` LIKE 'property-base'";

    $result = $wpdb->get_results($sql);

    if (empty($result)) {
        return false;
    }

    foreach ($result as $p) {
        $pid = $p->ID;
        echo '<pre>';
        print_r($pid . ' - ' . $p->post_title . ' - updated successfully!');
        echo '</pre>';

        wp_update_post(array(
            'ID' => $pid,
            'post_type' => 'property-rental-base',
        ));
    }

    die('all done!');
}

function crb_migrate_rentals() {
    global $wpdb;

    $sql = "SELECT * FROM `wp_postmeta`
            INNER JOIN wp_posts ON `wp_postmeta`.`post_id` = `wp_posts`.`ID`
            WHERE (`wp_postmeta`.`meta_key` LIKE '_property_is_rental' AND `wp_postmeta`.`meta_value` LIKE 'yes')
            AND `wp_posts`.`post_type` LIKE 'property-base'";

    $result = $wpdb->get_results($sql);

    if (empty($result)) {
        return false;
    }

    foreach ($result as $p) {
        $pid = $p->ID;

        // Some properties are also added in the "Продажби" type. We should NOT move them
        $has_main_post = crb_get_meta('_property_child_id', $pid);

        if ($has_main_post) {
            continue;
        }

        $updated_post_id = wp_update_post(array(
            'ID' => $pid,
            'post_type' => 'property-rental-base',
        ));

        echo '<pre>';
        print_r($p->ID .' - ' . $updated_post_id . ' - updated successfully!');
        echo '</pre>';
    }

    die('all done!');
}