<?php
/**
 * SKU for WooCommerce
 *
 * @version 1.1.3
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_SKU' ) ) :

class Alg_WC_SKU {

	/**
	 * Constructor.
	 *
	 * @version 1.1.3
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_sku_for_woocommerce_enabled' ) ) {

			add_action( 'wp_insert_post',                array( $this, 'set_new_product_sku_on_insert_post' ), PHP_INT_MAX, 3 );
			add_action( 'woocommerce_duplicate_product', array( $this, 'set_new_product_sku_on_duplicate' ),   PHP_INT_MAX, 2 );

			add_action( 'alg_sku_for_woocommerce_before_regenerator_tool', array( $this, 'regenerate_tool_set_sku' ),     PHP_INT_MAX );
			add_action( 'alg_sku_for_woocommerce_after_regenerator_tool',  array( $this, 'regenerate_tool_preview_sku' ), PHP_INT_MAX );

			if ( 'yes' === get_option( 'alg_sku_for_woocommerce_allow_duplicates', 'no' ) ) {
				add_filter( 'wc_product_has_unique_sku', '__return_false', PHP_INT_MAX );
			}

			/* if ( 'yes' === get_option( 'alg_sku_for_woocommerce_search_enabled' ) ) {
				add_filter( 'the_posts', array( $this, 'add_search_by_sku_results' ), PHP_INT_MAX, 2 );
			} */
		}
	}

	/*
	 * is_frontend()
	 *
	 * @return boolean
	 *
	function is_frontend() {
	   return ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) ? true : false;
	}

	/**
	 * add_search_by_sku_results.
	 *
	function add_search_by_sku_results( $posts, $query) {

		if ( $query->is_search && 'product' === $query->query_vars['post_type'] && $this->is_frontend() ) {

			// Search by SKU
			// TODO: preserve original query
			$posts_by_sku = get_posts( array(
				'post_type' => 'product',
				'meta_query' => array(
					array(
						'key'     => '_sku',
						'value'   => $query->query_vars['s'],
						'compare' => 'LIKE'
					),
				 ),
			) );

			// Merge with original search results (with duplicates)
			$modified_posts = array_merge( $posts, $posts_by_sku );

			// Remove duplicates
			$posts_ids = array();
			foreach( $modified_posts as $the_post ) {
				$posts_ids[] = $the_post->ID;
			}
			$unique_posts_ids = array_unique( $posts_ids );

			// Get posts by new query
			// TODO: preserve original query
			$posts = get_posts( array(
				'post__in'       => $unique_posts_ids,
				'post_type'      => 'product',
				'post_status'    => ( '' == $query->post_status ) ? 'any' : $query->post_status,
				'paged'          => $query->paged,
				'posts_per_page' => $query->posts_per_page,
				'order'          => $query->order,
				//'orderby'        => $query->orderby,
			) );

			// Preparing to return
			global $wp_query;
			$wp_query->found_posts = count( $posts );

		}
		return $posts;
	}

	/**
	 * regenerate_tool_set_sku.
	 *
	 * @version 1.1.1
	 */
	function regenerate_tool_set_sku() {
		if ( ! isset( $_GET['alg_set_sku'] ) ) return;
		$this->set_all_sku( false );
		echo '<div id="message" class="updated"><p><strong>' . __( 'SKUs generated and set successfully!', 'sku-for-woocommerce' ) . '</strong></p></div>';
	}

	/**
	 * regenerate_tool_preview_sku.
	 */
	function regenerate_tool_preview_sku() {
		if ( ! isset( $_GET['alg_preview_sku'] ) ) return;
		$preview_html = '';//'<h5>' . __( 'SKU Preview', 'sku-for-woocommerce' ) . '</h5>';
		$preview_html .= '<table class="widefat" style="width:50%; min-width: 300px;">';
		$preview_html .= '<tr>' .
							'<th>#</th>' .
							'<th>' . __( 'Product', 'sku-for-woocommerce' ) . '</th>' .
							'<th>' . __( 'SKU', 'sku-for-woocommerce' ) . '</th>' .
						'</tr>';
		ob_start();
		$this->set_all_sku( true );
		$preview_html .= ob_get_clean();
		$preview_html .= '</table>';
		echo $preview_html;
	}

	/**
	 * set_all_sku.
	 *
	 * @version 1.1.0
	 */
	function set_all_sku( $is_preview ) {
		if ( 'sequential' === get_option( 'alg_sku_for_woocommerce_number_generation', 'product_id' ) ) {
			$this->sequential_counter = get_option( 'alg_sku_for_woocommerce_number_generation_sequential', 1 );
		}
		$this->product_counter = 1;
		$limit = 96;
		$offset = 0;
		while ( TRUE ) {
			$posts = new WP_Query( array(
				'posts_per_page' => $limit,
				'offset'         => $offset,
				'post_type'      => 'product',
				'post_status'    => 'any',
				'order'          => 'ASC',
				'orderby'        => 'date',
			));
			if ( ! $posts->have_posts() ) break;
			while ( $posts->have_posts() ) {
				$posts->the_post();
				$this->set_sku_with_variable( $posts->post->ID, $is_preview );
			}
			$offset += $limit;
		}
		if ( 'sequential' === get_option( 'alg_sku_for_woocommerce_number_generation', 'product_id' ) && ! $is_preview ) {
			update_option( 'alg_sku_for_woocommerce_number_generation_sequential', $this->sequential_counter );
		}
	}

	/**
	 * set_new_product_sku_on_duplicate.
	 *
	 * @version 1.1.3
	 * @since   1.1.3
	 */
	function set_new_product_sku_on_duplicate( $post_ID, $post ) {
		$this->set_new_product_sku( $post_ID );
	}

	/**
	 * set_new_product_sku_on_insert_post.
	 *
	 * @version 1.1.3
	 * @since   1.1.3
	 */
	function set_new_product_sku_on_insert_post( $post_ID, $post, $update ) {
		if ( 'product' === $post->post_type && false === $update ) {
			$this->set_new_product_sku( $post_ID );
		}
	}

	/**
	 * set_new_product_sku.
	 *
	 * @version 1.1.3
	 */
	function set_new_product_sku( $post_ID ) {
		if ( 'sequential' === get_option( 'alg_sku_for_woocommerce_number_generation', 'product_id' ) ) {
			$this->sequential_counter = get_option( 'alg_sku_for_woocommerce_number_generation_sequential', 1 );
		}
		$this->set_sku_with_variable( $post_ID, false );
		if ( 'sequential' === get_option( 'alg_sku_for_woocommerce_number_generation', 'product_id' ) ) {
			update_option( 'alg_sku_for_woocommerce_number_generation_sequential', $this->sequential_counter );
		}
	}

	/**
	 * get_available_variations.
	 *
	 * @version 1.1.1
	 * @since   1.1.1
	 */
	function get_all_variations( $_product ) {
		$all_variations = array();
		foreach ( $_product->get_children() as $child_id ) {
			$variation = $_product->get_child( $child_id );
			$all_variations[] = $_product->get_available_variation( $variation );
		}
		return $all_variations;
	}

	/**
	 * set_sku_with_variable.
	 *
	 * @version 1.1.2
	 */
	function set_sku_with_variable( $product_id, $is_preview ) {

		if ( 'sequential' === ( '' == apply_filters( 'alg_sku_generator_option', 'product_id' ) ? get_option( 'alg_sku_for_woocommerce_number_generation', 'product_id' ) : 'product_id' ) ) {
			$sku_number = $this->sequential_counter;
			$this->sequential_counter++;
		} else { // if 'product_id'
			$sku_number = $product_id;
		}

		$this->set_sku( $product_id, $sku_number, '', $is_preview );

		// Handling variable products
		$variation_handling = ( '' == apply_filters( 'alg_sku_generator_option', 'as_variable' ) ? get_option( 'alg_sku_for_woocommerce_variations_handling', 'as_variable' ) : 'as_variable' );
		$product = wc_get_product( $product_id );
		if ( $product->is_type( 'variable' ) ) {

//			$variations = $product->get_available_variations();
			$variations = $this->get_all_variations( $product );

			if ( 'as_variable' === $variation_handling ) {
				foreach( $variations as $variation ) {
					$this->set_sku( $variation['variation_id'], $sku_number, '', $is_preview );
				}
			}
			else if ( 'as_variation' === $variation_handling ) {
				foreach( $variations as $variation ) {
					if ( 'sequential' === get_option( 'alg_sku_for_woocommerce_number_generation', 'product_id' ) ) {
						$sku_number = $this->sequential_counter;
						$this->sequential_counter++;
					} else { // if 'product_id'
						$sku_number = $variation['variation_id'];
					}
					$this->set_sku( $variation['variation_id'], $sku_number, '', $is_preview );
				}
			}
			else if ( 'as_variable_with_suffix' === $variation_handling ) {
				$variation_suffixes = 'abcdefghijklmnopqrstuvwxyz';
				$abc = 0;
				foreach( $variations as $variation ) {
					$this->set_sku( $variation['variation_id'], $sku_number, $variation_suffixes[ $abc++ ], $is_preview );
					if ( 26 == $abc ) { //TODO
						$abc = 0;
					}
				}
			}
		}
	}

	/**
	 * set_sku.
	 */
	function set_sku( $product_id, $sku_number, $variation_suffix, $is_preview ) {

		$the_sku = sprintf( '%s%0' . get_option( 'alg_sku_for_woocommerce_minimum_number_length', 0 ) . 'd%s%s',
			get_option( 'alg_sku_for_woocommerce_prefix', '' ),
			$sku_number,
			get_option( 'alg_sku_for_woocommerce_suffix', '' ),
			$variation_suffix );

		if ( $is_preview ) {
			echo '<tr>' .
				'<td>' . $this->product_counter++ . '</td>' .
				'<td>' . get_the_title( $product_id ) . '</td>' .
				'<td>' . $the_sku . '</td>' .
			 '</tr>';
		}
		else {
			update_post_meta( $product_id, '_' . 'sku', $the_sku );
		}
	}
}

endif;

return new Alg_WC_SKU();
