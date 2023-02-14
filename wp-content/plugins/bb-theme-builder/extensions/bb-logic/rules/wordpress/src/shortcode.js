const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/shortcode', {
	label: __( 'Shortcode Result' ),
	category: 'conditional-tag',
	form: getFormPreset( 'shortcode' ),
} )
