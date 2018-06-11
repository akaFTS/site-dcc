<?php
/**
 * @package WPZOOM
 */

/**
 * Class WPZOOM_Customizer_Control_Color
 *
 * Extended Customize Color Control class.
 *
 *
 * @since 1.7.1.
 */
class WPZOOM_Customizer_Control_Color extends WP_Customize_Color_Control {
    /**
     * The control contextual dependency.
     *
     * @since 1.7.1.
     *
     * @var string
     */
    public $dependency = false;

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 1.7.1.
     * @uses WP_Customize_Control::to_json()
     */
    public function to_json() {
        parent::to_json();

        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
        $this->json['mode'] = $this->mode;
        $this->json['dependency'] = $this->dependency;
    }
    
}