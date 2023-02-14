const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'wordpress/post-featured-image', {
	label: __( 'Post Featured Image' ),
	category: 'post',
	form: {
		operator: {
			type: 'operator',
			operators: [
				'is_set',
				'is_not_set',
			],
		},
	},
} )
