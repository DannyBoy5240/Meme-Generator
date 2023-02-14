import React, { Component } from 'react'

const { removeRuleType, removeRuleTypesByCategory } = BBLogic.api
const { RuleForm } = BBLogic.components
const { __ } = BBLogic.i18n

/**
 * Handles rendering of the conditional logic form
 * within the Beaver Themer UI.
 *
 * @since 0.1
 * @class Renderer
 */
class Renderer extends Component {
	constructor( props ) {
		super( props )
		const { root, nonce } = wpApiSettings
		BBLogic.request = {
			root,
			headers: {
				'X-WP-Nonce': nonce,
			},
		}
		this.removeRules()
	}

	removeRules() {
		// These rules aren't necessary since Themer has "locations."
		removeRuleType( 'wordpress/archive' )
		removeRuleType( 'wordpress/archive-term' )
		removeRuleType( 'wordpress/post' )
		removeRuleType( 'wordpress/post-parent' )
		removeRuleType( 'wordpress/post-type' )
		removeRuleType( 'wordpress/post-term' )

		// Don't show post rules for archives.
		if ( 'archive' === FLThemeBuilderConfig.layoutType ) {
			removeRuleTypesByCategory( 'author' )
			removeRuleTypesByCategory( 'post' )
			removeRuleType( 'acf/post-field' )
			removeRuleType( 'acf/post-author-field' )
		}

		// Don't show archive rules for singular.
		if ( 'singular' === FLThemeBuilderConfig.layoutType ) {
			removeRuleTypesByCategory( 'archive' )
			removeRuleType( 'acf/archive-field' )
		}

		// Don't show archive or post rules for 404.
		if ( '404' === FLThemeBuilderConfig.layoutType ) {
			removeRuleTypesByCategory( 'archive' )
			removeRuleTypesByCategory( 'author' )
			removeRuleTypesByCategory( 'post' )
			removeRuleType( 'acf/archive-field' )
			removeRuleType( 'acf/post-field' )
			removeRuleType( 'acf/post-author-field' )
		}
	}

	render() {
		return (
			<table className="fl-mb-table widefat">
				<tbody>
					<tr className="fl-mb-row">
						<td className="fl-mb-row-heading">
							<label>{ __( 'Rules' ) }</label>
							<i
								className="fl-mb-row-heading-help dashicons dashicons-editor-help"
								title={ __( 'Additional rules to determine if this layout should be displayed.' ) }
							></i>
						</td>
						<td className="fl-mb-row-content">
							<RuleForm
								display={ 'inline' }
								renderHeader={ false }
								renderDefaultRule={ false }
								renderSaveButton={ false }
								renderCancelButton={ false }
								buttonClassName={ 'button' }
								rules={ BBLogicRules }
							/>
						</td>
					</tr>
				</tbody>
			</table>
		)
	}
}

export default Renderer
