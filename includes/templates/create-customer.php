<?php

/**
 * Form to create a new customer.
 */

$order = wc_get_order( $_GET["order-id"] );
if ( $order ) {
	$current_customer_id = $order->get_customer_id();

}
if ( isset( $_GET["lead-id"] ) ) {
	$lead = get_post( $_GET["lead-id"] );

}
$customers = get_users( 'orderby=nicename&role=customer' );
?>
<?php if ( ! $order ) : ?>
    <div class=" col-lg-12 steps-page">
        <div class='row'>

            <div class='col-lg-12'>
                <div class='checkbox'>
                    <label><input type='checkbox' checked name='create_new_customer' id='create_new_customer'
                                  value='create_new_customer'><?php echo __( "Skapa ny kund" ); ?></label>
                </div>
            </div>
        </div>
        <div class=' select-customer'>

            <label class='top-buffer-half' for='customer'> <?php echo __( "Välj kund" ); ?> </label>
            <select name='customer' class='form-control js-sortable-select' id='customer'>
                <option selected disabled value=''> <?php echo __( "Ingen kund vald" ); ?>.</option>
				<?php

				foreach ( $customers as $customer ) {
					if ( $current_customer_id == $customer->ID ) {
						$selected = "selected";
					} else {
						$selected = "";
					}
					echo "<option " . $selected . " value='" . $customer->ID . "'> " . $customer->user_email . " - " . getCustomerName($customer->ID) . "</option>";
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
                                  href="#tab_customer_information"><?php echo __( "Kundinformation" ); ?></a></li>
            <li><a data-toggle="tab" href="#tab_customer_delivery_address"><?php echo __( "Leveransadress" ) ?></a></li>
            <li><a data-toggle="tab" href="#tab_tax_discount"><?php echo __( "ROT Avdrag" ) ?></a></li>
        </ul>
        <div id="tab_customer_information" class="row tab-pane fade in active">

            <div class=' col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_first_name'><?php echo __( 'Förnamn' ); ?> </label>
                <input type='text'
                       value="<?php if ( $lead ) {
					       echo get_post_meta( $lead->ID, 'lead_first_name' )[0];
				       } else {
					       echo get_user_meta( $current_customer_id, 'billing_first_name' )[0];
				       } ?>"
                       class='form-control'
                       name='customer_first_name' id='customer_first_name'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_last_name'><?php echo __( 'Efternamn' ); ?></label>
                <input type='text' value="<?php if ( $lead ) {
					echo get_post_meta( $lead->ID, 'lead_last_name' )[0];
				} else {
					echo get_user_meta( $current_customer_id, 'billing_last_name' )[0];
				} ?>"
                       class='form-control'
                       name='customer_last_name' id='customer_last_name'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_phone'><?php echo __( 'Telefonnummer' ); ?></label>
                <input type='text' value="<?php if ( $lead ) {
			        echo get_post_meta( $lead->ID, 'lead_phone' )[0];
		        } else {
			        echo get_user_meta( $current_customer_id, 'billing_phone' )[0];
		        } ?>"
                       class='form-control'
                       name='customer_phone'
                       id='customer_phone'>
            </div> <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_phone_2'><?php echo __( 'Telefonnummer 2' ); ?></label>
                <input type='text' value="<?php if ( $lead ) {
			        echo get_post_meta( $lead->ID, 'lead_phone' )[0];
		        } else {
			        echo get_user_meta( $current_customer_id, 'billing_phone_2' )[0];
		        } ?>"
                       class='form-control'
                       name='customer_phone_2'
                       id='customer_phone_2'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_email'><?php echo __( 'E - post' ); ?><span style="color: red"> *</span></label>
                <input required type='text' value="<?php if ( $lead ) {
			        echo get_post_meta( $lead->ID, 'lead_email' )[0];
		        } else {
			        echo get_user_meta( $current_customer_id, 'billing_email' )[0];
		        } ?>"
                       class='form-control'
                       name='customer_email' id='customer_email'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_individual_organisation_number'><?php echo __( 'Personnummer / Organisationsnummer' ); ?></label>
                <input type='text'
                       value="<?php echo get_user_meta( $current_customer_id, 'customer_individual_organisation_number' )[0] ?>"
                       class='form-control'
                       name='customer_individual_organisation_number'
                       id='customer_individual_organisation_number'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_company'><?php echo __( 'Företag' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'billing_company' )[0] ?>"
                       class='form-control'
                       name='customer_company' id='customer_company'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_address'><?php echo __( 'Adress' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'billing_address_1' )[0] ?>"
                       class='form-control'
                       name='customer_address' id='customer_address'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_address_2'><?php echo __( 'Adress 2' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'billing_address_2' )[0] ?>"
                       class='form-control'
                       name='customer_address_2' id='customer_address_2'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_postal_number'><?php echo __( 'Postnummer' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'billing_postcode' )[0] ?>"
                       class='form-control'
                       name='customer_postal_number' id='customer_postal_number'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='customer_city'><?php echo __( 'Postort' ); ?></label>
                <input type='text' value="<?php if ( $lead ) {
	                echo get_post_meta( $lead->ID, 'lead_city' )[0];
                } else {
	                echo get_user_meta( $current_customer_id, 'billing_phone' )[0];
                } ?>"
                       class='form-control'
                       name='customer_city'
                       id='customer_city'>
            </div>


            <div class='col-lg-12'>
                <label class='top-buffer-half'
                       for='customer_other'><?php echo __( 'Övrigt' ); ?></label>
                <textarea class='form-control' rows='5' name='customer_other'
                          id='customer_other'><?php if ( $lead ) {
	                     echo get_post_meta( $lead->ID, 'lead_other' )[0];
                     } else {
	                     echo get_user_meta( $current_customer_id, 'customer_other' )[0];
                     } ?>
                   </textarea>
            </div>
        </div>
        <div id="tab_customer_delivery_address" class="row tab-pane fade">


            <div class=' col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_first_name'><?php echo __( 'Förnamn' ); ?> </label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'shipping_first_name' )[0] ?>"
                       class='form-control'
                       name='shipping_first_name' id='shipping_first_name'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_last_name'><?php echo __( 'Efternamn' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'shipping_last_name' )[0] ?>"
                       class='form-control'
                       name='shipping_last_name' id='shipping_last_name'>
            </div>
            
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_address'><?php echo __( 'Adress' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'shipping_address_1' )[0] ?>"
                       class='form-control'
                       name='shipping_address' id='shipping_address'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_address_2'><?php echo __( 'Adress 2' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'shipping_address_2' )[0] ?>"
                       class='form-control'
                       name='shipping_address_2' id='shipping_address_2'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_postal_number'><?php echo __( 'Postnummer' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'shipping_postcode' )[0] ?>"
                       class='form-control'
                       name='shipping_postal_number' id='shipping_postal_number'>
            </div>
            <div class='col-lg-6'>
                <label class='top-buffer-half'
                       for='shipping_city'><?php echo __( 'Postort' ); ?></label>
                <input type='text' value="<?php echo get_user_meta( $current_customer_id, 'shipping_city' )[0] ?>"
                       class='form-control'
                       name='shipping_city'
                       id='shipping_city'>
            </div>
        </div>

    </div>

</div>
