<?php
require_once("wp-load.php");
$woocommerce = new WooCommerce();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
            $title  = $product_array->title;
            $sku   = $product_array->sku;
            $type   = $product_array->type;
            $price  = $product_array->regular_price;
            $description = $product_array->description;
            $clientWebStore->products->create( array( 'title' => $title, 'type' => $type, 'regular_price' => $price, 'description' => $description, 'sku' => $sku));
        } else {
            $title  = $product_array->title;
            $type   = $product_array->type;
            $price  = $product_array->regular_price;
            $description = $product_array->description;
            $clientWebStore->products->update( $result_id, array( 'title' => $title, 'type' => $type, 'regular_price' => $price, 'description' => $description));
        }
    }





    // //var_dump($orderObject);
    // // print_r($woocommerce->post('orders', array($orderObject)));
    // $orderarray = array($orderObject);
    // $orderorderarray = $orderObject->order;

    // print_r($order = wc_create_order($orderarray));

    // $line_items = $orderorderarray->line_items;
    // foreach ($line_items as $line_item) {
    //     $product_id = $line_item->product_id;
    //     $quantity = $line_item->quantity;
    //     print_r($order->add_product( wc_get_product($product_id), $quantity));

    // }

    // print_r($order->set_address($orderorderarray->shipping_address, 'shipping'));
    // print_r($order->set_total( $orderorderarray->total ));



    // coupons
    //print_r( $client->coupons->get() );
    //print_r( $client->coupons->get( $coupon_id ) );
    //print_r( $client->coupons->get_by_code( 'coupon-code' ) );
    //print_r( $client->coupons->create( array( 'code' => 'test-coupon', 'type' => 'fixed_cart', 'amount' => 10 ) ) );
    //print_r( $client->coupons->update( $coupon_id, array( 'description' => 'new description' ) ) );
    //print_r( $client->coupons->delete( $coupon_id ) );
    //print_r( $client->coupons->get_count() );
    // custom
    //$client->custom->setup( 'webhooks', 'webhook' );
    //print_r( $client->custom->get( $params ) );
    // customers
    //print_r( $client->customers->get() );
    //print_r( $client->customers->get( $customer_id ) );
    //print_r( $client->customers->get_by_email( 'help@woothemes.com' ) );
    //print_r( $client->customers->create( array( 'email' => 'woothemes@mailinator.com' ) ) );
    //print_r( $client->customers->update( $customer_id, array( 'first_name' => 'John', 'last_name' => 'Galt' ) ) );
    //print_r( $client->customers->delete( $customer_id ) );
    //print_r( $client->customers->get_count( array( 'filter[limit]' => '-1' ) ) );
    //print_r( $client->customers->get_orders( $customer_id ) );
    //print_r( $client->customers->get_downloads( $customer_id ) );
    //$customer = $client->customers->get( $customer_id );
    //$customer->customer->last_name = 'New Last Name';
    //print_r( $client->customers->update( $customer_id, (array) $customer ) );
    // index
    //print_r( $client->index->get() );
    // orders
    //print_r( $client->orders->get() );
    //print_r( $client->orders->update_status( $order_id, 'pending' ) );
    // order notes
    //print_r( $client->order_notes->get( $order_id ) );
    //print_r( $client->order_notes->create( $order_id, array( 'note' => 'Some order note' ) ) );
    //print_r( $client->order_notes->update( $order_id, $note_id, array( 'note' => 'An updated order note' ) ) );
    //print_r( $client->order_notes->delete( $order_id, $note_id ) );
    // order refunds
    //print_r( $client->order_refunds->get( $order_id ) );
    //print_r( $client->order_refunds->get( $order_id, $refund_id ) );
    //print_r( $client->order_refunds->create( $order_id, array( 'amount' => 1.00, 'reason' => 'cancellation' ) ) );
    //print_r( $client->order_refunds->update( $order_id, $refund_id, array( 'reason' => 'who knows' ) ) );
    //print_r( $client->order_refunds->delete( $order_id, $refund_id ) );
    // products
    
    //print_r( $client->products->get() );
    
    //print_r( $client->products->get( $product_id ) );
    //print_r( $client->products->get( $variation_id ) );
    //print_r( $client->products->get_by_sku( 'a-product-sku' ) );
    //print_r( $client->products->create( array( 'title' => 'Test Product', 'type' => 'simple', 'regular_price' => '9.99', 'description' => 'test' ) ) );
    //print_r( $client->products->update( $product_id, array( 'title' => 'Yet another test product' ) ) );
    //print_r( $client->products->delete( $product_id, true ) );
    //print_r( $client->products->get_count() );
    //print_r( $client->products->get_count( array( 'type' => 'simple' ) ) );
    //print_r( $client->products->get_categories() );
    //print_r( $client->products->get_categories( $category_id ) );
    // reports
    //print_r( $client->reports->get() );
    //print_r( $client->reports->get_sales( array( 'filter[date_min]' => '2014-07-01' ) ) );
    //print_r( $client->reports->get_top_sellers( array( 'filter[date_min]' => '2014-07-01' ) ) );
    // webhooks
    //print_r( $client->webhooks->get() );
    //print_r( $client->webhooks->create( array( 'topic' => 'coupon.created', 'delivery_url' => 'http://requestb.in/' ) ) );
    //print_r( $client->webhooks->update( $webhook_id, array( 'secret' => 'some_secret' ) ) );
    //print_r( $client->webhooks->delete( $webhook_id ) );
    //print_r( $client->webhooks->get_count() );
    //print_r( $client->webhooks->get_deliveries( $webhook_id ) );
    //print_r( $client->webhooks->get_delivery( $webhook_id, $delivery_id );
    // trigger an error
    //print_r( $client->orders->get( 0 ) );

} catch ( WC_API_Client_Exception $e ) {
    echo $e->getMessage() . PHP_EOL;
    echo $e->getCode() . PHP_EOL;
    if ( $e instanceof WC_API_Client_HTTP_Exception ) {
        print_r( $e->get_request() );
        print_r( $e->get_response() );
    }
}
?>