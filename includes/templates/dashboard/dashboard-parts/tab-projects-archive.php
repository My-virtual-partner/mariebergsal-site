<?php
$current_user_role = get_user_role();

?>
<div id="projects-archive" class="tab-pane fade">
	<?php
	$table_name     = "all-table-archived";
	$project_status = "project-archived";
	?>
    <div class="row top-buffer-half">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <label for="imm-sale-search-project"> <?php echo __( "Sök efter projekt" ); ?></label>
            <input value="" type="text" name="imm-sale-search-project"
                   data-table_name="<?php echo $table_name; ?>"
                   data-current_department="<?php echo $current_user_role; ?>"
                   data-project_status="<?php echo $project_status ?>"
                   class="form-control imm-sale-search-project imm-sale-search-project_archived"
                   id="imm-sale-search-project_<?php echo $table_name; ?>"
                   placeholder="<?php echo __( "Sök efter projekt..." ); ?>">

        </div>
    </div>

    <table class="table top-buffer-half">
        <thead>
        <tr>
            <th class="sortable"
                onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "ID" ); ?></th>
            <th class="sortable"
                onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Intern projektstatus" ); ?></th>
            <th class="sortable"
                onclick="sortTable(2,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Kund" ) ?></th>
            <th class="sortable"
                onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Säljare" ) ?></th>
            <th class="sortable"
                onclick="sortTable(4,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Typ av projekt" ) ?></th>
            <th class="sortable"
                onclick="sortTable(5,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Avdelning" ) ?></th>
            <th class="text-center"><?php echo( "Verktyg" ); ?></th>
        </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
		<?php
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		if ( $current_user_role == 'imm-sale-sub-contractor' ) {
			$meta = array(
				'relation' => 'AND',
				array(
					'key'   => 'order_current_department',
					'value' => $current_user_role,
				),
				array(
					'key'   => 'imm-sale-project',
					'value' => $project_status,
				),
                array(
					'key'   => 'assigned-technician-select',
					'value' => get_current_user_id(),
				),
			);

		} else {
			$meta = array(
				'relation' => 'AND',
				array(
					'key'   => 'order_current_department',
					'value' => $current_user_role,
				),
				array(
					'key'   => 'imm-sale-project',
					'value' => $project_status,
				),
			);
		}

		$args = [
			'posts_per_page' => -1,
			'orderby'        => 'ID',
			'post_type'      => wc_get_order_types(),
			'post_status'    => array_keys( wc_get_order_statuses() ),
			'meta_query'     => $meta,
		];
		return_orders_table( $args );
		wp_reset_query();

		?>
        </tbody>
    </table>
<!--    <div class="text-center">-->
<!--        <button class="btn btn-brand text-center load-more"-->
<!--                data-type="project"-->
<!--                data-project_status="--><?php //echo $project_status; ?><!--"-->
<!--                data-table="--><?php //echo $table_name; ?><!--"-->
<!--                data-page="2"><i class="fa fa-plus"-->
<!--                                 aria-hidden="true"></i> --><?php //echo __( "Ladda fler projekt" ); ?>
<!--        </button>-->
<!--    </div>-->

</div>
