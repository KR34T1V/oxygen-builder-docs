<?php
/**
 * Class OxyWooEl
 *
 * This class extends the OxyEl class and provides additional functionality related to WooCommerce.
 */
class OxyWooEl extends OxyEl {
    /**
     * Initialization method
     *
     * This method initializes the class by setting the assets path and enabling AJAX controls.
     */
    function init() {
        $this->El->useAJAXControls();
        $this->setAssetsPath( OXY_WOO_ASSETS_PATH );
    }

    /**
     * Render method
     *
     * This method is responsible for rendering the element based on the provided options, defaults, and content.
     *
     * @param array $options The options for rendering the element.
     * @param array $defaults The default values for the element options.
     * @param string $content The content to be rendered within the element.
     */
    function render($options, $defaults, $content) {
        if (method_exists($this, 'wooTemplate')) {
            global $product;
            $product = wc_get_product();

            if ($product != false) {
                // Call the wooTemplate method defined in the extending class
                call_user_func($this->wooTemplate());
            }
        }
    }

    /**
     * Get class names
     *
     * This method returns an array of class names associated with the OxyWooEl element.
     *
     * @return array An array of class names.
     */
    function class_names() {
        return array('oxy-woo-element');
    }

    /**
     * Get WooCommerce button place
     *
     * This method returns the position where the WooCommerce button should be placed.
     *
     * @return string The button place value.
     */
    function woo_button_place() {
        return "other";
    }

    /**
     * Get button place
     *
     * This method determines the final button place value for the element.
     *
     * @return string The final button place value.
     */
    function button_place() {
        $woo_button_place = $this->woo_button_place();

        if ($woo_button_place) {
            return "woo::" . $woo_button_place;
        }

        return "";
    }
}
