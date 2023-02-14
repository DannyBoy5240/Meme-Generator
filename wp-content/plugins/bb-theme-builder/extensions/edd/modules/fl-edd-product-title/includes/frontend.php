<?php
$item_prop = '';
if ( version_compare( EDD_VERSION, '3.0', '<' ) ) {
	$item_prop = edd_add_schema_microdata() ? ' itemprop="name"' : '';
}
?>
<h1<?php echo $item_prop; ?> class="edd_download_title">
	<a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</h1>
<?php do_action( 'edd_download_after_title' ); ?>
<meta itemprop="url" content="<?php the_permalink(); ?>" />
