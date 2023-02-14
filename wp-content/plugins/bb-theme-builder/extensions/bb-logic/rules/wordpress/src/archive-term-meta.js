const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/archive-term-meta', {
	label: __( 'Archive Term Meta' ),
	category: 'archive',
	form: getFormPreset( 'key-value' ),
} )
