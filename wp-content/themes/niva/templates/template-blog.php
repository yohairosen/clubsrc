<?php
/*
* Template Name: Blog
*/


get_header(); 


$class = "";

if ( niva('mt_blog_layout') == 'mt_blog_fullwidth' ) {
    $class = "col-md-12";
}elseif ( niva('mt_blog_layout') == 'mt_blog_right_sidebar' or niva('mt_blog_layout') == 'mt_blog_left_sidebar') {
    $class = "col-md-8";
}
$breadcrumbs_on_off = get_post_meta( get_the_ID(), 'breadcrumbs_on_off', true );
$blog_page_header = get_post_meta( get_the_ID(), 'blog_page_header', true );

$sidebar = $niva['mt_blog_layout_sidebar'];

// Theme Init
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
<?php // echo niva_header_title_breadcrumbs(); ?>


<!-- Page content -->

    <?php
    wp_reset_postdata();
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $args = array(
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'paged'            => $paged,
    );
    $posts = new WP_Query( $args );
    ?>
    <!-- Blog content -->
    <div class="container blog-posts high-padding <?php echo esc_attr($sidebar_position); ?>">
        
        <div class="row">

            <?php if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_left_sidebar') { ?>
                    <div class="col-md-4 sidebar-content"><?php  dynamic_sidebar( $sidebar ); ?></div>
            <?php } ?>

            <div class="<?php echo esc_attr($class); ?> main-content">

            <?php if ( $posts->have_posts() ) : ?>
                <?php /* Start the Loop */ ?>
                <div class="row">

                    <?php /* Start the Loop */ ?>
                    <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                        <?php /* Loop - Variant 1 */ ?>
                        <?php get_template_part( 'content', 'blogloop-v5' ); ?>
                    <?php endwhile; ?>

                </div>
            <?php else : ?>
                <?php get_template_part( 'content', 'none' ); ?>
            <?php endif; ?>
            
            <div class="clearfix"></div>

            <?php 
            $wp_query = new WP_Query($args);
            global  $wp_query;
            if ($wp_query->max_num_pages != 1) { ?>                
            <div class="modeltheme-pagination-holder col-md-12">           
                <div class="modeltheme-pagination pagination">           
                    <?php the_posts_pagination(); ?>
                </div>
            </div>
            <?php } ?>
            </div>

            <?php if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_right_sidebar') { ?>
                <div class="col-md-4 sidebar-content"><?php  dynamic_sidebar( $sidebar ); ?></div>
            <?php } ?>

        </div>
    </div>


<?php
get_footer();
?>