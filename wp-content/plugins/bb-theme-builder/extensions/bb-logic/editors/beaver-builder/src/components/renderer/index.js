import React, { Component } from 'react'

const { RuleForm } = BBLogic.components

/**
 * Handles rendering of the conditional logic form
 * within the Beaver Builder UI.
 *
 * @since 0.1
 * @class Renderer
 */
class Renderer extends Component {
	constructor( props ) {
		super( props )
		const { root, nonce } = wpApiSettings
		this.state = {
			input: null,
			render: false,
		}
		BBLogic.request = {
			root,
			headers: {
				'X-WP-Nonce': nonce,
			},
		}
	}

	componentDidMount() {
		jQuery( 'body' ).delegate(
			'.fl-builder-logic-button',
			'click',
			this.onLogicButtonClicked.bind( this )
		)
	}

	onLogicButtonClicked( e ) {
		const button = jQuery( e.target )
		this.setState( {
			input: button.siblings( 'input' ),
			render: true,
		} )
	}

	onSaveButtonClicked( rules ) {
		const { input } = this.state
		input.val( JSON.stringify( rules ) )
		this.setState( {
			input: null,
			render: false,
		} )
	}

	onCancelButtonClicked() {
		this.setState( {
			input: null,
			render: false,
		} )
	}

	render() {
		const { input, render } = this.state
		return (
			render ?
			<RuleForm
				display='lightbox'
				rules={ JSON.parse( input.val() ) }
				onSave={ this.onSaveButtonClicked.bind( this ) }
				onCancel={ this.onCancelButtonClicked.bind( this ) }
				className={ 'fl-builder-settings-fields' }
				buttonClassName={ 'fl-builder-button' }
			/>
			: null
		)
	}
}

export default Renderer
