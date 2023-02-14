import React, { Component } from 'react'
import { getDefaultOperators } from '../../api'
import { __ } from '../../i18n'
import SelectField from './select'

/**
 * A component that wraps a select component for defining
 * operator options such as equals and does_not_equal.
 *
 * @since 0.1
 * @class OperatorField
 */
class OperatorField extends Component {
	getOptions() {
		const { operators } = this.props
		const options = []
		const presets = getDefaultOperators()

		operators.map( ( operator ) => {
			if ( presets[ operator ] ) {
				options.push( {
					label: presets[ operator ],
					value: operator,
				} )
			}
		} )

		return options
	}

	render() {
		return (
			<SelectField
				options={ this.getOptions() }
				{ ...this.props }
			/>
		)
	}
}

export default OperatorField
