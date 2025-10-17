<?php

namespace Purpozed2\Controllers;

class passwordReset extends \Purpozed2\Controller
{
    protected $description = 'Password Reset';

    public function setViewVariables()
    {
        $this->view->info = $this->resetPassword();
    }

    public function resetPassword()
    {

        $info = array();
        if (isset($_POST['submit'])) {
            $email = esc_attr($_POST['email']);

            $userId = email_exists($email);
            if (is_int($userId)) {
                $password = $this->passwordGenerator(8);
                wp_set_password($password, $userId);

                ob_start();
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/password-reset.php');
                $message = ob_get_contents();
                ob_clean();

                $to = $email;
                $subject = 'PURPOZED - Password reset';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                $mail = wp_mail($to, $subject, $message, $headers);

                if ($mail) {
                    $info['success'] = 1;
                    return $info;
                } else {
                    $info['email-fail'] = 'There was some error during sending an email, try again';
                    return $info;
                }
            } else {
                $info['no-email'] = 'There is no such email in our database';
                return $info;
            }
        }
    }

    public function passwordGenerator($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}