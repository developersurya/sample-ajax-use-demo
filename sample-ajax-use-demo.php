<?php
/*
Plugin Name: sample ajax use demo
Plugin URI: http://themefoundation.com/
Description: Provides a starting point for creating custom meta boxes.Try it by adding show_cat(); function in your template.
Author: Theme Foundation
Version: 1.0
Author URI: http://themefoundation.com/
*/
/**
 * Adds a meta box to the post editing screen
 */
add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "custom", WP_PLUGIN_URL.'/sample-ajax-use-demo/js/custom.js', array('jquery') );
   wp_localize_script( 'custom', 'myAjax', array( 
   'ajaxurl' => admin_url( 'admin-ajax.php' ),
   'nonce'=> wp_create_nonce('get_cats_sec')
   ));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'custom' );

}
 
 function show_cat(){
	//show the category list and div for result..
		wp_dropdown_categories( array(
			'hide_empty'       => 0,
			'name'             => 'category_parent',
			'orderby'          => 'name',
			'selected'         => $category->parent,
			'hierarchical'     => true,
			'show_option_none' => __('None')
		) ); 
		echo "<div class='resultshere'></div>";
}
function ajax_url(){
	$nonce = wp_create_nonce("get_cats_sec");
    $admin_url = admin_url("admin-ajax.php");
	$ajax_url_arr = array($admin_url,$nonce);
	//echo json_encode($ajax_url_arr);
}	
	
//should be in function file// 
//new code for ajax-admin example...
add_action('wp_ajax_get_cat_selected','get_cat_selected_callback');//for user logged in action hook 
add_action('wp_ajax_nopriv_get_cat_selected','get_cat_selected_callback');//for user not logged in action hook
function get_cat_selected_callback(){
	$cat = check_ajax_referer('get_cats_sec','security');
	// The Query
	//var_dump($cat);
	$cat_id = $_POST['selectedcat'];
	$args =array('cat'=>$cat_id);
	$the_query = new WP_Query( $args );
	// The Loop
	if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
			$the_query->the_post();
			 echo get_the_content() ;
			
		}
		wp_reset_postdata();
	} else {
		echo 'no posts found';
	}
}