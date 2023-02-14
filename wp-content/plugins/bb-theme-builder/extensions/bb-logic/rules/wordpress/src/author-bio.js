const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/author-bio', {
	label: __( 'Author Bio' ),
	category: 'author',
	form: getFormPreset( 'string' ),
} )
