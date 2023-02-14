const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/customer-total-products', {
	label: __( 'Customer Total Products' ),
	category: 'woocommerce',
	form: getFormPreset( 'number' ),
} )
