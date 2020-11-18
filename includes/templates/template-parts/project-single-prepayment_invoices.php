<table class="table neworders">
    <thead>
    <tr>
        <th><?php echo __( "Fakturaunderlag" ); ?></th>
        <th><?php echo __( "Skapad datum" ); ?></th>
        <th><?php echo __( "Total" ); ?></th>
         <th><?php echo __( "Status" ); ?></th>
		 <th></th>
		
    </tr>
    </thead>
    <tbody>
	<?php
        $ParentOrder = array(
                    'orderby' => 'ID',
                    'post_type' => wc_get_order_types(),
                    'post_status' => array_keys(wc_get_order_statuses()),
                    'posts_per_page' => - 1,
                    'meta_query' => array(
                        array(
                            'key' => 'imm-sale_project_connection',
                            'value' => $project->ID,
                            'compare' => '='
                        )
                    )
                );
                $Porders = new WP_Query($ParentOrder);
                while ($Porders->have_posts()) :
                    $Porders->the_post();
                    $mainorder=get_the_ID();
                endwhile;
                wp_reset_postdata();
	$args = array(
		'orderby'        => 'ID',
		'order'=>'ASC',
		'post_type'      => wc_get_order_types(),
		'post_status' => array('wc-processing','wc-pending', 'wc-on-hold','wc-completed','wc-refunded','wc-cancelled'),
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'imm-sale_project_connection',
				'value'   => $project->ID,
				'compare' => '='
			),
			array(
				'key'     => 'imm-sale_prepayment_invoice',
				'value'   => true,
				'compare' => '='
			),
		)

	);

	$orders = new WP_Query( $args );
	
	while ( $orders->have_posts() ) :
	$orders->the_post();
	$order               = new WC_Order( get_the_ID() );
	$custom_order_number = get_post_meta( $order->ID, 'custom_order_number' )[0];
	$project_id =  get_post_meta($order->ID, 'imm-sale_project_connection', true);
	 $check_fort = explode(' ', get_post_meta($order->ID, 'invoice_percentage_totalamnt', true));
	//$parent_orderid=get_post_meta( $order->ID, 'imm-sale_parent_order',true );
	$typ=get_post_meta( $order->ID, 'invoice_percentage_totalamnt',true );
	       $customer_id = get_post_meta($project_id, "invoice_customer_id")[0];
		     $mainorder = get_post_meta(get_the_ID(), "imm-sale_parent_order")[0];
			 $send_date = get_post_meta(get_the_ID(),"send_date",true);
	?>
			<tr class="remove<?php the_ID();?>">
        <td>
		<?php if ($check_fort[1] != 'Förskottsfaktura') {	?>
			<p parent-order-id="<?php echo $mainorder;?>" data-order-id="<?php the_ID(); ?>" class="update_records1" style="padding: 0px 5px;"  href="javascript:void(0);"  ><?php echo $mainorder."-";the_ID(); ?>
</p>
		<?php } else { ?>
		<p  style="padding: 0px 5px;"  ><?php echo $mainorder."-";the_ID(); ?>
</p>	
		<?php }?>
        </td>
        <td><?php echo ($send_date)?$send_date:$order->order_date; ?></td>
        <td><?php echo $order->get_formatted_order_total();?></td>
		
        <td class="fortnox-status">
			<?php
			$fortnox_accept_status = get_post_meta(get_the_ID(), '_fortnox_order_synced',true);
 if ($check_fort[1] != 'Förskottsfaktura') { $class ="send-to-fortnox-prepayment1";	}else{ $class ="send-to-fortnox-prepayment"; } 
			if ( $fortnox_accept_status ) : ?>
             <p style="color:green" data-attr=<?php echo $class; ?>><?php echo __( "Har skickats" ); ?>
                </p>
			<?php else : ?>
                <a href="#" parent-order-id="<?php echo $mainorder;?>" data-order-id="<?php the_ID(); ?>"
                   class="<?php echo $class; ?>"><?php echo __( "Skicka till Fortnox" ); ?>
                </a>
			<?php endif; ?>

            

        </td>
		<td><?php echo $typ;?></td>
		<td style="display: inline-flex;">
		<a href="#" data-order-id="<?php the_ID(); ?>"  id="removeorder" ><i class="fa fa-trash" aria-hidden="true"></i></a>
		<?php if ($check_fort[1] != 'Förskottsfaktura') {	?>
		
		<a class="redigera_offert_verktyg" data_orderid="<?php the_ID(); ?>" data_current_user_id="<?php echo $customer_id; ?>" style="padding: 0px 8px;"  href="javascript:void(0);"  ><i class="fa fa-edit" aria-hidden="true"></i></a>
		<?php } 
		if ( $fortnox_accept_status ) : ?>
		<a parent-order-id="<?php echo $mainorder;?>" data-order-id="<?php the_ID(); ?>" class="tooltip <?php echo $class; ?>" style="padding: 0px 5px;"  href="javascript:void(0);"  ><i class="fa fa-refresh" aria-hidden="true"></i>
		<span class="tooltiptext">update this order in fortnox</span>
		</a>
			<?php endif; ?>
		</td>
		<?php endwhile;
		wp_reset_postdata();
		?>
    </tr>
    </tbody>
</table>