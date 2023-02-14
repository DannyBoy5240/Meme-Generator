<?php

// Do the removal of paged & offset parameters
add_filter( 'fl_builder_loop_query_args', array( $module, 'remove_pagination_args' ), 10 );

// Get the query data.
$query = $module->get_query();

// Remove filter to prevent breaking other modules
remove_filter( 'fl_builder_loop_query_args', array( $module, 'remove_pagination_args' ), 10 );

// Render the posts.
if ( $query->have_posts() ) :

?>

	<div class="fl-post-slider" itemscope="itemscope" itemtype="https://schema.org/Blog">
		<div class="fl-post-slider-wrapper">

			<?php

			while ( $query->have_posts() ) {

				$query->the_post();

				include $module->dir . 'includes/post-loop.php';

			}

				?>
		</div>
	<?php
	// Render the navigation.
	if ( 'yes' == $settings->navigation && $query->found_posts > 1 ) : ?>
		<div class="fl-post-slider-navigation" aria-label="post slider buttons">
			<a class="slider-prev" href="#" aria-label="previous" aria-role="button"><i class="icon-ArrowLeft"></i></a>
			<a class="slider-next" href="#" aria-label="next" aria-role="button"><i class="icon-ArrowRight"></i></a>
		</div>
	<?php endif; ?>
	</div>
	<div class="fl-clear"></div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
