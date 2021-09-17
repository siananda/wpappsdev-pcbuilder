<?php

namespace WPAppsDev\PCBU\Shortcodes;

use WPAppsDev\PCBU\Abstracts\WPAppsDevShortcode;

class PcBuilders extends WPAppsDevShortcode {
	protected $shortcode = 'wpadpcbu-pcbuilder';

	/**
	 * Load template files.
	 *
	 * @param array $atts
	 *
	 * @return void
	 */
	public function render_shortcode( $atts ) {
		$this->enqueue_scripts();

		$pcbu_data = [];

		if ( is_callable( [ WC()->session, 'get' ] ) ) {
			$pcbu_data = WC()->session->get( 'wpadpcbu_pc_builder_data', [] );
		}

		$args = [
			'components' => get_component_data(),
			'items'      => isset( $pcbu_data['items'] ) ? $pcbu_data['items'] : [],
			'total'      => isset( $pcbu_data['total'] ) ? wc_price( $pcbu_data['total'] ) : 0,
		];

		return wpadpcbu_get_template_html( 'shortcodes/pc-builder.php', $args );
	}

	/**
	 * Load enqueue scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
	}
}
