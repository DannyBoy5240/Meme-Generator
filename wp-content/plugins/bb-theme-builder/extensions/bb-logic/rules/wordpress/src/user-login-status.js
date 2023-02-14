const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/user-login-status', {
	label: __( 'User Login Status' ),
	category: 'user',
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
