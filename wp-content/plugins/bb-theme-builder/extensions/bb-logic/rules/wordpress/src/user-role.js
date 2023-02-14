const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/user-role', {
	label: __( 'User Role' ),
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
			route: 'bb-logic/v1/wordpress/roles',
		},
	},
} )
