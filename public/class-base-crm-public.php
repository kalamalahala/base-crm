<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/kalamalahala
 * @since      0.0.1
 *
 * @package    BaseCRM
 * @subpackage BaseCRM/public
 */

// namespace BaseCRM;
use BaseCRM\ServerSide\Lead;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    BaseCRM
 * @subpackage BaseCRM/public
 * @author     Tyler Karle <tyler.karle@icloud.com>
 */
class BaseCRM_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in BaseCRM_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BaseCRM_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if (!is_page(BaseCRM::plugin_page_ids())) {
			return;
		}

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/base-crm-public.css', array(), $this->version, 'all');
		add_action( 'wp_print_styles', function () {
			wp_dequeue_style( 'fusion-dynamic-css' );
			wp_deregister_style( 'fusion-dynamic-css' );
		} );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts()
	{

		if (!is_page(BaseCRM::plugin_page_ids())) {
			return;
		}

		$scripts = new Lead();
		$scripts = $scripts->lead_types();
		$is_admin = current_user_can('administrator');
		
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/base-crm-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script('basecrm-dist', BaseCRM_PLUGIN_URL . 'dist/main.js', array('jquery'), $this->version, true);

		wp_localize_script(
			$this->plugin_name,
			'base_crm',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'ajax_action' => 'base_crm_ajax',
				'ajax_nonce' => wp_create_nonce('base_crm_ajax_nonce'),
				'current_page' => $_SERVER['REQUEST_URI'],
				'script_list' => $scripts,
				'is_admin' => $is_admin,
				'user_names' => $this->get_user_names(),
                'current_user_id' => get_current_user_id(),
				'site_url' => get_site_url(),
                'username' => wp_get_current_user()->user_login,
                'password' => wp_get_current_user()->user_pass,
			)
		);

		add_action( 'wp_print_scripts', function () {
			$conflicting_scripts = [
				'fusion-scripts',
			];

			// deploy this repo

			foreach ( $conflicting_scripts as $script ) {
				wp_dequeue_script( $script );
				wp_deregister_script( $script );
			}
		} );
	}

	public function template_include($template)
	{
		$page_ids = BaseCRM::plugin_page_ids();

		if (is_page($page_ids)) {
			switch ($template) {
				case is_page($page_ids['basecrm']):
					$template = BaseCRM_PLUGIN_PATH . 'includes/templates/base-crm-template.php';
					break;
				case is_page($page_ids['basecrm_leads']):
					$template = BaseCRM_PLUGIN_PATH . 'includes/templates/base-crm-leads-template.php';
					break;
				case is_page($page_ids['basecrm_appointments']):
					$template = BaseCRM_PLUGIN_PATH . 'includes/templates/base-crm-appointments-template.php';
					break;
				case is_page($page_ids['basecrm_logs']):
					$template = BaseCRM_PLUGIN_PATH . 'includes/templates/base-crm-logs-template.php';
					break;
				case is_page($page_ids['basecrm_settings']):
					$template = BaseCRM_PLUGIN_PATH . 'includes/templates/base-crm-settings-template.php';
					break;
                case is_page($page_ids['basecrm_clients']):
                    $template = BaseCRM_PLUGIN_PATH . 'includes/templates/base-crm-clients-template.php';
                    break;
				default:
					return $template;
			}
		}

		return $template;
	}

	public function remove_admin_bar()
	{
		$page_ids = BaseCRM::plugin_page_ids();
		$is_page = is_page($page_ids);

		if ($is_page) {
			show_admin_bar(false);
		} else {
			show_admin_bar(true);
		}
	}

	public function get_user_names() {
		$filter = ''; // get_option('basecrm_user_filter') todo: add filter option
		
		$users = get_users();
		$user_names = array();
		foreach ($users as $user) {
			if (isset($user->first_name) && isset($user->last_name)) {
				$user_names[$user->ID] = $user->first_name . ' ' . $user->last_name;
			} else {
				$user_names[$user->ID] = $user->display_name;
			}
		}

		return $user_names;
	}
}
