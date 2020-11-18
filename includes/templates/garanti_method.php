<?php $garanti_methord = get_field('order_garanti_method',$_GET['order-id']);
$val_1 ="Ett problem har uppstått under garantitiden. Enligt överenkommelse kommer vi att göra en kontroll av installationen och åtgärda eventuella brister. Konstateras det att bristerna inte beror på fabrikationsneller installationsfel kommer kostnad för åtgärderna att debiteras enligt vår normala servicetaxa om 675kr per timme, material. Detsamma gäller om ytterligare arbeten önskas utförda när vi ändå är på plats. Ev. kostnad är Rot-avdragsgrundande enligt RSV regler.";
$val_2 ="Tio års garanti lämnas på skorstenstätning";
$val_3 ="Standard text";
$val_4 ="Ingen garanti";
$val_5 ="10 års funktionsgaranti gäller för alla utförda arbeten och installationer
Garantitid för fabrikationsfel på produkter följer tillverkarens villkor. 
Servicegaranti Vi garanterar alltid att din service och montage utförs fackmannamässigt.
För detaljerad information om garantier, läs mer på <a target='_blank' href='https://mariebergs.com/vara-garantivillkor'>mariebergs.com/vara-garantivillkor</a>
";



    ?>

    <label for="garanti_type"><strong><?php echo __("Garanti"); ?></strong></label>
    <select id="garanti_type" name="garanti_type" class="form-control js-sortable-select">

        <option value="<?php echo $val_5; ?>" <?php selected( $garanti_methord, $val_5 ); ?>><?php echo $val_5; ?></option>
        <option value="<?php echo $val_1; ?>" <?php selected( $garanti_methord, $val_1 ); ?>><?php echo $val_1; ?></option>
        <option value="<?php echo $val_2; ?>" <?php selected( $garanti_methord, $val_2 ); ?>><?php echo $val_2; ?></option>
        <!--<option value="<?php //echo $val_3; ?>" <?php //selected( $garanti_methord, $val_3 ); ?>><?php //echo $val_3; ?></option>-->
        <option value="<?php echo $val_4; ?>" <?php selected( $garanti_methord, $val_4 ); ?>><?php echo $val_4; ?></option>



    </select>

