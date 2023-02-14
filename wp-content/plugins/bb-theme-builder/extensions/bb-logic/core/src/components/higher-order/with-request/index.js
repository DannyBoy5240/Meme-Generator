import React, { Component } from 'react'
import 'whatwg-fetch'

/**
 * Cached response data.
 *
 * @since 0.1
 * @type {Object}
 */
const cache = {}

/**
 * Higher order component for making basic fetch GET
 * requests with response caching and a callback.
 *
 * @since 0.1
 * @class withRequest
 */
const withRequest = ( WrappedComponent ) => {
	class Request extends Component {
		constructor( props ) {
			super( props )
			this.state = {
				requests: {},
			}
		}

		request( route, callback = () => {} ) {
			const { root, headers } = BBLogic.request

			if ( ! route ) {
				return
			}

			if ( cache[ route ] ) {
				this.requestComplete( route, cache[ route ], callback )
			} else {
				fetch( root + route, {
					headers,
					credentials: 'same-origin',
				} ).then( ( response ) => {
					return response.json()
				} ).then( ( data ) => {
					this.requestComplete( route, data, callback )
				} )
			}
		}

		requestComplete( route, data, callback ) {
			const { requests } = this.state
			requests[ route ] = data
			cache[ route ] = data
			this.setState( { requests } )
			callback( data )
		}

		render() {
			return (
				<WrappedComponent
					{ ...this.props }
					request={ this.request.bind( this ) }
					requests={ this.state.requests }
				/>
			);
		}
	}

	return Request
}

export default withRequest
