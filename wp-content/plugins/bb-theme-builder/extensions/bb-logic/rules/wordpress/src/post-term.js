const { addRuleType, getPermalinks } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-term', {
	label: __( 'Post Taxonomy Term' ),
	category: 'post',
	form: ( { rule } ) => {
		const { taxonomy } = rule
		var permalink = getPermalinks()
		return {
			operator: {
				type: 'operator',
				operators: [
					'equals',
					'does_not_equal',
				],
			},
			taxonomy: {
				type: 'select',
				route: 'bb-logic/v1/wordpress/taxonomies',
			},
			term: {
				type: 'select',
				route: taxonomy ? `bb-logic/v1/wordpress/terms${ permalink }taxonomy=${ taxonomy }` : null,
				visible: taxonomy,
			},
		}
	},
} )
