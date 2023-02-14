<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );

function my_bb_custom_fonts ( $system_fonts ) {
  $system_fonts[ 'Noway' ] = array(
    'fallback' => 'courier',
    'weights' => array(
        '700',
        '500',
        '400',
        '300',
        '100',
    ),
  );

  $system_fonts[ 'Noway Italic' ] = array(
    'fallback' => 'courier',
    'weights' => array(
        '700',
        '500',
        '400',
        '300',
        '100',
    ),
  );

  return $system_fonts;
}
//Add to Beaver Builder Theme Customizer
add_filter( 'fl_theme_system_fonts', 'my_bb_custom_fonts' );
//Add to Page Builder modules
add_filter( 'fl_builder_font_families_system', 'my_bb_custom_fonts' );

//Add with add_action to limit to theme not all of wp
function my_assets() {
	// Add scripts file 
  wp_enqueue_script('theme-scripts', get_stylesheet_directory_uri() . '/scripts/scripts.js', array(), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'my_assets' );
// Allow svg uploads
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


//bb search shortcode
function bb_search_shortcode() {
  ob_start();
  FLTheme::nav_search();
  return ob_get_clean();
}
add_shortcode( 'bb_search','bb_search_shortcode' );

/**
 * Post Authors Post Link Shortcode
 *
 * @param array $atts
 * @return string $authors
 */
function post_authors_post_link_shortcode( $atts ) {
  
$atts = shortcode_atts( array( 
  'between'      => null,
  'between_last' => null,
  'before'       => "By ",
  'after'        => null
), $atts );

$authors = function_exists( 'coauthors_posts_links' ) ? coauthors_posts_links( $atts['between'], $atts['between_last'], $atts['before'], $atts['after'], false ) : $atts['before'] . get_author_posts_url() . $atts['after'];
return $authors;
}
add_shortcode( 'post_authors_post_link', 'post_authors_post_link_shortcode' );

//add coauthors shortcode
/*
function coauthors_shortcode() {
  if ( function_exists( 'coauthors') ) {
    $authors = coauthors();
  } else {
    $authors =  wp_list_authors(
      array(
        'html'          => FALSE
    ) );
  }
  return '<div class="coauthors">' . $authors . '</div>';
}
add_shortcode( 'coauthors','coauthors_shortcode' ); */

/* Add Yoast SEO breadcrumbs */
function yoast_breadcrumb_shortcode() {
  if ( function_exists('yoast_breadcrumb') ) {
    return yoast_breadcrumb('<div class="bb_breadcrumbs">','</div>');
  } 
}
add_shortcode( 'yoast_breadcrumb','yoast_breadcrumb_shortcode' );


//ACF Default Image, from here - https://acfextras.com/default-image-for-image-field/
//Add Default Image Setting to Image Field
add_action('acf/render_field_settings/type=image', 'add_default_value_to_image_field');
function add_default_value_to_image_field($field) {
  acf_render_field_setting( $field, array(
    'label'			=> 'Default Image',
    'instructions'		=> 'Appears when creating a new post',
    'type'			=> 'image',
    'name'			=> 'default_value',
  ));
}
//Enqueue WP Media Scripts on ACF Field Group Edit Page
add_action('admin_enqueue_scripts', 'enqueue_uploader_for_image_default');
function enqueue_uploader_for_image_default() {
  $screen = get_current_screen();
  if ($screen && $screen->id && ($screen->id == 'acf-field-group')) {
    acf_enqueue_uploader();
  }
}
//Reset to Default Image when image is removed/deleted from post
add_filter('acf/load_value/type=image', 'reset_default_image', 10, 3);
function reset_default_image($value, $post_id, $field) {
  if (!$value) {
    $value = $field['default_value'];
  }
  return $value;
}


function modify_tinymce_settings($settings) {
  //change indentation to match li indent
  $settings['indentation'] = '40px';
  // Omit h1 from the list
  $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';

  return $settings;
}
  
add_filter('tiny_mce_before_init', 'modify_tinymce_settings');


//limit search to posts, pages and stories
function searchfilter($query) {
    if ($query->is_search && !is_admin() ) {
      $query->set('post_type',array('post','page','story'));
    }
  return $query;
}
add_filter('pre_get_posts','searchfilter');

//add excerpts to pages
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}


//orderby for search
add_action( 'pre_get_posts', function( $query ) {
  if ( $query->is_search() ) {
    $query->set( 'orderby', 'relevance' );
  }
} );
//make posts a priority
add_filter( 'posts_search_orderby', function( $search_orderby ) {
  global $wpdb;
  return "{$wpdb->posts}.post_type LIKE 'post' DESC, {$search_orderby}";
});

//Add Instructions to Featured Image Box
add_filter( 'admin_post_thumbnail_html', 'add_featured_image_html');
function add_featured_image_html( $html ) {
  return $html .= '<p>Help text for featured image goes here.</p>';
}

//Add custom styles to the editor
function add_style_select_buttons( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );

//add custom styles to the WordPress editor
function my_custom_styles( $init_array ) {  
  
      $style_formats = array(  
          // These are the custom styles
          array(  
              'title' => 'Pink Button',  
              'block' => 'span',  
              'classes' => 'button-pink',
              'wrapper' => true,
          ),
          array(  
            'title' => 'Blue Button',  
            'block' => 'span',  
            'classes' => 'button-blue',
            'wrapper' => true,
          ),
          array(  
            'title' => 'Mixed Color Button',  
            'block' => 'span',  
            'classes' => 'button-mixed',
            'wrapper' => true,
          ),     
          array(  
              'title' => 'Pullquote',  
              'block' => 'span',  
              'classes' => 'pullquote',
              'wrapper' => true,
          ),
      );  
      // Insert the array, JSON ENCODED, into 'style_formats'
      $init_array['style_formats'] = json_encode( $style_formats );  
      
      return $init_array;  
    
  } 
  // Attach callback to 'tiny_mce_before_init' 
  add_filter( 'tiny_mce_before_init', 'my_custom_styles' );


  //add tides css to editor 
  add_action( 'init', 'tides_add_editor_styles' );
  /**
   * Apply theme's stylesheet to the visual editor.
   *
   * @uses add_editor_style() Links a stylesheet to visual editor
   * @uses get_stylesheet_uri() Returns URI of theme stylesheet
   */
  function tides_add_editor_styles() {
   add_editor_style( get_stylesheet_uri() );
  }

/**
 * Get all Partners with donation links
 * 
 * 
 *
 */
function partner_donate_links_shortcode() {
  // args
  $args = array(
    'posts_per_page'	=> -1,
    'post_type'		=> 'partners',
    'meta_key'		=> 'donation_link',
    'orderby' => 'title',
    'order' => 'ASC',
  );

  // query
  $the_query = new WP_Query( $args );
  $output = '';
  if( $the_query->have_posts() ) {
    $output = '<select id="donate-partner-options"><option value="">Select a Project</option>';
    while( $the_query->have_posts() ) {
        $the_query->the_post();
        $output .= '<option value="' . get_field('donation_link') . '">' . get_the_title() . '</option>';
    }
    $output .= '</select>';
  }
  wp_reset_query();	 // Restore global post data stomped by the_post(). 

  return $output;
}
add_shortcode( 'partner_donate_links', 'partner_donate_links_shortcode' );


function my_partners_columns($columns) {
	$columns = array(
    'cb'	 	=> '<input type="checkbox" />',
    'title' => 'Title',
		'logo'  =>  'Logo',
		'website' 	=> 'Website',
    'story' 	=> 'Story',
    'donate'  => 'Donation Link'
	);
	return $columns;
}

function my_custom_partners_columns($column) {
  global $post;
  
  if($column == 'title') {
		echo the_title();
  }
	if($column == 'logo') {
    $image = get_field('logo');
    echo $image['url'];
  }	
	if($column == 'website') {
		echo get_field('website', $post->ID );
  }
  if($column == 'story') {  
    if (is_array(get_field('story', $post->ID ))) {
      echo 'Yes';
    }
    else {
      echo 'No';
    }
  }
  if($column == 'donate') {
    echo get_field('donation_link', $post->ID );
  }
	
}
function partners_column_register_sortable( $columns ){
  $columns['title'] = 'title';
  $columns['website'] = 'website';
  $columns['story'] = 'story';
  $columns['donate'] = 'donation_link';
  return $columns;
}

function manage_wp_posts_be_qe_pre_get_posts( $query ) {

   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
      switch( $orderby ) {
         case 'story':
            $query->set( 'meta_key', 'story' );
            $query->set( 'orderby', 'meta_value' );      
            break;

        case 'website':
            $query->set( 'meta_key', 'website' );
            $query->set( 'orderby', 'meta_value' );      
            break;
      }
   }
}

add_action("manage_partners_posts_custom_column", "my_custom_partners_columns");
add_filter("manage_partners_posts_columns", "my_partners_columns");
add_filter("manage_edit-partners_sortable_columns", "partners_column_register_sortable" );
add_action( 'pre_get_posts', 'manage_wp_posts_be_qe_pre_get_posts', 1 );