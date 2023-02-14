const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-template', {
	label: __( 'Post Template' ),
	category: 'post',
	form: {
		operator: {
			type: 'operator',
			operators: [
				'equals',
				'does_not_equal',
			],
		},
		compare: {
			type: 'select',
			route: 'bb-logic/v1/wordpress/post-templates',
		},
	},
} )
