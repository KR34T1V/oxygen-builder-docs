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

// This PHP code represents a WordPress plugin called "Oxygen Elements for WooCommerce." The plugin adds additional functionality to WooCommerce, specifically when used with the Oxygen Builder. Here's a breakdown of the code:
// The plugin information is defined using comments. It includes the name, author, author URI, description, and version of the plugin.
// The code includes the EDD updater file using require_once to enable easy updates for the plugin.
// A constant CT_OXYGEN_WOOCOMMERCE_VERSION is defined to store the plugin version.
// The oxygen_woocommerce_init function is hooked into the plugins_loaded action. It serves as the initialization function for the Oxygen WooCommerce plugin.
// Inside the oxygen_woocommerce_init function, two checks are performed:
// First, it checks if the WooCommerce plugin is installed and active by verifying the existence of the WooCommerce class. If it's not active, the function returns and the plugin initialization is halted.
// Second, it checks if the Oxygen plugin is installed and active by verifying the existence of the OxygenElement class. If it's not active, the function returns and the plugin initialization is halted.
// Two constants, OXY_WOO_ASSETS_PATH and OXY_WOO_SETTINGS_ICONS, are defined to store the paths to the plugin's assets and icons.
// The woocommerce_locate_template filter is added to override WooCommerce template files. It calls the oxy_woo_template_overrides function when locating a template file.
// The plugin requires three additional files: OxyWooEl.php, OxyWooCommerce.php, and OxyWooConditions.php. These files likely contain additional classes and functions specific to the Oxygen WooCommerce integration.
// The OxyWooCommerce and OxyWooConditions classes are instantiated to utilize their respective functionalities.
// The oxy_woo_template_overrides function is defined to handle the override of WooCommerce template files. It receives the template file, template name, and template path as arguments.
// Inside the function, the global $woocommerce variable is accessed to get the WooCommerce template URL.
// The $template_path variable is set to the path where the overridden templates are stored (WP_CONTENT_DIR . '/oxywoocotemplates/woocommerce/').
// The function attempts to locate the template file by checking if it exists within the passed path and template name using locate_template(). If found, it sets the $template variable to the located template file.
// If the template file is still not found, it checks if the file exists directly in the template path and sets the $template variable accordingly.
// If no template file is found, the original template file path ($_template) is used.
// Finally, the function returns the selected template file.
