import React, { Component } from 'react'
import classnames from 'classnames'
import { getRuleFormConfig } from '../../api'
import { __ } from '../../i18n'
import Button from '../button'
import ErrorBoundary from '../error-boundary'
import RuleGroup from '../rule-group'
import withRequest from '../higher-order/with-request'

/**
 * Renders the main rule form for conditional logic.
 *
 * @since 0.1
 * @class RuleForm
 */
class RuleForm extends Component {
	static defaultProps = {
		display: 'inline', // inline or lightbox
		renderHeader: true,
		renderDefaultRule: true,
		renderSaveButton: true,
		renderCancelButton: true,
		className: '',
		buttonClassName: '',
		rules: [],
	}

	constructor( props ) {
		super( props )
		const { rules } = this.props
		this.state = {
			rules,
		}
	}

	componentDidMount() {
		const { rules } = this.state
		rules.map( ( group ) => {
			group.map( ( rule ) => {
				this.requestRuleFieldData( rule )
			} )
		} )
	}

	addRule( group ) {
		const { rules } = this.state
		rules[ group ].push( { type: '' } )
		this.setState( { rules } )
		this.onChange()
	}

	updateRule( group, rule, data ) {
		const { rules } = this.state
		rules[ group ][ rule ] = data
		this.setState( { rules } )
		this.onChange()
		this.requestRuleFieldData( data )
	}

	removeRule( group, rule ) {
		const { rules } = this.state
		rules[ group ].splice( rule, 1 )

		if ( 0 === rules[ group ].length ) {
			rules.splice( group, 1 )
		}

		this.setState( { rules } )
		this.onChange()
	}

	requestRuleFieldData( data ) {
		const { request } = this.props
		const config = getRuleFormConfig( data.type, data )

		if ( config ) {
			for ( const key in config ) {
				request( config[ key ].route )
			}
		}
	}

	onChange() {
		const { onChange } = this.props
		if ( onChange ) {
			onChange( this.getRulesForSave() )
		}
	}

	getRulesForSave() {
		const { rules } = this.state
		return rules.map( ( group ) => {
			return group.filter( ( rule ) => {
				return rule.type
			} )
		} ).filter( ( group ) => {
			return group.length
		} )
	}

	render() {
		const { rules } = this.state
		const {
			display,
			renderHeader,
			renderDefaultRule,
			renderSaveButton,
			renderCancelButton,
			className,
			buttonClassName,
			onSave,
			onCancel,
			requests
		} = this.props
		const renderButtons = renderSaveButton || renderCancelButton

		if ( renderDefaultRule && ! rules.length ) {
			rules.push( [ {
				type: '',
			} ] )
		}

		if ( ( ! renderDefaultRule && ! rules.length ) || rules[ rules.length - 1 ].length > 0 ) {
			rules.push( [] )
		}

		return (
			<ErrorBoundary>
				<div className={ `bb-logic bb-logic-display-${ display }` }>
					<div className={ classnames( 'bb-logic-content', className ) }>
						{ renderHeader &&
							<div className="bb-logic-header">
								<div className="bb-logic-heading">
									{ __( 'Conditional Logic Settings' ) }
								</div>
								<div className="bb-logic-description">
									{ __( 'Display this content if the following conditions are met...' ) }
								</div>

							</div>
						}
						<div className="bb-logic-rules">
							{ rules.map( ( group, index ) =>
								<RuleGroup
									key={ index }
									group={ index }
									data={ group }
									requests={ requests }
									isLast={ index === rules.length - 1  }
									addRule={ this.addRule.bind( this ) }
									updateRule={ this.updateRule.bind( this ) }
									removeRule={ this.removeRule.bind( this ) }
									buttonClassName={ buttonClassName }
								/>
							) }
						</div>
						{ renderButtons &&
							<div className="bb-logic-buttons">
								{ renderSaveButton &&
									<Button
										label={ __( 'Save' ) }
										className={ classnames( 'bb-logic-save', buttonClassName ) }
										onClick={ () => onSave( this.getRulesForSave() ) }
									/>
								}
								{ renderCancelButton &&
									<Button
										label={ __( 'Cancel' ) }
										className={ classnames( 'bb-logic-cancel', buttonClassName ) }
										onClick={ onCancel }
									/>
								}
							</div>
						}
						<input
							type='hidden'
							name='bb-logic-json'
							value={ JSON.stringify( this.getRulesForSave() ) }
						/>
					</div>
				</div>
			</ErrorBoundary>
		)
	}
}

export default withRequest( RuleForm )
