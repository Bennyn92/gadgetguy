<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

function custom_style_sheet() {
    wp_enqueue_style( 'maxStyle', get_stylesheet_directory_uri() . '/assets/css/maxStyle.css' );
}
add_action('wp_enqueue_scripts', 'custom_style_sheet');

//var_dump(get_stylesheet_directory_uri());
//echo  '<img class="svglogo" src="'.get_stylesheet_directory_uri() . '/images/gadgetguylogo_white.svg" >';

register_default_headers( array(
    'kami-logo' => array(
        'url'   => get_stylesheet_directory_uri() . '/images/gadgetguylogo_white.svg',
        'thumbnail_url' => get_stylesheet_directory_uri() . '/images/gadgetguylogo_white.svg',
        'description'   => __( 'Kami Logo', 'fun' )
    )
));

add_theme_support( 'custom-header', array(
    'default-image'   => get_stylesheet_directory_uri() . '/images/gadgetguylogo_white.svg',
    'width'           => 320,
    'height'          => 320,
    'header-selector' => '.site-title a',
    'header-text'     => false
) );



/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */


