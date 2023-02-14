const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'browser/cookie', {
	label: __( 'Cookie' ),
	category: 'browser',
	form: getFormPreset( 'key-value' ),
} )
