const { addRuleTypeCategory } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleTypeCategory( 'acf', {
	label: __( 'Advanced Custom Fields' )
} )

import './archive-field'
import './post-field'
import './post-author-field'
import './user-field'
import './option-field'
