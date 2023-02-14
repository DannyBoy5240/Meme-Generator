import { __ } from '../../i18n'

export const numberForm = {
	operator: {
		type: 'operator',
		operators: [
			'equals',
			'does_not_equal',
			'is_less_than',
			'is_less_than_or_equal_to',
			'is_greater_than',
			'is_greater_than_or_equal_to',
		],
	},
	compare: {
		type: 'number',
		defaultValue: '0',
	},
}
