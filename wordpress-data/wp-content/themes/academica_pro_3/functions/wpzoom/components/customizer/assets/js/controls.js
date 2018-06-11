/**
 * @package WPZOOM Framework
 */

/* global jQuery, wp */
(function (wp, $, WPZOOM_Controls) {
    'use strict';

    if ( ! wp || ! wp.customize || ! WPZOOM_Controls ) { return; }

    var api = wp.customize,
        WPZOOM;

    Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };

    // Setup
    WPZOOM = $.extend(WPZOOM_Controls, {
        cache: {
            $document: $(document),
            list_controls: api.control._value,
            control_elements: {},
            deps_is_ready: false,
            frag: false
        },
        __construct: function() {
            var self = this;

            self.setDependencies();
            self.checkDependency();
            self.initFont();
        },
        convertToType: function(value, type) {
            switch (type) {
                case 'number':
                    value = Number(value);
                    break;

                case 'string':
                    value = String(value);
                    break;

                case 'boolean':
                    value = Boolean(value);
                    break;
            }

            return value;
        },
        prepareItems: function(data, callback) {
            var self = this;

            var frag = document.createDocumentFragment();

            _.each(data, function (item, key) {

                _.each(item, function (text, val) {

                    var $option = new Option( text, val );

                    if ( val === 'label' ) {
                        $option = document.createElement('option');
                        $option.setAttribute( 'value', val + '-' + key );
                        $option.setAttribute( 'disabled', 'disabled' );
                        $option.textContent = text;
                    }

                    frag.appendChild($option);
                });

                self.cache.frag = true;
            });
            
            callback(frag);
        },
        checkDependency: function( event ) {
            event = event || 'ready';

            var self = this,
                list = self.cache.list_controls,
                list_dep = self.cache.list_dependencies,
                elements = self.cache.control_elements,
                controlID;

            var doCheck = function( event ) {
                var check = [];

                // Each all registered controls
                _.each(list, function(control){

                    var dependencies = {}, node = $(control.selector), element;

                    // Set control id
                    controlID = control.id;

                    // on document ready
                    if ( event == 'ready' && typeof list_dep[ controlID ] !== 'undefined' ) {
                        dependencies = list_dep[ controlID ]; // list of dependencies of this item
                    }

                    // on document change
                    if ( event == 'change' && typeof control.params.dependency != 'undefined' ) {
                        dependencies = control.params.dependency;
                    }

                    // Get the size of an object
                    var size = Object.size(dependencies);

                    // We have dependencies
                    if ( size ) {

                        check[ controlID ] = [];

                        // Link Elements
                        if ( typeof elements[ control.id ] == 'undefined' ) {
                            elements[ control.id ] = control;
                        }

                        // Each all dependencies to check if control satisfy all conditions or not
                        _.each(dependencies, function(val, id){

                            var control      = list[ id ], // dependency control
                                value        = control.setting.get(), // value of dependency control
                                value_type   = typeof value,
                                control_type = control.params.type,
                                node         = $(control.selector),
                                helper       = [];

                            if ( value == '' ) value = '0';

                            helper[ controlID ] = [];

                            // Link Elements
                            if ( typeof elements[ control.id ] == 'undefined' ) {
                                elements[ control.id ] = control;
                            }

                            // Check for multiple values
                            if ( _.isArray( val ) ) {
                                _.each(val, function(_val) {
                                    _val = WPZOOM.convertToType( _val, value_type );

                                    helper[ controlID ].push(value == _val);
                                });
                            } else {
                                val = WPZOOM.convertToType( val, value_type );

                                helper[ controlID ].push(value == val);
                            }

                            if ( _.contains( helper[ controlID ], true ) ) {
                                check[ controlID ].push(true);
                            } else {
                                check[ controlID ].push(false);
                            }

                        });

                    }

                    // Skip controls that has no dependency
                    if ( typeof check[ controlID ] == 'undefined' ) return;

                    // If control satisfy all conditions it remains visible
                    // else hide control until all conditions will be true
                    if ( _.contains(check[ controlID ], true) && ! _.contains(check[ controlID ], false) ) {
                        $('#customize-control-' + controlID).slideDown();
                    } else {
                        $('#customize-control-' + controlID).slideUp();
                    }

                });
            }

            // Check dependencies
            doCheck( event );

            // on Change event

            _.each(elements, function(control){
                var element = $(control.selector);

                if ( control.params.type == 'zoom_checkbox' && control.params.value == '0' ) {
                    element.find('input[type="checkbox"]').prop('checked', false);
                }

                // Update customizer controls visibility
                element.bind('change', function(e) {
                    doCheck(e.type);
                });
            });
        },
        setDependencies: function() {
            var self = this,
                list = self.cache.list_controls,
                dependencies = {};

            if ( self.cache.deps_is_ready ) return;

            _.each(list, function(control) {
                if ( typeof control.params.dependency != 'undefined' ) {
                    var id = control.id,
                        dependency = control.params.dependency;

                    if ( dependency ) {
                        dependencies[ id ] = dependency;
                    };
                }
            });

            self.cache.deps_is_ready = true;
            self.cache.list_dependencies = dependencies;
        }
    });

    // Font choice loader
    WPZOOM = $.extend(WPZOOM_Controls, {
        fontElements: $(),

        initFont: function() {
            var self = this;

            self.cache.$document.ready(function() {
                self.getFontElements();

                self.fontElements.each(function() {

                    $(this).chosen({
                        no_results_text: self.l10n.chosen_no_results_fonts,
                        search_contains: true,
                        width          : '100%'
                    })
                    .on('change', function (event, params){
                        self.updateFontParams(params);
                    });

                    $(this).on('chosen:showing_dropdown', self.updateFontElements);
                });
            });
        },

        getFontElements: function() {
            var self = this;
            var font;

            self.fontSettings = self.fontSettings || {};

            $.each(self.fontSettings, function(i, setting) {
                api.control(setting.setting_id, function(control) {
                    var $element = control.container.find('select');
                    var value = setting.default;

                    $element.data('settingId', setting.setting_id);

                    // Check selected value
                    if ( typeof setting.value != 'undefined' ) {
                        value = setting.value;
                    }

                    if ( setting.rule == 'font-family' ) {
                        $element.html('<option value="'+ value +'" selected="selected">' + value + '</option>');
                        font = value;

                        self.fontElements = self.fontElements.add($element);
                    }

                    if ( setting.rule == 'font-weight' || setting.rule == 'font-subset' ) {
                        self.updateFontParams({'container': control.container, 'selected': font, 'value': setting.value}, true);
                    }
                });
            });
        },

        updateFontElements: function() {
            var self = WPZOOM;

            self.fontElements.each(function() {
                $(this)
                    .html('<option>' + self.l10n.chosen_loading + '</option>')
                    .trigger('chosen:updated');
            });

            self.prepareItems(self.fontChoises, function(response) {
                if (response) {
                    self.insertFontChoices(response);
                }
            });
        },

        updateFontParams: function(params, init) {
            init = init || false;

            var options = $.extend({
                init: init,
                labels: ['font-weight', 'font-subset']
            }, params);

            var self = WPZOOM;
            var active_panel = self.cache.$document.find('.control-section.open');

            if ( init ) {

                _.each(options.labels, function(label){

                    options.label = label;

                    self.toggleFontLabels(options.container, options);
                });

            } else if ( ! init && active_panel.length ) {

                _.each(options.labels, function(label) {

                    var control_font_weight = active_panel.find('[id$="'+ label +'"][class*="customize-control"]');

                    if ( ! control_font_weight.length ) return;

                    var matches = control_font_weight.attr('id').match(/customize-control-(.*)/),
                        setting_id = matches[1],
                        $container = api.control(setting_id).container;

                    options.trigger = true;
                    options.label = label;

                    self.toggleFontLabels($container, options);
                });
            }
        },

        toggleFontLabels: function($container, options) {
            var self = WPZOOM;

            var label = options.label;

            // Hide all labels
            $container.find('label[for*="' + label + '"]').hide();

            // Standard Fonts
            if ( typeof self.fontParams[0].fonts[options.selected] != 'undefined' ) {

                // Show needed labels
                $container.find('label[for$="font-weightnormal"]').show();
                $container.find('label[for$="font-weightbold"]').show();

                // Hide 'Font Languages' control
                if ( $container.attr('id').indexOf('font-subset') != -1 ) {
                    $container.hide();
                }

                // Set 'normal' as default
                if ( options.trigger ) {
                    $container.find('label[for$="font-weightnormal"]').trigger('click');
                }

            }

            // Google Fonts
            if ( typeof self.fontParams[1].fonts[options.selected] != 'undefined' ) {

                // Font variants (100, 200, 300, 400, ...)
                _.each(self.fontParams[1].fonts[options.selected].variants, function (variant) {

                    // Skip variant if is italic
                    if ( variant.indexOf('italic') != -1 ) return;

                    // Regular is 400
                    if ( variant == 'regular' ) variant = 'normal';

                    // Show needed labels
                    $container.find('label[for$="font-weight'+ variant +'"]').show();

                    // Set 'normal' as default
                    if ( options.trigger && variant == 'normal' ) {

                        // Trigger 'click' if default value is not active
                        if ( ! $container.find('input[id$="font-weight'+ variant +'"]').is(':checked') ) {
                            $container.find('label[for$="font-weight'+ variant +'"]').trigger('click');
                        }
                    }

                    // Show 'bold'
                    $container.find('label[for$="font-weightbold"]').show();

                });


                // Show 'Font Languages' control
                if ( $container.attr('id').indexOf('font-subset') != -1 ) {
                    $container.show();
                }

                // Font subsets (latin, cyrillic, greek, ...)
                _.each(self.fontParams[1].fonts[options.selected].subsets, function (subset) {

                    // Show needed labels
                    $container.find('label[for$="font-subset'+ subset +'"]').show();

                    // Show 'all' label if font has more than 3 subsets
                    if ( self.fontParams[1].fonts[options.selected].subsets.length > 3 ) {
                        $container.find('label[for$="font-subsetall"]').show();
                    }

                    // Set 'normal' as default
                    if ( options.trigger && subset == 'latin' ) {

                        // Trigger 'click' if default value is not active
                        if ( ! $container.find('input[id$="font-subset'+ subset +'"]').is(':checked') ) {
                            $container.find('label[for$="font-subset'+ subset +'"]').trigger('click');
                        }
                    }

                });

            }

        },

        insertFontChoices: function(content) {
            var self = this;

            self.fontElements.each(function() {
                var $element = $(this),
                    settingId = $element.data('settingId');

                var foo = content.cloneNode(true);

                $element.html(foo);

                api(settingId, function(setting) {
                    var v = setting();
                    $element
                        .val(v)
                        .trigger('chosen:updated')
                        .off('chosen:showing_dropdown', self.updateFontElements);
                });
            });
        }
    });

    $(document).ready(function() {
        WPZOOM.__construct();
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Select
     *
     * @since 1.7.0
     */
    api.controlConstructor.zoom_select = api.Control.extend({
        ready: function() {
            var control = this,
                $container = control.container.find('.zoom-select-container'),
                $input = $('select', $container);

            // Listen for changes to the select.
            $input.on('change', function() {
                var value = $(this).val();
                var value_type = typeof control.setting.get();

                control.setting.set( WPZOOM.convertToType( value, value_type ) );
            });

            // Update the select if the setting changes.
            control.setting.bind(function(value) {
                $input.val(value);
            });
        }
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Sortable
     *
     * @since 1.7.0
     */
    api.controlConstructor.zoom_sortable = api.Control.extend({
        ready: function() {
            var control = this,
                $container = control.container.find('.zoom-sortable-container'),
                $label = control.container.find('.customize-control-title'),
                $sortable = $('ol', $container),
                $input = $('input[type="hidden"]', $container);

            var newval;

            $label.on('click', function(e){ e.preventDefault(); $sortable.focus(); });

            $sortable.sortable({
                axis: "y",
                containment: "parent",
                update: function(e, ui){
                    var value_type = typeof control.setting.get();
                        newval = '';

                    // Listen for changes to the sortable.
                    $.each($sortable.sortable("toArray"), function(index, id){
                        var value = $container.find('#' + id).attr('data-item-value');

                        newval += value;
                    });

                    control.setting.set( WPZOOM.convertToType( newval, value_type ) );
                }
            });

            // Update the select if the setting changes.
            control.setting.bind(function(value) {
                $input.val(value);
            });
        }
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Radio
     *
     * @since 1.7.0.
     */
    api.controlConstructor.zoom_radio = api.Control.extend({
        ready: function() {
            var control = this,
                $container = control.container.find('.zoom-radio-container');

            $container.each(function() {
                if ($(this).hasClass('zoom-radio-buttonset-container') || $(this).hasClass('zoom-radio-image-container')) {
                    $(this).buttonset();
                }
            });

            // Listen for changes to the radio group.
            $container.on('change', 'input:radio', function() {
                var value = $(this).parent().find('input:radio:checked').val();
                var value_type = typeof control.setting.get();
                
                control.setting.set( WPZOOM.convertToType( value, value_type ) );
            });

            // Update the radio group if the setting changes.
            control.setting.bind(function(value) {
                $container.find('input:radio').filter('[value=' + value + ']').prop('checked', true);
            });
        }
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Background_Gradient
     *
     * @since 1.7.1.
     */
    api.controlConstructor.zoom_background_gradient = api.Control.extend({
        obj: {},
        ready: function() {
            var control = this,
                settings = control.setting.get(),
                $container = control.container.find('.zoom-background-gradient-container'),
                picker = control.container.find( '.color-picker-hex' ),
                directions = control.container.find( 'select#directions' ),
                range = control.container.find( '.range-opacity-container' );

            try {
                control.obj = JSON.parse( settings );
            } catch (e) {
                control.obj = [settings];
            }

            picker.each(function(){
                var id = $(this).attr('id'),
                    value = control.obj[0][ id ];

                control.initColorPicker( $(this), value );
            });

            // Listen for changes to the select.
            directions.on('change', function() {
                var value = $(this).val();

                control.obj[0]['direction'] = value;

                control.setting.set( JSON.stringify(control.obj) );
            });

            // Update the select if the setting changes.
            control.setting.bind(function(value) {
                value = JSON.parse(value);

                directions.val(value[0]['direction']);
            });

            range.each(function() {
                control.initRange( $(this) );
            });
        },
        initColorPicker: function( picker, value ) {
            var control = this,
                updating = false,
                id = picker.attr('id');
                
            picker.val( value ).wpColorPicker({
                change: function() {
                    updating = true;

                    control.obj['picker'] = picker;
                    control.obj['id'] = id;
                    control.obj[0][ id ] = picker.wpColorPicker( 'color' );

                    control.setting.set( JSON.stringify(control.obj) );
                    updating = false;
                },
                clear: function() {
                    updating = true;

                    control.obj['picker'] = picker;
                    control.obj['id'] = id;
                    control.obj[0][ id ] = '';

                    control.setting.set( JSON.stringify(control.obj) );
                    updating = false;
                }
            });

            control.setting.bind( function ( value ) {
                // Bail if the update came from the control itself.
                if ( updating ) {
                    return;
                }

                value = JSON.parse(value);

                var picker = value[ 'picker' ], id = value[ 'id' ];

                _.each(value[0], function(val, key) {
                    if ( id === key ) {
                        picker.val( val );
                        picker.wpColorPicker( 'color', val );
                    }
                });

            } );
            

            // Collapse color picker when hitting Esc instead of collapsing the current section.
            control.container.on( 'keydown', function( event ) {
                var pickerContainer;
                if ( 27 !== event.which ) { // Esc.
                    return;
                }
                pickerContainer = control.container.find( '.wp-picker-container' );

                $.each(pickerContainer, function(){
                    if ( $(this).hasClass( 'wp-picker-active' ) ) {
                        if ( typeof control.obj[ 'picker' ] !== 'undefined' ) {
                            control.obj[ 'picker' ].wpColorPicker( 'close' );
                        }

                        $(this).find( '.wp-color-result' ).focus();
                        event.stopPropagation(); // Prevent section from being collapsed.
                    }
                });
            } );
        },
        initRange: function( container ) {
            var control = this;

            var $input = container.find('.zoom-range-input'),
                $slider = container.find('.zoom-range-slider'),
                value = parseFloat( $input.val() ),
                min = parseFloat( $input.attr('min') ),
                max = parseFloat( $input.attr('max') ),
                step = parseFloat( $input.attr('step') );

            // Configure the slider
            $slider.slider({
                value : value,
                min   : min,
                max   : max,
                step  : step,
                slide : function(e, ui) { $input.val(ui.value) }
            });

            // Debounce the slide event so the preview pane doesn't update too often
            $slider.on('slide', _.debounce(function(e, ui) {
                $input.keyup().trigger('change');
            }, 300));

            // Sync values of number input and slider
            $input.val( $slider.slider('value')).on('change', function() {
                $slider.slider('value', $(this).val());
            });

            // Listen for changes to the range.
            $input.on('change', function() {
                var value = $(this).val(),
                    id = $(this).attr('id');

                control.obj['slide'] = $(this);
                control.obj['slide_id'] = id;
                control.obj[0][ id ] = value;

                control.setting.set( JSON.stringify(control.obj) );
            });

            // Update the range if the setting changes.
            control.setting.bind(function(value) {
                var $input = control.obj['slide'],
                    id = control.obj['slide_id'];

                value = JSON.parse(value);

                if ( typeof id !== 'undefined' ) {
                    $input.val(value[0][ id ]);
                }
            });
        }
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Checkbox_Multiple
     *
     * @since 1.7.0.
     */
    api.controlConstructor.zoom_checkbox_multiple = api.Control.extend({
        ready: function() {
            var control = this,
                multiple_values = [],
                $container = control.container.find('.zoom-checkbox-container');

            $container.each(function() {
                if ($(this).hasClass('zoom-checkbox-buttonset-container')) {
                    $(this).buttonset();
                }
            });

            // Map checked values
            $container.find('input:checkbox').each(function() {
                if ( $(this).is(':checked') ) {
                    multiple_values.push( $(this).val() );
                }
            });

            // Listen for changes to the checkbox group.
            $container.on('change', 'input:checkbox', function() {
                var value = $(this).val();
                var isButtonset = $(this).hasClass('zoom-checkbox-buttonset-container');

                // Add new value in array if doesn't contains
                // else remove it
                if ( ! _.contains(multiple_values, value) ) {
                    multiple_values.push( value );
                } else {
                    multiple_values = $.grep(multiple_values, function(val) {
                        return val != value;
                    });
                }

                // Check all checkboxes
                if ( value == 'all' ) {

                    if ( isButtonset ) {
                        $container.find('input:checkbox').prop('checked', this.checked).button('refresh');
                    } else {
                        $container.find('input:checkbox').prop('checked', this.checked);
                    }

                    // Push all values in array if 'all' is checked
                    // else empty array
                    if ( this.checked ) {
                        $container.find('input:checkbox').each(function() {
                            if ( $(this).val() != 'all' ) {
                                multiple_values.push( $(this).val() );
                            }
                        });
                    } else {
                        multiple_values = [];
                    }
                }

                control.setting.set(multiple_values);
            });

            // Update the checkbox group if the setting changes.
            control.setting.bind(function(value) {
                var isButtonset = $container.hasClass('zoom-checkbox-buttonset-container');

                _.each(multiple_values, function(val){

                    if ( isButtonset ) {
                        $container.find('input:checkbox').filter('[value=' + val + ']').prop('checked', true).button('refresh');
                    } else {
                        $container.find('input:checkbox').filter('[value=' + val + ']').prop('checked', true);
                    }

                });
            });
        }
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Checkbox
     *
     * @since 1.7.1.
     */
    api.controlConstructor.zoom_checkbox = api.Control.extend({
        ready: function() {
            var control = this,
                $container = control.container.find('.zoom-checkbox-container');

            // Listen for changes to the checkbox.
            $container.on('change', 'input:checkbox', function() {
                var value = $(this).parent().find('input:checkbox:checked').val();
                var value_type = typeof control.setting.get();
                
                control.setting.set( WPZOOM.convertToType( value, value_type ) );
            });

            // Update the checkbox if the setting changes.
            control.setting.bind(function(value) {
                $container.find('input:checkbox').filter('[value=' + value + ']').prop('checked', true);
            });
        }
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Text
     *
     * @since 1.7.1.
     */
    api.controlConstructor.zoom_text = api.Control.extend({
        ready: function() {
            var control = this,
                $container = control.container.find('.zoom-text-container');

            // Listen for changes to the text input.
            $container.on('change', 'input:text', function() {
                var value = $(this).val();
                var value_type = typeof control.setting.get();
                
                control.setting.set( WPZOOM.convertToType( value, value_type ) );
            });

            // Update the text input if the setting changes.
            control.setting.bind(function(value) {
                $container.find('input:text').val(value);
            });
        }
    });

    /**
     * Initialize instances of WPZOOM_Customizer_Control_Range
     *
     * @since 1.7.0.
     */
    api.controlConstructor.zoom_range = api.Control.extend({
        ready: function() {
            var control = this,
                $container = control.container.find('.zoom-range-container');

            $container.each(function() {
                var $input = $(this).find('.zoom-range-input'),
                    $slider = $(this).find('.zoom-range-slider'),
                    value = parseFloat( $input.val() ),
                    min = parseFloat( $input.attr('min') ),
                    max = parseFloat( $input.attr('max') ),
                    step = parseFloat( $input.attr('step') );

                // Configure the slider
                $slider.slider({
                    value : value,
                    min   : min,
                    max   : max,
                    step  : step,
                    slide : function(e, ui) { $input.val(ui.value) }
                });

                // Debounce the slide event so the preview pane doesn't update too often
                $slider.on('slide', _.debounce(function(e, ui) {
                    $input.keyup().trigger('change');
                }, 300));

                // Sync values of number input and slider
                $input.val( $slider.slider('value')).on('change', function() {
                    $slider.slider('value', $(this).val());
                });

                // Listen for changes to the range.
                $input.on('change', function() {
                    var value = $(this).val();
                    control.setting.set(value);
                });

                // Update the range if the setting changes.
                control.setting.bind(function(value) {
                    $input.val(value);
                });
            });
        }
    });

})(wp, jQuery, WPZOOM_Controls);