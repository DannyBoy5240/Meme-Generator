<?php

ob_start();
comments_template( '', true );
$comments = ob_get_clean();

if ( empty( $comments ) && FLBuilderModel::is_builder_active() ) {
	echo '<div class="fl-builder-module-placeholder-message">';
	_e( 'Comments', 'bb-theme-builder' );
	echo '</div>';
} else {
	echo $comments;
}
