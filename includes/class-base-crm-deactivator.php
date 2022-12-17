<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/kalamalahala
 * @since      0.0.1
 *
 * @package    BaseCRM
 * @subpackage BaseCRM/includes
 */

// namespace BaseCRM;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.0.1
 * @package    BaseCRM
 * @subpackage BaseCRM/includes
 * @author     Tyler Karle <tyler.karle@icloud.com>
 */
class BaseCRM_Deactivator {

	/**
	 * Deactivate the plugin.
	 *
	 * Remove all the plugin pages from the site's options table.
	 *
	 * @since    0.0.1
	 */
	public static function deactivate() {

		// Trash plugin pages created in the Activator method
		$page_ids = [
			'basecrm_page_id',
			'basecrm_leads_page_id',
			'basecrm_appointments_page_id',
			'basecrm_logs_page_id',
			'basecrm_settings_page_id',
		];

		foreach ($page_ids as $page_id) {
			$page = get_post(get_option($page_id));
			if ($page) {
				wp_trash_post($page->ID);
			}
		}

	}

}
