<?php include($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
?>
<div class="order_printable_area" style="">
    
        <div class="col-md-12">
            <img src="/wp-content/uploads/2018/07/Mariebergs-Logo-Svart-ny.png" alt="" class="center-block"
                 style="margin:auto;margin-bottom: 20px;max-width: 350px;height:auto; display:block;">
            <br>

        </div>

        <?php
        $order_id=$_GET['order-id'];
//        echo $order_id;
        $order = new WC_Order($order_id);
//        print_r($order);die;
        $project_id = get_post_meta($order_id, 'imm-sale_project_connection', true);
        $order_data = $order->get_data();
//        print_r($order_data);
        $order_total_price = $order->get_total();
        if (get_field('imm-sale-tax-deduction', $order->get_id())) {
            $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
            $display_price = $order_total_price - $rot_avdrag;
        } else {
            $rot_avdrag = 0;
            $display_price = $order_total_price;
        }
//        $order = new WC_Order($order->get_id());
        $order_date = $order->order_date;
        $date = date("Y-m-d", strtotime($order_date));
        $time = date("H:i:s", strtotime($order_date));
        $kassavitto_date = new DateTime($date);
        $result = $kassavitto_date->format('Ymd');
        $Kassakvittonummer = $result . '-' . $order_id;
        ?>
        <table class="table table-striped" style="margin-top: 25px;width: 100%;max-width: 100%;margin-bottom: 20px;">
            <div><span><strong>Datum</strong>: <?php echo $date; ?></span> 
                <span class="cash_recipt" style="float:right"><strong>Kassakvittonummer</strong>: <?php echo $Kassakvittonummer; ?></span></div>
            <div><strong>Tid</strong>: <?php echo $time; ?></div>


            <tr class="tbl_hdng" style="background-color: #f9f9f9;">
                <th style="text-align:left; float:left;">Produkt</th>
                <th style="text-align:right;">Pris</th>
            </tr>
            <?php
            foreach ($order->get_items() as $order_item_id => $item) {

                $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
                //if (wc_get_order_item_meta($order_item_id, "HEAD_ITEM")) {

                $productqty = return_product_information_list_print($product_id, $item, $item->get_quantity());
                ?>
                <tr><td colspan="2"><?php echo $productqty; ?>
                </tr>

            <?php };
            ?>
            <tr>
                <td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Momssats: "); ?></strong>
                </td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;">25%
                </td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Summa ex moms: "); ?></strong>
                </td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;"><?php echo wc_price($order->get_total() - $order->get_total_tax()); ?>
                </td>
            </tr>
            <tr><td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Moms: "); ?></strong></td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;"><?php echo wc_price($order->get_total_tax()); ?></tr>
            <tr style="background-color: #f9f9f9;"><td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Totalsumma: "); ?></strong></td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;"><?php echo wc_price($display_price); ?></tr>
        </table>

        <div class="col-md-12">
            <img src="/wp-content/uploads/2018/07/Mariebergs-Logo-Svart-ny.png" alt="" class="center-block"
                 style="margin:auto;margin-bottom: 20px;max-width: 350px;height:auto; display:block;">


        </div>
        <div class="address" style="text-align: center;">
            <?php
            $office_connection = get_post_meta($project_id, 'office_connection')[0];
//            print_r($office_connection);
            $organization = get_field('organisation_no', $office_connection);
            $content_post = get_post($office_connection);
            $content = $content_post->post_content;
            ?>
            <h4 style="margin:0;line-height:18px"><strong>Org. nr:<?php echo $organization; ?></strong></h4>
            <span><?php echo $content;?></span><br>
        </div>
        <div class="footer_txt" style="text-align: center;">
            <h4 style="line-height:18px;font-size:15px"><strong>Tack För ditt köp!</strong></h4>
            <h4 style="line-height:18px;font-size:15px"><strong>Välkommen åter!</strong></h4>
        </div>

        
    </div>