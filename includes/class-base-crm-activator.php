<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/kalamalahala
 * @since      0.0.1
 *
 * @package    BaseCRM
 * @subpackage BaseCRM/includes
 */

// namespace BaseCRM;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @package    BaseCRM
 * @subpackage BaseCRM/includes
 * @author     Tyler Karle <tyler.karle@icloud.com>
 */
class BaseCRM_Activator {

	/**
	 * Activate the plugin.
	 *
	 * Creates / updates the plugin's database tables, and creates the plugin pages.
	 *
	 * @since    0.0.1
	 */
	public static function activate() {

		if (defined('ABSPATH') && defined('WPINC')) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		
		$leads_table = BaseCRM_LEADS_TABLE;
		$leads_meta_table = BaseCRM_LEADS_META_TABLE;
		$logs_table = BaseCRM_LOGS_TABLE;
		$appointments_table = BaseCRM_APPOINTMENTS_TABLE;
		$presentations_table = BaseCRM_PRESENTATIONS_TABLE;

		if (!BaseCRM::table_exists($leads_table)) {
			$leads_table_sql = "CREATE TABLE $leads_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				assigned_to mediumint(9) DEFAULT 0 NOT NULL,
				assigned_by mediumint(9) DEFAULT 0 NOT NULL,
				assigned_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				lead_status varchar(255) DEFAULT 'new' NOT NULL,
				lead_disposition varchar(255) DEFAULT 'new' NOT NULL,
				lead_type varchar(255) DEFAULT 'lead' NOT NULL,
				lead_source varchar(255) DEFAULT 'website' NOT NULL,
				lead_relationship varchar(255) DEFAULT 'self' NOT NULL,
				lead_referred_by varchar(255) DEFAULT '' NOT NULL,
				first_name varchar(255) DEFAULT '' NOT NULL,
				last_name varchar(255) DEFAULT '' NOT NULL,
				email varchar(255) DEFAULT '' NOT NULL,
				phone varchar(255) DEFAULT '' NOT NULL,
				is_married tinyint(1) DEFAULT 0 NOT NULL,
				is_employed tinyint(1) DEFAULT 0 NOT NULL,
				has_children tinyint(1) DEFAULT 0 NOT NULL,
				num_children mediumint(9) DEFAULT 0 NOT NULL,
				has_bank_account tinyint(1) DEFAULT 0 NOT NULL,
				bank_account_type varchar(255) DEFAULT '' NOT NULL,
				bank_name varchar(255) DEFAULT '' NOT NULL,
				bank_routing_number varchar(255) DEFAULT '' NOT NULL,
				bank_account_number varchar(255) DEFAULT '' NOT NULL,
				spouse_first_name varchar(255) DEFAULT '' NOT NULL,
				spouse_last_name varchar(255) DEFAULT '' NOT NULL,
				date_last_contacted datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				date_last_appointment datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				date_last_followup datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				date_last_disposition datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				date_last_sale datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				number_of_referrals_to_date mediumint(9) DEFAULT 0 NOT NULL,
				is_policyholder tinyint(1) DEFAULT 0 NOT NULL,
				is_spouse_policyholder tinyint(1) DEFAULT 0 NOT NULL,
				is_client tinyint(1) DEFAULT 0 NOT NULL,
				PRIMARY KEY (id)
				) $charset_collate;";

			dbDelta($leads_table_sql);
		}

		if (!BaseCRM::table_exists($leads_meta_table)) {
			$leads_meta_table_sql = "CREATE TABLE $leads_meta_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				lead_id mediumint(9) DEFAULT 0 NOT NULL,
				created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				meta_key varchar(255) DEFAULT '' NOT NULL,
				meta_value longtext DEFAULT '' NOT NULL,
				PRIMARY KEY (id)
				) $charset_collate;";

			dbDelta($leads_meta_table_sql);
		}

		if (!BaseCRM::table_exists($logs_table)) {
			$logs_table_sql = "CREATE TABLE $logs_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				lead_id mediumint(9) DEFAULT NULL,
				appointment_id mediumint(9) DEFAULT NULL,
				user_id mediumint(9) DEFAULT NULL,
				log_type varchar(255) DEFAULT '' NOT NULL,
				log_message longtext DEFAULT '' NOT NULL,
				PRIMARY KEY (id)
				) $charset_collate;";

			dbDelta($logs_table_sql);
		}

		if (!BaseCRM::table_exists($appointments_table)) {
			$appointments_table_sql = "CREATE TABLE $appointments_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				lead_id mediumint(9) DEFAULT NULL,
				agent_id mediumint(9) DEFAULT NULL,
				appointment_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				appointment_time varchar(255) DEFAULT '' NOT NULL,
				appointment_status varchar(255) DEFAULT 'new' NOT NULL,
				appointment_type varchar(255) DEFAULT 'appointment' NOT NULL,
				appointment_location varchar(255) DEFAULT '' NOT NULL,
				appointment_notes longtext DEFAULT '' NOT NULL,
				PRIMARY KEY (id)
				) $charset_collate;";

			dbDelta($appointments_table_sql);
		}

		if (!BaseCRM::table_exists($presentations_table)) {
			$presentations_table_sql = "CREATE TABLE $presentations_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				lead_id mediumint(9) DEFAULT NULL,
				agent_id mediumint(9) DEFAULT NULL,
				form_submission longtext DEFAULT '' NOT NULL,
				PRIMARY KEY (id)
				) $charset_collate;";

			dbDelta($presentations_table_sql);
		}

		/**
		 * Pages
		 * 
		 * /base - BaseCRM
		 * /base/leads - Leads
		 * /base/appointments - Appointments
		 * /base/logs - Logs
		 * /base/settings - Settings
		 * 
		 * Store page IDs in options table
		 */
		$base_page_id = wp_insert_post([
			'post_title' => 'BaseCRM',
			'post_name' => 'base',
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content' => '[basecrm]',
			'post_author' => 1
		]);

		$leads_page_id = wp_insert_post([
			'post_title' => 'Leads',
			'post_name' => 'leads',
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content' => '[basecrm_leads]',
			'post_author' => 1,
			'post_parent' => $base_page_id
		]);

		$appointments_page_id = wp_insert_post([
			'post_title' => 'Appointments',
			'post_name' => 'appointments',
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content' => '[basecrm_appointments]',
			'post_author' => 1,
			'post_parent' => $base_page_id
		]);

		$logs_page_id = wp_insert_post([
			'post_title' => 'Logs',
			'post_name' => 'logs',
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content' => '[basecrm_logs]',
			'post_author' => 1,
			'post_parent' => $base_page_id
		]);

		$settings_page_id = wp_insert_post([
			'post_title' => 'Settings',
			'post_name' => 'settings',
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_content' => '[basecrm_settings]',
			'post_author' => 1,
			'post_parent' => $base_page_id
		]);

        $clients_page_id = wp_insert_post([
            'post_title' => 'Clients',
            'post_name' => 'clients',
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_content' => '[basecrm_clients]',
            'post_author' => 1,
            'post_parent' => $base_page_id
        ]);

		// Store page IDs in options table
		update_option('basecrm_page_id', $base_page_id);
		update_option('basecrm_leads_page_id', $leads_page_id);
		update_option('basecrm_appointments_page_id', $appointments_page_id);
		update_option('basecrm_logs_page_id', $logs_page_id);
		update_option('basecrm_settings_page_id', $settings_page_id);
        update_option('basecrm_clients_page_id', $clients_page_id);

	}

}
