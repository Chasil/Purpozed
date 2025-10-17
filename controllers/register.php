<?php

namespace Purpozed2\Controllers;

class Register extends \Purpozed2\Controller
{
    protected $description = 'Register Volunteer';

    public function setViewVariables()
    {

        $skillsManager = new \Purpozed2\Models\SkillManager();
        $this->view->skills = $skillsManager->getList();

        $goalsManager = new \Purpozed2\Models\GoalsManager();
        $this->view->goals = $goalsManager->getList();

        if (isset($_POST['submit'])) {
            $this->view->errors = $this->userRegistration();
        }
    }

    public function userRegistration()
    {

        $validPostKeys = array('title', 'forename', 'surname', 'phone', 'company_id', 'email', 'password', 'repeat_password', 'skills', 'goals', 'help');
        $parsedPostData = array();
        foreach ($validPostKeys as $postValue) {
            $parsedPostData[$postValue] = (isset($_POST[$postValue])) ? $_POST[$postValue] : '';
        }

        $errors = array();
        if (email_exists($parsedPostData['email'])) {
            $errors[] = 'email-exists';
            return $errors;

        } else {

            $validation = new \Purpozed2\Models\validation();

            $validationTypes = array('title', 'forename', 'surname', 'phone', 'company_id', 'email', 'password', 'skills', 'goals');

            foreach ($validationTypes as $validationValue) {
                if (is_string($validation->$validationValue($parsedPostData[$validationValue]))) {
                    $errors[] = $validation->$validationValue($parsedPostData[$validationValue]);
                }
            }

            if (is_string($validation->password_repeat($parsedPostData['password'], $parsedPostData['repeat_password']))) {
                $errors[] = $validation->password_repeat($parsedPostData['password'], $parsedPostData['repeat_password']);
            }

            $company = new \Purpozed2\Models\Company();

            if (!$company->doesExist($parsedPostData['company_id'])) {
                $errors[] = 'no-company';
            }

            if (empty($errors)) {
                $userId = wp_create_user($parsedPostData['email'], $parsedPostData['password'], $parsedPostData['email']);
                if (is_int($userId)) {
                    $registrtion_code = md5(uniqid($parsedPostData['email'], true));

                    add_user_meta($userId, 'title', $parsedPostData['title']);
                    update_user_meta($userId, 'first_name', $parsedPostData['forename']);
                    update_user_meta($userId, 'last_name', $parsedPostData['surname']);
                    add_user_meta($userId, 'phone', $parsedPostData['phone']);
                    add_user_meta($userId, 'company_id', $parsedPostData['company_id']);
                    add_user_meta($userId, 'is_confirmed', $registrtion_code);

                    global $wpdb;

                    foreach ($parsedPostData['goals'] as $goalKey => $goalValue) {
                        $wpdb->insert('wp_purpozed_user_goals',
                            array(
                                'user_id' => $userId,
                                'goal_id' => $goalKey
                            ),
                            array(
                                '%d',
                                '%d'
                            )
                        );
                    }

                    foreach ($parsedPostData['skills'] as $skillKey => $skillValue) {
                        $wpdb->insert('wp_purpozed_user_skills',
                            array(
                                'user_id' => $userId,
                                'skill_id' => $skillKey
                            ),
                            array(
                                '%d',
                                '%d'
                            )
                        );
                    }

                    $role = new \WP_User($userId);
                    $role->set_role('volunteer');

                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/confirm-registration.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = $parsedPostData['email'];
                    $subject = 'purpozed: Bitte bestätige Deine E-Mail-Adresse';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    $mail = wp_mail($to, $subject, $message, $headers);

                    if (isset($_POST['contact_me'])) {
                        ob_start();
                        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/contact-me.php');
                        $message = ob_get_contents();
                        ob_clean();

                        $to = 'team@purpozed.org';
                        $subject = 'Contact needed';
                        $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                        $mail = wp_mail($to, $subject, $message, $headers);
                    }

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
}