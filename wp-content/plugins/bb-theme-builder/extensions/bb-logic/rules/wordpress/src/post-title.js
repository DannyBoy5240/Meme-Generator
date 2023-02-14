const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-title', {
	label: __( 'Post Title' ),
	category: 'post',
	form: getFormPreset( 'string' ),
} )
