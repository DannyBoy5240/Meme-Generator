const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/customer-last-ordered', {
	label: __( 'Customer Last Ordered' ),
	category: 'woocommerce',
	form: getFormPreset( 'date' ),
} )
