<?php if ($disable != true) { ?>
    <div class='container'>
        <h4>Personlig information:</h4>

        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='customer_email'><?php echo __('E - post'); ?></label>
            <input type='text'  value="<?php if ($lead_id) : echo get_field('lead_email', $lead_id);
    endif;
    ?>" class='form-control'
                   name='customer_email' id='customer_email'>
        </div>

        <div class=' col-lg-4 col-md-4'>
            <label class='top-buffer-half'
                   for='customer_first_name'><?php echo __('Namn / Företagsnamn'); ?> </label>
            <input type='text'
                   value="<?php if ($lead_id) : echo get_field('lead_first_name', $lead_id);
               endif;
               ?>"
                   class='form-control'
                   name='customer_first_name'  id='customer_first_name'>
        </div>
        <?php/*
        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half'
                   for='customer_last_name'><?php echo __('Efternamn'); ?></label>
            <input type='text' value="<?php if ($lead_id) : echo get_field('lead_last_name', $lead_id);
               endif;
               ?>" class='form-control'
                   name='customer_last_name' id='customer_last_name'>
        </div>
         * 
         */?>

        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='customer_phone'><?php echo __('Telefonnummer'); ?></label>
            <input type='text' value="<?php if ($lead_id) : echo get_field('lead_phone', $lead_id);
               endif;
               ?>" class='form-control'
                   name='customer_phone' id='customer_phone'>
        </div>
        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='customer_postnummer'><?php echo __('Postnummer'); ?></label>
            <input type='text'
                   value="<?php if ($lead_id) : echo get_field('lead_postnummer', $lead_id);
               endif;
               ?>"
                   class='form-control'
                   name='customer_postnummer' id='customer_postnummer'>
        </div>
        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='customer_city'><?php echo __('Postort'); ?></label>
            <input type='text' 
                   value="<?php if ($lead_id) : echo get_field('lead_city', $lead_id);
               endif;
               ?>"
                   class='form-control'
                   name='customer_city' id='customer_city'>
        </div>
        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='lead_typavlead'><?php echo __('Typ av lead'); ?></label>
            <select name="customer_typavlead" id="customer_typavlead" class="form-control js-sortable-select">

                <option value="ingen" disabledd <?php if (!$lead_id) : echo 'selected';
                    endif;
    ?>>Välj typ av lead</option>
                          <?php
                          $current_user_role = get_user_role();
                          $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);

                          foreach ($project_roles_steps as $single_step) :
                              ?>

                    <option   value="<?php echo $single_step["project_type_name"] ?>" <?php if ($lead_id && $single_step["project_type_name"] == get_field('lead_typavlead', $lead_id)) : echo 'selected';
            endif;
            ?>><?php echo $single_step["project_type_name"] ?></option>


                       <?php
                   endforeach;
                   ?>
            </select>
        </div>
        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='customer_levernadress'><?php echo __('Adress'); ?></label>
            <input type='text' 
                   value="<?php if ($lead_id) : echo get_field('lead_customer_levernadress', $lead_id);
                   endif;
                   ?>"
                   class='form-control'
                   name='customer_levernadress' id='customer_levernadress'>
        </div>
        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='customer_homenummer'><?php echo __('Fastighetsbet'); ?></label>
            <input type='text'
                   value="<?php if ($lead_id) : echo get_field('lead_customer_homenummer', $lead_id);
               endif;
                   ?>"
                   class='form-control'
                   name='customer_homenummer' id='customer_homenummer'>
        </div>

        <div class='col-lg-4 col-md-4'>
            <label class='top-buffer-half' for='user_kontakt_person'><?php echo __('Ansvarig säljare'); ?></label>
            <select name="user_kontakt_person" id="user_kontakt_person" class='js-sortable-select'>
                <option value="ingen" disabledd <?php if (!$lead_id) : echo 'selected';
                    endif;
    ?>>Alla</option>

                <?php
                $args = array(
                    'role__in' => array(
                        'sale-salesman',
                        'sale-administrator',
                    /*       'sale-economy',
                      'sale-technician',
                      'sale-project-management',
                      'sale-sub-contractor' */
                    )
                );
                $users = get_users($args);
//                $loginid = get_current_user_id();
//                $usering = get_userdata($loginid);
//
//                $user_roles = $usering->roles;
//                if (!empty(get_user_meta($current_customer_id, 'user_kontakt_person')[0])) {
//                    $user_kontakt_person = get_user_meta($current_customer_id, 'user_kontakt_person')[0];
//                } elseif (in_array('sale-salesman', $usering->roles) || in_array('sale-administrator', $usering->roles)) {
//                    $user_kontakt_person = $loginid;
//                }

                foreach ($users as $user) :
                    $salesman = get_userdata($user->ID);
                    ?>
                
                    <option <?php if(!$lead_id && $salesman->ID == get_current_user_id()){ echo "selected"; } ?> value='<?php echo $salesman->ID ?>' <?php if ($lead_id && $salesman->ID == get_field('lead_salesman', $lead_id)) : echo 'selected';
                    endif;
                    ?>><?php echo showName($salesman->ID); ?></option>
        <?php
    endforeach;
    ?>
            </select>
        </div>

    </div>
<?php } ?>
<div class='container'>
    <h4>Är intresserad av:</h4>

    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
if ($disable === true) {
    echo "disabled";
}
?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='braskamin_cb' value="braskamin_cb" <?php
                             if (get_field('braskamin_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Braskamin</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='kakelugn_cb' value="kakelugn_cb" <?php
                             if (get_field('kakelugn_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Kakelugn</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
            if ($disable === true) {
                echo "disabled";
            }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='frimurning_cb' value="frimurning_cb" <?php
                             if (get_field('frimurning_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Frimurning</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='murspis_cb' value="murspis_cb" <?php
                             if (get_field('murspis_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Murspis</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='etanol_cb' value="etanol_cb" <?php
                             if (get_field('etanol_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Etanol</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='kassett_cb' value="kassett_cb" <?php
            if (get_field('kassett_cb', $_GET['lead-id'])) {
                echo 'checked';
            }
            ?>>Kassett</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
            ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='vedspis_cb' value ="vedspis_cb" <?php
                             if (get_field('vedspis_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
            ?>>Vedspis</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='taljstensugn_cb' value="taljstensugn_cb" <?php
                             if (get_field('taljstensugn_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Täljstensugn</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='service_cb' value="service_cb" <?php
                             if (get_field('service_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Service</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='reservdel_cb' value="reservdel_cb" <?php
            if (get_field('reservdel_cb', $_GET['lead-id'])) {
                echo 'checked';
            }
            ?>>Reservdel</label>
    </div>
    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
            if ($disable === true) {
                echo "disabled";
            }
            ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='tillbehor_cb' value="tillbehor_cb" <?php
                             if (get_field('tillbehor_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
            ?>>Tillbehör</label>
    </div>

    <div class="col-md-3 col-sm-3">
        <label for=""><input type="checkbox" <?php
            if ($disable === true) {
                echo "disabled";
            }
            ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id='solceller_cb' value="solceller_cb" <?php
                             if (get_field('solceller_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
            ?>>Solceller</label>
    </div>



</div>

<div class='container'>
    <h4>Hustyp:</h4>

    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
            ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="enplans_cb" value="enplans_cb" <?php
                             if (get_field('enplans_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Enplanshus</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="ett_och_halva_plan" value="ett_och_halva_plan" <?php
                             if (get_field('ett_och_halva_plan', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>1 <small>1/2</small> plans</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="2_plans_cb" value="2_plans_cb" <?php
               if (get_field('2_plans_cb', $_GET['lead-id'])) {
                   echo 'checked';
               }
               ?>>2-plans</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
               if ($disable === true) {
                   echo "disabled";
               }
               ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="Fritishus_cb" value="Fritishus_cb" <?php
               if (get_field('Fritishus_cb', $_GET['lead-id'])) {
                   echo 'checked';
               }
               ?>>Fritidshus</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
               if ($disable === true) {
                   echo "disabled";
               }
               ?> class="CheckBoxClass form-control"  name='lead_checkbox[]' id="souterrang_cb" value="souterrang_cb" <?php
                             if (get_field('souterrang_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Souterräng</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="nybygge_cb" value="nybygge_cb" <?php
            if (get_field('nybygge_cb', $_GET['lead-id'])) {
                echo 'checked';
            }
            ?>>Nybygge</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
            ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="flerbistadshus_cb" value="flerbistadshus_cb" <?php
               if (get_field('flerbistadshus_cb', $_GET['lead-id'])) {
                   echo 'checked';
               }
               ?>>Flerbostadshus</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
               if ($disable === true) {
                   echo "disabled";
               }
               ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="torpargrundkrypgrund_cb" value="torpargrundkrypgrund_cb" <?php
               if (get_field('torpargrundkrypgrund_cb', $_GET['lead-id'])) {
                   echo 'checked';
               }
               ?>>Torpargrund/Krypgrund</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
               if ($disable === true) {
                   echo "disabled";
               }
               ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="platta_pa_mark_cb" value="platta_pa_mark_cb" <?php
                             if (get_field('platta_pa_mark_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Platta på mark</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
                             if ($disable === true) {
                                 echo "disabled";
                             }
                             ?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="kallare_cb" value="kallare_cb" <?php
                             if (get_field('kallare_cb', $_GET['lead-id'])) {
                                 echo 'checked';
                             }
                             ?>>Källare</label>
    </div>

    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
            if ($disable === true) {
                echo "disabled";
            }
                             ?> class="CheckBoxClass form-control" name="taksakerhet_finnssaknas_cb" id="taksakerhet_finnssaknas_cb" value="taksakerhet_finnssaknas_cb"<?php
               if (get_field('taksakerhet_finnssaknas_cb', $_GET['lead-id'])) {
                   echo 'checked';
               }
               ?>>Taksäkerhet Finns/Saknas</label>
    </div>
    <div class="col-md-6 col-sm-6">
        <input type="text" class="CheckBoxClass form-control"  <?php
               if ($disable === true) {
                   echo "disabled";
               }
               ?> name="takhojdbv_cb" placeholder="Takhöjd(BV)" id="takhojdbv_cb" value="<?php
               if (get_field('takhojdbv_cb', $_GET['lead-id'])) {
                   echo get_field('takhojdbv_cb', $_GET['lead-id']);
               }
               ?>">
    </div>
    <div class="col-md-6 col-sm-6">
        <input type="text" class="CheckBoxClass form-control"  <?php
if ($disable === true) {
    echo "disabled";
}
?> name="byggar_cb" placeholder="Byggär" id="byggar_cb" value="<?php
if (get_field('byggar_cb', $_GET['lead-id'])) {
    echo get_field('byggar_cb', $_GET['lead-id']);
}
?>">
    </div>



</div>

<div class='container'>
    <h4>Skorsten:</h4>

    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
if ($disable === true) {
    echo "disabled";
}
?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="ny_skorsten_cb" value="ny_skorsten_cb" <?php
if (get_field('ny_skorsten_cb', $_GET['lead-id'])) {
    echo 'checked';
}
?>>Ny</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
if ($disable === true) {
    echo "disabled";
}
?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="beffintlig_skorsten_cb" value="beffintlig_skorsten_cb" <?php
if (get_field('beffintlig_skorsten_cb', $_GET['lead-id'])) {
    echo 'checked';
}
?>>Befintlig</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
if ($disable === true) {
    echo "disabled";
}
?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="skorstenstatning_skorsten_cb" value="skorstenstatning_skorsten_cb" <?php
if (get_field('skorstenstatning_skorsten_cb', $_GET['lead-id'])) {
    echo 'checked';
}
?>>Skorstenstätning</label>
    </div>

    <div class="col-md-6 col-sm-6">
        <label class='top-buffer-half' for='annat_yttertak_cb'><?php echo __('Antal kanaler'); ?></label>
        <input type="text" class="CheckBoxClass form-control"  <?php
if ($disable === true) {
    echo "disabled";
}
?>  name="antal_kanaler_cb" id="antal_kanaler_cb" value="<?php
if (get_field('antal_kanaler_cb', $_GET['lead-id'])) {
    echo get_field('antal_kanaler_cb', $_GET['lead-id']);
}
?>">
    </div>
    <div class="col-md-6 col-sm-6">
        <label class='top-buffer-half' for='annat_yttertak_cb'><?php echo __('Ca meter'); ?></label>
        <input type="text" class="CheckBoxClass form-control"  <?php
if ($disable === true) {
    echo "disabled";
}
?>  name="ca_meter_cb" id="ca_meter_cb" value="<?php
if (get_field('ca_meter_cb', $_GET['lead-id'])) {
    echo get_field('ca_meter_cb', $_GET['lead-id']);
}
?>">
    </div>



</div>

<div class='container'>
    <h4>Yttertak:</h4>

    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
if ($disable === true) {
    echo "disabled";
}
?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="tagel_yttertak_cb" value="tagel_yttertak_cb"  <?php
if (get_field('tagel_yttertak_cb', $_GET['lead-id'])) {
    echo 'checked';
}
?>>Tegel</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
if ($disable === true) {
    echo "disabled";
}
?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="plat_yttertak_cb" value="plat_yttertak_cb"  <?php
if (get_field('plat_yttertak_cb', $_GET['lead-id'])) {
    echo 'checked';
}
?>>Plåt</label>
    </div>
    <div class="col-md-4 col-sm-4">
        <label for=""><input type="checkbox" <?php
if ($disable === true) {
    echo "disabled";
}
?> class="CheckBoxClass form-control" name='lead_checkbox[]' id="papp_yttertak_cb" value="papp_yttertak_cb"  <?php
if (get_field('papp_yttertak_cb', $_GET['lead-id'])) {
    echo 'checked';
}
?>>Papp</label>
    </div>

    <div class="col-md-6 col-sm-6">
        <label class='top-buffer-half' for='annat_yttertak_cb'><?php echo __('Annat'); ?></label>
        <input type="text" class="CheckBoxClass form-control"  <?php
if ($disable === true) {
    echo "disabled";
}
?> name="annat_yttertak_cb"  id="annat_yttertak_cb" value=" <?php
if (get_field('annat_yttertak_cb', $_GET['lead-id'])) {
    echo get_field('annat_yttertak_cb', $_GET['lead-id']);
}
?>">
    </div>

</div>
<?php if ($disable != true) { ?>
    <div class='container'>


        <label class='top-buffer-half' for='customer_other'><?php echo __('Övrigt'); ?></label>
        <textarea class='form-control' rows='5'  <?php
    if ($disable === true) {
        echo "disabled";
    }
    ?> name='customer_other'
                  id='customer_other'><?php if ($lead_id) : echo get_field('lead_other', $lead_id);
    endif;
    ?></textarea>

    </div>
<?php } ?>

