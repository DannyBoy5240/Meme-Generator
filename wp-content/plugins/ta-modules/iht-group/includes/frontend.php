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

<div class="ta-iht-group ta-iht-style-<?php echo $settings->style ?>">
  <h2 class="ta-iht-header">
    <?php

      for ( $i = 0; $i < count( $settings->header ); $i++ ) :

        if ( ! is_object( $settings->header[ $i ] ) ) {
          continue;
        }
        
        $class = null;
        
        $items = $settings->header[ $i ];
        if ($i == 0) {
          $class = 'ta-header-first';
        }
        if ($i == count( $settings->header ) - 1) {
          $class = 'ta-header-last';
        }
      ?>

      <span class="<?php echo $class; ?>"><?php echo $items->header; ?></span>

      <?php endfor; ?>

  </h2>
  <h3 class="ta-iht-text">
    <?php echo $settings->subhead ?>
  </h3>
  <div class="ta-iht-text">
    <?php echo $settings->text ?>
  </div>
  <div class="ta-iht-image">
    
    <?php $module->render_image(); ?>
  
  </div>
</div>


