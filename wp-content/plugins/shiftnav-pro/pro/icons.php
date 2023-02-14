<?php

function shiftnav_register_icons( $group , $iconmap ){
	_SHIFTNAV()->register_icons( $group, $iconmap );
}

function shiftnav_deregister_icons( $group ){
	_SHIFTNAV()->deregister_icons( $group );
}
function shiftnav_get_registered_icons(){
	return _SHIFTNAV()->get_registered_icons();
}
function shiftnav_get_icon_ops(){

	$icons = shiftnav_get_registered_icons();

	$icon_select = array( '' => array( 'title' => 'None' ) );

	foreach( $icons as $icon_group => $group ){

		$iconmap = $group['iconmap'];
		$prefix = isset( $group['class_prefix'] ) ? $group['class_prefix'] : '';

		foreach( $iconmap as $icon_class => $icon ){

			$icon_select[$prefix.$icon_class] = $icon; //$icon['title']; //ucfirst( str_replace( '-' , ' ' , str_replace( 'icon-' , '' , $icon_class ) ) );

		}

	}

	return $icon_select;
}

function shiftnav_register_default_icons(){

	shiftnav_register_icons( 'font-awesome' , array(
		'title' => 'Font Awesome',
		'class_prefix' => 'fa ',
		'iconmap' => shiftnav_get_icons() 
	));

}

function shiftnav_get_icons(){

	/*
	$icons = array(
		
		'fa-search'	=>	array(
			'title'	=>	'Search',

		),
		'fa-envelope-o'	=>	array(
			'title'	=>	'Envelope (Outline)',
		),
		'fa-user'	=>	array(
			'title'	=>	'User',
		),
		'fa-home'	=>	array(
			'title'	=>	'Home',
		),
		'fa-tag'	=>	array(
			'title'	=>	'Tag',
		),
		'fa-book'	=>	array(
			'title'	=>	'Book',
		),
		'fa-bookmark'	=>	array(
			'title'	=>	'Bookmark',
		),
		'fa-pencil'	=>	array(
			'title'	=>	'Pencil',
		),
		'fa-chevron-right'	=>	array(
			'title'	=>	'Chevron Right',
		),
		'fa-phone'	=>	array(
			'title'	=>	'Phone',
		),
		'fa-briefcase'	=>	array(
			'title'	=>	'Briefcase',
		),
		'fa-cloud'	=>	array(
			'title'	=>	'Cloud',
		),
		'fa-tachometer'	=>	array(
			'title'	=>	'Tachometer',
		),
		'fa-desktop'	=>	array(
			'title'	=>	'Desktop',
		),
		'fa-laptop'	=>	array(
			'title'	=>	'Laptop',
		),
		'fa-tablet'	=>	array(
			'title'	=>	'Tablet',
		),
		'fa-mobile'	=>	array(
			'title'	=>	'Mobile',
		),
		'fa-bullseye'	=>	array(
			'title'	=>	'Bullseye',
		),
		'fa-compass'	=>	array(
			'title'	=>	'Compass',
		),
		'fa-usd'	=>	array(
			'title'	=>	'Usd',
		),
		'fa-thumbs-up'	=>	array(
			'title'	=>	'Thumbs Up',
		),
		'fa-female'	=>	array(
			'title'	=>	'Female',
		),
		'fa-male'	=>	array(
			'title'	=>	'Male',
		),
	);
	*/


	$icons = array(
		'fa-glass'	=>	array(
			'title'	=>	'Glass',
		),
		'fa-music'	=>	array(
			'title'	=>	'Music',
		),
		'fa-search'	=>	array(
			'title'	=>	'Search',
		),
		'fa-envelope-o'	=>	array(
			'title'	=>	'Envelope (Outline)',
		),
		'fa-heart'	=>	array(
			'title'	=>	'Heart',
		),
		'fa-star'	=>	array(
			'title'	=>	'Star',
		),
		'fa-star-o'	=>	array(
			'title'	=>	'Star (Outline)',
		),
		'fa-user'	=>	array(
			'title'	=>	'User',
		),
		'fa-film'	=>	array(
			'title'	=>	'Film',
		),
		'fa-th-large'	=>	array(
			'title'	=>	'TH Large',
		),
		'fa-th'	=>	array(
			'title'	=>	'TH',
		),
		'fa-th-list'	=>	array(
			'title'	=>	'th-list',
		),
		'fa-check'	=>	array(
			'title'	=>	'Checkmark',
		),
		'fa-times'	=>	array(
			'title'	=>	'Times',
		),
		'fa-search-plus'	=>	array(
			'title'	=>	'Search Plus (Zoom In)',
		),
		'fa-search-minus'	=>	array(
			'title'	=>	'Search Minus (Zoom Out)',
		),
		'fa-power-off'	=>	array(
			'title'	=>	'Power Off',
		),
		'fa-signal'	=>	array(
			'title'	=>	'Signal',
		),
		'fa-cog'	=>	array(
			'title'	=>	'Cog',
		),
		'fa-trash-o'	=>	array(
			'title'	=>	'Trash (Outline)',
		),
		'fa-home'	=>	array(
			'title'	=>	'Home',
		),
		'fa-file-o'	=>	array(
			'title'	=>	'File (Outline)',
		),
		'fa-clock-o'	=>	array(
			'title'	=>	'Clock (Outline)',
		),
		'fa-road'	=>	array(
			'title'	=>	'Road',
		),
		'fa-download'	=>	array(
			'title'	=>	'Download',
		),
		'fa-arrow-circle-o-down'	=>	array(
			'title'	=>	'Arrow (Circle/Outline/Down)',
		),
		'fa-arrow-circle-o-up'	=>	array(
			'title'	=>	'Arrow (Circle/Outline/Up)',
		),
		'fa-inbox'	=>	array(
			'title'	=>	'Inbox',
		),
		'fa-play-circle-o'	=>	array(
			'title'	=>	'Play (Circle/Outline)',
		),
		'fa-repeat'	=>	array(
			'title'	=>	'Repeat',
		),
		'fa-refresh'	=>	array(
			'title'	=>	'Refresh',
		),
		'fa-list-alt'	=>	array(
			'title'	=>	'List (Alternative)',
		),
		'fa-lock'	=>	array(
			'title'	=>	'Lock',
		),
		'fa-flag'	=>	array(
			'title'	=>	'Flag',
		),
		'fa-headphones'	=>	array(
			'title'	=>	'Headphones',
		),
		'fa-volume-off'	=>	array(
			'title'	=>	'Volume Off',
		),
		'fa-volume-down'	=>	array(
			'title'	=>	'Volume Down',
		),
		'fa-volume-up'	=>	array(
			'title'	=>	'Volume Up',
		),
		'fa-qrcode'	=>	array(
			'title'	=>	'QR Code',
		),
		'fa-barcode'	=>	array(
			'title'	=>	'Barcode',
		),
		'fa-tag'	=>	array(
			'title'	=>	'Tag',
		),
		'fa-tags'	=>	array(
			'title'	=>	'tags',
		),
		'fa-book'	=>	array(
			'title'	=>	'Book',
		),
		'fa-bookmark'	=>	array(
			'title'	=>	'Bookmark',
		),
		'fa-print'	=>	array(
			'title'	=>	'Print',
		),
		'fa-camera'	=>	array(
			'title'	=>	'Camera',
		),
		'fa-font'	=>	array(
			'title'	=>	'Font',
		),
		'fa-bold'	=>	array(
			'title'	=>	'Bold',
		),
		'fa-italic'	=>	array(
			'title'	=>	'Italic',
		),
		'fa-text-height'	=>	array(
			'title'	=>	'Text Height',
		),
		'fa-text-width'	=>	array(
			'title'	=>	'Text Width',
		),
		'fa-align-left'	=>	array(
			'title'	=>	'Align Left',
		),
		'fa-align-center'	=>	array(
			'title'	=>	'Align Center',
		),
		'fa-align-right'	=>	array(
			'title'	=>	'Align Right',
		),
		'fa-align-justify'	=>	array(
			'title'	=>	'Align Justify',
		),
		'fa-list'	=>	array(
			'title'	=>	'List',
		),
		'fa-outdent'	=>	array(
			'title'	=>	'Outdent',
		),
		'fa-indent'	=>	array(
			'title'	=>	'Indent',
		),
		'fa-video-camera'	=>	array(
			'title'	=>	'video-camera',
		),
		'fa-picture-o'	=>	array(
			'title'	=>	'Picture (Outline)',
		),
		'fa-pencil'	=>	array(
			'title'	=>	'Pencil',
		),
		'fa-map-marker'	=>	array(
			'title'	=>	'Map Marker',
		),
		'fa-adjust'	=>	array(
			'title'	=>	'Adjust',
		),
		'fa-tint'	=>	array(
			'title'	=>	'Tint',
		),
		'fa-pencil-square-o'	=>	array(
			'title'	=>	'Pencil (Square/Outline)',
		),
		'fa-share-square-o'	=>	array(
			'title'	=>	'Share (Square/Outline)',
		),
		'fa-check-square-o'	=>	array(
			'title'	=>	'Check (Square/Outline)',
		),
		'fa-arrows'	=>	array(
			'title'	=>	'Arrows',
		),
		'fa-step-backward'	=>	array(
			'title'	=>	'Step Backward',
		),
		'fa-fast-backward'	=>	array(
			'title'	=>	'Fast Backward',
		),
		'fa-backward'	=>	array(
			'title'	=>	'Backward',
		),
		'fa-play'	=>	array(
			'title'	=>	'Play',
		),
		'fa-pause'	=>	array(
			'title'	=>	'Pause',
		),
		'fa-stop'	=>	array(
			'title'	=>	'Stop',
		),
		'fa-forward'	=>	array(
			'title'	=>	'Forward',
		),
		'fa-fast-forward'	=>	array(
			'title'	=>	'Fast Forward',
		),
		'fa-step-forward'	=>	array(
			'title'	=>	'Step Forward',
		),
		'fa-eject'	=>	array(
			'title'	=>	'Eject',
		),
		'fa-chevron-left'	=>	array(
			'title'	=>	'Chevron Left',
		),
		'fa-chevron-right'	=>	array(
			'title'	=>	'Chevron Right',
		),
		'fa-plus-circle'	=>	array(
			'title'	=>	'Plus (Circle)',
		),
		'fa-minus-circle'	=>	array(
			'title'	=>	'Minus (Circle)',
		),
		'fa-times-circle'	=>	array(
			'title'	=>	'Times (Circle)',
		),
		'fa-check-circle'	=>	array(
			'title'	=>	'Check (Circle)',
		),
		'fa-question-circle'	=>	array(
			'title'	=>	'Question (Circle)',
		),
		'fa-info-circle'	=>	array(
			'title'	=>	'Info (Circle)',
		),
		'fa-crosshairs'	=>	array(
			'title'	=>	'Crosshairs',
		),
		'fa-times-circle-o'	=>	array(
			'title'	=>	'Times (Circle/Outline)',
		),
		'fa-check-circle-o'	=>	array(
			'title'	=>	'Check (Circle/Outline)',
		),
		'fa-ban'	=>	array(
			'title'	=>	'Ban',
		),
		'fa-arrow-left'	=>	array(
			'title'	=>	'Arrow Left',
		),
		'fa-arrow-right'	=>	array(
			'title'	=>	'Arrow Right',
		),
		'fa-arrow-up'	=>	array(
			'title'	=>	'Arrow Up',
		),
		'fa-arrow-down'	=>	array(
			'title'	=>	'Arrow Down',
		),
		'fa-share'	=>	array(
			'title'	=>	'Share',
		),
		'fa-expand'	=>	array(
			'title'	=>	'Expand',
		),
		'fa-compress'	=>	array(
			'title'	=>	'Compress',
		),
		'fa-plus'	=>	array(
			'title'	=>	'Plus',
		),
		'fa-minus'	=>	array(
			'title'	=>	'Minus',
		),
		'fa-asterisk'	=>	array(
			'title'	=>	'Asterisk',
		),
		'fa-exclamation-circle'	=>	array(
			'title'	=>	'Exclamation Circle',
		),
		'fa-gift'	=>	array(
			'title'	=>	'Gift',
		),
		'fa-leaf'	=>	array(
			'title'	=>	'Leaf',
		),
		'fa-fire'	=>	array(
			'title'	=>	'Fire',
		),
		'fa-eye'	=>	array(
			'title'	=>	'Eye',
		),
		'fa-eye-slash'	=>	array(
			'title'	=>	'Eye Slash',
		),
		'fa-exclamation-triangle'	=>	array(
			'title'	=>	'Exclamation Triangle',
		),
		'fa-plane'	=>	array(
			'title'	=>	'Plane',
		),
		'fa-calendar'	=>	array(
			'title'	=>	'Calendar',
		),
		'fa-random'	=>	array(
			'title'	=>	'Random',
		),
		'fa-comment'	=>	array(
			'title'	=>	'Comment',
		),
		'fa-magnet'	=>	array(
			'title'	=>	'Magnet',
		),
		'fa-chevron-up'	=>	array(
			'title'	=>	'Chevron Up',
		),
		'fa-chevron-down'	=>	array(
			'title'	=>	'Chevron Down',
		),
		'fa-retweet'	=>	array(
			'title'	=>	'Retweet',
		),
		'fa-shopping-cart'	=>	array(
			'title'	=>	'Shopping Cart',
		),
		'fa-folder'	=>	array(
			'title'	=>	'Folder',
		),
		'fa-folder-open'	=>	array(
			'title'	=>	'Folder Open',
		),
		'fa-arrows-v'	=>	array(
			'title'	=>	'Arrows V',
		),
		'fa-arrows-h'	=>	array(
			'title'	=>	'Arrows H',
		),
		'fa-bar-chart-o'	=>	array(
			'title'	=>	'Bar Chart O',
		),
		'fa-twitter-square'	=>	array(
			'title'	=>	'Twitter Square',
		),
		'fa-facebook-square'	=>	array(
			'title'	=>	'Facebook Square',
		),
		'fa-camera-retro'	=>	array(
			'title'	=>	'Camera Retro',
		),
		'fa-key'	=>	array(
			'title'	=>	'Key',
		),
		'fa-cogs'	=>	array(
			'title'	=>	'Cogs',
		),
		'fa-comments'	=>	array(
			'title'	=>	'Comments',
		),
		'fa-thumbs-o-up'	=>	array(
			'title'	=>	'Thumbs O Up',
		),
		'fa-thumbs-o-down'	=>	array(
			'title'	=>	'Thumbs O Down',
		),
		'fa-star-half'	=>	array(
			'title'	=>	'Star Half',
		),
		'fa-heart-o'	=>	array(
			'title'	=>	'Heart O',
		),
		'fa-sign-out'	=>	array(
			'title'	=>	'Sign Out',
		),
		'fa-linkedin-square'	=>	array(
			'title'	=>	'Linkedin Square',
		),
		'fa-thumb-tack'	=>	array(
			'title'	=>	'Thumb Tack',
		),
		'fa-external-link'	=>	array(
			'title'	=>	'External Link',
		),
		'fa-sign-in'	=>	array(
			'title'	=>	'Sign In',
		),
		'fa-trophy'	=>	array(
			'title'	=>	'Trophy',
		),
		'fa-github-square'	=>	array(
			'title'	=>	'Github Square',
		),
		'fa-upload'	=>	array(
			'title'	=>	'Upload',
		),
		'fa-lemon-o'	=>	array(
			'title'	=>	'Lemon O',
		),
		'fa-phone'	=>	array(
			'title'	=>	'Phone',
		),
		'fa-square-o'	=>	array(
			'title'	=>	'Square O',
		),
		'fa-bookmark-o'	=>	array(
			'title'	=>	'Bookmark O',
		),
		'fa-phone-square'	=>	array(
			'title'	=>	'Phone Square',
		),
		'fa-twitter'	=>	array(
			'title'	=>	'Twitter',
		),
		'fa-facebook'	=>	array(
			'title'	=>	'Facebook',
		),
		'fa-github'	=>	array(
			'title'	=>	'Github',
		),
		'fa-unlock'	=>	array(
			'title'	=>	'Unlock',
		),
		'fa-credit-card'	=>	array(
			'title'	=>	'Credit Card',
		),
		'fa-rss'	=>	array(
			'title'	=>	'Rss',
		),
		'fa-hdd-o'	=>	array(
			'title'	=>	'Hdd O',
		),
		'fa-bullhorn'	=>	array(
			'title'	=>	'Bullhorn',
		),
		'fa-bell'	=>	array(
			'title'	=>	'Bell',
		),
		'fa-certificate'	=>	array(
			'title'	=>	'Certificate',
		),
		'fa-hand-o-right'	=>	array(
			'title'	=>	'Hand O Right',
		),
		'fa-hand-o-left'	=>	array(
			'title'	=>	'Hand O Left',
		),
		'fa-hand-o-up'	=>	array(
			'title'	=>	'Hand O Up',
		),
		'fa-hand-o-down'	=>	array(
			'title'	=>	'Hand O Down',
		),
		'fa-arrow-circle-left'	=>	array(
			'title'	=>	'Arrow Circle Left',
		),
		'fa-arrow-circle-right'	=>	array(
			'title'	=>	'Arrow Circle Right',
		),
		'fa-arrow-circle-up'	=>	array(
			'title'	=>	'Arrow Circle Up',
		),
		'fa-arrow-circle-down'	=>	array(
			'title'	=>	'Arrow Circle Down',
		),
		'fa-globe'	=>	array(
			'title'	=>	'Globe',
		),
		'fa-wrench'	=>	array(
			'title'	=>	'Wrench',
		),
		'fa-tasks'	=>	array(
			'title'	=>	'Tasks',
		),
		'fa-filter'	=>	array(
			'title'	=>	'Filter',
		),
		'fa-briefcase'	=>	array(
			'title'	=>	'Briefcase',
		),
		'fa-arrows-alt'	=>	array(
			'title'	=>	'Arrows Alt',
		),
		'fa-users'	=>	array(
			'title'	=>	'Users',
		),
		'fa-link'	=>	array(
			'title'	=>	'Link',
		),
		'fa-cloud'	=>	array(
			'title'	=>	'Cloud',
		),
		'fa-flask'	=>	array(
			'title'	=>	'Flask',
		),
		'fa-scissors'	=>	array(
			'title'	=>	'Scissors',
		),
		'fa-files-o'	=>	array(
			'title'	=>	'Files O',
		),
		'fa-paperclip'	=>	array(
			'title'	=>	'Paperclip',
		),
		'fa-floppy-o'	=>	array(
			'title'	=>	'Floppy O',
		),
		'fa-square'	=>	array(
			'title'	=>	'Square',
		),
		'fa-bars'	=>	array(
			'title'	=>	'Bars',
		),
		'fa-list-ul'	=>	array(
			'title'	=>	'List Ul',
		),
		'fa-list-ol'	=>	array(
			'title'	=>	'List Ol',
		),
		'fa-strikethrough'	=>	array(
			'title'	=>	'Strikethrough',
		),
		'fa-underline'	=>	array(
			'title'	=>	'Underline',
		),
		'fa-table'	=>	array(
			'title'	=>	'Table',
		),
		'fa-magic'	=>	array(
			'title'	=>	'Magic',
		),
		'fa-truck'	=>	array(
			'title'	=>	'Truck',
		),
		'fa-pinterest'	=>	array(
			'title'	=>	'Pinterest',
		),
		'fa-pinterest-square'	=>	array(
			'title'	=>	'Pinterest Square',
		),
		'fa-google-plus-square'	=>	array(
			'title'	=>	'Google Plus Square',
		),
		'fa-google-plus'	=>	array(
			'title'	=>	'Google Plus',
		),
		'fa-money'	=>	array(
			'title'	=>	'Money',
		),
		'fa-caret-down'	=>	array(
			'title'	=>	'Caret Down',
		),
		'fa-caret-up'	=>	array(
			'title'	=>	'Caret Up',
		),
		'fa-caret-left'	=>	array(
			'title'	=>	'Caret Left',
		),
		'fa-caret-right'	=>	array(
			'title'	=>	'Caret Right',
		),
		'fa-columns'	=>	array(
			'title'	=>	'Columns',
		),
		'fa-sort'	=>	array(
			'title'	=>	'Sort',
		),
		'fa-sort-asc'	=>	array(
			'title'	=>	'Sort Asc',
		),
		'fa-sort-desc'	=>	array(
			'title'	=>	'Sort Desc',
		),
		'fa-envelope'	=>	array(
			'title'	=>	'Envelope',
		),
		'fa-linkedin'	=>	array(
			'title'	=>	'Linkedin',
		),
		'fa-undo'	=>	array(
			'title'	=>	'Undo',
		),
		'fa-gavel'	=>	array(
			'title'	=>	'Gavel',
		),
		'fa-tachometer'	=>	array(
			'title'	=>	'Tachometer',
		),
		'fa-comment-o'	=>	array(
			'title'	=>	'Comment O',
		),
		'fa-comments-o'	=>	array(
			'title'	=>	'Comments O',
		),
		'fa-bolt'	=>	array(
			'title'	=>	'Bolt',
		),
		'fa-sitemap'	=>	array(
			'title'	=>	'Sitemap',
		),
		'fa-umbrella'	=>	array(
			'title'	=>	'Umbrella',
		),
		'fa-clipboard'	=>	array(
			'title'	=>	'Clipboard',
		),
		'fa-lightbulb-o'	=>	array(
			'title'	=>	'Lightbulb O',
		),
		'fa-exchange'	=>	array(
			'title'	=>	'Exchange',
		),
		'fa-cloud-download'	=>	array(
			'title'	=>	'Cloud Download',
		),
		'fa-cloud-upload'	=>	array(
			'title'	=>	'Cloud Upload',
		),
		'fa-user-md'	=>	array(
			'title'	=>	'User Md',
		),
		'fa-stethoscope'	=>	array(
			'title'	=>	'Stethoscope',
		),
		'fa-suitcase'	=>	array(
			'title'	=>	'Suitcase',
		),
		'fa-bell-o'	=>	array(
			'title'	=>	'Bell O',
		),
		'fa-coffee'	=>	array(
			'title'	=>	'Coffee',
		),
		'fa-cutlery'	=>	array(
			'title'	=>	'Cutlery',
		),
		'fa-file-text-o'	=>	array(
			'title'	=>	'File Text O',
		),
		'fa-building-o'	=>	array(
			'title'	=>	'Building O',
		),
		'fa-hospital-o'	=>	array(
			'title'	=>	'Hospital O',
		),
		'fa-ambulance'	=>	array(
			'title'	=>	'Ambulance',
		),
		'fa-medkit'	=>	array(
			'title'	=>	'Medkit',
		),
		'fa-fighter-jet'	=>	array(
			'title'	=>	'Fighter Jet',
		),
		'fa-beer'	=>	array(
			'title'	=>	'Beer',
		),
		'fa-h-square'	=>	array(
			'title'	=>	'H Square',
		),
		'fa-plus-square'	=>	array(
			'title'	=>	'Plus Square',
		),
		'fa-angle-double-left'	=>	array(
			'title'	=>	'Angle Double Left',
		),
		'fa-angle-double-right'	=>	array(
			'title'	=>	'Angle Double Right',
		),
		'fa-angle-double-up'	=>	array(
			'title'	=>	'Angle Double Up',
		),
		'fa-angle-double-down'	=>	array(
			'title'	=>	'Angle Double Down',
		),
		'fa-angle-left'	=>	array(
			'title'	=>	'Angle Left',
		),
		'fa-angle-right'	=>	array(
			'title'	=>	'Angle Right',
		),
		'fa-angle-up'	=>	array(
			'title'	=>	'Angle Up',
		),
		'fa-angle-down'	=>	array(
			'title'	=>	'Angle Down',
		),
		'fa-desktop'	=>	array(
			'title'	=>	'Desktop',
		),
		'fa-laptop'	=>	array(
			'title'	=>	'Laptop',
		),
		'fa-tablet'	=>	array(
			'title'	=>	'Tablet',
		),
		'fa-mobile'	=>	array(
			'title'	=>	'Mobile',
		),
		'fa-circle-o'	=>	array(
			'title'	=>	'Circle O',
		),
		'fa-quote-left'	=>	array(
			'title'	=>	'Quote Left',
		),
		'fa-quote-right'	=>	array(
			'title'	=>	'Quote Right',
		),
		'fa-spinner'	=>	array(
			'title'	=>	'Spinner',
		),
		'fa-circle'	=>	array(
			'title'	=>	'Circle',
		),
		'fa-reply'	=>	array(
			'title'	=>	'Reply',
		),
		'fa-github-alt'	=>	array(
			'title'	=>	'Github Alt',
		),
		'fa-folder-o'	=>	array(
			'title'	=>	'Folder O',
		),
		'fa-folder-open-o'	=>	array(
			'title'	=>	'Folder Open O',
		),
		'fa-smile-o'	=>	array(
			'title'	=>	'Smile O',
		),
		'fa-frown-o'	=>	array(
			'title'	=>	'Frown O',
		),
		'fa-meh-o'	=>	array(
			'title'	=>	'Meh O',
		),
		'fa-gamepad'	=>	array(
			'title'	=>	'Gamepad',
		),
		'fa-keyboard-o'	=>	array(
			'title'	=>	'Keyboard O',
		),
		'fa-flag-o'	=>	array(
			'title'	=>	'Flag O',
		),
		'fa-flag-checkered'	=>	array(
			'title'	=>	'Flag Checkered',
		),
		'fa-terminal'	=>	array(
			'title'	=>	'Terminal',
		),
		'fa-code'	=>	array(
			'title'	=>	'Code',
		),
		'fa-reply-all'	=>	array(
			'title'	=>	'Reply All',
		),
		'fa-mail-reply-all'	=>	array(
			'title'	=>	'Mail Reply All',
		),
		'fa-star-half-o'	=>	array(
			'title'	=>	'Star Half O',
		),
		'fa-location-arrow'	=>	array(
			'title'	=>	'Location Arrow',
		),
		'fa-crop'	=>	array(
			'title'	=>	'Crop',
		),
		'fa-code-fork'	=>	array(
			'title'	=>	'Code Fork',
		),
		'fa-chain-broken'	=>	array(
			'title'	=>	'Chain Broken',
		),
		'fa-question'	=>	array(
			'title'	=>	'Question',
		),
		'fa-info'	=>	array(
			'title'	=>	'Info',
		),
		'fa-exclamation'	=>	array(
			'title'	=>	'Exclamation',
		),
		'fa-superscript'	=>	array(
			'title'	=>	'Superscript',
		),
		'fa-subscript'	=>	array(
			'title'	=>	'Subscript',
		),
		'fa-eraser'	=>	array(
			'title'	=>	'Eraser',
		),
		'fa-puzzle-piece'	=>	array(
			'title'	=>	'Puzzle Piece',
		),
		'fa-microphone'	=>	array(
			'title'	=>	'Microphone',
		),
		'fa-microphone-slash'	=>	array(
			'title'	=>	'Microphone Slash',
		),
		'fa-shield'	=>	array(
			'title'	=>	'Shield',
		),
		'fa-calendar-o'	=>	array(
			'title'	=>	'Calendar O',
		),
		'fa-fire-extinguisher'	=>	array(
			'title'	=>	'Fire Extinguisher',
		),
		'fa-rocket'	=>	array(
			'title'	=>	'Rocket',
		),
		'fa-maxcdn'	=>	array(
			'title'	=>	'Maxcdn',
		),
		'fa-chevron-circle-left'	=>	array(
			'title'	=>	'Chevron Circle Left',
		),
		'fa-chevron-circle-right'	=>	array(
			'title'	=>	'Chevron Circle Right',
		),
		'fa-chevron-circle-up'	=>	array(
			'title'	=>	'Chevron Circle Up',
		),
		'fa-chevron-circle-down'	=>	array(
			'title'	=>	'Chevron Circle Down',
		),
		'fa-html5'	=>	array(
			'title'	=>	'Html5',
		),
		'fa-css3'	=>	array(
			'title'	=>	'Css3',
		),
		'fa-anchor'	=>	array(
			'title'	=>	'Anchor',
		),
		'fa-unlock-alt'	=>	array(
			'title'	=>	'Unlock Alt',
		),
		'fa-bullseye'	=>	array(
			'title'	=>	'Bullseye',
		),
		'fa-ellipsis-h'	=>	array(
			'title'	=>	'Ellipsis H',
		),
		'fa-ellipsis-v'	=>	array(
			'title'	=>	'Ellipsis V',
		),
		'fa-rss-square'	=>	array(
			'title'	=>	'Rss Square',
		),
		'fa-play-circle'	=>	array(
			'title'	=>	'Play Circle',
		),
		'fa-ticket'	=>	array(
			'title'	=>	'Ticket',
		),
		'fa-minus-square'	=>	array(
			'title'	=>	'Minus Square',
		),
		'fa-minus-square-o'	=>	array(
			'title'	=>	'Minus Square O',
		),
		'fa-level-up'	=>	array(
			'title'	=>	'Level Up',
		),
		'fa-level-down'	=>	array(
			'title'	=>	'Level Down',
		),
		'fa-check-square'	=>	array(
			'title'	=>	'Check Square',
		),
		'fa-pencil-square'	=>	array(
			'title'	=>	'Pencil Square',
		),
		'fa-external-link-square'	=>	array(
			'title'	=>	'External Link Square',
		),
		'fa-share-square'	=>	array(
			'title'	=>	'Share Square',
		),
		'fa-compass'	=>	array(
			'title'	=>	'Compass',
		),
		'fa-caret-square-o-down'	=>	array(
			'title'	=>	'Caret Square O Down',
		),
		'fa-caret-square-o-up'	=>	array(
			'title'	=>	'Caret Square O Up',
		),
		'fa-caret-square-o-right'	=>	array(
			'title'	=>	'Caret Square O Right',
		),
		'fa-eur'	=>	array(
			'title'	=>	'Eur',
		),
		'fa-gbp'	=>	array(
			'title'	=>	'Gbp',
		),
		'fa-usd'	=>	array(
			'title'	=>	'Usd',
		),
		'fa-inr'	=>	array(
			'title'	=>	'Inr',
		),
		'fa-jpy'	=>	array(
			'title'	=>	'Jpy',
		),
		'fa-rub'	=>	array(
			'title'	=>	'Rub',
		),
		'fa-krw'	=>	array(
			'title'	=>	'Krw',
		),
		'fa-btc'	=>	array(
			'title'	=>	'Btc',
		),
		'fa-file'	=>	array(
			'title'	=>	'File',
		),
		'fa-file-text'	=>	array(
			'title'	=>	'File Text',
		),
		'fa-sort-alpha-asc'	=>	array(
			'title'	=>	'Sort Alpha Asc',
		),
		'fa-sort-alpha-desc'	=>	array(
			'title'	=>	'Sort Alpha Desc',
		),
		'fa-sort-amount-asc'	=>	array(
			'title'	=>	'Sort Amount Asc',
		),
		'fa-sort-amount-desc'	=>	array(
			'title'	=>	'Sort Amount Desc',
		),
		'fa-sort-numeric-asc'	=>	array(
			'title'	=>	'Sort Numeric Asc',
		),
		'fa-sort-numeric-desc'	=>	array(
			'title'	=>	'Sort Numeric Desc',
		),
		'fa-thumbs-up'	=>	array(
			'title'	=>	'Thumbs Up',
		),
		'fa-thumbs-down'	=>	array(
			'title'	=>	'Thumbs Down',
		),
		'fa-youtube-square'	=>	array(
			'title'	=>	'Youtube Square',
		),
		'fa-youtube'	=>	array(
			'title'	=>	'Youtube',
		),
		'fa-xing'	=>	array(
			'title'	=>	'Xing',
		),
		'fa-xing-square'	=>	array(
			'title'	=>	'Xing Square',
		),
		'fa-youtube-play'	=>	array(
			'title'	=>	'Youtube Play',
		),
		'fa-dropbox'	=>	array(
			'title'	=>	'Dropbox',
		),
		'fa-stack-overflow'	=>	array(
			'title'	=>	'Stack Overflow',
		),
		'fa-instagram'	=>	array(
			'title'	=>	'Instagram',
		),
		'fa-flickr'	=>	array(
			'title'	=>	'Flickr',
		),
		'fa-adn'	=>	array(
			'title'	=>	'Adn',
		),
		'fa-bitbucket'	=>	array(
			'title'	=>	'Bitbucket',
		),
		'fa-bitbucket-square'	=>	array(
			'title'	=>	'Bitbucket Square',
		),
		'fa-tumblr'	=>	array(
			'title'	=>	'Tumblr',
		),
		'fa-tumblr-square'	=>	array(
			'title'	=>	'Tumblr Square',
		),
		'fa-long-arrow-down'	=>	array(
			'title'	=>	'Long Arrow Down',
		),
		'fa-long-arrow-up'	=>	array(
			'title'	=>	'Long Arrow Up',
		),
		'fa-long-arrow-left'	=>	array(
			'title'	=>	'Long Arrow Left',
		),
		'fa-long-arrow-right'	=>	array(
			'title'	=>	'Long Arrow Right',
		),
		'fa-apple'	=>	array(
			'title'	=>	'Apple',
		),
		'fa-windows'	=>	array(
			'title'	=>	'Windows',
		),
		'fa-android'	=>	array(
			'title'	=>	'Android',
		),
		'fa-linux'	=>	array(
			'title'	=>	'Linux',
		),
		'fa-dribbble'	=>	array(
			'title'	=>	'Dribbble',
		),
		'fa-skype'	=>	array(
			'title'	=>	'Skype',
		),
		'fa-foursquare'	=>	array(
			'title'	=>	'Foursquare',
		),
		'fa-trello'	=>	array(
			'title'	=>	'Trello',
		),
		'fa-female'	=>	array(
			'title'	=>	'Female',
		),
		'fa-male'	=>	array(
			'title'	=>	'Male',
		),
		'fa-gittip'	=>	array(
			'title'	=>	'Gittip',
		),
		'fa-sun-o'	=>	array(
			'title'	=>	'Sun O',
		),
		'fa-moon-o'	=>	array(
			'title'	=>	'Moon O',
		),
		'fa-archive'	=>	array(
			'title'	=>	'Archive',
		),
		'fa-bug'	=>	array(
			'title'	=>	'Bug',
		),
		'fa-vk'	=>	array(
			'title'	=>	'Vk',
		),
		'fa-weibo'	=>	array(
			'title'	=>	'Weibo',
		),
		'fa-renren'	=>	array(
			'title'	=>	'Renren',
		),
		'fa-pagelines'	=>	array(
			'title'	=>	'Pagelines',
		),
		'fa-stack-exchange'	=>	array(
			'title'	=>	'Stack Exchange',
		),
		'fa-arrow-circle-o-right'	=>	array(
			'title'	=>	'Arrow Circle O Right',
		),
		'fa-arrow-circle-o-left'	=>	array(
			'title'	=>	'Arrow Circle O Left',
		),
		'fa-caret-square-o-left'	=>	array(
			'title'	=>	'Caret Square O Left',
		),
		'fa-dot-circle-o'	=>	array(
			'title'	=>	'Dot Circle O',
		),
		'fa-wheelchair'	=>	array(
			'title'	=>	'Wheelchair',
		),
		'fa-vimeo-square'	=>	array(
			'title'	=>	'Vimeo Square',
		),
		'fa-try'	=>	array(
			'title'	=>	'Try',
		),
		'fa-plus-square-o'	=>	array(
			'title'	=>	'Plus Square O',
		),







		//4.1
		'fa-automobile'	=>	array(
			'title'	=>	'Automobile',
		),
		'fa-bank'	=>	array(
			'title'	=>	'Bank',
		),
		'fa-behance'	=>	array(
			'title'	=>	'Behance',
		),
		'fa-behance-square'	=>	array(
			'title'	=>	'Behance square',
		),
		'fa-bomb'	=>	array(
			'title'	=>	'Bomb',
		),
		'fa-building'	=>	array(
			'title'	=>	'Building',
		),
		'fa-cab'	=>	array(
			'title'	=>	'Cab',
		),
		'fa-car'	=>	array(
			'title'	=>	'Car',
		),
		'fa-child'	=>	array(
			'title'	=>	'Child',
		),
		'fa-circle-o-notch'	=>	array(
			'title'	=>	'Circle o-notch',
		),
		'fa-circle-thin'	=>	array(
			'title'	=>	'Circle thin',
		),
		'fa-codepen'	=>	array(
			'title'	=>	'Codepen',
		),
		'fa-cube'	=>	array(
			'title'	=>	'Cube',
		),
		'fa-cubes'	=>	array(
			'title'	=>	'Cubes',
		),
		'fa-database'	=>	array(
			'title'	=>	'Database',
		),
		'fa-delicious'	=>	array(
			'title'	=>	'Delicious',
		),
		'fa-deviantart'	=>	array(
			'title'	=>	'Deviantart',
		),
		'fa-digg'	=>	array(
			'title'	=>	'Digg',
		),
		'fa-drupal'	=>	array(
			'title'	=>	'Drupal',
		),
		'fa-empire'	=>	array(
			'title'	=>	'Empire',
		),
		'fa-envelope-square'	=>	array(
			'title'	=>	'Envelope square',
		),
		'fa-fax'	=>	array(
			'title'	=>	'Fax',
		),
		'fa-file-archive-o'	=>	array(
			'title'	=>	'File archive-o',
		),
		'fa-file-audio-o'	=>	array(
			'title'	=>	'File audio-o',
		),
		'fa-file-code-o'	=>	array(
			'title'	=>	'File code-o',
		),
		'fa-file-excel-o'	=>	array(
			'title'	=>	'File excel-o',
		),
		'fa-file-image-o'	=>	array(
			'title'	=>	'File image-o',
		),
		'fa-file-movie-o'	=>	array(
			'title'	=>	'File movie-o',
		),
		'fa-file-pdf-o'	=>	array(
			'title'	=>	'File pdf-o',
		),
		'fa-file-photo-o'	=>	array(
			'title'	=>	'File photo-o',
		),
		'fa-file-picture-o'	=>	array(
			'title'	=>	'File picture-o',
		),
		'fa-file-powerpoint-o'	=>	array(
			'title'	=>	'File powerpoint-o',
		),
		'fa-file-sound-o'	=>	array(
			'title'	=>	'File sound-o',
		),
		'fa-file-video-o'	=>	array(
			'title'	=>	'File video-o',
		),
		'fa-file-word-o'	=>	array(
			'title'	=>	'File word-o',
		),
		'fa-file-zip-o'	=>	array(
			'title'	=>	'File zip-o',
		),
		'fa-ge'	=>	array(
			'title'	=>	'Ge',
		),
		'fa-git'	=>	array(
			'title'	=>	'Git',
		),
		'fa-git-square'	=>	array(
			'title'	=>	'Git square',
		),
		'fa-google'	=>	array(
			'title'	=>	'Google',
		),
		'fa-graduation-cap'	=>	array(
			'title'	=>	'Graduation cap',
		),
		'fa-hacker-news'	=>	array(
			'title'	=>	'Hacker news',
		),
		'fa-header'	=>	array(
			'title'	=>	'Header',
		),
		'fa-history'	=>	array(
			'title'	=>	'History',
		),
		'fa-institution'	=>	array(
			'title'	=>	'Institution',
		),
		'fa-joomla'	=>	array(
			'title'	=>	'Joomla',
		),
		'fa-jsfiddle'	=>	array(
			'title'	=>	'Jsfiddle',
		),
		'fa-language'	=>	array(
			'title'	=>	'Language',
		),
		'fa-life-bouy'	=>	array(
			'title'	=>	'Life bouy',
		),
		'fa-life-ring'	=>	array(
			'title'	=>	'Life ring',
		),
		'fa-life-saver'	=>	array(
			'title'	=>	'Life saver',
		),
		'fa-mortar-board'	=>	array(
			'title'	=>	'Mortar board',
		),
		'fa-openid'	=>	array(
			'title'	=>	'Openid',
		),
		'fa-paper-plane'	=>	array(
			'title'	=>	'Paper plane',
		),
		'fa-paper-plane-o'	=>	array(
			'title'	=>	'Paper plane-o',
		),
		'fa-paragraph'	=>	array(
			'title'	=>	'Paragraph',
		),
		'fa-paw'	=>	array(
			'title'	=>	'Paw',
		),
		'fa-pied-piper'	=>	array(
			'title'	=>	'Pied piper',
		),
		'fa-pied-piper-alt'	=>	array(
			'title'	=>	'Pied piper-alt',
		),
		'fa-pied-piper-square'	=>	array(
			'title'	=>	'Pied piper-square',
		),
		'fa-qq'	=>	array(
			'title'	=>	'Qq',
		),
		'fa-ra'	=>	array(
			'title'	=>	'Ra',
		),
		'fa-rebel'	=>	array(
			'title'	=>	'Rebel',
		),
		'fa-recycle'	=>	array(
			'title'	=>	'Recycle',
		),
		'fa-reddit'	=>	array(
			'title'	=>	'Reddit',
		),
		'fa-reddit-square'	=>	array(
			'title'	=>	'Reddit square',
		),
		'fa-send'	=>	array(
			'title'	=>	'Send',
		),
		'fa-send-o'	=>	array(
			'title'	=>	'Send o',
		),
		'fa-share-alt'	=>	array(
			'title'	=>	'Share alt',
		),
		'fa-share-alt-square'	=>	array(
			'title'	=>	'Share alt-square',
		),
		'fa-slack'	=>	array(
			'title'	=>	'Slack',
		),
		'fa-sliders'	=>	array(
			'title'	=>	'Sliders',
		),
		'fa-soundcloud'	=>	array(
			'title'	=>	'Soundcloud',
		),
		'fa-space-shuttle'	=>	array(
			'title'	=>	'Space shuttle',
		),
		'fa-spoon'	=>	array(
			'title'	=>	'Spoon',
		),
		'fa-spotify'	=>	array(
			'title'	=>	'Spotify',
		),
		'fa-steam'	=>	array(
			'title'	=>	'Steam',
		),
		'fa-steam-square'	=>	array(
			'title'	=>	'Steam square',
		),
		'fa-stumbleupon'	=>	array(
			'title'	=>	'Stumbleupon',
		),
		'fa-stumbleupon-circle'	=>	array(
			'title'	=>	'Stumbleupon circle',
		),
		'fa-support'	=>	array(
			'title'	=>	'Support',
		),
		'fa-taxi'	=>	array(
			'title'	=>	'Taxi',
		),
		'fa-tencent-weibo'	=>	array(
			'title'	=>	'Tencent weibo',
		),
		'fa-tree'	=>	array(
			'title'	=>	'Tree',
		),
		'fa-university'	=>	array(
			'title'	=>	'University',
		),
		'fa-vine'	=>	array(
			'title'	=>	'Vine',
		),
		'fa-wechat'	=>	array(
			'title'	=>	'Wechat',
		),
		'fa-weixin'	=>	array(
			'title'	=>	'Weixin',
		),
		'fa-wordpress'	=>	array(
			'title'	=>	'Wordpress',
		),
		'fa-yahoo'	=>	array(
			'title'	=>	'Yahoo',
		),






		//4.2
		'fa-angellist' => array(
			'title' => 'Angellist',
		),
		'fa-area-chart' => array(
			'title' => 'Area-chart',
		),
		'fa-at' => array(
			'title' => 'At',
		),
		'fa-bell-slash' => array(
			'title' => 'Bell-slash',
		),
		'fa-bell-slash-o' => array(
			'title' => 'Bell-slash-o',
		),
		'fa-bicycle' => array(
			'title' => 'Bicycle',
		),
		'fa-binoculars' => array(
			'title' => 'Binoculars',
		),
		'fa-birthday-cake' => array(
			'title' => 'Birthday-cake',
		),
		'fa-bus' => array(
			'title' => 'Bus',
		),
		'fa-calculator' => array(
			'title' => 'Calculator',
		),
		'fa-cc' => array(
			'title' => 'Cc',
		),
		'fa-cc-amex' => array(
			'title' => 'Cc-amex',
		),
		'fa-cc-discover' => array(
			'title' => 'Cc-discover',
		),
		'fa-cc-mastercard' => array(
			'title' => 'Cc-mastercard',
		),
		'fa-cc-paypal' => array(
			'title' => 'Cc-paypal',
		),
		'fa-cc-stripe' => array(
			'title' => 'Cc-stripe',
		),
		'fa-cc-visa' => array(
			'title' => 'Cc-visa',
		),
		'fa-copyright' => array(
			'title' => 'Copyright',
		),
		'fa-eyedropper' => array(
			'title' => 'Eyedropper',
		),
		'fa-futbol-o' => array(
			'title' => 'Futbol-o',
		),
		'fa-google-wallet' => array(
			'title' => 'Google-wallet',
		),
		'fa-ils' => array(
			'title' => 'Ils',
		),
		'fa-ioxhost' => array(
			'title' => 'Ioxhost',
		),
		'fa-lastfm' => array(
			'title' => 'Lastfm',
		),
		'fa-lastfm-square' => array(
			'title' => 'Lastfm-square',
		),
		'fa-line-chart' => array(
			'title' => 'Line-chart',
		),
		'fa-meanpath' => array(
			'title' => 'Meanpath',
		),
		'fa-newspaper-o' => array(
			'title' => 'Newspaper-o',
		),
		'fa-paint-brush' => array(
			'title' => 'Paint-brush',
		),
		'fa-paypal' => array(
			'title' => 'Paypal',
		),
		'fa-pie-chart' => array(
			'title' => 'Pie-chart',
		),
		'fa-plug' => array(
			'title' => 'Plug',
		),
		'fa-shekel' => array(
			'title' => 'Shekel',
		),
		'fa-sheqel' => array(
			'title' => 'Sheqel',
		),
		'fa-slideshare' => array(
			'title' => 'Slideshare',
		),
		'fa-soccer-ball-o' => array(
			'title' => 'Soccer-ball-o',
		),
		'fa-toggle-off' => array(
			'title' => 'Toggle-off',
		),
		'fa-toggle-on' => array(
			'title' => 'Toggle-on',
		),
		'fa-trash' => array(
			'title' => 'Trash',
		),
		'fa-tty' => array(
			'title' => 'Tty',
		),
		'fa-twitch' => array(
			'title' => 'Twitch',
		),
		'fa-wifi' => array(
			'title' => 'Wifi',
		),
		'fa-yelp' => array(
			'title' => 'Yelp',
		),




		
		//4.3
		'fa-bed' => array(
			'title' => 'Bed',
		),
		'fa-buysellads' => array(
			'title' => 'Buysellads',
		),
		'fa-cart-arrow-down' => array(
			'title' => 'Cart-arrow-down',
		),
		'fa-cart-plus' => array(
			'title' => 'Cart-plus',
		),
		'fa-connectdevelop' => array(
			'title' => 'Connectdevelop',
		),
		'fa-dashcube' => array(
			'title' => 'Dashcube',
		),
		'fa-diamond' => array(
			'title' => 'Diamond',
		),
		'fa-facebook-official' => array(
			'title' => 'Facebook-official',
		),
		'fa-forumbee' => array(
			'title' => 'Forumbee',
		),
		'fa-heartbeat' => array(
			'title' => 'Heartbeat',
		),
		'fa-hotel' => array(
			'title' => 'Hotel',
		),
		'fa-leanpub' => array(
			'title' => 'Leanpub',
		),
		'fa-mars' => array(
			'title' => 'Mars',
		),
		'fa-mars-double' => array(
			'title' => 'Mars-double',
		),
		'fa-mars-stroke' => array(
			'title' => 'Mars-stroke',
		),
		'fa-mars-stroke-h' => array(
			'title' => 'Mars-stroke-h',
		),
		'fa-mars-stroke-v' => array(
			'title' => 'Mars-stroke-v',
		),
		'fa-medium' => array(
			'title' => 'Medium',
		),
		'fa-mercury' => array(
			'title' => 'Mercury',
		),
		'fa-motorcycle' => array(
			'title' => 'Motorcycle',
		),
		'fa-neuter' => array(
			'title' => 'Neuter',
		),
		'fa-pinterest-p' => array(
			'title' => 'Pinterest-p',
		),
		'fa-sellsy' => array(
			'title' => 'Sellsy',
		),
		'fa-server' => array(
			'title' => 'Server',
		),
		'fa-ship' => array(
			'title' => 'Ship',
		),
		'fa-shirtsinbulk' => array(
			'title' => 'Shirtsinbulk',
		),
		'fa-simplybuilt' => array(
			'title' => 'Simplybuilt',
		),
		'fa-skyatlas' => array(
			'title' => 'Skyatlas',
		),
		'fa-street-view' => array(
			'title' => 'Street-view',
		),
		'fa-subway' => array(
			'title' => 'Subway',
		),
		'fa-train' => array(
			'title' => 'Train',
		),
		'fa-transgender' => array(
			'title' => 'Transgender',
		),
		'fa-transgender-alt' => array(
			'title' => 'Transgender-alt',
		),
		'fa-user-plus' => array(
			'title' => 'User-plus',
		),
		'fa-user-secret' => array(
			'title' => 'User-secret',
		),
		'fa-user-times' => array(
			'title' => 'User-times',
		),
		'fa-venus' => array(
			'title' => 'Venus',
		),
		'fa-venus-double' => array(
			'title' => 'Venus-double',
		),
		'fa-venus-mars' => array(
			'title' => 'Venus-mars',
		),
		'fa-viacoin' => array(
			'title' => 'Viacoin',
		),
		'fa-whatsapp' => array(
			'title' => 'Whatsapp',
		),



		//4.4
		'fa-500px' => array(
			'title' => '500px', 
		),
		'fa-amazon' => array(
			'title' => 'Amazon', 
		),
		'fa-balance-scale' => array(
			'title' => 'Balance-scale', 
		),
		'fa-battery-0' => array(
			'title' => 'Battery-0', 
		),
		'fa-battery-1' => array(
			'title' => 'Battery-1', 
		),
		'fa-battery-2' => array(
			'title' => 'Battery-2', 
		),
		'fa-battery-3' => array(
			'title' => 'Battery-3', 
		),
		'fa-battery-4' => array(
			'title' => 'Battery-4', 
		),
		'fa-battery-empty' => array(
			'title' => 'Battery-empty', 
		),
		'fa-battery-full' => array(
			'title' => 'Battery-full', 
		),
		'fa-battery-half' => array(
			'title' => 'Battery-half', 
		),
		'fa-battery-quarter' => array(
			'title' => 'Battery-quarter', 
		),
		'fa-battery-three-quarters' => array(
			'title' => 'Battery-three-quarters', 
		),
		'fa-black-tie' => array(
			'title' => 'Black-tie', 
		),
		'fa-calendar-check-o' => array(
			'title' => 'Calendar-check-o', 
		),
		'fa-calendar-minus-o' => array(
			'title' => 'Calendar-minus-o', 
		),
		'fa-calendar-plus-o' => array(
			'title' => 'Calendar-plus-o', 
		),
		'fa-calendar-times-o' => array(
			'title' => 'Calendar-times-o', 
		),
		'fa-cc-diners-club' => array(
			'title' => 'Cc-diners-club', 
		),
		'fa-cc-jcb' => array(
			'title' => 'Cc-jcb', 
		),
		'fa-chrome' => array(
			'title' => 'Chrome', 
		),
		'fa-clone' => array(
			'title' => 'Clone', 
		),
		'fa-commenting' => array(
			'title' => 'Commenting', 
		),
		'fa-commenting-o' => array(
			'title' => 'Commenting-o', 
		),
		'fa-contao' => array(
			'title' => 'Contao', 
		),
		'fa-creative-commons' => array(
			'title' => 'Creative-commons', 
		),
		'fa-expeditedssl' => array(
			'title' => 'Expeditedssl', 
		),
		'fa-firefox' => array(
			'title' => 'Firefox', 
		),
		'fa-fonticons' => array(
			'title' => 'Fonticons', 
		),
		'fa-genderless' => array(
			'title' => 'Genderless', 
		),
		'fa-get-pocket' => array(
			'title' => 'Get-pocket', 
		),
		'fa-gg' => array(
			'title' => 'Gg', 
		),
		'fa-gg-circle' => array(
			'title' => 'Gg-circle', 
		),
		'fa-hand-grab-o' => array(
			'title' => 'Hand-grab-o', 
		),
		'fa-hand-lizard-o' => array(
			'title' => 'Hand-lizard-o', 
		),
		'fa-hand-paper-o' => array(
			'title' => 'Hand-paper-o', 
		),
		'fa-hand-peace-o' => array(
			'title' => 'Hand-peace-o', 
		),
		'fa-hand-pointer-o' => array(
			'title' => 'Hand-pointer-o', 
		),
		'fa-hand-rock-o' => array(
			'title' => 'Hand-rock-o', 
		),
		'fa-hand-scissors-o' => array(
			'title' => 'Hand-scissors-o', 
		),
		'fa-hand-spock-o' => array(
			'title' => 'Hand-spock-o', 
		),
		'fa-hand-stop-o' => array(
			'title' => 'Hand-stop-o', 
		),
		'fa-hourglass' => array(
			'title' => 'Hourglass', 
		),
		'fa-hourglass-1' => array(
			'title' => 'Hourglass-1', 
		),
		'fa-hourglass-2' => array(
			'title' => 'Hourglass-2', 
		),
		'fa-hourglass-3' => array(
			'title' => 'Hourglass-3', 
		),
		'fa-hourglass-end' => array(
			'title' => 'Hourglass-end', 
		),
		'fa-hourglass-half' => array(
			'title' => 'Hourglass-half', 
		),
		'fa-hourglass-o' => array(
			'title' => 'Hourglass-o', 
		),
		'fa-hourglass-start' => array(
			'title' => 'Hourglass-start', 
		),
		'fa-houzz' => array(
			'title' => 'Houzz', 
		),
		'fa-i-cursor' => array(
			'title' => 'I-cursor', 
		),
		'fa-industry' => array(
			'title' => 'Industry', 
		),
		'fa-internet-explorer' => array(
			'title' => 'Internet-explorer', 
		),
		'fa-map' => array(
			'title' => 'Map', 
		),
		'fa-map-o' => array(
			'title' => 'Map-o', 
		),
		'fa-map-pin' => array(
			'title' => 'Map-pin', 
		),
		'fa-map-signs' => array(
			'title' => 'Map-signs', 
		),
		'fa-mouse-pointer' => array(
			'title' => 'Mouse-pointer', 
		),
		'fa-object-group' => array(
			'title' => 'Object-group', 
		),
		'fa-object-ungroup' => array(
			'title' => 'Object-ungroup', 
		),
		'fa-odnoklassniki' => array(
			'title' => 'Odnoklassniki', 
		),
		'fa-odnoklassniki-square' => array(
			'title' => 'Odnoklassniki-square', 
		),
		'fa-opencart' => array(
			'title' => 'Opencart', 
		),
		'fa-opera' => array(
			'title' => 'Opera', 
		),
		'fa-optin-monster' => array(
			'title' => 'Optin-monster', 
		),
		'fa-registered' => array(
			'title' => 'Registered', 
		),
		'fa-safari' => array(
			'title' => 'Safari', 
		),
		'fa-sticky-note' => array(
			'title' => 'Sticky-note', 
		),
		'fa-sticky-note-o' => array(
			'title' => 'Sticky-note-o', 
		),
		'fa-television' => array(
			'title' => 'Television', 
		),
		'fa-trademark' => array(
			'title' => 'Trademark', 
		),
		'fa-tripadvisor' => array(
			'title' => 'Tripadvisor', 
		),
		'fa-tv' => array(
			'title' => 'Tv', 
		),
		'fa-vimeo' => array(
			'title' => 'Vimeo', 
		),
		'fa-wikipedia-w' => array(
			'title' => 'Wikipedia-w', 
		),
		'fa-y-combinator' => array(
			'title' => 'Y-combinator', 
		),
		'fa-yc' => array(
			'title' => 'Yc', 
		),




		//4.5.0
		'fa-bluetooth' => array(
			'title' => 'Bluetooth', 
		),
		'fa-bluetooth-b' => array(
			'title' => 'Bluetooth-b', 
		),
		'fa-codiepie' => array(
			'title' => 'Codiepie', 
		),
		'fa-credit-card-alt' => array(
			'title' => 'Credit-card-alt', 
		),
		'fa-edge' => array(
			'title' => 'Edge', 
		),
		'fa-fort-awesome' => array(
			'title' => 'Fort-awesome', 
		),
		'fa-hashtag' => array(
			'title' => 'Hashtag', 
		),
		'fa-mixcloud' => array(
			'title' => 'Mixcloud', 
		),
		'fa-modx' => array(
			'title' => 'Modx', 
		),
		'fa-pause-circle' => array(
			'title' => 'Pause-circle', 
		),
		'fa-pause-circle-o' => array(
			'title' => 'Pause-circle-o', 
		),
		'fa-percent' => array(
			'title' => 'Percent', 
		),
		'fa-product-hunt' => array(
			'title' => 'Product-hunt', 
		),
		'fa-reddit-alien' => array(
			'title' => 'Reddit-alien', 
		),
		'fa-scribd' => array(
			'title' => 'Scribd', 
		),
		'fa-shopping-bag' => array(
			'title' => 'Shopping-bag', 
		),
		'fa-shopping-basket' => array(
			'title' => 'Shopping-basket', 
		),
		'fa-stop-circle' => array(
			'title' => 'Stop-circle', 
		),
		'fa-stop-circle-o' => array(
			'title' => 'Stop-circle-o', 
		),
		'fa-usb' => array(
			'title' => 'USB', 
		),




		//4.6.3
		'fa-american-sign-language-interpreting' => array(
			'title' => 'American-sign-language-interpreting', 
		),
		'fa-asl-interpreting' => array(
			'title' => 'Asl-interpreting', 
		),
		'fa-assistive-listening-systems' => array(
			'title' => 'Assistive-listening-systems', 
		),
		'fa-audio-description' => array(
			'title' => 'Audio-description', 
		),
		'fa-blind' => array(
			'title' => 'Blind', 
		),
		'fa-braille' => array(
			'title' => 'Braille', 
		),
		'fa-deaf' => array(
			'title' => 'Deaf', 
		),
		'fa-deafness' => array(
			'title' => 'Deafness', 
		),
		'fa-envira' => array(
			'title' => 'Envira', 
		),
		'fa-fa' => array(
			'title' => 'Fa', 
		),
		'fa-first-order' => array(
			'title' => 'First-order', 
		),
		'fa-font-awesome' => array(
			'title' => 'Font-awesome', 
		),
		'fa-gitlab' => array(
			'title' => 'Gitlab', 
		),
		'fa-glide' => array(
			'title' => 'Glide', 
		),
		'fa-glide-g' => array(
			'title' => 'Glide-g', 
		),
		'fa-google-plus-circle' => array(
			'title' => 'Google-plus-circle', 
		),
		'fa-google-plus-official' => array(
			'title' => 'Google-plus-official', 
		),
		'fa-hard-of-hearing' => array(
			'title' => 'Hard-of-hearing', 
		),
		'fa-instagram' => array(
			'title' => 'Instagram', 
		),
		'fa-low-vision' => array(
			'title' => 'Low-vision', 
		),
		'fa-pied-piper' => array(
			'title' => 'Pied-piper', 
		),
		'fa-question-circle-o' => array(
			'title' => 'Question-circle-o', 
		),
		'fa-sign-language' => array(
			'title' => 'Sign-language', 
		),
		'fa-signing' => array(
			'title' => 'Signing', 
		),
		'fa-snapchat' => array(
			'title' => 'Snapchat', 
		),
		'fa-snapchat-ghost' => array(
			'title' => 'Snapchat-ghost', 
		),
		'fa-snapchat-square' => array(
			'title' => 'Snapchat-square', 
		),
		'fa-themeisle' => array(
			'title' => 'Themeisle', 
		),
		'fa-universal-access' => array(
			'title' => 'Universal-access', 
		),
		'fa-viadeo' => array(
			'title' => 'Viadeo', 
		),
		'fa-viadeo-square' => array(
			'title' => 'Viadeo-square', 
		),
		'fa-volume-control-phone' => array(
			'title' => 'Volume-control-phone', 
		),
		'fa-wheelchair-alt' => array(
			'title' => 'Wheelchair-alt', 
		),
		'fa-wpbeginner' => array(
			'title' => 'Wpbeginner', 
		),
		'fa-wpforms' => array(
			'title' => 'Wpforms', 
		),
		'fa-yoast' => array(
			'title' => 'Yoast', 
		),






		//4.7
		'fa-address-book' => array(
			'title' => 'Address-book', 
		),
		'fa-address-book-o' => array(
			'title' => 'Address-book-o', 
		),
		'fa-address-card' => array(
			'title' => 'Address-card', 
		),
		'fa-address-card-o' => array(
			'title' => 'Address-card-o', 
		),
		'fa-bandcamp' => array(
			'title' => 'Bandcamp', 
		),
		'fa-bath' => array(
			'title' => 'Bath', 
		),
		'fa-bathtub' => array(
			'title' => 'Bathtub', 
		),
		'fa-drivers-license' => array(
			'title' => 'Drivers-license', 
		),
		'fa-drivers-license-o' => array(
			'title' => 'Drivers-license-o', 
		),
		'fa-eercast' => array(
			'title' => 'Eercast', 
		),
		'fa-envelope-open' => array(
			'title' => 'Envelope-open', 
		),
		'fa-envelope-open-o' => array(
			'title' => 'Envelope-open-o', 
		),
		'fa-etsy' => array(
			'title' => 'Etsy', 
		),
		'fa-free-code-camp' => array(
			'title' => 'Free-code-camp', 
		),
		'fa-grav' => array(
			'title' => 'Grav', 
		),
		'fa-handshake-o' => array(
			'title' => 'Handshake-o', 
		),
		'fa-id-badge' => array(
			'title' => 'Id-badge', 
		),
		'fa-id-card' => array(
			'title' => 'Id-card', 
		),
		'fa-id-card-o' => array(
			'title' => 'Id-card-o', 
		),
		'fa-imdb' => array(
			'title' => 'Imdb', 
		),
		'fa-linode' => array(
			'title' => 'Linode', 
		),
		'fa-meetup' => array(
			'title' => 'Meetup', 
		),
		'fa-microchip' => array(
			'title' => 'Microchip', 
		),
		'fa-podcast' => array(
			'title' => 'Podcast', 
		),
		'fa-quora' => array(
			'title' => 'Quora', 
		),
		'fa-ravelry' => array(
			'title' => 'Ravelry', 
		),
		'fa-s15' => array(
			'title' => 'S15', 
		),
		'fa-shower' => array(
			'title' => 'Shower', 
		),
		'fa-snowflake-o' => array(
			'title' => 'Snowflake-o', 
		),
		'fa-superpowers' => array(
			'title' => 'Superpowers', 
		),
		'fa-telegram' => array(
			'title' => 'Telegram', 
		),
		'fa-thermometer' => array(
			'title' => 'Thermometer', 
		),
		'fa-thermometer-0' => array(
			'title' => 'Thermometer-0', 
		),
		'fa-thermometer-1' => array(
			'title' => 'Thermometer-1', 
		),
		'fa-thermometer-2' => array(
			'title' => 'Thermometer-2', 
		),
		'fa-thermometer-3' => array(
			'title' => 'Thermometer-3', 
		),
		'fa-thermometer-4' => array(
			'title' => 'Thermometer-4', 
		),
		'fa-thermometer-empty' => array(
			'title' => 'Thermometer-empty', 
		),
		'fa-thermometer-full' => array(
			'title' => 'Thermometer-full', 
		),
		'fa-thermometer-half' => array(
			'title' => 'Thermometer-half', 
		),
		'fa-thermometer-quarter' => array(
			'title' => 'Thermometer-quarter', 
		),
		'fa-thermometer-three-quarters' => array(
			'title' => 'Thermometer-three-quarters', 
		),
		'fa-times-rectangle' => array(
			'title' => 'Times-rectangle', 
		),
		'fa-times-rectangle-o' => array(
			'title' => 'Times-rectangle-o', 
		),
		'fa-user-circle' => array(
			'title' => 'User-circle', 
		),
		'fa-user-circle-o' => array(
			'title' => 'User-circle-o', 
		),
		'fa-user-o' => array(
			'title' => 'User-o', 
		),
		'fa-vcard' => array(
			'title' => 'Vcard', 
		),
		'fa-vcard-o' => array(
			'title' => 'Vcard-o', 
		),
		'fa-window-close' => array(
			'title' => 'Window-close', 
		),
		'fa-window-close-o' => array(
			'title' => 'Window-close-o', 
		),
		'fa-window-maximize' => array(
			'title' => 'Window-maximize', 
		),
		'fa-window-minimize' => array(
			'title' => 'Window-minimize', 
		),
		'fa-window-restore' => array(
			'title' => 'Window-restore', 
		),
		'fa-wpexplorer' => array(
			'title' => 'WPExplorer', 
		),

		
	);

	return $icons;
}
