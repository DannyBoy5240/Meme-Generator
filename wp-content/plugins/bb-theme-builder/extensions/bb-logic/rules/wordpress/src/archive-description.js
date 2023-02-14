const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/archive-description', {
	label: __( 'Archive Description' ),
	category: 'archive',
	form: getFormPreset( 'string' ),
} )
