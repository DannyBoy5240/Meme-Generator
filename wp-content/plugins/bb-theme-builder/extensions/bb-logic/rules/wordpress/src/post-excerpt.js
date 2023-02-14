const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-excerpt', {
	label: __( 'Post Excerpt' ),
	category: 'post',
	form: getFormPreset( 'string' ),
} )
