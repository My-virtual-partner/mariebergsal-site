<?php
/**
 * Lead create form.
 * Simply creates a new lead when posted.
 */
include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
 $pid=get_post_meta($_GET["order-id"],'imm-sale_project_connection', true);
//$pid= $_GET["order-id"]-1;
$get_custid = get_field('invoice_customer_id',$pid);

  $leadid = get_field('orgin_lead_id',$pid);

 $project_type = get_field('order_project_type', $_GET["order-id"]);
$user_info = get_userdata($get_custid);

$uid=$user_info->ID;

  $first_name=get_user_meta( $uid, 'first_name', 'true' );
$last_name=get_user_meta( $uid, 'last_name', 'true' );
$billing_last_name=get_user_meta( $uid, 'billing_first_name', 'true' );
$billing_last_name=get_user_meta( $uid, 'billing_last_name', 'true' );
$billing_phone=get_user_meta( $uid, 'billing_phone', 'true' );
$billing_address_1=get_user_meta( $uid, 'billing_address_1', 'true' );
$billing_address_2=get_user_meta( $uid, 'billing_address_2', 'true' );
$billing_postcode=get_user_meta( $uid, 'billing_postcode', 'true' );
 
 
 $lead_customer_homenummer=get_post_meta( $leadid, 'lead_customer_homenummer', 'true' );
 
 $billing_city=get_user_meta( $uid, 'billing_city', 'true' );
$customer_individual_organisation_number=get_user_meta( $uid, 'customer_individual_organisation_number', 'true' );
$lead_other=get_post_meta( $leadid, 'lead_other', 'true' );
$billing_email=get_user_meta( $uid, 'billing_email', 'true' );
$customer_company_private=get_user_meta( $uid, 'customer_company_private', 'true' );
$user_kontakt_person=get_user_meta( $uid, 'user_kontakt_person', 'true' );

 /**
     * Update the user data. Currently showing in ball step 1 if lead form does not exist for the project
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['leadupdate'] === 'true') {
		
		


        /*   var_dump($_POST);die;*/
        $lead_id = $_POST["userid"];
        $lead_first_name = $_POST["customer_first_name"];
        $lead_last_name = $_POST["customer_last_name"];
        $lead_email = $_POST["customer_email"];
        $lead_phone = $_POST["customer_phone"];
        $lead_city = $_POST["customer_city"];
        $lead_postnummer = $_POST["customer_postnummer"];
        $lead_typavlead = $_POST["customer_typavlead"];
        $lead_other = $_POST["customer_other"];
        $lead_customer_levernadress = $_POST["customer_levernadress"];
        $lead_customer_homenummer = $_POST["customer_homenummer"];
//print_r($_POST);


	

	/* foreach($_POST['lead_checkbox'] as $metaValue){
		
				update_post_meta($lead_checkboxid, $metaValue, $metaValue);

		} */
        update_user_meta($lead_id, "first_name", $lead_first_name);
        update_user_meta($lead_id, "last_name", $lead_last_name);
        update_user_meta($lead_id, "billing_email", $lead_email);
        update_user_meta($lead_id, "billing_phone", $lead_phone);
        update_user_meta($lead_id, "billing_city", $lead_city);
        update_user_meta($lead_id, "billing_postcode", $lead_postnummer);
        update_user_meta($lead_id, "lead_typavlead", $lead_typavlead);
        update_post_meta($leadid, "lead_other", $lead_other);
        update_user_meta($lead_id, "billing_address_1", $lead_customer_levernadress);
        update_user_meta($lead_id, "billing_address_1", $lead_customer_homenummer);
		//update_user_meta($lead_id, "leads_skapat_lead", date('Ymd'));

        $today = date('Y-m-d');
        $todo_action_date = date('Y-m-d', strtotime($today));


       // create_todo_item($todo_action_date, 0, null, __("Nytt lead har skapats för kund ") . $lead_first_name . " " . $lead_last_name, 'sale-salesman');


        //header('Location:' . site_url() . "/system-dashboard#leads");



    }

//print_r($user_info);

?>




 
    <div class="container">
        <div class="row">
            <form id="leadupdate" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="leadupdate" value="true">
<input type="hidden" name="userid" value="<?=$uid;?>" id="uid">
<input type="hidden"  value="<?=$leadid;?>" id="leadid">
                <div class='container'>
                    <h4>Personlig information:</h4>
                    <div class=' col-lg-4 col-md-4'>
                        <label class='top-buffer-half'
                               for='customer_first_name'><?php echo __( 'Förnamn' ); ?> </label>
                        <input type='text'
                               value="<?php if (!empty($first_name)) : echo $first_name; endif; ?>"
                               class='form-control'
                               name='customer_first_name' id='customer_first_name'>
                    </div>
                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half'
                               for='customer_last_name'><?php echo __( 'Efternamn' ); ?></label>
                        <input type='text' value="<?php if (!empty($last_name)) : echo $last_name; endif; ?>" class='form-control'
                               name='customer_last_name' id='customer_last_name'>
                    </div>

                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half' for='customer_email'><?php echo __( 'E - post' ); ?></label>
                        <input type='text' value="<?php if (!empty($billing_email)) : echo $billing_email; endif; ?>" class='form-control'
                               name='customer_email' id='customer_email'>
                    </div>
                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half' for='customer_phone'><?php echo __( 'Telefonnummer' ); ?></label>
                        <input type='text' value="<?php if (!empty($billing_phone)) : echo $billing_phone; endif;?>" class='form-control'
                               name='customer_phone' id='customer_phone'>
                    </div>
                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half' for='customer_city'><?php echo __( 'Postort' ); ?></label>
                        <input type='text'
                               value="<?php if (!empty($billing_city)) : echo $billing_city; endif; ?>"
                               class='form-control'
                               name='customer_city' id='customer_city'>
                    </div>
                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half' for='customer_postnummer'><?php echo __( 'Postnummer' ); ?></label>
                        <input type='text'
                               value="<?php if (!empty($billing_postcode)) : echo $billing_postcode; endif;  ?>"
                               class='form-control'
                               name='customer_postnummer' id='customer_postnummer'>
                    </div>
                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half' for='lead_typavlead'><?php echo __( 'Typ av lead' ); ?></label>
                        <select name="customer_typavlead" <?php echo $project_type; ?> class="form-control js-sortable-select">

                            <option value="ingen" disabled <?php if ( !$project_type ) : echo 'selected'; endif; ?>>Välj typ av lead</option>
                            <?php

                            $current_user_role = get_user_role();
                            $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);

                            foreach ($project_roles_steps as $single_step) :?>

                                <option value="<?php echo $single_step["project_type_name"] ?>" <?php if ( $project_type &&  $single_step["project_type_name"] == $project_type ) : echo 'selected'; endif; ?>><?php echo $single_step["project_type_name"] ?></option>


                            <?php
                            endforeach;



                            ?>
                        </select>
                    </div>
                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half' for='customer_levernadress'><?php echo __( 'Leveransadress' ); ?></label>
                        <input type='text'
                               value="<?php if (!empty($billing_address_1)) : echo $billing_address_1; endif; ?>"
                               class='form-control'
                               name='customer_levernadress' id='customer_levernadress'>
                    </div>
                    <div class='col-lg-4 col-md-4'>
                        <label class='top-buffer-half' for='customer_homenummer'><?php echo __( 'Fastighets Nr' ); ?></label>
                        <input type='text'
                               value="<?php if (!empty($lead_customer_homenummer)) : echo $lead_customer_homenummer; endif; ?>"
                               class='form-control'
                               name='customer_homenummer' id='customer_homenummer'>
                    </div>

                </div>
      <div class='container'>
                    <h4>Är intresserad av:</h4>

                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="braskamin_cb" <?php if(get_field('braskamin_cb',$leadid)){echo 'checked';}?>>Braskamin</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="kakelugn_cb" <?php if(get_field('kakelugn_cb',$leadid)){echo 'checked';}?>>Kakelugn</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="frimurning_cb" <?php if(get_field('frimurning_cb',$leadid)){echo 'checked';}?>>Frimurning</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="murspis_cb" <?php if(get_field('murspis_cb',$leadid)){echo 'checked';}?>>Murspis</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="etanol_cb" <?php if(get_field('etanol_cb',$leadid)){echo 'checked';}?>>Etanol</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="kassett_cb" <?php if(get_field('kassett_cb',$leadid)){echo 'checked';}?>>Kassett</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value ="vedspis_cb" <?php if(get_field('vedspis_cb',$leadid)){echo 'checked';}?>>Vedspis</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="taljstensugn_cb" <?php if(get_field('taljstensugn_cb',$leadid)){echo 'checked';}?>>Täljstensugn</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value='lead_checkbox' value="service_cb" <?php if(get_field('service_cb',$leadid)){echo 'checked';}?>>Service</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="reservdel_cb" <?php if(get_field('reservdel_cb',$leadid)){echo 'checked';}?>>Reservdel</label>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="tillbehor_cb" <?php if(get_field('tillbehor_cb',$leadid)){echo 'checked';}?>>Tillbehör</label>
                        </div>




                </div>

<div class='container'>
                    <h4>Hustyp:</h4>

                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="enplans_cb" <?php if(get_field('enplans_cb',$leadid)){echo 'checked';}?>>Enplans</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="ett_och_halva_plan" <?php if(get_field('ett_och_halva_plan',$leadid)){echo 'checked';}?>>1 <small>1/2</small> plans</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="2_plans_cb" <?php if(get_field('2_plans_cb',$leadid)){echo 'checked';}?>>2-plans</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="Fritishus_cb" <?php if(get_field('Fritishus_cb',$leadid)){echo 'checked';}?>>Fritishus</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control"  name='lead_checkbox[]' id="lead_checkbox" value="souterrang_cb" <?php if(get_field('souterrang_cb',$leadid)){echo 'checked';}?>>Souterräng</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="nybygge_cb" <?php if(get_field('nybygge_cb',$leadid)){echo 'checked';}?>>Nybygge</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="flerbistadshus_cb" <?php if(get_field('flerbistadshus_cb',$leadid)){echo 'checked';}?>>Flerbostadshus</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="torpargrundkrypgrund_cb" <?php if(get_field('torpargrundkrypgrund_cb',$leadid)){echo 'checked';}?>>Torpargrund/Krypgrund</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="platta_pa_mark_cb" <?php if(get_field('platta_pa_mark_cb',$leadid)){echo 'checked';}?>>Platta på mark</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="kallare_cb" <?php if(get_field('kallare_cb',$leadid)){echo 'checked';}?>>Källare</label>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name="taksakerhet_finnssaknas_cb" <?php if(get_field('taksakerhet_finnssaknas_cb',$leadid)){echo 'checked';}?>>Taksäkerhet Finns/Saknas</label>
                    </div>
                    <div class="col-md-6 col-sm-6">
                     <input type="text" class="CheckBoxClass form-control"  name="takhojdbv_cb" placeholder="Takhöjd(BV)" value="<?php if(get_field('takhojdbv_cb',$leadid)){echo get_field('takhojdbv_cb',$leadid);}?>">
                    </div>
                    <div class="col-md-6 col-sm-6">
                     <input type="text" class="CheckBoxClass form-control"  name="byggar_cb" placeholder="Byggår" value="<?php if(get_field('byggar_cb',$leadid)){echo get_field('byggar_cb',$leadid);}?>">
                    </div>



                </div>

                          <div class='container'>
                    <h4>Skorsten:</h4>

                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="ny_skorsten_cb" <?php if(get_field('ny_skorsten_cb',$leadid)){echo 'checked';}?>>Ny</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="beffintlig_skorsten_cb" <?php if(get_field('beffintlig_skorsten_cb',$leadid)){echo 'checked';}?>>Befintlig</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="skorstenstatning_skorsten_cb" <?php if(get_field('skorstenstatning_skorsten_cb',$leadid)){echo 'checked';}?>>Skorstenstätning</label>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <input type="text" class="CheckBoxClass form-control"  name="antal_kanaler_cb" placeholder="Antal kanaler" value="<?php if(get_field('antal_kanaler_cb',$leadid)){echo get_field('antal_kanaler_cb',$leadid);}?>">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="text" class="CheckBoxClass form-control" name="ca_meter_cb" placeholder="Ca meter" value="<?php if(get_field('ca_meter_cb',$leadid)){echo get_field('ca_meter_cb',$leadid);}?>">
                    </div>



                </div>

          <div class='container'>
                    <h4>Yttertak:</h4>

                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="tagel_yttertak_cb"  <?php if(get_field('tagel_yttertak_cb',$leadid)){echo 'checked';}?>>Tegel</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="plat_yttertak_cb"  <?php if(get_field('plat_yttertak_cb',$leadid)){echo 'checked';}?>>Plåt</label>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for=""><input type="checkbox" class="CheckBoxClass form-control" name='lead_checkbox[]' id="lead_checkbox" value="papp_yttertak_cb"  <?php if(get_field('papp_yttertak_cb',$leadid)){echo 'checked';}?>>Papp</label>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <input type="text" class="CheckBoxClass form-control" name="annat_yttertak_cb" placeholder="Annat" value=" <?php if(get_field('annat_yttertak_cb',$leadid)){echo get_field('annat_yttertak_cb',$leadid);}?>">
                    </div>

                </div>

                <div class='container'>


                        <label class='top-buffer-half' for='customer_other'><?php echo __( 'Övrigt' ); ?></label>
                        <textarea class='form-control' rows='5' name='customer_other'
                                  id='customer_other'><?php if ( !empty($lead_other) ) : echo $lead_other; endif; ?></textarea>

                </div>
                <div class="col-lg-12 top-buffer">
                    <input value="<?php echo __("Spara"); ?>" type="button" id="updatelead" class="btn btn-brand btn-block">

                </div>

            </form>
        </div>
    </div>
    
    

<?php wp_footer(); ?>