<script type="text/html" id="tmpl-fl-field-connections-menu">
	<div class="fl-field-connections-menu" data-field="{{data.fieldId}}">
		<input class="fl-field-connections-search" type="text" placeholder="<?php _e( 'Search...', 'bb-theme-builder' ); ?>" />
		<div class="fl-field-connections-groups">
		<# for ( var group in data.menuData ) { #>
			<div class="fl-field-connections-group">
				<div class="fl-field-connections-group-label">{{data.menuData[ group ].label}}</div>
				<div class="fl-field-connections-properties">
					<# for ( var object in data.menuData[ group ].properties ) { #>
						<# for ( var property in data.menuData[ group ].properties[ object ] ) { #>
						<# var hasToken = jQuery.inArray( data.fieldType, [ 'text', 'textarea', 'editor', 'code' ] ) > -1; #>
						<div class="fl-field-connections-property <# if ( hasToken ) { #>fl-field-connections-property-has-token<# } #>" data-object="{{object}}" data-property="{{property}}"<# if ( data.menuData[ group ].properties[ object ][ property ].form ) { #> data-form="{{data.menuData[ group ].properties[ object ][ property ].form.id}}"<# } #>>
							<div class="fl-field-connections-property-label">{{data.menuData[ group ].properties[ object ][ property ].label}}</div>
							<div class="fl-field-connections-property-connect"><?php _e( 'Connect', 'bb-theme-builder' ); ?></div>
							<# if ( hasToken ) { #>
							<div class="fl-field-connections-property-token" data-token="{{object}}:{{property}}"><?php _e( 'Insert', 'bb-theme-builder' ); ?></div>
							<# } #>
						</div>
						<# } #>
					<# } #>
				</div>
			</div>
		<# } #>
		</div>
	</div>
</script>
