<?php

if ( ! empty( $settings->block_id ) ) {
	$id = str_replace( 'block-', '', $settings->block_id );
	echo do_blocks( '<!-- wp:block {"ref":' . $id . '} /-->' );
}
