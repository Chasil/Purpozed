<?php

namespace Purpozed2\Controllers;

class RegisterOrganization extends \Purpozed2\Controller
{
    protected $description = 'Register Organization';

    public function setViewVariables()
    {

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $goals = $goalsManager->getListAsArray();
        usort($goals, array($this, 'sort_skills'));
        $this->view->goals = $goals;

        if (isset($_POST['submit'])) {
            $this->view->errors = $this->organizationRegistration();
        }
    }

    public function organizationRegistration()
    {

        $validPostKeys = array('organization_name', 'street', 'zip', 'city', 'website', 'about', 'logo', 'main_goal', 'goals', 'forename', 'surname', 'title', 'phone', 'email', 'password', 'repeat_password', 'help');
        $parsedPostData = array();
        foreach ($validPostKeys as $postValue) {
            $parsedPostData[$postValue] = (isset($_POST[$postValue])) ? $_POST[$postValue] : '';
        }

        $logoId = '';
        if (($_FILES['image']['size']) !== 0) {
            $logoId = $this->uploadLogo($_FILES);
        }

        $errors = array();
        if (email_exists($parsedPostData['email'])) {
            $errors[] = 'email-exists';
            return $errors;

        } else {

            $validation = new \Purpozed2\Models\validation();

            $validationTypes = array('title', 'forename', 'surname', 'phone', 'email', 'password');

            foreach ($validationTypes as $validationValue) {
                if (is_string($validation->$validationValue($parsedPostData[$validationValue]))) {
                    $errors[] = $validation->$validationValue($parsedPostData[$validationValue]);
                }
            }

            if (is_string($validation->password_repeat($parsedPostData['password'], $parsedPostData['repeat_password']))) {
                $errors[] = $validation->password_repeat($parsedPostData['password'], $parsedPostData['repeat_password']);
            }

            if (empty($errors)) {
                $userId = wp_create_user($parsedPostData['email'], $parsedPostData['password'], $parsedPostData['email']);
                if (is_int($userId)) {
                    $registrtion_code = md5(uniqid($parsedPostData['email'], true));

                    add_user_meta($userId, 'organization_name', $parsedPostData['organization_name']);
                    add_user_meta($userId, 'street', $parsedPostData['street']);
                    add_user_meta($userId, 'zip', $parsedPostData['zip']);
                    add_user_meta($userId, 'city', $parsedPostData['city']);
                    add_user_meta($userId, 'website', $parsedPostData['website']);
                    add_user_meta($userId, 'about', $parsedPostData['about']);
                    add_user_meta($userId, 'logo', $logoId);
                    add_user_meta($userId, 'main_goal', $parsedPostData['main_goal']);
                    update_user_meta($userId, 'first_name', $parsedPostData['forename']);
                    update_user_meta($userId, 'last_name', $parsedPostData['surname']);
                    add_user_meta($userId, 'title', $parsedPostData['title']);
                    add_user_meta($userId, 'phone', $parsedPostData['phone']);
                    add_user_meta($userId, 'is_confirmed', $registrtion_code);

                    //TODO maila jak potrzebny help

                    global $wpdb;

                    foreach ($parsedPostData['goals'] as $goalKey => $goalValue) {
                        $wpdb->insert('wp_purpozed_organization_goals',
                            array(
                                'organization_id' => $userId,
                                'goal_id' => $goalKey
                            ),
                            array(
                                '%d',
                                '%d'
                            ));
                    }

                    $role = new \WP_User($userId);
                    $role->set_role('organization');

                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/confirm-registration.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = $parsedPostData['email'];
                    $subject = 'purpozed: Bitte bestätige Deine E-Mail-Adresse';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    $mail = wp_mail($to, $subject, $message, $headers);

                    if ($mail) {
                        header('Location: /thank-you');

                    }
                } else {
                    foreach ($userId as $error) {
                        if ($error[0] = 'existing_user_login') {
                            $errors[] = 'existing_user_login';
                        } else {
                            $errors[] = 'others';
                        }
                        return $errors;
                    }
                }
            } else {
                return $errors;
            }
        }
    }

    public function uploadLogo($logo)
    {

        $file = $logo['image']['tmp_name'];
        $filename = $logo['image']['name'];

        $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $upload_file['file']);
            if (!is_wp_error($attachment_id)) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
                wp_update_attachment_metadata($attachment_id, $attachment_data);
            }

            return $attachment_id;
        } else {
            return $upload_file['error'];
        }
    }

    public function sort_skills($a, $b)
    {
        return strnatcmp($a['name'], $b['name']);
    }
}