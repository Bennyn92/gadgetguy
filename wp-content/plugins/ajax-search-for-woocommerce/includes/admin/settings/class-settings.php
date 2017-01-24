<?php

/**
 * Settings API data
 */
class DGWT_WCAS_Settings {
	/*
	 * @var string
	 * Unique settings slug
	 */

	private $setting_slug = DGWT_WCAS_SETTINGS_KEY;

	/*
	 * @var array
	 * All options values in one array
	 */
	public $opt;

	/*
	 * @var object
	 * Settings API object
	 */
	public $settings_api;

	public function __construct() {
		global $dgwt_wcas_settings;

		// Set global variable with settings
		$settings = get_option( $this->setting_slug );
		if ( !isset( $settings ) || empty( $settings ) ) {
			$dgwt_wcas_settings = array();
		} else {
			$dgwt_wcas_settings = $settings;
		}

		$this->opt = $dgwt_wcas_settings;

		$this->settings_api = new DGWT_WCAS_Settings_API( $this->setting_slug );

		add_action( 'admin_init', array( $this, 'settings_init' ) );
	}

	/*
	 * Set sections and fields
	 */

	public function settings_init() {

		//Set the settings
		$this->settings_api->set_sections( $this->settings_sections() );
		$this->settings_api->set_fields( $this->settings_fields() );

		//Initialize settings
		$this->settings_api->settings_init();
	}

	/*
	 * Set settings sections
	 * 
	 * @return array settings sections
	 */

	public function settings_sections() {

		$sections = array(
			array(
				'id'	 => 'dgwt_wcas_basic',
				'title'	 => __( 'Basic', DGWT_WCAS_DOMAIN )
			),
			array(
				'id'	 => 'dgwt_wcas_advanced',
				'title'	 => __( 'Advanced', DGWT_WCAS_DOMAIN )
			),
			array(
				'id'	 => 'dgwt_wcas_details_box',
				'title'	 => __( 'Extra Details', DGWT_WCAS_DOMAIN )
			),
			array(
				'id'	 => 'dgwt_wcas_style',
				'title'	 => __( 'Style', DGWT_WCAS_DOMAIN )
			),
//			array(
//				'id'	 => 'dgwt_wcas_performance',
//				'title'	 => __( 'Performance', DGWT_WCAS_DOMAIN )
//			)
		);
		return apply_filters( 'dgwt_wcas_settings_sections', $sections );
	}

	/**
	 * Create settings fields
	 *
	 * @return array settings fields
	 */
	function settings_fields() {
		$settings_fields = array(
			'dgwt_wcas_basic'		 => apply_filters( 'dgwt_wcas_basic_settings', array(
				array(
					'name'		 => 'how_to_use',
					'label'		 => __( 'How to use?', DGWT_WCAS_DOMAIN ),
					'type'		 => 'desc',
					'desc'		 => dgwt_wcas_how_to_use_html(),
				),
				array(
					'name'		 => 'suggestions_limit',
					'label'		 => __( 'Suggestions limit', DGWT_WCAS_DOMAIN ),
					'type'		 => 'number',
					'size'		 => 'small',
					'desc'		 => __( 'Maximum number of suggestions rows.', DGWT_WCAS_DOMAIN ),
					'default'	 => 10,
				),
				array(
					'name'		 => 'min_chars',
					'label'		 => __( 'Minimum characters', DGWT_WCAS_DOMAIN ),
					'type'		 => 'number',
					'size'		 => 'small',
					'desc'		 => __( 'Minimum number of characters required to trigger autosuggest.', DGWT_WCAS_DOMAIN ),
					'default'	 => 3,
				),
				array(
					'name'		 => 'show_submit_button',
					'label'		 => __( 'Show submit button', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'size'		 => 'small',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'search_submit_text',
					'label'		 => __( 'Search submit button text', DGWT_WCAS_DOMAIN ),
					'type'		 => 'text',
					'desc'		 => __( 'To display a loupe icon leave this field empty.', DGWT_WCAS_DOMAIN ),
					'default'	 => __( 'Search', DGWT_WCAS_DOMAIN ),
				),
				array(
					'name'		 => 'search_placeholder',
					'label'		 => __( 'Search input placeholder', DGWT_WCAS_DOMAIN ),
					'type'		 => 'text',
					'default'	 => __( 'Search for products...', DGWT_WCAS_DOMAIN ),
				),
				array(
					'name'		 => 'show_details_box',
					'label'		 => __( 'Show details box', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'size'		 => 'small',
					'desc'		 => __( 'The Details box is an additional container for extended information. The details are changed dynamically when you hover the mouse over one of the suggestions.', DGWT_WCAS_DOMAIN ),
					'default'	 => 'off',
				)
			) ),
			'dgwt_wcas_advanced'	 => apply_filters( 'dgwt_wcas_advanced_settings', array(
				array(
					'name'	 => 'search_head',
					'label'	 => '<h3>' . __( 'Search scope', DGWT_WCAS_DOMAIN ) . '</h3>',
					'type'	 => 'head',
				),
				array(
					'name'		 => 'search_in_product_content',
					'label'		 => __( 'Search in products content', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'search_in_product_excerpt',
					'label'		 => __( 'Search in products excerpt', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'search_in_woo_categories',
					'label'		 => __( 'Search in products categories', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'on',
				),
				array(
					'name'		 => 'search_in_woo_tags',
					'label'		 => __( 'Search in products tags', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'search_in_product_sku',
					'label'		 => __( 'Search in products SKU', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'exclude_out_of_stock',
					'label'		 => __( "Exclude 'out of stock' products", DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'	 => 'product_suggestion_head',
					'label'	 => '<h3>' . __( 'Suggestions output', DGWT_WCAS_DOMAIN ) . '</h3>',
					'type'	 => 'head',
				),
				array(
					'name'		 => 'show_product_image',
					'label'		 => __( 'Show product image', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'show_product_price',
					'label'		 => __( 'Show price', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'show_product_desc',
					'label'		 => __( 'Show product description', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
				array(
					'name'		 => 'show_product_sku',
					'label'		 => __( 'Show SKU', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'off',
				),
//				array(
//					'name'		 => 'show_sale_badge',
//					'label'		 => __( 'Show sale badge', DGWT_WCAS_DOMAIN ),
//					'type'		 => 'checkbox',
//					'default'	 => 'off',
//				),
//				array(
//					'name'		 => 'show_featured_badge',
//					'label'		 => __( 'Show featured badge', DGWT_WCAS_DOMAIN ),
//					'type'		 => 'checkbox',
//					'default'	 => 'off',
//				),
			) ),
			'dgwt_wcas_details_box'	 => apply_filters( 'dgwt_wcas_details_box_settings', array(
				array(
					'name'	 => 'tax_details_tax_head',
					'label'	 => '<h3>' . __( 'Category and tag details:', DGWT_WCAS_DOMAIN ) . '</h3>',
					'type'	 => 'head',
				),
				array(
					'name'		 => 'show_for_tax',
					'label'		 => __( 'Show', DGWT_WCAS_DOMAIN ),
					'type'		 => 'select',
					'options'	 => array(
						'all'		 => __( 'All Product', DGWT_WCAS_DOMAIN ),
						'featured'	 => __( 'Featured Products', DGWT_WCAS_DOMAIN ),
						'onsale'	 => __( 'On-sale Products', DGWT_WCAS_DOMAIN ),
					),
					'default'	 => 'on',
				),
				array(
					'name'		 => 'orderby_for_tax',
					'label'		 => __( 'Order by', DGWT_WCAS_DOMAIN ),
					'type'		 => 'select',
					'options'	 => array(
						'date'	 => __( 'Date', DGWT_WCAS_DOMAIN ),
						'price'	 => __( 'Price', DGWT_WCAS_DOMAIN ),
						'rand'	 => __( 'Random', DGWT_WCAS_DOMAIN ),
						'sales'	 => __( 'Sales', DGWT_WCAS_DOMAIN ),
					),
					'default'	 => 'on',
				),
				array(
					'name'		 => 'order_for_tax',
					'label'		 => __( 'Order by', DGWT_WCAS_DOMAIN ),
					'type'		 => 'select',
					'options'	 => array(
						'desc'	 => __( 'DESC', DGWT_WCAS_DOMAIN ),
						'asc'	 => __( 'ASC', DGWT_WCAS_DOMAIN ),
					),
					'default'	 => 'desc',
				),
				array(
					'name'	 => 'tax_details_product_other',
					'label'	 => '<h3>' . __( 'Other', DGWT_WCAS_DOMAIN ) . '</h3>',
					'type'	 => 'head',
				),
				array(
					'name'		 => 'details_box_position',
					'label'		 => __( 'Details box position', DGWT_WCAS_DOMAIN ),
					'type'		 => 'select',
					'desc'		 => __( 'If your search form is very close to the right window screen, then select left.', DGWT_WCAS_DOMAIN ),
					'options'	 => array(
						'left'	 => __( 'Left', DGWT_WCAS_DOMAIN ),
						'right'	 => __( 'Right', DGWT_WCAS_DOMAIN ),
					),
					'default'	 => 'right',
				)
			) ),
			'dgwt_wcas_style'		 => apply_filters( 'dgwt_wcas_style_settings', array(
				array(
					'name'	 => 'search_form',
					'label'	 => '<h3>' . __( 'Search form', DGWT_WCAS_DOMAIN ) . '</h3>',
					'type'	 => 'head',
				),
				array(
					'name'		 => 'bg_input_color',
					'label'		 => __( 'Search input background', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'text_input_color',
					'label'		 => __( 'Search input text', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'border_input_color',
					'label'		 => __( 'Search input border', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'bg_submit_color',
					'label'		 => __( 'Search submit background', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'text_submit_color',
					'label'		 => __( 'Search submit text', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'	 => 'syggestions_style_head',
					'label'	 => '<h3>' . __( 'Suggestions', DGWT_WCAS_DOMAIN ) . '</h3>',
					'type'	 => 'head',
				),
				array(
					'name'		 => 'sug_bg_color',
					'label'		 => __( 'Suggestion background', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'sug_hover_color',
					'label'		 => __( 'Suggestion selected', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'sug_text_color',
					'label'		 => __( 'Text color', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'sug_highlight_color',
					'label'		 => __( 'Highlight color', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'sug_border_color',
					'label'		 => __( 'Border color', DGWT_WCAS_DOMAIN ),
					'type'		 => 'color',
					'default'	 => '',
				),
				array(
					'name'		 => 'sug_width',
					'label'		 => __( 'Suggestions width', DGWT_WCAS_DOMAIN ),
					'type'		 => 'number',
					'size'		 => 'small',
					'desc'		 => ' px. ' . __( 'Overvrite the suggestions container width. Leave this field empty to adjust the suggestions container width to the search input width.', DGWT_WCAS_DOMAIN ),
					'default'	 => '',
				),
				array(
					'name'	 => 'preloader',
					'label'	 => '<h3>' . __( 'Preloader', DGWT_WCAS_DOMAIN ) . '</h3>',
					'type'	 => 'head',
				),
				array(
					'name'		 => 'show_preloader',
					'label'		 => __( 'Show preloader', DGWT_WCAS_DOMAIN ),
					'type'		 => 'checkbox',
					'default'	 => 'on',
				),
				array(
					'name'		 => 'preloader_url',
					'label'		 => __( 'Upload preloader image', DGWT_WCAS_DOMAIN ),
					'type'		 => 'file',
					'default'	 => '',
				),
			) )
		);


		return $settings_fields;
	}

	/*
	 * Print optin value
	 * 
	 * @param string $option_key
	 * @param string $default default value if option not exist
	 * 
	 * @return string
	 */

	public function get_opt( $option_key, $default = '' ) {

		$value = '';

		if ( is_string( $option_key ) && !empty( $option_key ) ) {
			
			$settings = get_option( $this->setting_slug );

			if ( is_array($settings) && array_key_exists( $option_key, $settings ) ) {
				$value = $settings[ $option_key ];
			} else {

				// Catch default
				foreach ( $this->settings_fields() as $section ) {
					foreach ( $section as $field ) {
						if ( $field[ 'name' ] === $option_key && isset( $field[ 'default' ] ) ) {
							$value = $field[ 'default' ];
						}
					}
				}
			}
		}

		if ( empty( $value ) && !empty( $default ) ) {
			$value = $default;
		}

		return apply_filters( 'dgwt_wcas_return_option_value', $value, $option_key );
	}

	/**
	 * Handles output of the settings
	 */
	public static function output() {

		$settings = DGWT_WCAS()->settings->settings_api;

		include_once DGWT_WCAS_DIR . 'includes/admin/views/settings.php';
	}

}

/*
 * Disable details box setting tab if the option id rutns off
 */
add_filter( 'dgwt_wcas_settings_sections', 'dgwt_wcas_hide_settings_detials_tab' );

function dgwt_wcas_hide_settings_detials_tab( $sections ) {

	if ( DGWT_WCAS()->settings->get_opt( 'show_details_box' ) !== 'on' && is_array( $sections ) ) {
		
		$i = 0;
		foreach ( $sections as $section ) {

			if ( isset( $section[ 'id' ] ) && $section[ 'id' ] === 'dgwt_wcas_details_box' ) {
				unset( $sections[ $i ] );
				
			}
			
			$i++;
		}
	}

	return $sections;
}
