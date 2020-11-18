<?php
/**
 * Main system dashboard. Contains includes for dashboard partials
 * TODO: Only show parts connected to the correct user role.
 */
include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
global $current_user;
global $current_user_role;
$today = date( 'Y-m-d' );
?>
<!--<div class="front-loader"></div>-->
    <div class="container-db">
        <div class="row">
            <div class="col-lg-12">

                <h2><?php echo __( "Välkommen, " ) . "<span class='name'>" . getCustomerName($current_user->ID) . "</span>"; ?></h2>

                <ul class="nav nav-tabs backbrowser">
					<?php if ( $current_user_role == 'sale-salesman' || $current_user_role == "sale-administrator" ) : ?>
                        <li class="top-buffer-half">
                            <a data-toggle="tab" href="#leads"><i class="fa fa-paper-plane-o"
                                                                  aria-hidden="true"></i> <?php echo __( "Leads" ) ?>
                            </a>
                        </li>
					<?php endif; ?>
					<?php if ( true ) : ?>
                        <li class="top-buffer-half active">
                            <a data-toggle="tab" href="#todo-today"><i class="fa fa-list-ol"
                                                                       aria-hidden="true"></i> <?php echo __( "Uppgift" ) ?>
                            </a>
                        </li>
					<?php endif; ?>

					<?php if ( true ) : ?>
                        <li class="top-buffer-half projects_nav">
                            <a data-toggle="tab" href="#projects"><i class="fa fa-cube"
                                                                     aria-hidden="true"></i> <?php echo __( "Projekt" ) ?>
                            </a>
                        </li>
					<?php endif; ?>
					<?php if ( true ) : ?>
                        <li class="top-buffer-half">
                            <a id="calendar-tab" data-toggle="tab" href="#work-planning-calendar"><i
                                        class="fa fa-calendar"
                                        aria-hidden="true"></i> <?php echo __( "Kalender" ) ?>
                            </a>
                        </li>
					<?php endif; ?>

					<?php /* if ( true ) : ?>
                        <li class="top-buffer-half">
                            <a data-toggle="tab" href="#web-orders"><i class="fa fa-shopping-cart"
                                                                       aria-hidden="true"></i> <?php echo __( "Webborder" ) ?>
                            </a>
                        </li>
					<?php endif; */?>

                    <?php if ( true ) : ?>
                        <!--<li class="top-buffer-half egen_order_nav_tab">
                            <a  data-toggle="tab" href="#alla-ordrar"><i
                                        class="fa fa-info-circle"
                                        aria-hidden="true"></i> <?php //echo __( "Egna ordrar" ) ?>
                            </a>
                        </li>-->
                    <?php endif; ?>
             <?php if ($current_user_role != 'sale-sub-contractor') : ?>
                        <li class="top-buffer-half rapporter_nav_tab">
                            <a data-toggle="tab" href="#rapporter_tab"><i class="fa fa-list-ol"
                                                                       aria-hidden="true"></i> <?php echo __( "Rapporter" ) ?>
                            </a>
                        </li>
                 <?php endif; ?>
<?php  if ($current_user_role == "sale-administrator") : ?>
                        <li class="top-buffer-half">
                            <a data-toggle="tab" href="#alla-ordrar"><i class="fa fa-file"
                                                                       aria-hidden="true"></i> <?php echo __( "Synka leverantörsfakturor" ) ?>
                            </a>
                        </li>
					<?php endif; ?>
                        
                        <?php/*  if(get_current_user_id()=='328') : ?>
                        <li class="top-buffer-half">
                            <a data-toggle="tab" href="#new_todo"><i class="fa fa-list-ol"
                                                                       aria-hidden="true"></i> <?php echo __( "Uppgift New" ) ?>
                            </a>
                        </li>
					<?php endif; */?>
                        
                        
                </ul>
                <hr>
                <div class="tab-content">
					<?php

					if ( true ) {
						include( 'dashboard/dashboard-parts/tab-todo-today.php' );
					}
                                        if(get_current_user_id()=='328'){
                                        if ( true ) {
						include( 'dashboard/dashboard-parts/todo_list.php' );
					}
					}
					if ( $current_user_role = 'sale-salesman' || $current_user_role == "sale-administrator" ) {
						include( 'dashboard/dashboard-parts/tab-leads.php' );
					}
					if ( true ) {
						include( 'dashboard/dashboard-parts/sample-tab-projects.php' );
					}
					if ( true ) {
						include( 'dashboard/dashboard-parts/tab-work-planning-calendar.php' );
					}
					if ( true ) {
						//include( 'dashboard/dashboard-parts/tab-web-order.php' );
					}
                 
                   if ( true ) {
                        include( 'dashboard/dashboard-parts/tab-rapporter.php' );
                    }	
					if ($current_user_role == "sale-administrator") {
                       include( 'dashboard/dashboard-parts/tab-alla-ordrar.php' );
                    }
			
					?>


                </div>

            </div>
        </div>

    </div>


<?php
wp_footer();
