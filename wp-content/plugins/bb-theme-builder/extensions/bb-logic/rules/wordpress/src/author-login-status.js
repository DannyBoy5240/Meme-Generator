const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/author-login-status', {
	label: __( 'Author Login Status' ),
	category: 'author',
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
					label: __( 'Logged In' ),
					value: 'logged_in',
				},
				{
					label: __( 'Logged Out' ),
					value: 'logged_out',
				}
			]
		}
	},
} )
