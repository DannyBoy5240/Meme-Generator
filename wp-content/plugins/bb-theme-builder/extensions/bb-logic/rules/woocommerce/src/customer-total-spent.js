const { addRuleType, getFormPreset } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleType( 'woocommerce/customer-total-spent', {
	label: __( 'Customer Total Spent' ),
	category: 'woocommerce',
	form: getFormPreset( 'number' ),
} )
