const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/customer-first-ordered', {
	label: __( 'Customer First Ordered' ),
	category: 'woocommerce',
	form: getFormPreset( 'date' ),
} )
