import React from 'react'

/**
 * Catches errors in the UI and logs the to the console.
 *
 * @since 0.1
 * @class ErrorBoundary
 */
class ErrorBoundary extends React.Component {
	constructor( props ) {
		super( props )
		this.state = { hasError: false }
	}

	componentDidCatch( error, info ) {
		this.setState( { hasError: true } )
		console.log( 'UI Error:', error, info )
	}

	render() {
		return this.props.children
	}
}

export default ErrorBoundary
