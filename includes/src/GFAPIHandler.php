<?php

namespace BaseCRM\ServerSide;

use GFAPI;

class GFAPIHandler
{

    public string $rest_url;
    public int $form_id;
    public int $field_id;

    public function __construct(int $form_id = 0)
    {
        if (!$form_id) {
            $this->form_id = 114; // gravity forms id 114 on The Johnson Group
        }

        $this->rest_url = get_rest_url(null, 'base-crm/v1');
        $this->field_id = 18; // gravity forms field id 18 on The Johnson Group form 114
    }

    public function getMatchingEntries(int $base_crm_lead_id): array|bool
    {
        if (!$base_crm_lead_id) return false;

        // /wp-json/gf/v2/entries?form_ids[0]=$this->form_id&_labels=1&search={"field_filters": [{"key": $this->field_id, "value": $base_crm_lead_id}]}

        $url = get_rest_url(null, 'gf/v2') . '/entries?form_ids[0]=' . $this->form_id . '&_labels=1&search={"field_filters": [{"key": ' . $this->field_id . ', "value": ' . $base_crm_lead_id . '}]}';

        $entries = wp_remote_get($url);

        $lead = new Lead($base_crm_lead_id);

        $results = [
            'entries' => $entries,
            'lead' => $lead,
            'url' => $url,
        ];

        return ($results) ?: false;
    }

}