<?php

$data = array(
	'date'          => '[wpbb post:date format="' . $settings->date_format . '"]',
	'modified_date' => '[wpbb post:modified_date format="' . $settings->modified_date_format . '"]',
	'author'        => '[wpbb post:author_name link="' . $settings->show_author_link . '"]',
	'comments'      => '[wpbb post:comments_number link="1" none_text="' . $settings->none_text . '" one_text="' . $settings->one_text . '" more_text="' . $settings->more_text . '"]',
	'terms'         => '[wpbb post:terms_list taxonomy="' . $settings->terms_taxonomy . '" separator="' . $settings->terms_separator . '" display="' . $settings->terms_display . '"]',
);

for ( $i = 0; $i < count( $settings->order ); $i++ ) {

	$key = $settings->order[ $i ];

	if ( ! $settings->{ 'show_' . $key } ) {
		unset( $data[ $key ] );
	}
}

for ( $i = 0; $i < count( $settings->order ); $i++ ) {

	$key = $settings->order[ $i ];

	if ( ! isset( $data[ $key ] ) ) {
		continue;
	}

	$content = do_shortcode( $data[ $key ] );

	if ( empty( $content ) ) {
		continue;
	}

	if ( isset( $settings->{$key . '_prefix'} ) ) {
		$content = $settings->{$key . '_prefix'} . $content;
	}

	if ( 0 !== $i && count( $data ) > 1 ) {
		echo '<span class="fl-post-info-sep">' . $settings->separator . '</span>';
	}

	echo '<span class="fl-post-info-' . $key . '">';
	echo $content;
	echo '</span>';
}
