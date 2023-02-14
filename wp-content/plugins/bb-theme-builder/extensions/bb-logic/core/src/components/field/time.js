import React, { Component } from 'react'
import DatetimeField from './datetime'

/**
 * Renders a text input with a time picker.
 *
 * @since 0.1
 * @class DateField
 */
class TimeField extends Component {
	render() {
		return (
			<DatetimeField
				mode={ 'time' }
				{ ...this.props }
			/>
		)
	}
}

export default TimeField
