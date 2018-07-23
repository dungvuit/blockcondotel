function displayBarNotification(n,c,m){
    var nNote = jQuery("#nNote");
    if(n){
        nNote.attr('class', '').addClass("nNote " + c).fadeIn().html(m);
        setTimeout(function(){
            nNote.attr('class', '').hide("slow").html("");
        }, 10000);
    }else{
        nNote.attr('class', '').hide("slow").html("");
    }
}
function displayAjaxLoading(n){
    n?jQuery(".ajax-loading-block-window").show():jQuery(".ajax-loading-block-window").hide("slow");
}
function ShowType(id){
    jQuery.ajax({
        url: ajaxurl, type: "POST", dataType: "html", cache: false,
        data: {
            action: 'get_category_childrens',
            term_id: id
        },
        success: function (response, textStatus, XMLHttpRequest) {
            if(response && response.length > 0){
                jQuery("#category").html(response);
            }
        },
        error: function (MLHttpRequest, textStatus, errorThrown) {
        },
        complete: function () {
        }
    });
}
jQuery(document).ready(function ($) {
    jQuery("#nNote").click(function(){
        jQuery(this).attr('class', '').hide("slow").html("");
    });
    
    jQuery("input[name=rds]:first").attr('checked', true);
    
    jQuery("#ddlCity").change(function () {
        jQuery("#ddlDistrict").prop("disabled", true);
        jQuery("#ddlWard").prop("disabled", true);
        var id = jQuery('#ddlCity').val().trim() === "" ? 0 : jQuery('#ddlCity').val();
        if (parseInt(id) > 0) {
            jQuery.ajax({
                url: ajaxurl, type: "GET", dataType: "json", cache: true,
                data: {
                    action: 'get_ddldistrict',
                    city_id: id
                },
                success: function (response, textStatus, XMLHttpRequest) {
                    jQuery("#ddlDistrict").empty().append('<option value="">- Quận/ Huyện -</option>').append(response.data);
                    jQuery("#ddlDistrict").prop("disabled", false);
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                complete: function () {
                }
            });
        } else {
            jQuery("#ddlDistrict").empty().append('<option value="">- Quận/ Huyện -</option>').trigger('change');
            jQuery('#ddlWard').empty().append('<option value="">- Phường/Xã -</option>').trigger('change');
            jQuery('#ddlStreet').empty().append('<option value="">- Đường phố -</option>');
        }
    });
    jQuery("#ddlDistrict").change(function () {
        jQuery("#ddlWard").prop("disabled", true);
        var id = jQuery('#ddlDistrict').val().trim() === "" ? 0 : jQuery('#ddlDistrict').val();
        if (parseInt(id) > 0) {
            jQuery.ajax({
                url: ajaxurl, type: "GET", dataType: "json", cache: true,
                data: {
                    action: 'get_ddlward',
                    district_id: id
                },
                success: function (response, textStatus, XMLHttpRequest) {
                    jQuery("#ddlWard").empty().append('<option value="">- Phường/Xã -</option>').append(response.data);
                    jQuery("#ddlWard").prop("disabled", false);
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                complete: function () {
                }
            });

        } else {
            jQuery("#ddlDistrict").empty().append('<option value="">- Quận/ Huyện -</option>').trigger('change');
            jQuery('#ddlWard').empty().append('<option value="">- Phường/Xã -</option>').trigger('change');
            jQuery('#ddlStreet').empty().append('<option value="">- Đường phố -</option>');
        }
    });
    
    // Change profile
    jQuery("#frmChangeProfile .btnSubmit").click(function(){
        displayAjaxLoading(true);
        jQuery.ajax({
            url: ajaxurl, type: "POST", dataType: "json", cache: false,
            data: jQuery("#frmChangeProfile").serialize(),
            success: function(response, textStatus, XMLHttpRequest){
                if(response && response.status === 'success'){
                    displayBarNotification(true, 'nSuccess', response.message);
                    setTimeout(function (){
                        location.reload();
                    }, 2000);
                } else if(response.status === 'error'){
                    displayBarNotification(true, 'nWarning', response.message);
                }
            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                console.log(errorThrown);
            },
            complete:function(){
                displayAjaxLoading(false);
            }
        });
    });
    
    // Save post to Favorites
    jQuery(".list_product .item_product .share-pro .save-post, .carousel-products-widget .item .tools .save-post, .list_product .item_product .tools .save-post").click(function(){
        displayAjaxLoading(true);
        var post_id = jQuery(this).data('id');
        jQuery.ajax({
            url: ajaxurl, type: "POST", dataType: "json", cache: false,
            data: {
                action: 'add_to_favorites',
                post_id: post_id
            },
            success: function(response, textStatus, XMLHttpRequest){
                if(response && response.status === 'success'){
                    displayBarNotification(true, 'nSuccess', response.message);
                } else if(response.status === 'error'){
                    displayBarNotification(true, 'nWarning', response.message);
                }
            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                console.log(errorThrown);
            },
            complete:function(){
                displayAjaxLoading(false);
            }
        });
    });
    
    // Remove post from Favorites
    jQuery(".list_product .item_product .share-pro .unsave-post").click(function(){
        displayAjaxLoading(true);
        var post_id = jQuery(this).data('id');
        jQuery.ajax({
            url: ajaxurl, type: "POST", dataType: "json", cache: false,
            data: {
                action: 'remove_from_favorites',
                post_id: post_id
            },
            success: function(response, textStatus, XMLHttpRequest){
                if(response && response.status === 'success'){
                    displayBarNotification(true, 'nSuccess', response.message);
                    jQuery(".item_product_" + post_id).remove();
                } else if(response.status === 'error'){
                    displayBarNotification(true, 'nWarning', response.message);
                }
            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                console.log(errorThrown);
            },
            complete:function(){
                displayAjaxLoading(false);
            }
        });
    });
    
    // Add post to Compare
    jQuery(".list_product .item_product .share-pro .compare-post, .carousel-products-widget .item .tools .compare-post, .list_product .item_product .tools .compare-post").click(function(){
        displayAjaxLoading(true);
        var post_id = jQuery(this).data('id');
        jQuery.ajax({
            url: ajaxurl, type: "POST", dataType: "json", cache: false,
            data: {
                action: 'add_to_compare',
                post_id: post_id
            },
            success: function(response, textStatus, XMLHttpRequest){
                if(response && response.message.length > 0){
                    displayBarNotification(true, 'nSuccess', response.message);
                } else {
                    window.location = response.redirect_url;
                }
            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                console.log(errorThrown);
            },
            complete:function(){
                displayAjaxLoading(false);
            }
        });
    });
    
    jQuery(".carousel-products-widget .item .thumbnail, .list_product .item_product .thumbnail").click(function(){
        return false;
    });
});