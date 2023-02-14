const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/customer-shipping-address', {
	label: __( 'Customer Shipping Address' ),
	category: 'woocommerce',
	form: getFormPreset( 'address' ),
} )
