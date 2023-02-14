const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'acf/option-field', {
	label: __( 'ACF Option Field' ),
	category: 'acf',
	form: getFormPreset( 'key-value' ),
} )
