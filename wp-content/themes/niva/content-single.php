<?php
/**
* Content Single
*/
$prev_post = get_previous_post();
$next_post = get_next_post();

$breadcrumbs_on_off = get_post_meta( get_the_ID(), 'breadcrumbs_on_off', true );
?>


<!-- HEADER TITLE BREADCRUBS SECTION -->
<?php 
if ( function_exists('sweetthemes_framework')) {
    if (isset($breadcrumbs_on_off) && $breadcrumbs_on_off == 'yes' || $breadcrumbs_on_off == '') {
        echo niva_header_title_breadcrumbs();
    }
}else{
    echo wp_kses_post(niva_header_title_breadcrumbs());
}

// BEGIN_WP5
$select_post_layout = get_post_meta( get_the_ID(), 'select_post_layout', true );
$select_post_sidebar = get_post_meta( get_the_ID(), 'select_post_sidebar', true );
$sidebar = 'sidebar-1';
if ( function_exists('sweetthemes_framework')) {
    if (isset($select_post_sidebar) && $select_post_sidebar != '') {
        $sidebar = $select_post_sidebar;
    }else{
        $sidebar = niva('mt_single_blog_layout_sidebar');
    }
}
$cols = 'col-md-12 col-sm-12';
$sidebars_lr_meta = array("left-sidebar", "right-sidebar");
if (isset($select_post_layout) && in_array($select_post_layout, $sidebars_lr_meta)) {
    $cols = 'col-md-8 col-sm-8 status-meta-sidebar';
}elseif(isset($select_post_layout) && $select_post_layout == 'no-sidebar'){
    $cols = 'col-md-12 col-sm-12 status-meta-fullwidth';
}else{
    if(class_exists( 'ReduxFrameworkPlugin' )){
        $sidebars_lr_panel = array("mt_single_blog_left_sidebar", "mt_single_blog_right_sidebar");
        if (in_array(niva('mt_single_blog_layout'), $sidebars_lr_panel)) {
            $cols = 'col-md-8 col-sm-8 status-panel-sidebar';
        }else{
            $cols = 'col-md-12 col-sm-12 status-panel-no-sidebar';
        }
    }
}
if (!is_active_sidebar($sidebar)) {
    $cols = "col-md-12";
}

$sidebar_position = '';

if (isset($select_post_layout) && $select_post_layout == 'left-sidebar') { ?>
    <?php $sidebar_position = 'sidebar_position_left'; ?>
<?php }else{ ?>
    <?php if (isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
        <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
            <?php if ( niva('mt_single_blog_layout') == 'mt_single_blog_left_sidebar') { ?>
                <?php $sidebar_position = 'sidebar_position_left'; ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
<?php } 

if (isset($select_post_layout) && $select_post_layout == 'right-sidebar') { ?>
    <?php $sidebar_position = 'sidebar_position_right'; ?>
<?php }else{ ?>
    <?php if (isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
        <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
            <?php if ( niva('mt_single_blog_layout') == 'mt_single_blog_right_sidebar') { ?>
                <?php $sidebar_position = 'sidebar_position_right'; ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
<?php } ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post high-padding'); ?>>
    <div class="container <?php echo esc_attr($sidebar_position); ?>">
       <div class="row">


            <?php // BEGIN_WP5 ?>
            <?php if (isset($select_post_layout) && $select_post_layout == 'left-sidebar') { ?>
                <div class="col-md-4 col-sm-4 sidebar-content sidebar-left">
                    <?php if (is_active_sidebar($sidebar)) { ?>
                        <?php dynamic_sidebar($sidebar); ?>
                    <?php } ?>
                </div>
            <?php }else{ ?>
                <?php if (isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
                    <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
                        <?php if ( niva('mt_single_blog_layout') == 'mt_single_blog_left_sidebar') { ?>
                            <div class="col-md-4 col-sm-4 sidebar-content sidebar-left">
                                <?php if (is_active_sidebar($sidebar)) { ?>
                                    <?php dynamic_sidebar($sidebar); ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php // END_WP5 ?>

            <!-- POST CONTENT -->
            <div class="<?php echo esc_attr($cols); ?> main-content">
                <div class="thumbnail-single">
                    <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'niva_blog_900x550' ); 
                            if($thumbnail_src) { ?>
                                <?php the_post_thumbnail( 'niva_blog_900x550' ); ?>
                            <?php } ?>
                </div>
                <div class="article-content-single">
                <!-- HEADER -->
                <div class="article-header">
                    <div class="article-details">

                        
                        <div class="clearfix"></div>

                        <div class="post-category-comment-date">
                            <span class="post-categories">
                                <?php echo wp_kses_post(get_the_term_list( get_the_ID(), 'category', '<i class="fa fa-folder-open"></i> ', ', ' )); ?> 
                            </span>
                        </div>

                        <h1 class="post-title">
                            <?php echo esc_html(get_the_title()); ?>
                        </h1>

                        <div class="post-category-comment-date">
                            <span class="post-date">
                                <i class="fa fa-calendar"></i> <?php echo esc_html(get_the_date()); ?>
                            </span>
                            <span>-</span>
                            <span class="post-author"><?php esc_html_e('by ', 'niva') ?>
                                <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php echo get_the_author(); ?></a>
                            </span>
                        </div>          

                    </div>
                </div>
                <!-- CONTENT -->
                <div class="article-content">
                    <?php the_content(); ?>
                    <div class="clearfix"></div>

                    <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'niva' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                    <div class="clearfix"></div>


                    <div class="row">
                        <?php $single_post_tags_column = '';
                        if ( function_exists('sweetthemes_framework')) { 
                            $single_post_tags_column = 'col-md-8';
                        } else { 
                            $single_post_tags_column = 'col-md-12';
                        } ?>    
                        <?php $tags_cls = ''; ?>            
                        <?php if (get_the_tags()) { ?>
                            <div class="post-tags-single <?php echo esc_attr($single_post_tags_column); ?>">
                                 <?php echo wp_kses_post(get_the_tag_list('<i class="fa fa-tag"></i> ',', ',' ')); ?>
                            </div>
                        <?php } else {
                            $tags_cls = 'no-tags-cls';
                        }?>

                        <?php if ( function_exists('sweetthemes_framework')) { ?>
                            <div class="single-post-share col-md-4 <?php echo esc_attr($tags_cls); ?>">
                                <span class="share"><?php echo esc_html__('Share','niva'); ?></span>                         
                                <?php echo do_shortcode('[st_sharer tooltip_placement="top"]'); ?> 
                            </div> 
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div>

                    <!-- COMMENTS -->
                    <?php
                        // If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                    ?>
                </div>

                </div>              
                <?php echo wp_kses_post(niva_post_nav()); ?>
            </div>

            <?php // BEGIN_WP5 ?>
                <?php if(class_exists( 'ReduxFrameworkPlugin' )){ ?>
                    <?php if (isset($select_post_layout) && $select_post_layout == 'right-sidebar') { ?>
                        <div class="col-md-4 sidebar-content sidebar-right">
                            <?php if (is_active_sidebar($sidebar)) { ?>
                                <?php dynamic_sidebar($sidebar); ?>
                            <?php } ?>
                        </div>
                    <?php }elseif(isset($select_post_layout) && $select_post_layout == 'inherit') { ?>
                        <?php if ( niva('mt_single_blog_layout') == 'mt_single_blog_right_sidebar') { ?>
                            <div class="col-md-4 sidebar-content sidebar-right">
                                <?php if (is_active_sidebar($sidebar)) { ?>
                                    <?php dynamic_sidebar($sidebar); ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                <?php } ?>
            <?php // END_WP5 ?>
            <?php } ?>       
        </div>
    </div>
</article>


