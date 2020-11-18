<?php
/**
 * Partial for the price adjustment part of the steps.
 */
?>
<form action="" method="POST">

    <input type="hidden" name="handle-project-price-adjustments" value="true">
<!--
    <div style="display: none;">


        <div class="row" style="margin-top: 30px;">
            <?php /*$betal_methord = get_field('order_payment_method', $_GET['order-id']);
            $val_1 = "35% av orderbeloppet betalas i förskott efter erhållen delfaktura. Resterande belopp betalas mot slutfaktura efter utfört arbete.Delfakturan räknas på totala orderbeloppet utan ROTavdrag.  Faktureringsavgift 50 kr. ";
            $val_2 = "Betalning vid beställning, faktura 15 dagar. Fakturaavgift 50 kr";
            $val_3 = "Faktura 15 dagar. Fakturaavgift 50 kr Kreditkontroll obligatorisk, Personnr:";
            $val_4 = "Betalning sker via Ecster finansiering enligt separat avtal";
            $val_5 = "Delfakturering görs enligt överenskommen betalplan";
            $val_6 = "Faktura 30 dagar. Fakturaavgift 50 kr Kreditkontroll obligatorisk, org.nr:";
            $val_7 = "Betalas vid beställning. ";
            $val_8 = "Kortbetalning. ";
            */?>
            <div class="col-lg-6">


                <label for="payment_type"><strong><?php /*echo __("Välj betalningsvillkor"); */?></strong></label>
                <select id="payment_type" name="payment_type" class="form-control js-sortable-select">
                    <option value="<?php /*echo $val_1; */?>" <?php /*selected($betal_methord, $val_1); */?>><?php /*echo $val_1; */?></option>
                    <option value="<?php /*echo $val_2; */?>" <?php /*selected($betal_methord, $val_2); */?>><?php /*echo $val_2; */?></option>
                    <option value="<?php /*echo $val_3; */?>" <?php /*selected($betal_methord, $val_3); */?>><?php /*echo $val_3; */?></option>
                    <option value="<?php /*echo $val_4; */?>" <?php /*selected($betal_methord, $val_4); */?>><?php /*echo $val_4; */?></option>
                    <option value="<?php /*echo $val_5; */?>" <?php /*selected($betal_methord, $val_5); */?>><?php /*echo $val_5; */?></option>
                    <option value="<?php /*echo $val_6; */?>" <?php /*selected($betal_methord, $val_6); */?>><?php /*echo $val_6; */?></option>
                    <option value="<?php /*echo $val_7; */?>" <?php /*selected($betal_methord, $val_7); */?>><?php /*echo $val_7; */?></option>
                    <option value="<?php /*echo $val_8; */?>" <?php /*selected($betal_methord, $val_8); */?>><?php /*echo $val_8; */?></option>

                </select>


            </div>

        </div>

        <div class="col-lg-12" style="margin-top:20px;margin-bottom: 20px;">
            <?php /*include('reservationer.php'); */?>
        </div>

        <div class="col-lg-12" style="margin-top: 20px;margin-bottom: 20px;">
            <?php /*include('garanti_method.php'); */?>
        </div>
    </div>-->

    

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-4"><label
                    class='top-buffer-half'><?php echo __('Beskrivning *'); ?></label>
                <input type="text"
                       value=""
                       placeholder="Fyll i beskrivning"
                       class="form-control"
                       maxlength="50"
                       name="price_adjust[price_adjust_code]"
                       id="getvaluename" >
            </div>
            <div class="col-lg-3"><label
                        class='top-buffer-half'><?php echo __( 'Typ av justering' ); ?></label>

                <select class="form-control" name="price_adjust[price_adjust_product_id]">
                    <option value="<?php the_field('custom_price_adjust_material_product_id', 'options'); ?>"><?php echo __("Tillägg Material"); ?></option>
                    <option value="<?php the_field('custom_price_adjust_arbetet_product_id', 'options'); ?>"><?php echo __("Tillägg  Arbetskostnad"); ?></option>
                    <option value="<?php the_field('custom_price_adjust_negative_product_id', 'options'); ?>"><?php echo __("Avdrag Material"); ?></option>
                    <option value="<?php the_field('custom_price_adjust_product_id', 'options'); ?>"><?php echo __("Avdrag Arbetskostnad"); ?></option>
                </select>

            </div>
            <div class="col-lg-3"><label
                    class='top-buffer-half'><?php echo __('Kostnad inkl. moms'); ?></label>
                <input type="number"
                       min="1"
                       value=""
                       class="form-control"
                       name="price_adjust[price_adjust_amount]"
                       id="price_adjust_amount">
            </div>
           <div class="col-lg-2"><label
                        class='top-buffer-half'><?php echo __( 'Inköpspris' ); ?></label>
                <input type="number"
                       min="1"
                       value=""
                       class="form-control"
                       name="price_adjust[price_adjust_inkopprice]"
                       id="price_adjust_inkopprice">
            </div>

            <div class="col-lg-12">
                <button type="submit"
                        class="btn btn-beta top-buffer" id="lagsubmit" ><?php echo __( "Lägg till fler" ); ?></button>

            </div>

        </div>



        <div class='col-lg-12' style="margin-bottom: 40px;margin-top: 40px;">
            <div class="col-lg-12">
                <label for=""><strong>Rabattera produkt</strong></label>
            </div>


            <div class="col-lg-4">

                <select name="imm_sale_product_descount" id="imm_sale_product_descount" class="js-sortable-select">
                    <option value="none" selected disabled>Välj produkt</option>
                    <?php
                    foreach ($order->get_items() as $order_item_id => $item) {

                        $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
                        if ($product_id === 0) {
                            $title = $item["name"];

                        } else {
                            $title = null;

                        }


                        echo return_product_information_for_list_pi($product_id, $item, $item->get_quantity(), $title);



                    };

                    ?>
                </select>

            </div>
            <div class="col-lg-4">
                <input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="imm_sale_product_descount_value" name="imm_sale_product_descount_value" placeholder="Ange procent rabatt">
            </div>
            <div class="col-lg-4">
                <input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="imm_sale_product_amount_descount_value" name="imm_sale_product_amount_descount_value" placeholder="Ange rabatt inkl moms">
            </div>
            <div class="col-lg-4">
                <input type="button" value="Bekräfta" class="btn-brand submit_discount">
            </div>


        </div>
    </div>

</form>
