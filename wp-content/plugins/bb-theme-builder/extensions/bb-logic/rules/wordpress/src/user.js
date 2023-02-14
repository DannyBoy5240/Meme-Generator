const { addRuleType, getPermalinks } = BBLogic.api
const { __ } = BBLogic.i18n
var permalink = getPermalinks()
addRuleType( 'wordpress/user', {
	label: __( 'User' ),
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
			type: 'suggest',
			placeholder: __( 'Username' ),
			route: `bb-logic/v1/wordpress/users${ permalink }suggest={search}`,
		},
	},
} )
