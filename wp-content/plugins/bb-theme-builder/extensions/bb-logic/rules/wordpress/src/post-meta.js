const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-meta', {
	label: __( 'Post Custom Field' ),
	category: 'post',
	form: getFormPreset( 'key-value' ),
} )
