const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'browser/url-variable', {
	label: __( 'URL Variable' ),
	category: 'browser',
	form: getFormPreset( 'key-value' ),
} )
