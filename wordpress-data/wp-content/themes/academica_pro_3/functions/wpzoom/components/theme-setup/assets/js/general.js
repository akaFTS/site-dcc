/**
 * general.js workflow for theme setup.
 */

(function ($, _, zoomData) {

    var D = $(document),
        B = $('body'),
        W = $(window);

    var _options = {
        "steps_status": {},
        "config_menu": {},
        "front_page": {},
        "data": {},
    };

    var settings_fields = ['delete_wp_defaults', 'regenerate_only_feat_img'],
        modal_items     = [];

    var themeSetup = {
        beforeUnloadCallback: function (e) {
            e.returnValue = zoomData.strings.on_leave_alert; // Gecko, Trident, Chrome 34+
            return zoomData.strings.on_leave_alert; // Gecko, WebKit, Chrome <34
        },
        popup: {
            instance: $.magnificPopup.instance,
            getPopupHtml: function (data) {
                var opts = $.extend({
                    step_id: '',
                    header_steps: true,
                    header: false,
                    content: false,
                    controls: false
                }, data);

                var header_steps = opts.header_steps ? '<div class="white-popup-header-steps">' + themeSetup.popup.getStepsHTML(zoomData.steps) + '</div>' : '';
                var header = opts.header ? '<div class="white-popup-header">' + opts.header + '</div>' : '';
                var content = '<div class="white-popup-content">' + (opts.content ? opts.content : '') + '</div>';
                var controls = '<div class="white-popup-controls' + (opts.controls ? '' : 'no-border') + '">' + (opts.controls ? opts.controls : '') + '</div>';

                var html = '<div class="white-popup">' +
                    header_steps +
                    header +
                    content +
                    controls +
                    '</div>';
                return html;
            },
            getPopupItem: function (data) {
                var currentThumb = zoomData.thumbs.length - data._thumbsLength + 1;
                var thumbsLength = zoomData.thumbs.length;

                var dataOpts = data.success ? {
                    header: '<div class="white-popup-header-progress-wrapper">' +
                    '<div class="white-popup-header-progress" style="width:' + ( (currentThumb * 100) / thumbsLength) + '%"></div>' +
                    '</div>',
                    'content': '<div class="cssload-container">' +
                    '<div class="cssload-whirlpool"></div>' +
                    '</div>' +
                    '<p class="description">' + data.data.message + '</p>',
                    controls: '<p class="description">' +
                    (zoomData.strings.images_progress.replace('{1}', currentThumb).replace('{2}', thumbsLength))
                    + '</p>'
                } :
                {
                    content: '<p class="description warning-msg">' + data.data.message + '</p>'
                };

                return [
                    {
                        src: themeSetup.popup.getPopupHtml(dataOpts),
                        type: 'inline'
                    }
                ];
            },
            openOnce: function (data) {
                _options['current'] = themeSetup.popup.instance.index;

                themeSetup.popup.instance.open({
                    items: {
                        src: themeSetup.popup.getPopupHtml({
                            content: '<div class="cssload-container">' +
                            '<div class="cssload-whirlpool"></div>' +
                            '</div>' +
                            '<p class="description">' + data.data.message + '</p>'
                        }),
                        type: 'inline'
                    },
                    modal: true
                }, 0);
            },
            openWarningModal: function (data) {
                themeSetup.popup.instance.close();

                themeSetup.popup.instance.open({
                    items: {
                        src: themeSetup.popup.getPopupHtml({
                            header: data.data.message,
                            content: '<div class="popup-modal-message warning-message">' +
                                '<div class="icon-wrap">' +
                                    '<span><i class="fa fa-exclamation"></i></span>' +
                                '</div>' +
                                '<p class="description">' + data.data.message + '</p>' +
                            '</div>'
                        }),
                        type: 'inline'
                    }
                });

                _.delay(function(){
                    themeSetup.popup.instance.content.find('.popup-modal-message').addClass('done');
                }, 50);
            },
            getControls: function(data) {
                var out = '';

                $.each(data, function(index, val) {
                    var float = "float" in val ? 'style="float: '+ val.float +'"' : '';

                    if ( val.action == 'skip' ) {
                        out += '<button type="button" '+ float +' class="'+ val.class +' skip-step" id="'+ val.id +'">'+ val.text +'</button>';
                    } else if ( val.action == 'settings' ) {
                        out += '<button type="button" '+ float +' class="'+ val.class +' advanced-settings" id="'+ val.id +'">'+ val.text +'</button>';
                    } else if ( val.action == 'next' ) {
                        out += '<button type="button" '+ float +' class="'+ val.class +' next-step" id="'+ val.id +'" >'+ val.text +'</button>';
                    } else if ( val.action == 'close' ) {
                        out += '<button type="button" '+ float +' class="'+ val.class +' close-modal" id="'+ val.id +'" >'+ val.text +'</button>';
                    } else if ( val.action == 'link' ) {
                        out += '<a href="'+ val.href +'" '+ float +' class="'+ val.class +'" id="'+ val.id +'" target="'+ val.target +'">'+ val.text +'</a>';
                    }
                });

                return out;
            },
            getStepsHTML: function(data) {
                var steps_output = '<ul>';

                $.each(data, function( index, item ) {
                    if ( item.id !== 'final' ) {
                        steps_output += '<li id="'+ item.id +'" class="step-item '+ item.std +'" data-goto="'+ index +'"><span class="step-number">'+ item.title +'</span><span class="description">'+ item.description +'</span></li>';
                    }
                });

                steps_output += '</ul>';

                return steps_output;
            }
        },
        runAjax: function (thumbs) {
            var first = _.first(thumbs);

            $.ajax({
                    type: "post",
                    dataType: "json",
                    url: ajaxurl,
                    data: {
                        action: 'zoom_regenerate_thumbnails',
                        'thumb_id': first,
                        'nonce_regenerate_thumbnail': zoomData.nonce_regenerate_thumbnail
                    }
                }
            ).retry({times: 5, statusCodes: [503, 504, 500, 502]}).done(function () {
                // on done
            }).fail(function () {
                // on fail
            }).always(function (data, textStatus, jqxhr) {

                if (textStatus === 'error') {
                    themeSetup.popup.openWarningModal({data: {message: jqxhr}});
                    return;
                }

                if (data.data.halt) {
                    themeSetup.popup.openWarningModal(data);
                    return;
                }

                data._thumbsLength = thumbs.length;
                themeSetup.updateItems(themeSetup.popup.getPopupItem(data));

                if (thumbs.length > 1) {
                    themeSetup.runAjax(_.rest(thumbs));
                } else {
                    _.delay(function () {
                        themeSetup.isDone(1);
                    }, 1000);
                }
            })
        },
        reinit: function() {
            // Reinit variables
            _options = {
                "steps_status": {},
                "config_menu": {},
                "front_page": {}
            };

            modal_items = [];
        },
        changeTabTitle: function( text ) {
            $('head title', window.parent.document).text( text );
        },
        updateStepStatus: function(index, status) {
            status = status || '';

            if ( index !== '' && status !== '' ) {
                if ( _options['steps_status'][index] !== 'done' ) {
                    _options['steps_status'][index] = status;
                }
            }

            if ( _.keys(_options['steps_status']).length ) {

                _.delay(function() {
                    $.each(_options['steps_status'], function(key, val) {

                        B.find('[data-goto="'+ key +'"]').attr('class', 'step-item ' + val);

                        if ( val == 'done' ) {
                            B.find('[data-goto="'+ key +'"]').find('.step-number').html('<i class="fa fa-check"></i>');
                        }

                    });
                });

            }
        },
        updateItems: function(items) {
            themeSetup.popup.instance.items = items;
            themeSetup.popup.instance.updateItemHTML();
        },
        parseContent: function(data) {

            _options['data'] = data; // Store current instance data in global variable

            var content = data.content,
                index = data.index;

            content.find('select[name^="wpz_menu"]').each(function(){
                var element = $(this),
                    menu_location = $(this).attr('data-location'),
                    menu_id = _options['config_menu'][menu_location];

                if ( typeof menu_id != 'undefined' ) {
                    element.find('option').prop('selected', false); // Deselect all options
                    element.find('option[value="'+ menu_id +'"]').prop('selected', true); // Make selected option that we have changed
                }
            });

            content.find('input[name="show_on_front"]').each(function(){
                var element = $(this),
                    value = _options['front_page']['show_on_front'];

                if ( typeof value != 'undefined' ) {
                    element.prop('checked', false);

                    if ( element.val() == value ) {
                        element.prop('checked', true);
                    }

                    if ( value == 'page' ) {
                        content.find('#page_on_front, #page_for_posts').prop('disabled', false);
                    } else {
                        content.find('#page_on_front, #page_for_posts').prop('disabled', true);
                    }
                }
            });

            content.find('select[name="page_on_front"], select[name="page_for_posts"]').each(function(){
                var element = $(this),
                    name_attr = element.attr('name'),
                    page_id = _options['front_page'][name_attr];

                if ( typeof page_id != 'undefined' ) {
                    element.find('option').prop('selected', false); // Deselect all options
                    element.find('option[value="'+ page_id +'"]').prop('selected', true); // Make selected option that we have changed
                }
            });

            if ( typeof _options['steps_status'][index] !== 'undefined' && _options['steps_status'][index] == 'done' ) {
                _.delay(function(){
                    content.find('.popup-modal-message').addClass('done');
                }, 50);
            }

            _.delay(function(){
                themeSetup.advancedSettingsUpdateValues();
            }, 50);
        },
        isDone: function(index, next) {
            next = next || false;

            themeSetup.updateStepStatus(index, 'done');

            // Change item content when is done
            // Check for is_done index
            if ( "is_done" in zoomData.steps[index] ) {
                modal_items[index]['src'] = themeSetup.popup.getPopupHtml({
                        header: (typeof zoomData.steps[index]['is_done'].header !== 'undefined' ? zoomData.steps[index]['is_done'].header : ''),
                        step_id: index,
                        content: zoomData.steps[index]['is_done'].content,
                        controls: themeSetup.popup.getControls(zoomData.steps[index]['is_done'].controls)
                    }
                );
            }

            themeSetup.updateItems(modal_items);
            themeSetup.popup.instance.goTo(index);

            _.delay(function(){
                _options['data'].content.find('.popup-modal-message').addClass('done');
            }, 50);

            // Go to next step
            if ( next ) {
                themeSetup.popup.instance.goTo(parseInt(index)+1);
            }
        },
        isComplete: function() {
            // Set value 'done' for completed theme setup for specific demo
            $.ajax({
                type: "post",
                dataType: "json",
                url: ajaxurl,
                data: {
                    action: 'zoom_set_demo_theme_setup_complete',
                    advanced_settings: _options['advanced_settings'],
                    'nonce_set_demo_theme_setup_complete': zoomData.nonce_set_demo_theme_setup_complete
                }
            }).done(function(response){
                _options['isComplete'] = true;
            });

            // Don't show leave alert
            W.off('beforeunload', themeSetup.beforeUnloadCallback);
        },
        advancedSettingsUpdateValues: function() {

            // Append advanced settings modal
            if ( ! D.find('#advanced-settings-popup').length ) {
                D.find('.white-popup-content').append(zoomData.advanced_settings.content);
            }

            $.each(settings_fields, function(index, field){
                var element = D.find('[name="'+ field +'"]'),
                    field_type = element.attr('type');

                if ( !element.length ) {
                    return;
                }

                if ( typeof _options['advanced_settings'][field] === 'undefined' ) {
                    _options['advanced_settings'][field] = element.is(':checked') ? true : false;
                }

                D.on('change', '[name="'+ field +'"]', function(){
                    if ( field_type == 'checkbox' || field_type == 'radio' ) {
                        _options['advanced_settings'][field] = element.is(':checked') ? true : false;
                    }
                });

                // For field type [checkbox] or [radio]
                if ( field_type == 'checkbox' || field_type == 'radio' ) {
                    element.prop('checked', _options['advanced_settings'][field]);
                }
            });
        }
    };

    D.ready(function () {

        $('#misc_load_demo_content').on('click', function () {
            W.on('beforeunload', themeSetup.beforeUnloadCallback);
        });


        /**
         * Demo Content is complete imported
         */
        B.on('wpzoom:load_demo_content:done', function () {

            D.find('.wp-pointer').hide();

            themeSetup.popup.openOnce({data: {message: zoomData.strings.starting_message}});

            // Reinit
            themeSetup.reinit();

            // Change browser tab title
            themeSetup.changeTabTitle( zoomData.strings.demo_imported_success );

            $.ajax({
                type: "post",
                dataType: "json",
                url: ajaxurl,
                data: {
                    action: 'zoom_set_setup_options',
                    'nonce_set_setup_options': zoomData.nonce_set_setup_options,
                    'imported_demo': demoImporter.options['imported_demo'],
                }
            }).done(function (response) {

                var data = response.data;

                if ( "setup_is_complete" in data ) {
                    themeSetup.popup.instance.close();
                    themeSetup.popup.instance.open({
                        items: {
                            'src': themeSetup.popup.getPopupHtml({
                                header_steps: false,
                                content: data.content,
                            }),
                            'type': 'inline',
                            'closeBtnInside': true,
                        },
                        callbacks: {
                            beforeClose: function() {
                                W.off('beforeunload', themeSetup.beforeUnloadCallback);
                            },
                            close: function() {
                                location.reload();
                            }
                        }
                    });

                    _.delay(function(){
                        themeSetup.popup.instance.content.find('.popup-modal-message').addClass('done');
                    }, 50);

                    return;
                }

                // Push response data into global variable
                zoomData.steps = data.steps;
                zoomData.advanced_settings = data.advanced_settings;

                _options['steps'] = data.steps;
                _options['advanced_settings'] = data.advanced_settings;

                // Prepare items for modal
                $.each(zoomData.steps, function(index, step) {
                    obj_item = {};

                    obj_item = {
                        'src': themeSetup.popup.getPopupHtml({
                            header: ("header" in step ? step.header : ''),
                            step_id: step.id,
                            content: step.content,
                            controls: themeSetup.popup.getControls(step.controls)
                        }),
                        'type': 'inline',
                    }

                    modal_items.push(obj_item);
                });

                themeSetup.popup.instance.close();

                themeSetup.popup.instance.open({
                    items: modal_items,
                    modal: true,
                    callbacks: {
                        change: function() {
                            // We need to parse content because each time we change the step
                            // Popup change the instance and the content returns to original
                            themeSetup.parseContent(this);
                        },
                        elementParse: function(item) {
                            themeSetup.updateStepStatus(item.index, 'current');
                        },
                        updateStatus: function(data) {
                            themeSetup.updateStepStatus();
                        },
                    }
                }, 0);

                // First step is Done
                themeSetup.isDone(themeSetup.popup.instance.index);

                // ADVANCED SETTINGS
                D.on('click', '#zoom-advanced-settings', function(){
                    var container = D.find('#advanced-settings-popup');

                    themeSetup.advancedSettingsUpdateValues();

                    container.slideToggle();
                });

            }).fail(function() {
            
            }).always(function (data, textStatus, jqxhr) {

                if ( textStatus === 'error' ) {
                    themeSetup.popup.openWarningModal({data: {message: jqxhr}});
                    return;
                }

            });

            // Custom Actions
            D.on('click', '[id^="zoom-skip-step"]', function(e) {
                themeSetup.updateStepStatus(themeSetup.popup.instance.index, 'skipped');
                themeSetup.popup.instance.goTo(parseInt(themeSetup.popup.instance.index)+1);

                _.delay(function(){
                    themeSetup.popup.instance.content.find('.popup-modal-message').addClass('done');
                }, 50);
            });

            D.on('click', '[data-goto]', function(e) {
                var index = $(this).attr('data-goto');
                themeSetup.popup.instance.goTo(index);
            });


            // Regenerate Thumbnails
            D.on('click', '#zoom-show-regenerate-thumbnails', function (e) {
                themeSetup.isDone(themeSetup.popup.instance.index, true);
            });

            D.on('click', '#zoom-regenerate-thumbnails', function (e) {
                themeSetup.popup.openOnce({data: {message: zoomData.strings.starting_message}});

                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: ajaxurl,
                    data: {
                        action: 'zoom_get_thumbnails',
                        advanced_settings: _options['advanced_settings'],
                        'nonce_get_thumbnails': zoomData.nonce_get_thumbnails
                    }
                }).done(function (response) {
                    zoomData.thumbs = response.data.thumbs;
                    themeSetup.runAjax(zoomData.thumbs);
                });
            });

            D.on('click', '#zoom-regenerate-thumbnails-done', function(e) {
                themeSetup.isDone(themeSetup.popup.instance.index, true);
            });


            // Load Default Widgets
            D.on('click', '#zoom-load-widgets', function(e) {
                themeSetup.popup.openOnce({data: {message: zoomData.strings.starting_message}});
                
                _.delay(
                    function () {
                        $.ajax({
                                type: "post",
                                dataType: "json",
                                url: ajaxurl,
                                data: {
                                    action: 'wpzoom_widgets_default',
                                    '_ajax_nonce': zoomData.nonce_widgets_default
                                }
                            }
                        ).done(function (response) {
                            var index = _options['current'];
                            themeSetup.isDone(index);
                        }).fail(function (response, status) {
                            themeSetup.popup.openWarningModal({data: {message: status}});
                        });
                    }, 500
                );
            });

            D.on('click', '#zoom-load-widgets-done', function(e) {
                themeSetup.isDone(themeSetup.popup.instance.index, true);
            });


            // Configure Menus
            D.on('click', '#zoom-configure-menus', function (e) {
                e.preventDefault();

                themeSetup.popup.openOnce({data: {message: zoomData.strings.starting_message}});

                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: ajaxurl,
                    data: {
                        action: 'wpzoom_update_nav_menu_location',
                        'settings': _options['config_menu'],
                        '_ajax_nonce': zoomData.nonce_update_nav_menu_location
                    }
                }).done(function (response) {
                    var index = _options['current'];
                    themeSetup.isDone(index, true);
                });
            });

            D.on('change', 'select[name^="wpz_menu"]', function(){
                var menu_location = $(this).attr('data-location'),
                    menu_id = $(this).find('option:selected').val();

                _options['config_menu'][menu_location] = menu_id;
            });

            // Complete Setup
            D.on('click', '#zoom-complete-setup', function () {

                _options['front_page']['show_on_front'] = D.find('input[name="show_on_front"]:checked').val();

                themeSetup.popup.openOnce({data: {message: zoomData.strings.starting_message}});

                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: ajaxurl,
                    data: {
                        action: 'zoom_set_front_page_option',
                        'data': _options['front_page'],
                        'nonce_set_front_page_option': zoomData.nonce_set_front_page_option
                    }
                }).done(function () {
                    themeSetup.isDone(_options['current'], true);

                    W.off('beforeunload', themeSetup.beforeUnloadCallback);

                });

            });

            D.on('change', 'input[name="show_on_front"]', function() {
                var value = $(this).val();

                _options['front_page']['show_on_front'] = value;

                if ( value == 'page' ) {
                    $('#page_on_front, #page_for_posts').prop('disabled', false);
                } else {
                    $('#page_on_front, #page_for_posts').prop('disabled', true);
                }

            });

            D.on('change', 'select[name="page_on_front"]', function() {
                var value = $(this).find('option:selected').val();
                _options['front_page']['page_on_front'] = value;
            });

            D.on('change', 'select[name="page_for_posts"]', function() {
                var value = $(this).find('option:selected').val();
                _options['front_page']['page_for_posts'] = value;
            });

            D.on('click', '#zoom-close-popup-modal', function() {
                themeSetup.popup.instance.close();
            });

            D.on('click', '#zoom-close-modal', function() {
                themeSetup.popup.instance.close();

                location.reload();
            });

            D.on('click', '#zoom-close-modal, #zoom-open-customizer, #zoom-view-site', function() {
                if ( typeof _options['isComplete'] === 'undefined' ) {
                    themeSetup.isComplete();
                }
            });

            D.on('click', '#zoom-close-popup-modal', function() {
                themeSetup.popup.instance.close();

                // Don't show leave alert
                W.off('beforeunload', themeSetup.beforeUnloadCallback);

                location.reload();
            });

        });


        /**
         * Demo Content is complete deleted
         */
        B.on('wpzoom:delete_demo_content:done', function () {

            if ( demoImporter.options['off_trigger'] ) {
                return;
            }

            D.find('.wp-pointer').hide();

            themeSetup.popup.openOnce({data: {message: zoomData.strings.starting_message}});

            // Reinit
            themeSetup.reinit();

            themeSetup.popup.instance.close();

            themeSetup.popup.instance.open({
                items: {
                    'src': themeSetup.popup.getPopupHtml({
                        header_steps: false,
                        content: zoomData.strings.delete_demo_content,
                    }),
                    'type': 'inline',
                    'closeBtnInside': true,
                },
                callbacks: {
                    beforeClose: function() {
                        W.off('beforeunload', themeSetup.beforeUnloadCallback);
                    },
                    close: function() {
                        location.reload();
                    }
                }
            });

            _.delay(function(){
                themeSetup.popup.instance.content.find('.popup-modal-message').addClass('done');
            }, 50);

            return;
        });

        window.themeSetup = themeSetup;
        window.themeSetup.options = _options;

    });
})(jQuery, _, zoom_theme_setup);
