import React, { Component } from 'react'
import Select from 'react-select'
import { __ } from '../../i18n'
import './select.scss'

/**
 * Renders a react-select field with the given options.
 *
 * @since 0.1
 * @class SelectField
 */
class SelectField extends Component {
	render() {
		const { name } = this.props
		return (
			<Select
				name={ name }
				value={ this.getValue() }
				options={ this.getOptions() }
				onChange={ this.onChange.bind( this ) }
				menuPlacement={ 'auto' }
				maxMenuHeight={ 235 }
				noOptionsMessage={ () => __( 'No results found.' ) }
				placeholder={ __( 'Choose...' ) }
				scrollMenuIntoView={ false }
				className='react-select__container'
				classNamePrefix='react-select'
			/>
		)
	}

	onChange( { value } ) {
		const { name, onChange } = this.props
		onChange( {
			target: {
				name,
				value,
			}
		} )
	}

	getOptions() {
		const { options, route, requests } = this.props
		const dynamicOptions = [ {
			label: __( 'Choose...' ),
			value: '',
		} ]

		if ( route ) {
			const response = requests[ route ]
			return response ? dynamicOptions.concat( response ) : dynamicOptions
		} else if ( ! options ) {
			return dynamicOptions
		}

		return options
	}

	getValue( options = null ) {
		const { value } = this.props

		if ( ! options ) {
			options = this.getOptions()
		}

		for ( let i = 0; i < options.length; i++ ) {
			if ( options[ i ].options ) {
				let child = this.getValue( options[ i ].options )
				if ( child ) {
					return child
				}
			} else if ( value === options[ i ].value ) {
				return options[ i ]
			}
		}

		return null
	}
}

export default SelectField
