<?php $post_id = get_the_id(); ?>

<div class="fl-post-slider-post fl-post-slider-<?php echo $module->get_slider_class( $post_id ) ?><?php if ( isset( $settings->show_thumb ) && 'show' == $settings->show_thumb ) { echo ' fl-post-slider-has-image';} ?> swiper-slide" itemscope="itemscope" itemtype="<?php FLTAPostGridModule::schema_itemtype(); ?>">

	<?php

		FLTAPostGridModule::schema_meta();

		// render featured images
	if ( isset( $settings->show_thumb ) && 'show' == $settings->show_thumb ) {
		if ( has_post_thumbnail( $post_id ) ) { echo $module->render_mobile_img( $post_id );
		}
		if ( has_post_thumbnail( $post_id ) ) { echo $module->render_img( $post_id );
		}
	}
	?>      

	<div class="fl-post-slider-content">

    <?php if (!empty($settings->slider_header)) : ?>
      <h2 class="ta-slider-header"><?php echo $settings->slider_header; ?></h2>
    <?php endif; ?>
    
    <?php if (!empty($settings->custom_title)) : ?>
      <h2 class="fl-post-slider-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $settings->custom_title; ?></a></h2>
    <?php else : ?>
      <?php $module->render_post_title( $post_id ) ?>
    <?php endif; ?>
	
		<?php if ( $settings->show_content || $settings->show_more_link ) : ?>
		<div class="fl-post-slider-feed-content swiper-no-swiping" itemprop="text">
			<?php if ( $settings->show_content ) : ?>
			<?php the_excerpt(); ?>
			<?php endif; ?>
			<?php if ( $settings->show_more_link ) : ?>
			<a class="fl-post-slider-feed-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $settings->more_link_text; ?></a>
			<?php endif; ?>
		</div>
    <?php endif; ?>
    
    <?php if (!empty($settings->slider_button_link)) : ?>
    <div class="ta-slider-button">
      <a href="<?php echo $settings->slider_button_link; ?>" title="<?php echo $settings->slider_button_text; ?>" class="ta-button" role="button">
        <?php echo $settings->slider_button_text; ?>
      </a>
    </div>
  <?php endif; ?>

	</div>

</div>
