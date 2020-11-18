<table class="table">
    <thead>
        <tr>
            <th><?php echo __("Ordernummer "); ?></th>
            <th><?php echo __("Huvudprodukt"); ?></th>
            <th><?php echo __("Skapad datum"); ?></th>
            <th><?php echo __("Total"); ?></th>
            <th><?php echo __("Typ"); ?></th>
            <th><?php echo __("Betalningstyp"); ?></th>
            <th><?php echo __("Betalningsvillkor"); ?></th>
            <th></th>


        </tr>
    </thead>
    <tbody>
        <?php
        $args = array(
            'orderby' => 'ID',
            'post_type' => wc_get_order_types(),
            'post_status' => array('wc-processing', 'wc-pending', 'wc-on-hold', 'wc-completed', 'wc-refunded', 'wc-cancelled'),
            'posts_per_page' => - 1,
            'meta_query' => array(
                array(
                    'key' => 'imm-sale_project_connection',
                    'value' => $project->ID,
                    'compare' => '='
                ), array(
                    'key' => 'imm-sale_converted_to_order',
                    'value' => 1,
                    'compare' => '='
                ),
                array(
                    'key' => 'order_accept_status',
                    'value' => 'true',
                    'compare' => '='
                ),
                array(
                    'key' => 'imm-sale_prepayment_invoice',
                    'compare' => 'NOT EXISTS'
                ),
            )
        );



        $orders = new WP_Query($args);
//echo "<pre>"; print_r($orders);
        while ($orders->have_posts()) :
            $orders->the_post();
			$productname = '';
            $order = new WC_Order(get_the_ID());
            $current_user_role = get_user_role();

            $project_roles_steps = get_field('project_type-' . $current_user_role, 'option');

            $this_project_type = __("Ej tillgängligt");
            $project_type_id = get_post_meta($order->ID, 'order_project_type');
            if ($project_type_id[0] == 'fireplace_with_assembly') {
                $project_name = 'Eldstad inklusive montage';
            } elseif ($project_type_id[0] == 'hem_visit_sale_system') {
                $project_name = 'Hembesök';
            } elseif ($project_type_id[0] == 'service') {
                $project_name = 'Service och reservdelar';
            } elseif ($project_type_id[0] == 'accesories') {
                $project_name = 'Kassa';
            } elseif ($project_type_id[0] == 'changes_and_new_work') {
                $project_name = 'ÄTA';
            } elseif ($project_type_id[0] == 'self_builder') {
                $project_name = 'Självbyggare';
            } elseif ($project_type_id[0] == 'hansa_offert_for_old_offert') {
                $project_name = 'Specialoffert';
            } elseif ($project_type_id[0] == 'solcellspaket') {
                $project_name = 'Solcellspaket';
            }
            $custom_order_number = get_post_meta($order->ID, 'custom_order_number')[0];
            $typ = get_post_meta($order->ID, 'invoice_percentage_totalamnt', true);
            $confirmed_rot_percentage = get_post_meta($order->ID, 'confirmed_rot_percentage')[0];
            $payment_type = get_post_meta(get_the_ID(), 'order_status_betainingstyp1')[0];
             $getpayment = $paymenttypeSearch = paytemMethod();
            $paymenttetm = $paymenttypeSearch[$payment_type];

            $customrder = explode('-', $custom_order_number);
            $project_id = get_post_meta($order->ID, 'imm-sale_project_connection', true);
            $customerid = get_post_meta($project_id, 'invoice_customer_id', true);
//            echo $customerid;
//            echo $project_id;die;
            if ($customrder[0] == '0' || empty($customrder[0])) {
                $new_customer_order_number = $customerid . '-' . $project_id . '-' . $order->ID;
                update_post_meta($order->ID, 'custom_order_number', $new_customer_order_number);

//                echo $new_customer_order_number;
            } else {
                $new_customer_order_number = $custom_order_number;
            }
//            $order_id = $order->get_id();
            $productorder = wc_get_order($order->get_id());
            $items = $productorder->get_items();
            foreach ($items as $order_item_id => $item) {
                if (wc_get_order_item_meta($order_item_id, "HEAD_ITEM")) {
                    $productname = $item->get_name();
                    break;
                }
				
            }
            $order_accept = get_post_meta($order->get_id(), "order_accept_status")[0];
            $order_step='https://mariebergsalset.com/system-dashboard/order-steps?order-id='.$order->get_id().'&step=0';
							 	$project_statuss = get_post_meta($project->ID, 'imm-sale-project')[0];
            ?>
            <tr>
               <td>
                    <a href="<?=$order->get_id()?>" data-accept="true"  data-pstatus="<?=$project_statuss?>" class="btn-settings custom_mypop"><?php echo $new_customer_order_number; ?>
                    </a>
                </td>
				 
                <td><?php echo $productname; ?></td>
                <td><?php
        
        if ($order_accept == 'true') {
            $order_date = get_post_meta($order->get_id(), 'order_accept_date', true);
            if (empty($order_date)) {
                $order_date = $order->order_date;
            }
        } else {
            $order_date = $order->order_date;
        }
        echo $order_date;
            ?></td>
                    <?php if ($current_user_role == 'sale-sub-contractor') { ?>
                    <td></td>
                <?php } else { ?>
                    <td><?php echo wc_price($order->get_total()); ?></td>
                <?php } ?>
                <td><?php
                echo $project_name;
                ?>
                </td>
                <td>
    <?php if ($paymenttetm) echo $paymenttetm; ?>

                </td>
                <td><?php
                $getprder = get_post_meta(get_the_ID(), 'order_payment_method', true);
                echo get_payment_term($getprder);
    ?></td>

                <?php if ($current_user_role != 'sale-sub-contractor') { ?>
                    <td>
                        <?php
					
                        if (array_key_exists($payment_type, $paymenttypeSearch)) {
                            // $prepayed_invoice_created = get_post_meta($order->ID, 'imm-sale_prepayment_invoice_created')[0];
                            $prepayed_invoice_created = get_post_meta($order->ID, 'created_invoice_form')[0];
                            ?>
                            <?php if ($prepayed_invoice_created) : ?>
                                <p  id="newinvoice" style="display:none; color: #ff5912; cursor: pointer;" 
                                    class="btn-settings toggle-prepayment-invoice-modal"
                                    data-order-id="<?php echo $order->get_id(); ?>" data-project-id="<?php echo $project_id; ?>"><?php echo __("Skapa fakturaunderlag"); ?>
                                </p>

                                <p id="newinvoice" ><?php echo __("Fakturaunderlag skapat"); ?></p>

                            <?php else : ?>
                                <a href="<?php echo $order->get_id(); ?>"
                                   class="btn-settings toggle-prepayment-invoice-modal"
                                   data-order-id="<?php echo $order->get_id(); ?>" data-project-id="<?php echo $project_id; ?>"><?php echo __("Skapa fakturaunderlag"); ?>
                                </a>
                            <?php endif;
                        }
                        ?>
                    </td>
                <?php } ?>

                <td><?php
                    if (array_key_exists($payment_type, $getpayment)) {
                        echo $typ;
                    }
                    ?></td>
                <?php if ($prepayed_invoice_created) : ?>
                    <td><a id="createinvoiced" href="javascript:void(0)">Skapa igen</a></td>
                <?php endif; ?>

                <?php
				
            endwhile;
            wp_reset_postdata();
            ?>

        </tr>
    </tbody>
</table>