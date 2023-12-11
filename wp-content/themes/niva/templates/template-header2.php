<?php
  #WooCommerce global variable
  global $woocommerce;

  $count_woo = "0";
  if ( class_exists( 'WooCommerce' ) ) {
      $cart_url = wc_get_cart_url();
      $count_woo = WC()->cart->cart_contents_count;
  } 
  
?>

<header class="header2">

  <!-- BOTTOM BAR -->
  <nav class="navbar navbar-default logo-infos" id="sweetthemes-main-head">
    
      <!-- LOGO -->
      <div class="navbar-header col-md-2 col-sm-12">
        <!-- NAVIGATION BURGER MENU -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <i class="fa fa-bars"></i>
        </button>

        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
          
            $custom_header_activated = get_post_meta( get_the_ID(), 'niva_custom_header_options_status', true );
            $header_v = get_post_meta( get_the_ID(), 'niva_header_custom_variant', true );

            $logo_col10 = '';
            if ( niva('mt_contact_phone') && niva('mt_contact_phone') != '') { 
                $logo_col10 = ''; 
            } else {
                $logo_col10 = 'logo_col10'; 
            }

            $darkmode_on_off = get_post_meta( get_the_ID(), 'darkmode_on_off', true );
            $dark_custom_logo = get_post_meta( get_the_ID(), 'dark_custom_logo', true );

            if (isset($darkmode_on_off) && $darkmode_on_off == 'yes') { ?>
                
                <h1 class="logo img-logo <?php echo esc_attr($logo_col10); ?>">
                    <a href="<?php echo esc_url(get_site_url()); ?>">
                        <img src="<?php echo esc_url($dark_custom_logo); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
                    </a>
                </h1>
              
            <?php } else { ?>

                <?php if(niva('mt_logo','url')){ ?>
                  <h1 class="logo img-logo <?php echo esc_attr($logo_col10); ?>">
                      <a href="<?php echo esc_url(get_site_url()); ?>">
                          <img src="<?php echo esc_url(niva('mt_logo','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
                      </a>
                  </h1>
                <?php }else{ ?>
                  <h1 class="logo no-logo">
                      <a href="<?php echo esc_url(get_site_url()); ?>">
                        <?php echo esc_html(get_bloginfo()); ?>
                      </a>
                  </h1>
                <?php } ?>

            <?php } ?>

        <?php }else{ ?>
          <h1 class="logo no-logo">
              <a href="<?php echo esc_url(get_site_url()); ?>">
                <?php echo esc_html(get_bloginfo()); ?>
              </a>
          </h1>
        <?php } ?>
      </div>
      
      <?php $navbar_class = 'col-md-6 col-sm-12'; ?>

      <!-- NAV MENU -->
      <div id="navbar" class="navbar-collapse collapse <?php echo esc_attr($navbar_class); ?>">
        <ul class="menu nav navbar-nav pull-right nav-effect nav-menu">
          <?php

            $page_custom_menu = get_post_meta( get_the_ID(), 'niva_page_custom_menu', true );
            $html = '';

            if ( has_nav_menu( 'primary' ) ) {
              $defaults = array(
                'menu'            => '',
                'container'       => false,
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'menu',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => false,
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '%3$s',
                'depth'           => 0,
                'walker'          => ''
              );

              $defaults['theme_location'] = 'primary';
              if (isset($page_custom_menu)) {
                $html .= wp_nav_menu( array('menu' => $page_custom_menu ));
              }else{
                $html .= wp_nav_menu( $defaults );
              }

            }else{
              echo '<p class="no-menu text-left">';
                echo esc_html__('Primary navigation menu is missing. Add one from ', 'niva');
                echo '<a href="'.esc_url(get_admin_url() . 'nav-menus.php').'">'.esc_html__(' Appearance -> Menus','niva').'</a>';
              echo '</p>';
            }
          ?>
        </ul>
      </div>

      <div class="col-md-4 right-side-social-actions">

        <?php if ( niva('mt_contact_phone') && niva('mt_contact_phone') != '' ) { ?>
          <div class="phone-menu">
            <?php $mt_contact_phone_url = esc_html__('tel:','niva') . str_replace(' ', '', niva('mt_contact_phone')); ?>
            <?php $mt_contact_phone = niva('mt_contact_phone'); ?>
            <a href="<?php echo esc_url($mt_contact_phone_url); ?>"><?php echo esc_html($mt_contact_phone); ?></a>
          </div>
        <?php } ?>

   

       <!-- ACTIONS BUTTONS GROUP -->
        <div class="pull-right actions-group">

          <?php if ( class_exists( 'WooCommerce' ) ) { ?>
              <?php if(niva('st_header_cart') == true){ ?>
              <div class="shop_cart_holder">
                <div class="shop_cart_div">
                  <a class="shop_cart" href="<?php echo wc_get_cart_url(); ?>">
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="cart-contents-count"><?php echo esc_html( $count_woo ); ?></span>
                  </a>
                </div>
                <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                  <div class="header_mini_cart">
                     <?php the_widget( 'WC_Widget_Cart' ); ?>
                  </div>
                <?php } ?>
              </div> 
            <?php } ?>                    
          <?php } ?>

          <?php if(niva('mt_header_fixed_sidebar_menu_status') == true) { ?>
            <!-- MT BURGER -->
            <div id="mt-nav-burger">
              <span></span>
              <span></span>
              <span></span>
            </div>
          <?php } ?>

        </div>

        <!-- SOCIAL LINKS -->
        <?php if(niva('st_header_social_icons') == true){ ?>
          <?php if ( niva('mt_social_fb') && niva('mt_social_fb') != '' || niva('mt_social_tw') && niva('mt_social_tw') != '' || niva('mt_social_behance') && niva('mt_social_behance') != '') { ?>
          <ul class="social-links">
            <?php if ( niva('mt_social_fb') && niva('mt_social_fb') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_fb') ) ?>"><i class="fa fa-facebook"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_tw') && niva('mt_social_tw') != '' ) { ?>
              <li><a target="_blank" href="https://twitter.com/<?php echo esc_attr( niva('mt_social_tw') ) ?>"><i class="fa fa-twitter"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_gplus') && niva('mt_social_gplus') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_gplus') ) ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_youtube') && niva('mt_social_youtube') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_youtube') ) ?>"><i class="fa fa-youtube"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_pinterest') && niva('mt_social_pinterest') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_pinterest') ) ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_linkedin') && niva('mt_social_linkedin') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_linkedin') ) ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_skype') && niva('mt_social_skype') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_skype') ) ?>"><i class="fa fa-skype"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_instagram') && niva('mt_social_instagram') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_instagram') ) ?>"><i class="fa fa-instagram"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_dribbble') && niva('mt_social_dribbble') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_dribbble') ) ?>"><i class="fa fa-dribbble"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_deviantart') && niva('mt_social_deviantart') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_deviantart') ) ?>"><i class="fa fa-deviantart"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_digg') && niva('mt_social_digg') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_digg') ) ?>"><i class="fa fa-digg"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_flickr') && niva('mt_social_flickr') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_flickr') ) ?>"><i class="fa fa-flickr"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_stumbleupon') && niva('mt_social_stumbleupon') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_stumbleupon') ) ?>"><i class="fa fa-stumbleupon"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_tumblr') && niva('mt_social_tumblr') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_tumblr') ) ?>"><i class="fa fa-tumblr"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_vimeo') && niva('mt_social_vimeo') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_vimeo') ) ?>"><i class="fa fa-vimeo-square"></i></a></li>
            <?php } ?>
            <?php if ( niva('mt_social_behance') && niva('mt_social_behance') != '' ) { ?>
              <li><a target="_blank" href="<?php echo esc_url( niva('mt_social_behance') ) ?>"><i class="fa fa-behance"></i></a></li>
            <?php } ?>
          </ul>
          <?php } ?>
        <?php } ?>

      </div>
     <!-- row -->
     
  </nav>
</header>
