const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-comments-number', {
	label: __( 'Post Comments Number' ),
	category: 'post',
	form: getFormPreset( 'number' ),
} )
