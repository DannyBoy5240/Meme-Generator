import React, { Component } from 'react'
import { __ } from '../../i18n'
import { getRuleFormConfig, getDefaultOperator } from '../../api'
import Button from '../button'
import { DismissIcon } from '../icons'
import Field from '../field'
import TypeSelect from './type-select'

/**
 * Class for rendering a single rule.
 *
 * @since 0.1
 * @class Rule
 */
class Rule extends Component {
	constructor( props ) {
		super( props )
	}

	render() {
		const {
			data,
			group,
			rule,
			isLast,
			removeRule
		} = this.props

		return (
			<div className='bb-logic-rule'>
				<div className='bb-logic-rule-fields'>
					<TypeSelect
						name={ `bb-logic[${ group }][${ rule }][type]` }
						value={ data.type }
						onChange={ this.onTypeChange.bind( this ) }
					/>
					{ this.renderFields() }
				</div>
				<Button
					label={ <DismissIcon /> }
					className='bb-logic-rule-delete'
					onClick={ () => removeRule( group, rule ) }
				/>
			</div>
		)
	}

	renderFields() {
		const { data, group, rule, requests } = this.props
		const config = getRuleFormConfig( data.type, data )
		const fields = []

		if ( ! config ) {
			return null
		}

		for ( let key in config ) {
			const { visible } = config[ key ]

			if ( 'undefined' !== typeof visible && ! visible ) {
				continue;
			}

			fields.push(
				<Field
					key={ key }
					name={ `bb-logic[${ group }][${ rule }][${ key }]` }
					value={ data[ key ] }
					onChange={ this.onFieldChange.bind( this ) }
					data={ data }
					requests={ requests }
					{ ...config[ key ] }
				/>
			)
		}

		return fields
	}

	onTypeChange( e ) {
		const { group, rule, updateRule } = this.props
		const type = e.target.value

		updateRule( group, rule, {
			type,
			...this.getFieldDefaults( type )
		} )
	}

	onFieldChange( e ) {
		const { group, rule, data, updateRule } = this.props
		const { name, value } = e.target
		const key = name.split( '[' ).pop().replace( ']', '' )
		data[ key ] = value
		updateRule( group, rule, data )
	}

	getFieldDefaults( type ) {
		const config = getRuleFormConfig( type )
		const defaults = {}

		if ( config ) {
			for ( let key in config  ) {
				let field = config[ key ]

				if ( 'select' === field.type && field.options ) {
					defaults[ key ] = field.options[0].value
				} else if ( 'operator' === field.type ) {
					defaults[ key ] = field.operators ? field.operators[0] : getDefaultOperator()
				} else {
					defaults[ key ] = field.defaultValue ? field.defaultValue : ''
				}
			}
		}

		return defaults
	}
}

export default Rule
