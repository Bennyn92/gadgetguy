<?php
/**
 * SKU for WooCommerce - General Section Settings
 *
 * @version 1.1.2
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_SKU_Settings_General' ) ) :

class Alg_WC_SKU_Settings_General {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id   = 'general';
		$this->desc = __( 'General', 'sku-for-woocommerce' );

		add_filter( 'woocommerce_get_sections_alg_sku',              array( $this, 'settings_section' ) );
		add_filter( 'woocommerce_get_settings_alg_sku_' . $this->id, array( $this, 'get_settings' ), PHP_INT_MAX );
	}

	/**
	 * settings_section.
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}

	/**
	 * get_settings.
	 *
	 * @version 1.1.2
	 */
	function get_settings() {

		$settings = array(

			array(
				'title'     => __( 'SKU Generator for WooCommerce Options', 'sku-for-woocommerce' ),
				'type'      => 'title',
				'id'        => 'alg_sku_for_woocommerce_options',
			),

			array(
				'title'     => __( 'SKU Generator for WooCommerce', 'sku-for-woocommerce' ),
				'desc'      => '<strong>' . __( 'Enable', 'sku-for-woocommerce' ) . '</strong>',
				'desc_tip'  => __( 'Add full SKU support to WooCommerce.', 'sku-for-woocommerce' ),
				'id'        => 'alg_sku_for_woocommerce_enabled',
				'default'   => 'yes',
				'type'      => 'checkbox',
			),

			array(
				'type'      => 'sectionend',
				'id'        => 'alg_sku_for_woocommerce_options',
			),

			array(
				'title'    => __( 'SKU Format Options', 'sku-for-woocommerce' ),
				'type'     => 'title',
				'desc'     => __( 'This section lets you set format for SKUs. All new products will automatically get SKU according to set format values. To change SKUs of existing products, use Regenerator tool.', 'sku-for-woocommerce' ),
				'id'       => 'alg_sku_for_woocommerce_format_options',
			),

			array(
				'title'    => __( 'Number Generation', 'sku-for-woocommerce' ),
				'id'       => 'alg_sku_for_woocommerce_number_generation',
				'default'  => 'product_id',
				'type'     => 'select',
				'options'  => array(
					'product_id' => __( 'From product ID', 'sku-for-woocommerce' ),
					'sequential' => __( 'Sequential', 'sku-for-woocommerce' ),
				),
				'desc_tip' => __( 'Possible values: from product ID or sequential', 'sku-for-woocommerce' ),
				'desc'     => apply_filters( 'alg_sku_generator_option', sprintf( __( 'Get <a target="_blank" href="%s">SKU Generator for WooCommerce Pro</a> plugin to change value.', 'sku-for-woocommerce' ), 'http://coder.fm/item/sku-generator-for-woocommerce-plugin/' ) ),
				'custom_attributes' => apply_filters( 'alg_sku_generator_option', array( 'disabled' => 'disabled' ) ),
			),

			array(
				'title'    => __( 'Sequential Number Generation Counter', 'sku-for-woocommerce' ),
				'id'       => 'alg_sku_for_woocommerce_number_generation_sequential',
				'default'  => 1,
				'type'     => 'number',
				'desc'     => apply_filters( 'alg_sku_generator_option', sprintf( __( 'Get <a target="_blank" href="%s">SKU Generator for WooCommerce Pro</a> plugin to change value.', 'sku-for-woocommerce' ), 'http://coder.fm/item/sku-generator-for-woocommerce-plugin/' ) ),
				'custom_attributes' => ( '' == apply_filters( 'alg_sku_generator_option', 'disabled' ) ? array( 'min' => 0 ) : array( 'disabled' => 'disabled' ) ),
			),

			array(
				'title'    => __( 'Prefix', 'sku-for-woocommerce' ),
				'id'       => 'alg_sku_for_woocommerce_prefix',
				'default'  => '',
				'type'     => 'text',
			),

			array(
				'title'    => __( 'Minimum Number Length', 'sku-for-woocommerce' ),
				'id'       => 'alg_sku_for_woocommerce_minimum_number_length',
				'default'  => 0,
				'type'     => 'number',
			),

			array(
				'title'    => __( 'Suffix', 'sku-for-woocommerce' ),
				'id'       => 'alg_sku_for_woocommerce_suffix',
				'default'  => '',
				'type'     => 'text',
			),

			array(
				'title'    => __( 'Variable Products Variations', 'sku-for-woocommerce' ),
				'id'       => 'alg_sku_for_woocommerce_variations_handling',
				'default'  => 'as_variable',
				'type'     => 'select',
				'options'  => array(
					'as_variable'             => __( 'SKU same as parent\'s product', 'sku-for-woocommerce' ),
					'as_variation'            => __( 'Generate different SKU for each variation', 'sku-for-woocommerce' ),
					'as_variable_with_suffix' => __( 'SKU same as parent\'s product + variation letter suffix', 'sku-for-woocommerce' ),
				),
				'desc_tip' => __( 'Possible values: SKU same as parent\'s product, generate different SKU for each variation or SKU same as parent\'s product + variation letter suffix.', 'sku-for-woocommerce' ),
				'desc'     => apply_filters( 'alg_sku_generator_option', sprintf( __( 'Get <a target="_blank" href="%s">SKU Generator for WooCommerce Pro</a> plugin to change value.', 'sku-for-woocommerce' ), 'http://coder.fm/item/sku-generator-for-woocommerce-plugin/' ) ),
				'custom_attributes' => apply_filters( 'alg_sku_generator_option', array( 'disabled' => 'disabled' ) ),
			),

			array(
				'type'     => 'sectionend',
				'id'       => 'alg_sku_for_woocommerce_format_options',
			),

			array(
				'title'     => __( 'More Options', 'sku-for-woocommerce' ),
				'type'      => 'title',
				'id'        => 'alg_sku_for_woocommerce_more_options',
			),

			array(
				'title'     => __( 'Allow duplicate SKUs', 'sku-for-woocommerce' ),
				'desc'      => __( 'Enable', 'sku-for-woocommerce' ),
				'id'        => 'alg_sku_for_woocommerce_allow_duplicates',
				'default'   => 'no',
				'type'      => 'checkbox',
			),

			array(
				'type'      => 'sectionend',
				'id'        => 'alg_sku_for_woocommerce_more_options',
			),

			/* array(
				'title'     => __( 'Search by SKU Options', 'sku-for-woocommerce' ),
				'type'      => 'title',
				'id'        => 'alg_sku_for_woocommerce_search_options',
			),

			array(
				'title'     => __( 'Search by SKU', 'sku-for-woocommerce' ),
				'desc'      => __( 'Add', 'sku-for-woocommerce' ),
				'desc_tip'  => __( 'Add product searching by SKU on frontend.', 'sku-for-woocommerce' ),
				'id'        => 'alg_sku_for_woocommerce_search_enabled',
				'default'   => 'no',
				'type'      => 'checkbox',
			),

			array(
				'type'      => 'sectionend',
				'id'        => 'alg_sku_for_woocommerce_search_options',
			), */

		);

		return $settings;
	}

}

endif;

return new Alg_WC_SKU_Settings_General();
