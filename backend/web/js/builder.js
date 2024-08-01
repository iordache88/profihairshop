// initiate on load
initSortable();
initSortable('.sortable-gallery');

// populate modal_magic 
$(document).on('click', '[data-bs-target="#modal_builder"]', function () {
    var modal = $(this);
    var data = modal.data();
    data.target = data.bsTarget;
	data.toggle = data.bsToggle;
    var url = 'modal';
    $(data.target).find('.modal-dialog').html('');

    if (data.view == 'getmodule' || data.view == 'actionmodule' || data.view == 'layout') {
        url = data.view;
    }


    $.ajax({
        type: 'POST',
        url: "/backend/web/builder/" + url,
        dataType: 'html',
        data: data,
        success: function (response) {

            $(data.target).find('.modal-dialog').html(response);
            backgroundType();
            form();
            hideshow();
            initEditor('ckeditor');
            initSortable('.sortable-gallery');
            initSortable('#sortable-options');
        },
        error: function (error) {
            console.log(error);
        }
    });
})


// prevent submit form and get data
function form() {
    $('#modal_builder').find('form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var action = form.attr('action');

        $.ajax({
            type: 'POST',
            url: action,
            dataType: 'html',
            data: form.serialize(),
            success: function (response) {
                $('#magic_builder').html(response);
                $('#modal_builder').modal('hide');
                $('#modal_builder').find('.modal-dialog').html('');
                initSortable();
            }
        });
    })
}

// background type on select
function backgroundType() {
    CustomColorpicker();

    $('.modal').each(function () {
        var modal = $(this);
        var defaultValue = modal.find('select[name=background_type]').val();
        modal.find('.set-' + defaultValue).removeClass('hide');
        modal.find('.input_' + defaultValue).attr('name', 'background_info');

        modal.find('select[name=background_type]').change(function () {
            var value = $(this).val();
            modal.find('.set').addClass('hide');
            modal.find('.set-' + value).removeClass('hide');
            modal.find('.input').attr('name', '');
            modal.find('.input_' + value).attr('name', 'background_info');
        })
    })
}


// initiate ckeditor on custom ID
function initEditor(id) {
    if ($('#' + id).length) {
        // CKEDITOR.replace( id, {}); 
    }
}

// initiate sortable
function initSortable(element = false) {
    if (element.length) {
        if ($(element).length) {
            $(element).sortable({
                update: function (event, ui) { }
            })
        }
    }
    else {
        if ($('#magic_builder .row').length) {
            builderSort('#magic_builder');
        }
        if ($('#magic_builder .col').length) {
            builderSort('#magic_builder .contentRow');
        }
        if ($('#magic_builder .module').length) {
            builderSort('#magic_builder .contentColumn');
        }
    }
}


function builderSort(item) {
    $(item).sortable({
        opacity: 0.8,
        cancel: '.module-action-btn',
        // items: "span:not(.module-action-btn)",
        tolerance: "pointer",
        // connectWith: item,
        // start: function(e, ui) {
        //        // creates a temporary attribute on the element with the old index
        //        $(this).attr('data-previndex', ui.item.index());
        //    },
        update: function (event, ui) {
            var element = $(ui.item[0]);
            var page = element.data('order-page');
            var target = element.data('order-target');
            var order = element.data('order');
            var parents = element.data('order-parents');

            sendSort(target, page, item, parents, order);
        }
    })
}

function sendSort(target, page, item, parents, order) {
    var sort = [];
    if (target == 'row') {
        $('#magic_builder > div').each(function () {
            sort.push($(this).data('order'));
        })
    }
    else if (target == 'col') {
        $('#magic_builder .row-' + parents[0] + ' .contentRow > div').each(function () {
            sort.push($(this).data('order'));
        })
    }
    else if (target == 'module') {
        $('#magic_builder .row-' + parents[0] + ' .contentRow .col-' + parents[1] + ' .contentColumn > div').each(function () {
            sort.push($(this).data('order'));
        })
    }

    $.ajax({
        type: "POST",
        url: "/backend/web/builder/sort",
        data: { target: target, page: page, parents: parents, sort: sort, '_csrf-backend': $('[name="csrf-token"]').attr('content') },
        dataType: "html",
        success: function (data) {
            // console.log(data);
            $('#magic_builder').html(data);
            initSortable();
        }
    })
}

// hide/show elements on change
function hideshow() {
    $('[data-show]').on('change', function () {
        var target = $(this).data('show');
        var item = $(this).val();

        $('.' + target).addClass('hide');
        $('.hs-' + item).removeClass('hide');
    })
}

// generate video thumbnail
$(document).on('click', '[data-video="thumb"]', function () {
    var videoUrl = $('input[name="url"]').val();

    $.ajax({
        type: "POST",
        url: "/backend/web/builder/generatevideothumb",
        data: { videoUrl: videoUrl },
        dataType: "html",
        success: function (data) {
            $('.video_thumb').html(data);
        }
    })
})

// checkbox options
$(document).on('click', '.addOpt', function () {
    var allInputs = $('.options').find('input').length;
    var idInput = allInputs + 1;
    $('.options').append('<p id="opt-' + idInput + '"><span class="handle"><i class="fa fa-arrows"></i></span><input type="text" name="options[]" class="form-control" value="" /><button type="button" data-id="' + idInput + '" class="btn btn-simple btn-link nomargin btn-sm btn-danger delOpt"><i class="fa fa-times"></i></button></p>');
    initSortable('#sortable-options');
})
$(document).on('click', '.delOpt', function () {
    var id = $(this).data('id');
    $('.options').find('#opt-' + id).remove();
    initSortable('#sortable-options');
})


// convert builder form
$('.form-convert-builder').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);
    var action = form.attr('action');

    $.ajax({
        type: 'POST',
        url: action,
        dataType: 'html',
        data: form.serialize(),
        success: function (response) {
            $('#magic_builder').html(response);

            console.log(response);
            initSortable();
        }
    });
})

// MODULE category
$(document).on('change', '.type_of_categories', function () {
    var type = $(this).val();

    $.ajax({
        type: 'POST',
        url: '/backend/web/builder/modulecategory',
        dataType: 'html',
        data: { type: type },
        success: function (response) {
            $('select[name="category"]').html(response);
        }
    });
})
// MODULE category

// MODULE field
$(document).on('change', '.type_of_fields', function () {
    var type = $(this).val();

    $.ajax({
        type: 'POST',
        url: '/backend/web/builder/modulefield',
        dataType: 'html',
        data: { type: type },
        success: function (response) {
            $('select[name="field_id"]').html(response);
        }
    });
})

$(document).on('change', '.field_module_select_field_id', function () {
    var field_id = $(this).val();

    $.ajax({
        type: 'POST',
        url: '/backend/web/builder/modulefield-valueoptions',
        dataType: 'html',
        data: { field_id: field_id },
        success: function (response) {
            $('.value-options-ajax-recipient').html(response);
        }
    });
})
// MODULE field

// CHECK SESSION TIMEOUT
function checkTimeout() {

    if ($('#magic_builder').length) {
        
        var item = $('#magic_builder').data('item');

        if (item != undefined) {
            
            $.ajax({
                type: 'POST',
                url: '/backend/web/builder/checksession',
                dataType: 'html',
                data: { item: item },
                success: function (response) {
                }
            });
        }
    }
}

$(window).on('load', function () {

    if ($('#magic_builder').length) {
        var interval = 60 * 1000;
        setInterval(function () {
            checkTimeout();
        }, interval);
    }
});
// CHECK SESSION TIMEOUT



// REMOVE FICKLE IMAGE
$(document).on("click", '.btn-remove-fickle-image', function (e) {
    e.preventDefault();
    $('.fickle-image-preview').html('');
    $('.fickle-image-input').val('');
});
// REMOVE FICKLE IMAGE



// REMOVE FICKLE BACKGROUND IMAGE
$(document).on("click", '.btn-remove-fickle-background-image', function (e) {
    e.preventDefault();
    $('.fickle-background-image-preview').html('');
    $('.fickle-background-image-input').val('');
});
// REMOVE FICKLE BACKGROUND IMAGE




actionrowform();
changeBackgroundType();
sortableRows();
disableAllLinks();
stickyButton();


function loadBootstrap(event) {
    if (event.name == 'mode' && event.editor.mode == 'source')
        return; // Skip loading jQuery and Bootstrap when switching to source mode.

    var jQueryScriptTag = document.createElement('script');
    var bootstrapScriptTag = document.createElement('script');

    jQueryScriptTag.src = 'https://code.jquery.com/jquery-1.11.3.min.js';
    bootstrapScriptTag.src = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js';

    var editorHead = event.editor.document.$.head;

    editorHead.appendChild(jQueryScriptTag);
    jQueryScriptTag.onload = function () {
        editorHead.appendChild(bootstrapScriptTag);
    };
}

var i = 1;
$('button[data-action]').on('click', function(){

    if ($(this).data('action') == 'addrow') {
        $('#builder_wrapper').append(
            '<div class="row" id="row' + i++ + '"><div class="panel panel-default"><div class="panel-body text-center"><button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addcolumn"><i class="fas fa-plus"></i></button></div></div></div>'
        );
    }

    if ($(this).data('action') == 'addlayout') {
        var layoutID = $(this).data('layout');
        var pageID = $('#layout_content, #magic_builder').data('item');

        $.ajax({
            type: 'POST',
            url: "/backend/web/index.php?r=site%2Fselectlayout&id=" + layoutID + '&page=' + pageID,
            dataType: 'html',
            success: function (data) {
                $('#magic_builder').html(data);
                $('#magic_builder').removeClass('row');
                $('#magic_builder').addClass('builder');
                $('#addlayout').modal('hide');
                actionupdateform();
            }
        });
    }

})

function disableAllLinks() {
    $("#layout_content a").click(function (e) {
        e.preventDefault();
    });
}

function changeBackgroundType() {
    $('.modal').each(function () {
        var modal = $(this);
        var defaultValue = modal.find('select[name=background_type]').val();
        modal.find('.set-' + defaultValue).removeClass('hide');
        modal.find('.input_' + defaultValue).attr('name', 'background_info');

        modal.find('select[name=background_type]').change(function () {
            var value = $(this).val();
            modal.find('.set').addClass('hide');
            modal.find('.set-' + value).removeClass('hide');
            modal.find('.input').attr('name', '');
            modal.find('.input_' + value).attr('name', 'background_info');
        })
    })

}

function actionupdateform() {
    jscolor.installByClassName("jscolor");
    changeBackgroundType();

    // $('.btn-submit').on('click', function(){
    // 	var form = $(this).data('form');

    // 	$('#form-'+form).submit();
    // })

    $(".updatelayoutform").on('submit', function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                $('#layout_content').html(data);
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                actionupdateform();
                disableAllLinks();
            }
        });
    });
}


// ---- LAYOUT GENERATOR ---- //
function actioncolumnform() {
    jscolor.installByClassName("jscolor");
    changeBackgroundType();

    $('.btn-submit-column').on('click', function () {
        var form = $(this).data('form');

        $('#form-' + form).submit();
    })

    var pageID = $('#layout_content').data('item');

    $('.actioncolumn').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url + '&page=' + pageID,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                $('#layout_content').html(data);
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                // actioncolumnform();
                disableAllLinks();
                sortableRows();
            }
        });
    })
}

function actionrowform() {
    $('.btn-submit').on('click', function () {
        var form = $(this).data('form');
        $('.' + form).submit();
    })

    // jscolor.installByClassName("jscolor");
    changeBackgroundType();

    var pageID = $('#layout_content').data('item');

    $('.actionrow').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url + '&page=' + pageID,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                $('#layout_content').html(data);
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                disableAllLinks();
                sortableRows();
            }
        });
    })
}

function actioneditrowform() {
    $('.btn-submit-edit').on('click', function () {
        var form = $(this).data('form');
        $('.' + form).submit();
    })

    var pageID = $('#layout_content').data('item');

    $('.actioneditrow').on('submit', function (e) {
        e.preventDefault();

        // console.log('update');
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url + '&page=' + pageID,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                $('#layout_content').html(data);
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                disableAllLinks();
                sortableRows();
            }
        });
    })
}

function actiondelrow(item) {
    var pageID = $('#layout_content').data('item');

    $.ajax({
        type: "POST",
        url: "/backend/web/index.php?r=site%2Faddlayoutelement&type=delrow&item=" + item + '&page=' + pageID,
        data: "HTML", // serializes the form's elements.
        success: function (data) {
            $('#layout_content').html(data);
            disableAllLinks();
            sortableRows();
        }
    });
}

function actiondelcol(row, col) {
    var pageID = $('#layout_content').data('item');

    $.ajax({
        type: "POST",
        url: "/backend/web/index.php?r=site%2Faddlayoutelement&type=delcol&item=" + row + "&col=" + col + '&page=' + pageID,
        data: "HTML", // serializes the form's elements.
        success: function (data) {
            $('#layout_content').html(data);
            $('.modal').modal('hide');
            $('.modal-backdrop').remove();
            disableAllLinks();
            sortableRows();
        }
    });
}

// ---- END LAYOUT GENERATOR ---- //


// ---- SHOW MODAL CONTENT ---- //
function showmodal(type, row, col = null) {
    var pageID = $('#layout_content').data('item');

    $.ajax({
        type: "POST",
        url: '/backend/web/index.php?r=site%2Fmodalcontent&type=' + type + '&row=' + row + '&col=' + col + '&page=' + pageID,
        data: 'HTML', // serializes the form's elements.
        success: function (data) {
            $('#modalLayout .modal-content').html(data);

            if (type == '_edit_row' || type == '_edit_column') {
                actioneditrowform();
            }
            if (type == '_add_column') {
                actioncolumnform();
            }

            if (type == '_add_column' || type == '_edit_column') {
                if (col == null) {
                    col = '';
                }

                CKEDITOR.replace('content' + row + col, {
                    // toolbar : 'Basic', /* this does the magic */
                    height: '200px',
                    extraPlugins: 'bootstrapTabs, collapsibleItem, showmore, btgrid, accordionList',
                    extraAllowedContent: 'div span',
                    contentsCss: ['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'],
                    on: {
                        instanceReady: loadBootstrap,
                        mode: loadBootstrap
                    }
                });
                CKEDITOR.config.allowedContent = true;
            }

            changeBackgroundType();
            CustomColorpicker();
        }
    });
}
// ---- END SHOW MODAL CONTENT ---- //



function setupModal(item) {
    localStorage.setItem('dataFor', item);
    
}

// CKEDITOR.on('instanceReady', function () {
//     $.each(CKEDITOR.instances, function (instance) {

//         $('#cke_3157_textInput').on('click', function () {
//             console.log('click');
//         })

//         CKEDITOR.instances[instance].on('change', function (e) {
//             console.log('change');
//             for (instance in CKEDITOR.instances)
//                 CKEDITOR.instances[instance].updateElement();
//         });
//         $('button[type="submit"]').on('click', function (e) {
//             for (instance in CKEDITOR.instances)
//                 CKEDITOR.instances[instance].updateElement();
//         })
//         $('.actioneditrow').find('.btn-submit-edit').on('click', function (e) {
//             for (instance in CKEDITOR.instances)
//                 CKEDITOR.instances[instance].updateElement();
//         })
//     });

//     CKEDITOR.on('dialogDefinition', function (evt) {
//         var dialog = evt.data;
//         if (dialog.name == 'image') {
//             // Get dialog we want
//             var def = evt.data.definition;

//             //Get The Desired Tab Element
//             var infoTab = def.getContents('info');

//             //Add Our Button
//             infoTab.add({
//                 type: 'button',
//                 id: 'buttonId',
//                 label: 'Select image',
//                 title: 'Select Image',
//                 onClick: function () {

//                     $('.cke_dialog_page_contents').each(function () {
//                         $(this).find('table tbody tr').each(function (e) {
//                             if (e == 0) {
//                                 if ($(this).find('.cke_dialog_ui_labeled_label').text() == 'URL') {
//                                     var elementClass = $(this).find('td').first().attr('class');
//                                     setupModal(elementClass);
//                                     var input = $(this).find('input');
//                                     $(input).attr('name', 'background_info');
//                                 }
//                             }
//                             else if (e == 3) {
//                                 if ($(this).find('.cke_dialog_ui_labeled_label').text() == 'Alternative Text') {
//                                     var input = $(this).find('input');
//                                     $(input).attr('name', 'alt_title');
//                                 }

//                                 var label = $(this).find('.cke_dialog_ui_labeled_label');
//                                 label.each(function () {
//                                     if ($(this).text() == 'Advisory Title') {
//                                         var inputID = $(this).attr('for');
//                                         $('#' + inputID).attr('name', 'media_title');
//                                     }
//                                 })
//                             }
//                             else if (e == 2) {
//                                 if ($(this).find('.cke_dialog_ui_labeled_label').text() == 'Long Description URL') {
//                                     var input = $(this).find('input');
//                                     $(input).attr('name', 'media_description');
//                                 }
//                             }
//                             // 	console.log(e + ' = ' + $(this).find('.cke_dialog_ui_labeled_label').text());
//                         })
//                     })

//                     $('#modalMedia').modal('show');
//                 }
//             });
//         }
//     });
// })


function sortableRows() {
    var firstNoRow = $('#layout_content > .row:first-child').data('order');
    var firstNoCol = $('#layout_content > .row .contentRow > div:first-child').data('order');
    // $(document).ready(function(){
    // 	// ---- SORTABLE ROWS ---- //
    // 	$('#layout_content').sortable({
    // 		tolerance: "pointer",
    // 		opacity: 0.5,
    // 		update: function(event, ui)
    // 		{
    // 			$('#layout_content').addClass('disabled');
    // 			var allRows = $('#layout_content > .row').length - 1;
    // 			$('#layout_content > .row').each(function(e, element){
    // 				var target = $('#layout_content').data('target'),
    // 					item = $('#layout_content').data('item'),
    // 					oldOrder = $(this).data('order');
    // 					e = e + firstNoRow;


    // 				$.ajax({
    // 					type: "POST",
    // 					url: "/backend/web/index.php?r=site%2Fsortlayout&id="+item+"&target="+target+'&order='+e+'&oldorder='+oldOrder,
    // 					data: "HTML", // serializes the form's elements.
    // 					success: function(data)
    // 					{
    // 						if(e == allRows)
    // 						{
    // 							// console.log(data);
    // 							// $('#layout_content').html(data);
    // 							$('#layout_content').removeClass('disabled');
    // 						}

    // 					}
    // 				})
    // 			})
    // 		}
    // 	})
    // 	// ---- END SORTABLE ROWS ---- //


    // ---- SORTABLE COLUMNS ---- //
    // $('.contentRow').sortable({
    // 	opacity: 0.8,
    // 	tolerance: "pointer",
    // 	update: function(event, ui)
    // 	{

    // 		$('#layout_content').addClass('disabled');
    // 		var allRows = $('#layout_content > .row').length;
    // 		$('#layout_content > .row').each(function(row){	
    // 			row = row + firstNoRow;
    // 			$(this).find('.contentRow > div').each(function(e, element){
    // 				var target = 'col',
    // 					item = $('#layout_content').data('item'),
    // 					oldOrder = $(this).data('order');
    // 					e = e + firstNoCol;
    // 					// console.log('row: '+row+' col:'+e+' oldOrder:'+oldOrder);

    // 				$.ajax({
    // 					type: "POST",
    // 					url: "/backend/web/index.php?r=site%2Fsortlayout&id="+item+"&target="+target+'&order='+e+'&oldorder='+oldOrder+'&row='+row,
    // 					data: "HTML", // serializes the form's elements.
    // 					success: function(data)
    // 					{
    // 						if(row == (allRows - 1))
    // 						{
    // 						// console.log(data);
    // 							// $('#layout_content').html(data);
    // 							$('#layout_content').removeClass('disabled');
    // 						}

    // 					}
    // 				})
    // 			})
    // 		})
    // 	}
    // })
    // ---- END SORTABLE COLUMNS ---- //
    // })
}

// ---- SAVE TO LIBRARY ---- //
function savetolibrary(item, type, action) {
    var pageID = $('#layout_content, #magic_builder').data('item');

    $.ajax({
        type: "POST",
        url: "/backend/web/builder/savetolibrary?item=" + item + "&type=" + type + "&action=" + action + '&page=' + pageID + '&_csrf-backend=' + $('[name="csrf-token"]').attr('content'),
        data: "HTML", // serializes the form's elements.
        success: function (data) {
            $('#modalLayout .modal-content').html(data);
            conditions();
            savetolibraryform();
        }
    })
}

function savetolibraryform() {
    $('form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var elementTitle = form.find('input[name=elementTitle]').val();
        var pageID = $('#layout_content, #magic_builder').data('item');

        $.ajax({
            type: "POST",
            url: url + '&page=' + pageID + '&elementTitle=' + elementTitle + '&_csrf-backend=' + $('[name="csrf-token"]').attr('content'),
            data: "HTML", // serializes the form's elements.
            success: function (data) {
                $('#modalLayout .modal-content').html(data);
                conditions();
                setTimeout(function () {
                    $('.modal').modal('hide');
                    $('.modal-backdrop').remove();
                }, 3000);
            }
        })
    })
}
// ---- END SAVE TO LIBRARY ---- //


// ---- STICKY BUTTON UPDATE ---- //
function stickyButton() {
    if ($('#rightSide').length) {
        var elementPosition = $('#rightSide').offset().top + $('#rightSide > #accordion').outerHeight() + $('#rightSide .sticky').outerHeight();
        $('.main-panel').scroll(function () {
            var scrollPosition = $(this).scrollTop();
            if (elementPosition < scrollPosition) {
                $('.sticky').addClass('fixed');
            }
            else {
                $('.sticky').removeClass('fixed');
            }
        })
    }
}
// ---- STICKY BUTTON UPDATE ---- //


if ($('#basicEditor').length) {
    CKEDITOR.replace('basicEditor', {
        // toolbar : 'Basic', /* this does the magic */
        // toolbar: [
        // 	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CreateDiv' ] },
        // 	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', '-', 'Link', 'Unlink', 'Anchor', 'Image', 'SpecialChar' ] },
        // 	// { name: 'links', items: [  ] }
        // ],
        extraAllowedContent: 'div span',
        contentsCss: ['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'],
        on: {
            instanceReady: loadBootstrap,
            mode: loadBootstrap
        }
    });
}

if ($('#postEditor').length) {
    CKEDITOR.replace('postEditor', {
        // toolbar : 'Basic', /* this does the magic */
        toolbar: [
            { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Bold', 'Italic', 'Underline', '-', 'TextColor', 'Strike', 'Subscript', 'Superscript', '-', 'CreateDiv'] },
            { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
            { name: 'links', items: ['Source', '-'] },
        ],
        height: '350px',
        extraAllowedContent: 'div span',
        contentsCss: ['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'],
        on: {
            instanceReady: loadBootstrap,
            mode: loadBootstrap
        }
    });
}


// ---- HISTORY ---- //
function layoutHistory(id) {
    $.ajax({
        type: "POST",
        url: '/backend/web/index.php?r=site%2Fhistory&id=' + id + '&type=show' + '&_csrf-backend=' + $('[name="csrf-token"]').attr('content'),
        data: "HTML", // serializes the form's elements.
        success: function (data) {
            $('#historyModal .modal-content').html(data);
            formRestoreHistory();
        }
    })
}

function formRestoreHistory() {
    $('.restoreHistory').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: "HTML", // serializes the form's elements.
            success: function (data) {

                $('#layout_content').html(data);
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                disableAllLinks();
                sortableRows();
            }
        })
    })
}
// ---- HISTORY ---- //



popupMedia();
CustomColorpicker();
showHideMenu();
sortableMenu();
conditions();


// SIDEBAR WIDTH
$(window).on('load', function () {
    var logoHeight = $('.logo').outerHeight();
    $('.sidebar .sidebar-wrapper').css({ 'height': 'calc(100vh - ' + logoHeight + 'px' });
})
// SIDEBAR WIDTH


$(document).ready(function () {
    $('[data-bs-toggle="tooltip"]').tooltip()
})

/*--- CONDITIONS ALERT ---*/
function conditions() {
    $('form').each(function () {
        $(this).on('submit', function (e) {
            $(this).find('.required').each(function (element) {
                var item = $(this).find('input, select').val();
                if (item == null || item == '') {
                    e.preventDefault();
                    $(this).addClass('has-error');
                    if (!$(this).find('.error').length) {
                        $(this).find('label').append('<span class="text-danger error"> This field is required</span>');
                    }
                }
                else {
                    $(this).find('label .error').remove();
                    $(this).removeClass('has-error');
                }
            })
        })
    })
}
/*--- CONDITIONS ALERT ---*/

/*--- PAGE ---*/
$(document).ready(function () {
    $("input[name=slugPage]").on('blur', function () {
        var newSlug = $(this).val(),
            pageID = $('input[name="idPage"]').val(),
            target = $(this).data('target');

        if (target != page) {
            target = 'page';
        }

        $.ajax({
            type: 'POST',
            url: "/backend/web/index.php?r=" + target + "%2Fupdateslugpage&id=" + pageID + "&newslug=" + newSlug,
            dataType: 'html',
            success: function (data) {
                $('input[name=slugPage]').val(data);
            }
        });
    })
})
/*--- END PAGE ---*/



/*--- MENU ---*/
function showHideMenu() {
    $('.show-hide').each(function () {
        $(this).on('change', function () {
            var target = '.' + $(this).data('target');
            var element = '#element-' + $(this).find(':selected').data('item');
            $(target).addClass('hide');
            $(element).removeClass('hide');

            if ($(this).find(':selected').data('item') == 'page') {
                $('#element-page').addClass('required');
            }
            else {
                $('#element-page').removeClass('required');
            }
        })
    })
}

/*----- SORTABLE ----*/
function sortableMenu() {
    $(document).ready(function () {
        $('#sortable-menu').sortable({
            update: function (event, ui) {
                $('#sortable-menu > li').each(function (e) {
                    var item = $(this).data('item'),
                        type = $(this).data('type');
                    $.ajax({
                        type: 'POST',
                        url: "/backend/web/index.php?r=site%2Fsortmenu&order=" + e + "&item=" + item + '&type=' + type,
                        dataType: 'html',
                        success: function (data) {
                        }
                    });
                })
            }
        })

        $('#sortable-menu > li').each(function () {
            var input = $(this).find('input[name=itemLabel]');
            var item = $(this).data('item');

            input.change(function () {
                var value = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: "/backend/web/index.php?r=site%2Fupdatemenu&update=ajax&idItem=" + item + '&title=' + value,
                    dataType: 'html',
                    success: function (data) {

                    }
                });
            })
        })

        $('.sortable-page > tbody').sortable({
            update: function (event, ui) {
                $('.sortable-page > tbody tr').each(function (e) {
                    var target = $(this).data('target'),
                        item = $(this).data('item');
                    $.ajax({
                        type: 'POST',
                        url: "/backend/web/index.php?r=site%2Fsortpage&item=" + item + "&target=" + target + "&order=" + e,
                        dataType: 'html',
                        success: function (data) {
                        }
                    });
                })
            }
        })

        $('#sortable-gallery').sortable({
            update: function (event, ui) {
            }
        })

        $('#sortable-options').sortable({
            handle: ".handle"
            // update: function(event, ui)
            // {
            // }
        })
    })
}
/*----- END SOPRTABLE ----*/

// EDIT ITEM //
function showMenuItem(item) {
    $.ajax({
        type: 'POST',
        url: "/backend/web/index.php?r=site%2Fshowitem&item=" + item,
        dataType: 'html',
        success: function (data) {
            $('#editMenuItem .modal-content').html(data);
            showHideMenu();
            editMenuItem();
            sortableMenu();
        }
    });
}
function editMenuItem() {
    $('#editItemMenu').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var type = $(this).find('select[name=typeElement]').val();
        var pageID = $(this).find('select[name=pageID]').val();
        if (type == 'page' && !pageID.length) {
            $('#editMenuItem #element-pageModal').addClass('has-danger');
            $('#editMenuItem .error').html('<span class="text-danger">Please select a <b>page</b>!</span>');
        }
        else {
            $.ajax({
                type: "POST",
                url: url + '&' + form.serialize(),
                dataType: 'html', // serializes the form's elements.
                success: function (data) {
                    showHideMenu();
                    editMenuItem();
                    sortableMenu();
                    $('.menu-items').html(data);
                    $('.modal').modal('hide');
                    $('.modal-backdrop').remove();
                }
            });
        }
    })
}


/*--- END MENU ---*/



/*--- SYNC MEDIA ---*/
$(document).on('click', '[data-media]', function () {
    let el = $(this);
    let action = el.data('media');

    if (action == 'sync') {
        let folder = el.data('media-folder');
        $.ajax({
            url: '/backend/web/index.php/?r=site%2Fmediasync',
            type: 'POST',
            data: { folder: folder },
            dataType: 'html',
            beforeSend: function () {
                el.find('i').addClass('spinn');
            },
            success: function (data) {
                console.log(data);
            },
            error: function (error) {
                console.log(error.responseText);
            }
        });
    }
})
/*--- SYNC MEDIA ---*/

/*--- POPUP MEDIA ---*/
function popupMedia() {
    $('a.thumb').click(function (event) {
        event.preventDefault();
        var content = $('.modal-body');
        content.empty();
        var title = $(this).attr("title");
        var id = $(this).data('media');

        $('.modal-title').html(title);
        $(".modal-profile").modal({ show: true });

        $.ajax({
            url: '/backend/web/index.php/?r=site%2Fmediaattr&action=show&id=' + id,
            dataType: 'html',
            success: function (data) {
                content.html(data);
            }
        });
    });
}
/*--- END POPUP MEDIA ---*/




/*--- INSERT INPUT ---*/
$('button[data-action=insert]').each(function (e) {
    var item = $(this).data('item');
    $(this).click(function () {
        if (item == 'lang') {
            var idItem = item + e++;
            $('.' + item).append('<div class="' + idItem + '"><input type="text" placeholder="Lang name" style="margin-bottom: 5px;width: 30%;display: -webkit-inline-box; margin-right: 15px" class="form-control" name="' + item + '_name[]" placeholder="" value=""><input type="text" placeholder="Slug url" style="margin-bottom: 5px;width: 30%;display: -webkit-inline-box; margin-right: 15px" class="form-control" name="' + item + '_slug[]" placeholder="" value=""><input type="text" placeholder="Lang code" style="margin-bottom: 5px;width: 30%;display: -webkit-inline-box;" class="form-control" name="' + item + '_code[]" placeholder="" value=""><button type="button" class="btn btn-link btn-danger" onclick="removeItem(\'' + idItem + '\')"><i class="fas fa-times"></i></button></div>');
        }
        else {
            var idItem = item + e++;
            $('.' + item).append('<div class="' + idItem + '"><input type="text" style="margin-bottom: 5px;width: 95%;display: -webkit-inline-box;" class="form-control" name="' + item + '[]" placeholder="" value=""><button type="button" class="btn btn-link btn-danger" onclick="removeItem(\'' + idItem + '\')"><i class="fas fa-times"></i></button></div>');
        }
    })
})
/*--- END INSERT INPUT ---*/


function changeParent(idItem, position) {
    // var idItem = $(this).data('item');
    // var position = $(this).data('position');;

    $.ajax({
        type: 'POST',
        url: "/backend/web/index.php?r=site%2Ffrontpage&idItem=" + idItem + "&position=" + position,
        dataType: 'html',
        success: function (data) {
            $('.menu-items').html(data);
        }
    });
}

// REMOVE ITEM CONTACT DETAILS //
function removeItem(item) {
    jQuery(function ($) {
        $('.' + item).remove();
        $(this).remove();
    })
}
// END REMOVE ITEM CONTACT DETAILS //


// SHOW CONTENT (HIDE/SHOW) //
$('.showContent').change(function () {
    var item = $(this).val();
    $('.showElement').addClass('hide');
    $('.' + item).removeClass('hide');
})
// END SHOW CONTENT (HIDE/SHOW) //

// COLOR PICKER //
function CustomColorpicker() {
    'use strict';
    $(document).ready(function () {

        $('.color-picker').each(function () {

            var input = $(this).find('.color-input');
            var inputID = input.attr('id');
            var inputVal = input.val();
            var valEmpty = inputVal.length;

            if (valEmpty == 0) {
                inputVal = '#000000';
            }

            var anchor = $(this).find('.colorpicker-custom-anchor');
            var colorpickerInsideInputAnchor = $('#dc-ex3-anchor').find('[data-color]');
            var colorPickerDefaultInsideInput = new ColorPicker.Default('#' + inputID, {
                color: inputVal
            });
            colorpickerInsideInputAnchor.css('background', colorPickerDefaultInsideInput.getColor());
            colorPickerDefaultInsideInput.on('change', function (color) {
                colorpickerInsideInputAnchor.css('background', color);
            });
            colorpickerInsideInputAnchor.on('click', function () {
                $('#' + inputID).trigger('focus');

                return false;
            });

            if (valEmpty == 0) {
                input.val('');
            }
        })
    });
}
// COLOR PICKER //


// DATE TIMEPICKER //
// $('.startdate').datetimepicker({
//     format: 'Y-MM-DD'
// });
// $('.enddate').datetimepicker({
//     format: 'Y-MM-DD'
// });
// DATE TIMEPICKER //


// AUTOCOMPLETE //
$(document).ready(function () {
    $('.langAsoc').each(function () {
        $(this).on('click', function () {
            var lang = $(this).data('lang');
            var baseUrl = window.location.href.match(/^.*\//)[0];

            var availableTags = [
                "ActionScript",
                "AppleScript",
                "Asp",
                "BASIC",
                "C",
                "C++",
                "Clojure",
                "COBOL",
                "ColdFusion",
                "Erlang",
                "Fortran",
                "Groovy",
                "Haskell",
                "Java",
                "JavaScript",
                "Lisp",
                "Perl",
                "PHP",
                "Python",
                "Ruby",
                "Scala",
                "Scheme"
            ];
            $('#autocomplete-' + lang).autocomplete({
                minLength: 1,
                autoFocus: true,
                source: baseUrl + 'index.php?r=site%2Flangasoc&lang=' + lang
            });
        })
    })
})
// END AUTOCOMPLETE //




// SHOW CATEGORY EDIT //
function showCategory(item) {
    $.ajax({
        url: '/backend/web/index.php/?r=categories%2Fshow&item=' + item,
        dataType: 'html',
        success: function (data) {
            $('#editCategory .modal-content').html(data);
        }
    })
}

function showField(item) {
    $.ajax({
        url: '/backend/web/index.php/?r=fields%2Fshow&item=' + item,
        dataType: 'html',
        success: function (data) {
            $('#editField .modal-content').html(data);
            selectMedia();
        }
    })
}


// LOAD RELATION FOR CUSTOM FIELDS //
$('.custom-fields').each(function () {
    var item = $(this).find('select');

    item.on('change', function () {
        var value = $(this).val();

        $.ajax({
            url: '/backend/web/index.php/?r=fields%2Fshowitemrel&id=' + value,
            dataType: 'json',
            success: function (data) {
                $('[name="' + data.item + '"]').html(data.values);
            }
        })
    })
})
// LOAD RELATION FOR CUSTOM FIELDS //





// CODE PLUGIN
codeMirrorOptions = {

    lineNumbers: true,
    autoRefresh: true,
    fullscreen: true,
    mode: 'htmlmixed',
    theme: 'dracula'

}

$('.code-editor').each(function () {

    var textareaCode = this;

    CodeMirror.fromTextArea(textareaCode, codeMirrorOptions);

});



$(document).on('click', '#modal_builder .btn-submit-column[type="submit"]', function () {

    if ($('.CodeMirror').length) {

        var cm = document.querySelector('.CodeMirror').CodeMirror;

        cm.save();

    }

});


$('#modalMedia').on('hidden.bs.modal', function () {
    var fickle = $('.modal-content-fickle');

    if (fickle.length) {

        if (fickle.parents('#modal_builder').hasClass('show')) {
            $('body').addClass('modal-open');
        }
    }

});



$(document).on('change', '#uploadform-imagefile', function () {
    var i = $(this).prev('label').clone();
    var file = $('#uploadform-imagefile')[0].files[0].name;
    $('input[name="filename"]').val(file);
});



$('.tab-toggle').find('a').each(function () {
    $(this).on('click', function () {
        var id = $(this).attr('href');
        var action = $(this).data('action');
        $('.tab-content .tab-pane').html('');

        $.ajax({
            type: 'POST',
            url: '/backend/web/index.php?r=' + action + '/showtab',
            data: { id: id },
            dataType: 'html',
            success: function (data) {
                $('.tab-content').find(id).html(data);
            }
        })
    })
})


// ECOMMERCE SETTINGS //


// HISTORY //
$(document).on('click', '[data-history]', function (e) {
    e.preventDefault();
    var page = $(this).data('history');
    $('#history').html('<i class="fas spinn fa-circle-notch text-info"></i>');

    $.ajax({
        type: 'POST',
        url: '/backend/web/index.php?r=history/showlist',
        data: { idPage: page },
        dataType: 'html',
        success: function (data) {
            $('#history').html(data);
        }
    })
})

$(document).on('click', '[data-show-history]', function (e) {
    e.preventDefault();
    var id = $(this).data('show-history');
    $('#historyModal').find('.modal-content').html('<div class="modal-body text-center"><i class="fas spinn fa-circle-notch text-info"></i></div>');

    $.ajax({
        type: 'POST',
        url: '/backend/web/index.php?r=history/show',
        data: { idHistory: id },
        dataType: 'html',
        success: function (data) {
            $('#historyModal').find('.modal-content').html(data);
        }
    })
})

$(document).on('submit', '[data-restore-history]', function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var id = form.data('restore-history');

    $.ajax({
        type: 'POST',
        url: url,
        data: { idHistory: id },
        dataType: 'html',
        success: function (data) {
            $('#magic_builder').html(data);
            $('.modal').modal('hide');
            window.location = '#magic_builder';
        }
    })
})
// HISTORY //


// EDIT SECTIONS //
$(document).on('click', '[data-section]', function () {
    var key = $(this).data('section');
    var modal = $('#editSection');
    var content = modal.find('.modal-body');
    content.html('');
    $.ajax({
        type: 'POST',
        url: '/backend/web/index.php?r=sections/show',
        data: { key: key },
        dataType: 'html',
        success: function (data) {
            content.html(data);
        }
    })
})
// EDIT SECTIONS //





// $('.datetimepicker').datetimepicker({
//     icons: {
//         time: "fa fa-clock-o",
//         date: "fa fa-calendar",
//         up: "fa fa-chevron-up",
//         down: "fa fa-chevron-down",
//         previous: 'fa fa-chevron-left',
//         next: 'fa fa-chevron-right',
//         today: 'fa fa-screenshot',
//         clear: 'fa fa-trash',
//         close: 'fa fa-remove'
//     },
//     format: 'YYYY-MM-DD'
// });


// MODAL FIELDS
$(document).on('click', '[data-bs-target="#modalFields"]', function () {
    let modal = $(this).data('target');
    let content = $(modal).find('.modal-content');
    let page = $(this).data('field-page');
    let item = $(this).data('field-item');
    let target = $(this).data('field-target');

    $.ajax({
        url: '/backend/web/index.php?r=fields/associate',
        type: 'POST',
        data: { page: page, item: item, target: target },
        dataType: 'html',
        success: function (data) {
            content.html(data);
        },
        error: function (error) {
            console.log(error.responseText);
        }
    })
})

$(document).on('submit', '.form-fields-associate', function (e) {
    e.preventDefault();
    let form = $(this);

    $.ajax({
        url: '/backend/web/index.php?r=fields/associate',
        type: 'POST',
        data: form.serialize(),
        dataType: 'html',
        success: function (data) {
            $('#modalFields .modal-content').html(data);
        },
        error: function (error) {
            console.log(error.responseText);
        }
    })
})

$(document).on('click', '[data-field-set-associate]', function (e) {
    let el = $(this);
    let item = el.data('field-item');
    let page = el.data('field-page');
    let target = el.data('field-target');
    let associate = el.data('field-set-associate');

    $.ajax({
        url: '/backend/web/index.php?r=fields/associateset',
        type: 'POST',
        data: { item: item, page: page, target: target, associate: associate },
        dataType: 'html',
        success: function (data) {
            console.log(data);
            $('#modalFields').modal('hide');
            $('.field-' + item + ' .associated-set').append(data);
        },
        error: function (error) {
            console.log(error.responseText);
        }
    })
})

$(document).on('click', '[data-field-remove]', function () {
    let el = $(this);
    let item = el.data('field-remove');
    $('#' + item).remove();
})
// MODAL FIELDS





// ACTIONS MODAL GENERAL
/* Populate with data on click from button data-bs-target="#modalGeneral" and data-action="@variable" */
$(document).on('click', '[data-bs-target="#modalGeneral"]', function () {
    var action = $(this).data('action');
    var values = $(this).data('values');
    var modal = $(this).data('bs-target');

    if ($(this).data('modal')) {
        $(modal).find('.modal-dialog').attr('class', 'modal-dialog');
        var width = $(this).data('modal');
        $(modal).find('.modal-dialog').addClass('modal-' + width);
    }

    $.ajax({
        type: 'POST',
        url: '/backend/web/' + action,
        data: values,
        dataType: 'json',
        beforeSend: function () {
            $(modal).find('.modal-content').html('<div class="modal-body text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
        },
        success: function (response) {

            $(modal).find('.modal-content').html(response.render);

            if ($('#basicEditor').length) {
                CKEDITOR.replace('basicEditor', {
                    // toolbar : 'Basic', /* this does the magic */
                    height: '200px',
                    // extraPlugins: 'bootstrapTabs, collapsibleItem, showmore, btgrid, accordion',
                    extraAllowedContent: 'div span',
                    contentsCss: ['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'],
                    on: {
                        instanceReady: loadBootstrap,
                        mode: loadBootstrap
                    }
                });
            }

            if ($('.colorpicker-input').length) {
                CustomColorpicker();
            }
        },
        error: function (error) {
            $(modal).find('.modal-content').html('<div class="modal-body text-center text-warning">' + error.responseText + '</div>');
        }
    });
});


$(document).on('click', '[data-dismiss="modal"]', function (e) {

    e.preventDefault();

    var modal = $(this).parents('.modal');

    if (modal.length) {
        modal.modal('hide');
    }
    return false;
});


$(document).on('click', '.btn-remove-fickle-image, .btn-remove-fickle-background-image', function (e) {

    e.preventDefault();
    var btn = $(this);
    var upload_box = btn.closest('.upload-image-box');

    upload_box.find('.input_image').val('').attr("value", '');
    upload_box.find('img').attr('src', btn.data('no-image-src'));

    btn.remove();
    
});


