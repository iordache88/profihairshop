$(document).ready(function () {
    

    function updateThemeSettings(params) {
        
        let fixed_plugin = $('.fixed-plugin');

        let sidebar_color = fixed_plugin.find('.badge.active').attr('data-color');
        let sidebar_type = fixed_plugin.find('.btn_sidebar_type.active').attr('data-class');

        let navbar_fixed = 0;

        if ($('input#navbarFixed').prop('checked')) {
            navbar_fixed = 1;
        }

        let navbar_minimize = 0;

        if ($('input#navbarMinimize').prop('checked')) {
            navbar_minimize = 1;
        }

        let dark_mode = 0;

        if ($('input#dark-version').prop('checked')) {
            dark_mode = 1;
        }

        $.ajax({
            type: "post",
            url: fixed_plugin.data('url'),
            data: {
                '_csrf-backend': $('[name="csrf-token"]').attr('content'),
                sidebar_color  : sidebar_color,
                sidebar_type   : sidebar_type,
                navbar_fixed   : navbar_fixed,
                navbar_minimize: navbar_minimize,
                dark_mode      : dark_mode,
            },

            success: function (response) {
                

            }
        });
    }


    $(document).on('click', '.fixed-plugin .badge, .btn_sidebar_type', function () {

        updateThemeSettings();
        
    });

    $(document).on('change', 'input#navbarFixed, input#navbarMinimize, input#dark-version', function () {

        updateThemeSettings();
        
    });



    $(document).on('show.bs.modal', '.modal', function (event) {

        var zIndex = 10010 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    
    $(document).on('hidden.bs.modal', '.modal', function (event) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });

    
    $(document).on('click', '[data-bs-toggle="modal-multiple"]', function (e) {
        
        e.preventDefault();
        var btn = $(this);
        var target = btn.attr('data-bs-target');
        $(target).modal('show');

        setTimeout(function () {
            
            $(target).data('trigger', btn.data('trigger')).attr('data-trigger', btn.data('trigger'));

        }, 100);
    });

    

    $(document).on('change', '.update_attribute_ajax', function (e) {

        var input = $(this);
        var url = input.data('url');
        var id = input.data('id');
        var attr = input.data('attr');
        var value = input.val();


        if (input.find(":selected").length) {
            value = input.find(":selected").attr("value");
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                id: id,
                attr: attr,
                value: value,
            },
            success: function (response) {

                if (response.status === 'success') {

                    var success_action = input.attr('data-success-action');

                    if (success_action == undefined || success_action == 'pjax-reload') {


                        var pjax_check = input.parents('[data-pjax-container]');

                        if (pjax_check.length) {

                            var pjax_id = pjax_check.attr('id');

                            $.pjax.reload('#' + pjax_id);
                        }

                        return false;


                    } else if (success_action == 'none') {

                        return false;


                    } else if (success_action == 'alert') {

                        alert(response.message);
                        return false;


                    } else if (success_action == 'reload') {

                        window.location.reload();
                        return false;

                    } else if (success_action == 'alert-reload') {

                        alert(response.message);
                        window.location.reload();
                        return false;

                    } else {

                        return false;
                    }


                } else {
                    if (response.message == undefined) {
                        if (typeof response == 'object') {

                            alert(JSON.stringify(response));
                        } else {

                            alert(response);
                        }
                    } else {

                        alert(response.message);
                    }
                    return false;
                }

                return false;
            }
        });

    });


    $(document).on('change', '.form-check-input[name="category_ids[]"]', function () {

        var input = $(this);

        if (input.prop('checked')) {
            
            var parent_check = $('.form-check-input[name="category_ids[]"][value="' + input.data('parent-id') + '"]');

            if (parent_check.length) {
                parent_check.prop('checked', true).trigger('change');
            }

        } else {

            var sub_check = $('.form-check-input[name="category_ids[]"][data-parent-id="' + input.val() + '"]');

            if (sub_check.length) {
                sub_check.prop('checked', false).trigger('change');
            }
        }
        
    });

    


});