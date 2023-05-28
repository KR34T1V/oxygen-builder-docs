<?php
/*
Plugin Name: Oxygen Elements for WooCommerce
Author: Soflyy
Author URI: https://oxygenbuilder.com
Description: Build beautiful WooCommerce websites.
Version: 2.0
*/

// Include the EDD updater file
require_once("admin/includes/updater/edd-updater.php");

// Define the plugin version
define("CT_OXYGEN_WOOCOMMERCE_VERSION", "2.0");

// Hook into the 'plugins_loaded' action and initialize the Oxygen WooCommerce plugin
add_action('plugins_loaded', 'oxygen_woocommerce_init');

function oxygen_woocommerce_init() {
    // Check if WooCommerce is installed and active
    if (!class_exists('WooCommerce')) {
        return;
    }

    // Check if Oxygen is installed and active
    if (!class_exists('OxygenElement')) {
        return;
    }

    // Define constants for assets and icons paths
    define("OXY_WOO_ASSETS_PATH", plugins_url("elements/assets", __FILE__));
    define("OXY_WOO_SETTINGS_ICONS", plugins_url("icons", __FILE__));

    // Add a filter to override WooCommerce template files
    add_filter('woocommerce_locate_template', 'oxy_woo_template_overrides', 1, 3);

    // Require necessary files
    require_once('OxyWooEl.php');
    require_once('OxyWooCommerce.php');
    require_once('OxyWooConditions.php');

    // Initialize the OxyWooCommerce and OxyWooConditions classes
    $OxyWooCommerce = new OxyWooCommerce();
    $OxyWooConditions = new OxyWooConditions();
}

// Function to override WooCommerce template files
function oxy_woo_template_overrides($template, $template_name, $template_path) {
    global $woocommerce;
    $_template = $template;

    if (!$template_path) {
        $template_path = $woocommerce->template_url;
    }

    $template_path = WP_CONTENT_DIR . '/oxywoocotemplates/woocommerce/';

    // Look for the template file within the passed path and the template name
    $template = locate_template(
        array(
            $template_path . $template_name,
            $template_name
        )
    );

    if (!$template && file_exists($template_path . $template_name)) {
        $template = $template_path . $template_name;
    }

    if (!$template) {
        $template = $_template;
    }

    return $template;
}
