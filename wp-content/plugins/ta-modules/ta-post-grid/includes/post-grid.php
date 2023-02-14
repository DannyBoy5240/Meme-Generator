<?php if ( 'columns' == $settings->layout ) : ?>
<div class="fl-post-column">
<?php endif;?>

<div <?php $module->render_post_class(); ?> itemscope itemtype="<?php FLTAPostGridModule::schema_itemtype(); ?>">

	<?php FLTAPostGridModule::schema_meta(); ?>
  <?php $module->render_featured_image( 'above-title' ); ?>
  
  <?php $website = null; ?>
  <?php if (get_field('website')) : ?>
    <?php $website = get_field('website'); ?>
  <?php endif; ?>

  <?php if (get_field('logo')) : ?>
    <?php $logo = get_field('logo'); ?>
    <div class="partner-logo-wrap">
      <?php if ($logo['id']) : ?>
        <?php $img_atts = wp_get_attachment_image_src( $logo['id'], 'medium' );
        $img_src = $img_atts[0]; ?>
      <?php endif; ?>
      <?php if($logo && $website): ?>
        <a href="<?php echo $website ?>" target="_blank"><img class="partner-logo" src="<?php echo $img_src; ?>" alt="<?php echo $logo['alt']; ?>" /></a>
      <?php elseif ($logo) : ?>
        <img class="partner-logo" src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" />
      <?php endif; ?>
    </div>
  <?php endif; ?>
	

	<div class="fl-post-grid-text">
    <?php if ($settings->link_content == 1) : ?>
      <h2 class="fl-post-grid-title" itemprop="headline">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
      </h2>
    <?php else : ?>
      <h2 class="fl-post-grid-title" itemprop="headline">
        <?php the_title(); ?>
      </h2>
    <?php endif; ?>


		<?php do_action( 'fl_builder_ta_post_grid_before_meta', $settings, $module ); ?>

		<?php if ( $settings->show_author || $settings->show_date || $settings->show_comments_grid ) : ?>
		<div class="fl-post-grid-meta">
			<?php if ( $settings->show_author ) : ?>
				<span class="fl-post-grid-author">
				<?php

				printf(
					_x( 'By %s', '%s stands for author name.', 'fl-builder' ),
					'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '"><span>' . get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ) . '</span></a>'
				);

				?>
				</span>
			<?php endif; ?>
			<?php if ( $settings->show_date ) : ?>
				<?php if ( $settings->show_author ) : ?>
					<span class="fl-sep"><?php echo $settings->info_separator; ?></span>
				<?php endif; ?>
				<span class="fl-post-grid-date">
					<?php FLBuilderLoop::post_date( $settings->date_format ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $settings->show_comments_grid ) : ?>
				<?php if ( $settings->show_author || $settings->show_date ) : ?>
					<span class="fl-sep"><?php echo $settings->info_separator; ?></span>
				<?php endif; ?>
				<span class="fl-post-feed-comments">
					<?php comments_popup_link( '0 <i class="far fa-comment"></i>', '1 <i class="far fa-comment"></i>', '% <i class="far fa-comment"></i>' ); ?>
				</span>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if ( $settings->show_terms && $module->get_post_terms() ) : ?>
		<div class="fl-post-grid-meta">
			<div class="fl-post-grid-terms">
				<span class="fl-terms-label"><?php echo $settings->terms_list_label; ?></span>
				<?php echo $module->get_post_terms(); ?>
			</div>
		</div>
		<?php endif; ?>

		<?php do_action( 'fl_builder_ta_post_grid_after_meta', $settings, $module ); ?>

	<?php if ( $module->has_featured_image( 'above' ) ) : ?>
	</div>
	<?php endif; ?>

	<?php $module->render_featured_image( 'above' ); ?>

	<?php if ( $module->has_featured_image( 'above' ) ) : ?>
	<div class="fl-post-grid-text">
	<?php endif; ?>

		<?php do_action( 'fl_builder_ta_post_grid_before_content', $settings, $module ); ?>

		<?php if ( $settings->show_content || $settings->show_more_link ) : ?>
		<div class="fl-post-grid-content">
			<?php if ( $settings->show_content ) : ?>
			<?php $module->render_excerpt(); ?>
			<?php endif; ?>
			<?php if ( $settings->show_more_link ) : ?>
			<a class="fl-post-grid-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $settings->more_link_text; ?></a>
			<?php endif; ?>
		</div>
		<?php endif; ?>

    <?php do_action( 'fl_builder_ta_post_grid_after_content', $settings, $module ); ?>
        
    <?php if ($story = get_field('story')) : ?>
      <?php $story_url = get_permalink($story[0]->ID); ?>
      <a class="btn-partner" href="<?php echo $story_url; ?>">Story</a>
    <?php endif; ?>

    <?php if ($website) : ?>
        <a class="btn-partner" href="<?php echo $website ?>" target="_blank">Website</a>
    <?php endif; ?>

	</div>
</div>

<?php if ( 'columns' == $settings->layout ) : ?>
</div>
<?php endif; ?>
