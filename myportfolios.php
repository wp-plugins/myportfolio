<?php
 
/*
Plugin Name: Myportfolio
Description: This is a solution for potfolio solutions
Version: 1.00
Author: srinidhi
Author URI: https://profiles.wordpress.org/srinidhibhargava
License:     GPL2
 
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Myportfolio is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Myportfolio. 
*/
add_action('wp_enqueue_scripts', 'front_scripts',1);	
function front_scripts() {
		$list = 'enqueued';
				

		if (wp_script_is( 'bootstrap.min.js', $list ) || wp_script_is( 'bootstrap.js', $list )) {
			 } else {
					wp_enqueue_script( 'bstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js' );
   
			}
	
	wp_enqueue_script( 'isotopescript', plugin_dir_url( __FILE__ ) . 'js/isotope.js' , array( 'jquery' ));
    wp_enqueue_script( 'modern', plugin_dir_url( __FILE__ ) . 'js/modernizr.js' );
   wp_enqueue_script( 'backstretch', plugin_dir_url( __FILE__ ) . 'js/jquery.backstretch.min.js' );
    wp_enqueue_script( 'apear', plugin_dir_url( __FILE__ ) . 'js/jquery.appear.js' );
    wp_enqueue_script( 'customjs', plugin_dir_url( __FILE__ ) . 'js/custom.js' ,array('isotopescript'));
	
	wp_enqueue_style( 'bootcss', plugins_url( '/css/mystyle.css', __FILE__ ) );
	wp_enqueue_style( 'myCSS', plugins_url( '/css/bootstrap.min.css', __FILE__ ) );
	wp_enqueue_style( 'myfont', plugins_url( '/fonts/font-awesome/css/font-awesome.css', __FILE__ ) );
	wp_enqueue_style( 'myanimate', plugins_url( '/css/animations.css', __FILE__ ) );
}

 
function pluginprefix_install() {
 
    // Trigger our function that registers the custom post type
    register_cpt_portfolio();
 
    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();
 
}
register_activation_hook( __FILE__, 'pluginprefix_install' );

    add_action( 'init', 'register_cpt_portfolio' );

    function register_cpt_portfolio() {

        $labels = array( 
            'name' => _x( 'portfolios', 'portfolio' ),
            'singular_name' => _x( 'portfolio', 'portfolio' ),
            'add_new' => _x( 'Add New', 'portfolio' ),
            'add_new_item' => _x( 'Add New portfolio', 'portfolio' ),
            'edit_item' => _x( 'Edit portfolio', 'portfolio' ),
            'new_item' => _x( 'New portfolio', 'portfolio' ),
            'view_item' => _x( 'View portfolio', 'portfolio' ),
            'search_items' => _x( 'Search portfolios', 'portfolio' ),
            'not_found' => _x( 'No portfolios found', 'portfolio' ),
            'not_found_in_trash' => _x( 'No portfolios found in Trash', 'portfolio' ),
            'parent_item_colon' => _x( 'Parent portfolio:', 'portfolio' ),
            'menu_name' => _x( 'portfolios', 'portfolio' ),
        );

        $args = array( 
            'labels' => $labels,
            'hierarchical' => false,
            
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions' ),
            'taxonomies' => array( 'category' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'post'
        );

        register_post_type( 'portfolio', $args );
    }

	
function display_portfolio_func($atts,$content,$tag){
     require('frontend.php'); 
}
add_shortcode('display_portfolio','display_portfolio_func');


// Handle the post_type parameter given in get_terms function
function df_terms_clauses($clauses, $taxonomy, $args) {
	if (!empty($args['post_type']))	{
		global $wpdb;

		$post_types = array();

		foreach($args['post_type'] as $cpt)	{
			$post_types[] = "'".$cpt."'";
		}

	    if(!empty($post_types))	{
			$clauses['fields'] = 'DISTINCT '.str_replace('tt.*', 'tt.term_taxonomy_id, tt.term_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields']).', COUNT(t.term_id) AS count';
			$clauses['join'] .= ' INNER JOIN '.$wpdb->term_relationships.' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN '.$wpdb->posts.' AS p ON p.ID = r.object_id';
			$clauses['where'] .= ' AND p.post_type IN ('.implode(',', $post_types).')';
			$clauses['orderby'] = 'GROUP BY t.term_id '.$clauses['orderby'];
		}
    }
    return $clauses;
}
add_filter('terms_clauses', 'df_terms_clauses', 10, 3);


