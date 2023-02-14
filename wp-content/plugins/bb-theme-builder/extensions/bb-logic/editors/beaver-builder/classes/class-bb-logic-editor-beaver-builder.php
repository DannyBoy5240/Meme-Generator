<?php

/**
 * Main conditional logic class to support the Beaver
 * Builder UI. Handles enqueuing assets and processing
 * display logic for nodes in a layout.
 *
 * @since 0.1
 */
final class BB_Logic_Editor_Beaver_Builder {

	/**
	 * Setup hooks if the Beaver Builder plugin is active.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function init() {
		if ( ! class_exists( 'FLBuilder' ) ) {
			return;
		}

		// Actions
		add_action( 'fl_builder_ui_enqueue_scripts', __CLASS__ . '::enqueue_assets', 11 ); // Iframe UI
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_assets', 11 );
		add_action( 'wp_footer', __CLASS__ . '::render_react_root' );

		// Filters
		add_filter( 'fl_builder_custom_fields', __CLASS__ . '::register_logic_field' );
		add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::filter_node_settings_form', 10, 2 );
		add_filter( 'fl_builder_is_node_visible', __CLASS__ . '::is_node_visible', 10, 2 );
	}

	/**
	 * Enqueue assets when the builder UI is active.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function enqueue_assets() {
		if ( ! FLBuilderModel::is_builder_active() ) {
			return;
		}

		// Core Assets
		BB_Logic_Asset_Loader::enqueue();

		// Styles
		wp_enqueue_style(
			'bb-logic-editor-beaver-builder',
			BB_LOGIC_URL . 'editors/beaver-builder/build/style.css',
			array( 'bb-logic-core' ),
			BB_LOGIC_VERSION
		);

		// Scripts
		wp_enqueue_script(
			'bb-logic-editor-beaver-builder',
			BB_LOGIC_URL . 'editors/beaver-builder/build/index.js',
			array( 'bb-logic-core' ),
			BB_LOGIC_VERSION,
			true
		);
	}

	/**
	 * Renders the react root for rendering the conditional
	 * logic form in the DOM.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function render_react_root() {
		if ( ! FLBuilderModel::is_builder_active() ) {
			return;
		}

		echo '<div id="bb-logic-root"></div>';
	}

	/**
	 * Registers our custom field with the builder
	 * for conditional logic.
	 *
	 * @since 0.1
	 * @param array $fields
	 * @return array
	 */
	static public function register_logic_field( $fields ) {
		$fields['logic'] = BB_LOGIC_DIR . 'editors/beaver-builder/includes/ui-field-logic.php';
		return $fields;
	}

	/**
	 * Filters the config for node settings forms and adds an
	 * option to the visibility settings for conditional logic.
	 *
	 * @since 0.1
	 * @param array $form
	 * @param string $id
	 * @return array
	 */
	static public function filter_node_settings_form( $form, $id ) {
		if ( 'row' === $id || 'col' === $id ) {
			$fields = &$form['tabs']['advanced']['sections']['visibility']['fields'];
		} elseif ( 'module_advanced' === $id ) {
			$fields = &$form['sections']['visibility']['fields'];
		} else {
			return $form;
		}

		$fields['visibility_display']['options']['logic'] = __( 'Conditional Logic', 'bb-theme-builder' );

		$fields['visibility_display']['toggle']['logic'] = array(
			'fields' => array(
				'visibility_logic',
			),
		);

		$fields['visibility_logic'] = array(
			'type'    => 'logic',
			'label'   => __( 'Conditional Logic Settings', 'bb-theme-builder' ),
			'default' => array(),
		);

		return $form;
	}

	/**
	 * Hides nodes that have conditional logic conditions
	 * that aren't met for the current session by setting
	 * their visibility in the builder to false.
	 *
	 * @since 0.1
	 * @param bool $visible
	 * @param object $node
	 * @return bool
	 */
	static public function is_node_visible( $visible, $node ) {
		$settings = $node->settings;

		if ( isset( $settings->visibility_display ) && 'logic' === $settings->visibility_display ) {
			if ( isset( $settings->visibility_logic ) && ! empty( $settings->visibility_logic ) ) {
				$visible = BB_Logic_Rules::process_groups( $settings->visibility_logic );
			}
		}

		return $visible;
	}
}

BB_Logic_Editor_Beaver_Builder::init();
