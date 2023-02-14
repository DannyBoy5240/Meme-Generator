import React, { Component } from 'react'
import AsyncSelect from 'react-select/Async'
import { __ } from '../../i18n'
import withRequest from '../higher-order/with-request'
import './select.scss'

/**
 * A select input field with suggest functionality.
 *
 * @since 0.1
 * @class SuggestField
 */
class SuggestField extends Component {
	constructor( props ) {
		super( props )
		this.requestTimeout = null
	}

	render() {
		const { name, value, placeholder } = this.props
		return (
			<AsyncSelect
				name={ name }
				value={ this.getValue() }
				loadOptions={ this.loadOptions.bind( this ) }
				onChange={ this.onChange.bind( this ) }
				placeholder={ placeholder }
				menuPlacement={ 'auto' }
				maxMenuHeight={ 240 }
				noOptionsMessage={ () => __( 'Type to search...' ) }
				scrollMenuIntoView={ false }
				className='react-select__container'
				classNamePrefix='react-select'
			/>
		)
	}

	getValue() {
		const { value } = this.props

		if ( value ) {
			return {
				label: value,
				value,
			}
		}

		return null
	}

	loadOptions( value, callback ) {
		const { route, request } = this.props

		if ( this.requestTimeout ) {
			clearTimeout( this.requestTimeout )
		}

		this.requestTimeout = setTimeout( () => {
			request( route.replace( '{search}', value ), callback )
		}, 250 )
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
}

export default withRequest( SuggestField )
