<?php

$options = get_option(AZEXO_FRAMEWORK);
if (!isset($show_sidebar)) {
    $show_sidebar = isset($options[get_post_type() . '_show_sidebar']) ? $options[get_post_type() . '_show_sidebar'] : 'right';
    if ($show_sidebar == 'hidden') {
        $show_sidebar = false;
    }
}
$additional_sidebar = isset($options[get_post_type() . '_additional_sidebar']) ? (array) $options[get_post_type() . '_additional_sidebar'] : array();
get_header();
?>

<div class="<?php print ((isset($options['content_fullwidth']) && $options['content_fullwidth']) ? '' : 'container'); ?> <?php print (is_active_sidebar('sidebar') && $show_sidebar ? 'active-sidebar ' . esc_attr($show_sidebar) : ''); ?> <?php print (in_array('single', $additional_sidebar) ? 'additional-sidebar' : ''); ?>">
    <?php
    if ($show_sidebar == 'left') {
        get_sidebar();
    } else {
        if (in_array('single', $additional_sidebar)) {
            get_sidebar('additional');
        }
    }
    ?>
    <div id="primary" class="content-area">
        <?php
        if ($options['show_page_title']) {
            get_template_part('template-parts/general', 'title');
        }
        ?>
        <div id="content" class="site-content" role="main">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('content', get_post_format()); ?>                

                <?php
                if (isset($options['comments']) && $options['comments'] && !azexo_is_dashboard()) {
                    if (comments_open()) {
                        comments_template();
                    }
                }
                ?>

            <?php endwhile; ?>

            
        </div><!-- #content -->
    </div><!-- #primary -->

    <?php
    if ($show_sidebar == 'right') {
        get_sidebar();
    } else {
        if (in_array('single', $additional_sidebar)) {
            get_sidebar('additional');
        }
    }

    
    ?>

<?php 
   $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );
?>

	


	
<main class="main">
    <!-- SVG masks -->
    <svg class="svg-defs">
        <clipPath id="avatar-box">
            <path d="M1.85379 38.4859C2.9221 18.6653 18.6653 2.92275 38.4858 1.85453 56.0986.905299 77.2792 0 94 0c16.721 0 37.901.905299 55.514 1.85453 19.821 1.06822 35.564 16.81077 36.632 36.63137C187.095 56.0922 188 77.267 188 94c0 16.733-.905 37.908-1.854 55.514-1.068 19.821-16.811 35.563-36.632 36.631C131.901 187.095 110.721 188 94 188c-16.7208 0-37.9014-.905-55.5142-1.855-19.8205-1.068-35.5637-16.81-36.63201-36.631C.904831 131.908 0 110.733 0 94c0-16.733.904831-37.9078 1.85379-55.5141z"/>
        </clipPath>
        <clipPath id="avatar-hexagon">
             <path d="M0 27.2891c0-4.6662 2.4889-8.976 6.52491-11.2986L31.308 1.72845c3.98-2.290382 8.8697-2.305446 12.8637-.03963l25.234 14.31558C73.4807 18.3162 76 22.6478 76 27.3426V56.684c0 4.6805-2.5041 9.0013-6.5597 11.3186L44.4317 82.2915c-3.9869 2.278-8.8765 2.278-12.8634 0L6.55974 68.0026C2.50414 65.6853 0 61.3645 0 56.684V27.2891z"/>
        </clipPath>		
    </svg>

	    <div class="container gutter-top">
		    <div class="row sticky-parent">
			    <!-- Sidebar -->
				
                <aside class="col-12 col-md-12 col-xl-4">
				    <div class="sidebar box shadow pb-0 sticky-column">
						<svg class="avatar avatar--180" style="border-radius:40px;" viewBox="0 0 188 188">
                            <g class="avatar__box_">
                                <image xlink:href="<?php echo $image_url ?>" height="100%" width="100%" />
                            </g>
                        </svg>
						<div class="text-center">
						    <h3 class="title title--h3 sidebar__user-name">	<?php the_title();  ?></h3>
							<div class="badge badge--light"> <?php the_field('role'); ?></div>
							
							<!-- Social -->
		                    <div class="social">
		                    </div>
						</div>
						
						<div class="sidebar__info box-inner box-inner--rounded">
		                    <ul class="contacts-block">
					           
						        <li class="contacts-block__item" data-toggle="tooltip" data-placement="top" title="Address">
							        <i class="font-icon icon-location"></i><?php the_field('location'); ?>
							    </li>
						       
						        <li class="contacts-block__item" data-toggle="tooltip" data-placement="top" title="Phone">
							        <i class="font-icon icon-phone"></i><?php the_field('time_zone'); ?>
							    </li>
						        <li class="contacts-block__item" data-toggle="tooltip" data-placement="top" title="Skype">
									<i class="font-icon icon-phone"></i><?php the_field('experience'); ?>
							    </li>
					        </ul>
							
							<a class="btn" href="/contact/"> Hire now</a>
						</div>
					</div>	
		        </aside>
		        
				<!-- Content -->
		        <div class="col-12 col-md-12 col-xl-8">
				    <div class="box shadow pb-0">
					    <!-- Menu -->
					   
					
			            <div class="content">
						    <div id="about-tab" class="tabcontent active">
					            <!-- ABOUT -->
						        <div class="pb-0 pb-sm-2">
		                            <h1 class="title title--h1 first-title title__separate">About Me</h1>
						            <p>    <?php the_content(); ?> </p>
                                    
					            </div>

								<div class="top-skills">
									<div class="col-12 col-lg-6 mt-4 mt-lg-0">
										<h2 class="title title--h3">My Main Stack</h2>
										<div class="box box__second">
											<!-- Progress -->

											<?php 
											$terms = get_field('top_skills');
											$top_skills = [];
											if( $terms ): ?>

												<?php foreach( $terms as $index=>$term ): 
													$exp = get_field('skill_'.$index);
													$top_skills[$term->name] =  $exp;
												endforeach; 


												arsort($top_skills);
												
												$max = $top_skills[array_key_first($top_skills)];
												$min = $top_skills[array_key_last($top_skills)];
												
												?>

												<?php foreach( $terms as $index=>$term ): ?>
												
													<?php $exp = get_field('skill_'.$index) / $max * 100; ?>
										
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $exp ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $exp ?>%; z-index:2;">
															<div class="progress-text"><span>	<?php echo esc_html($term->name); ?></span><span><?php echo $exp ?>%</span></div>
														</div>
														<div class="progress-text"><span>	<?php echo esc_html($term->name); ?></span></div>
													</div>


												

												
												<?php endforeach; ?>
											<?php endif; ?>

										</div>
									</div>
									
								</div>
						
						        <!-- What -->
						        <div class="box-inner pb-0">
						            <h2 class="title title--h3">What I do</h2>
							        <div class="skills">
							            <!-- Case Item -->

										<?php 
											$terms = get_field('skills');
											if( $terms ): ?>

												<?php foreach( $terms as $term ): ?>
													<div class="badge badge--dark">
														
													<?php echo esc_html( $term->name ); ?>
													</div>
												
												<?php endforeach; ?>
											<?php endif; ?>

								    </div>	
						        </div>
						
						        <!-- Testimonials -->
					
						
						        <!-- Clients -->
						        <div class="box-inner box-inner--rounded">
						          
							
					
						        </div>
						    </div>
							
						
							
						</div>
					</div>
					
					<footer class="footer"></footer>
					<footer class="footer"></footer>
					<footer class="footer"></footer>
		        </div>
			</div>
		</div>	
    </main>

    <div class="back-to-top"></div>






                <?php get_footer(); ?>