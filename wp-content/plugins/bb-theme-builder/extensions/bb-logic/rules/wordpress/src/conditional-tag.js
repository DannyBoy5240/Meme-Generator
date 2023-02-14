const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/conditional-tag', {
	label: __( 'Conditional Tag' ),
	category: 'conditional-tag',
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
					label: __( '404' ),
					value: 'is_404',
				},
				{
					label: __( 'Home' ),
					value: 'is_home',
				},
				{
					label: __( 'Front Page' ),
					value: 'is_front_page',
				},
				{
					label: __( 'Taxonomy Archive' ),
					value: 'is_tax',
				},
				{
					label: __( 'Search Results' ),
					value: 'is_search',
				},
			],
		}
	},
} )
