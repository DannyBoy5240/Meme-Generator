const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/archive-title', {
	label: __( 'Archive Title' ),
	category: 'archive',
	form: getFormPreset( 'string' ),
} )
