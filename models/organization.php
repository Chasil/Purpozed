<?php

namespace Purpozed2\Models;

class Organization
{

    public function getDetails()
    {
        return get_user_meta(get_current_user_id());
    }

    public function getDetailsById($organizationId)
    {
        return get_user_meta($organizationId);
    }

    public function getCompanyId()
    {
        return get_user_meta(get_current_user_id(), 'company_id')[0];
    }

    public function getName($id = null)
    {
        if (is_null($id)) {
            $id = get_current_user_id();
        }
        return get_user_meta($id, 'organization_name')[0];
    }

    public function getApllied($organizationId)
    {

        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_opportunities wpo
                                        LEFT JOIN wp_purpozed_volunteer_applied wpva
                                        ON wpva.opportunity_id = wpo.id
                                        WHERE wpo.organization_id = %d", $organizationId);

        return $wpdb->get_results($query);
    }

    public function totalAppliedVolunteers($organizationId = null)
    {
        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }

        global $wpdb;

        $query = $wpdb->prepare("SELECT *
                                        FROM wp_purpozed_volunteer_applied wpva
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpva.opportunity_id
                                        WHERE organization_id = %d AND removed = 0 AND rejected = 0 AND status = 'open'", $organizationId);
        return $wpdb->get_results($query);
    }

    public function succeededVolunteers($organizationId = null)
    {
        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }

        global $wpdb;

        $allExceptEngagements = $wpdb->prepare("SELECT *
                                        FROM wp_purpozed_opportunities 
                                        WHERE organization_id = %d AND status IN ('succeeded', 'retracted', 'canceled') AND evaluation_volunteer is not null AND evaluation_organization is null", $organizationId);

        $engagements = $wpdb->prepare("SELECT *
                                        FROM wp_purpozed_opportunities_engagement_evaluation wpoee
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpoee.opportunity_id
                                        WHERE wpo.organization_id = %d AND wpo.task_type = 'engagement' AND wpo.status IN ('open', 'retracted') AND wpoee.evaluation_volunteer is not null AND wpoee.evaluation_organization is null", $organizationId);


        $allExceptEngagementsArray = $wpdb->get_results($allExceptEngagements);
        $engagementsArray = $wpdb->get_results($engagements);

        $total = count($engagementsArray) + count($allExceptEngagementsArray);

        return $total;
    }

    public function countVolunteersWhoWaitForComment($organizationId = null)
    {

        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }

        global $wpdb;
        $opportunities = $wpdb->prepare("SELECT *
                                        FROM wp_purpozed_opportunities wpo
                                        WHERE wpo.organization_id = %d AND wpo.task_type != 'engagement' AND wpo.status IN ('succeeded', 'canceled', 'retracted') AND wpo.evaluation_volunteer is not null AND wpo.evaluation_organization is null", $organizationId);

        $engagementsArray = $wpdb->get_results($opportunities);

        $total = count($engagementsArray);

        return $total;
    }

    public function countVolunteersWhoWaitForEngagementComment($organizationId = null)
    {

        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }

        global $wpdb;
        $engagements = $wpdb->prepare("SELECT *
                                        FROM wp_purpozed_opportunities_engagement_evaluation wpoee
                                        LEFT JOIN wp_purpozed_opportunities wpo
                                        ON wpo.id = wpoee.opportunity_id
                                        WHERE wpo.organization_id = %d AND wpoee.evaluation_volunteer is not null AND wpoee.evaluation_organization is null", $organizationId);

        $engagementsArray = $wpdb->get_results($engagements);

        $total = count($engagementsArray);

        return $total;
    }

    public function succeededOpportunities($organizationId = null)
    {
        global $wpdb;

        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_opportunities WHERE status = '%s' AND organization_id = '%d'", 'succeeded', $organizationId);

        return $wpdb->get_var($query);
    }

    public function openOpportunities($organizationId = null)
    {
        global $wpdb;

        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_opportunities WHERE status = '%s' AND organization_id = '%d'", 'open', $organizationId);

        return $wpdb->get_var($query);
    }

    public function succeededOpportunitiesById($organizationId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_opportunities WHERE status = '%s' AND organization_id = '%d'", 'succeeded', $organizationId);

        return $wpdb->get_var($query);
    }

    public function openOpportunitiesById($organizationId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM wp_purpozed_opportunities WHERE organization_id = '%d'  AND status = '%s'", $organizationId, 'open');

        return $wpdb->get_var($query);
    }

    public function getMainGoal($goalId)
    {
        global $wpdb;

        $query = $wpdb->prepare("SELECT id, name, image_id FROM wp_purpozed_goals WHERE id = '%d'", $goalId);

        return $wpdb->get_row($query);
    }

    public function getGoals($organizationId = null)
    {
        global $wpdb;

        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }

        $query = $wpdb->prepare("SELECT wpg.id, wpg.name, wpg.image_id FROM wp_purpozed_organization_goals wpog
                                        LEFT JOIN wp_purpozed_goals wpg
                                        ON wpg.id = wpog.goal_id
                                        WHERE wpog.organization_id = '%d'", $organizationId);

        return $wpdb->get_results($query);
    }

    public function getLinks($organizationId = null)
    {
        if ($organizationId === null) {
            $organizationId = get_current_user_id();
        }
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM wp_purpozed_user_links WHERE user_id = '%d'", $organizationId);

        return $wpdb->get_results($query);
    }
}