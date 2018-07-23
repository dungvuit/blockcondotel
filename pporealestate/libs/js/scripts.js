/**
 * @Author: Ngo Van Thang
 * @Email: ngothangit@gmail.com
 */
var shortname = "ppo";
var CustomJS = {
    uploadSlider: function ($) {
        var custom_uploader;
        $('#upload_slide_img_button').click(function (e) {
            e.preventDefault();

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function () {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#slide_img').val(attachment.url);
            });

            //Open the uploader dialog
            custom_uploader.open();
        });

        $("#publish").click(function (event) {
            var valid = true;
            if ($("#slide_img").length > 0 && $("#slide_img").val().length == 0) {
                $("#slide_img").css('border', '1px solid red');
                valid = false;
            }
            if ($("#slide_order").length > 0 && !$.isNumeric($("#slide_order").val())) {
                $("#slide_order").css('border', '1px solid red');
                valid = false;
            }
            if (valid == false) {
                event.stopImmediatePropagation();
                return false;
            }
        });
    },
    uploadAds: function ($) {
        var custom_uploader;
        $('#upload_media_button').click(function (e) {
            e.preventDefault();

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                frame: 'select', // 'post'
                state: 'upload_media',
                multiple: false,
                //library: { type : 'image' },
                button: {text: 'Close'}
            });
            custom_uploader.states.add([
                new wp.media.controller.Library({
                    id: 'upload_media',
                    title: 'Upload Media',
                    priority: 20,
                    toolbar: 'select',
                    filterable: 'uploaded',
                    library: wp.media.query(custom_uploader.options.library),
                    multiple: custom_uploader.options.multiple ? 'reset' : false,
                    editable: true,
                    displayUserSettings: false,
                    displaySettings: true,
                    allowLocalEdits: true
                            //AttachmentView: ?
                }),
            ]);

            //Open the uploader dialog
            custom_uploader.open();
        });
    },
    uploadMetaFields: function ($) {
        var fields = new Array('slide_img', 'logo_img');

        $.each(fields, function (index, field) {
            $("#publish").click(function (event) {
                var valid = true;
                if ($('#' + field).length > 0 && $('#' + field).val().length == 0) {
                    $('#' + field).css('border', '1px solid red');
                    valid = false;
                }
                if ($("#order_item").length > 0 && !$.isNumeric($("#order_item").val())) {
                    $("#order_item").css('border', '1px solid red');
                    valid = false;
                }
                if (valid == false) {
                    event.stopImmediatePropagation();
                    return false;
                }
            });
        });

        $("select.chosen-select").chosen({width: "38%"});
    }
};
function uploadByField(field) {
    jQuery(document).ready(function ($) {
        var custom_uploader;

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#' + field).val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();
    });
}
function uploadProductChildIMG(field) {
    jQuery(document).ready(function ($) {
        var custom_uploader;

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function () {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#' + field).val(attachment.url);
            $('#img_' + field).attr('src', attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();
    });
}
function city_change(id){
    jQuery(document).ready(function ($) {
        if (parseInt(id) > 0) {
            jQuery.ajax({
                url: ajaxurl, type: "POST", dataType: "json", cache: false,
                data: {
                    action: 'get_ddldistrict',
                    city_id: id,
                },
                success: function (response, textStatus, XMLHttpRequest) {
                    $("#district").empty().append('<option value="">- Quận/ Huyện -</option>').append(response.data);
                    $("#district").prop("disabled", false);
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                },
                complete: function () {
                }
            });
        } else {
            $("#district").empty().append('<option value="">- Quận/ Huyện -</option>').trigger('change');
            $('#ward').empty().append('<option value="">- Phường/Xã -</option>').trigger('change');
            $('#ddlStreet').empty().append('<option value="">- Đường phố -</option>');
        }
    });
}
function district_change(id){
    jQuery(document).ready(function ($) {
        if (parseInt(id) > 0) {
            jQuery.ajax({
                url: ajaxurl, type: "POST", dataType: "json", cache: false,
                data: {
                    action: 'get_ddlward',
                    district_id: id,
                },
                success: function (response, textStatus, XMLHttpRequest) {
                    $("#ward").empty().append('<option value="">- Phường/Xã -</option>').append(response.data);
                    $("#ward").prop("disabled", false);
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                },
                complete: function () {
                }
            });
        } else {
            $("#district").empty().append('<option value="">- Quận/ Huyện -</option>').trigger('change');
            $('#ward').empty().append('<option value="">- Phường/Xã -</option>').trigger('change');
            $('#ddlStreet').empty().append('<option value="">- Đường phố -</option>');
        }
    });
}

// Run
jQuery(document).ready(function ($) {
    CustomJS.uploadSlider($);
    CustomJS.uploadAds($);
    CustomJS.uploadMetaFields($);

    $("select.select-chosen").chosen();

    $('#' + shortname + '_primaryColor, #' + shortname + '_primaryBigColor, #' + shortname + '_primaryBigBgColor, #' + shortname + '_linkColor, #' + shortname + '_linkHVColor, #' + shortname + '_secondaryColor, #' + shortname + '_linkMenu, #' + shortname + '_linkHVMenu,#' + shortname + '_footerColor,#' + shortname + '_footerBgColor, #' + shortname + '_bgColor, #tag_meta_color').each(function () {
        var $el = $(this);
        $el.css({
            width: 100,
            height: 36,
            'float': 'left',
            margin: '0 0 0 -3px'
        })
        .before('<div class="colorSelector"><div style="background-color:#' + $el.val() + '"></div></div>')
        .after('<div style="clear:both;"></div>')
        .ColorPicker({
            onSubmit: function (hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
                $(this).prev('div.colorSelector').children('div').css('backgroundColor', '#' + this.value);
            },
            onChange: function (hsb, hex, rgb) {
                $el.val(hex).prev('div.colorSelector').children('div').css('backgroundColor', '#' + hex);
            }
        })
        .bind('keyup', function () {
            $(this).ColorPickerSetColor(this.value);
            $(this).prev('div.colorSelector').children('div').css('backgroundColor', '#' + this.value);
        })
        .prev('div.colorSelector').click(function () {
            $(this).next('input').click();
        });
    });

    $('#city').on('change', function () {
        $("#district").prop("disabled", true);
        $("#ward").prop("disabled", true);
        var id = $('#city').val() === "" ? 0 : $('#city').val();
        city_change(id);
    });

    $("#district").change(function () {
        $("#ward").prop("disabled", true);
        var id = $('#district').val() === "" ? 0 : $('#district').val();
        district_change(id);
    });
    
    $(window).load(function(){
        $("#district").prop("disabled", true);
        $("#ward").prop("disabled", true);
        var city_id = $('#city').val() === "" ? 0 : $('#city').val();
        var district_id = $('#district').attr('data-val') === "" ? 0 : $('#district').attr('data-val');
        var ward_id = $('#ward').attr('data-val') === "" ? 0 : $('#ward').attr('data-val');
        try {
            if(typeof city_id !== undefined && city_id !== 0 && city_id.toString().trim().length !== 0){
                city_change(city_id);
                district_change(district_id);
                setTimeout(function(){
                    $('#district').val(district_id);
                    $('#ward').val(ward_id);
                }, 1000);
                setTimeout(function(){
                    $('#district').val(district_id);
                    $('#ward').val(ward_id);
                }, 2000);
                setTimeout(function(){
                    $('#district').val(district_id);
                    $('#ward').val(ward_id);
                }, 3000);
            }
        } catch (e) {
            console.log(e);
        }
    });
    
    // API
    jQuery(".btn-push-api").click(function(){
        jQuery(this).attr('disabled', 'disabled').text("Pushing...");
        var btnPush = jQuery(this);
        var post_id = jQuery(this).data('id');
        var api_url = jQuery(this).prev('.api-url').val();
        if (parseInt(post_id) > 0) {
            jQuery.ajax({
                url: ajaxurl, type: "POST", dataType: "json", cache: false,
                data: {
                    action: 'api_push_product',
                    id: post_id,
                    url: api_url
                },
                success: function (response, textStatus, XMLHttpRequest) {
                    if(response){
                        if(response.status === "success"){
                            btnPush.removeClass('button-primary').text("Pushed");
                            if(jQuery('.btn-push-api').prev('.api-url').find('option').length > 1){
                                setTimeout(function(){
                                    btnPush.addClass('button-primary').text('Push');
                                }, 1000);
                            }
                        } else if(response.status === "error") {
                            alert(response.message);
                            btnPush.removeAttr('disabled').text('Push');
                        }
                    } else {
                        alert("Xảy ra lỗi!");
                        btnPush.removeAttr('disabled').text('Push');
                    }
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                    btnPush.removeAttr('disabled');
                },
                complete: function () {
                    if(jQuery('.btn-push-api').prev('.api-url').find('option').length > 1){
                        btnPush.removeAttr('disabled');
                    }
                }
            });
        } else {
            alert("Không hợp lệ!");
            jQuery(this).removeAttr('disabled');
        }
    });
});