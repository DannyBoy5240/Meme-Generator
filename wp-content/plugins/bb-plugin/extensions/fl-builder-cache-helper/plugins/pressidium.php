<?php
namespace FLCacheClear;

class Pressidium {

	var $name = 'Pressidium Hosting';
	var $url  = 'https://pressidium.com/';

	static function run() {
		if ( defined( 'WP_NINUKIS_WP_NAME' ) && class_exists( '\NinukisCaching' ) ) {
			\NinukisCaching::get_instance()->purgeAllCaches();
		}
	}
}
