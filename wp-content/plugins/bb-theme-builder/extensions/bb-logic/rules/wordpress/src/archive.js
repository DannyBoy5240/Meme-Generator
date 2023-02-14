const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/archive', {
	label: __( 'Archive' ),
	category: 'archive',
	form: {
		operator: {
			type: 'operator',
			operators: [
				'equals',
				'does_not_equal',
			],
		},
		archive: {
			type: 'select',
			route: 'bb-logic/v1/wordpress/archives',
		},
	},
} )
