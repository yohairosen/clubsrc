<?php
	/**
	CUSTOM FOOTER FUNCTIONS
	*/


	/**
Function name:              niva_footer_row1()
Function description:       Footer row 1
*/
function niva_footer_row1(){

    global  $niva;
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if ( function_exists('sweetthemes_framework')) {
            echo '<div class="row">';
                echo '<div class="col-md-12 footer-row-1">';
                    echo '<div class="row">';

                        $footer_row_1_layout = $niva['mt_footer_row_1_layout'];
                        $nr = array("1", "2", "3", "4", "6");

                        if (in_array($footer_row_1_layout, $nr)) {
                            $columns    = 12/$footer_row_1_layout;
                            $class = 'col-md-'.esc_attr($columns);
                            for ( $i=1; $i <= $footer_row_1_layout ; $i++ ) { 
                                if ( is_active_sidebar( 'footer_row_1_'.esc_attr($i) ) ){
                                    echo '<div class="'.esc_attr($class).' sidebar-'.esc_attr($i).'">';
                                        dynamic_sidebar( 'footer_row_1_'.esc_attr($i) );
                                    echo '</div>';
                                }
                            }
                        }elseif($footer_row_1_layout == '5'){
                            if ( is_active_sidebar( 'footer_row_1_1' ) ){
                                echo '<div class="col-md-2 col-md-offset-1 sidebar-1">';
                                    dynamic_sidebar( 'footer_row_1_1' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_2' ) ){
                                echo '<div class="col-md-2 sidebar-2">';
                                    dynamic_sidebar( 'footer_row_1_2' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_3' ) ){
                                echo '<div class="col-md-2 sidebar-3">';
                                    dynamic_sidebar( 'footer_row_1_3' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_4' ) ){
                                echo '<div class="col-md-2 sidebar-4">';
                                    dynamic_sidebar( 'footer_row_1_4' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_5' ) ){
                                echo '<div class="col-md-2 sidebar-5">';
                                    dynamic_sidebar( 'footer_row_1_5' );
                                echo '</div>';
                            }
                        }elseif($footer_row_1_layout == 'column_half_sub_half'){
                            if ( is_active_sidebar( 'footer_row_1_1' ) ){
                                echo '<div class="col-md-6 sidebar-1">';
                                    dynamic_sidebar( 'footer_row_1_1' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_2' ) ){
                                echo '<div class="col-md-3 sidebar-2">';
                                    dynamic_sidebar( 'footer_row_1_2' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_3' ) ){
                                echo '<div class="col-md-3 sidebar-3">';
                                    dynamic_sidebar( 'footer_row_1_3' );
                                echo '</div>';
                            }
                        }elseif($footer_row_1_layout == 'column_sub_half_half'){
                            if ( is_active_sidebar( 'footer_row_1_1' ) ){
                                echo '<div class="col-md-3 sidebar-1">';
                                    dynamic_sidebar( 'footer_row_1_1' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_2' ) ){
                                echo '<div class="col-md-3 sidebar-2">';
                                    dynamic_sidebar( 'footer_row_1_2' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_3' ) ){
                                echo '<div class="col-md-6 sidebar-3">';
                                    dynamic_sidebar( 'footer_row_1_3' );
                                echo '</div>';
                            }
                        }elseif($footer_row_1_layout == 'column_sub_fourth_third'){
                            if ( is_active_sidebar( 'footer_row_1_1' ) ){
                                echo '<div class="col-md-2 sidebar-1">';
                                    dynamic_sidebar( 'footer_row_1_1' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_2' ) ){
                                echo '<div class="col-md-2 sidebar-2">';
                                    dynamic_sidebar( 'footer_row_1_2' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_3' ) ){
                                echo '<div class="col-md-2 sidebar-3">';
                                    dynamic_sidebar( 'footer_row_1_3' );
                                echo '</div>';
                            }
                                
                            if ( is_active_sidebar( 'footer_row_1_4' ) ){
                                echo '<div class="col-md-2 sidebar-4">';
                                    dynamic_sidebar( 'footer_row_1_4' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_5' ) ){
                                echo '<div class="col-md-4 sidebar-5">';
                                    dynamic_sidebar( 'footer_row_1_5' );
                                echo '</div>';
                            }
                        }elseif($footer_row_1_layout == 'column_third_sub_fourth'){
                            if ( is_active_sidebar( 'footer_row_1_1' ) ){
                                echo '<div class="col-md-4 sidebar-1">';
                                    dynamic_sidebar( 'footer_row_1_1' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_2' ) ){
                                echo '<div class="col-md-2 sidebar-2">';
                                    dynamic_sidebar( 'footer_row_1_2' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_3' ) ){
                                echo '<div class="col-md-2 sidebar-3">';
                                    dynamic_sidebar( 'footer_row_1_3' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_4' ) ){
                                echo '<div class="col-md-2 sidebar-4">';
                                    dynamic_sidebar( 'footer_row_1_4' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_5' ) ){
                                echo '<div class="col-md-2 sidebar-5">';
                                    dynamic_sidebar( 'footer_row_1_5' );
                                echo '</div>';
                            }
                        }elseif($footer_row_1_layout == 'column_sub_third_half'){
                            if ( is_active_sidebar( 'footer_row_1_1' ) ){
                                echo '<div class="col-md-2 sidebar-1">';
                                    dynamic_sidebar( 'footer_row_1_1' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_2' ) ){
                                echo '<div class="col-md-2 sidebar-2">';
                                    dynamic_sidebar( 'footer_row_1_2' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_3' ) ){
                                echo '<div class="col-md-2 sidebar-3">';
                                    dynamic_sidebar( 'footer_row_1_3' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_4' ) ){
                                echo '<div class="col-md-6 sidebar-4">';
                                    dynamic_sidebar( 'footer_row_1_4' );
                                echo '</div>';
                            }
                        }elseif($footer_row_1_layout == 'column_half_sub_third'){
                            if ( is_active_sidebar( 'footer_row_1_1' ) ){
                                echo '<div class="col-md-6 sidebar-1">';
                                    dynamic_sidebar( 'footer_row_1_1' );
                                echo '</div>';
                            }

                            if ( is_active_sidebar( 'footer_row_1_2' ) ){
                                echo '<div class="col-md-2 sidebar-2">';
                                    dynamic_sidebar( 'footer_row_1_2' );
                                echo '</div>';
                            }
                                
                            if ( is_active_sidebar( 'footer_row_1_3' ) ){
                                echo '<div class="col-md-2 sidebar-3">';
                                    dynamic_sidebar( 'footer_row_1_3' );
                                echo '</div>';
                            }
                                
                            if ( is_active_sidebar( 'footer_row_1_4' ) ){
                                echo '<div class="col-md-2 sidebar-4">';
                                    dynamic_sidebar( 'footer_row_1_4' );
                                echo '</div>';
                            }
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
}


/**
Function name:              niva_footer_row2()
Function description:       Footer row 2
*/
function niva_footer_row2(){

    global  $niva;
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if ( function_exists('sweetthemes_framework')) {
            echo '<div class="row">';
                echo '<div class="col-md-12 footer-row-2">';
                    echo '<div class="row">';

                    $footer_row_2_layout = $niva['mt_footer_row_2_layout'];
                    $nr = array("1", "2", "3", "4", "6");

                    if (in_array($footer_row_2_layout, $nr)) {
                        $columns    = 12/$footer_row_2_layout;
                        $class = 'col-md-'.esc_attr($columns);
                        for ( $i=1; $i <= $footer_row_2_layout ; $i++ ) { 
                            if ( is_active_sidebar( 'footer_row_2_'.esc_attr($i) ) ){
                                echo '<div class="'.esc_attr($class).' sidebar-'.esc_attr($i).'">';
                                    dynamic_sidebar( 'footer_row_2_'.esc_attr($i) );
                                echo '</div>';
                            }
                        }
                    }elseif($footer_row_2_layout == '5'){
                        if ( is_active_sidebar( 'footer_row_2_1' ) ){
                            echo '<div class="col-md-2 col-md-offset-1 sidebar-1">';
                                dynamic_sidebar( 'footer_row_2_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_2_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_2_3' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_2_4' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_5' ) ){
                            echo '<div class="col-md-2 sidebar-5">';
                                dynamic_sidebar( 'footer_row_2_5' );
                            echo '</div>';
                        }
                    }elseif($footer_row_2_layout == 'column_half_sub_half'){
                        if ( is_active_sidebar( 'footer_row_2_1' ) ){
                            echo '<div class="col-md-6 sidebar-1">';
                                dynamic_sidebar( 'footer_row_2_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_2' ) ){
                            echo '<div class="col-md-3 sidebar-2">';
                                dynamic_sidebar( 'footer_row_2_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_3' ) ){
                            echo '<div class="col-md-3 sidebar-3">';
                                dynamic_sidebar( 'footer_row_2_3' );
                            echo '</div>';
                        }
                    }elseif($footer_row_2_layout == 'column_sub_half_half'){
                        if ( is_active_sidebar( 'footer_row_2_1' ) ){
                            echo '<div class="col-md-3 sidebar-1">';
                                dynamic_sidebar( 'footer_row_2_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_2' ) ){
                            echo '<div class="col-md-3 sidebar-2">';
                                dynamic_sidebar( 'footer_row_2_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_3' ) ){
                            echo '<div class="col-md-6 sidebar-3">';
                                dynamic_sidebar( 'footer_row_2_3' );
                            echo '</div>';
                        }
                    }elseif($footer_row_2_layout == 'column_sub_fourth_third'){
                        if ( is_active_sidebar( 'footer_row_2_1' ) ){
                            echo '<div class="col-md-2 sidebar-1">';
                                dynamic_sidebar( 'footer_row_2_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_2_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_2_3' );
                            echo '</div>';
                        }
                            
                        if ( is_active_sidebar( 'footer_row_2_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_2_4' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_5' ) ){
                            echo '<div class="col-md-4 sidebar-5">';
                                dynamic_sidebar( 'footer_row_2_5' );
                            echo '</div>';
                        }
                    }elseif($footer_row_2_layout == 'column_third_sub_fourth'){
                        if ( is_active_sidebar( 'footer_row_2_1' ) ){
                            echo '<div class="col-md-4 sidebar-1">';
                                dynamic_sidebar( 'footer_row_2_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_2_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_2_3' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_2_4' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_5' ) ){
                            echo '<div class="col-md-2 sidebar-5">';
                                dynamic_sidebar( 'footer_row_2_5' );
                            echo '</div>';
                        }
                    }elseif($footer_row_2_layout == 'column_sub_third_half'){
                        if ( is_active_sidebar( 'footer_row_2_1' ) ){
                            echo '<div class="col-md-2 sidebar-1">';
                                dynamic_sidebar( 'footer_row_2_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_2_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_2_3' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_4' ) ){
                            echo '<div class="col-md-6 sidebar-4">';
                                dynamic_sidebar( 'footer_row_2_4' );
                            echo '</div>';
                        }
                    }elseif($footer_row_2_layout == 'column_half_sub_third'){
                        if ( is_active_sidebar( 'footer_row_2_1' ) ){
                            echo '<div class="col-md-6 sidebar-1">';
                                dynamic_sidebar( 'footer_row_2_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_2_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_2_2' );
                            echo '</div>';
                        }
                            
                        if ( is_active_sidebar( 'footer_row_2_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_2_3' );
                            echo '</div>';
                        }
                            
                        if ( is_active_sidebar( 'footer_row_2_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_2_4' );
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
}


/**
Function name:              niva_footer_row3()
Function description:       Footer row 3
*/
function niva_footer_row3(){

    global  $niva;

     if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if ( function_exists('sweetthemes_framework')) {
            echo '<div class="row">';
                echo '<div class="col-md-12 footer-row-3">';
                    echo '<div class="row">';

                    $footer_row_3_layout = $niva['mt_footer_row_3_layout'];
                    $nr = array("1", "2", "3", "4", "6");

                    if (in_array($footer_row_3_layout, $nr)) {
                        $columns    = 12/$footer_row_3_layout;
                        $class = 'col-md-'.esc_attr($columns);
                        for ( $i=1; $i <= $footer_row_3_layout ; $i++ ) { 
                            if ( is_active_sidebar( 'footer_row_3_'.esc_attr($i) ) ){
                                echo '<div class="'.esc_attr($class).' sidebar-'.esc_attr($i).'">';
                                    dynamic_sidebar( 'footer_row_3_'.esc_attr($i) );
                                echo '</div>';
                            }
                        }
                    }elseif($footer_row_3_layout == '5'){
                        if ( is_active_sidebar( 'footer_row_3_1' ) ){
                            echo '<div class="col-md-2 col-md-offset-1 sidebar-1">';
                                dynamic_sidebar( 'footer_row_3_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_3_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_3_3' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_3_4' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_5' ) ){
                            echo '<div class="col-md-2 sidebar-5">';
                                dynamic_sidebar( 'footer_row_3_5' );
                            echo '</div>';
                        }
                    }elseif($footer_row_3_layout == 'column_half_sub_half'){
                        if ( is_active_sidebar( 'footer_row_3_1' ) ){
                            echo '<div class="col-md-6 sidebar-1">';
                                dynamic_sidebar( 'footer_row_3_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_2' ) ){
                            echo '<div class="col-md-3 sidebar-2">';
                                dynamic_sidebar( 'footer_row_3_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_3' ) ){
                            echo '<div class="col-md-3 sidebar-3">';
                                dynamic_sidebar( 'footer_row_3_3' );
                            echo '</div>';
                        }
                    }elseif($footer_row_3_layout == 'column_sub_half_half'){
                        if ( is_active_sidebar( 'footer_row_3_1' ) ){
                            echo '<div class="col-md-3 sidebar-1">';
                                dynamic_sidebar( 'footer_row_3_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_2' ) ){
                            echo '<div class="col-md-3 sidebar-2">';
                                dynamic_sidebar( 'footer_row_3_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_3' ) ){
                            echo '<div class="col-md-6 sidebar-3">';
                                dynamic_sidebar( 'footer_row_3_3' );
                            echo '</div>';
                        }
                    }elseif($footer_row_3_layout == 'column_sub_fourth_third'){
                        if ( is_active_sidebar( 'footer_row_3_1' ) ){
                            echo '<div class="col-md-2 sidebar-1">';
                                dynamic_sidebar( 'footer_row_3_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_3_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_3_3' );
                            echo '</div>';
                        }
                            
                        if ( is_active_sidebar( 'footer_row_3_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_3_4' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_5' ) ){
                            echo '<div class="col-md-4 sidebar-5">';
                                dynamic_sidebar( 'footer_row_3_5' );
                            echo '</div>';
                        }
                    }elseif($footer_row_3_layout == 'column_third_sub_fourth'){
                        if ( is_active_sidebar( 'footer_row_3_1' ) ){
                            echo '<div class="col-md-4 sidebar-1">';
                                dynamic_sidebar( 'footer_row_3_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_3_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_3_3' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_3_4' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_5' ) ){
                            echo '<div class="col-md-2 sidebar-5">';
                                dynamic_sidebar( 'footer_row_3_5' );
                            echo '</div>';
                        }
                    }elseif($footer_row_3_layout == 'column_sub_third_half'){
                        if ( is_active_sidebar( 'footer_row_3_1' ) ){
                            echo '<div class="col-md-2 sidebar-1">';
                                dynamic_sidebar( 'footer_row_3_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_3_2' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_3_3' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_4' ) ){
                            echo '<div class="col-md-6 sidebar-4">';
                                dynamic_sidebar( 'footer_row_3_4' );
                            echo '</div>';
                        }
                    }elseif($footer_row_3_layout == 'column_half_sub_third'){
                        if ( is_active_sidebar( 'footer_row_3_1' ) ){
                            echo '<div class="col-md-6 sidebar-1">';
                                dynamic_sidebar( 'footer_row_3_1' );
                            echo '</div>';
                        }

                        if ( is_active_sidebar( 'footer_row_3_2' ) ){
                            echo '<div class="col-md-2 sidebar-2">';
                                dynamic_sidebar( 'footer_row_3_2' );
                            echo '</div>';
                        }
                            
                        if ( is_active_sidebar( 'footer_row_3_3' ) ){
                            echo '<div class="col-md-2 sidebar-3">';
                                dynamic_sidebar( 'footer_row_3_3' );
                            echo '</div>';
                        }
                            
                        if ( is_active_sidebar( 'footer_row_3_4' ) ){
                            echo '<div class="col-md-2 sidebar-4">';
                                dynamic_sidebar( 'footer_row_3_4' );
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
}
?>