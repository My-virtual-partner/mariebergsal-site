<?php
/**
 * Template used to edit customer information
 * URL PATH: $_SERVER['REQUEST_URI'], '/customer-edit'
 */
include_once(plugin_dir_path(__FILE__) . 'head.php');

$current_customer_id = $_GET["customer-id"];
$customers = get_userdata($current_customer_id);
if (get_user_meta($current_customer_id, 'shipping_first_name', true))
    $firstname = get_user_meta($current_customer_id, 'shipping_first_name', true);
else
    $firstname = get_user_meta($current_customer_id, 'billing_first_name', true);

if (get_user_meta($current_customer_id, 'shipping_last_name', true))
    $lname = get_user_meta($current_customer_id, 'shipping_last_name', true);
else
    $lname = get_user_meta($current_customer_id, 'billing_last_name', true);

if (get_user_meta($current_customer_id, 'shipping_contact_number', true))
    $contact_number = get_user_meta($current_customer_id, 'shipping_contact_number', true);
else
    $contact_number = get_user_meta($current_customer_id, 'billing_phone', true);

if (get_user_meta($current_customer_id, 'shipping_address_1', true))
    $address_1 = get_user_meta($current_customer_id, 'shipping_address_1', true);
else
    $address_1 = get_user_meta($current_customer_id, 'billing_address_1', true);

if (get_user_meta($current_customer_id, 'shipping_address_2', true))
    $address_2 = get_user_meta($current_customer_id, 'shipping_address_2', true);
else
    $address_2 = get_user_meta($current_customer_id, 'billing_address_2', true);

if (get_user_meta($current_customer_id, 'shipping_postcode', true))
    $postcode = get_user_meta($current_customer_id, 'shipping_postcode', true);
else
    $postcode = get_user_meta($current_customer_id, 'billing_postcode', true);

if (get_user_meta($current_customer_id, 'shipping_city', true))
    $city = get_user_meta($current_customer_id, 'shipping_city', true);
else
    $city = get_user_meta($current_customer_id, 'billing_city', true);


if (get_user_meta($current_customer_id, 'billing_first_name', true))
    $firstname = get_user_meta($current_customer_id, 'billing_first_name', true);
else
    $firstname = get_user_meta($current_customer_id, 'first_name', true);

if (get_user_meta($current_customer_id, 'billing_last_name', true))
    $lastname = get_user_meta($current_customer_id, 'billing_last_name', true);
else
    $lastname = get_user_meta($current_customer_id, 'last_name', true);

if (!empty($customers->user_email))
    $email = $customers->user_email;
else
    $email = get_user_meta($current_customer_id, 'billing_email', true);

if (get_user_meta($current_customer_id, 'billing_phone', true))
    $phone = get_user_meta($current_customer_id, 'billing_phone', true);
else
    $phone = get_user_meta($current_customer_id, 'personal_phone', true);
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <form id="invoice-form" method="post" enctype="multipart/form-data">

                <input type="hidden" name="customer-edit" value="true">

                <div class=' col-lg-12 steps-page '>
                    <div class="col-md-12">
                        <div class="col-md-6"> <h2><?php echo $current_customer_id . " " . getCustomerName($current_customer_id); ?></h2></div>
                        <div class="col-md-6" style="float: right;">
                            <div class="userrole">
                            </div></div></div>
                    <hr>
                    <div class="tab-content">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab"
                                                  href="#tab_customer_information"><?php echo __("Kundinformation"); ?></a>
                            </li>
                            <li><a data-toggle="tab"
                                   href="#tab_customer_delivery_address"><?php echo __("Leveransadress") ?></a>
                            </li>
<?php if ($current_customer_id) : ?>

                                <li><a data-toggle="tab"
                                       href="#tab_customer_orders"><?php echo __("Kundprojekt") ?></a>
                                </li>
<?php endif; ?>

                        </ul>

                        <div id="tab_customer_information" class="row tab-pane fade in active">

                            <div class=' col-lg-6'>
                                <label class='top-buffer-half'
                                       for='customer_first_name'><?php echo __('Namn / Företagsnamn'); ?> </label>
                                <input type='text'
                                       value="<?php echo showName($current_customer_id); ?>"
                                       class='form-control'
                                       name='customer_first_name' id='customer_first_name'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='reference_name'><?php echo __('Referens'); ?></label>
                                <input type='text'
                                       value="<?php echo get_user_meta($current_customer_id, 'reference_name')[0]; ?>"
                                       class='form-control'
                                       name='reference_name' id='reference_name'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='customer_phone'><?php echo __('Telefonnummer'); ?></label>
                                <input type='text'
                                       value="<?php echo get_user_meta($current_customer_id, 'billing_phone')[0] ?>"
                                       class='form-control validphone'
                                       name='customer_phone'
                                       id='customer_phone'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='customer_phone_2'><?php echo __('Telefonnummer 2'); ?></label>
                                <input type='text'
                                       value="<?php echo get_user_meta($current_customer_id, 'billing_phone_2')[0] ?>"
                                       class='form-control validphone2 '
                                       name='customer_phone_2'
                                       id='customer_phone_2'>
                            </div>
                            <div class='col-lg-6 edit_customer'>
                                <label class='top-buffer-half'
                                       for='customer_email'><?php echo __('E-post'); ?></label>
                                <input type='email' pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$" value="<?php echo $email; ?>"
                                       class='form-control'
                                       name='customer_email' id='customer_email1' required>
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
                            <div class="exist_email"></div>
                            <div class='col-lg-6 all-mail'>
                                <label class='top-buffer-half'
                                       for='email_communication'><?php echo __('E-post för kommunikation'); ?></label>
                                <input type='text' value="<?php echo implode(',',get_user_meta($current_customer_id, 'email_comm')[0]); ?>"
                                       name='email_communication' id="email_communication" class='enter-mail-id' data-role="tagsinput">
									 
                            </div>

                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='invoice_email'><?php echo __('Epost för faktura'); ?></label>
                                <input type='text'
                                       value="<?php echo implode(',',get_user_meta($current_customer_id, 'invoice_email')[0]); ?>"
                                       class='form-control'
                                       name='invoice_email' id='invoice_email' data-role="tagsinput">
                            </div>
                            
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='vat_number'><?php echo __('VAT nummer vid omvänd byggmoms'); ?></label>
                                <input id="vat_number"  type="text" value="<?php echo get_user_meta($current_customer_id, 'vat_number')[0]; ?>" name="vat_number"/>
                            </div>
                             
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='customer_address'><?php echo __('Adress'); ?></label>
                                <input type='text'
                                       value="<?php echo get_user_meta($current_customer_id, 'billing_address_1')[0] ?>"
                                       class='form-control'
                                       name='customer_address' id='customer_address'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='customer_address_2'><?php echo __('Adress 2'); ?></label>
                                <input type='text'
                                       value="<?php echo get_user_meta($current_customer_id, 'billing_address_2')[0] ?>"
                                       class='form-control'
                                       name='customer_address_2' id='customer_address_2'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='customer_postal_number'><?php echo __('Postnummer'); ?></label>
                                <input type='text'
                                       value="<?php echo get_user_meta($current_customer_id, 'billing_postcode')[0] ?>"
                                       class='form-control'
                                       name='customer_postal_number' id='customer_postal_number' maxlength="9">
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='customer_city'><?php echo __('Postort'); ?></label>
                                <input type='text'
                                       value="<?php echo get_user_meta($current_customer_id, 'billing_city')[0] ?>"
                                       class='form-control'
                                       name='customer_city'
                                       id='customer_city'>
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

<?php
$args = array(
    'role__in' => array(
        'sale-salesman',
        'sale-administrator',
        'sale-economy',
        'sale-project-management'
    /*       'sale-economy',
      'sale-technician',
      'sale-project-management',
      'sale-sub-contractor' */
    )
);
$users = get_users($args);
$loginid = get_current_user_id();
$usering = get_userdata($loginid);

$user_roles = $usering->roles;

if (!empty($order_salesman)) {
    $user_kontakt_person = $order_salesman;
} else {
    if (!empty(get_user_meta($current_customer_id, 'user_kontakt_person')[0])) {
        $user_kontakt_person = get_user_meta($current_customer_id, 'user_kontakt_person')[0];
    } elseif (in_array('sale-salesman', $usering->roles) || in_array('sale-administrator', $usering->roles)) {
        $user_kontakt_person = $loginid;
    }
}
?>
                                <label class='top-buffer-half' for='user_kontakt_person'>Ansvarig säljare </label>


                                <select name="user_kontakt_person" id="user_kontakt_person" class='js-sortable-select'>

                                <?php
                                foreach ($users as $user) :
                                    $salesman = get_userdata($user->ID);
                                    ?>

                                        <option value='<?php echo $salesman->ID ?>' <?php $selected = selected($user_kontakt_person, $salesman->ID); ?>><?php echo showName($salesman->ID) ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class='col-lg-12'>
                                <label class='top-buffer-half'
                                       for='customer_other'><?php echo __('Övrigt'); ?></label>
                                <textarea class='form-control' rows='5' name='customer_other'
                                          id='customer_other'><?php echo get_user_meta($current_customer_id, 'customer_other')[0] ?></textarea>
                            </div>
                        </div>
                        <div id="tab_customer_delivery_address" class="row tab-pane fade">


                            <div class=' col-lg-6'>
                                <label class='top-buffer-half'
                                       for='shipping_first_name'><?php echo __('Förnamn'); ?> </label>
                                <input type='text'
                                       value="<?php echo $firstname; ?>"
                                       class='form-control'
                                       name='shipping_first_name' id='shipping_first_name'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='shipping_last_name'><?php echo __('Efternamn'); ?></label>
                                <input type='text'
                                       value="<?php echo $lname; ?>"
                                       class='form-control'
                                       name='shipping_last_name' id='shipping_last_name'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='shipping_contact_number'><?php echo __('Aviseringsnummer'); ?></label>
                                <input type='text'
                                       value="<?php echo $contact_number; ?>"
                                       class='form-control'
                                       name='shipping_contact_number' id='shipping_contact_number'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='shipping_address'><?php echo __('Adress'); ?></label>
                                <input type='text'
                                       value="<?php echo $address_1; ?>"
                                       class='form-control'
                                       name='shipping_address' id='shipping_address'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='shipping_address_2'><?php echo __('Adress 2'); ?></label>
                                <input type='text'
                                       value="<?php echo $address_2; ?>"
                                       class='form-control'
                                       name='shipping_address_2' id='shipping_address_2'>
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='shipping_postal_number'><?php echo __('Postnummer'); ?></label>
                                <input type='text'
                                       value="<?php echo $postcode; ?>"
                                       class='form-control'
                                       name='shipping_postal_number' id='shipping_postal_number' maxlength="9">
                            </div>
                            <div class='col-lg-6'>
                                <label class='top-buffer-half'
                                       for='shipping_city'><?php echo __('Postort'); ?></label>
                                <input type='text'
                                       value="<?php echo $city; ?>"
                                       class='form-control'
                                       name='shipping_city'
                                       id='shipping_city'>
                            </div>

                        </div>
<?php if ($current_customer_id) : ?>
                            <div id="tab_customer_orders" class="row tab-pane fade">
                                <div class="col-lg-12 top-buffer">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="sortable"
                                                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("ID"); ?></th>
                                                <th class="sortable"
                                                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Skapad"); ?></th>
                                                
<th class="sortable"
                                                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Project Type"); ?></th>
                                                <th class="sortable"
                                                    onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Säljare") ?></th>
                                                <th class="sortable"
                                                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Project Status") ?></th>
                                                <th class="text-center"><?php echo("Verktyg"); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
    <?php
    $args = [
        'posts_per_page' => -1,
        'orderby' => 'ID',
        'meta_key' => '_customer_user',
        'meta_value' => $current_customer_id,
        'post_type' => wc_get_order_types(),
        'post_status' => array('wc-processing', 'wc-pending', 'wc-on-hold', 'wc-completed', 'wc-refunded', 'wc-cancelled'),
    ];
    return_orders_for_customer_table($args);
    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                        <?php endif; ?>
                    </div>
					<span id="errormsg" style="    color: #ff5e00;"></span>
                    <input value="<?php echo __("Uppdatera kundinformation") ?>" type="submit"
                           class="btn btn-brand btn-block top-buffer update_customer" id="">

                </div>


            </form>
        </div>
    </div>
</div>
	
	<script>
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
	jQuery('.update_customer').click(function(){
var number = jQuery('input.validphone').val().trim();
var number2 = jQuery('input.validphone2').val().trim();

if(valiPhone(number) && valiPhone(number2)){
	return true;
}else{
	return false;
}


	});
	</script>
	

<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js
"></script>
                        <?php wp_footer(); ?>