const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/customer-billing-address', {
	label: __( 'Customer Billing Address' ),
	category: 'woocommerce',
	form: getFormPreset( 'address' ),
} )
