import React, { Component } from 'react'
import DatetimeField from './datetime'

/**
 * Renders a text input with a date picker.
 *
 * @since 0.1
 * @class DateField
 */
class DateField extends Component {
	render() {
		return (
			<DatetimeField
				mode={ 'date' }
				{ ...this.props }
			/>
		)
	}
}

export default DateField
