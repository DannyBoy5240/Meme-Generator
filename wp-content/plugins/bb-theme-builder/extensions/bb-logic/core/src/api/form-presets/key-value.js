import { __ } from '../../i18n'

export function keyValueForm( { rule } ) {
	const { operator } = rule
	return {
		key: {
			type: 'text',
			placeholder: __( 'Key' ),
		},
		operator: {
			type: 'operator',
			operators: [
				'equals',
				'does_not_equal',
				'is_less_than',
				'is_less_than_or_equal_to',
				'is_greater_than',
				'is_greater_than_or_equal_to',
				'starts_with',
				'ends_with',
				'contains',
				'does_not_contain',
				'is_set',
				'is_not_set',
			],
		},
		compare: {
			type: 'text',
			placeholder: __( 'Value' ),
			visible: 'is_set' !== operator && 'is_not_set' !== operator,
		},
	}
}
