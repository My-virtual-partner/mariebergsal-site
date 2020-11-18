<?php
/**
 * Container for the price adjustment part of the steps in project creation.
 */

$order = new WC_Order($_GET["order-id"]);
$order_summary_heading = get_field('order_summary_heading', $order->ID);
$order_summary_description = get_field('order_summary_description', $order->ID);

if (!$order_summary_description) {
    $order_summary_description = get_field('order_summary_description', 'options');
}

?>
<input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET["order-id"]; ?>">


<form action="" method="POST">

    <input type="hidden" name="handle-project-price-adjustments" value="true">


 <!--  we add this hidden div with garanti,reservatio,etc just to make sure that they will be included in the order-->
 <?php /*
    <div style="display: none;">


        <div class="row" style="margin-top: 30px;">
            <?php $betal_methord = get_field('order_payment_method', $_GET['order-id']);
            $val_1 = "35% av orderbeloppet betalas i förskott efter erhållen delfaktura. Resterande belopp betalas mot slutfaktura efter utfört arbete.Delfakturan räknas på totala orderbeloppet utan ROTavdrag.  Faktureringsavgift 50 kr. ";
            $val_2 = "Betalning vid beställning, faktura 15 dagar. Fakturaavgift 50 kr";
            $val_3 = "Faktura 15 dagar. Fakturaavgift 50 kr Kreditkontroll obligatorisk, Personnr:";
            $val_4 = "Betalning sker via Ecster finansiering enligt separat avtal";
            $val_5 = "Delfakturering görs enligt överenskommen betalplan";
            $val_6 = "Faktura 30 dagar. Fakturaavgift 50 kr Kreditkontroll obligatorisk, org.nr:";
            $val_7 = "Betalas vid beställning. ";
            $val_8 = "Kortbetalning. ";
            ?>
            <div class="col-lg-6">


                <label for="payment_type"><strong><?php echo __("Välj betalningsvillkor"); ?></strong></label>
                <select id="payment_type" name="payment_type" class="form-control js-sortable-select">
                    <option value="<?php echo $val_1; ?>" <?php selected($betal_methord, $val_1); ?>><?php echo $val_1; ?></option>
                    <option value="<?php echo $val_2; ?>" <?php selected($betal_methord, $val_2); ?>><?php echo $val_2; ?></option>
                    <option value="<?php echo $val_3; ?>" <?php selected($betal_methord, $val_3); ?>><?php echo $val_3; ?></option>
                    <option value="<?php echo $val_4; ?>" <?php selected($betal_methord, $val_4); ?>><?php echo $val_4; ?></option>
                    <option value="<?php echo $val_5; ?>" <?php selected($betal_methord, $val_5); ?>><?php echo $val_5; ?></option>
                    <option value="<?php echo $val_6; ?>" <?php selected($betal_methord, $val_6); ?>><?php echo $val_6; ?></option>
                    <option value="<?php echo $val_7; ?>" <?php selected($betal_methord, $val_7); ?>><?php echo $val_7; ?></option>
                    <option value="<?php echo $val_8; ?>" <?php selected($betal_methord, $val_8); ?>><?php echo $val_8; ?></option>

                </select>


            </div>

        </div>

        <div class="col-lg-12" style="margin-top:20px;margin-bottom: 20px;">
            <?php include('reservationer.php'); ?>
        </div>

        <div class="col-lg-12" style="margin-top: 20px;margin-bottom: 20px;">
            <?php include('garanti_method.php'); ?>
        </div>
    </div>
  * 
  */?>
 

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-3"><label
                        class='top-buffer-half'><?php echo __('Beskrivning'); ?></label>


                <select class="form-control js-sortable-select" name="price_adjust[price_adjust_code]">
                   
                    <option value="Sotarbesiktning"><?php echo __("Sotarbesiktning"); ?></option>
					 <option value="Parkettläggning"><?php echo __("Parkettläggning"); ?></option>
                    <option value="Betonghåltagning"><?php echo __("Betonghåltagning"); ?></option>
                    <option value="Papptätning tak"><?php echo __(" Papptätning tak"); ?></option>
                    <option value="Snickeriarbeten"><?php echo __("Snickeriarbeten"); ?></option>
                    <option value="Plåtarbeteten"><?php echo __("Plåtarbeteten"); ?></option>
                    <option value="Elarbeten"><?php echo __("Elarbeten"); ?></option>
                    <option value="Måleriarbeten"><?php echo __("Måleriarbeten"); ?></option>
                    <option value="Rörmokeriarbeten"><?php echo __("Rörmokeriarbeten"); ?></option>

                </select>

            </div>
            <div class="col-lg-4" style="padding: 0;"><label
                        class='top-buffer-half'><?php echo __('Typ av justering'); ?></label>

                <select class="form-control" name="price_adjust[price_adjust_product_id]">
				<option value="<?php the_field('custom_price_adjust_arbetet_product_id_utan_rot', 'options'); ?>"><?php echo __("Tillägg Arbetskostnad utan ROT"); ?></option>
                    <option value="<?php the_field('custom_price_adjust_material_product_id', 'options'); ?>"><?php echo __("Tillägg Material"); ?></option>
                    <option value="<?php the_field('custom_price_adjust_arbetet_product_id', 'options'); ?>"><?php echo __("Tillägg  Arbetskostnad"); ?></option>
                    
                    <option value="<?php the_field('custom_price_adjust_negative_product_id', 'options'); ?>"><?php echo __("Avdrag Material"); ?></option>
                    <option value="<?php the_field('custom_price_adjust_product_id', 'options'); ?>"><?php echo __("Avdrag Arbetskostnad"); ?></option>
                    <option value="<?php the_field('custom_price_adjust_arbetet_product_id_utan_rot_negative', 'options'); ?>"><?php echo __("Avdrag Arbetskostnad utan ROT"); ?></option>

                </select>

            </div>
            <div class="col-lg-3"><label
                        class='top-buffer-half'><?php echo __('Kostnad inkl. moms'); ?></label>
                <input type="number"
                       min="1"
                       value=""
                       class="form-control"
                       name="price_adjust[price_adjust_amount]"
                       id="">
            </div>
            
            <div class="col-lg-2"><label
                        class='top-buffer-half'><?php echo __( 'Inköppris' ); ?></label>
                <input type="number"
                       min="1"
                       value=""
                       class="form-control"
                       name="price_adjust[price_adjust_inkopprice]"
                       id="price_adjust_inkopprice">
            </div>

            <div class="col-lg-12">
                <button type="submit"
                        class="btn btn-beta top-buffer"><?php echo __("Lägg till fler"); ?></button>

            </div>

        </div>


    </div>

</form>

