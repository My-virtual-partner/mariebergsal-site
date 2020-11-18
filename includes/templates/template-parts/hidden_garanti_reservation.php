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