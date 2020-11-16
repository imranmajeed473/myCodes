<?php 
add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);
function salient_child_enqueue_styles() {
  $nectar_theme_version = nectar_get_theme_version();
  wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
    if ( is_rtl() ) {
     wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
  }
}

// menu right
function register_my_menus() {
  register_nav_menus(
    array(
      'newmenu1' => __( 'NewMenu1' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );

// new custom widget
function wpb_widgets_init() {
 register_sidebar( array(
  'name' => 'New Widget 1',
  'id' => 'newwidget1',
  'before_widget' => '<div id="newwidget1" class="newwidget1 lang-us">',
  'after_widget' => '</div>',
 ) );
}
add_action( 'widgets_init', 'wpb_widgets_init' );


// header
add_action('wp_head', 'googlefontfn');
function googlefontfn(){
?>
<style>
/*
font-family:"Gilroy";
font-family: "Galano Grotesque";
font-family: "Mont";
*/
@font-face {
    font-family: 'Gilroy';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/gilroy-extrabold-webfont.woff2') format('woff2'),
         url('<?php get_stylesheet_directory_uri(); ?>/fonts/gilroy-extrabold-webfont.woff') format('woff');
}
@font-face {
    font-family: 'Galano Grotesque';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/galanogrotesquedemo-bold-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/galanogrotesquedemo-bold-webfont.woff') format('woff');
}
@font-face {
    font-family: 'Gilroy';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/gilroy-extrabold-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/gilroy-extrabold-webfont.woff') format('woff');
}
@font-face {
    font-family: 'Gilroy';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/gilroy-light-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/gilroy-light-webfont.woff') format('woff');
    font-weight: 300;

}
@font-face {
    font-family: 'Mont';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/mont-extralightdemo-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/mont-extralightdemo-webfont.woff') format('woff');
    font-weight: 200;
}
@font-face {
    font-family: 'Mont';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/mont-heavydemo-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/mont-heavydemo-webfont.woff') format('woff');
}
@font-face {
    font-family: 'Galano Grotesque alt';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/rene_bieder_-_galano_grotesque_alt_demo_bold-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/rene_bieder_-_galano_grotesque_alt_demo_bold-webfont.woff') format('woff');
}
@font-face {
    font-family: 'Galano Grotesque _demobold';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/rene_bieder_-_galano_grotesque_demo_bold-webfont.woff2') format('woff2'),
         url('<?php echo get_stylesheet_directory_uri(); ?>/fonts/rene_bieder_-_galano_grotesque_demo_bold-webfont.woff') format('woff');
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<?php
}

// footer
/*add_action('wp_footer', 'myfnfooter');
function myfnfooter(){
  ?>
  <script type="text/javascript">
    jQuery( document ).ready(function() {
      jQuery('.addlineshtml').each(function(index, value){
        jQuery(this).append('<ul class="lineshtml"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>');
      });
    });
  </script>
  <?php
}*/



//allow empty tag line <i class="fa fa-facebook"></i>
add_filter('tiny_mce_before_init', 'override_mce_options');
function override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
} 

// contactform7 remove br tags
add_filter( 'wpcf7_autop_or_not', '__return_false' );



// [productoffset offset=0 product_cat='']
add_shortcode( 'productoffset', 'productoffset_fn' );
function productoffset_fn( $atts ){
  global $post;
  // Attributes
  $atts = shortcode_atts(
   array(
    'type'      => 'post',
    'post_type'   => 'product',
    'product_cat' => '',
    'offset'   => 0,
    'status'    => 'publish',
    'posts_per_page'=>1,
    // 'orderby' => 'menu_order',
    // 'sort_order' => 'ASC',
   ),$atts,'productoffset');
  $posts = get_posts( $atts );
  if( count($posts) ):
  $return = '';
    foreach( $posts as $post ): 
        setup_postdata( $post );
        $product = wc_get_product( $post->ID );
        $return .= '<div class="productmain offset'.$atts['offset'].'">';
        $return .= '<div class="desc">';
        // $return .= '<h3>'.$product->get_name().'</h3>';
        $return .= '<a href="'.$product->get_slug().'"><h3>'.$product->get_name().'</h3></a>';
        if ($product->get_sale_price()) {
          $return .= '<span class="sprice"><del>$'.$product->get_regular_price().'</del> $'.$product->get_sale_price().'</span>';
        } else {
          $return .= '<span class="price">$'.$product->get_price().'</span>';
        }
        // $return .= '<p class="sdesc">'.$product->get_short_description().'</p>';
        // $add_to_cart = do_shortcode('[add_to_cart_url id="'.$post->ID.'"]');
        $return .= '<a href="?add-to-cart='.$post->ID.'" class="add_to_cart_button ajax_add_to_cart" data-product_id="'.$post->ID.'" ><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>';
        $addtowishlist = do_shortcode('[yith_wcwl_add_to_wishlist product_id="'.$post->ID.'" product_added_text="" wishlist_url="" label="" browse_wishlist_text="" already_in_wishslist_text="" product_added_text=""]');
        $return .=  $addtowishlist;
        //$return .=  $product->short_description;
        $return .= '</div>';
        $return .= '<div class="image">';
        // $return .= get_the_post_thumbnail( $_post->ID, 'full' );
        $return .= get_the_post_thumbnail( $_post->ID );
        $return .= '</div>';
        $return .= '</div>';
     endforeach; 
    wp_reset_postdata();
  //$return .= '';
  else :
    $return .= '';//'<p>No posts found.</p>';
  endif;
return $return;
}

// after tab
add_action( 'woocommerce_after_single_product_summary', 'product_custom_content', 10);
function product_custom_content() {
    echo '<div class="span_12 col col_last wpb_text_column wpb_content_element  shippingtext"> <div class="wpb_wrapper"> <h5>ORDER QUANTITY 100 PCS &amp; MORE GET 30% DISCOUNT</h5> <p><strong>ITEM LESS THEN $10.00 SHIPPING $2, $10 items or more $3.50</strong></p> </div> </div>';
}


// define the woocommerce_after_shop_loop_item_title callback 
//function action_woocommerce_after_shop_loop_item_title(  ) { 
//    echo get_the_ID();
//}; 
//add_action( 'woocommerce_after_shop_loop_item_title', 'action_woocommerce_after_shop_loop_item_title', 10, 0 ); 


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
?>
