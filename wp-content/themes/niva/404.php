<?php
/**
 * The template for displaying 404 pages (not found).
 *
 */

get_header(); ?>

<?php 
// Theme Init
$theme_init = new niva_init_class;
if($theme_init->niva_get_page_404_template_variant() == 'page_404_v1_center'){
	$alignment = 'text-center';
	$grid_class = 'col-md-12';
}elseif ($theme_init->niva_get_page_404_template_variant() == 'page_404_v2_right') {
	$alignment = 'text-center';
	$grid_class = 'col-md-8';
}

$sidebar_position = 'sidebar_position_left';

if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_left_sidebar') { 
    $sidebar_position = 'sidebar_position_left';
}

if ( niva('mt_blog_layout') != '' && niva('mt_blog_layout') == 'mt_blog_right_sidebar') { 
    $sidebar_position = 'sidebar_position_right';
}

?>

	<!-- Page content -->
	<div id="primary" class="content-area">
	    <main id="main" class="container blog-posts site-main <?php echo esc_attr($sidebar_position); ?>">
	        <div class="main-content">
				<section class="error-404 not-found">
					<header class="page-header-404">
						<div class="high-padding row">
							<?php if($theme_init->niva_get_page_404_template_variant() == 'page_404_v2_right'){ ?>
								<div class="col-md-4 sidebar-content">
									<?php get_sidebar(); ?>
								</div>
							<?php } ?>
							<div class="<?php echo esc_attr($grid_class); ?>">
								<h1 class="page-404-digits <?php echo esc_attr($alignment); ?>"><?php esc_html_e( '404', 'niva' ); ?></h1>
								<h2 class="page-title <?php echo esc_attr($alignment); ?>"><?php esc_html_e( 'Sorry, this page does not exist', 'niva' ); ?></h2>
								<h3 class="page-title <?php echo esc_attr($alignment); ?>"><?php esc_html_e( 'The link you clicked might be corrupted, or the page may have been removed.', 'niva' ); ?></h3>
								<div class="text-center"><?php get_search_form(); ?></div>
							</div>						
						</div>
					</header>
				</section>
			</div>
		</main>
	</div>

<?php get_footer(); ?>