<?php do_action( 'fl_content_close' ); ?>

	</div><!-- .fl-page-content -->
	<?php

	do_action( 'fl_after_content' );

	if ( FLTheme::has_footer() ) :

	?>
	<footer class="fl-page-footer-wrap" itemscope="itemscope" itemtype="https://schema.org/WPFooter">
    <div id="footer">
      <div class="footer-signup">
        <?php 
          echo do_shortcode('[fl_builder_insert_layout id="70"]');
        ?>
        <?php 
          echo do_shortcode('[fl_builder_insert_layout id="69"]');
        ?>
      </div>
      <div class="footer-main container">
        <div class="search-topmenu-footer-wrap footer-topmenu-desktop">
            
            <?php 

            wp_nav_menu(array(
              'theme_location' => 'bar',
              'items_wrap' => '<ul id="%1$s" class="fl-page-bar-nav nav navbar-nav %2$s">%3$s</ul>',
              'container' => false,
              'fallback_cb' => 'FLTheme::nav_menu_fallback',
            )); 
            
            FLTheme::nav_search(); ?>
        </div>
        <div class="primary-menu-wrap">
          <?php
            wp_nav_menu(array(
                'theme_location' => 'header',
                'items_wrap' => '<ul id="%1$s" class="nav navbar-nav %2$s">%3$s</ul>',
                'container' => false,
                'fallback_cb' => 'FLTheme::nav_menu_fallback',
              ));
          ?>
        </div>
        <div class="search-topmenu-footer-wrap footer-topmenu-mobile">
            
            <?php 

            wp_nav_menu(array(
              'theme_location' => 'bar',
              'items_wrap' => '<ul id="%1$s" class="fl-page-bar-nav nav navbar-nav %2$s">%3$s</ul>',
              'container' => false,
              'fallback_cb' => 'FLTheme::nav_menu_fallback',
            )); 
            
           ?>
        </div>
        <?php FLTheme::footer_col1(); ?>
      </div>
    </div>
	</footer>
	<?php endif; ?>
	<?php do_action( 'fl_page_close' ); ?>
</div><!-- .fl-page -->
<?php

wp_footer();

do_action( 'fl_body_close' );

FLTheme::footer_code();

?>
</body>
</html>
