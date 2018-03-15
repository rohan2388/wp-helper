<?php
namespace RD\WP;

/**
 * Define constants
 */

if ( ! defined( RDWP_RDH_TEMPLATES ) ) {
    define( "RDWP_RDH_TEMPLATES", get_template_directory() . '/templates' );
}



/**
 * Helper functions
 *
 * css_stringify:
 * inline_styles:
 *      Array to css string
 * classes:
 *      Array of html class to string
 *
 *
 */
class WC {

    /**
     * Return product image source
     * @param   integer     $product_id     default: get_the_id()
     * @param   string      $size           default: full
     * @param   boolean     $source         return image url, width and height array if true. default: false
     * @return  mixed
     */
    static function get_product_image( $product_id = null, $size = "full", $source = false ) {
        if ( ! $product_id ) {
            $product_id = get_the_ID();
        }
        if ( $source ) {
            return wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
        }
        return wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size )[0];
    }

    /**
     * Get shop page url
     * @return  string  URL
     */
    static function shop_url() {
        if ( function_exists( 'wc_get_page_id' ) ) {
            return esc_url( get_permalink( wc_get_page_id( 'shop' ) ) );
        }
        return "";
    }

    /**
     * Get account page url
     * @return  string  URL
     */
    static function account_url() {
        if ( function_exists( 'wc_get_page_id' ) ) {
            return esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );
        }
        return "";
    }

    /**
     * Get cart page url
     * @return  string  URL
     */
    static function cart_url() {
        if ( function_exists( 'wc_get_page_id' ) ) {
            return esc_url( get_permalink( wc_get_page_id( 'cart' ) ) );
        }
        return "";
    }

    /**
     * Get checkout page url
     * @return  string  URL
     */
    static function checkout_url() {
        if ( function_exists( 'wc_get_page_id' ) ) {
            return esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) );
        }
        return "";
    }

}
