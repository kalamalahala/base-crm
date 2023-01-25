<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/kalamalahala
 * @since      0.0.1
 *
 * @package    BaseCRM
 * @subpackage BaseCRM/includes
 */

 
use BaseCRM\ServerSide\Lead;
use BaseCRM\ServerSide\BaseCRM_Shortcodes;
use BaseCRM\Ajax\AjaxHandler;
use BaseCRM\Rest\RestHandler;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.0.1
 * @package    BaseCRM
 * @subpackage BaseCRM/includes
 * @author     Tyler Karle <tyler.karle@icloud.com>
 */

class BaseCRM {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      BaseCRM_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	protected $shortcodes;
	protected $ajax;
	protected $rest;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function __construct() {
		if ( defined( 'BaseCRM_VERSION' ) ) {
			$this->version = BaseCRM_VERSION;
		} else {
			$this->version = '0.0.1';
		}
		$this->plugin_name = 'BaseCRM';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - BaseCRM_Loader. Orchestrates the hooks of the plugin.
	 * - BaseCRM_i18n. Defines internationalization functionality.
	 * - BaseCRM_Admin. Defines all hooks for the admin area.
	 * - BaseCRM_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-base-crm-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-base-crm-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-base-crm-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-base-crm-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/src/ServerSide.php';

		$this->loader = new BaseCRM_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the BaseCRM_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new BaseCRM_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new BaseCRM_Admin( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->ajax = new AjaxHandler();
		$this->rest = new RestHandler();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new BaseCRM_Public( $this->get_plugin_name(), $this->get_version() );
		$this->shortcodes = new BaseCRM_Shortcodes();
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'template_include', $plugin_public, 'template_include' );
		$this->loader->add_filter( 'show_admin_bar', $plugin_public, 'remove_admin_bar' );
		
		$this->ajax = new AjaxHandler();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.0.1
	 * @return    BaseCRM_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Returns a boolean value indicating whether the table exists or not.
	 *
	 * @param string $table_name
	 * @return boolean
	 */
	public static function table_exists(string $table_name): bool
	{
		global $wpdb;
		$table_name = $wpdb->prefix . $table_name;
		return $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
	}

	/**
	 * Returns an array of page ids created upon plugin activation.
	 *
	 * @return array
	 */
	public static function plugin_page_ids(): array
	{
		$basecrm_page = get_option('basecrm_page_id');
		$basecrm_leads_page = get_option('basecrm_leads_page_id');
		$basecrm_appointments_page = get_option('basecrm_appointments_page_id');
		$basecrm_logs_page = get_option('basecrm_logs_page_id');
		$basecrm_settings_page = get_option('basecrm_settings_page_id');

		return [
			'basecrm' => $basecrm_page,
			'basecrm_leads' => $basecrm_leads_page,
			'basecrm_appointments' => $basecrm_appointments_page,
			'basecrm_logs' => $basecrm_logs_page,
			'basecrm_settings' => $basecrm_settings_page
		];
	}

	/**
	 * Include the navbar template.
	 *
	 * @return string
	 */
	public static function include_navbar(): string {
		ob_start();
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/templates/navbar.php';
		return ob_get_clean();
	}

	/**
	 * Return the contents of a php file in the snips directory.
	 *
	 * @param string $file_name
	 * @return string
	 */
	public static function snip(string $file_name): string {
		ob_start();
		include_once BaseCRM_PLUGIN_PATH . 'includes/templates/snips/' . $file_name . '.php';
		return ob_get_clean();		
	}

	/**
	 * Disable permalink.
	 * 
	 * If the current user is not an administrator, the permalink is disabled.
	 *
	 * @param integer $page_id
	 * @return string #
	 */
	public static function disable_permalink_if_not_admin(int $page_id): string {
		if (current_user_can('administrator')) {
			return get_permalink($page_id);
		} else {
			return '#';
		}
	}

	public static function i18n(string $text): string {
		return __($text, 'basecrm');
	}

	/**
	 * Return a string containing the agent's name.
	 * 
	 * If the agent's first and last name are empty, the agent's display name is returned
	 * with the name prettified.
	 *
	 * @param integer $agent_id
	 * @param string $mode
	 * @return string
	 */
	public static function agent_name(int $agent_id, string $mode = 'full'): string {
		$agent = get_user_by('ID', $agent_id); // Get the agent's user object
		if (!$agent) return 'Guest'; // If the agent's user object is empty, return 'Guest'

		if (empty($agent->first_name) && empty($agent->last_name)) { 	// If the agent's first and last name are empty
			$splittable_name = str_contains($agent->display_name, ' '); // Check if the agent's display name is splittable

			if ($splittable_name) {										// If the agent's display name is splittable
				$agent_name = explode(' ', $agent->display_name);		// Split the agent's display name into an array
				$agent_first_name = $agent_name[0];						// Set the agent's first name to the first element of the array
				$agent_last_name = $agent_name[1];						// Set the agent's last name to the second element of the array
			} else {													// If the agent's display name is not splittable
				$agent_first_name = $agent->display_name;				// Set the agent's first name to the agent's display name
				$agent_last_name = '';									// Set the agent's last name to an empty string
			}

		} else {														// If the agent's first and last name are not empty
			$agent_first_name = $agent->first_name;
			$agent_last_name = $agent->last_name;
		}

		$name = array(
			'first' => ucwords(rtrim($agent_first_name, ' .,')),
			'last' => ucwords(rtrim($agent_last_name, ' .,')),
			'full' => ucwords(rtrim($agent_first_name . ' ' . $agent_last_name, ' .,'))
		);

		return $name[$mode];
	}

}
