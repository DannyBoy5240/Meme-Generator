const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'acf/post-field', {
	label: __( 'ACF Post Field' ),
	category: 'acf',
	form: getFormPreset( 'key-value' ),
} )
