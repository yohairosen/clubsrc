<form method="get" class="searchform" action="<?php print esc_url(home_url('/')); ?>">
    <span class="toggle"></span>
    <div class="searchform-wrapper">        
        <label class="screen-reader-text"><?php print esc_html__('Search for:', 'elastik'); ?></label>
        <input type="text" value="<?php print get_search_query(); ?>" name="s" />
        <div class="submit"><input type="submit" value="<?php print esc_attr__('Search', 'elastik'); ?>"></div>
    </div>
</form>