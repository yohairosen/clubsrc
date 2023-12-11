<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
$class = "col-md-12";
?>

    <?php echo wp_kses_post(niva_header_title_breadcrumbs()); ?>
    <?php
        /**
         * woocommerce_before_main_content hook
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         */
        do_action( 'woocommerce_before_main_content' );
    ?>

        <!-- Page content -->
    <div class="nine-high-padding">
        <!-- Blog content -->
        <div class="container">
           <div class="row">

                <div class="<?php echo esc_attr($class); ?> main-content">

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php wc_get_template_part( 'content', 'single-product' ); ?>

                <?php endwhile; // end of the loop. ?>

                </div>

            </div>
        </div>
    </div>

    <?php
        /**
         * woocommerce_after_main_content hook
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action( 'woocommerce_after_main_content' );
    ?>

<?php get_footer( 'shop' ); ?>
