<?php
add_action( 'woocommerce_after_shop_loop_item_title', 'wc_add_long_description' );
/**
 * WooCommerce, Add Long Description to Products on Shop Page
 *
 * @link https://wpbeaches.com/woocommerce-add-short-or-long-description-to-products-on-shop-page
 */
function wc_add_long_description() {
	global $product;

	?>
        <div itemprop="description">
            <?php echo apply_filters( 'the_content', $product->post->post_content ) ?>
        </div>
	<?php
}
