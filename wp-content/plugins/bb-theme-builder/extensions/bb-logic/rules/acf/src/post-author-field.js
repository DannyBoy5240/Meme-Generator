const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'acf/post-author-field', {
	label: __( 'ACF Post Author Field' ),
	category: 'acf',
	form: getFormPreset( 'key-value' ),
} )
