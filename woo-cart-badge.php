<?php
/*
Plugin Name: WooCommerce Cart Badge
Description: Muestra una badge en la parte inferior derecha con el número de elementos en el carrito de WooCommerce.
Version: 1.0
Author: Álvaro Rosado González
Author URI: https://github.com/aLVaRoZz01
*/

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    // Añade los scripts y estilos necesarios
    function woo_cart_badge_enqueue_scripts() {
        wp_enqueue_style('woo-cart-badge-style', plugins_url('/woo-cart-badge.css', __FILE__));
        wp_enqueue_script('woo-cart-badge-script', plugins_url('/woo-cart-badge.js', __FILE__), array('jquery'), '', true);

        // Pasa el URL del carrito y la URL de AJAX a JavaScript
        wp_localize_script('woo-cart-badge-script', 'wooCartBadge', array(
            'cart_url' => wc_get_cart_url(),
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
    add_action('wp_enqueue_scripts', 'woo_cart_badge_enqueue_scripts');

    // Añade el HTML de la badge
    function woo_cart_badge_html() {
        ?>
        <div id="woo-cart-badge" style="display: none;">
            <span class="woo-cart-badge-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
  					<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
				</svg>
			</span>
            <span class="woo-cart-badge-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </div>
        <?php
    }
    add_action('wp_footer', 'woo_cart_badge_html');

    // Actualiza el número de elementos en el carrito con Ajax
    function woo_cart_badge_update_count() {
        echo WC()->cart->get_cart_contents_count();
        wp_die(); // Termina correctamente la ejecución de la función
    }
    add_action('wp_ajax_woo_cart_badge_update_count', 'woo_cart_badge_update_count');
    add_action('wp_ajax_nopriv_woo_cart_badge_update_count', 'woo_cart_badge_update_count');
}