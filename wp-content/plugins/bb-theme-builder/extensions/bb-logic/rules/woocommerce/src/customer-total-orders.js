const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/customer-total-orders', {
	label: __( 'Customer Total Orders' ),
	category: 'woocommerce',
	form: getFormPreset( 'number' ),
} )
