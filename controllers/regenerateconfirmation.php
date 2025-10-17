<?php

namespace Purpozed2\Controllers;

class RegenerateConfirmation extends \Purpozed2\Controller
{
    protected $description = 'Regenerate confirmation';

    public function setViewVariables()
    {

        if (isset($_POST['submit'])) {
            $this->view->info = $this->sendConfirmationEmail();
        }
    }

    public function sendConfirmationEmail()
    {

        $info = array();
        $email = esc_attr($_POST['email']);

        $userId = email_exists($email);
        if (is_int($userId)) {

            $registrtion_code = get_user_meta($userId, 'is_confirmed')[0];

            if (!$registrtion_code) {
                return $info = 30;
            } elseif ($registrtion_code === '1') {
                return $info = 10;
            } else {
                ob_start();
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/confirm-registration.php');
                $message = ob_get_contents();
                ob_clean();

                $to = $email;
                $subject = 'purpozed: Bitte bestätige Deine E-Mail-Adresse';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                $mail = wp_mail($to, $subject, $message, $headers);

                if ($mail) {
                    return $info = 20;
                } else {
                    return $info = 30;
                }
            }

        } else {
            $info = 40;
            return $info;
        }
    }

}