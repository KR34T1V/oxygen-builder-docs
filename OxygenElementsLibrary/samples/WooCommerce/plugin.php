<?php
/**
 * Plugin Name: Oxygen Elements for WooCommerce
 * Author: Soflyy
 * Author URI: https://oxygenbuilder.com
 * Description: Build beautiful WooCommerce websites.
 * Version: 2.0
 */

require_once("admin/includes/updater/edd-updater.php");
define("CT_OXYGEN_WOOCOMMERCE_VERSION", "2.0");

/**
 * Initializes the Oxygen Elements for WooCommerce plugin.
 * This function is hooked to the 'plugins_loaded' action.
 */
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

    // Define constants for assets path and settings icons
    define("OXY_WOO_ASSETS_PATH", plugins_url("elements/assets", __FILE__));
    define("OXY_WOO_SETTINGS_ICONS", plugins_url("icons", __FILE__));

    // Hook a filter to override WooCommerce template files
    add_filter('woocommerce_locate_template', 'oxy_woo_template_overrides', 1, 3);

    // Require the necessary files for Oxygen WooCommerce functionality
    require_once('OxyWooEl.php');
    require_once('OxyWooCommerce.php');
    require_once('OxyWooConditions.php');

    // Instantiate the OxyWooCommerce and OxyWooConditions classes
    $OxyWooCommerce = new OxyWooCommerce();
    $OxyWooConditions = new OxyWooConditions();
}

/**
 * Overrides the WooCommerce template files with Oxygen-specific templates.
 *
 * @param string $template - The template path and name.
 * @param string $template_name - The template name.
 * @param string $template_path - The template path.
 * @return string - The modified template path.
 */
function oxy_woo_template_overrides($template, $template_name, $template_path) {
    global $woocommerce;
    $_template = $template;

    if (!$template_path) {
        $template_path = $woocommerce->template_url;
    }

    $template_path = WP_CONTENT_DIR . '/oxywoocotemplates/woocommerce/';

    // Look within passed path within the theme - this is priority
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

// The provided code is a WordPress plugin file for "Oxygen Elements for WooCommerce." Here's a breakdown of the code:

// The plugin registers a custom action hook plugins_loaded to initialize the Oxygen Elements for WooCommerce plugin.
// The function oxygen_woocommerce_init() is hooked to the plugins_loaded action and performs the following tasks:
// Checks if the WooCommerce and Oxygen plugins are installed and active. If not, the function returns early.
// Defines constants for the assets path and settings icons of the Oxygen Elements for WooCommerce.
// Hooks a filter to override WooCommerce template files using the woocommerce_locate_template filter.
// Requires the necessary files for Oxygen WooCommerce functionality.
// Instantiates the OxyWooCommerce and OxyWooConditions classes.
// The oxy_woo_template_overrides() function is used to override WooCommerce template files with Oxygen-specific templates.
