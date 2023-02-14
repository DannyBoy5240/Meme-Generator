<span class="fl-builder-button fl-builder-logic-button">
	<?php _e( 'Open Conditional Logic Settings', 'bb-theme-builder' ); ?>
</span>
<# var value = 'object' === typeof data.value ? JSON.stringify( data.value ) : '[]'; #>
<input name="{{data.name}}" type="hidden" value='{{{value}}}' />
