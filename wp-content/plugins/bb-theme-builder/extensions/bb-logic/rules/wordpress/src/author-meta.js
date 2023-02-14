const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/author-meta', {
	label: __( 'Author Meta' ),
	category: 'author',
	form: getFormPreset( 'key-value' ),
} )
