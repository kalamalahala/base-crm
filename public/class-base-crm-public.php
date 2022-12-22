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
		
		wp_dequeue_script('bootstrap-modal');
		wp_dequeue_script('bootstrap-tooltip');
		wp_dequeue_script('bootstrap-transition');
		wp_dequeue_script('bootstrap-popover');
		wp_dequeue_script('bootstrap-collapse');


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
			)
		);
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

	public function dequeue_avada_scripts()
	{
		do_action('qm/debug', 'dequeue_avada_scripts');
		// 		/* Fix for Modal Conflict */
		// add_action( 'wp', function() {
		// 	Fusion_Dynamic_JS::deregister_script( 'bootstrap-modal' );
		// }, 99);

		// Fusion_Dynamic_JS::deregister_script('avada-comments');
		// Fusion_Dynamic_JS::deregister_script('avada-general-footer');
		// Fusion_Dynamic_JS::deregister_script('avada-mobile-image-hover');
		// Fusion_Dynamic_JS::deregister_script('avada-quantity');
		// Fusion_Dynamic_JS::deregister_script('avada-scrollspy');
		// Fusion_Dynamic_JS::deregister_script('avada-select');
		// Fusion_Dynamic_JS::deregister_script('avada-sidebars');
		// Fusion_Dynamic_JS::deregister_script('avada-tabs-widget');

		// Fusion_Dynamic_JS::deregister_script('bootstrap-collapse');
		Fusion_Dynamic_JS::deregister_script('bootstrap-modal');
		// Fusion_Dynamic_JS::deregister_script('bootstrap-popover');
		// Fusion_Dynamic_JS::deregister_script('bootstrap-scrollspy');
		// Fusion_Dynamic_JS::deregister_script('bootstrap-tab');
		// Fusion_Dynamic_JS::deregister_script('bootstrap-tooltip');
		// Fusion_Dynamic_JS::deregister_script('bootstrap-transition');

		// Fusion_Dynamic_JS::deregister_script('cssua');

		// Fusion_Dynamic_JS::deregister_script('fusion-alert');
		// Fusion_Dynamic_JS::deregister_script('fusion-blog'); // !
		// Fusion_Dynamic_JS::deregister_script('fusion-button'); // !
		// Fusion_Dynamic_JS::deregister_script('fusion-carousel');
		// Fusion_Dynamic_JS::deregister_script('fusion-chartjs');
		// Fusion_Dynamic_JS::deregister_script('fusion-column-bg-image');
		// Fusion_Dynamic_JS::deregister_script('fusion-count-down');
		// Fusion_Dynamic_JS::deregister_script('fusion-equal-heights');
		// Fusion_Dynamic_JS::deregister_script('fusion-flexslider');
		// Fusion_Dynamic_JS::deregister_script('fusion-image-before-after');
		// Fusion_Dynamic_JS::deregister_script('fusion-lightbox');
		// Fusion_Dynamic_JS::deregister_script('fusion-parallax'); // !
		// Fusion_Dynamic_JS::deregister_script('fusion-popover');
		// Fusion_Dynamic_JS::deregister_script('fusion-recent-posts');
		// Fusion_Dynamic_JS::deregister_script('fusion-sharing-box');
		// Fusion_Dynamic_JS::deregister_script('fusion-syntax-highlighter');
		// Fusion_Dynamic_JS::deregister_script('fusion-title');
		// Fusion_Dynamic_JS::deregister_script('fusion-tooltip');
		// Fusion_Dynamic_JS::deregister_script('fusion-video-bg');
		// Fusion_Dynamic_JS::deregister_script('fusion-video-general');
		// Fusion_Dynamic_JS::deregister_script('fusion-waypoints');

		// Fusion_Dynamic_JS::deregister_script('images-loaded'); // !
		// Fusion_Dynamic_JS::deregister_script('isotope'); // !!

		// Fusion_Dynamic_JS::deregister_script('jquery-appear');
		// Fusion_Dynamic_JS::deregister_script('jquery-caroufredsel');
		// Fusion_Dynamic_JS::deregister_script('jquery-count-down');
		// Fusion_Dynamic_JS::deregister_script('jquery-count-to');
		// Fusion_Dynamic_JS::deregister_script('jquery-easy-pie-chart');
		// Fusion_Dynamic_JS::deregister_script('jquery-event-move');
		// Fusion_Dynamic_JS::deregister_script('jquery-fade'); // !!
		// Fusion_Dynamic_JS::deregister_script('jquery-fitvids');
		// Fusion_Dynamic_JS::deregister_script('jquery-fusion-maps');
		// Fusion_Dynamic_JS::deregister_script('jquery-hover-flow');
		// Fusion_Dynamic_JS::deregister_script('jquery-hover-intent');
		// Fusion_Dynamic_JS::deregister_script('jquery-infinite-scroll'); // !
		// Fusion_Dynamic_JS::deregister_script('jquery-lightbox');
		// Fusion_Dynamic_JS::deregister_script('jquery-mousewheel'); // !
		// Fusion_Dynamic_JS::deregister_script('jquery-placeholder');
		// Fusion_Dynamic_JS::deregister_script('jquery-request-animation-frame');
		// Fusion_Dynamic_JS::deregister_script('jquery-sticky-kit');
		// Fusion_Dynamic_JS::deregister_script('jquery-to-top');
		// Fusion_Dynamic_JS::deregister_script('jquery-touch-swipe'); // !
		// Fusion_Dynamic_JS::deregister_script('jquery-waypoints'); // !

		// Fusion_Dynamic_JS::deregister_script('lazysizes');
		// Fusion_Dynamic_JS::deregister_script('packery'); // !!
		// Fusion_Dynamic_JS::deregister_script('vimeo-player');  


		//     Fusion_Dynamic_JS::deregister_script('jquery-easing');      
		//     Fusion_Dynamic_JS::deregister_script('modernizr');
		//     Fusion_Dynamic_JS::deregister_script('fusion-testimonials');
		//     Fusion_Dynamic_JS::deregister_script('jquery-cycle'); // !    
		//     Fusion_Dynamic_JS::deregister_script('jquery-flexslider'); // !
	}
}
