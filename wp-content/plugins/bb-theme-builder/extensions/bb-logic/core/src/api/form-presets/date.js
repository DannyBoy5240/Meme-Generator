import { __ } from '../../i18n'

export function dateForm( { rule } ) {
	const { operator } = rule
	return {
		operator: {
			type: 'operator',
			operators: [
				'in_the_past',
				'over',
				'on',
				'before',
				'on_or_before',
				'after',
				'on_or_after',
				'between',
			],
		},
		duration: {
			type: 'number',
			visible: 'in_the_past' === operator || 'over' === operator,
			defaultValue: 7,
		},
		period: {
			type: 'select',
			visible: 'in_the_past' === operator || 'over' === operator,
			options: [ {
				label: 'over' === operator ? __( 'minute(s) ago' ) : __( 'minute(s)' ),
				value: 'minutes',
			}, {
				label: 'over' === operator ? __( 'hour(s) ago' ) : __( 'hour(s)' ),
				value: 'hours',
			}, {
				label: 'over' === operator ? __( 'day(s) ago' ) : __( 'day(s)' ),
				value: 'days',
			}, {
				label: 'over' === operator ? __( 'week(s) ago' ) : __( 'week(s)' ),
				value: 'weeks',
			}, {
				label: 'over' === operator ? __( 'month(s) ago' ) : __( 'month(s)' ),
				value: 'months',
			}, {
				label: 'over' === operator ? __( 'year(s) ago' ) : __( 'year(s)' ),
				value: 'years',
			} ],
		},
		start: {
			type: 'date',
			visible: 'in_the_past' !== operator && 'over' !== operator,
		},
		end: {
			type: 'date',
			visible: 'between' === operator,
		},
	}
}
