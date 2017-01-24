<?php
require_once("wp-load.php");
$woocommerce = new WooCommerce();

require_once( 'lib/woocommerce-api.php' );
$options = array(
    'debug'           => true,
    'return_as_array' => false,
    'validate_url'    => false,
    'timeout'         => 30,
    'ssl_verify'      => false,
);

try {

    $clientWebStore = new WC_API_Client( 'http://thecomputerguyde.com', 'ck_c5faf0e4aa56fd278b4d49d498bc3b1e981ae788', 'cs_84fe6aba56ad5791ff63d00824b4901428d4d377', $options );

    $clientDropship = new WC_API_Client( 'http://dropship.thecomputerguyde.com', 'ck_1218aa30d83fbc1c99702e9f79ced04294a0a351', 'cs_4ebc21ede4e7c0e64fab65bf4b9b36e1cda28fb1', $options );
   
    $productsDropship = $clientDropship->products->get( '', ['filter[limit]' => -1] );
    $productsDropship = $productsDropship->products;

    foreach ($productsDropship as $product_array) { 

        $product_sku  = $product_array->sku;
        $result_id = wc_get_product_id_by_sku($product_sku);
    
        if ($result_id == 0) {
            // $title  = $product_array->title;
            // $sku   = $product_array->sku;
            // $type   = $product_array->type;
            // $price  = $product_array->regular_price;
            // $description = $product_array->description;
            $clientWebStore->products->create( get_object_vars($product_array) );
        } else {
            // $title  = $product_array->title;
            // $type   = $product_array->type;
            // $price  = $product_array->regular_price;
            // $description = $product_array->description;
            $clientWebStore->products->update( $result_id, get_object_vars($product_array) );
        }
    }

} catch ( WC_API_Client_Exception $e ) {
    echo $e->getMessage() . PHP_EOL;
    echo $e->getCode() . PHP_EOL;
    if ( $e instanceof WC_API_Client_HTTP_Exception ) {
        print_r( $e->get_request() );
        print_r( $e->get_response() );
    }
}
?>