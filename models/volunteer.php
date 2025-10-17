<?php

namespace Purpozed2\Models;

class Volunteer
{

    protected $userId;

    public function __construct(int $id)
    {
        $this->setUserId($id);
    }

    protected function getUserId(): int
    {
        return $this->userId;
    }

    protected function setUserId(int $id): bool
    {
        $this->userId = $id;
        return true;
    }

    public function getDetails()
    {

        return get_user_meta($this->getUserId());
    }

    public function getSkills()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_user_skills wpus
                                        LEFT JOIN wp_purpozed_skills wps
                                        ON wps.id = wpus.skill_id
                                        WHERE user_id = %d", $this->getUserId());

        return $wpdb->get_results($query);
    }

    public function getGoals()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_user_goals wpug
                                        LEFT JOIN wp_purpozed_goals wpg
                                        ON wpg.id = wpug.goal_id
                                        WHERE user_id = %d", $this->getUserId());

        return $wpdb->get_results($query);
    }

    public function applyToOpportunity($opportunityId)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();

        $organizationId = $opportunity->getOrganization($opportunityId);
        ob_start();
        require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/volunteer-applied-to-opportunity.php');
        $message = ob_get_contents();
        ob_clean();

        $to = get_userdata($organizationId)->data->user_email;
        $subject = 'Gratulation! Ein Freiwilliger möchte eine Deiner Tätigkeiten übernehmen. Bitte antworte jetzt...';
        $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

        wp_mail($to, $subject, $message, $headers);

        return $wpdb->insert('wp_purpozed_volunteer_applied',
            array(
                'user_id' => $this->getUserId(),
                'opportunity_id' => $opportunityId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function retractOpportunity()
    {

        global $wpdb;
    }

    public function removeApplication($opportunityId)
    {

        global $wpdb;

        $wpdb->delete('wp_purpozed_volunteer_applied',
            array(
                'user_id' => $this->getUserId(),
                'opportunity_id' => $opportunityId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function removeFromTheList($opportunityId, $rejectedByVolunteer, $retractedByVolunteer)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
        $type = $opportunity->getType($opportunityId);

        if ($rejectedByVolunteer) {
            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            $currentOpportunity = '';

            if ($type === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($type === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($type === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($type === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/request-rejected-by-volunteer.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Schade, ein Freiwilliger hat gerade Deine Anfrage abgelehnt';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        if ($retractedByVolunteer) {
            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            $currentOpportunity = '';

            if ($type === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($type === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($type === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($type === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/application-retracted-by-volunteer.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Du hast leider zu lange gezögert. Ein Freiwilliger hat sein Interesse an einer Deiner Tätigkeiten zurückgezogen';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        $wpdb->update('wp_purpozed_volunteer_applied',
            array(
                'removed' => 1,
            ),
            array(
                'user_id' => $this->getUserId(),
                'opportunity_id' => $opportunityId
            ),
            array(
                '%d',
                '%d'
            )
        );

        $wpdb->update('wp_purpozed_volunteer_request',
            array(
                'removed' => 1,
            ),
            array(
                'user_id' => $this->getUserId(),
                'opportunity_id' => $opportunityId
            ),
            array(
                '%d',
                '%d'
            )
        );

        $wpdb->delete('wp_purpozed_volunteer_bookmarked',
            array(
                'user_id' => $this->getUserId(),
                'opportunity_id' => $opportunityId
            ),
            array(
                '%d',
                '%d'
            )
        );
    }

    public function signInToOpportunity($opportunityId, $applyAccepted, $acceptedUser)
    {
        global $wpdb;

        $wpdb->insert('wp_purpozed_volunteer_in_progress',
            array(
                'user_id' => $this->getUserId(),
                'opportunity_id' => $opportunityId
            ),
            array(
                '%d',
                '%d'
            )
        );

        $wpdb->insert('wp_purpozed_engaged_users',
            array(
                'user_id' => $this->getUserId(),
                'engaged_date' => date('Y-m-d'),
            ),
            array(
                '%d',
                '%s'
            )
        );

        $opportunity = new \Purpozed2\Models\Opportunity();
        $type = $opportunity->getType($opportunityId);

        if ($type !== 'engagement') {

            $usersApplied = $opportunity->getApplied($opportunityId);


            foreach ($usersApplied as $user) {
                if ((int)$user->user_id !== (int)$acceptedUser) {

                    $userName = get_user_meta($this->getUserId(), 'first_name')[0];

                    $organizationId = $opportunity->getOrganization($opportunityId);
                    $organizationName = get_user_meta($organizationId, 'organization_name')[0];

                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/applied-but-not-chosen.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = get_userdata($user->user_id)->data->user_email;
                    $subject = 'Schade, ein anderer Volunteer wurde für eine Tätigkeit ausgewählt, an der du Interesse bekundet hast';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    wp_mail($to, $subject, $message, $headers);
                }
            }

            $usersRequested = $opportunity->getRequested($opportunityId);

            foreach ($usersRequested as $user) {
                if ((int)$user->user_id !== (int)$acceptedUser) {

                    $userName = get_user_meta($user->user_id, 'first_name')[0];

                    $organizationId = $opportunity->getOrganization($opportunityId);
                    $organizationName = get_user_meta($organizationId, 'organization_name')[0];

                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/requested-but-not-chosen.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = get_userdata($user->user_id)->data->user_email;
                    $subject = 'Du hast leider zu lange gezögert. Ein anderer Volunteer wurde für eine Tätigkeit ausgewählt, für die Du angefragt wurdest';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    wp_mail($to, $subject, $message, $headers);
                }
            }

            if ($applyAccepted === '1') {


            } else {

                $organizationId = $opportunity->getOrganization($opportunityId);

                $userName = get_user_meta($acceptedUser, 'first_name')[0];
                $userLastName = get_user_meta($acceptedUser, 'last_name')[0];
                $userPhone = (get_user_meta($acceptedUser, 'phone')) ? get_user_meta($this->getUserId(), 'phone')[0] : 'No phone number';
                $userEmail = $to = get_userdata($acceptedUser)->data->user_email;

                ob_start();
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/notify-organization-about-succeeded-request.php');
                $message = ob_get_contents();
                ob_clean();

                $to = get_userdata($organizationId)->data->user_email;
                $subject = 'Gratulation! Ein Freiwilliger, hat gerade eine Deiner Tätigkeiten übernommen. So geht es jetzt weiter…';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                wp_mail($to, $subject, $message, $headers);
            }
            $opportunity->startOpportunity($opportunityId);
        }

        $opportunity->removeFromApplied($opportunityId, $this->getUserId());
        $opportunity->removeFromRequested($opportunityId, $this->getUserId());

        if ($applyAccepted) {

            $to = get_userdata($this->getUserId())->data->user_email;
            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            $organizationId = $opportunity->getOrganization($opportunityId);
            $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();

            $currentOpportunity = '';

            if ($type === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($type === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($type === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($type === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            $organizationName = get_user_meta($organizationId, 'organization_name')[0];
            $organizationFirstName = get_user_meta($organizationId, 'first_name')[0];
            $organizationLastName = get_user_meta($organizationId, 'last_name')[0];
            $organizationPhone = get_user_meta($organizationId, 'phone')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/apply-accepted.php');
            $message = ob_get_contents();
            ob_clean();

            $subject = 'Gratuliere! Du wurdest gerade für eine Tätigkeit ausgewählt. So geht es jetzt weiter…';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        return true;
    }

    public function saveSettings($logoId)
    {

        $returnData = array();

        $validation = new \Purpozed2\Models\validation();

        if (!empty($logoId)) {
            update_user_meta($this->getUserId(), 'image', $logoId);
        }

        update_user_meta($this->getUserId(), 'title', esc_html($_POST['title']));
        update_user_meta($this->getUserId(), 'first_name', esc_html($_POST['first_name']));
        update_user_meta($this->getUserId(), 'last_name', esc_html($_POST['last_name']));
        update_user_meta($this->getUserId(), 'company_id', esc_html($_POST['company_id']));
        update_user_meta($this->getUserId(), 'zip', esc_html($_POST['zip']));
        update_user_meta($this->getUserId(), 'city', esc_html($_POST['city']));

        if (isset($_POST['ready_for_request'])) {
            update_user_meta($this->getUserId(), 'ready_for_request', esc_html($_POST['ready_for_request']));
        } else {
            update_user_meta($this->getUserId(), 'ready_for_request', '');
        }
        if (isset($_POST['comments_visible'])) {
            update_user_meta($this->getUserId(), 'comments_visible', esc_html($_POST['comments_visible']));
        } else {
            update_user_meta($this->getUserId(), 'comments_visible', '');
        }
        update_user_meta($this->getUserId(), 'about', esc_html($_POST['about']));

        global $wpdb;

        $wpdb->delete('wp_purpozed_user_goals',
            array(
                'user_id' => $this->getUserId(),
            ),
            array(
                '%d',
            )
        );

        if (isset($_POST['goals'])) {
            foreach ($_POST['goals'] as $goalKey => $goalValue) {
                $wpdb->insert('wp_purpozed_user_goals',
                    array(
                        'user_id' => $this->getUserId(),
                        'goal_id' => $goalKey
                    ),
                    array(
                        '%d',
                        '%d'
                    )
                );
            }
        }

        $wpdb->delete('wp_purpozed_user_skills',
            array(
                'user_id' => $this->getUserId(),
            ),
            array(
                '%d',
            )
        );

        if (isset($_POST['skills'])) {
            foreach ($_POST['skills'] as $skillKey => $skillValue) {
                $wpdb->insert('wp_purpozed_user_skills',
                    array(
                        'user_id' => $this->getUserId(),
                        'skill_id' => $skillKey
                    ),
                    array(
                        '%d',
                        '%d'
                    )
                );
            }
        }

        $wpdb->delete('wp_purpozed_user_experiences',
            array(
                'user_id' => $this->getUserId(),
            ),
            array(
                '%d',
            )
        );

        if (isset($_POST['experiences'])) {
            foreach ($_POST['experiences'] as $experienceKey => $experienceValue) {
                $wpdb->insert('wp_purpozed_user_experiences',
                    array(
                        'user_id' => $this->getUserId(),
                        'text' => $experienceValue
                    ),
                    array(
                        '%d',
                        '%s'
                    )
                );
            }
        }

        $wpdb->delete('wp_purpozed_user_links',
            array(
                'user_id' => $this->getUserId(),
            ),
            array(
                '%d',
            )
        );

        if (isset($_POST['links'])) {
            foreach ($_POST['links'] as $linkKey => $linkValue) {
                $wpdb->insert('wp_purpozed_user_links',
                    array(
                        'user_id' => $this->getUserId(),
                        'url' => $linkValue['url'],
                        'name' => $linkValue['name']
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }
        }

        $userData = get_userdata(get_current_user_id());
        $currentEmail = $userData->data->user_email;

        if ($currentEmail !== $_POST['email']) {
            wp_update_user(array(
                'ID' => $this->getUserId(),
                'user_email' => esc_attr($_POST['email'])
            ));
            $registrtion_code = md5(uniqid($_POST['email'], true));
            update_user_meta($this->getUserId(), 'is_confirmed', $registrtion_code);

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/change-email.php');
            $message = ob_get_contents();
            ob_clean();

            $to = $_POST['email'];
            $subject = _e('Confirm registrations', 'purpozed');
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            $send = wp_mail($to, $subject, $message, $headers);
            if ($send) {
                $returnData['email'] = true;
            } else {
                $returnData['email'] = false;
            }
        }

        $returnData['saved'] = true;

        if (!empty($_POST['old_password'])) {

            $oldPassword = esc_attr($_POST['old_password']);
            $newPassword = esc_attr($_POST['password']);
            $repeatPassword = esc_attr($_POST['repeat_password']);
            $user = wp_get_current_user();

            $isOldPasswordCorrect = wp_check_password($oldPassword, $user->user_pass, $user->data->ID);

            if ($isOldPasswordCorrect) {
                $isRepeatedTrue = $validation->password_repeat($newPassword, $repeatPassword);
                if (!$isRepeatedTrue) {
                    $returnData['password_reperat'] = false;
                    $returnData['saved'] = false;
                } else {
                    $isEnhancement = $validation->password($newPassword);
                    if (!$isEnhancement) {
                        $returnData['password_enhancement'] = false;
                        $returnData['saved'] = false;
                    } else {
                        wp_update_user(array(
                            'ID' => $this->getUserId(),
                            'user_pass' => esc_attr($newPassword)
                        ));
                    }
                }
            } else {
                $returnData['old_password'] = false;
                $returnData['saved'] = false;
            }
        }

        update_user_meta($this->getUserId(), 'phone', esc_html($_POST['phone']));

        return $returnData;
    }

    public function saveOrganizationSettings($logoId)
    {
        $returnData = array();

        $validation = new \Purpozed2\Models\validation();

        if (!empty($logoId)) {
            update_user_meta($this->getUserId(), 'logo', $logoId);
        }

        update_user_meta($this->getUserId(), 'organization_name', esc_html($_POST['organization_name']));
        update_user_meta($this->getUserId(), 'street', esc_html($_POST['street']));
        update_user_meta($this->getUserId(), 'zip', esc_html($_POST['zip']));
        update_user_meta($this->getUserId(), 'city', esc_html($_POST['city']));
        update_user_meta($this->getUserId(), 'website', esc_html($_POST['website']));
        update_user_meta($this->getUserId(), 'about', esc_html($_POST['description']));
        update_user_meta($this->getUserId(), 'main_goal', esc_html($_POST['main_goal']));
        update_user_meta($this->getUserId(), 'phone', esc_html($_POST['phone']));
        update_user_meta($this->getUserId(), 'first_name', esc_html($_POST['forename']));
        update_user_meta($this->getUserId(), 'last_name', esc_html($_POST['surname']));
        update_user_meta($this->getUserId(), 'title', esc_html($_POST['title']));

        global $wpdb;

        $wpdb->delete('wp_purpozed_organization_goals',
            array(
                'organization_id' => $this->getUserId(),
            ),
            array(
                '%d',
            )
        );

        foreach ($_POST['goals'] as $goalKey => $goalValue) {
            $wpdb->insert('wp_purpozed_organization_goals',
                array(
                    'organization_id' => $this->getUserId(),
                    'goal_id' => $goalKey
                ),
                array(
                    '%d',
                    '%d'
                )
            );
        }

        $wpdb->delete('wp_purpozed_user_links',
            array(
                'user_id' => $this->getUserId(),
            ),
            array(
                '%d',
            )
        );

        if (isset($_POST['links'])) {
            foreach ($_POST['links'] as $linkKey => $linkValue) {
                $wpdb->insert('wp_purpozed_user_links',
                    array(
                        'user_id' => $this->getUserId(),
                        'url' => $linkValue['url'],
                        'name' => $linkValue['name']
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }
        }

        $userData = get_userdata(get_current_user_id());
        $currentEmail = $userData->data->user_email;

        if ($currentEmail !== $_POST['email']) {
            wp_update_user(array(
                'ID' => $this->getUserId(),
                'user_email' => esc_attr($_POST['email'])
            ));
            $registrtion_code = md5(uniqid($_POST['email'], true));
            update_user_meta($this->getUserId(), 'is_confirmed', $registrtion_code);

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/change-email.php');
            $message = ob_get_contents();
            ob_clean();

            $to = $_POST['email'];
            $subject = _e('Confirm registrations', 'purpozed');
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            $send = wp_mail($to, $subject, $message, $headers);
            if ($send) {
                $returnData['email'] = true;
            } else {
                $returnData['email'] = false;
            }
        }

        $returnData['saved'] = true;

        if (!empty($_POST['old_password'])) {

            $oldPassword = esc_attr($_POST['old_password']);
            $newPassword = esc_attr($_POST['password']);
            $repeatPassword = esc_attr($_POST['repeat_password']);
            $user = wp_get_current_user();

            $isOldPasswordCorrect = wp_check_password($oldPassword, $user->user_pass, $user->data->ID);

            if ($isOldPasswordCorrect) {
                $isRepeatedTrue = $validation->password_repeat($newPassword, $repeatPassword);
                if (!$isRepeatedTrue) {
                    $returnData['password_reperat'] = false;
                    $returnData['saved'] = false;
                } else {
                    $isEnhancement = $validation->password($newPassword);
                    if (!$isEnhancement) {
                        $returnData['password_enhancement'] = false;
                        $returnData['saved'] = false;
                    } else {
                        wp_update_user(array(
                            'ID' => $this->getUserId(),
                            'user_pass' => esc_attr($newPassword)
                        ));
                    }
                }
            } else {
                $returnData['old_password'] = false;
                $returnData['saved'] = false;
            }
        }

        return $returnData;
    }

    public function saveCompanySettings($logoId, $userId = null)
    {

        $returnData = array();

        $validation = new \Purpozed2\Models\validation();

        $currentUserCompanyId = '';
        $companyId = 0;
        if (!is_null($userId)) {
            $currentUserCompanyId = $userId;
        } elseif (!is_admin() && is_null($userId)) {
            $currentUserCompanyId = get_user_meta(get_current_user_id(), 'company_id')[0];
        } else {
            $password = 'ffewf989we9wewe&**&';
            $c_id = $validation->company_id($_POST['company_id']);
            $companyExists = $validation->company_id_exists($_POST['company_id']);

            if (!$c_id) {
                $returnData['company_id'] = 1;
                return $returnData;
            }

            if ($companyExists) {
                $returnData['company_id_exists'] = 1;
                return $returnData;
            }

            if (empty($_POST['first_name']) || empty($_POST['email'])) {
                $returnData['name_and_email_requested'] = 1;
                return $returnData;
            }

            $newUserId = wp_create_user($_POST['first_name'], $password, $_POST['email']);
            if (is_int($newUserId)) {
                $currentUserCompanyId = $newUserId;
                $newUser = new \WP_User($currentUserCompanyId);
                $newUser->remove_role('subscriber');
                $newUser->add_role('company');
                update_user_meta($currentUserCompanyId, 'company_id', esc_html($_POST['company_id']));
                $companyId = $newUserId;
            } else {
                $returnData['user_exists'] = 1;
                return $returnData;
            }
        }

        if (!$companyId) {

            $users = get_users(array('fields' => array('ID')));

            foreach ($users as $user) {
                $userData = get_user_by('ID', $user->ID);
                if (in_array('company', $userData->roles)) {
                    $currentCompanyData = get_user_meta($user->ID);

                    if ($currentUserCompanyId === $currentCompanyData['company_id'][0]) {
                        $companyDetails = get_user_meta($user->ID);
                        $companyId = $user->ID;
                    }
                }
            }
            if (!$companyId) {
                $companyId = $_GET['id'];
            }
        }

        if (!empty($logoId)) {
            update_user_meta($companyId, 'logo', $logoId);
        }

        update_user_meta($companyId, 'first_name', esc_html($_POST['first_name']));
        update_user_meta($companyId, 'street', esc_html($_POST['street']));
        update_user_meta($companyId, 'zip', esc_html($_POST['zip']));
        update_user_meta($companyId, 'city', esc_html($_POST['city']));
        update_user_meta($companyId, 'website', esc_html($_POST['website']));
        update_user_meta($companyId, 'description', esc_html($_POST['description']));
        update_user_meta($companyId, 'phone', esc_html($_POST['phone']));
        update_user_meta($companyId, 'invited_users', esc_html($_POST['invited_users']));

        global $wpdb;

        $wpdb->delete('wp_purpozed_user_links',
            array(
                'user_id' => $currentUserCompanyId,
            ),
            array(
                '%d',
            )
        );

        if (isset($_POST['links'])) {

            $wpdb->delete('wp_purpozed_user_links',
                array(
                    'user_id' => $currentUserCompanyId,
                ),
                array(
                    '%d',
                )
            );
            foreach ($_POST['links'] as $linkKey => $linkValue) {
                $wpdb->insert('wp_purpozed_user_links',
                    array(
                        'user_id' => $currentUserCompanyId,
                        'url' => $linkValue['url'],
                        'name' => $linkValue['name']
                    ),
                    array(
                        '%d',
                        '%s',
                        '%s'
                    )
                );
            }
        }

        $returnData['saved'] = true;

        return $returnData;
    }

    public function getExperiences()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_user_experiences WHERE user_id = %d", $this->getUserId());
        return $wpdb->get_results($query);
    }

    public function deleteExperience()
    {
        global $wpdb;

        return $wpdb->delete('wp_purpozed_user_experiences',
            array('id'),
            array('%d')
        );
    }

    public function evaluateVolunteer($opportunityId, $text, $type, $hours)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunity->removeFromBookmarked($opportunityId, $this->getUserId());
        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();

        $textTable = '';
        $textTableDate = '';
        if ($type === 'volunteer') {
            $textTable = 'evaluation_volunteer';
            $textTableDate = 'evaluation_volunteer_date';
        } else {
            $textTable = 'evaluation_organization';
            $textTableDate = 'evaluation_organization_date';
        }

        $opportunityStatus = $opportunity->getStatus($opportunityId);

        if ($type === 'organization' && $opportunityStatus === 'canceled') {

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];
            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/info-volunteer-about-organization-comment-after-cancelation.php');
            $message = ob_get_contents();
            ob_clean();

            $getVolunteers = $opportunity->getVolunteersWhoCommented($opportunityId);
            foreach ($getVolunteers as $volunteer) {
                $to = get_userdata($volunteer->user_id)->data->user_email;
                $subject = 'Eine Organisation hat die Zusammenarbeit mit Dir kommentiert, die du zuvor abgebrochen hast';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                wp_mail($to, $subject, $message, $headers);
            }
        } elseif ($type === 'organization' && $opportunityStatus === 'succeeded') {
            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/info-volunteer-about-organization-comment-after-success.php');
            $message = ob_get_contents();
            ob_clean();

            $getVolunteers = $opportunity->getVolunteersWhoCommented($opportunityId);
            foreach ($getVolunteers as $volunteer) {
                $to = get_userdata($volunteer->user_id)->data->user_email;
                $subject = 'Eine Organisation hat die Zusammenarbeit mit Dir kommentiert, die du zuvor abgebrochen hast';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                wp_mail($to, $subject, $message, $headers);
            }
        }

        if ($type === 'organization' && !($opportunity->isEvaluated($opportunityId))) {

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];
            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/complete-opportunity-in-progress-by-organization.php');
            $message = ob_get_contents();
            ob_clean();

            $getVolunteers = $opportunity->getVolunteersWhoComplete($opportunityId);
            foreach ($getVolunteers as $volunteer) {
                $to = get_userdata($volunteer->user_id)->data->user_email;
                $subject = 'Gratuliere! Eine Organisation hat gerade eine Deiner Tätigkeiten als erfolgreich abgeschlossen markiert. Bitte schreibe einen Kommentar...';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                wp_mail($to, $subject, $message, $headers);
            }
        }

        if ($type === 'volunteer' && !($opportunity->isEvaluated($opportunityId))) {

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            $currentOpportunity = '';

            if ($type === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($type === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($type === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($type === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/volunteer-comments-opportunity-succeeded-by-him.php');
            $message = ob_get_contents();
            ob_clean();

            $organizationId = $opportunity->getOrganization($opportunityId);

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Ein Freiwilliger hat gerade eine Deiner Tätigkeiten als erfolgreich abgeschlossen markiert. Bitte schreibe einen Kommentar...';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);

        } elseif ($type === 'volunteer' && $opportunityStatus === 'succeeded') {

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            $currentOpportunity = '';

            if ($type === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($type === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($type === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($type === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/volunteer-comments-opportunity-succeeded-by-organization.php');
            $message = ob_get_contents();
            ob_clean();


            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Ein Freiwilliger hat eine Tätigkeiten kommentiert, die Du zuvor als erfolgreich abgeschlossen markiert hast';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        if ($opportunity->isEvaluated($opportunityId)) {
            return $wpdb->update('wp_purpozed_opportunities',
                array(
                    $textTable => $text,
                    $textTableDate => date('Y-m-d'),
                ),
                array(
                    'id' => $opportunityId
                ),
                array(
                    '%s',
                    '%s'
                )
            );
        } else {
            return $wpdb->update('wp_purpozed_opportunities',
                array(
                    'status' => 'succeeded',
                    $textTable => $text,
                    $textTableDate => date('Y-m-d'),
                ),
                array(
                    'id' => $opportunityId
                ),
                array(
                    '%s',
                    '%s'
                )
            );
        }
    }

    public function evaluateVolunteerEngagement($opportunityId, $text, $type, $userId, $hours)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunity->removeFromBookmarked($opportunityId, $this->getUserId());
        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();

        $textTable = '';
        $textTableDate = '';
        if ($type === 'volunteer') {
            $textTable = 'evaluation_volunteer';
            $textTableDate = 'evaluation_volunteer_date';
        } else {
            $textTable = 'evaluation_organization';
            $textTableDate = 'evaluation_organization_date';
        }

        $opportunityType = $opportunity->getType($opportunityId);

        $engagementData = $opportunity->getCompletedEngagementFully($opportunityId, $userId);
        $engagementCancelBy = $engagementData->canceled_by;

        if ($type === 'organization') {

            if (!($opportunity->isEvaluatedEngagement($opportunityId, $userId))) { // orga evaluate first...
                if ($_GET['c']) { // ..and cancel

                    $organizationId = $opportunity->getOrganization($opportunityId);
                    $organizationName = get_user_meta($organizationId, 'organization_name')[0];
                    $userName = get_user_meta($this->getUserId(), 'first_name')[0];

                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-organization.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = get_userdata($userId)->data->user_email;
                    $subject = 'Eine Organisation hat gerade die Zusammenarbeit mit Dir vorzeitig abgebrochen. Bitte schreibe einen Kommentar...';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    wp_mail($to, $subject, $message, $headers);

                } else { // ...and succeed

                    $organizationId = $opportunity->getOrganization($opportunityId);
                    $organizationName = get_user_meta($organizationId, 'organization_name')[0];
                    $userName = get_user_meta($this->getUserId(), 'first_name')[0];

                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/complete-opportunity-in-progress-by-organization.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = get_userdata($userId)->data->user_email;
                    $subject = 'Gratuliere! Eine Organisation hat gerade eine Deiner Tätigkeiten als erfolgreich abgeschlossen markiert. Bitte schreibe einen Kommentar...';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    wp_mail($to, $subject, $message, $headers);

                }
            } elseif (($opportunity->isEvaluatedEngagement($opportunityId, $userId))) { // orga evaluate 2nd

                if ($engagementCancelBy !== 'volunteer') { // ..succeeded

                    $organizationId = $opportunity->getOrganization($opportunityId);
                    $organizationName = get_user_meta($organizationId, 'organization_name')[0];
                    $userName = get_user_meta($userId, 'first_name')[0];

                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/info-volunteer-about-organization-comment-after-success.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = get_userdata($userId)->data->user_email;
                    $subject = 'Eine Organisation hat eine Deiner Tätigkeiten kommentiert, die du zuvor als erfolgreich abgeschlossen markiert hast';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    wp_mail($to, $subject, $message, $headers);

                } else { // ...canceled

                    $organizationId = $opportunity->getOrganization($opportunityId);
                    $organizationName = get_user_meta($organizationId, 'organization_name')[0];
                    $userName = get_user_meta($this->getUserId(), 'first_name')[0];
                    ob_start();
                    require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-volunteer-commented-by-organization.php');
                    $message = ob_get_contents();
                    ob_clean();

                    $to = get_userdata($userId)->data->user_email;
                    $subject = 'Eine Organisation hat die Zusammenarbeit mit Dir kommentiert, die du zuvor abgebrochen hast';
                    $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                    wp_mail($to, $subject, $message, $headers);

                }
            }
        }

        if ($type === 'volunteer' && !($opportunity->isEvaluatedEngagement($opportunityId, $userId))) {

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];
            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            $currentOpportunity = '';

            if ($opportunityType === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($opportunityType === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($opportunityType === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($opportunityType === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/volunteer-comments-opportunity-succeeded-by-him.php');
            $message = ob_get_contents();
            ob_clean();

            $organizationId = $opportunity->getOrganization($opportunityId);

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Ein Freiwilliger hat gerade eine Deiner Tätigkeiten als erfolgreich abgeschlossen markiert. Bitte schreibe einen Kommentar...';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);

        } elseif ($type === 'volunteer' && $opportunity->isEvaluatedEngagement($opportunityId, $userId)) {

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            $currentOpportunity = '';

            if ($opportunityType === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($opportunityType === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($opportunityType === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($opportunityType === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/volunteer-comments-opportunity-succeeded-by-organization.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Ein Freiwilliger hat eine Tätigkeiten kommentiert, die Du zuvor als erfolgreich abgeschlossen markiert hast';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        $singleOpportunity = new \Purpozed2\Models\Opportunity();
        $startTime = $singleOpportunity->getStartOportunityTime($opportunityId, $userId);
        $opportunity->removeFromInProgress($opportunityId, $userId);

        $isEvaluated = $opportunity->isEvaluatedEngagement($opportunityId, $userId);

        $date = date('Y-m-d');
        if ($isEvaluated) {
            return $wpdb->update('wp_purpozed_opportunities_engagement_evaluation',
                array(
                    $textTable => $text,
                    $textTableDate => $date
                ),
                array(
                    'user_id' => $userId,
                    'opportunity_id' => $opportunityId
                )
            );
        } else {
            return $wpdb->insert('wp_purpozed_opportunities_engagement_evaluation',
                array(
                    'user_id' => $userId,
                    'opportunity_id' => $opportunityId,
                    $textTable => $text,
                    $textTableDate => $date,
                    'canceled_by' => '',
                    'hours' => $hours,
                    'start_date' => $startTime,
                )
            );
        }
    }

    public function remindOrganizationAboutEvaluation($opportunityId)
    {
        //todo wysłać email
        return true;
    }

    public function cancelOpportunity($opportunityId, $text, $canceledBy)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
        $opportunity->removeFromBookmarked($opportunityId, $this->getUserId());
        $type = $opportunity->getType($opportunityId);

        $opportunity->setStatusChangeDate($opportunityId);

        $textTable = '';
        $textTableDate = '';
        if ($canceledBy === 'volunteer') {
            $textTable = 'evaluation_volunteer';
            $textTableDate = 'evaluation_volunteer_date';
        } else {
            $textTable = 'evaluation_organization';
            $textTableDate = 'evaluation_organization_date';
        }

        if ($canceledBy === 'organization') {

            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-organization.php');
            $message = ob_get_contents();
            ob_clean();

            $getVolunteers = $opportunity->getInProgress($opportunityId);
            foreach ($getVolunteers as $volunteer) {
                $to = get_userdata($volunteer->user_id)->data->user_email;
                $subject = 'Ein Freiwilliger hat eine Tätigkeiten kommentiert, die Du zuvor abgebrochen hast';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                wp_mail($to, $subject, $message, $headers);
            }
        }
        if ($canceledBy === 'volunteer') {

            $opportunityStatus = $opportunity->getStatus($opportunityId);

            $currentOpportunity = '';

            if ($type === 'call') {
                $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
            } elseif ($type === 'project') {
                $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
            } elseif ($type === 'mentoring') {
                $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
            } elseif ($type === 'engagement') {
                $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
            }

            if ($opportunityStatus === 'canceled') {
                ob_start();
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-organization-commented-by-volunteer.php');
                $message = ob_get_contents();
                ob_clean();

                $organizationId = $opportunity->getOrganization($opportunityId);

                $to = get_userdata($organizationId)->data->user_email;
                $subject = 'Ein Freiwilliger hat eine Tätigkeiten kommentiert, die Du zuvor abgebrochen hast';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                wp_mail($to, $subject, $message, $headers);
            } else {
                ob_start();
                require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-volunteer.php');
                $message = ob_get_contents();
                ob_clean();

                $organizationId = $opportunity->getOrganization($opportunityId);

                $to = get_userdata($organizationId)->data->user_email;
                $subject = 'Ein Freiwilliger hat gerade eine Deiner Tätigkeiten vorzeitig abgebrochen. Bitte schreibe einen Kommentar...';
                $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

                wp_mail($to, $subject, $message, $headers);
            }
        }

        $opportunity->removeFromInProgress($opportunityId, $this->getUserId());

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                'status' => 'canceled',
                $textTable => $text,
                $textTableDate => date('Y-m-d'),
                'canceled_by' => $canceledBy
            ),
            array(
                'id' => $opportunityId
            ),
            array(
                '%s',
                '%s'
            )
        );
    }

    public function cancelOpportunityEngagement($opportunityId, $text, $canceledBy, $userId)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();
        $opportunity->removeFromBookmarked($opportunityId, $this->getUserId());
        $type = $opportunity->getType($opportunityId);

        $opportunity->setStatusChangeDate($opportunityId);

        $textTable = '';
        $textTableDate = '';
        if ($canceledBy === 'volunteer') {
            $textTable = 'evaluation_volunteer';
            $textTableDate = 'evaluation_volunteer_date';
        } else {
            $textTable = 'evaluation_organization';
            $textTableDate = 'evaluation_organization_date';
        }

        $currentOpportunity = '';

        if ($type === 'call') {
            $currentOpportunity = $opportunityManager->getSingleCall($opportunityId);
        } elseif ($type === 'project') {
            $currentOpportunity = $opportunityManager->getSingleProject($opportunityId);
        } elseif ($type === 'mentoring') {
            $currentOpportunity = $opportunityManager->getSingleMentoring($opportunityId);
        } elseif ($type === 'engagement') {
            $currentOpportunity = $opportunityManager->getSingleEngagement($opportunityId);
        }

        $isEvaluated = $opportunity->isEvaluatedEngagement($opportunityId, $userId);


        if ($canceledBy === 'organization' && !$isEvaluated) {

            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-organization.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($userId)->data->user_email;
            $subject = 'Eine Organisation hat gerade die Zusammenarbeit mit Dir vorzeitig abgebrochen. Bitte schreibe einen Kommentar...';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);

        } else {

            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            $organizationId = $opportunity->getOrganization($opportunityId);
            $organizationName = get_user_meta($organizationId, 'organization_name')[0];

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/info-volunteer-about-organization-comment-after-cancelation.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($userId)->data->user_email;
            $subject = 'Eine Organisation hat die Zusammenarbeit mit Dir kommentiert, die du zuvor abgebrochen hast';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        if ($canceledBy === 'volunteer' && $isEvaluated) {

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-organization-commented-by-volunteer.php');
            $message = ob_get_contents();
            ob_clean();

            $organizationId = $opportunity->getOrganization($opportunityId);
            $userName = get_user_meta($this->getUserId(), 'first_name')[0];

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Ein Freiwilliger hat eine Tätigkeiten kommentiert, die Du zuvor abgebrochen hast';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);

        } else {

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/canceled-by-volunteer.php');
            $message = ob_get_contents();
            ob_clean();

            $organizationId = $opportunity->getOrganization($opportunityId);

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Ein Freiwilliger hat gerade eine Deiner Tätigkeiten vorzeitig abgebrochen. Bitte schreibe einen Kommentar...';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }

        $singleOpportunity = new \Purpozed2\Models\Opportunity();
        $startTime = $singleOpportunity->getStartOportunityTime($opportunityId, $userId);
        $opportunity->removeFromInProgress($opportunityId, $userId);

        if ($isEvaluated) {

            return $wpdb->update('wp_purpozed_opportunities_engagement_evaluation',
                array(
                    $textTable => $text,
                    $textTableDate => date('Y-m-d'),
                ),
                array(
                    'user_id' => $userId,
                    'opportunity_id' => $opportunityId,
                )
            );
        } else {
            return $wpdb->insert('wp_purpozed_opportunities_engagement_evaluation',
                array(
                    'user_id' => $userId,
                    'opportunity_id' => $opportunityId,
                    $textTable => $text,
                    $textTableDate => date('Y-m-d'),
                    'canceled_by' => $canceledBy,
                    'hours' => '0',
                    'start_date' => $startTime,
                )
            );
        }
    }

    public function commentCanceledOpportunity($opportunityId, $text, $canceledBy)
    {
        global $wpdb;

        $opportunity = new \Purpozed2\Models\Opportunity();
        $opportunity->removeFromBookmarked($opportunityId, $this->getUserId());

        $textTable = '';
        if ($canceledBy === 'volunteer') {
            $textTable = 'evaluation_volunteer';
        } else {
            $textTable = 'evaluation_organization';
        }

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                $textTable => $text,
            ),
            array(
                'id' => $opportunityId
            ),
            array(
                '%s',
                '%s'
            )
        );
    }

    public function evaluateOrganization($opportunityId, $text)
    {
        global $wpdb;

        return $wpdb->update('wp_purpozed_opportunities',
            array(
                'status' => 'succeeded',
                'evaluation_organization' => $text
            ),
            array(
                'id' => $opportunityId
            ),
            array(
                '%s',
                '%s'
            )
        );
    }

    public function hasAppliedNumber()
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_applied WHERE user_id = '%d'", $this->getUserId());

        return $wpdb->get_var($query);
    }

    public function currentOpportunities()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_in_progress WHERE user_id = '%d'", $this->getUserId());

        return $wpdb->get_var($query);
    }

    public function succeededOpportunities()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_volunteer_completed WHERE user_id = '%d'", $this->getUserId());

        return $wpdb->get_var($query);
    }

    public function hoursHelped()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT opportunity_id as id FROM wp_purpozed_volunteer_completed WHERE user_id = '%d'", $this->getUserId());

        $opportunities = $wpdb->get_results($query);

        $hoursHelped = 0;
        $singleOpportunity = new \Purpozed2\Models\Opportunity();

        foreach ($opportunities as $opportunity) {
            $opportunityType = $singleOpportunity->getType($opportunity->id);
            if ($opportunityType === 'call') {
                $hoursHelped += 1;
            } elseif ($opportunityType === 'project') {
                $query = $wpdb->prepare("SELECT wppt.hours_duration as hours
                    FROM wp_purpozed_opportunities_project wpop
                    JOIN wp_purpozed_opportunities wpo 
                    ON wpo.id = wpop.task_id
                    LEFT JOIN wp_purpozed_project_tasks wppt 
                    ON wpop.topic = wppt.id
                    WHERE wpop.task_id = '%d'", $opportunity->id);

                $hoursHelped += $wpdb->get_var($query);
            } elseif ($opportunityType === 'mentoring') {
                $query = $wpdb->prepare("SELECT (wpom.frequency * wpom.duration * wpom.time_frame) as hours
                    FROM wp_purpozed_opportunities_mentoring wpom 
                    JOIN wp_purpozed_opportunities wpo 
                    ON wpo.id = wpom.task_id
                    WHERE wpom.task_id = '%d'", $opportunity->id);

                $hoursHelped += $wpdb->get_var($query);
            } elseif ($opportunityType === 'engagement') {
                $query = $wpdb->prepare("SELECT (wpoe.frequency * wpoe.duration * wpoe.time_frame) as hours
                    FROM wp_purpozed_opportunities_engagement wpoe 
                    JOIN wp_purpozed_opportunities wpo 
                    ON wpo.id = wpoe.task_id
                    WHERE wpoe.task_id = '%d'", $opportunity->id);

                $hoursHelped += $wpdb->get_var($query);
            }
        }
        return $hoursHelped;
    }

    public function getRegisterDate()
    {

        $userData = get_userdata($this->getUserId());
        return $userData->user_registered;

    }

    public function removeFromAllApplied()
    {
        global $wpdb;

        return $wpdb->delete('wp_purpozed_volunteer_applied',
            array(
                'user_id' => $this->getUserId()
            )
        );
    }

    public function removeAllFromReqested()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT opportunity_id FROM wp_purpozed_volunteer_request WHERE user_id = '%d'", $this->getUserId());
        $allRequestedOpportunities = $wpdb->get_col($query);

        $opportunity = new \Purpozed2\Models\Opportunity();

        foreach ($allRequestedOpportunities as $key => $requestedOpportunityId) {

            $organizationId = $opportunity->getOrganization($requestedOpportunityId);

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/inform_organization_that_volunteer_deleted_account_requested.php');
            $message = ob_get_contents();
            ob_clean();

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Ein Freiwilliger hat eine Tätigkeiten kommentiert, die Du zuvor abgebrochen hast';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);
        }


//        return $wpdb->delete('wp_purpozed_volunteer_request',
//            array(
//                'user_id' => $this->getUserId()
//            )
//        );
    }

    public function removeAllFromInProgress()
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT opportunity_id FROM wp_purpozed_volunteer_in_progress WHERE user_id = '%d'", $this->getUserId());
        $allInProgressOpportunities = $wpdb->get_col($query);

        $opportunity = new \Purpozed2\Models\Opportunity();

        foreach ($allInProgressOpportunities as $key => $inProgressOpportunityId) {

            $opportunity->removeFromBookmarked($inProgressOpportunityId, $this->getUserId());

            ob_start();
            require($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/purpozed2/views/emails/inform_organization_that_volunteer_deleted_account_in_progress.php');
            $message = ob_get_contents();
            ob_clean();

            $organizationId = $opportunity->getOrganization($inProgressOpportunityId);

            $to = get_userdata($organizationId)->data->user_email;
            $subject = 'Purpozed notification';
            $headers = array("Content-Type: text/html; charset=UTF-8", "From: Purpozed <support@purpozed.org>\n");

            wp_mail($to, $subject, $message, $headers);

            $wpdb->update('wp_purpozed_opportunities',
                array(
                    'status' => 'canceled',
                    'evaluation_volunteer' => 'Volunteer deleted account',
                    'canceled_by' => 'volunteer'
                ),
                array(
                    'id' => $inProgressOpportunityId
                ),
                array(
                    '%s',
                    '%s'
                )
            );
        }
    }

    public function commentUncommentedCompletedOpportunitiesOnDelete()
    {
        $opportunityManager = new \Purpozed2\Models\OpportunitiesManager();

        $completedOpportunities = $opportunityManager->getCompleted(get_current_user_id());

        global $wpdb;

        foreach ($completedOpportunities as $completedOpportunity) {
            if (empty($completedOpportunity->evaluation_volunteer) || is_null($completedOpportunity->evaluation_volunteer)) {
                $wpdb->update('wp_purpozed_opportunities',
                    array(
                        'evaluation_volunteer' => 'Volunteer deleted account'
                    ),
                    array(
                        'id' => $completedOpportunity->id
                    )
                );
            }
        }
    }

    public function deleteAccount()
    {
        $this->removeFromAllApplied();
        $this->removeAllFromReqested();
        $this->removeAllFromInProgress();
        $this->commentUncommentedCompletedOpportunitiesOnDelete();

        $user = new \WP_User($this->getUserId());
        $user->remove_role('volunteer');
        $user->add_role('deactivated');
        wp_logout();
    }

    public function finishedVolunteersWithNoCommentYet()
    {
        global $wpdb;

        $allExceptEngagements = $wpdb->prepare("SELECT *
                                        FROM wp_purpozed_volunteer_completed wpvc
                                        LEFT JOIN wp_purpozed_opportunities wpo 
                                        ON wpvc.opportunity_id = wpo.id  
                                        WHERE wpvc.user_id = %d AND wpo.task_type != 'engagement' AND wpo.evaluation_volunteer is null", $this->getUserId());

        $engagements = $wpdb->prepare("SELECT *
                                        FROM wp_purpozed_opportunities_engagement_evaluation wpoee
                                        WHERE wpoee.user_id = %d AND wpoee.evaluation_volunteer is null", $this->getUserId());


        $allExceptEngagementsArray = $wpdb->get_results($allExceptEngagements);
        $engagementsArray = $wpdb->get_results($engagements);

        $total = count($engagementsArray) + count($allExceptEngagementsArray);

        return $total;
    }

    public function saveUserLogin()
    {
        global $wpdb;

        $wpdb->insert('wp_purpozed_logins',
            array(
                'login_date' => date('Y-m-d'),
                'user_id' => $this->getUserId()
            ),
            array(
                '%s',
                '%d'
            )
        );
    }

}