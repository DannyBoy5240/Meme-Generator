<?php

/**
 * Class for adding to and working with all data
 * related to the current page.
 *
 * @since 1.0
 */
final class FLPageData {

	/**
	 * An array of groups for grouping related properties.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $groups
	 */
	static private $groups;

	/**
	 * An array of all registered properties stored by object
	 * type such as post, archive, and 404.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $properties
	 */
	static private $properties;

	/**
	 * Cached values that have been retrieved.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $values
	 */
	static private $values;

	/**
	 * A settings object for the current property value
	 * that is being pulled. Mainly useful for hooks
	 * that need to pass settings around.
	 *
	 * @since 1.0
	 * @access private
	 * @var object $settings
	 */
	static private $settings = null;

	/**
	 * Cached value for the is_archive method.
	 *
	 * @since 1.0
	 * @access private
	 * @var bool $is_archive
	 */
	static private $is_archive = null;

	/**
	 * Initialize page data.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		self::init_defaults();

		add_action( 'wp', __CLASS__ . '::init_properties', 1 );
	}

	/**
	 * Initialize default values for internal vars.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init_defaults() {
		self::$groups = array(
			'general'  => array(
				'label' => __( 'General', 'bb-theme-builder' ),
			),
			'archives' => array(
				'label' => __( 'Archives', 'bb-theme-builder' ),
			),
			'posts'    => array(
				'label' => __( 'Posts', 'bb-theme-builder' ),
			),
			'comments' => array(
				'label' => __( 'Comments', 'bb-theme-builder' ),
			),
			'author'   => array(
				'label' => __( 'Author', 'bb-theme-builder' ),
			),
			'site'     => array(
				'label' => __( 'Site', 'bb-theme-builder' ),
			),
			'user'     => array(
				'label' => __( 'User', 'bb-theme-builder' ),
			),
			'advanced' => array(
				'label' => __( 'Advanced', 'bb-theme-builder' ),
			),
		);

		self::$properties = array(
			'archive' => array(),
			'post'    => array(),
			'site'    => array(),
		);

		self::$values = array(
			'archive' => array(),
			'post'    => array(),
			'site'    => array(),
		);
	}

	/**
	 * Loads page data properties.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init_properties() {
		// Core Classes
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-page-data-archive.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-page-data-post.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-page-data-site.php';

		// Core Includes
		require_once FL_THEME_BUILDER_DIR . 'includes/page-data-archive.php';
		require_once FL_THEME_BUILDER_DIR . 'includes/page-data-post.php';
		require_once FL_THEME_BUILDER_DIR . 'includes/page-data-site.php';

		// Let devs hook into page data
		do_action( 'fl_page_data_add_properties' );
	}

	/**
	 * Adds a property group for grouping related properties.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_group( $key, $data = array() ) {
		if ( isset( self::$groups[ $key ] ) ) {
			return;
		}

		self::$groups[ $key ] = array_merge( array(
			'label' => $key,
		), $data );
	}

	/**
	 * Returns the groups array.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_groups() {
		return self::$groups;
	}

	/**
	 * Adds a property and associated data for archives.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_archive_property( $key, $data = array() ) {
		self::add_property( 'archive', $key, $data );
	}

	/**
	 * Adds a property and associated data for posts.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_post_property( $key, $data = array() ) {
		$data = array_merge( array(
			'post_type' => 'all',
		), $data );

		self::add_property( 'post', $key, $data );
	}

	/**
	 * Adds a property and associated data for the site.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_site_property( $key, $data = array() ) {
		self::add_property( 'site', $key, $data );
	}

	/**
	 * Adds a property and associated data.
	 *
	 * @since 1.0
	 * @param string $object
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_property( $object, $key, $data = array() ) {
		if ( isset( self::$properties[ $object ][ $key ] ) ) {
			return;
		}

		self::$properties[ $object ][ $key ] = array_merge( array(
			'object' => $object,
			'key'    => $key,
			'group'  => 'general',
			'label'  => $key,
			'type'   => 'string',
			'form'   => false,
			'getter' => function() {
				return ''; },
		), $data );
	}

	/**
	 * Returns data for a single property.
	 *
	 * @since 1.0
	 * @param string $object
	 * @param string $key
	 * @return array
	 */
	static public function get_property( $object, $key ) {
		return isset( self::$properties[ $object ][ $key ] ) ? self::$properties[ $object ][ $key ] : false;
	}

	/**
	 * Returns the properties array.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_properties() {
		return self::$properties;
	}

	/**
	 * Returns the value for a property.
	 *
	 * @since 1.0
	 * @param string $object The type of object to return a value for.
	 * @param string $key The property key.
	 * @param object $settings A settings object to pass to the getter.
	 * @return mixed
	 */
	static public function get_value( $object, $key, $settings = null ) {
		$property = self::get_property( $object, $key );

		// Property or getter doesn't exist, return an empty string.
		if ( ! $property || ! is_callable( $property['getter'] ) ) {
			return '';
		}

		// Get the value.
		if ( $property['form'] ) {
			$defaults       = FLBuilderModel::get_settings_form_defaults( $property['form']['id'] );
			$settings       = ! $settings ? new stdClass : $settings;
			$settings       = (object) array_merge( (array) $defaults, (array) $settings );
			self::$settings = $settings;
			$value          = call_user_func( $property['getter'], $settings, $property );
			self::$settings = null;
		} else {
			$value = call_user_func( $property['getter'] );
		}

		// Cache the value.
		self::$values[ $object ][ $key ] = $value;

		// Return the value after running it through the expression function
		return FLThemeBuilderFieldConnections::general_compare( $settings, $value );
	}

	/**
	 * Returns an array of all property values.
	 *
	 * @since 1.0
	 * @param string $object The type of object to return values for.
	 * @return array
	 */
	static public function get_values( $object = null ) {
		// Return all values if we don't have an object.
		if ( ! $object ) {

			foreach ( self::$properties as $object => $properties ) {
				self::$values[ $object ] = self::get_values( $object );
			}

			return self::$values;
		}

		// Return the values for a single object.
		foreach ( self::$properties[ $object ] as $key => $data ) {

			if ( ! isset( self::$values[ $object ][ $key ] ) ) {
				self::$values[ $object ][ $key ] = self::get_value( $object, $key );
			}
		}

		return self::$values[ $object ];
	}

	/**
	 * Returns the settings for the current value that
	 * is being pulled, if settings are set.
	 *
	 * @since 1.0
	 * @return object
	 */
	static public function get_current_settings() {
		return self::$settings;
	}

	/**
	 * Adds a settings form associated with an archive property.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_archive_property_settings_form( $key, $data = array() ) {
		self::add_property_settings_form( 'archive', $key, $data );
	}

	/**
	 * Adds a settings form associated with a post property.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_post_property_settings_form( $key, $data = array() ) {
		self::add_property_settings_form( 'post', $key, $data );
	}

	/**
	 * Adds a settings form associated with a site property.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_site_property_settings_form( $key, $data = array() ) {
		self::add_property_settings_form( 'site', $key, $data );
	}

	/**
	 * Adds a settings form associated with a property.
	 *
	 * @since 1.0
	 * @param string $object
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_property_settings_form( $object, $key, $data = array() ) {
		$property = self::get_property( $object, $key );
		$form_id  = 'page-data-' . $object . '-' . $key;
		$form     = array(
			'title' => $property['label'],
			'tabs'  => isset( $data['tabs'] ) ? $data['tabs'] : $data,
		);

		self::$properties[ $object ][ $key ]['form'] = array(
			'id'  => $form_id,
			'css' => isset( $data['tabs'] ) && isset( $data['css'] ) ? $data['css'] : null,
			'js'  => isset( $data['tabs'] ) && isset( $data['js'] ) ? $data['js'] : null,
		);

		FLBuilderModel::register_settings_form( $form_id, $form );
	}

	/**
	 * Adds a settings fields to a form associated with a archive property.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_archive_property_settings_fields( $key, $data = array() ) {
		self::add_property_settings_fields( 'archive', $key, $data );
	}

	/**
	 * Adds a settings fields to a form associated with a post property.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_post_property_settings_fields( $key, $data = array() ) {
		self::add_property_settings_fields( 'post', $key, $data );
	}

	/**
	 * Adds a settings fields to a form associated with a site property.
	 *
	 * @since 1.0
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_site_property_settings_fields( $key, $data = array() ) {
		self::add_property_settings_fields( 'site', $key, $data );
	}

	/**
	 * Adds a settings fields to a form associated with a property.
	 * This makes it easy to add settings fields without all of the
	 * necessary form config as most properties won't need many fields.
	 *
	 * @since 1.0
	 * @param string $object
	 * @param string $key
	 * @param array  $data
	 * @return void
	 */
	static public function add_property_settings_fields( $object, $key, $data = array() ) {
		self::add_property_settings_form( $object, $key, array(
			'css'  => isset( $data['fields'] ) && isset( $data['css'] ) ? $data['css'] : null,
			'js'   => isset( $data['fields'] ) && isset( $data['js'] ) ? $data['js'] : null,
			'tabs' => array(
				'general' => array(
					'title'    => '',
					'sections' => array(
						'general' => array(
							'title'  => '',
							'fields' => isset( $data['fields'] ) ? $data['fields'] : $data,
						),
					),
				),
			),
		) );
	}

	/**
	 * Checks to see if the current page is an archive page
	 * or a theme layout set to override one.
	 *
	 * @since 1.0
	 * @return bool
	 */
	static public function is_archive() {
		global $wp_the_query;
		global $post;

		if ( null !== self::$is_archive ) {
			return self::$is_archive;
		}

		self::$is_archive = false;

		if ( is_archive() ) {
			self::$is_archive = true;
		} elseif ( is_object( $wp_the_query->post ) && 'fl-theme-layout' == $wp_the_query->post->post_type ) {

			$layout_type = get_post_meta( $wp_the_query->post->ID, '_fl_theme_layout_type', true );

			if ( 'archive' == $layout_type ) {
				self::$is_archive = true;
			}
		} elseif ( is_singular() && $post->post_type != $wp_the_query->post->post_type ) {
			self::$is_archive = true;
		}

		return self::$is_archive;
	}
}

FLPageData::init();
