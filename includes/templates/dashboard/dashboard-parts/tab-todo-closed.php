<div id="todo-closed" class="tab-pane fade">
	<?php $table_name = "todo-closed-table"; ?>

	<table class="table top-buffer-half">
		<thead>
		<tr>
			<th class="sortable"
			    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "'Att göra' datum" ); ?></th>
			<th class="sortable"
			    onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Status" ); ?></th>

			<th class="sortable"
			    onclick="sortTable(2,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Projekt" ) ?></th>
			<th class="sortable"
			    onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Notering" ) ?></th>
			<th class="text-center"><?php echo( "Verktyg" ); ?></th>
		</tr>
		</thead>
		<tbody id="<?php echo $table_name ?>">
		<?php
		global $current_user;

		$args = [
			'posts_per_page' => -1,
			'meta_key'       => 'todo_action_date',
			'orderby'        => 'meta_value',
			'order'          => 'asc',
			'post_type'      => 'imm-sale-todo',
			'meta_query'     => array(

				array(
					'relation' => 'OR',
					array(
						'key'     => 'todo_assigned_department',
						'value'   => $current_user->roles[0],
						'compare' => '='
					),
					array(
						'key'     => 'todo_assigned_user',
						'value'   => $current_user->ID,
						'compare' => '='
					),
				),

				array(
					'key'     => 'todo_status',
					'value'   => 1,
					'compare' => '=',
				)
			)

		];


		return_todo_table( $args );
		wp_reset_query();

		?>
		</tbody>
	</table>
<!--    <div class="text-center">-->
<!--        <button class="btn btn-brand text-center load-more-todos"-->
<!--                data-type="closed"-->
<!--                data-table="--><?php //echo $table_name; ?><!--"-->
<!--                data-user_role="--><?php //echo $current_user->roles[0]; ?><!--"-->
<!--                data-user_id="--><?php //echo $current_user->ID; ?><!--"-->
<!--                data-page="2"><i class="fa fa-plus"-->
<!--                                 aria-hidden="true"></i> --><?php //echo __( "Ladda fler" ); ?>
<!--        </button>-->
<!--    </div>-->
</div>
