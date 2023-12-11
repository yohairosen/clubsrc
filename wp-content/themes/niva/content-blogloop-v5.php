<?php 
// BLOGLOOP-V2

// THUMBNAIL
$post_img = '';
$feature_img = '';
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'niva_blog_900x550' );
if ($thumbnail_src) {
    $post_img = '<img class="blog_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.the_title_attribute('echo=0').'" />';
    $feature_img = '';
}else{
    $feature_img = 'no-featured-image';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post col-md-12 list-view blogloop-v2 blogloop-no-flex'); ?> > 
    <div class="blog_custom <?php echo esc_attr($feature_img); ?>">
        
        <?php /*POST THUMBNAIL*/ ?>
        <?php if ($post_img) { ?>
            <!-- POST THUMBNAIL -->
            <div class="post-thumbnail">
                <a href="<?php echo esc_url(get_the_permalink()); ?>" class="relative">
                    <?php echo wp_kses_post($post_img); ?>
                    
                </a>
            </div>
            <span class="post-date">
                <?php echo esc_html(get_the_date(get_option('date_format'))); ?>
            </span>
        <?php } ?>

        <!-- POST DETAILS -->
        <div class="post-details">
            <div class="post-details-holder">

                <div class="post-author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), 120); ?>
                </div>

                <!-- POST TITLE -->
                <h1 class="post-name row">
                    <a title="<?php the_title_attribute() ?>" href="<?php echo esc_url(get_the_permalink()); ?>">
                        <!-- POST TITLE -->
                        <?php the_title(); ?>
                    </a>
                </h1>

                <!-- POST METAS (CATEGORIES / TAGS ) -->              
                <div class="post-category-comment-date post-tags-comment-date row">
                    <?php if(get_the_tag_list()) { ?>
                        <span class="post-tags">
                            <?php echo wp_kses_post(get_the_tag_list('<i class="fa fa-tag"></i>',', ',' ')); ?>
                        </span>
                    <?php } ?>
                    <span class="post-tags">
                        <?php echo wp_kses_post(get_the_term_list( get_the_ID(), 'category', '<i class="fa fa-folder-open"></i>', ', ' )); ?> 
                    </span>
                </div>
                
                

                <!-- POST CONTENT / EXCERPT -->
                <div class="post-excerpt row">
                    <?php
                        /* translators: %s: Name of current post */
                        the_excerpt();
                    ?>
                    <div class="clearfix"></div>

                    <p class="text-center">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>" class="more-link">
                            <?php echo esc_html__( 'Continue Reading ', 'niva' ); ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </p>
                    <div class="clearfix"></div>

                    <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'niva' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                </div>
            </div>
        </div>
    </div>
</article>