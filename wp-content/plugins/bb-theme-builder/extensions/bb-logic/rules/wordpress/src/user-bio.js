const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/user-bio', {
	label: __( 'User Bio' ),
	category: 'user',
	form: getFormPreset( 'string' ),
} )
