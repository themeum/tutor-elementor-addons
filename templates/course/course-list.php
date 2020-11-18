
<div class="<?php tutor_container_classes(); ?> etlms-course-list-main-wrap">

<!--loading course init-->
<?php
    
    /*
        *get settings from elementor

    */
    $course_list_perpage = $settings['course_list_perpage'];
    $course_list_column = $settings['course_list_column'];

    /*
        *query arguements
    */
    $args = [
        'post_type' => tutor()->course_post_type,
        'post_status' => 'publish',
        'posts_per_page' => $course_list_perpage 
    ];
    
    // the query
    $the_query = new WP_Query( $args );

    //wp_reset_postdata();
    //do_action('tutor_course/archive/before_loop');

    if ( $the_query->have_posts() ) :?>

    <!-- loop start --> 
<?php
$shortcode_arg = isset($GLOBALS['tutor_shortcode_arg']) ? $GLOBALS['tutor_shortcode_arg']['column_per_row'] : null;
$courseCols = $shortcode_arg===null ? tutor_utils()->get_option( 'courses_col_per_row', 4 ) : $shortcode_arg;
?>  
    <!-- loop start --> 
    <?php 
        $card_normal_shadow = '';
        $card_hover_shadow = '';
        if("yes" === $settings['course_coursel_box_shadow']){
            $card_normal_shadow = "etlms-loop-course-normal-shadow";
        }   

        if("yes" === $settings['course_coursel_box_hover_shadow']){
            $card_hover_shadow = "etlms-loop-course-hover-shadow";
        }
        else
        {
            $card_hover_shadow = "etlms-loop-course-hover-shadow-no";
        }
    ?> 
    <div class="etlms-course-list-loop-wrap tutor-courses tutor-courses-loop-wrap tutor-courses-layout-<?php echo $courseCols.' '.$card_normal_shadow.' '.$card_hover_shadow; ?> etlms-course-list-<?= $settings['course_list_skin']?>" >

        <?php while ( $the_query->have_posts() ) : $the_query->the_post();
        ?>

<!-- slick-slider-main-wrapper -->

<div class="tutor-course-col-<?= $course_list_column?>">

    <div class="<?php tutor_course_loop_wrap_classes(); ?>"
        <?php
            $image_size = $settings['course_list_image_size_size'];
            $image_url = get_tutor_course_thumbnail($image_size, $url=true);
            if("overlayed" == $settings['course_list_skin'])
            {
                echo 'style= "background-image:url('.$image_url.')" ';
            }
        ?>
    >


        <!-- header -->
        <div class="tutor-course-header">
            <?php 
                $custom_image_size = $settings['course_list_image_size_size'];

                if("overlayed" !=$settings['course_list_skin']):
            ?>
            <a href="<?php the_permalink(); ?>"> 
                <?php
                    if("yes" === $settings['course_list_image']){

                        get_tutor_course_thumbnail($custom_image_size);
                    }
                ?> 
            </a>    
            <?php
           
            endif;
            $course_id = get_the_ID();
            ?>
            <div class="tutor-course-loop-header-meta">
                <?php
                $is_wishlisted = tutor_utils()->is_wishlisted($course_id);
                $has_wish_list = '';
                if ($is_wishlisted){
                    $has_wish_list = 'has-wish-listed';
                }

                $action_class = '';
                if ( is_user_logged_in()){
                    $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
                }else{
                    $action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
                }
                if("yes" === $settings['course_list_difficulty_settings']){
                    echo '<span class="tutor-course-loop-level">'.get_tutor_course_level().'</span>';
                }
                if("yes" === $settings['course_list_wishlist_settings']){
                    echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-fav-line '.$action_class.' '.$has_wish_list.' " data-course-id="'.$course_id.'"></a> </span>';    
                }

                
                ?>
            </div>
        </div>
        <!-- start loop content wrap -->
        <div class="etlms-carousel-course-container"
        <?php 
            if("overlayed" == $settings['course_list_skin'])
            {
                echo 'style= "margin-top:40px"';
            }
        ?>
        >
            <div class="tutor-loop-course-container">

            <!-- loop rating -->
            <?php if("yes" === $settings['course_list_rating_settings']):?>
            <div class="tutor-loop-rating-wrap">
                <?php
                $course_rating = tutor_utils()->get_course_rating();
                tutor_utils()->star_rating_generator($course_rating->rating_avg);
                ?>
                <span class="tutor-rating-count">
                    <?php
                    if ($course_rating->rating_avg > 0) {
                        echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg);
                        echo '<i>(' . apply_filters('tutor_course_rating_count', $course_rating->rating_count) . ')</i>';
                    }
                    ?>
                </span>
            </div>
            <?php endif;?>
            <!-- loop title -->
            <div class="tutor-course-loop-title">
                <h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>

            <!-- loop meta -->
            <?php
            /**
             * @package TutorLMS/Templates
             * @version 1.4.3
             */

            global $post, $authordata;

            $profile_url = tutor_utils()->profile_url($authordata->ID);
            ?>


            <?php if("yes" === $settings['course_list_meta_data']):?>
            <div class="tutor-course-loop-meta">
                <?php
                $course_duration = get_tutor_course_duration_context();
                $course_students = tutor_utils()->count_enrolled_users_by_course();
                ?>
                <div class="tutor-single-loop-meta">
                    <i class='tutor-icon-user'></i><span><?php echo $course_students; ?></span>
                </div>
                <?php
                if(!empty($course_duration)) { ?>
                    <div class="tutor-single-loop-meta">
                        <i class='tutor-icon-clock'></i> <span><?php echo $course_duration; ?></span>
                    </div>
                <?php } ?>
            </div>
            <?php endif;?>

            <div class="tutor-loop-author">
                <div class="tutor-single-course-avatar">
                    <?php if("yes" === $settings['course_list_avatar_settings']):?>
                    <a href="<?php echo $profile_url; ?>"> <?php echo tutor_utils()->get_tutor_avatar($post->post_author); ?></a>
                    <?php endif;?>
                </div>
                <?php if("yes" == $settings['course_list_author_settings']):?>
                <div class="tutor-single-course-author-name">
                    <span><?php _e('by', 'tutor'); ?></span>
                    <a href="<?php echo $profile_url; ?>"><?php echo get_the_author(); ?></a>
                </div>
                <?php endif;?>
                <div class="tutor-course-lising-category">
                    <?php
                    if("yes" === $settings['course_list_category_settings']){

                        $course_categories = get_tutor_course_categories();
                        if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
                            ?>
                            <span><?php esc_html_e('In', 'tutor') ?></span>
                            <?php
                            foreach ($course_categories as $course_category){
                                $category_name = $course_category->name;
                                $category_link = get_term_link($course_category->term_id);
                                echo "<a href='$category_link'>$category_name </a>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- end content wrap -->
            </div>

            <!-- loop footer -->
            
            <?php
            $is_footer = $settings['course_list_footer_settings'];
            ?>
            <div class="tutor-loop-course-footer etlms-carousel-footer" style="
            <?php if($is_footer=='yes'):?>
                display:block;
                <?php else:?>
                display: none;
            <?php endif;?>    
            ">
            <?php

                tutor_course_loop_price();

            ?>   
            </div>

        </div>  <!-- etlms-course-container -->
        
        

    </div>    
</div>   
    
<!-- slick-slider-main-wrapper -->

        <?php  
        endwhile;
        ?>
    </div> 

    <!-- loop end -->    
    <?php    

    else :

        /**
         * No course found
         */
        tutor_load_template('course-none');

    endif;

    tutor_course_archive_pagination();

    do_action('tutor_course/archive/after_loop');
?>
<!--loading course init-->



<input type="hidden" id="etlms_enroll_btn_type" value="<?= $settings['course_carousel_enroll_btn_type']?>">
<input type="hidden" id="etlms_enroll_btn_cart" value="<?= $settings['course_coursel_button_icon']?>">    
</div>






