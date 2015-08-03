jQuery(document).ready(function($){
    var Advanced_Search_Widget = {
        init: function() {
            var elContainer = $('ul.asw-form-elements'),
            customField = $('#asw-custom-template').html(),
            taxonomy = $('#asw-tax-template').html();
			searchbox = $('#asw-search-template').html();
			head = $('#asw-head-template').html();

            $('.asw-form-elements').sortable({
                handle: '.hndle'
            });

            $('.asw-form-elements').on('click', '.handlediv', this.toggleElement);


			$('.asw-elements').on('click', '#asw-search-add-btn', function(e) {
                e.preventDefault();

                elContainer.append(searchbox).slideDown('slow');
            });
			
			$('.asw-elements').on('click', '#asw-head-add-btn', function(e) {
                e.preventDefault();

                elContainer.append(head).slideDown('slow');
            });

            $('.asw-elements').on('click', '#asw-custom-add-btn', function(e) {
                e.preventDefault();

                elContainer.append(customField).slideDown('slow');
            });

            $('.asw-elements').on('click', '#asw-tax-add-btn', function(e) {
                e.preventDefault();

                elContainer.append(taxonomy).slideDown();
            });

            $('.asw-form-elements').on('click', '.asw-remove-el', function(e){
                e.preventDefault();

                $(this).parents('li').slideUp('slow').remove();
            });

            $('#asw-form').on('submit', this.saveOptions);
            $('#asw-form').on('change', '.asw-custom-type', this.toggleValues);

//            $('#asw-form .asw-custom-type').each(index, el, function(){
//                $(this).change();
//            })
        },
        toggleElement: function (e) {
            e.preventDefault();
            var p = $(this).parents('.postbox');

            p.toggleClass('closed');
        },
        saveOptions: function () {
            var form = $(this),
            data = form.serialize() + '&action=asw_save_options',
            error = false;
            //alert(data);

            form.find('input.required').each(function(index, el){
                var value = $(el).val();

                if(value === '') {
                    $(el).addClass('asw-error');
                    error = true;
                }

                if(value !== '' && $(el).hasClass('asw-error')) {
                    $(el).removeClass('asw-error');
                }
            });

            if(!error) {

                form.find('img.ajax-feedback').css('visibility', 'visible');
                $.post(ajaxurl, data, function(response){
                    var json = $.parseJSON(response);

                    form.find('img.ajax-feedback').css('visibility', 'hidden');
                    if(json) {
                        $('#asw-ajax-response').html(json.nag);
                        $('#asw-preview-content').html(json.form_preview);
                        $('.asw-form-elements').html(json.builder);
                    }
                });
            }

            return false;
        },
        toggleValues: function () {
            var self = $(this),
                value = self.val();

            if(value === 'select') {
                self.parent().next('.show-if-select').slideDown('fast');
            } else {
                self.parent().next('.show-if-select').slideUp('fast');
            }
        }
    };

    Advanced_Search_Widget.init();

});