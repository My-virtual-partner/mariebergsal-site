<?php
/**
 * Lead create form. This form can be displayed by using the shortcode [load_lead_form]
 * Simply creates a new lead when posted.
 */

$lead_id = $_GET["lead-id"];
?>
<div class="container">
    <div class="row">
        <form id="lead_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="create_external_lead" value="true">
            <div class=' col-lg-12'>
                <div class=' col-lg-6 col-md-6'>
                    <label class='top-buffer-half'
                           for='customer_first_name'><?php echo __( 'Förnamn' ); ?> </label>
                    <input required type='text'
                           value="<?php if ( $lead_id ) : echo get_field( 'lead_first_name', $lead_id ); endif; ?>"
                           class='form-control'
                           name='customer_first_name' id='customer_first_name'>
                </div>
                <div class='col-lg-6 col-md-6'>
                    <label class='top-buffer-half'
                           for='customer_last_name'><?php echo __( 'Efternamn' ); ?></label>
                    <input required type='text'
                           value="<?php if ( $lead_id ) : echo get_field( 'lead_last_name', $lead_id ); endif; ?>"
                           class='form-control'
                           name='customer_last_name' id='customer_last_name'>
                </div>

                <div class='col-lg-6 col-md-6'>
                    <label class='top-buffer-half' for='customer_email'><?php echo __( 'E - post' ); ?></label>
                    <input required type='text'
                           value="<?php if ( $lead_id ) : echo get_field( 'lead_email', $lead_id ); endif; ?>"
                           class='form-control'
                           name='customer_email' id='customer_email'>
                </div>
                <div class='col-lg-6 col-md-6'>
                    <label class='top-buffer-half' for='customer_phone'><?php echo __( 'Telefonnummer' ); ?></label>
                    <input required type='text'
                           value="<?php if ( $lead_id ) : echo get_field( 'lead_phone', $lead_id ); endif; ?>"
                           class='form-control'
                           name='customer_phone' id='customer_phone'>
                </div>
                <div class='col-lg-6 col-md-6'>
                    <label class='top-buffer-half' for='customer_city'><?php echo __( 'Postort' ); ?></label>
                    <input required type='text'
                           value="<?php if ( $lead_id ) : echo get_field( 'lead_city', $lead_id ); endif; ?>"
                           class='form-control'
                           name='customer_city' id='customer_city'>
                </div>
                <div class='col-lg-12'>
                    <label class='top-buffer-half' for='customer_other'><?php echo __( 'Övrigt' ); ?></label>
                    <textarea class='form-control' rows='5' name='customer_other'
                              id='customer_other'><?php if ( $lead_id ) : echo get_field( 'lead_other', $lead_id ); endif; ?></textarea>
                </div>

                <div class="col-lg-12 top-buffer">
					<?php if ( $lead_id ) : ?>
                        <h2><?php echo __( "Tack för ditt intresse. Vi kommer att kontakta dig så snart vi kan." ) ?></h2>
					<?php else : ?>
                        <input value="<?php echo __( "Spara" ); ?>" type="submit" class="btn btn-brand btn-block" id="">
					<?php endif; ?>
                </div>
            </div>

        </form>
    </div>
</div>
