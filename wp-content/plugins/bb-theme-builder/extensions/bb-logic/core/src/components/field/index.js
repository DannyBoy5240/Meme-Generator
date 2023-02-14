import React, { Component, Fragment } from 'react'
import DateField from './date'
import DatetimeField from './datetime'
import InputField from './input'
import OperatorField from './operator'
import SelectField from './select'
import SuggestField from './suggest'
import TimeField from './time'

/**
 * Renders a form field of the given type.
 *
 * @since 0.1
 * @class Field
 */
class Field extends Component {
	renderField() {
		const { type } = this.props
		const fields = {
			'datetime': DatetimeField,
			'date': DateField,
			'input': InputField,
			'operator': OperatorField,
			'select': SelectField,
			'suggest': SuggestField,
			'time': TimeField,
		}
		const FieldType = fields[ type ] ? fields[ type ] : fields[ 'input' ]
		return <FieldType { ...this.props } />
	}

	render() {
		const { type, before, after } = this.props

		return (
			<Fragment>
				{ before &&
					<div className={ 'bb-logic-rule-field bb-logic-before-field' }>
						{ before }
					</div>
				}
				<div className={ `bb-logic-rule-field bb-logic-${ type }-field` }>
					{ this.renderField() }
				</div>
				{ after &&
					<div className={ 'bb-logic-rule-field bb-logic-after-field' }>
						{ after }
					</div>
				}
			</Fragment>
		)
	}
}

export default Field
