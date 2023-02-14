const { addRuleTypeCategory } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleTypeCategory( 'woocommerce', {
	label: __( 'WooCommerce' )
} )

import './customer-products-purchased'
import './customer-first-ordered'
import './customer-last-ordered'
import './customer-total-orders'
import './customer-total-products'
import './customer-total-spent'
import './customer-billing-address'
import './customer-shipping-address'
import './cart'
import './cart-products'
import './cart-total'
