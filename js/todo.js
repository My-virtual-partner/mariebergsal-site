var ajaxUrl = "/wp-admin/admin-ajax.php";

jQuery(document).on("change",'.todo_assigned_user_mottagare', function (event) {
    var mottagare = jQuery('#todo_assigned__user').val();
    var getaRole = jQuery('#todo_assigned__user option:selected').attr('data_roll');
    var searched_user_roll = jQuery('#todo_assigned_department option[value="' + getaRole + '"]').attr('selected', 'selected');
    jQuery('#todo_assigned_department').append(searched_user_roll);
    searched_user_roll.prop('selected', 'selected').change();
    jQuery('#todo_assigned__user option[value="' + mottagare + '"]').attr('selected', 'selected');
});
 
 
jQuery(document).on('change','.todo-assigned-department', function (e) {

var data_roll = jQuery('#todo_assigned_department option:selected').val();
        var selected_user_val = jQuery('#selected_user_value').val();
        var searched_user_roll = jQuery('#todo_assigned__user_hidden').find('[data_roll="' + data_roll + '"]');
        if (data_roll === 'alla') {
jQuery('#todo_assigned__user').empty();
        var $choosen_options = jQuery('#todo_assigned__user_hidden').children().clone();
        jQuery('#todo_assigned__user').append($choosen_options);
        } else {
jQuery('#todo_assigned__user').empty();
        var $choosen_options = searched_user_roll.clone();
//        jQuery('#todo_assigned__user').append('<option value="alla"> Alla </option>');
        jQuery('#todo_assigned__user').append($choosen_options);
        searched_user_roll.prop('selected', 'selected').change();
        jQuery('#todo_assigned__user option[value="' + selected_user_val + '"]').attr('selected', 'selected');
        }

})

function show_todo_loader(display) {
    if (display == 'show') {
        jQuery(".front-loader").show();
    } else {
        jQuery(".front-loader").hide();
    }
    jQuery(".front-loader").html('<div class="loading_overlay" style="background-color: rgba(255, 255, 255, 0.8);/* position: absolute; */ display: block; /* flex-direction: column; *//* align-items: center; *//* justify-content: center; */z-index: 9999;background-image: url(&quot;/wp-content/plugins/imm-sale-system/js/loading.gif&quot;);background-position: center center;background-repeat: no-repeat;top: 0px;left: 0px;width: 100%;height: 100%;background-size: 100px;"></div><span>Laddar...</span>');
}


jQuery(document).on('click','.toggle-todo-modal', function (e) {
//    alert('yes');
    var todo_id = jQuery(this).attr('data-todo-id');
    var project_id = jQuery(this).attr('data-project-id');
    jQuery.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: {
            action: 'return_todo_modal_content',
            todo_id: todo_id,
            project_id: project_id

        },
        beforeSend: function () {
            show_todo_loader("show");
//                $.LoadingOverlay("show");
        },
        success: function (results) {
            show_todo_loader("hide");
//                $.LoadingOverlay("hide");
            jQuery(".todo-modal-body").html(results);
            jQuery("#todo-modal").modal('show');
            jQuery('.js-sortable-select').select2(
                    {
                        theme: "bootstrap",
                        width: '100%'
                    }
            );
        }
    });
});

function todoConfirm(msg, yesFn, noFn) {
    var confirmBox = jQuery("#confirmBox");
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function () {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();
}

jQuery(document).on('click','a#remove-todo', function () {
var todo_id = jQuery(this).attr('data-order-id');
        var newid = jQuery('tr#' + todo_id);
        todoConfirm("Är du säker?", function yes() {
        jQuery.ajax({
        url: '/wp-content/plugins/imm-sale-system/ajax/delete_todo_ajax.php',
                type: 'POST',
                data: {
                // action: 'delete_todo_data',
                todo_id: todo_id,
                },
                success: function (result) {
                newid.fadeOut(1000, function(){ newid.remove(); });
                        jqueryshow_loader("hide");
                }
        });
        }, function no() {

        });
});


jQuery(document).on('click','#completed_task', function () {
    if (jQuery(this).attr('data-checkfinish')) {
        var value = jQuery(this).attr('data-todo-status');
        if (value === 1) {
            var value = 0;
        } else {
            var value = 1;
        }
    } else {
        if (jQuery(this).is(":checked"))
            var value = 1;
        else
            var value = 0;
    }


    var orderid = jQuery(this).attr('data-order-id');
    var todo_id = (orderid) ? orderid : jQuery('input[name="todo_id"]').val();
    var todo_action_date = jQuery('#todo_action_date').val();
    var todo_assigned_department = jQuery('#todo_assigned_department').val();
    var todo_assigned_user_hidden = jQuery('#todo_assigned__user_hidden').val();
    var todo_entry = jQuery('#todo_entry').val();
    var mottagare = jQuery('#todo_assigned__user').val();
    jQuery.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: {
            action: 'completed_upgift',
            todo_id: todo_id,
            todo_action_date: todo_action_date,
            todo_assigned_department: todo_assigned_department,
            todo_assigned_user_hidden: todo_assigned_user_hidden,
            todo_entry: todo_entry,
            todo_assigned_user_mottagare: mottagare,
            value: value,
            checkquick: jQuery(this).attr('data-checkfinish')
        },
        beforeSend: function () {
//            alert('yes1');

            jqueryshow_loader("show");
//            jQuery.LoadingOverlay("show");
        },
        success: function (results) {
//            alert('yes');
            location.reload();
//            jQuery.LoadingOverlay("hide");
            jqueryshow_loader("hide");
            jQuery("#todo-modal").modal('hide');
        }
    });
});