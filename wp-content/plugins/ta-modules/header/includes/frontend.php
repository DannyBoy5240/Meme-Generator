<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file: 
 * 
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 * Example: 
 */

?>	
  <<?php echo $settings->text_header; ?> class="ta-header ta-header-background-<?php echo $settings->text_bkg; ?> ta-header-weight-<?php echo $settings->text_weight; ?> ta-header-italics-<?php echo $settings->text_italic; ?> ta-header-width-<?php echo $settings->text_width; ?> ta-header-border-<?php echo $settings->text_border; ?> ta-header-align-<?php echo $settings->text_align; ?> ta-header-style-<?php echo $settings->text_style; ?> ta-header-size-<?php echo $settings->text_size; ?> ta-header-color-<?php echo $settings->text_color; ?>">
      <?php if ( ! empty( $settings->link ) ) : ?>
        <a href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>"<?php echo ( '_blank' == $settings->link_target ) ? ' rel="noopener"' : '';?>>
      <?php endif; ?>
      <?php
        if (!empty($settings->item_header_single)) {
          echo $settings->item_header_single;
        }

        else {

        for ( $i = 0; $i < count( $settings->item_header ); $i++ ) :

          if ( ! is_object( $settings->item_header[ $i ] ) ) {
            continue;
          }
          
          $class = null;
          
          $items = $settings->item_header[ $i ];
          if ($i == 0) {
            $class = 'ta-header-first';
          }
          if ($i == count( $settings->item_header ) - 1) {
            $class = 'ta-header-last';
          }
        ?>

        <span class="<?php echo $class; ?>"><?php echo $items->header; ?></span>

      <?php endfor; }?>
      <?php if ( ! empty( $settings->link ) ) : ?>
        </a>
      <?php endif; ?>
</<?php echo $settings->text_header; ?>>