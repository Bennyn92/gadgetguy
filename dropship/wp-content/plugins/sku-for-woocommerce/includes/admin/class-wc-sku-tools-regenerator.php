<?php
/**
 * SKU for WooCommerce - Regenerator Tool
 *
 * @version 1.1.2
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_SKU_Tools_Regenerator' ) ) :

class Alg_WC_SKU_Tools_Regenerator {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id   = 'regenerator';
		$this->desc = __( 'Regenerator', 'sku-for-woocommerce' );

		add_filter( 'woocommerce_get_sections_alg_sku',              array( $this, 'settings_section' ) );
//		add_filter( 'woocommerce_get_settings_alg_sku_' . $this->id, array( $this, 'get_settings' ), PHP_INT_MAX );

		add_action( 'alg_sku_for_woocommerce_regenerator_tool', array( $this, 'create_sku_tool' ) );
	}

	/**
	 * create_sku_tool.
	 *
	 * @version 1.1.2
	 */
	function create_sku_tool() {
		echo '<h3>' . __( 'SKU Regenerator', 'sku-for-woocommerce' ) . '</h3>';
		if ( 'yes' === get_option( 'alg_sku_for_woocommerce_enabled' ) ) {

			do_action( 'alg_sku_for_woocommerce_before_regenerator_tool' );
			if ( isset( $_GET['alg_preview_sku'] ) ) {
				echo '<p>' . '<a class="button button-primary" href="' . add_query_arg( 'alg_set_sku', '', remove_query_arg( 'alg_preview_sku' ) ) . '">' . __( 'Set SKUs for all products', 'sku-for-woocommerce' )  . '</a>' . '</p>';
			} else {
				echo '<p>' . '<a class="button button-primary" href="' . add_query_arg( 'alg_preview_sku', '', remove_query_arg( 'alg_set_sku' ) ) . '">' . __( 'Generate SKU preview for all products', 'sku-for-woocommerce' )  . '</a>' . '</p>';
			}
			do_action( 'alg_sku_for_woocommerce_after_regenerator_tool' );

		} else {

			echo '<em>' . __( 'To use regenerator, SKU Generator for WooCommerce must be enabled in General settings tab.', 'sku-for-woocommerce' ) . '</em>';

		}
	}

	/**
	 * settings_section.
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}
}

endif;

return new Alg_WC_SKU_Tools_Regenerator();
