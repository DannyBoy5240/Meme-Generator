const { addRuleType } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/cart', {
	label: __( 'Cart' ),
	category: 'woocommerce',
	form: {
		operator: {
			type: 'operator',
			operators: [
				'is_empty',
				'is_not_empty',
			],
		},
	},
} )
