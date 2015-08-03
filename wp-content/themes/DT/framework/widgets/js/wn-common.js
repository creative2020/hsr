/*
  Widget Ninja v1.4
  (c) 2011. Web factory Ltd
*/

// list of binded elements
var active = [];

Array.prototype.has = function(v){
  for (i=0; i < this.length; i++){
    if (this[i] == v) {
      return i;
    }
  }
  return false;
}


function bindTipsy() {
  jQuery('.help').tipsy({gravity: 'se',
                         html: true,
                         trigger: 'manual',
                         opacity: 0.9,
                         title: function() {
                            var tmp_title = jQuery('#wn-help-' + jQuery(this).attr('wn-help')).html();
                            if (!tmp_title) {
                              return 'This object has no help associated with it.';
                            } else {
                              return tmp_title;
                            }
                          }});
  jQuery('.help').click(function() { jQuery('.tipsy').remove(); jQuery(this).tipsy('show'); return false; } );
} // bindTipsy


function updateWidget(target) {
  target = jQuery(target.currentTarget);
  if (jQuery(".widget-content:visible", target).length) {
        bindSortableNoCheck(jQuery('.active_tags', target).attr('id'));
        bindSortableNoCheck(jQuery('.inactive_tags', target).attr('id'));
  }
  bindTipsy();
} // updateWidget


jQuery(document).ready(function($) {
  bindTipsy();

  // bind sortable when widget opens
  jQuery('.widget-liquid-right .widget-action, #wp_inactive_widgets .widget-action').click(function() {
    if (jQuery(this).parents('.widget').find('.widget-content:visible').length == 0) {
      bindSortable(jQuery(this).parents('.widget').find('.widget-content'));
    }
  });

  // live doesn't work properly so re-bind events on drag-drop stop
  jQuery('#available-widgets').bind('dragstop', function(event, ui) {
    jQuery('.widget-liquid-right .widget, #wp_inactive_widgets .widget').ajaxSuccess(function(target) {
      updateWidget(target);
    });
  });

  // bind events after AJAX calls (widget dialog update)
  jQuery('.widget-liquid-right .widget, #wp_inactive_widgets .widget').ajaxSuccess(function(target) {
    updateWidget(target);
  });

  // status selector change
  jQuery('.wn_status').live('change', function(){
    var options_div = jQuery('div.' + jQuery(this).attr('id'));

    if (jQuery(this).val() == '') {
      options_div.hide();
    } else {
      options_div.show();
    }
  });

  // Jquery UI Dialog List elements click
  jQuery('[id^="wn_selectable"] li a').live('click',function(){
    if (jQuery(this).parent('li').hasClass('wn-selected')) {
      // unselect
      jQuery(this).parent('li').removeClass('wn-selected');
    } else {
      // select
      jQuery(this).parent('li').attr('class', 'wn-selected');
    }
    return false;
  });

  // jQuery UI Dialog
  jQuery('[class="dialog"]').dialog({
    height:450,
    modal: true,
    autoOpen: false,
    dialogClass: 'wp-dialog',
    // Add buttons to our dialog
    buttons: [{ text: 'OK', className: 'button-primary',
       'click': function() {
        var obj = jQuery(this);
        var selected = '';
        var old_id = obj.data('params');
        var widget_id = obj.data('widget_id');
        var hook_name = old_id.replace(/\:(.*)/,'');

        // Find which items are selected and save them to condition
        jQuery(this).find('li.wn-selected').each(function(){
          selected += jQuery(this).children('a').attr('id') + ',';
        });
        // Remove last character (comma)
        selected = selected.substring(0, selected.length - 1);
        // If nothing is selected set selected to zero
        if (selected == '') {
          selected = '0';
        }

        // Write selected items to conditions ID attr
        jQuery("ul[id='" + widget_id + "'] li[wnfn='" + old_id + "']").attr('wnfn', hook_name + ":" + selected);

        // Empty dialog contents
        obj.empty();

        serialize_tags('#' + widget_id);

        // Run close action on dialog
        jQuery(this).dialog("close");
      }},
      // close button
      { text: 'Cancel', className: 'button-secondary',
        "click": function() {
        jQuery(this).dialog("close");
      }
      }
    ]
  });

  // ask which id should be attach to certain action/hook
  jQuery("a.promptID").live('click',function(){
    // get dialog name (categories, tags, posts, pages ..)
    var dialog_name = jQuery(this).attr('id');
    // get already selected items
    var params = jQuery(this).parent('li').attr('wnfn');
    // get unique widget id
    var widget_id = jQuery(this).closest('ul').attr('id');

    // show loading box
    jQuery(".dialog_loading_container").show();

    jQuery.post(ajaxurl,
                {'action':'wf_wn_dialog', 'params':params, 'widget_id':widget_id, 'dialog_name':dialog_name},
                function(data) {
                  // Open Dialog
                  jQuery("div.dialog").html(data)
                                      .data({ "params":params, "widget_id":widget_id })
                                      .dialog({ title: jQuery("div.dialog").children('ul').attr('title') })
                                      .dialog("open");
                  // Hide loading box
                  jQuery(".dialog_loading_container").hide();

                });

    return false;
  });

  // Addon: for is_tax
  jQuery('select#wn_taxonomy').live('change', function(){
    var taxonomy_slug = jQuery(this).val();
    var tmp_param = jQuery('input#wf_wn_tmp_params').val();
    jQuery("div#term_list", "div#dialog").html('Loading...');
    jQuery.post(ajaxurl,
                {'action':'wf_wn_get_term_list', 'taxonomy_slug':taxonomy_slug, 'params':tmp_param},
                function(data) {
                  jQuery("div#term_list", "div#dialog").empty().html(data);
                });
    return false;
  });

  // When widget is saved run list serialization
  jQuery("input.widget-control-save").live('click',function(){
    jQuery('.tipsy').hide();

    return true;
  });
}); // ready


function bindSortable(container) {
  container = jQuery(container);
  jQuery("ul.active_tags, ul.inactive_tags", container).each(function(){
        elem_id = jQuery(this).attr('id');
        if (active.has(elem_id) === false) {
          active.push(elem_id);
          jQuery("#" + elem_id).sortable({ connectWith: '.wn_Connected', update: function(event, ui) { serialize_tags(ui.item)}}).disableSelection();
        }
        serialize_tags("#" + elem_id);
  }); // each
}

function bindSortableNoCheck(elem_id) {
  jQuery("#" + elem_id).sortable({ connectWith: '.wn_Connected', update: function(event, ui) { serialize_tags(ui.item)} }).disableSelection();
  serialize_tags("#" + elem_id);
}

function serialize_tags(elem) {
  var main_container = jQuery(elem).parents('.widget');
  var serialized = jQuery("ul.active_tags", main_container).sortable('serialize', {attribute:'wnfn', expression: /(.+):(.+)/});
  jQuery('.serialized_tags', main_container).val(serialized);
} // serialize_tags