const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-content', {
	label: __( 'Post Content' ),
	category: 'post',
	form: getFormPreset( 'string' ),
} )
