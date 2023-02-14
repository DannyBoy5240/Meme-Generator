import React, { Component } from 'react'
import Datetime from 'react-datetime'
import './date.scss'

/**
 * Renders a text input with a date and time picker.
 *
 * @since 0.1
 * @class DateField
 */
class DatetimeField extends Component {
	static defaultProps = {
		mode: 'datetime',
	}

	render() {
		const { mode, name, value, placeholder, onChange } = this.props

		return (
			<Datetime
				dateFormat={ 'datetime' === mode || 'date' === mode }
				timeFormat={ 'datetime' === mode || 'time' === mode }
				value={ value }
				onChange={ this.onChange.bind( this ) }
				inputProps={ {
					name,
					placeholder,
					onChange,
				} }
			/>
		)
	}

	onChange( moment ) {
		const { mode, name, onChange } = this.props
		const formats = {
			datetime: 'MM/DD/YYYY hh:mm A',
			date: 'MM/DD/YYYY',
			time: 'hh:mm A',
		}
		onChange( {
			target: {
				name,
				value: moment.format( formats[ mode ] ),
			}
		} )
	}
}

export default DatetimeField
