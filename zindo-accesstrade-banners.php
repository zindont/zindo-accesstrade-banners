<?php
/**
 * @package Accesstrade.vn Banners by Ân
 * @version 1.0.0
 */
/*
Plugin Name: Accesstrade.vn Banners by Ân
Plugin URI: http://sieukhuyenmai.xyz/
Description: Widget load banner khuyến mãi từ accesstrade
Author: Ân Đẹp Trai
Text Domain: zindo-accesstrade-banners
Version: 1.0.0
Author URI: http://zindo.info/
*/

// don't load directly 

if ( !defined('ABSPATH') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

require_once 'Zindo_Accesstrade_Banners.widget.class.php';

// Register Widget
function zindo_accesstrade_banners_register_widget() {
    register_widget( 'Zindo_Accesstrade_Banners' );
}
add_action( 'widgets_init', 'zindo_accesstrade_banners_register_widget' );

// Register ajax
function zindo_accesstrade_banners_ajax_get_promotions()
{
    $widget_name = htmlentities($_GET['widget_name'], ENT_QUOTES);
    $widget_id = htmlentities($_GET['widget_id'], ENT_QUOTES);

    $widget_instances = get_option('widget_' . $widget_name);
    $widget = $widget_instances[$widget_id];

    $access_key = $widget['access_key'];
	$offer_id = $widget['offer_id'];
	
    header('Content-Type: application/json');
    header("Cache-Control: max-age=31536000");

	$context = stream_context_create(array(
	    'http' => array(
	        'header'  => "Authorization: Token " . $access_key
	    )
	));

    $promotions = file_get_contents('https://api.accesstrade.vn/v1/offers_informations?scope=public&merchant='.$offer_id, false, $context);
    echo $promotions;

    wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_zindo_masoffer_auto_banner_ajax_get_promotions', 'zindo_accesstrade_banners_ajax_get_promotions' );
add_action( 'wp_ajax_nopriv_zindo_masoffer_auto_banner_ajax_get_promotions', 'zindo_accesstrade_banners_ajax_get_promotions' );