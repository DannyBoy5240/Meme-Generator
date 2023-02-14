const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/cart-total', {
	label: __( 'Cart Total' ),
	category: 'woocommerce',
	form: getFormPreset( 'number' ),
} )
