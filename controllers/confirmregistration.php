<?php

namespace Purpozed2\Controllers;

class ConfirmRegistration extends \Purpozed2\Controller
{
    protected $description = 'Confirm Registration';

    public function setViewVariables()
    {

        if (isset($_GET['id']) && isset($_GET['key'])) {
            $userId = esc_attr($_GET['id']);
            $key = esc_attr($_GET['key']);

            $userKey = get_user_meta($userId, 'is_confirmed') ? get_user_meta($userId, 'is_confirmed')[0] : 0;
            if ($userKey === $key) {
                update_user_meta($userId, 'is_confirmed', 1);
                $this->view->info = 10;
            } elseif ($userKey === '1') {
                $this->view->info = 20;
            } else {
                $this->view->info = 30;
            }

        } else {
            $this->view->info = 40;
        }
    }

}