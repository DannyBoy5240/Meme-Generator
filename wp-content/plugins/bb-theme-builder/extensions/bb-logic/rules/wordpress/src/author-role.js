const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/author-role', {
	label: __( 'Author Role' ),
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
			route: 'bb-logic/v1/wordpress/roles',
		},
	},
} )
