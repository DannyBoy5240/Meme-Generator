const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/user-registered', {
	label: __( 'User Registered' ),
	category: 'user',
	form: getFormPreset( 'date' ),
} )
