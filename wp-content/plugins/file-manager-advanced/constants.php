<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * File Manager Version
 */
if ( !defined('FMA_VERSION') ) {
   define('FMA_VERSION', '5.0.2');
}
/**
 * File Manager UI
 */
if ( !defined('FMA_UI') ) {
   define('FMA_UI', ['toolbar', 'tree', 'path', 'stat']);
}
/**
 * File Manager path
 */
if ( !defined('FMAFILEPATH') ) {
   define('FMAFILEPATH', plugin_dir_path( __FILE__ ));
}
/**
 * File Manager Operations
 */
if ( !defined('FMA_OPERATIONS') ) {
    define('FMA_OPERATIONS', ['mkdir', 'mkfile', 'rename', 'duplicate', 'paste', 'ban', 'archive', 'extract', 'copy', 'cut', 'edit','rm','download', 'upload', 'search', 'info', 'help','empty','resize','preference']);
}