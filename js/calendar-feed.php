<?php
require_once( "../../../../wp-load.php" );

$action = $_GET["action"];
$office_id = $_GET["office_id"];
$from_field = "work-date-from";
$to_field = "work-date-to";

$meta = null;


if (get_user_role() == 'sale-sub-contractor') {


    $meta = array(
        'relation' => 'OR',
        array(
            'key' => 'assigned-subcontractor-select-calender',
            'value' => get_current_user_id()
        ),
        array(
            'key' => 'order_current_department',
            'value' => 'sale-sub-contractor'
        )
    );
} elseif (isset($_GET["office_id"]) && $_GET["office_id"] != '') {
    if ($_GET["office_id"] == 'order_calendar_by_office') {
        $meta = array(
            array(
                'key' => 'office_connection',
                'value' => array('27782', '2625', '2541', '2540', '2539', '2538', '2537', '2536','office_connection'),
                'compare' => 'IN'
            ),
        );
    } else {
        $meta = array(
            array(
                'key' => 'office_connection',
                'value' => $office_id
            ),
        );
    }
}


$args = [
    'orderby' => 'ID',
    'post_type' => 'imm-sale-project',
    'posts_per_page' => - 1,
    'meta_query' => $meta
];

$return_dates_for_calendar = [];
$orders = new WP_Query($args);
//echo"<pre>";
//print_r($orders);

while ($orders->have_posts()) {
    $orders->the_post();
    $project = get_post(get_the_ID());
//    echo"<br>";
//    echo $project->ID;
    $custom_project_number = get_post_meta($project->ID, 'custom_project_number')[0];
    $url = "/project?pid=" . $project->ID;
    $project_type = get_field('order_project_type', $project->ID);


    global $wpdb;
    $table = $wpdb->prefix . 'project_calender';
    $current_user_id = get_current_user_id();
    $query = "SELECT * FROM $table WHERE project_id=$project->ID";
    $result = $wpdb->get_results($query);
    foreach ($result as $value) {
        $calender_id=$value->id;
           
        $work_date_from = $value->work_date_from;
      //  $work_date_to = $value->work_date_to;
		$work_date_to = date('Y-m-d ', strtotime($value->work_date_to . ' +1 day'));
        $end = date('Y-m-d ', strtotime($work_date_to));
        $planning_type = $value->planning_type;
        $current_assigned_technician = $value->assigned_subcontractor_select;
        $user = get_userdata($current_assigned_technician);
        if ($user) {
            $techinican_display_name = $user->data->display_name;
        } else {
            $techinican_display_name = __("Ingen tekniker vald");
        }
//        echo"<br>";
//       echo $project->ID.'work_date_from'.$work_date_from.'date_to'.$end.'assigned_subcontractor_select'.$techinican_display_name.'planning_type'.$planning_type;
        $dates = [
        'calender_id'=>$calender_id,
        'project_id' => $project->ID,
        'title' => $custom_project_number,
        'start' => $work_date_from,
        'end' => $end,
        'url' => $url,
        'className' => '',
        'resourceId' => $user->data->ID,
        'backgroundColor' => $planning_type,
    ];

    array_push($return_dates_for_calendar, $dates);
   
    }





//    $current_assigned_technician = get_post_meta($project->ID, "assigned-subcontractor-select")[0];
//    $user = get_userdata($current_assigned_technician);
//    if ($user) {
//        $techinican_display_name = $user->data->display_name;
//    } else {
//        $techinican_display_name = __("Ingen tekniker vald");
//    }

    
//    $end = date('Y-m-d ', strtotime(get_post_meta($project->ID, $to_field)[0] . ' +1 day'));

    
}


if (get_user_role() == "sale-sub-contractor") {

    $users = wp_get_current_user();
} else {

    $args = array(
        'role__in' => array('sale-technician', 'sale-sub-contractor')
    );
    $users = get_users($args);
}

foreach ($users as $user) {
    $planning_unavailable = get_field('planning_unavailable', 'user_' . $user->ID);

    foreach ($planning_unavailable as $single_planning_unavailable) {
        $unav_date = [
            'title' => $single_planning_unavailable["unavailable_title"],
            'start' => $single_planning_unavailable["unavailable_date_from"],
            'end' => $single_planning_unavailable["unavailable_date_to"],
            'backgroundColor' => 'red',
            'redering' => 'background',
            'resourceId' => $user->ID,
            'editable' => false
        ];

        array_push($return_dates_for_calendar, $unav_date);
    }
}


echo json_encode($return_dates_for_calendar, JSON_PRETTY_PRINT);
