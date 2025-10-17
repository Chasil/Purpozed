<?php

namespace Purpozed2\Models;

class validation
{

    public function __construct()
    {

    }

    public function title($title)
    {
        if (!empty($title)) {
            return (preg_match('/^([ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜü.a-z\s-]{2,50})+$/i', $title)) ? true : _e('Title must contain letters only (min: 2, max: 50)', 'purpozed');
        } else {
            return true;
        }
    }

    public function forename($username)
    {
        return (preg_match('/^([ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüa-z\s-]{2,50})+$/i', $username)) ? true : _e('Forename must contain letters only (min: 2, max: 50).', 'purpozed');
    }

    public function surname($surname)
    {
        return (preg_match('/^([ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüa-z\s-]{2,50})+$/i', $surname)) ? true : _e('Surname must contain letters only (min: 2, max: 50).', 'purpozed');
    }

    public function phone($phone)
    {
        if (!empty($phone)) {
            return (preg_match('/^(?:[+\d].*\d|\d)$/i', $phone)) ? true : _e('Phone number must contain only numbers and + sign (min: 8, max: 15 chars)', 'purpozed');
        }
    }

    public function company_id($comapny_id)
    {
        return (preg_match('/^([0-9]{2,10})+$/i', $comapny_id)) ? true : _e('Company ID must contain from 2 to 10 digits only.', 'purpozed');
    }

    public function company_id_exists($comapny_id)
    {

        $users = get_users(array('fields' => array('ID')));

        foreach ($users as $user) {
            $userData = get_user_by('ID', $user->ID);
            if (in_array('company', $userData->roles)) {
                $currentCompanyId = get_user_meta($user->ID, 'company_id')[0];

                if ($currentCompanyId === $comapny_id) {
                    return true;
                }
            }
        }

        return false;
    }

    public function email($email)
    {
        return (is_string(filter_var($email, FILTER_VALIDATE_EMAIL))) ? true : _e('Invalid email.', 'purpozed');
    }

    public function password($password)
    {
        return (preg_match('/^(.*).{8,16}$/', $password)) ? true : false;
    }

    public function password_repeat($password, $repeat_password)
    {
        return ($password === $repeat_password) ? true : _e('Passwords missmatch.', 'purpozed');
    }

    public function skills($skills)
    {
        return (count($skills) < 3) ? _e('You must check at least 3 skills', 'purpozed') : true;
    }

    public function goals($goals)
    {
        return (count($goals) < 3) ? _e('You must check at least 3 goals', 'purpozed') : true;
    }
}