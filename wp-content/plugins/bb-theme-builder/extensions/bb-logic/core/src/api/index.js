import { __ } from '../i18n'
import { addressForm } from './form-presets/address'
import { dateForm } from './form-presets/date'
import { keyValueForm } from './form-presets/key-value'
import { numberForm } from './form-presets/number'
import { stringForm } from './form-presets/string'
import { shortcodeForm } from './form-presets/shortcode'

/**
 * Rule type categories.
 *
 * @since 0.1
 * @type {Object}
 */
const categories = {
	general: {
		label: 'General',
	},
}

/**
 * Rule type settings.
 *
 * @since 0.1
 * @type {Object}
 */
const types = {}

/**
 * Default operators used with the operator field.
 * If you want to define custom operators you can
 * use a select field with your own labels and values.
 *
 * @since 0.1
 * @type {Object}
 */
const operators = {
	equals: __( 'equals' ),
	does_not_equal: __( 'does not equal' ),
	is_less_than: __( 'is less than' ),
	is_less_than_or_equal_to: __( 'is less than or equal to' ),
	is_greater_than: __( 'is greater than' ),
	is_greater_than_or_equal_to: __( 'is greater than or equal to' ),
	starts_with: __( 'starts with' ),
	ends_with: __( 'ends with' ),
	contains: __( 'contains' ),
	does_not_contain: __( 'does not contain' ),
	include: __( 'include' ),
	includes: __( 'includes' ),
	do_not_include: __( 'do not include' ),
	does_not_include: __( 'does not include' ),
	is_set: __( 'is set' ),
	is_not_set: __( 'is not set' ),
	is_empty: __( 'is empty' ),
	is_not_empty: __( 'is not empty' ),
	on: __( 'on' ),
	is_on: __( 'is on' ),
	not_on: __( 'not on' ),
	is_not_on: __( 'is not on' ),
	before: __( 'before' ),
	is_before: __( 'is before' ),
	on_or_before: __( 'on or before' ),
	is_on_or_before: __( 'is on or before' ),
	after: __( 'after' ),
	is_after: __( 'is after' ),
	on_or_after: __( 'on or after' ),
	is_on_or_after: __( 'is on or after' ),
	within: __( 'within' ),
	is_within: __( 'is within' ),
	not_within: __( 'not within' ),
	is_not_within: __( 'is not within' ),
	between: __( 'between' ),
	is_between: __( 'is between' ),
	not_between: __( 'not between' ),
	is_not_between: __( 'is not between' ),
	in_the_past: __( 'in the past' ),
	over: __( 'over' ),
}

/**
 * Form presets.
 *
 * @since 0.1
 * @type {Object}
 */
const formPresets = {
	'address': addressForm,
	'date': dateForm,
	'key-value': keyValueForm,
	'number': numberForm,
	'string': stringForm,
	'shortcode': shortcodeForm,
}

/**
 * Adds a new rule type category.
 *
 * @since 0.1
 * @param {String} key
 * @param {Object} props
 */
export function addRuleTypeCategory( key, props ) {
	categories[ key ] = props
}

/**
 * Returns all rule type categories.
 *
 * @since 0.1
 * @return {Object}
 */
export function getRuleTypeCategories() {
	return categories
}

/**
 * Removes an existing rule type.
 *
 * @since 0.1
 * @param {String} key
 */
export function removeRuleType( key ) {
	types[ key ] = null
	delete types[ key ]
}

/**
 * Removes rule types by category key.
 *
 * @since 1.0
 * @param {String} key
 */
export function removeRuleTypesByCategory( key ) {
	for ( let type in types ) {
		if ( key === types[ type ].category ) {
			removeRuleType( type )
		}
	}
}

/**
 * Adds a new rule type.
 *
 * @since 0.1
 * @param {String} key
 * @param {Object} props
 */
export function addRuleType( key, props ) {
	types[ key ] = props
}

/**
 * Returns all rule types.
 *
 * @since 0.1
 * @return {Object}
 */
export function getRuleTypes() {
	return types
}

/**
 * Returns a single rule type.
 *
 * @since 0.1
 * @param {String} type
 * @return {Object}
 */
export function getRuleType( type ) {
	return types[ type ] ? types[ type ] : null
}

/**
 * Returns the processed form config for a rule.
 *
 * @since 0.1
 * @param {String} type
 * @param {Object} rule
 * @return {Object}
 */
export function getRuleFormConfig( type, rule = {} ) {
	if ( type && types[ type ] ) {
		const { form } = getRuleType( type )
		return 'function' === typeof form ? form( { rule } ) : form
	}
	return null
}

/**
 * Returns all default rule operators.
 *
 * @since 0.1
 * @return {Object}
 */
export function getDefaultOperators() {
	return operators
}

/**
 * Returns the default rule operator.
 *
 * @since 0.1
 * @return {String}
 */
export function getDefaultOperator() {
	return Object.keys( operators )[0]
}

/**
 * Returns the config for a form preset.
 *
 * @since 0.1
 * @return {Object}
 */
export function getFormPreset( type ) {
	return formPresets[ type ]
}

export function getPermalinks() {
	return window.FLBuilderConfig.logicPermalinks ? '?' : '&'
}
