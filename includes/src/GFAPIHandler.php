<?php

	namespace BaseCRM\ServerSide;

	use GFAPI;

	class GFAPIHandler {

		public string $rest_url;
		public int $form_id;
		public int $field_id;

		public function __construct( int $form_id = 0 ) {
			if ( ! $form_id ) {
				$this->form_id = 114; // gravity forms id 114 on The Johnson Group
			}

			$this->rest_url = get_rest_url( null, 'base-crm/v1' );
			$this->field_id = 18; // gravity forms field id 18 on The Johnson Group form 114
		}

		public function getMatchingEntries( int $base_crm_lead_id ): array|bool {
			if (!$base_crm_lead_id) return false;

			$entries = GFAPI::get_entries( $this->form_id, [
				'search_criteria' => [
					'field_filters' => [
						[
							'key' => $this->field_id,
							'value' => $base_crm_lead_id,
						],
					],
				],
			] );

			$lead = new Lead($base_crm_lead_id);

			$results = [
				'entries' => $entries,
				'lead' => $lead,
			];

			return ($results) ?: false;
		}

	}