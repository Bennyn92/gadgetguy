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

if (isset($_GET['order']) && ($_GET['order'] !== '')) {$order_id = $_GET['order'];}

try {
    $clientWebStore = new WC_API_Client( 'http://thecomputerguyde.com', 'ck_c5faf0e4aa56fd278b4d49d498bc3b1e981ae788', 'cs_84fe6aba56ad5791ff63d00824b4901428d4d377', $options );
    $orderObject = $clientWebStore->orders->get($order_id);

    $clientDropship = new WC_API_Client( 'http://dropship.thecomputerguyde.com', 'ck_1218aa30d83fbc1c99702e9f79ced04294a0a351', 'cs_4ebc21ede4e7c0e64fab65bf4b9b36e1cda28fb1', $options );

    $orderarray = array($orderObject);
    $orderOrderArray = $orderObject->order;

    $order = wc_create_order($orderarray);
    $line_items = $orderOrderArray->line_items;

    foreach ($line_items as $line_item) {
        $sku = $line_item->sku;
        $product_id = wc_get_product_id_by_sku($sku);
        $quantityOrdered = $line_item->quantity;
        $order->add_product( wc_get_product($product_id), $quantityOrdered);

        $quantityDropship = wc_get_product($product_id)->get_stock_quantity();
        $newStock = $quantityDropship - $quantityOrdered;
        wc_update_product_stock( $product_id, $newStock);
    }

    $order->set_address($orderOrderArray->shipping_address, 'shipping');
    $order->set_total( $orderOrderArray->total );

} catch ( WC_API_Client_Exception $e ) {
    echo $e->getMessage() . PHP_EOL;
    echo $e->getCode() . PHP_EOL;
    if ( $e instanceof WC_API_Client_HTTP_Exception ) {
        print_r( $e->get_request() );
        print_r( $e->get_response() );
    }
}
?>