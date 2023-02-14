const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'browser/referer', {
	label: __( 'Referer' ),
	category: 'browser',
	form: getFormPreset( 'string' ),
} )
