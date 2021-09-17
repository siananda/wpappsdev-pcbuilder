<?php

namespace WPAppsDev\PCBU\Admin;

use WPAppsDev\WpadSettingApi;

/**
 * The Menu handler class.
 */
class Menu {
	/**
	 * Hold menu page ID.
	 *
	 * @var string
	 */
	protected $menupage;

	/**
	 * Hold sub menu page ID.
	 *
	 * @var string
	 */
	protected $submenupage;

	/**
	 * Hold settings api object.
	 *
	 * @var object
	 */
	protected static $settings;

	/**
	 * Initialize the class.
	 */
	public function __construct() {
		self::$settings = new WpadSettingApi();

		// Register admin menu.
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		// Change admin menu order.
		add_action( 'admin_menu', [ $this, 'change_menu_order' ], 99 );
		// Update active menu parent file for new menu order.
		add_action( 'admin_head', [ $this, 'maybe_change_menu_parent_file' ] );
		// Init settings api.
		add_action( 'admin_init', [ $this, 'settings_api_init' ] );
	}

	/**
	 * Register admin menu.
	 *
	 * @return void
	 */
	public function admin_menu() {
		$base_slug  = 'wpadpcbu-pcbuilder';
		$manage     = 'manage_woocommerce';
		$capability = apply_filters( 'wpadpcbu_manager_capability', $manage );

		$this->menupage = add_menu_page(
			__( 'WC Pc Builder', 'wpappsdev-pcbuilder' ),
			__( 'WC PcBuilder', 'wpappsdev-pcbuilder' ),
			$capability,
			$base_slug,
			[ $this, 'settings_page' ],
			'dashicons-book-alt',
			50
		);

		$this->submenu = add_submenu_page(
			$base_slug,
			__( 'Pc Builder Settings', 'wpappsdev-pcbuilder' ),
			__( 'Settings', 'wpappsdev-pcbuilder' ),
			$capability,
			'pcbusettings',
			[ $this, 'settings_page' ]
		);
	}

	/**
	 * Display Settings Page.
	 *
	 * @return void
	 */
	public function settings_page() {
		echo '<div class="wrap">';
		echo '<div class="settings-body">';
		self::$settings->show_navigation();
		self::$settings->show_forms();
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Change admin menu order.
	 *
	 * @return void
	 */
	public function change_menu_order() {
		global $submenu;
		$component_menu = [];
		$p_menus        = $submenu['edit.php?post_type=product'];

		foreach ( $p_menus as $key => $p_menu ) {
			if ( 'edit-tags.php?taxonomy=pcbucomp&amp;post_type=product' === $p_menu[2] ) {
				$component_menu    = $p_menu;
				$component_menu[0] = __( 'PC Components', 'wpappsdev-pcbuilder' );
				unset( $submenu['edit.php?post_type=product'][ $key ] );
			}
		}

		if ( ! empty( $component_menu ) ) {
			$pcbuilder_menu                = [ $component_menu ];
			$pcbuilder_menu                = array_merge( $pcbuilder_menu, $submenu['wpadpcbu-pcbuilder'] );
			$submenu['wpadpcbu-pcbuilder'] = $pcbuilder_menu;
		}
	}

	/**
	 * Update active menu parent file for new menu order.
	 *
	 * @return void
	 */
	public function maybe_change_menu_parent_file() {
		global $parent_file;

		if ( 'edit.php?post_type=product' != $parent_file ) {
			return;
		}

		if ( ! isset( $_REQUEST['taxonomy'] ) ) {
			return;
		}

		if ( 'pcbucomp' == $_REQUEST['taxonomy'] ) {
			$parent_file = 'wpadpcbu-pcbuilder';
		}

		$tax_array = explode( '-', wc_clean( $_REQUEST['taxonomy'] ) );

		if ( count( $tax_array ) > 1 && 'cf' == $tax_array[0] ) {
			$parent_file = 'wpadpcbu-pcbuilder';
		}

		return;
	}

	/**
	 * Init settings api options.
	 *
	 * @return void
	 */
	public function settings_api_init() {
		//set the settings
		self::$settings->set_sections( self::settings_sections() );
		self::$settings->set_fields( self::settings_fields() );

		//initialize settings
		self::$settings->admin_init();
	}

	/**
	 * Returns all the settings sections.
	 *
	 * @return array
	 */
	public static function settings_sections() {
		$sections = [
			[
				'id'         => 'page_settings',
				'title'      => __( 'Builder Pages Settings', 'wpappsdev-pcbuilder' ),
				'menu_title' => __( 'Pages Settings', 'wpappsdev-pcbuilder' ),
			],
			[
				'id'         => 'search_page_settings',
				'title'      => __( 'Search Page Settings', 'wpappsdev-pcbuilder' ),
				'menu_title' => __( 'Search Page', 'wpappsdev-pcbuilder' ),
			],
		];

		$sections = apply_filters( 'wpadpcbu_section_settings_tabs', $sections );

		return $sections;
	}

	/**
	 * Returns all the settings fields.
	 *
	 * @return array
	 */
	public static function settings_fields() {
		$settings_fields = [
			'page_settings' => apply_filters( 'wpadpcbu_page_settings_fields', [
				[
					'name'    => 'wpadpcbu_builder_page',
					'label'   => __( 'Select Builder Page', 'wpappsdev-pcbuilder' ),
					'type'    => 'select',
					'options' => self::get_pages_options(),
				],
				[
					'name'    => 'wpadpcbu_builder_search_page',
					'label'   => __( 'Select Builder Search Page', 'wpappsdev-pcbuilder' ),
					'type'    => 'select',
					'options' => self::get_pages_options(),
				],
			] ),
			'search_page_settings' => apply_filters( 'wpadpcbu_search_page_settings_fields', [
				[
					'name'  => 'wpadpcbu_search_per_page',
					'label' => __( 'Per Page', 'wpappsdev-pcbuilder' ),
					'type'  => 'text',
				],
			] ),
		];

		$settings_fields = apply_filters( 'wpadpcbu_section_settings_tabs_fields', $settings_fields );

		return $settings_fields;
	}

	/**
	 * Get page select options.
	 *
	 * @return void
	 */
	public static function get_pages_options() {
		$pages   = get_pages();
		$options = [ -1 => __( 'Select Page', 'wpappsdev-pcbuilder' ) ];

		foreach ( $pages as $page ) {
			$options[ $page->ID ] = $page->post_title;
		}

		return $options;
	}
}
