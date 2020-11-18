<?php
/**
 * Form to create a new customer.
 */
$order = wc_get_order($_GET["order-id"]);
if ($order) {
    $current_customer_id = $order->get_customer_id();
}
if (isset($_GET["lead-id"])) {
    $lead = get_post($_GET["lead-id"]);
    $lead_id = $_GET["lead-id"];
}
//$customers = get_users( 'orderby=nicename&role=customer' );
$customers = get_users('orderby=nicename');
$disable = true;
?>
<?php if (!$order) : ?>
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
          rel = "stylesheet">

    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript">
        jQuery(function() {
        jQuery("input#first_name_user").autocomplete({
        source: [
    <?php foreach ($customers as $customer) {
        ?>
            { label: '<?php echo get_user_meta($customer->ID, 'billing_company', true) . ' - ' . getCustomerName($customer->ID); ?>', value: '<?php echo $customer->first_name; ?>' },
    <?php } ?>
        ]
        });
//        jQuery("input#last_name_user").autocomplete({
//        source: [
//    <?php // foreach ($customers as $customer) { ?>
//            { label: "<?php // echo ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . $customer->first_name . " " . $customer->last_name; ?>", value: "<?php echo $customer->last_name; ?>" },
//    <?php // } ?>
//        ]
//        });
        jQuery("input#phone_number_user").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->billing_phone . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . getCustomerName($customer->ID). ")"; ?>", value: "<?php echo $customer->billing_phone; ?>" },
    <?php } ?>
        ]
        });
        jQuery("input#customer_phone_2").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->customer_phone . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . getCustomerName($customer->ID) . ")"; ?>", value: "<?php echo $customer->customer_phone; ?>" },
    <?php } ?>
        ]
        });
        jQuery("input#customer_email").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->user_email . " - " . getCustomerName($customer->ID); ?>", value: "<?php echo $customer->user_email; ?>" },
    <?php } ?>
        ]
        });
        jQuery("input#customer_individual_organisation_number").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->customer_individual_organisation_number . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . showName($customer->ID). ")"; ?>", value: "<?php echo $customer->customer_individual_organisation_number; ?>" },
    <?php } ?>
        ]
        });
        jQuery("input#customer_company").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->billing_company . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . showName($customer->ID) . ")"; ?>", value: "<?php echo $customer->billing_company; ?>" },
    <?php } ?>
        ]
        });
        jQuery("input#customer_address").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->billing_address_1 . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . showName($customer->ID) . ")"; ?>", value: "<?php echo $customer->billing_address_1; ?>" },
    <?php } ?>
        ]
        });
        jQuery("#customer_address_2").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->billing_address_2 . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . showName($customer->ID) . ")"; ?>", value: "<?php echo $customer->billing_address_2; ?>" },
    <?php } ?>
        ]
        });
        jQuery("#customer_postal_number").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->billing_postcode . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . showName($customer->ID) . ")"; ?>", value: "<?php echo $customer->billing_postcode; ?>" },
    <?php } ?>
        ]
        });
        jQuery("#customer_kontaktperson").autocomplete({
        source: [
    <?php foreach ($customers as $customer) { ?>
            { label: "<?php echo $customer->customer_kontaktperson . " - (" . ucfirst(get_user_meta($customer->ID, 'billing_company', true)) . " - " . showName($customer->ID) . ")"; ?>", value: "<?php echo $customer->customer_kontaktperson; ?>" },
    <?php } ?>
        ]
        });
        });
    </script>
    <div class=" col-lg-12 steps-page">
        <div class='row'>

            <div class='col-lg-12 create_new_customer'>
                <div class='checkbox'>
                    <label><input type='checkbox' checked name='create_new_customer' id='create_new_customer'
                                  value='create_new_customer'><?php echo __("Skapa ny kund"); ?></label>
                </div>
            </div>

        </div>



        <div class='select-customer'>

            <label class='top-buffer-half' for='customer'> <?php echo __("Välj kund"); ?> </label>
            <select name='customer' class='form-control js-sortable-select' id='customer' >
                <option selected disabled value=''> <?php echo __("Ingen kund vald"); ?>.</option>
    <?php
    foreach ($customers as $customer) {
        if ($current_customer_id == $customer->ID) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        echo "<option " . $selected . " value='" . $customer->ID . "'> " . $customer->ID . " - " . $customer->user_email . " - " . showName($customer->ID) . "</option>";
    }
    wp_reset_query();
    ?>

            </select>
        </div>


    </div>
            <?php endif; ?>
<div class=' col-lg-12 steps-page create-new-customer'>

    <div class="tab-content">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab"
                                  href="#tab_customer_information"><?php echo __("Kundinformation"); ?></a></li>
            <li><a data-toggle="tab" href="#tab_customer_delivery_address"><?php echo __("Leveransadress") ?></a></li>
            <li><a data-toggle="tab" href="#tab_lead_info"><?php echo __("Lead Info") ?></a></li>
        </ul>
        <div id="tab_customer_information" class="row tab-pane fade in active">

            <div class=' col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_first_name'><?php echo __('Namn / Företagsnamn'); ?> </label>
                <input  type='text'
                        value="<?php
            if ($lead) {
                echo get_post_meta($lead->ID, 'lead_first_name')[0];
            } else {
                echo showName($current_customer_id);
            }
            ?>"  class='form-control'
                        name='customer_first_name' id='first_name_user'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='reference_name'><?php echo __('Referens'); ?></label>
                <input type='text' value="<?php
             echo get_user_meta($current_customer_id, 'reference_name')[0];
            ?>" class='form-control' name='reference_name' id='reference_name'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_phone'><?php echo __('Telefonnummer'); ?></label>
                <input type='text' value="<?php
            if ($lead) {
                echo get_post_meta($lead->ID, 'lead_phone')[0];
            } else {
                echo get_user_meta($current_customer_id, 'billing_phone')[0];
            }?>"  class='form-control validphone'
			name='customer_phone'
                       id='phone_number_user'>
            </div> <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_phone_2'><?php echo __('Telefonnummer 2'); ?></label>
                <input type='text' value="<?php
                if ($lead) {
                    echo get_post_meta($lead->ID, 'lead_phone')[0];
                } else {
                    echo get_user_meta($current_customer_id, 'billing_phone_2')[0];
                }
            ?>" 			class='form-control validphone2'
                       name='customer_phone_2 '
                       id='customer_phone_2'>
            </div>
            <div class='col-lg-6 customeremail'>
                <label class='top-buffer-half'
                       for='customer_email'><?php echo __('E - post'); ?><span style="color: red"> *</span></label>
                <input required type='email' pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php
                       if ($lead) {
                           echo get_post_meta($lead->ID, 'lead_email')[0];
                       } else {
                           echo get_user_meta($current_customer_id, 'billing_email')[0];
                       }
                       ?>"  class='form-control'
                       name='customer_email'  id='customer_email'>
                
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_individual_organisation_number'><?php echo __('Personnummer / Organisationsnummer'); ?></label>
                <input type='text'
                       value="<?php echo get_user_meta($current_customer_id, 'customer_individual_organisation_number')[0] ?>"
                       class='form-control'
                       name='customer_individual_organisation_number'
                       id='customer_individual_organisation_number'>
            </div>
            
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='email_communication'><?php echo __('E-post för kommunikation'); ?><span style="color: red"></span></label>
                <input type='text' value="<?php
                if ($lead) {
                    echo get_post_meta($lead->ID, 'lead_email')[0];
                } else {
                    echo get_user_meta($current_customer_id, 'customer_email_communication')[0];
                }
                ?>" class='form-control'
                       name='email_communication'  id='email_communication' data-role="tagsinput">

            </div>
            
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='invoice_email'><?php echo __('E-post för faktura'); ?><span style="color: red"></span></label>
                <input type='text' value="<?php
                if ($lead) {
                    echo get_post_meta($lead->ID, 'lead_email')[0];
                } else {
                    echo get_user_meta($current_customer_id, 'fortnox_invoice_email')[0];
                }
                ?>"class='form-control'
                       name='invoice_email'  id='invoice_email' data-role="tagsinput">

            </div>
            
             <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='vat_number'><?php echo __('VAT nummer vid omvänd byggmoms'); ?></label>
                <input id="vat_number"  type="text" value="<?php echo get_user_meta($current_customer_id, 'vat_number')[0]; ?>" name="vat_number"/>
            </div>
            <div class="exist_email"></div>
            
            <?php /*
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_company'><?php echo __('Företag'); ?></label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'billing_company')[0] ?>"
                       class='form-control'
                       name='customer_company' id='customer_company'>
            </div>
             * 
             */?>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_address'><?php echo __('Adress'); ?></label>
                <input type='text' value="<?php if ($lead) {
                    echo get_post_meta($lead->ID, 'lead_customer_levernadress', true);
                } else {
                    echo get_user_meta($current_customer_id, 'billing_address_1')[0];
                }
                       ?>"
                       class='form-control'
                       name='customer_address' id='customer_address'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_address_2'><?php echo __('Adress 2'); ?></label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'billing_address_2')[0] ?>"
                       class='form-control'
                       name='customer_address_2' id='customer_address_2'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_postal_number'><?php echo __('Postnummer'); ?></label>
                <input type='text' value="<?php
                if ($lead) {
                    echo get_post_meta($lead->ID, 'lead_postnummer')[0];
                } else {
                    get_user_meta($current_customer_id, 'billing_postcode')[0];
                }
                       ?>" class='form-control'
                       name='customer_postal_number' id='customer_postal_number'maxlength="9">
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_city'><?php echo __('Postort'); ?></label>
                <input type='text' value="<?php
                if ($lead) {
                    echo get_post_meta($lead->ID, 'lead_city')[0];
                } else {
                    echo get_user_meta($current_customer_id, 'billing_phone')[0];
                }
                       ?>"                   class='form-control'
                       name='customer_city'
                       id='customer_city'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_kontaktperson'><?php echo __('Kontaktperson'); ?></label>
                <input type='text'
                       value="<?php echo get_user_meta($current_customer_id, 'customer_kontaktperson')[0] ?>"
                       class='form-control'
                       name='customer_kontaktperson'
                       id='customer_kontaktperson'>
            </div>
            <div class=' col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_company_private'><?php echo __('Företag/Privatperson'); ?> </label>
                <select name="customer_company_private" id="customer_company_private"
                        class="js-sortable-select">
                            <?php
                            $custemer_meta_private_company = get_user_meta($current_customer_id, 'customer_company_private')[0];
                            if ($custemer_meta_private_company === 'Företag') {
                                echo '<option value="Företag" selected>Företag</option>';
                                echo '<option value="Privatperson">Privatperson</option>';
                            } else {
                                echo '<option value="Privatperson" selected>Privatperson</option>';
                                echo '<option value="Företag" >Företag</option>';
                            }
                            ?>


                </select>

            </div>
            <div class=' col-lg-6'>


                <label class='top-buffer-half' for='user_kontakt_person'>Ansvarig säljare </label>

                <select name="user_kontakt_person" id="user_kontakt_person" class='js-sortable-select'>

                    <?php
                    $args = array(
                        'role__in' => array(
                            'sale-salesman',
                            'sale-administrator',
                            'sale-project-management',
                            'sale-economy',
                        /*     'sale-technician',

                          'sale-sub-contractor' */
                        )
                    );
                    if ($lead_id) {

                        $current_customer_id = get_field('lead_salesman', $lead_id);
                        $loginid = $current_customer_id;
                        $usering = get_userdata($loginid);
                    } else {
                        $loginid = get_current_user_id();
                        $usering = get_userdata($loginid);
                    }
                    $users = get_users($args);

                    $user_roles = $usering->roles;
                    if (!empty(get_user_meta($current_customer_id, 'user_kontakt_person')[0])) {

                        if ($lead_id) {
                            $user_kontakt_person = $current_customer_id;
                        } else {
                            $user_kontakt_person = get_user_meta($current_customer_id, 'user_kontakt_person')[0];
                        }
                    } elseif (in_array('sale-project-management', $usering->roles) || in_array('sale-economy', $usering->roles) || in_array('sale-salesman', $usering->roles) || in_array('sale-administrator', $usering->roles)) {
                        $user_kontakt_person = $loginid;
                    }


                    foreach ($users as $user) :
                        $salesman = get_userdata($user->ID);
                        ?>

                        <option value='<?php echo $salesman->ID ?>' <?php $selected = selected($user_kontakt_person, $salesman->ID); ?>><?php echo showName($salesman->ID) ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
                    <?php //echo $current_customer_id; echo "<pre>";print_r($users);?>
            </div>
            <div class='col-lg-12'>
                <label class='top-buffer-half'
                       for='customer_other'><?php echo __('Övrigt'); ?></label>
                <textarea class='form-control' rows='5' name='customer_other'
                          id='customer_other'><?php
                    if ($lead) {
                        echo get_post_meta($lead->ID, 'lead_other')[0];
                    } else {
                        echo get_user_meta($current_customer_id, 'customer_other')[0];
                    }
                    ?>
                </textarea>
				<span id="errormsg" style="    color: #ff5e00;"></span>
            </div>
        </div>
        <div id="tab_customer_delivery_address" class="row tab-pane fade">


            <div class=' col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_first_name'><?php echo __('Förnamn'); ?> </label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'shipping_first_name')[0] ?>"
                       class='form-control'
                       name='shipping_first_name' id='shipping_first_name'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_last_name'><?php echo __('Efternamn'); ?></label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'shipping_last_name')[0] ?>"
                       class='form-control'
                       name='shipping_last_name' id='shipping_last_name'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_contact_number'><?php echo __('Aviseringsnummer'); ?></label>
                <input type='text'
                       value="<?php echo get_user_meta($current_customer_id, 'shipping_contact_number')[0] ?>"
                       class='form-control'
                       name='shipping_contact_number' id='shipping_contact_number'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_address'><?php echo __('Adress'); ?></label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'shipping_address_1')[0] ?>"
                       class='form-control'
                       name='shipping_address' id='shipping_address'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_address_2'><?php echo __('Adress 2'); ?></label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'shipping_address_2')[0] ?>"
                       class='form-control'
                       name='shipping_address_2' id='shipping_address_2'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_postal_number'><?php echo __('Postnummer'); ?></label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'shipping_postcode')[0] ?>"
                       class='form-control'
                       name='shipping_postal_number' id='shipping_postal_number' maxlength="9">
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_city'><?php echo __('Postort'); ?></label>
                <input type='text' value="<?php echo get_user_meta($current_customer_id, 'shipping_city')[0] ?>"
                       class='form-control'
                       name='shipping_city'
                       id='shipping_city'>
            </div>
        </div>
        <div id="tab_lead_info" class="row tab-pane fade">


            <div class=' col-lg-12'>
                <?php include_once('lead-form.php'); ?>
            </div></div>
    </div>



</div>

	
<script>
jQuery(document).ready(function(){
	function valiPhone(number){
		var getCode = number.substring(0, 3);

if(getCode == '+46'){
jQuery("#errormsg").html('Please remove the country code ('+getCode+') from Telefonnummer field');
	return false;
}else{
jQuery("#errormsg").empty();
	return true;
}

	}
	jQuery('input.create_project_btn').on('click',function(){
var number = jQuery('input.form-control.validphone').val().trim();
var number2 = jQuery('input.validphone2').val().trim();

if(valiPhone(number) && valiPhone(number2)){
	return true;
}else{
	return false;
}


	}); 	});
	</script>
	
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js
"></script>