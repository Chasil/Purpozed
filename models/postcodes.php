<?php

namespace Purpozed2\Models;


class PostCodes
{
    public function getCoordinates($postCode)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT lat, lon FROM wp_purpozed_zip_coordinates WHERE zipcode = %d", $postCode);

        return $wpdb->get_row($query);
    }
}