<ul class="nav nav-tabs">
	<?php if ( $current_user_role == 'sale-salesman' || $current_user_role == "sale-administrator" ) : ?>
		<li class="top-buffer-half">
			<a  href="<?php echo site_url() . '/system-dashboard/leads'; ?>"><i class="fa fa-paper-plane-o"
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
		<li class="top-buffer-half " >
			<a data-toggle="tab" href="#projects"><i class="fa fa-cube"
			                                         aria-hidden="true"></i> <?php echo __( "Projekt" ) ?>
			</a>
		</li>
	<?php endif; ?>
	<?php if ( true ) : ?>
		<li class="top-buffer-half">
			<a id="calendar-tab" data-toggle="tab" href="#work-planning-calendar"><i class="fa fa-calendar"
			                                                                         aria-hidden="true"></i> <?php echo __( "Kalender" ) ?>
			</a>
		</li>
	<?php endif; ?>

	<?php/* if ( true ) : ?>
		<li class="top-buffer-half">
			<a data-toggle="tab" href="#web-orders"><i class="fa fa-shopping-cart"
			                                           aria-hidden="true"></i> <?php echo __( "Webborder" ) ?>
			</a>
		</li>
	<?php endif; */?>
    <?php if ( true ) : ?>
        <li class="top-buffer-half">
            <a data-toggle="tab" href="#alla-ordrar"><i class="fa fa-info-circle"
                                                       aria-hidden="true"></i> <?php echo __( "Egna ordrar" ) ?>
            </a>
        </li>
    <?php endif; ?>
     <?php if ($current_user_role != 'sale-sub-contractor') : ?>
        <li class="top-buffer-half">
            <a data-toggle="tab" href="#rapporter_tab"><i class="fa fa-list-ol"
                                                        aria-hidden="true"></i> <?php echo __( "Rapporter" ) ?>
            </a>
        </li>
    <?php endif; ?>

</ul>