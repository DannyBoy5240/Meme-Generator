import React, { Component } from 'react'

/**
 * A simple button component.
 *
 * @since 0.1
 * @class Button
 */
class Button extends Component {
	render() {
		const { label, className, onClick } = this.props
		return (
			<button
				className={ className }
				onClick={ ( e ) => {
					e.preventDefault();
					onClick( e );
				} }
			>
				{ label }
			</button>
		)
	}
}

export default Button
