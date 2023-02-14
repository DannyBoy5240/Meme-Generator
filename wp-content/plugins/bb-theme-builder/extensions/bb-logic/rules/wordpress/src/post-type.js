const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-type', {
	label: __( 'Post Type' ),
	category: 'post',
	form: ( { rule } ) => {
		const { taxonomy } = rule
		return {
			operator: {
				type: 'operator',
				operators: [
					'equals',
					'does_not_equal',
				],
			},
			compare: {
				type: 'select',
				route: 'bb-logic/v1/wordpress/post-types',
			},
		}
	},
} )
