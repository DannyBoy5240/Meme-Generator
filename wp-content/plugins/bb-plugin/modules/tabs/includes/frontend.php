<?php

global $wp_embed;

if ( 'post' == $settings->source ) {
	$query = FLBuilderLoop::query( $settings );
}
?>

<div class="fl-tabs fl-tabs-<?php echo $settings->layout; ?> fl-clearfix">

	<div class="fl-tabs-labels fl-clearfix" role="tablist">
		<?php
		$active_tab     = intval( $settings->active_tab );
		$tabs_on_mobile = $settings->tabs_on_mobile;

		if ( $active_tab <= 0 || $active_tab > count( $settings->items ) ) {
			$active_tab = 1;
		}
		?>
		<?php
		if ( 'content' == $settings->source ) {
			for ( $i = 0; $i < count( $settings->items ); $i++ ) {
				if ( ! is_object( $settings->items[ $i ] ) ) {
					continue;
				}

				$tab_label_id = 'fl-tabs-' . $module->node . '-label-' . $i;
				$id_in_label  = apply_filters( 'fl_tabs_id_in_label', false, $settings, $i );

				if ( $id_in_label && ! empty( $settings->id ) ) {
					$tab_label_id = $settings->id . '-label-' . $i;
				}
				?>
				<a href="#" class="fl-tabs-label<?php if ( ($active_tab - 1) == $i ) { echo ' fl-tab-active';} ?>" id="<?php echo 'fl-tabs-' . $module->node . '-label-' . $i; ?>" data-index="<?php echo $i; ?>" aria-selected="<?php echo ( ($active_tab - 1) == $i ) ? 'true' : 'false';?>" aria-controls="<?php echo 'fl-tabs-' . $module->node . '-panel-' . $i; ?>" aria-expanded="<?php echo ( ($active_tab - 1) == $i ) ? 'true' : 'false'; ?>" role="tab" tabindex="0"><?php // @codingStandardsIgnoreLine ?>
				<?php echo $settings->items[ $i ]->label; ?>
				</a>
				<?php
			}
		} elseif ( 'post' == $settings->source ) {
			if ( $query->have_posts() ) {
				$i = 0;

				while ( $query->have_posts() ) {
					$query->the_post();

					$tab_label_id = 'fl-tabs-' . $module->node . '-label-' . $i;
					$id_in_label  = apply_filters( 'fl_tabs_id_in_label', false, $settings, $i );

					if ( $id_in_label && ! empty( $settings->id ) ) {
						$tab_label_id = $settings->id . '-label-' . $i;
					}
					?>
					<a href="#" class="fl-tabs-label<?php if ( ($active_tab - 1) == $i ) { echo ' fl-tab-active';} ?>" id="<?php echo 'fl-tabs-' . $module->node . '-label-' . $i; ?>" data-index="<?php echo $i; ?>" aria-selected="<?php echo ( ($active_tab - 1) == $i ) ? 'true' : 'false';?>" aria-controls="<?php echo 'fl-tabs-' . $module->node . '-panel-' . $i; ?>" aria-expanded="<?php echo ( ($active_tab - 1) == $i ) ? 'true' : 'false'; ?>" role="tab" tabindex="0"><?php // @codingStandardsIgnoreLine ?>
						<?php the_title(); ?>
					</a>
					<?php
					$i++;
				}
				wp_reset_postdata();
			}
		}
		?>

	</div>

	<div class="fl-tabs-panels fl-clearfix">
		<?php
		if ( 'content' == $settings->source ) {
			for ( $i = 0; $i < count( $settings->items ); $i++ ) {
				if ( ! is_object( $settings->items[ $i ] ) ) {
					continue;
				}
				?>
				<div class="fl-tabs-panel"<?php echo ( ! empty( $settings->id ) ) ? ' id="' . sanitize_html_class( $settings->id ) . '-' . $i . '"' : ''; ?>>
					<div class="fl-tabs-label fl-tabs-panel-label<?php echo ( ( $active_tab - 1 ) == $i ) ? ' fl-tab-active' : ''; ?>" data-index="<?php echo $i; ?>" tabindex="0">
						<span><?php echo $settings->items[ $i ]->label; ?></span>
						<i class="fas<?php echo ( ( $active_tab - 1 ) !== $i || 'close-all' === $tabs_on_mobile ) ? ' fa-plus' : ''; ?>"></i>
					</div>
					<div class="fl-tabs-panel-content fl-clearfix<?php if ( ($active_tab - 1)  == $i ) { echo ' fl-tab-active';} ?>" id="<?php echo 'fl-tabs-' . $module->node . '-panel-' . $i; ?>" data-index="<?php echo $i; ?>"<?php if ( ($active_tab - 1) !== $i ) { echo ' aria-hidden="true"';} ?> aria-labelledby="<?php echo 'fl-tabs-' . $module->node . '-label-' . $i; ?>" role="tabpanel" aria-live="polite"><?php // @codingStandardsIgnoreLine ?>
						<?php
						if ( 'none' === $settings->items[ $i ]->saved_layout ) {
							echo wpautop( $wp_embed->autoembed( $settings->items[ $i ]->content ) );
						} else {
							$post_id = $settings->items[ $i ]->{'saved_' . $settings->items[ $i ]->saved_layout};

							if ( ! empty( $post_id ) ) {
								$module->render_content( $post_id );
							}
						}
						?>
					</div>
				</div>
				<?php
			}
		} elseif ( 'post' == $settings->source ) {
			if ( $query->have_posts() ) {
				$i = 0;

				while ( $query->have_posts() ) {
					$query->the_post();
					?>
					<div class="fl-tabs-panel"<?php echo ( ! empty( $settings->id ) ) ? ' id="' . sanitize_html_class( $settings->id ) . '-' . $i . '"' : ''; ?>>
						<div class="fl-tabs-label fl-tabs-panel-label<?php echo ( ( $active_tab - 1 ) == $i ) ? ' fl-tab-active' : ''; ?>" data-index="<?php echo $i; ?>" tabindex="0">
							<span><?php the_title(); ?></span>
							<i class="fas<?php echo ( ( $active_tab - 1 ) !== $i || 'close-all' === $tabs_on_mobile ) ? ' fa-plus' : ''; ?>"></i>
						</div>
						<div class="fl-tabs-panel-content fl-clearfix<?php if ( ($active_tab - 1)  == $i ) { echo ' fl-tab-active';} ?>" id="<?php echo 'fl-tabs-' . $module->node . '-panel-' . $i; ?>" data-index="<?php echo $i; ?>"<?php if ( ($active_tab - 1) !== $i ) { echo ' aria-hidden="true"';} ?> aria-labelledby="<?php echo 'fl-tabs-' . $module->node . '-label-' . $i; ?>" role="tabpanel" aria-live="polite"><?php // @codingStandardsIgnoreLine ?>
							<?php $module->render_content( get_the_id() ); ?>
						</div>
					</div>
					<?php
					$i++;
				}
				wp_reset_postdata();
			}
		}
		?>
	</div>

</div>
