<?php
/**
 * The Template for Predictive Search plugin
 *
 * Override this template by copying it to yourtheme/woocommerce/popup/item.php
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<script type="text/template" id="wc_psearch_itemTpl"><div class="ajax_search_content">
	<div class="result_row">
		<a href="{{= url }}">
			<span class="rs_avatar"><img src="{{= image_url }}" /></span>
			<div class="rs_content_popup">
				<span class="rs_name">{{= title }}</span>
				{{ if ( type == 'p_sku' ) { }}<span class="rs_sku"><?php wc_ps_ict_t_e( 'SKU', __('SKU', 'woocommerce-predictive-search' ) ); ?>: <strong>{{= sku }}</strong></span>{{ } }}
				{{ if ( price != null && price != '' ) { }}<span class="rs_price"><?php wc_ps_ict_t_e( 'Price', __('Price', 'woocommerce-predictive-search' ) ); ?>: {{= price }}</span>{{ } }}
				{{ if ( description != null && description != '' ) { }}<span class="rs_description">{{= description }}</span>{{ } }}
			</div>
		</a>
	</div>
</div></script>