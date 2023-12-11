<?php 

# Custom Comments

function niva_custom_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'div';
        $add_below = 'div-comment';
    }
?>
    <<?php echo esc_attr($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body fullwidth single_comment parent">
        <?php endif; ?>
            <div class="comment-author vcard comment_author col-avatar">
                <?php if ( $args['avatar_size'] != 0 ) echo wp_kses_post(get_avatar( $comment, 130 )); ?>
            </div>
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','niva' ); ?></em>
        <?php endif; ?>

        <div class="comment-meta commentmetadata col-comment-body comment_body relative">
            <div class="vc_row">
                <span class="reply_button col-md-7 text-left">
                     <?php printf( '<div class="author_name">%s</div>', get_comment_author_link() ); ?>
                    <?php printf( '%1$s - %2$s', get_comment_date(),  get_comment_time() ); ?>
                </span>
                <span class="reply_button1 col-md-5 text-right">
                    <?php edit_comment_link( esc_html__( 'Edit', 'niva' ), '  ', '' ); ?>
                    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </span>
            </div>
            <?php comment_text(); ?>
        </div>
    </div>

    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php } ?>
