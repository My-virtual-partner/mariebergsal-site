<?php
/**
 * Calendar tab in System Dashboard. If user role is sale-sub-contractor, the only user shown is the current user.
 */

$args  = array(
	'role__in' => array( 'sale-technician', 'sale-sub-contractor' )
);
$users = get_users( $args );


?>

<div id="work-planning-calendar" class="tab-pane fade ">

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12">
			<?php get_tech_sub_dropdown( "order_calendar_by_user" ); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
			<?php get_office_dropdown( "order_calendar_by_office" ); ?>
        </div>

    </div>
    <div class="top-buffer" id='work-planning-calendar-cal'></div>
</div>
