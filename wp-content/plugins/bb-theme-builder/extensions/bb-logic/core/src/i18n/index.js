/**
 * This is a placeholder until we get i18n
 * figured out properly.
 *
 * @since 0.1
 * @param {String} string
 * @return {String}
 */
export function __( string ) {

	var strings = window.LogicI18n;

	if (typeof strings[string] !== 'undefined') {
  	return strings[string];
	} else {
		console.log( 'No translation found for ' + string )
		return string;
	}
}
