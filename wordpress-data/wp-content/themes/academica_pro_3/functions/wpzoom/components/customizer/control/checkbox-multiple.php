<?php
/**
 * @package WPZOOM
 */

/**
 * Class WPZOOM_Customizer_Control_Checkbox_Multiple
 *
 * Specialized checkbox control to enable multiple value choices.
 *
 *
 * @since 1.7.0.
 */
class WPZOOM_Customizer_Control_Checkbox_Multiple extends WPZOOM_Customize_Control {
    /**
     * The control type.
     *
     * @since 1.7.0.
     *
     * @var string
     */
    public $type = 'zoom_checkbox_multiple';

    /**
     * The control mode.
     *
     * Possible values are 'buttonset', 'checkbox'.
     *
     * @since 1.7.0.
     *
     * @var string
     */
    public $mode = 'checkbox';

    /**
     * WPZOOM_Customizer_Control_Checkbox_Multiple constructor.
     *
     * @since 1.7.0.
     *
     * @param WP_Customize_Manager $manager
     * @param string               $id
     * @param array                $args
     */
    public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
        parent::__construct( $manager, $id, $args );

        // Ensure this instance maintains the proper type value.
        $this->type = 'zoom_checkbox_multiple';
    }

    /**
     * Enqueue necessary scripts for this control.
     *
     * @since 1.7.0.
     *
     * @return void
     */
    public function enqueue() {
        if ( 'buttonset' === $this->mode ) {
            wp_enqueue_script( 'jquery-ui-button' );
        }
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 1.7.1.
     * @uses WP_Customize_Control::to_json()
     */
    public function to_json() {
        parent::to_json();

        $this->json['id'] = $this->id;
        $this->json['mode'] = $this->mode;
        $this->json['choices'] = $this->choices;
        $this->json['value'] = $this->value();
        $this->json['link'] = $this->get_link();
    }

    /**
     * Define the JS template for the control.
     *
     * @since 1.7.0.
     *
     * @return void
     */
    protected function content_template() { ?>
        <# if (data.label) { #>
            <span class="customize-control-title">{{ data.label }}</span>
        <# } #>
        <# if (data.description) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
        <# } #>

        <div id="input_{{ data.id }}" class="zoom-checkbox-container<# if (0 <= ['buttonset'].indexOf( data.mode )) { #> zoom-checkbox-{{ data.mode }}-container<# } #>">
            <# if ('buttonset' === data.mode) { #>
                <# for (key in data.choices) { #>
                    <input id="{{ data.id }}{{ key }}" name="_customize-checkbox-{{ key }}" type="checkbox" value="{{ key }}" <# if ( (typeof data.value == 'string' && key == data.value) || (jQuery.isArray(data.value) && 0 <= data.value.indexOf( key )) ) { #> checked="checked" <# } #> />
                    <label for="{{ data.id }}{{ key }}">{{ data.choices[ key ] }}</label>
                <# } #>
            <# } else { #>
                <# for (key in data.choices) { #>
                    <label for="{{ data.id }}{{ key }}" class="customizer-checkbox">
                        <input id="{{ data.id }}{{ key }}" name="_customize-checkbox-{{ key }}" type="checkbox" value="{{ key }}" <# if ( (typeof data.value == 'string' && key == data.value) || (jQuery.isArray(data.value) && 0 <= data.value.indexOf( key )) ) { #> checked="checked" <# } #> />
                        {{ data.choices[ key ] }}<br />
                    </label>
                <# } #>
            <# } #>
        </div>
    <?php
    }

    
}