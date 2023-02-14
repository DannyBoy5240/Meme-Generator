<?php

/**
 * Handles logic for page data site properties.
 *
 * @since 1.0
 */
final class FLPageDataSite {

	/**
	 * Returns the current site title.
	 *
	 * @since 1.0
	 * @return string
	 */
	static public function get_title() {
		return get_bloginfo( 'name' );
	}

	/**
	 * Returns the current site description.
	 *
	 * @since 1.0
	 * @return string
	 */
	static public function get_description() {
		return get_bloginfo( 'description' );
	}

	/**
	 * Returns the current site URL.
	 *
	 * @since 1.0
	 * @return string
	 */
	static public function get_url() {
		return get_bloginfo( 'url' );
	}

	/**
	 * Adds site settings fields for a user connection.
	 *
	 * @since 1.0.1
	 * @param string $key
	 * @param array $fields
	 * @return void
	 */
	static public function add_user_settings_fields( $key, $fields = array() ) {

		$fields['user'] = array(
			'type'    => 'select',
			'label'   => __( 'User', 'bb-theme-builder' ),
			'default' => 'current',
			'options' => array(
				'current'  => __( 'Current User', 'bb-theme-builder' ),
				'specific' => __( 'Specific User', 'bb-theme-builder' ),
				'author'   => __( 'Author', 'bb-theme-builder' ),
			),
			'toggle'  => array(
				'specific' => array(
					'fields' => array( 'user_id' ),
				),
			),
		);

		$fields['user_id'] = array(
			'type'  => 'text',
			'label' => __( 'User ID', 'bb-theme-builder' ),
			'size'  => 10,
		);

		FLPageData::add_site_property_settings_fields( $key, $fields );
	}

	/**
	 * Returns the user name for the current user.
	 *
	 * @since 1.0.1
	 * @param object $settings
	 * @return string
	 */
	static public function get_user_name( $settings ) {

		$user = self::get_user( $settings );
		$name = '';

		if ( ! $user ) {
			return '';
		}

		switch ( $settings->type ) {

			case 'display':
				$name = $user->display_name;
				break;

			case 'first':
				$name = get_user_meta( $user->ID, 'first_name', true );
				break;

			case 'last':
				$name = get_user_meta( $user->ID, 'last_name', true );
				break;

			case 'firstlast':
				$first = get_user_meta( $user->ID, 'first_name', true );
				$last  = get_user_meta( $user->ID, 'last_name', true );
				$name  = $first . ' ' . $last;
				break;

			case 'lastfirst':
				$first = get_user_meta( $user->ID, 'first_name', true );
				$last  = get_user_meta( $user->ID, 'last_name', true );
				$name  = $last . ', ' . $first;
				break;

			case 'nickname':
				$name = $user->user_nicename;
				break;

			case 'username':
				$name = $user->user_login;
				break;
		}

		if ( $name && 'yes' == $settings->link ) {
			$settings->type = $settings->link_type;
			$name           = '<a href="' . self::get_user_url( $settings ) . '">' . $name . '</a>';
		}
		return $name;
	}

	/**
	 * Returns the bio for the current user.
	 *
	 * @since 1.0.1
	 * @param object $settings
	 * @return string
	 */
	static public function get_user_bio( $settings ) {

		$user = self::get_user( $settings );

		if ( ! $user ) {
			return '';
		}

		return get_user_meta( $user->ID, 'description', true );
	}

	/**
	 * Returns the URL for the current user.
	 *
	 * @since 1.0.1
	 * @param object $settings
	 * @return string
	 */
	static public function get_user_url( $settings ) {

		$user = self::get_user( $settings );
		$url  = '';

		if ( ! $user ) {
			return '';
		} elseif ( 'archive' == $settings->type ) {
			$url = get_author_posts_url( $user->ID );
		} elseif ( 'website' == $settings->type ) {
			$url = $user->user_url;
		}

		return $url;
	}

	/**
	 * @since 1.0.1
	 * @param object $settings
	 * @return string
	 */
	static public function get_user_profile_picture( $settings ) {

		$user   = self::get_user( $settings );
		$avatar = '';

		if ( $user ) {

			$size   = ! is_numeric( $settings->size ) ? 512 : $settings->size;
			$avatar = get_avatar( $user->ID, $size );

			if ( 'yes' == $settings->link ) {
				$settings->type = $settings->link_type;
				$avatar         = '<a href="' . self::get_user_url( $settings ) . '">' . $avatar . '</a>';
			}
		}

		return $avatar;
	}

	/**
	 * @since 1.0.1
	 * @param object $settings
	 * @return string
	 */
	static public function get_user_profile_picture_url( $settings ) {

		$user = self::get_user( $settings );
		$url  = '';

		if ( $user ) {
			// We get the url like this because not all custom avatar plugins filter get_avatar_url.
			$size   = ! is_numeric( $settings->size ) ? 512 : $settings->size;
			$avatar = get_avatar( $user->ID, $size, $settings->default_img_src );

			preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $avatar, $matches, PREG_SET_ORDER );
			$url = ! empty( $matches ) && isset( $matches[0][1] ) ? $matches[0][1] : '';
		}

		if ( ! $url && isset( $settings->default_img_src ) ) {
			$url = $settings->default_img_src;
		}

		return $url;
	}

	/**
	 * @since 1.0.1
	 * @param object $settings
	 * @return string
	 */
	static public function get_user_meta( $settings ) {

		$user = self::get_user( $settings );
		$meta = '';

		if ( $user && ! empty( $settings->key ) ) {
			$meta = get_user_meta( $user->ID, $settings->key, true );
		}

		return $meta;
	}

	/**
	 * @since 1.1
	 * @param object $settings
	 * @return string
	 */
	static public function get_year( $settings ) {

		if ( ! is_string( $settings->format ) || '' == $settings->format ) {
			$settings->format = 'Y';
		}
		return gmdate( $settings->format );
	}

	/**
	 * Returns a user object based on settings from a
	 * user connection settings form.
	 *
	 * @since 1.0.1
	 * @param object $settings
	 * @return object|bool
	 */
	static private function get_user( $settings ) {

		$user = false;

		if ( 'current' == $settings->user ) {
			$user = wp_get_current_user();
		} elseif ( 'specific' == $settings->user && ! empty( $settings->user_id ) ) {
			$user = get_user_by( 'ID', $settings->user_id );
		} elseif ( 'author' == $settings->user && is_author() ) {
			$user = get_user_by( 'ID', get_query_var( 'author' ) );
		}

		if ( is_object( $user ) && ! $user->ID ) {
			$user = false;
		}

		return $user;
	}

	/**
	 * @since 1.2.1
	 */
	static public function is_user_logged_in( $settings ) {

		if ( '' == $settings->role ) {
			return is_user_logged_in();
		}

		$roles      = array_map( 'trim', explode( ',', $settings->role ) );
		$user       = wp_get_current_user();
		$user_roles = (array) $user->roles;
		$result     = array_intersect( $roles, $user_roles );

		return ( ! empty( $result ) ) ? true : false;
	}
}
