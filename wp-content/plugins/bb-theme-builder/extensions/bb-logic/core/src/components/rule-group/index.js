import React, { Component } from 'react'
import classnames from 'classnames'
import { __ } from '../../i18n'
import Button from '../button'
import Rule from '../rule'

/**
 * Class for rendering rule groups.
 *
 * @since 0.1
 * @class RuleGroup
 */
class RuleGroup extends Component {
	render() {
		const {
			group,
			data,
			isLast,
			addRule,
			updateRule,
			removeRule,
			requests,
			buttonClassName
		} = this.props

		return (
			<div className='bb-logic-rule-group'>
				<div className='bb-logic-rule-group-rules'>
					{ data.map( ( rule, index ) =>
						<Rule
							key={ index }
							group={ group }
							rule={ index }
							data={ rule }
							requests={ requests }
							isLast={ index === data.length - 1 }
							updateRule={ updateRule }
							removeRule={ removeRule }
						/>
					) }
					<Button
						label={ isLast ? __( 'Add Rule Group' ) : __( 'Add Rule' ) }
						className={ classnames( 'bb-logic-add-rule', buttonClassName ) }
						onClick={ () => addRule( group ) }
					/>
				</div>
				{ ! isLast &&
					<div className="bb-logic-rule-group-separator">
						{ __( 'or' ) }
					</div>
				}
			</div>
		)
	}
}

export default RuleGroup
