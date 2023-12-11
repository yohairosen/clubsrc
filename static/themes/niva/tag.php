<?php

/**

 * The template for displaying tags results pages.

 *

 */



get_header(); 



$class_row = "col-md-8";

if ( niva('mt_blog_layout') == 'mt_blog_fullwidth' ) {

    $class_row = "col-md-12";

}elseif ( niva('mt_blog_layout') == 'mt_blog_right_sidebar' or niva('mt_blog_layout') == 'mt_blog_left_sidebar') {

    $class_row = "col-md-8";

}

$sidebar = niva('mt_blog_layout_sidebar');





// theme_ini

$theme_init = new niva_init_class;

$sidebar_position = 'sidebar_position_left';

if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_left_sidebar') { 
    $sidebar_position = 'sidebar_position_left';
}

if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_right_sidebar') { 
    $sidebar_position = 'sidebar_position_right';
}

?>



    <!-- HEADER TITLE BREADCRUBS SECTION -->

    <?php echo niva_header_title_breadcrumbs(); ?>



    <!-- Page content -->

    <div class="high-padding">

        <!-- Blog content -->

        <div class="container blog-posts <?php echo esc_attr($sidebar_position); ?>">

            <div class="row">



                <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>

                    <?php if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_left_sidebar') { ?>

                        <?php if (is_active_sidebar($sidebar)) { ?>

                            <div class="col-md-4 sidebar-content"><?php  dynamic_sidebar( $sidebar ); ?></div>

                        <?php } ?>

                    <?php } ?>

                    <?php }else{ ?>

                        <div class="col-md-4 sidebar-content">

                            <?php get_sidebar(); ?>

                        </div>

                <?php } ?>



                <div class="<?php echo esc_attr($class_row); ?> main-content">

                <?php if ( have_posts() ) : ?>

                        <?php /* Start the Loop */ ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php /* Loop - Variant 1 */ ?>

                            <?php get_template_part( 'content', 'blogloop-v5' ); ?>

                        <?php endwhile; ?>



                        <div class="sweetthemes-pagination-holder col-md-12">             

                            <div class="sweetthemes-pagination pagination">             

                                <?php the_posts_pagination(); ?>

                            </div>

                        </div>


                <?php else : ?>

                    <?php get_template_part( 'content', 'none' ); ?>

                <?php endif; ?>

                </div>



                <?php if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_right_sidebar') { ?>

                    <?php if (is_active_sidebar($sidebar)) { ?>

                        <div class="col-md-4 sidebar-content">

                            <?php dynamic_sidebar( $sidebar ); ?>

                        </div>

                    <?php } ?>

                <?php } ?>

            </div>

        </div>

    </div>

<?php get_footer(); ?>