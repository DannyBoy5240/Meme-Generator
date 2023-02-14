const { addRuleType, getPermalinks } = BBLogic.api
const { __ } = BBLogic.i18n
var permalink = getPermalinks()
addRuleType( 'woocommerce/customer-products-purchased', {
	label: __( 'Customer Products Purchased' ),
	category: 'woocommerce',
	form: {
		operator: {
			type: 'operator',
			operators: [
				'include',
				'do_not_include',
			],
		},
		compare: {
			type: 'select',
			route: `bb-logic/v1/wordpress/posts${ permalink }post_type=product`,
		},
	},
} )
