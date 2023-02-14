import React, { Component } from 'react'
import { __ } from '../../i18n'
import { getRuleTypeCategories, getRuleTypes } from '../../api'
import Field from '../field'

/**
 * Renders the rule type select.
 *
 * @since 0.1
 * @class TypeSelect
 */
class TypeSelect extends Component {
	getOptions() {
		const categories = getRuleTypeCategories()
		const types = getRuleTypes()
		const categorized = {}
		const options = [ {
			label: __( 'Choose...' ),
			value: '',
		} ]

		for ( let type in types ) {
			let category = types[ type ].category

			if ( ! categories[ category ] ) {
				category = 'general'
			}

			if ( ! categorized[ category ] ) {
				categorized[ category ] = {
					label: categories[ category ].label,
					options: [],
				}
			}

			categorized[ category ].options.push( {
				label: types[ type ].label,
				value: type,
			} )
		}

		for ( let category in categorized ) {
			options.push( categorized[ category ] )
		}

		return options
	}

	render() {
		const { name, value, onChange } = this.props
		return (
			<Field
				name={ name }
				type='select'
				value={ value }
				options={ this.getOptions() }
				onChange={ onChange }
			/>
		)
	}
}

export default TypeSelect
