const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'acf/user-field', {
	label: __( 'ACF User Field' ),
	category: 'acf',
	form: getFormPreset( 'key-value' ),
} )
