const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'acf/archive-field', {
	label: __( 'ACF Archive Field' ),
	category: 'acf',
	form: getFormPreset( 'key-value' ),
} )
