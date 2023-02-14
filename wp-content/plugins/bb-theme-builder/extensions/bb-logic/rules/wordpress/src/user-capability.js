const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/user-capability', {
	label: __( 'User Capability' ),
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
			route: 'bb-logic/v1/wordpress/capabilities',
		},
	},
} )
