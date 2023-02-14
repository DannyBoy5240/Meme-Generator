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

<div class="ta-quote ta-quote-align-<?php echo $settings->quote_align ?> ta-quote-color-<?php echo $settings->quote_color ?> ta-quote-style-<?php echo $settings->quote_style ?> ta-quote-size-<?php echo $settings->quote_size ?><?php if (!empty($settings->quote_name)) : echo ' ta-quote-has-credit'; endif; ?>">
  <div class="ta-quote-text">
    <?php echo $settings->quote_text ?>
  </div>
  <?php if (!empty($settings->quote_name)) : ?>
    <div class="ta-quote-wrap">
      <div class="ta-quote-name">
        <?php echo $settings->quote_name ?>
      </div>
      <?php if (!empty($settings->quote_org)) : ?>
        <div class="ta-quote-org">
          <?php echo $settings->quote_org ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
