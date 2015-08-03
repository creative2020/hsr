HJI.Membership.Admin = (function($)
{
    var licenseKeyRegex = /^[A-Z0-9]{4}\-[A-Z0-9]{4}\-[A-Z0-9]{4}(\-[A-Z0-9]{4})?$/;

    var __obj =
    {
        manageSettings: function ()
        {
            var lkey = jQuery('#hji-license-key');

            lkey.bind('change keyup', function (event)
            {
                var value = jQuery.trim(lkey.val());

                var valid = licenseKeyRegex.test(value);
                
                lkey[valid ? 'removeClass' : 'addClass']('hji-input-invalid');

                lkey.next('span')[valid ? 'hide' : 'show']();
                
            }).trigger('change');
        },

        /**
         * Auto-save for newly created widgets in the
         * Widgets admin dashboard
         *
         * To add a widget to autoSave call addAutoSaveWidget
         * trigger on window.load with the base_id of the widget
         *
         * $(window).load(function(){
         *  $(document).trigger('addAutoSaveWidget', 'widget_base_id');
         * });
         *
         * "widget_saved" hook will be triggered when the widget
         * is saved and widget object will be passed to the handler.
         */
        autoSaveWidgets: function()
        {
            var autoSave =
            {
                widgets: [],

                getWidgets: function()
                {
                    return autoSave.widgets;
                },

                addWidget: function(widget)
                {
                    autoSave.widgets.push(widget);
                },

                processWidget: function(infoObj)
                {
                    // Base IDs of widgets to save

                    var widgets = autoSave.getWidgets();

                    var id = $(infoObj.widget).find('input[name="id_base"]').val();

                    if ($.inArray(id, widgets) >= 0)
                    {
                        infoObj.save = true;
                    }
                },

                setAjaxCompleteListener: function()
                {
                    jQuery(document).ajaxComplete(
                        function(event, XMLHttpRequest, ajaxOptions)
                        {
                            if (typeof ajaxOptions.data == 'undefined')
                                return false;

                            // determine which ajax request is this (we're after "save-widget")
                            var request = {}, pairs = ajaxOptions.data.split('&'), i, split, widget;

                            for(i in pairs)
                            {
                                split = pairs[i].split('=');
                                request[decodeURIComponent(split[0])] = decodeURIComponent(split[1]);
                            }

                            // only proceed if this was a widget-save request
                            if(request.action && (request.action === 'save-widget'))
                            {
                                // locate the widget block
                                widget = jQuery('input.widget-id[value="' + request['widget-id'] + '"]').parents('.widget');
                                // trigger manual save, if this was the save request
                                // and if we didn't get the form html response (the wp bug)
                                if(!XMLHttpRequest.responseText)
                                {
                                    // Trigger save only on widgets that indicated they want to be auto-saved

                                    var infoObj = {
                                        widget: widget,
                                        save: false
                                    }

                                    // autoSaveWidget will update infoObj.save if necessary

                                    jQuery(document).trigger('autoSaveWidget', infoObj);

                                    wpWidgets.save(widget, 0, 1, 0);
                                    // we got an response, this could be either our request above,
                                    // or a correct widget-save call, so fire an event on which we can hook our js
                                }
                                else
                                {
                                    jQuery(document).trigger('widget_saved', widget);
                                }
                            }
                        }
                    );
                },

                setup: function()
                {
                    autoSave.setAjaxCompleteListener();

                    $(document).on('addAutoSaveWidget', function(e, widget){
                        autoSave.addWidget(widget);
                        console.log(autoSave.getWidgets());
                    });

                    $(document).on('autoSaveWidget', function(e, infoObj)
                    {
                        return autoSave.processWidget(infoObj);
                    });

                }
            }

            autoSave.setup();
        }
    }
    
    return __obj;
})(jQuery);
