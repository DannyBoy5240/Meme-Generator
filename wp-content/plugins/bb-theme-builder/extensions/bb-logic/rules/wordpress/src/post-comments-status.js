const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-comments-status', {
	label: __( 'Post Comments Status' ),
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
			options: [
				{
					label: __( 'Open' ),
					value: true,
				},
				{
					label: __( 'Closed' ),
					value: false,
				}
			]
		},
	},
} )
