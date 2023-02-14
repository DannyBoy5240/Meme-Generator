<?php

if( class_exists('WP_Customize_Control' ) ) {

    class WP_Customize_Control_ShiftNav_Radio_HTML extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content() {

        	if ( empty( $this->choices ) )
					return;

				$name = '_customize-radio-' . $this->id;

				if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;
				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description ; ?></span>
				<?php endif;

        ?><span class="customize-inside-control-row"><?php

				foreach ( $this->choices as $value => $label ) :
					?>
					<label>
						<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<?php echo $label; ?><br/>
					</label>
					<?php
				endforeach;
        ?></span> <?php
        }
    }
}

if( class_exists('WP_Customize_Control' ) ) {

    class WP_Customize_Control_ShiftNav_Checkbox extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content() {
        	/*value="<?php echo esc_attr( $this->value() ); ?>"  value="<?php echo esc_attr( $value ); ?>"*/
        	$value = $this->value() == 'on' ? true : false;
        	?>

          <span class="customize-inside-control-row">

        	<label>
				<input type="checkbox"  <?php $this->link(); checked( $value ); ?> />
				<strong><?php echo esc_html( $this->label ); ?></strong>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</label>
          </span>
			<?php
				/*
				$name = '_customize-radio-' . $this->id;

				if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;
				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description ; ?></span>
				<?php endif;

				foreach ( $this->choices as $value => $label ) :
					?>
					<label>
						<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<?php echo $label; ?><br/>
					</label>
					<?php
				endforeach;*/
		}

    }
}
