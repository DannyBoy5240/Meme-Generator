<?php

/**
 * Handles logic for page data Advanced Custom Field properties.
 *
 * @since 1.0
 */
final class FLPageDataACF {

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'acf', array(
			'label' => __( 'Advanced Custom Fields', 'bb-theme-builder' ),
		) );

		add_action( 'wp_enqueue_scripts', function() {
			if ( FLBuilderModel::is_builder_active() ) {
				wp_enqueue_script( 'bb-theme-builder-acf-fields', FL_THEME_BUILDER_ACF_URL . 'js/detected-fields.js' );
			}
		});
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string
	 */
	static public function string_field( $settings, $property ) {
		$content = '';
		$name    = trim( $settings->name );
		if ( function_exists( 'acf_get_loop' ) && acf_get_loop( 'active' ) ) {
			$object = get_sub_field_object( $name );
			// get group field
			if ( ! $object ) {
				$object = self::group_sub_field_object( $name );
			}
		} else {
			$object = get_field_object( $name, self::get_object_id( $property ) );
		}

		if ( empty( $object ) || ! isset( $object['type'] ) ) {
			return $content;
		}

		$value = isset( $object['value'] ) ? $object['value'] : '';

		switch ( $object['type'] ) {
			case 'text':
			case 'textarea':
			case 'number':
			case 'email':
			case 'url':
			case 'radio':
			case 'button_group':
				$content = $value;
				break;
			case 'color_picker':
				$prefix  = empty( $settings->prefix ) ? false : wp_validate_boolean( $settings->prefix );
				$content = $prefix ? $object['value'] : str_replace( '#', '', $object['value'] );
				break;
			case 'page_link':
				$content = '';

				if ( 'string' == gettype( $value ) ) {
					$content = $value;
				} elseif ( ! empty( $value ) && ( 'array' == gettype( $value ) ) ) {
					$separator = ( isset( $settings->separator ) ) ? $settings->separator : false;
					if ( $separator ) {
						$content = array();
						foreach ( $value as $v ) {
							$content[] = "<a href='{$v}'>{$v}</a>";
						}
						$content = implode( $separator, $content );
					} else {
						$content = '<ul>';
						foreach ( $value as $v ) {
							$content .= "<li><a href='{$v}'>{$v}</a></li>";
						}
						$content .= '</ul>';
					}
				}
				break;
			case 'link':
				if ( 'string' == gettype( $object['value'] ) ) {
					$content = $object['value'];
				} elseif ( ! empty( $object['value'] ) && ( 'array' == gettype( $object['value'] ) ) ) {
					$content = $object['value']['url'];
				}
				break;
			case 'password':
			case 'wysiwyg':
			case 'oembed':
			case 'date_time_picker':
			case 'time_picker':
				$content      = isset( $value ) ? $value : '';
				$is_date_time = 'date_time_picker' === $object['type'] || 'time_picker' === $object['type'];
				if ( $is_date_time && ! empty( $settings->format ) && ! empty( $content ) ) {
					$date    = str_replace( '/', '-', $content );
					$content = date( $settings->format, strtotime( $date ) ); // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
				}
				break;
			case 'checkbox':
				$values = array();

				if ( ! is_array( $value ) ) {
					break;
				} elseif ( 'text' !== $settings->checkbox_format ) {
					$content .= '<' . $settings->checkbox_format . '>';
				}

				foreach ( $value as $v ) {
					$values[] = is_array( $v ) ? $v['label'] : $v;
				}

				if ( 'text' === $settings->checkbox_format ) {
					$text_separator = isset( $settings->checkbox_separator ) ? $settings->checkbox_separator : ', ';
					$content        = implode( $text_separator, $values );
				} else {
					$content .= '<li>' . implode( '</li><li>', $values ) . '</li>';
					$content .= '</' . $settings->checkbox_format . '>';
				}
				break;
			case 'select':
				$values    = array();
				$obj_value = (array) $value;

				if ( 'text' !== $settings->select_format ) {
					$content .= '<' . $settings->select_format . '>';
				}

				foreach ( $obj_value as $v ) {
					$values[] = is_array( $v ) ? $v['label'] : $v;
				}

				if ( 'text' === $settings->select_format ) {
					$content = implode( ', ', $values );
				} else {
					$content .= '<li>' . implode( '</li><li>', $values ) . '</li>';
					$content .= '</' . $settings->select_format . '>';
				}
				break;
			case 'date_picker':
				if ( isset( $object['date_format'] ) && ! isset( $object['return_format'] ) ) {
					$format = self::js_date_format_to_php( $object['display_format'] );
					$date   = DateTime::createFromFormat( 'Ymd', $value );

					// Only pass to format() if valid date, DateTime returns false if not valid.
					if ( $date ) {
						$content = $date->format( $format );
					} else {
						$content = '';
					}
				} else {
					if ( isset( $settings->format ) && '' !== $settings->format && isset( $value ) ) {
						$date    = str_replace( '/', '-', $value );
						$content = date_i18n( $settings->format, strtotime( $date ) );
					} else {
						$content = isset( $value ) ? $value : '';
					}
				}
				break;
			case 'google_map':
				$height = ! empty( $object['height'] ) ? $object['height'] : '400';
				if ( ! empty( $value ) && is_array( $value ) && isset( $value['address'] ) ) {
					$address = urlencode( $value['address'] );
					$content = "<iframe src='https://www.google.com/maps/embed/v1/place?key=AIzaSyD09zQ9PNDNNy9TadMuzRV_UsPUoWKntt8&q={$address}' style='border:0;width:100%;height:{$height}px'></iframe>";
				} else {
					$content = '';
				}
				break;
			case 'image':
				$content = '';
				if ( empty( $settings->display ) ) {
					break;
				}

				if ( 'tag' == $settings->display ) {
					$image_id = self::get_image_id_from_object( $object );
					$format   = self::get_object_return_format( $object );
					$content  = wp_get_attachment_image( $image_id, $settings->image_size );
					if ( 'url' == $format ) {
						$url     = self::get_file_url_from_object( $object, $settings->image_size );
						$content = '<img src="' . $url . '" />';
					}
					if ( 'yes' == $settings->linked ) {
						$content = '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . $content . '</a>';
					}
				} elseif ( 'url' == $settings->display ) {
					$content = self::get_file_url_from_object( $object, $settings->image_size );
				} else {
					$acf_image = get_field( $object['name'] );
					if ( isset( $property['key'] ) && 'acf_option' == $property['key'] ) {
						$acf_image = get_field( $object['name'], 'option' );
					}
					$content = ! empty( $acf_image[ $settings->display ] ) ? $acf_image[ $settings->display ] : '';
					$format  = self::get_object_return_format( $object );

					if ( 'id' == $format ) {
						if ( 'alt' == $settings->display ) {
							$content = get_post_meta( $acf_image, '_wp_attachment_image_alt', true );
						} else {
							$image = get_post( $acf_image );
							if ( 'title' == $settings->display ) {
								$content = $image->post_title;
							} elseif ( 'caption' == $settings->display ) {
								$content = $image->post_excerpt;
							} elseif ( 'description' == $settings->display ) {
								$content = $image->post_content;
							}
						}
					}
				}
				break;
			case 'file':
				$content = self::get_file_url_from_object( $object );

				if ( 'name' == $settings->display ) {
					$file = pathinfo( $content );
					if ( is_array( $file ) && isset( $file['filename'] ) ) {
						$content = $file['filename'];
					}
				} elseif ( 'basename' == $settings->display ) {
					$file = pathinfo( $content );
					if ( is_array( $file ) && isset( $file['basename'] ) ) {
						$content = $file['basename'];
					}
				} elseif ( 'ext' == $settings->display ) {
					$file = pathinfo( $content );
					if ( is_array( $file ) && isset( $file['extension'] ) ) {
						$content = $file['extension'];
					}
				}
				break;
			case 'true_false':
			case 'color_picker':
				$content = strval( $value );
				break;
			case 'acf_smartslider3':
				$content = '';
				if ( class_exists( 'SmartSlider3' ) ) {
					$content = strval( $value );
				}
				break;
			default:
				$content = '';
		}// End switch().
		return is_string( $content ) ? $content : '';
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string
	 */
	static public function url_field( $settings, $property ) {
		$content = '';
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || $object['type'] != $settings->type ) {
			return $content;
		}

		switch ( $object['type'] ) {
			case 'text':
			case 'url':
			case 'select':
			case 'radio':
			case 'page_link':
				$content = '';

				if ( 'string' == gettype( $object['value'] ) ) {
					$content = $object['value'];
				} elseif ( ! empty( $object['value'] ) && ( 'array' == gettype( $object['value'] ) ) ) {
					$separator = ( isset( $settings->separator ) ) ? $settings->separator : false;
					if ( $separator ) {
						$content = array();
						foreach ( $object['value'] as $v ) {
							$content[] = "<a href='{$v}'>{$v}</a>";
						}
						$content = implode( $separator, $content );
					} else {
						$content = '<ul>';
						foreach ( $object['value'] as $v ) {
							$content .= "<li><a href='{$v}'>{$v}</a></li>";
						}
						$content .= '</ul>';
					}
				}
				break;
			case 'link':
				if ( 'string' == gettype( $object['value'] ) ) {
					$content = $object['value'];
				} elseif ( ! empty( $object['value'] ) && ( 'array' == gettype( $object['value'] ) ) ) {
					$content = $object['value']['url'];
				}
				break;
			case 'image':
				$content = self::get_file_url_from_object( $object, $settings->image_size );
				break;
			case 'file':
				$content = self::get_file_url_from_object( $object );
				break;
		}

		return is_string( $content ) ? $content : '';
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string|array
	 */
	static public function photo_field( $settings, $property ) {
		$content = '';
		if ( isset( $settings->image_fallback_src ) ) {
			$content = $settings->image_fallback_src;
		}
		$object = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || $object['type'] != $settings->type ) {
			return $content;
		}
		switch ( $object['type'] ) {
			case 'text':
			case 'url':
			case 'select':
			case 'radio':
				$content = isset( $object['value'] ) ? $object['value'] : $content;
				break;
			case 'image':
				$id  = self::get_image_id_from_object( $object );
				$url = self::get_file_url_from_object( $object, $settings->image_size );
				if ( $url ) {
					$content = array(
						'id'  => $id,
						'url' => $url,
					);
				}
				break;
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return array
	 */
	static public function multiple_photos_field( $settings, $property ) {
		$content = array();
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || 'gallery' != $object['type'] ) {
			return $content;
		} elseif ( is_array( $object['value'] ) ) {
			if ( 'id' == $object['return_format'] ) {
				$content = $object['value'];
			} else {
				foreach ( $object['value'] as $key => $value ) {
					if ( 'array' == $object['return_format'] ) {
						$content[] = $value['id'];
					} elseif ( 'url' == $object['return_format'] && attachment_url_to_postid( $value ) ) {
						$content[] = attachment_url_to_postid( $value );
					}
				}
			}
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string
	 */
	static public function color_field( $settings, $property ) {
		$content = '';
		if ( function_exists( 'acf_get_loop' ) && acf_get_loop( 'active' ) ) {
			$object = get_sub_field_object( trim( $settings->name ) );
		} else {
			$object = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );
		}

		if ( empty( $object ) || ! isset( $object['type'] ) || 'color_picker' != $object['type'] ) {
			return $content;
		} else {
			$prefix  = empty( $settings->prefix ) ? false : wp_validate_boolean( $settings->prefix );
			$content = $prefix ? $object['value'] : str_replace( '#', '', $object['value'] );
		}

		return $content;
	}

	/**
	 * @since 1.2.1
	 * @param array $property
	 * @return string
	 */
	static public function relational_field( $settings, $property ) {
		$content = '';

		if ( function_exists( 'acf_get_loop' ) && acf_get_loop( 'active' ) ) {
			$object = get_sub_field_object( trim( $settings->name ) );
		} else {
			$object = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );
		}
		$bail_out = empty( $object ) || $object['type'] !== $settings->type || ! isset( $object['type'] ) || ! in_array( $object['type'], array( 'user', 'post_object', 'relationship', 'page_link', 'taxonomy' ) );
		if ( $bail_out ) {
			return $content;
		} elseif ( ! empty( $object['value'] ) ) {
			$values = ( ! empty( $object['multiple'] ) ) ? $object['value'] : array( $object['value'] );

			if ( empty( $object['type'] ) ) {
				return $content;
			}

			if ( 'user' == $object['type'] ) {
				$users = array();
				$name  = '';

				foreach ( $values as $user_data ) {

					if ( 'id' == $object['return_format'] || 'object' == $object['return_format'] ) {
						if ( 'id' == $object['return_format'] ) {
							$user = get_userdata( $user_data );
						} else {
							$user = $user_data;
						}
						$user_data                   = array();
						$user_data['ID']             = $user->ID;
						$user_data['user_firstname'] = $user->first_name;
						$user_data['user_lastname']  = $user->last_name;
						$user_data['nickname']       = $user->nickname;
						$user_data['user_nicename']  = $user->user_nicename;
						$user_data['display_name']   = $user->display_name;
						$user_data['user_url']       = $user->user_url;
					}

					switch ( $settings->display_type ) {
						case 'display':
							$name = $user_data['display_name'];
							break;

						case 'first':
							$name = $user_data['user_firstname'];
							break;

						case 'last':
							$name = $user_data['user_lastname'];
							break;

						case 'firstlast':
							$first = $user_data['user_firstname'];
							$last  = $user_data['user_lastname'];
							$name  = $first . ' ' . $last;
							break;

						case 'lastfirst':
							$first = $user_data['user_firstname'];
							$last  = $user_data['user_lastname'];
							$name  = $last . ', ' . $first;
							break;

						case 'nickname':
							$name = $user_data['nickname'];
							break;

						case 'username':
							$name = $user_data['user_nicename'];
							break;
					}

					if ( $name && 'yes' == $settings->link ) {
						$url = '';

						if ( 'archive' == $settings->link_type ) {
							$url = get_author_posts_url( $user_data['ID'] );
						} elseif ( 'website' == $settings->link_type ) {
							$url = $user_data['user_url'];
						}

						if ( ! empty( $url ) ) {
							$name = '<a href="' . $url . '">' . $name . '</a>';
						}
					}

					$users[] = $name;
				}

				if ( count( $users ) > 0 ) {
					if ( count( $users ) < 3 ) {
						$content = implode( ' and ', $users );
					} else {
						$last_user = array_pop( $users );
						$content   = implode( ', ', $users ) . ' and ' . $last_user;
					}
				}
			} elseif ( 'post_object' == $object['type'] ) {

				// ul, ol, div
				$list_tag      = $settings->list_type;
				$list_item_tag = 'div';

				if ( 'ul' === $list_tag || 'ol' === $list_tag ) {
					$list_item_tag = 'li';
				}

				$content = '<' . $list_tag . '>';
				foreach ( $values as $post ) {
					$post_id = is_object( $post ) ? $post->ID : $post;

					$href  = get_permalink( $post_id );
					$title = the_title_attribute( array(
						'echo' => false,
						'post' => $post_id,
					) );

					$text           = get_the_title( $post_id );
					$list_item_text = $text;

					if ( 'yes' === $settings->post_title_link ) {
						$list_item_text = "<a href='{$href}' title='{$title}'>{$text}</a>";
					}

					$content .= "<{$list_item_tag} class='post-{$post_id}'>{$list_item_text}</{$list_item_tag}>";
				}
				$content .= '</' . $list_tag . '>';
			} elseif ( ! empty( $object['type'] ) && ( 'page_link' == $object['type'] ) ) {
				if ( ! $object['multiple'] && 'array' === gettype( $values ) && count( $values ) <= 1 ) {
					$content = implode( '', $values );
				} else {
					$content = '<ul>';
					foreach ( $values as $v ) {
						$content .= "<li><a href='{$v}'>{$v}</a></li>";
					}
					$content .= '</ul>';
				}
			} elseif ( 'relationship' === $object['type'] ) {
				if ( 1 === count( $values ) ) {
					$content = '<ul>';

					foreach ( $values[0] as $post ) {
						$post_id    = is_object( $post ) ? $post->ID : $post;
						$href       = get_permalink( $post_id );
						$title_attr = the_title_attribute( array(
							'echo' => false,
							'post' => $post_id,
						) );

						$post_title = get_the_title( $post_id );
						$content   .= "<li class='post-{$post_id}'><a href='{$href}' title='{$title_attr}'>{$post_title}</a></li>";
					}

					$content .= '</ul>';
				}
			} elseif ( 'taxonomy' == $object['type'] ) {

				$list_item_tag = 'div';
				$taxonomy      = $object['taxonomy'];
				$skip_term     = false;
				$list_tag      = $settings->list_type;
				$content       = '<' . $list_tag . '>';
				if ( 'ul' === $list_tag || 'ol' === $list_tag ) {
					$list_item_tag = 'li';
				}
				if ( 'checkbox' == $object['field_type'] || 'multi_select' == $object['field_type'] ) {
					foreach ( $object['value'] as $term ) {
						$term_id   = is_object( $term ) ? $term->term_id : $term;
						$link      = get_term_link( $term_id, $taxonomy );
						$term_data = get_term( $term_id, $taxonomy );
						if ( $term_data ) {
							$term_name  = $term_data->name;
							$post_count = $term_data->count;
							if ( 'yes' == $settings->term_archive_link ) {
								$term_name = "<a href='{$link}'>{$term_name}</a>";
							}
							if ( 'yes' == $settings->term_post_count ) {
								$term_name .= ' (' . $post_count . ')';
							}
							if ( 'yes' == $settings->hide_empty && 0 == $post_count ) {
								$skip_term = true;
							}
							if ( ! $skip_term ) {
								$content .= "<{$list_item_tag} class='taxonomy-{$term_data->term_id}'>{$term_name}</{$list_item_tag}>";
							}
						}
					}
				} else {
					$term_id   = $object['value'];
					$link      = get_term_link( $term_id, $taxonomy );
					$term_data = get_term( $term_id, $taxonomy );
					if ( $term_data ) {
						$term_name  = $term_data->name;
						$post_count = $term_data->count;
						if ( 'yes' == $settings->term_archive_link ) {
							$term_name = "<a href='{$link}'>{$term_name}</a>";
						}
						if ( 'yes' == $settings->term_post_count ) {
							$term_name .= ' (' . $post_count . ')';
						}
						if ( 'yes' == $settings->hide_empty && 0 == $post_count ) {
							$skip_term = true;
						}
					}
					if ( ! $skip_term ) {
						$content .= "<{$list_item_tag} class='taxonomy-{$term_data->term_id}'>{$term_name}</{$list_item_tag}>";
					}
				}
				$content .= '</' . $list_tag . '>';
			}
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @param array $property
	 * @return string
	 */
	static public function get_object_id( $property ) {
		global $post;

		$id = false;

		if ( 'archive' == $property['object'] ) {
			$location = FLThemeBuilderRulesLocation::get_current_page_location();
			if ( ! empty( $location['object'] ) ) {
				$location = explode( ':', $location['object'] );
				$id       = $location[1] . '_' . $location[2];
			}
		} elseif ( is_object( $post ) && strstr( $property['key'], 'acf_author' ) ) {
			$id = 'user_' . $post->post_author;
		} elseif ( strstr( $property['key'], 'acf_user' ) ) {
			$user = wp_get_current_user();
			if ( $user->ID > 0 ) {
				$id = 'user_' . $user->ID;
			}
		} elseif ( strstr( $property['key'], 'acf_option' ) ) {
			$id = 'option';
		}

		return $id;
	}

	/**
	 * Returns a field object ID by type instead of using
	 * the property array.
	 *
	 * @since 1.1.2
	 * @param string $type
	 * @return string
	 */
	static public function get_object_id_by_type( $type ) {
		$id = false;

		switch ( $type ) {
			case 'archive':
				$id = self::get_object_id( array(
					'object' => 'archive',
					'key'    => 'acf',
				) );
				break;

			case 'post':
				$id = self::get_object_id( array(
					'object' => 'post',
					'key'    => 'acf',
				) );
				break;

			case 'author':
				$id = self::get_object_id( array(
					'object' => 'post',
					'key'    => 'acf_author',
				) );
				break;

			case 'user':
				$id = self::get_object_id( array(
					'object' => 'site',
					'key'    => 'acf_user',
				) );
				break;

			case 'option':
				$id = self::get_object_id( array(
					'object' => 'site',
					'key'    => 'acf_option',
				) );
				break;
		}

		return $id;
	}

	/**
	 * @since 1.0
	 * @param array $object
	 * @param string $size
	 * @return string
	 */
	static public function get_file_url_from_object( $object, $size = 'thumbnail' ) {
		$url    = '';
		$format = self::get_object_return_format( $object );

		if ( $format && isset( $object['value'] ) ) {

			if ( 'array' == $format || 'object' == $format ) {

				if ( isset( $object['value']['sizes'] ) && isset( $object['value']['sizes'][ $size ] ) ) {
					$url = $object['value']['sizes'][ $size ];
				} elseif ( isset( $object['value']['url'] ) ) {
					$url = $object['value']['url'];
				}
			} elseif ( 'url' == $format ) {
				$url = $object['value'];
			} elseif ( 'id' == $format ) {
				if ( 'image' == $object['type'] ) {
					$data = wp_get_attachment_image_src( $object['value'], $size );
					$url  = isset( $data[0] ) ? $data[0] : '';
				} elseif ( 'file' == $object['type'] ) {
					$url = wp_get_attachment_url( $object['value'] );
				}
			}
		}

		return $url;
	}

	/**
	 * @since 1.0
	 * @param array $object
	 * @return int
	 */
	static public function get_image_id_from_object( $object ) {
		$id     = null;
		$format = self::get_object_return_format( $object );

		if ( $format && isset( $object['value'] ) ) {

			if ( 'array' == $format && isset( $object['value']['ID'] ) ) {
				$id = $object['value']['ID'];
			} elseif ( 'object' == $format ) {
				$id = $object['value']['id'];
			} elseif ( 'id' == $format ) {
				$id = $object['value'];
			}
		}

		return $id;
	}

	/**
	 * @since 1.0
	 * @param array $object
	 * @return int
	 */
	static public function get_object_return_format( $object ) {
		$format = false;

		if ( isset( $object['return_format'] ) ) {
			$format = $object['return_format'];
		} elseif ( isset( $object['save_format'] ) ) {
			$format = $object['save_format'];
		}

		return $format;
	}

	/**
	 * Converts a JS date format to a PHP date format.
	 * Needed because ACF 4 stores the date format in
	 * the JS format /shrug.
	 *
	 * @since 1.0
	 * @param string $format
	 * @return string
	 */
	static public function js_date_format_to_php( $format ) {

		$symbols = array(
			// Day
			'dd' => '{1}', // d
			'DD' => 'l',
			'd'  => 'j',
			'o'  => 'z',
			// Month
			'MM' => 'F',
			'mm' => '{2}', // m
			'm'  => 'n',
			// Year
			'yy' => 'Y',
		);

		foreach ( $symbols as $js => $php ) {
			$format = str_replace( $js, $php, $format );
		}

		$format = str_replace( '{1}', 'd', $format );
		$format = str_replace( '{2}', 'm', $format );

		return $format;
	}

	/**
	 * @since 1.3.2
	 */
	public static function get_custom_fields_select( $post_id, $relationship = false ) {
		global $wpdb;
		$form       = array();
		$sub_fields = array();
		$relation   = array( 'post_object', 'page_link', 'user', 'taxonomy', 'relationship' );

		if ( ! FLBuilderModel::is_builder_active() ) {
			return array();
		}
		$results = $wpdb->get_results( "SELECT ID as 'id', post_excerpt as 'field_key', post_title as 'field_name', post_content as 'field_opts' FROM {$wpdb->posts} where post_type = 'acf-field' ORDER BY field_name", ARRAY_A );

		// maybe filter
		foreach ( $results as $k => $field ) {
			$data = maybe_unserialize( $field['field_opts'] );
			if ( is_array( $data ) && isset( $data['type'] ) ) {
				$type = $data['type'];
				if ( $relationship ) {
					if ( ! in_array( $type, $relation ) ) {
						unset( $results[ $k ] );
					}
				} else {
					if ( in_array( $type, $relation ) && 'page_link' !== $type ) {
						unset( $results[ $k ] );
					}
				}

				// get group sub-fields
				if ( 'group' == $data['type'] ) {
					$field_key  = $field['field_key'];
					$field_data = acf_get_field( $field_key, false );

					if ( $field_data ) {
						if ( isset( $field_data['sub_fields'] ) && count( $field_data['sub_fields'] ) > 0 ) {
							foreach ( $field_data['sub_fields'] as $subfield ) {

								if ( 'group' !== $subfield['type'] && ! isset( $sub_fields[ $subfield['ID'] ] ) ) {
									$sub_fields[ $subfield['ID'] ] = $field_key . '_' . $subfield['name'];
								}
								if ( isset( $subfield['sub_fields'] ) && count( $subfield['sub_fields'] ) > 0 ) {
									foreach ( $subfield['sub_fields'] as $sub_subfield ) {
										$sub_fields[ $sub_subfield['ID'] ] = $field_key . '_' . $subfield['name'] . '_' . $sub_subfield['name'];
									}
								}
							}
						}
					}
				}
				if ( in_array( $data['type'], array( 'accordion', 'group', 'repeater', 'tab' ) ) ) {
					unset( $results[ $k ] );
				}
			}
		}

		if ( ! empty( $results ) ) {
			$form['type']    = 'select';
			$form['label']   = __( 'Detected Fields', 'bb-theme-builder' );
			$form['options'] = array(
				'' => __( 'Choose ACF Field', 'bb-theme-builder' ),
			);

			foreach ( $results as $field ) {
				if ( isset( $sub_fields[ $field['id'] ] ) ) {
					$field['field_key'] = $sub_fields[ $field['id'] ];
				}
				$data = maybe_unserialize( $field['field_opts'] );
				if ( is_array( $data ) && isset( $data['type'] ) ) {
					$type                                   = isset( $data['type'] ) ? str_replace( array( '_', '-' ), ' ', $data['type'] ) : 'unknown';
					$form['options'][ $field['field_key'] ] = sprintf( '%s (%s) [%s]', $field['field_name'], $field['field_key'], $type );
				}
			}
		}
		return $form;
	}

	/**
	 * @since 1.4
	 * @param string $sub_field
	 * @return object
	 */
	public static function group_sub_field_object( $sub_field ) {
		global $wpdb;
		$group_field = false;
		$object      = false;
		$results     = $wpdb->get_results( "SELECT post_excerpt as 'field_key', post_content as 'field_opts' FROM {$wpdb->posts} where post_type = 'acf-field'", ARRAY_A );

		foreach ( $results as $k => $field ) {
			$data = maybe_unserialize( $field['field_opts'] );
			if ( 'group' == $data['type'] ) {
				$field_key = $field['field_key'];
				if ( stripos( $sub_field, $field_key ) !== false ) {
					$group_field = $field_key;
				}
			}
		}

		if ( $group_field ) {
			$name = str_replace( $group_field, '', $sub_field );
			$name = substr( $name, 1 );
			if ( have_rows( $group_field ) ) {
				while ( have_rows( $group_field ) ) :
					the_row();
					$object = get_sub_field_object( $name );
				endwhile;
			}
		}
		return $object;
	}
}

FLPageDataACF::init();
