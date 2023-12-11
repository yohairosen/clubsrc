<?php
/**
 * The template for displaying the footer.
 *
*/
?>

    <?php if ( !class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <!-- BACK TO TOP BUTTON -->
        <a class="back-to-top sweetthemes-is-visible sweetthemes-fade-out" href="<?php echo esc_url('#0'); ?>">
            <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
        </a>
    <?php } else { ?>
        <?php if (niva('mt_backtotop_status') == true) { ?>
            <!-- BACK TO TOP BUTTON -->
            <a class="back-to-top sweetthemes-is-visible sweetthemes-fade-out" href="<?php echo esc_url('#0'); ?>">
                <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
            </a>
        <?php } ?>
    <?php } ?>


    <!-- FOOTER -->
    <?php $theme_init = new niva_init_class; ?>
    <footer class="<?php echo esc_attr($theme_init->niva_get_footer_variant()); ?>">

        <!-- FOOTER TOP -->
        <div class=" footer-top">
            <div class="container">
            <?php          
                //FOOTER ROW #1
                echo wp_kses_post(niva_footer_row1());
                //FOOTER ROW #2
                echo wp_kses_post(niva_footer_row2());
                //FOOTER ROW #3
                echo wp_kses_post(niva_footer_row3());
             ?>
            </div>
        </div>

        <!-- FOOTER BOTTOM -->
        <div class=" footer-div-parent">
            <div class="footer">
                <div class="container">
                	<p class="copyright text-center">
                        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                            <?php echo wp_kses_post(niva('mt_footer_text')); ?>
                        <?php }else{ ?>
                            <?php echo esc_html__('Niva by Sweet-Themes. 2021 All Rights Reserved.', 'niva'); ?>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>



<?php wp_footer(); ?>
</body>
</html>