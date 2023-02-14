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

<div class="ta-grid-item ta-grid-style-<?php echo $settings->item_style ?>">
  <?php if (!empty($settings->item_header)) : ?>
    <h3 class="ta-item-title">
      <?php

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

        <?php endfor; ?>

    </h3>
  <?php endif; ?>
  <div class="ta-item-text">
    <?php echo $settings->item_text ?>
  </div>
  <?php if (!empty($settings->item_button_link)) : ?>
    <div class="ta-item-button">
      <a href="<?php echo $settings->item_button_link; ?>" title="<?php echo $settings->item_button_text; ?>" target="<?php echo $settings->link_target; ?>" class="ta-button" role="button">
        <?php echo $settings->item_button_text; ?>
      </a>
    </div>
  <?php endif; ?>
</div>


