import React, { Component } from 'react'

/**
 * Renders a standard form input.
 *
 * @since 0.1
 * @class InputField
 */
class InputField extends Component {
	render() {
		const { name, type, value, placeholder, onChange } = this.props

		return (
			<input
				name={ name }
				type={ type }
				value={ value }
				placeholder={ placeholder }
				onChange={ onChange }
			/>
		)
	}
}

export default InputField
