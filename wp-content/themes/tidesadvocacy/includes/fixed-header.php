<header class="fl-page-header fl-page-header-fixed fl-page-nav-right fl-page-nav-toggle-<?php echo FLTheme::get_setting( 'fl-mobile-nav-toggle' ) ?> fl-page-nav-toggle-visible-<?php echo FLTheme::get_setting( 'fl-nav-breakpoint' ) ?>">
	<div class="fl-page-header-wrap">
		<div class="fl-page-header-container container">
			<div class="fl-page-header-row row">
				<div class="fl-page-logo-wrap col-md-2 col-sm-12">
					<div class="fl-page-header-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php FLTheme::fixed_header_logo(); ?></a>
					</div>
				</div>
				<div class="fl-page-fixed-nav-wrap col-md-10 col-sm-12">
					<div class="fl-page-nav-wrap">
						<nav class="fl-page-nav fl-nav navbar navbar-default" role="navigation" aria-label="<?php echo esc_attr( FLTheme::get_nav_locations( 'header' ) ); ?>">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".fl-page-nav-collapse">
								<span><?php FLTheme::nav_toggle_text(); ?></span>
							</button>
							<div class="fl-page-nav-collapse collapse navbar-collapse">
								<?php

								wp_nav_menu(array(
									'theme_location' => 'header',
									'items_wrap' => '<ul id="%1$s" class="nav navbar-nav navbar-right %2$s">%3$s</ul>',
									'container' => false,
									'fallback_cb' => 'FLTheme::nav_menu_fallback',
								));

								?>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</header><!-- .fl-page-header-fixed -->
