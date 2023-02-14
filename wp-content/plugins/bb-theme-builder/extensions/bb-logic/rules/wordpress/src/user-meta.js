const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/user-meta', {
	label: __( 'User Meta' ),
	category: 'user',
	form: getFormPreset( 'key-value' ),
} )
