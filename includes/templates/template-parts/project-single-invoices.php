<table class="table">
    <thead>
        <tr>
            <th><?php echo __("Offertnummer"); ?></th>
            <th><?php echo __("Huvudprodukt"); ?></th>
            <th><?php echo __("Skapad datum"); ?></th>
            <th><?php echo __("Total"); ?></th>
            <th><?php echo __("Typ"); ?></th>
            <th><?php echo __("Status"); ?></th>
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
                    'compare' => 'NOT EXISTS'
                ),
                array('key' => 'order_accept_status',
                    'value' => array('false', '', 'Kundfråga', 'archieved', 'Acceptavkund'),
                    'compare' => 'IN',),
                array(
                    'key' => 'imm-sale_prepayment_invoice',
                    'compare' => 'NOT EXISTS'
                ),
            )
        );

        $orders = new WP_Query($args);
//        echo"<pre>";
//        print_r($orders);
        while ($orders->have_posts()) :
            $orders->the_post();
			    $productname ='';
            $order = new WC_Order(get_the_ID());

//            echo $order->ID;
            $current_user_role = get_user_role();
            $project_roles_steps = get_field('project_type-' . $current_user_role, 'option');

            $this_project_type = __("Hansa Offert");
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
            $confirmed_rot_percentage = get_post_meta($order->ID, 'confirmed_rot_percentage')[0];
            $status = get_post_meta($order->ID, 'order_accept_status')[0];
            $customrder = explode('-', $custom_order_number);
            $project_id = get_post_meta($order->ID, 'imm-sale_project_connection', true);
            $customerid = get_post_meta($project_id, 'invoice_customer_id', true);
            if ($customrder[0] == '0' || empty($customrder[0])) {
                $new_customer_order_number = $customerid . '-' . $project_id . '-' . $order->ID;
                update_post_meta($order->ID, 'custom_order_number', $new_customer_order_number);
            } else {
                $new_customer_order_number = $custom_order_number;
            }
            ?>

            <?php
            $order_id = $order->get_id();
            $order = new WC_Order($order_id);
            $productorder = wc_get_order($order_id);
            $items = $productorder->get_items();
            foreach ($items as $order_item_id => $item) {
                if (wc_get_order_item_meta($order_item_id, "HEAD_ITEM")) {
                    $productname = $item->get_name();
                    break;
                }
            }
            //   if ($project_type_id) {
//                if ($order->get_status() !== 'failed') {
	$project_statuss = get_post_meta($project->ID, 'imm-sale-project')[0];
				   $orderaccept = get_post_meta($order->get_id(), 'order_accept_status', true);
            ?>
            <tr>
			 
                <td>
                    <a href="<?=$order->get_id()?>" data-accept="<?=$orderaccept?>"  data-pstatus="<?=$project_statuss?>" class="btn-settings custom_mypop" data-order-id="<?=$order->get_id()?>"><?php echo __("Offert: ") . $new_customer_order_number; ?>
                    </a>
                </td>
               		 
                <td><?php echo $productname; ?></td>
               
                <td><?php echo $order->order_date ?></td>
                <?php if ($current_user_role == 'sale-sub-contractor') { ?>
                    <td><?php echo ""; ?></td>
                <?php } else { ?>
                    <td><?php echo wc_price($order->get_total()); ?></td>
                <?php } ?>
                <td><?php
                echo $project_name;
                ?>
                </td>
                <td><?php
                if ($status == 'false') {
                    echo 'Nekad av kund';
                } elseif ($status == 'Kundfråga') {
                    echo 'Kundfråga ';
                } elseif ($status == 'archieved') {
                    echo 'Arkiverad kopia';
                } elseif ($status == '') {
                    echo 'Väntar svar';
                } elseif ($status == 'Acceptavkund') {
                    echo 'Accepterad av kund';
                }
                ?></td>



            </tr>


            <?php
//                }
            //   }
            ?>
            <?php
			$orderaccept = '';
        endwhile;
        wp_reset_postdata();
        ?>



    </tbody>
</table>