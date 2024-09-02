jQuery(document).ready(function($) {
    // Función para actualizar el número de elementos en la badge
    function updateCartCount() {
        $.get(wooCartBadge.ajax_url, { action: 'woo_cart_badge_update_count' }, function(data) {
            console.log('Cart count received:', data); // Para depuración
            $('#woo-cart-badge .woo-cart-badge-count').text(data);

            // Mostrar u ocultar la badge dependiendo del conteo
            if (data > 0) {
                $('#woo-cart-badge').show(); // Mostrar la badge si hay artículos en el carrito
            } else {
                $('#woo-cart-badge').hide(); // Ocultar la badge si no hay artículos en el carrito
            }
        });
    }

    // Actualiza el número de elementos en la badge al cargar la página
    updateCartCount();

    // Redirige a la página del carrito cuando se hace clic en la badge
    $('#woo-cart-badge').on('click', function() {
        window.location.href = wooCartBadge.cart_url;
    });

    // Escucha eventos de actualización de carrito de WooCommerce
    $(document.body).on('added_to_cart removed_from_cart updated_cart_totals', function() {
        updateCartCount(); // Actualiza el conteo del carrito
    });
});
