const dropzoneOptions = {
    acceptedFiles: 'image/*,video/*,application/*',
    addRemoveLinks: false,
    resizeWidth: 1920,
    uploadMultiple: false,
    maxFiles: 20,
    parallelUploads: 20,
    init: function () {

        this.on("sending", function (file, xhr, formData) {
            // Append the CSRF Token to the request headers
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            xhr.setRequestHeader('X-CSRF-Token', csrfToken);
        });

        if ($('.media-items-receiver').length) {

            this.on("processing", function (file) {
                this.options.url = $(".dropzone-upload-media").attr('action');
            });
        }


        this.on('complete', function () {

            this.removeAllFiles();


            if ($('.media-items-receiver').length) {

                mediaItemsAjax($('.input-search-media').val());

                var counter_element = $('.folder-list-item[data-id="' + $('.dropzone-upload-media').attr('data-folder') + '"]').find('.count_folder_files');
                counter_element.text(parseInt(counter_element.text()) + 1);

            } else {

                var target = $(this.element).data('target');
                var folder = $(this.element).data('folder');

                if (target == 'modal') {
                    var show = 2;
                }
                else {
                    var show = 1;
                    // popupMedia();
                }

                $.ajax({
                    url: '/backend/web/media/index/?show=' + show + '&folder=' + folder,
                    dataType: 'html',
                    success: function (data) {
                        $('#mediaItems').html(data);
                        setupModal(localStorage.getItem('dataFor'));
                    }
                });
            }

        });
    }
}

Dropzone.options.dropzoneFrom = dropzoneOptions;

function searchMedia() {

    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search_media_items");
    filter = input.value.toUpperCase();
    table = document.getElementById("table_media_items");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
            txtValue = td.textContent || td.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}



function mediaItemsAjax(search_keyword) {

    if ($('.media-items-receiver').length == 0) {
        return false;
    }

    var fd = new FormData();

    if (search_keyword != undefined) {

        fd.append('search_keyword', search_keyword);
    }

    if ($('.folder-opened').length) {
        fd.append('folder_id', $('.folder-opened').data('id'));
    }

    $.ajax({
        type: "post",
        url: "/backend/web/media/search",
        data: fd,
        processData: false,
        contentType: false,
        beforeSend: function () {

            $('.media-items-loading').css('display', 'flex');
        },
        success: function (response) {

            $('.media-items-receiver').html(response);
            $('.media-items-loading').hide();
        }
    });
}


$(document).ready(function () {


    $(document).on('change keyup', '.input-search-media', function () {

        var search_keyword = $(this).val();

        if (search_keyword.length >= 2) {

            mediaItemsAjax(search_keyword);
        }
        else {
            mediaItemsAjax();
        }

    });


    mediaItemsAjax();


    $(document).on('click', '.td-media-item-img img', function (e) {

        e.preventDefault();

        $('body').append('<div id="media-item-zoom-box"><div id="media-item-zoom-box-close"></div><img src="' + $(this).attr('src') + '" /></div>');

    });

    $(document).on('click', '#media-item-zoom-box-close', function (e) {

        e.preventDefault();

        $('#media-item-zoom-box').remove();
    });


    $(document).on('keydown', function (e) {

        if (e.which == 27) {
            $('#media-item-zoom-box').remove();
        }

    });


    $(document).on("change", ".input-update-media-attribute", function () {

        var id = $(this).parents('tr').data('key');
        var attribute = $(this).attr('name');
        var value = $(this).val();

        var td = $(this).parents('td');
        var tr = $(this).parents('tr');

        $.ajax({
            type: "post",
            url: "/backend/web/media/update-item-attribute",
            data: {
                id: id,
                attribute: attribute,
                value: value,
            },
            beforeSend: function () {

                td.append('<div class="attribute-loading"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function (response) {

                if (response.status == 'success') {

                    tr.replaceWith(response.html);
                } else {
                    alert(response.message);
                    // window.location.reload();
                }
            }
        });

    });


    $(document).on("click", ".media-folders-box .folder-list-item-link", function (e) {

        if ($(this).attr('data-bs-toggle') != undefined) {
            return false;
        }

        e.preventDefault();
        var item = $(this).parent();

        item.siblings().removeClass('folder-opened');
        item.toggleClass('folder-opened');

        var search_keyword = $('.input-search-media').val();
        if (search_keyword.length >= 2) {

            mediaItemsAjax(search_keyword);
        }
        else {
            mediaItemsAjax();
        }

        $('.dropzone-upload-media').attr('action', '/backend/web/media/add?folder=' + item.data('id')).data('folder', item.data('id')).attr('data-folder', item.data('id'));

        if ($('.folder-opened').length) {
            $('.upload-media-box-wrp').removeClass('prevented');
        } else {
            $('.upload-media-box-wrp').addClass('prevented');
        }


        var items_box = $('.media-items-box');
        if (items_box.length) {

            var scrollpos = items_box.offset().top;
            $('html, body').animate({ scrollTop: scrollpos - 45 }, 500);
        }

    });


    $(document).on('click', '.folder-filter-link', function (e) {

        e.preventDefault();
        var btn = $(this);
        var data_type = btn.attr('href').replace('#', '');

        btn.parent().siblings().removeClass('active');
        btn.parent().addClass('active');

        if (data_type == 'all' || data_type == undefined) {

            $('.folder-list-item').show();
        }
        else {

            $('.folder-list-item').hide();
            $('.folder-list-item[data-type="' + data_type + '"]').show();
        }

    });





    $(document).on('click', '.media-items-box .pagination .page-link', function (e) {

        e.preventDefault();

        // var page = new URLSearchParams($(this).attr('href')).get('page');
        var url = $(this).attr('href');
        var fd = new FormData();

        var search_keyword = $('.input-search-media').val();
        if (search_keyword.length >= 2) {

            fd.append('search_keyword', search_keyword);
        }


        if ($('.folder-opened').length) {
            fd.append('folder_id', $('.folder-opened').data('id'));
        }

        $.ajax({
            type: "post",
            url: url,
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: function () {

                $('.media-items-loading').css('display', 'flex');
            },
            success: function (response) {

                $('.media-items-receiver').html(response);
                $('.media-items-loading').hide();

                var items_box = $('.media-items-box');
                if (items_box.length) {

                    var scrollpos = items_box.offset().top;
                    $('html, body').animate({ scrollTop: scrollpos - 45 }, 500);
                }

            }
        });

    });



    $(document).on('click', '.btn_media_item_more_info', function (e) {

        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            type: "post",
            url: "/backend/web/media/item-more-info",
            data: {
                id: id,
            },

            beforeSend: function () {

                $('.loading').show();
            },
            success: function (response) {

                $('#modalMediaUsedInfo .modal-content').html(response);

                $('.loading').hide();
                $('#modalMediaUsedInfo').modal('show');
            }
        });

    });



    $(document).on('click', '.btn_delete_media_item', function (e) {

        e.preventDefault();

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn bg-gradient-success',
                cancelButton: 'btn bg-gradient-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "The file will be gone forever.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Da, sterge!',
            cancelButtonText: 'Nu, renunt',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var id = $(this).data('id');

                $.ajax({
                    type: "post",
                    url: "/backend/web/media/delete-media-item",
                    data: {
                        id: id,
                    },

                    beforeSend: function () {

                        $('.loading').show();
                    },
                    success: function (response) {

                        $('.loading').hide();

                        if (response.status == 'success') {

                            mediaItemsAjax($('.input-search-media').val());
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }

        });


        return false;

    });



    $(document).on('change', '.change_item_folder', function () {

        var id = $(this).data('id');
        var folder_id = $(this).find(':selected').attr('value');

        $.ajax({
            type: "post",
            url: "/backend/web/media/change-folder-id",
            data: {
                id: id,
                folder_id: folder_id,
            },

            beforeSend: function () {

                $('.loading').show();
            },
            success: function (response) {

                $('.loading').hide();

                if (response.status == 'success') {

                    mediaItemsAjax($('.input-search-media').val());
                } else {
                    alert(response.message);
                }
            }
        });

    });

    // $('#modalMedia').on('hidden.bs.modal', function () {

    //     if ($('#editCategory.modal.show').length) {

    //         $('body').addClass('modal-open').css('padding-right', '17px');
    //     }

    // });



    $(document).on('click', '.btn_create_media_folder_ajax', function (e) {

        e.preventDefault();

        var btn = $(this);
        var form = btn.parents('form');
        var url = form.attr('action');
        var fd = new FormData(form[0]);

        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {

                $('#addFolder').modal('hide');
                $('#modalMedia').modal('show');

                if (response.status === 'success') {

                    $('#modalMedia .modal-content').html(response.html);
                    mediaItemsAjax();

                    // Destroy existing Dropzone instance if it exists
                    if (Dropzone.instances.length > 0) {
                        Dropzone.instances.forEach(dropzone => dropzone.destroy());
                    }

                    // Reinitialize Dropzone with the same options
                    new Dropzone("#dropzoneFrom", dropzoneOptions);
                    

                } else {

                    const swalBasic = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn bg-gradient-danger'
                        }
                    });
                    swalBasic.fire({
                        title: 'Ooops...',
                        text: response.message,
                    });
                }
            }
        });

        return false;

    });


    

    $(document).on('click', '.btn_remove_folder', function (e) {

        e.preventDefault();
        var folder_id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "/backend/web/media/remove-folder",
            data: {
                folder_id: folder_id
            },
            success: function (response) {
                
                if (response.status === 'success') {
                    window.location.reload(true);
                } else {
                    const swalBasic = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn bg-gradient-danger'
                        }
                    });
                    swalBasic.fire({
                        title: 'Ooops...',
                        text: response.message,
                    });
                }
            }
        });
        
    });

    


    $(document).on('click', '.btn_remove_all_files_from_folder', function (e) {

        e.preventDefault();
        var folder_id = $(this).data('id');

        if (folder_id == undefined) {
            return false;
        }

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn bg-gradient-success',
                cancelButton: 'btn bg-gradient-danger'
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "All files from this folder will be gone forever.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete them all!',
            cancelButtonText: 'No, cancel',
            reverseButtons: true

        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "/backend/web/media/remove-all-files-from-folder",
                    data: {
                        folder_id: folder_id
                    },
                    success: function (response) {
                        
                        if (response.status === 'success') {
                            window.location.reload(true);

                        } else {
                            const swalBasic = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn bg-gradient-danger'
                                }
                            });
                            swalBasic.fire({
                                title: 'Ooops...',
                                text: response.message,
                            });
                        }
                    }
                });
            }
        });
        
        return false;
    });

    

    
    $(document).on('show.bs.modal', '#modalMedia', function (e) {

        var trigger = $(e.relatedTarget);
        
        if (trigger.length) {
            
            $(this).data('trigger', trigger.attr('data-trigger'));
            $(this).attr('data-trigger', trigger.attr('data-trigger'));
        }

        
    });



    $(document).on('click', '.copy_url', function () {
        var copyText = $(this).text();

        // Create a temporary input element
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(copyText).select();

        // Copy the text inside the input element
        document.execCommand('copy');

        // Remove the temporary input element
        tempInput.remove();

        // Add the copied class to show feedback
        $(this).addClass('copied');

        // Show alert
        // alert('Copied to clipboard: ' + copyText);

        // Remove the copied class after a delay
        setTimeout(() => {
            $(this).removeClass('copied');
        }, 1000);
    });


    $(document).on('click', '.btn_add_media_item', function (e) {

        e.preventDefault();

        var btn = $(this);
        var modal = btn.parents('#modalMedia');

        if (modal.length == 0 || modal.attr('data-trigger') == undefined) {
            
            const swalBasic = Swal.mixin({
                customClass: {
                    confirmButton: 'btn bg-gradient-danger'
                }
            });
            swalBasic.fire({
                title: 'Ooops...',
                text: 'No trigger detected.',
            });

        } else {

            var tr = btn.closest('tr')
            var media_id = tr.data('key');
            var media_src = tr.data('src');

            var data_trigger = modal.attr('data-trigger');

            


            if (data_trigger === 'page_featured_image') {
                
                var input_ = $('input#page-featured_image')
                
                input_.val(media_id);
                
                input_.closest('.upload-image-box').find('img').attr('src', media_src);
                
                modal.modal('hide');

                

                
            } else if (data_trigger === 'category_featured_image') {
                
                var input_ = $('input#category-media_id')
                
                input_.val(media_id);
                
                input_.closest('.upload-image-box').find('img').attr('src', media_src);
                
                modal.modal('hide');

                

                
            } else if (data_trigger === 'logo') {
                
                var input_ = $('#upload-image-box-logo .input_image')
                
                input_.val(media_id); 
                
                input_.closest('.upload-image-box').find('img').attr('src', media_src);
                
                modal.modal('hide');


                

            } else if (data_trigger === 'logo_b') {
                
                var input_ = $('#upload-image-box-logo-b .input_image')
                
                input_.val(media_id); 
                
                input_.closest('.upload-image-box').find('img').attr('src', media_src);
                
                modal.modal('hide');


                


            } else if (data_trigger === 'favicon') {
                
                var input_ = $('#upload-image-box-favicon .input_image')
                
                input_.val(media_id); 
                
                input_.closest('.upload-image-box').find('img').attr('src', media_src);
                
                modal.modal('hide');
                


                

            } else if (data_trigger.includes('module_image') || data_trigger.includes('row') || data_trigger.includes('column')) {

                var upload_box = $('.upload-image-box [data-trigger="' + data_trigger + '"]').closest('.upload-image-box');

                var input_ = upload_box.find('.input_image');

                input_.val(media_id).attr('value', media_id); 

                upload_box.find('img').attr('src', media_src);

                modal.modal('hide');

                


            } else if (data_trigger.includes('module_fickle_image')) {

                var upload_box = $('.upload-image-box [data-trigger="' + data_trigger + '"]').closest('.upload-image-box');

                var input_ = upload_box.find('.input_image');

                input_.val(media_id).attr('value', media_id); 

                upload_box.find('img').attr('src', media_src);

                modal.modal('hide');

                


            } else if (data_trigger.includes('module_fickle_background_image')) {


                var upload_box = $('.upload-image-box [data-trigger="' + data_trigger + '"]').closest('.upload-image-box');
                var input_ = upload_box.find('.input_image');

                input_.val(media_id).attr('value', media_id); 

                upload_box.find('img').attr('src', media_src);

                modal.modal('hide');

            

            
            } else if (data_trigger.includes('menu_item')) {

                var upload_box = $('.upload-image-box [data-trigger="' + data_trigger + '"]').closest('.upload-image-box');

                upload_box.find('img').attr('src', media_src);

                modal.modal('hide');

                $.ajax({
                    type: "POST",
                    url: "/backend/web/menu/update-attribute",
                    data: {
                        attr: 'media_id',
                        id: upload_box.closest('tr').data('key'),
                        value: media_id
                    },
                    beforeSend: function () {
                        
                        $('.loading').show();
                    },
                    success: function (response) {

                        $('.loading').hide();
                        
                        console.log(response);

                        $.pjax.reload('#pjax-menu-items');

                        if (response.status !== 'success') {
                            alert(response.message);
                        }
                    }
                });

                
            }

        }
        return false;
    });


    
    $(document).on('click', '.btn_remove_uploaded_media_item', function (e) {
        
        e.preventDefault();
        var btn = $(this);
        var box = btn.closest('.upload-image-box');
        var img = box.find('img');

        box.find('.input_image').val('');

        img.attr('src', img.attr('data-no-image-src'));

        btn.remove();

        return false;
    });
});
