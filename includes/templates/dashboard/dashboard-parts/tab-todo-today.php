<?php
/**
 * To-do tab in System Dashboard. Lists To-do items connected by role and user.
 * TODO: Make better logic for displaying To-do items based on user/role.
 */
?>
<div id="todo-today" class="tab-pane fade in active">
    <?php
    $table_name = "todo-table";
    $current_user_role = get_user_role();
    $project_status = "project-ongoing";
    ?>
    <div class="row top-buffer-half">
        <div class="col-lg-4 col-md-4 col-sm-6"><?php get_todo_status_dropdown("order-by-todo-status", $table_name); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6"><?php get_number_of_posts_dropdown("number-of-todos", $table_name, 'label_todo_tab', 'filter_todo_tab'); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6"><?php get_departments_dropdown("todo-order-department_" . $project_status, $table_name,$current_user_role, true, $project_status, "", 'filter_todo_tab'); ?>
		
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6"><?php get_my_or_all_dropdown("todo-order-by-mine-or-all",'', $table_name, "", 'filter_todo_tab'); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <label for="imm-sale-order-date_from" class="top-buffer-half"> <?php echo __("Från"); ?></label>
            <input type="text" id="imm-sale-order-date_from" class="filter_todo_tab cstm_date_picker"
                   data-table_name="<?php echo $table_name; ?>" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <label for="imm-sale-order-date_to" class="top-buffer-half"> <?php echo __("Till"); ?></label>
            <input type="text" id="imm-sale-order-date_to" class="filter_todo_tab cstm_date_picker"
                   data-table_name="<?php echo $table_name; ?>" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 " id="get_internal_status1" style="display:none;">

            <?php get_internal_project_status_dropdown($current_user_role, "internal_project_status_user_todo", $table_name, "top-buffer-half", 'top-buffer-half', 'filter_todo_tab'); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6"><?php get_assigned_user_mottagare("todo_assigned_user_mottagare", get_current_user_id(), $table_name, "top-buffer-half", 'filter_todo_tab'); ?>
        </div>
    </div>


    <table class="table top-buffer-half">
        <thead>
            <tr>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"></th>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Åtgärdsdatum"); ?></th>
                <th class="sortable"
                    onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Projekt") ?></th>
                <th class="sortable"
                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Status"); ?></th>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Avsändare"); ?></th>
                <th class="sortable"
                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Mottagare"); ?></th>
                <th class="sortable"
                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Kund"); ?></th>
                <th class="sortable"
                    onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Avdelning") ?></th>
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Notering") ?></th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
               </tbody>
    </table>
</div>

<script>
    function get_department_todo(department, class_name, table_name = false, classes,newid) {
        var department = department;

        jQuery.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                action: 'getDepartment',
                department: department,
                table_name: table_name,
                classes: classes,
				newid:newid
            },
            success: function (result) {

                jQuery('#' + class_name).html(result);
                jQuery('.js-sortable-select').select2(
                        {
                            theme: "bootstrap",
                            width: '100%'
                        });
            }
        });
    }

jQuery(document).ready(function($){
	
	var conv = JSON.parse(readCookie('todotoday'));
	if(conv){
	var receiver = conv[5].split('##');
	var rec = receiver[1];
	}else{
		var rec  = 'ew';
	}
if(rec === $('#useridget').val()){ 
console.log(receiver[1]); 	
$.each( conv, function( key, value ) {
first = value.split('##');

$("#todo-today select[name= '" +first[0]+ "']").val(first[1]);

var get = $("#todo-today select[name= '" +first[0]+ "'] :selected").text(); 
if(first[0] == 'todo-order-department_project-ongoing' && first[1] == 'alla'){

get_department_todo('alla', 'get_internal_status1', 'all-table', 'filter_project_tab','internal_project_status_user_todo');
}
$('#todo-today span#select2-'+first[0]+'-container').text(get);
$('#todo-today span#select2-'+first[0]+'-container').prop('title', get);
});  
}
 
		var todo_status = $("#order-by-todo-status").val();
        var number_of_posts = $("#number-of-todos").val();
        var from_date = $("#imm-sale-order-date_from").val();
        var to_date = $("#imm-sale-order-date_to").val();
        var mine_all = $("#todo-order-by-mine-or-all").val();
        var user_mottagare = $("#todo_assigned_user_mottagare").val();
        var department = $("#todo-order-department_project-ongoing").val();
        var role_status = $("#todo-today select#internal_project_status_user_todo").val();

if(role_status != 'Alla'){
        var role_status = $('#projects select#internal_project_status_user_todo').val().split('#');
		  var crntstatus = role_status[0];
        var roles = role_status[1];
}else{
        var crntstatus = role_status;
       // var roles = role_status[1];
}
 $.ajax({
            url:  "/wp-admin/admin-ajax.php",
            type: 'POST',
            data: {
                action: 'filter_and_return_todos',
                number_of_posts: number_of_posts,
                todo_status: todo_status,
                from_date: from_date,
                to_date: to_date,
                mine_all: mine_all,
                department: department,
                crntstatus: crntstatus,
                user_mottagare: user_mottagare,
                roles: roles

            },

            success: function (results) {
                $("#todo-table").html(results);
            }
        });
$(".cstm_date_picker").datepicker();
		});
		
</script>