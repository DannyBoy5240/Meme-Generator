const { addRuleType, getPermalinks } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-parent', {
	label: __( 'Post Parent' ),
	category: 'post',
	form: ( { rule } ) => {
		const { posttype } = rule
		var permalink = getPermalinks()
		return {
			operator: {
				type: 'operator',
				operators: [
					'equals',
					'does_not_equal',
				],
			},
			posttype: {
				type: 'select',
				route: `bb-logic/v1/wordpress/post-types${ permalink }hierarchical=1`,
			},
			post: {
				type: 'select',
				route: posttype ? `bb-logic/v1/wordpress/posts${ permalink }post_type=${ posttype }` : null,
				visible: posttype,
			},
		}
	},
} )
