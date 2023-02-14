const { addRuleTypeCategory } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleTypeCategory( 'browser', {
	label: __( 'Browser' )
} )

import './cookie'
import './referer'
import './url-variable'
