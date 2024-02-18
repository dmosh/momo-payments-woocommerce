<?php
/**
 * Plugin Name: Synced Payments WooCommerce Gateway
 * Plugin URI: http://syncedtek.ga
 * Author: Epuret Moses Obuya
 * Author URI: http://syncedtek.ga
 * Description: Synced Payments Gateway for WordPress.
 * Version: 0.1.0
 * License: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: synced-payments-woo
 * 
 * Class WC_Gateway_synced file.
 *
 * @package WooCommerce\synced
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;

add_action( 'plugins_loaded', 'synced_payment_init', 11 );
add_filter( 'woocommerce_currencies', 'synced_add_ugx_currencies' );
add_filter( 'woocommerce_currency_symbol', 'synced_add_ugx_currencies_symbol', 10, 2 );
add_filter( 'woocommerce_payment_gateways', 'add_to_woo_synced_payment_gateway');

function synced_payment_init() {
    if( class_exists( 'WC_Payment_Gateway' ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-wc-payment-gateway-synced.php';
		require_once plugin_dir_path( __FILE__ ) . '/includes/synced-order-statuses.php';
		require_once plugin_dir_path( __FILE__ ) . '/includes/synced-checkout-description-fields.php';
	}
}

function add_to_woo_synced_payment_gateway( $gateways ) {
    $gateways[] = 'WC_Gateway_synced';
    return $gateways;
}

function synced_add_ugx_currencies( $currencies ) {
	$currencies['UGX'] = __( 'Ugandan Shillings', 'synced-payments-woo' );
	return $currencies;
}

function synced_add_ugx_currencies_symbol( $currency_symbol, $currency ) {
	switch ( $currency ) {
		case 'UGX': 
			$currency_symbol = 'UGX'; 
		break;
	}
	return $currency_symbol;
}
