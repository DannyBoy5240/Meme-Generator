<header class="fl-page-header fl-page-header-primary<?php FLTheme::header_classes(); ?>"<?php FLTheme::header_data_attrs(); ?> itemscope="itemscope" itemtype="https://schema.org/WPHeader">
	<div class="fl-page-header-wrap">
		<div class="fl-page-header-container container">
			<div class="fl-page-header-row row">
				<div class="col-md-6 col-sm-6 fl-page-header-logo-col">
					<div class="fl-page-header-logo" itemscope="itemscope" itemtype="https://schema.org/Organization">
            <a href="<?php echo home_url(); ?>">
							<img class="fl-logo-img" itemscope itemtype="http://schema.org/ImageObject" src="<?php echo get_stylesheet_directory_uri() ?>/images/tides_advocacy_logo.svg" alt="Tides Advocacy logo" /><meta itemprop="name" content="Tides Advocacy logo" />
						</a>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
          <div class="xsearch-topmenu-wrap">
            <?php 

            wp_nav_menu(array(
              'theme_location' => 'bar',
              'items_wrap' => '<ul id="%1$s" class="fl-page-bar-nav nav navbar-nav %2$s">%3$s</ul>',
              'container' => false,
              'fallback_cb' => 'FLTheme::nav_menu_fallback',
            )); 
            
            FLTheme::nav_search(); ?>
          </div>
				</div>
			</div>
		</div>
	</div>
	<div class="fl-page-nav-wrap">
		<div class="fl-page-nav-container container">
			<nav class="fl-page-nav navbar navbar-default" role="navigation" aria-label="<?php echo esc_attr( FLTheme::get_nav_locations( 'header' ) ); ?>" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".fl-page-nav-collapse">
					<span><?php FLTheme::nav_toggle_text(); ?></span>
				</button>
				<div class="fl-page-nav-collapse collapse navbar-collapse">
          <div class="fl-page-header-logo" itemscope="itemscope" itemtype="https://schema.org/Organization">
            <a href="<?php echo home_url(); ?>">
							<img class="fl-logo-img" itemscope itemtype="http://schema.org/ImageObject" src="<?php echo get_stylesheet_directory_uri() ?>/images/tides_advocacy_logo.svg" alt="Tides Advocacy logo" /><meta itemprop="name" content="Tides Advocacy logo" />
						</a>
					</div>
					<?php

					wp_nav_menu(array(
						'theme_location' => 'header',
						'items_wrap' => '<ul id="%1$s" class="nav navbar-nav %2$s">%3$s</ul>',
						'container' => false,
						'fallback_cb' => 'FLTheme::nav_menu_fallback',
          ));
          
          wp_nav_menu(array(
            'theme_location' => 'bar',
            'items_wrap' => '<ul id="%1$s" class="fl-page-bar-nav nav navbar-nav %2$s">%3$s</ul>',
            'container' => false,
            'fallback_cb' => 'FLTheme::nav_menu_fallback',
          )); 

					FLTheme::nav_search();

					?>
				</div>
			</nav>
		</div>
	</div>
</header><!-- .fl-page-header -->
