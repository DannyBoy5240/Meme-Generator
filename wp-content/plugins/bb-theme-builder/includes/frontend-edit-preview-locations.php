<div class="fl-theme-builder-preview-select fl-builder-button">

	<div class="fl-theme-builder-preview-select-title">
		<i class="fas fa-caret-down"></i>
		<div>
			<?php echo __( 'Preview As', 'bb-theme-builder' ) . ': '; ?>
			<span><?php echo $label; ?></span>
		</div>
	</div>

	<div class="fl-theme-builder-preview-select-items">
		<?php foreach ( $locations['general'] as $key => $data ) : ?>
		<div class="fl-theme-builder-preview-select-item" data-location="general:<?php echo $data['id']; ?>">
			<div class="fl-theme-builder-preview-select-item-title"><?php echo $data['label']; ?></div>
		</div>
		<?php endforeach; ?>
		<?php foreach ( $locations['post'] as $post_type => $data ) : ?>
			<?php
			if ( ! isset( $data['label'] ) ) {
				continue;
			}
			?>
		<div class="fl-theme-builder-preview-select-item" data-location="post:<?php echo $post_type; ?>" data-children-loaded="<?php echo ( $data['all'] ? 0 : 1 ); ?>">
			<div class="fl-theme-builder-preview-select-item-title"><?php echo $data['label']; ?><i class="fas fa-caret-down"></i></div>
			<div class="fl-theme-builder-preview-select-item-children">
				<?php if ( ! $data['all'] ) : ?>
					<?php foreach ( $data['posts'] as $child ) : ?>
					<div class="fl-theme-builder-preview-select-item-child" data-location="post:<?php echo $post_type; ?>:<?php echo $child['id']; ?>"><?php echo $child['title']; ?></div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
		<?php if ( ! empty( $locations['archive'] ) ) : ?>
		<div class="fl-theme-builder-preview-select-item">
			<div class="fl-theme-builder-preview-select-item-title"><?php _e( 'Archives', 'bb-theme-builder' ); ?><i class="fas fa-caret-down"></i></div>
			<div class="fl-theme-builder-preview-select-item-children">
				<?php foreach ( $locations['archive'] as $data ) : ?>
				<div class="fl-theme-builder-preview-select-item-child" data-location="archive:<?php echo $data['id']; ?>"><?php echo $data['label']; ?></div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
		<?php foreach ( $locations['taxonomy'] as $taxonomy => $data ) : ?>
		<div class="fl-theme-builder-preview-select-item" data-location="taxonomy:<?php echo $taxonomy; ?>" data-children-loaded="<?php echo ( $data['all'] ? 0 : 1 ); ?>">
			<div class="fl-theme-builder-preview-select-item-title"><?php echo $data['label']; ?><i class="fas fa-caret-down"></i></div>
			<div class="fl-theme-builder-preview-select-item-children">
				<?php if ( ! $data['all'] ) : ?>
					<?php foreach ( $data['terms'] as $child ) : ?>
					<div class="fl-theme-builder-preview-select-item-child" data-location="taxonomy:<?php echo $taxonomy; ?>:<?php echo $child['id']; ?>"><?php echo $child['title']; ?></div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

</div>
