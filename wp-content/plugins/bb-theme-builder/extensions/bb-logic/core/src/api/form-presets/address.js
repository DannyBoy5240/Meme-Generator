import { __ } from '../../i18n'

export const addressForm = {
	part: {
		type: 'select',
		options: [
			{
				label: __( 'address line 1' ),
				value: 'address_1',
			},
			{
				label: __( 'address line 2' ),
				value: 'address_2',
			},
			{
				label: __( 'city' ),
				value: 'city',
			},
			{
				label: __( 'state' ),
				value: 'state',
			},
			{
				label: __( 'zip/postcode' ),
				value: 'postcode',
			},
			{
				label: __( 'country' ),
				value: 'country',
			},
		]
	},
	operator: {
		type: 'operator',
		operators: [
			'equals',
			'does_not_equal',
			'starts_with',
			'ends_with',
			'contains',
			'does_not_contain',
		],
	},
	compare: {
		type: 'text',
	},
}
