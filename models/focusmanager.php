<?php

namespace Purpozed2\Models;

class FocusManager {

    public function getList() {

        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_purpozed_focuses");
    }
}