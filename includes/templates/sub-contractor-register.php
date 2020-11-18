<?php
/**
 * Template used to display a sub-contractor register.
 * URL PATH: $_SERVER['REQUEST_URI'], '/sub-contractor-register'
 */

include_once(plugin_dir_path(__FILE__) . 'head.php');
$table_name = "sub-contractor-register-table";
?>
    <div class="container-db top-buffer-half">
        <input type="hidden" id="sub_contractor_id_hidden_field">
        <div class="row">
            <div class="col-lg-4" >
                <a href="#" type="button" class="btn btn-alpha btn-block" data-toggle="modal" data-target="#create_new_ue"><i class="fa fa-address-book" aria-hidden="true"></i>
                    Skapa ny UE </a>
            </div>


            <!--modal-->
            <div class="modal fade" id="create_new_ue" tabindex="-1" role="dialog"
                 aria-labelledby="create_new_ue_modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_new_ue_modal">Skapa ny UE</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body ">



                            <label for="" class="top-buffer-half"><strong>Förnamn</strong></label>
                            <input type="text" value="" placeholder="Förnnamn" class="sub_cont_fornamn_new">
<!--                            <label for="" class="top-buffer-half"><strong>Efternamn</strong></label>
                            <input type="text" value="" placeholder="Efternamn" class="sub_cont_efternamn_new" >-->
                            <label for="" class="top-buffer-half"><strong>Kortnamn</strong></label>
                            <input type="text" value="" placeholder="Kortnamn" class="sub_cont_shortname_new" >

                            <label for="" class="top-buffer-half"><strong>E-post</strong></label>
                            <input type="text" value="" placeholder="E-post"   class="sub_cont_epost_new">
                            <label for="" class="top-buffer-half"><strong>Telefonnummer</strong></label>
                            <input type="text" value="" placeholder="Telefonnummer" class="sub_cont_tel_new">
                            <label for="" class="top-buffer-half" ><strong>UE Företag</strong></label>
                            <input type="text" value="" placeholder="Företag" class="sub_cont_company_new">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-brand" data-dismiss="modal">Stäng</button>
                            <button type="button" class="btn btn-primary btn-brand create_new_ue" ">Skapa</button>
                        </div>
                    </div>
                </div>
            </div>

        <!--    Tables-->
            <div class="col-lg-12">


                <table class="table top-buffer-half">
                    <thead>
                    <tr>
                        <th class="sortable"
                            onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Fullständigt namn"); ?></th>
                        <th class="sortable"
                            onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __('E - post'); ?></th>
                        <th class="sortable"
                            onclick="sortTable(2,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __('Telefon'); ?></th>
                        <th class="sortable"
                            onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __('UE Företag'); ?></th>
                        <th class="sortable"
                            onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __('Redigera'); ?></th>
                    </tr>

                    </thead>
                    <tbody id="<?php echo $table_name ?>">
                    <?php
                    $users = get_users('orderby=nicename&role=sale-sub-contractor');

                    foreach ($users as $user) :
                        $user_info = get_userdata($user->ID);
                        ?>
                        <tr>
                            <td><?php echo getCustomerName($user->ID); ?></td>
                            <td><?php echo $user_info->user_email; ?></td>
                            <td>
                                <a href="tel:<?php echo get_user_meta($user->ID, 'personal_phone')[0] ?>"><?php echo get_user_meta($user->ID, 'personal_phone')[0] ?></a>
                            </td>
                            <td><?php echo get_user_meta($user->ID, 'sale-sub-contractor_company')[0] ?></td>
                            <td class="redigera_sale_sub_contractor_btn" data_id="<?php echo $user->ID; ?>"><a href="#" data-toggle="modal" data-target="#<?php echo $user->ID; ?>" >Redigera</a></td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>
<?php
$users = get_users('orderby=nicename&role=sale-sub-contractor');
                foreach ($users as $user) :
                $user_info = get_userdata($user->ID);
                ?>
                <!--modal-->
                <div class="modal fade" id="<?php echo $user->ID; ?>" tabindex="-1" role="dialog"
                     aria-labelledby="<?php echo get_user_meta($user->ID, 'personal_phone')[0] ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="<?php echo get_user_meta($user->ID, 'personal_phone')[0] ?>"><?php echo getCustomerName($user->ID); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ">

                                <label for="" class="top-buffer-half"><strong>Förnamn</strong></label>
                                <input type="text" value="<?php echo getCustomerName($user->ID); ?>" placeholder="Förnnamn" class="sub_cont_fornamn<?php echo $user->ID; ?>">
                                <?php/*<label for="" class="top-buffer-half"><strong>Efternamn</strong></label>
                                <input type="text" value="<?php echo $user_info->user_lastname; ?>" placeholder="Efternamn" class="sub_cont_efternamn<?php echo $user->ID; ?>" >*/?>
                                <label for="" class="top-buffer-half"><strong>Kortnamn</strong></label>
                                <input type="text" value="<?php echo get_user_meta($user->ID, 'sale-sub-contractor_shortname')[0] ;?>" placeholder="Kortnamn" class="sub_cont_shortname<?php echo $user->ID; ?>" >
                                <label for="" class="top-buffer-half"><strong>E-post</strong></label>
                                <input type="text" value="<?php echo $user_info->user_email; ?>" placeholder="E-post"   class="sub_cont_epost<?php echo $user->ID; ?>">
                                <label for="" class="top-buffer-half"><strong>Telefonnummer</strong></label>
                                <input type="text" value="<?php echo get_user_meta($user->ID, 'personal_phone')[0] ?>" placeholder="Telefonnummer" class="sub_cont_tel<?php echo $user->ID; ?>">
                                <label for="" class="top-buffer-half" ><strong>Företag</strong></label>
                                <input type="text" value="<?php echo get_user_meta($user->ID, 'sale-sub-contractor_company')[0] ?>" placeholder="Företag" class="sub_cont_company<?php echo $user->ID; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-brand" data-dismiss="modal">Stäng</button>
                             <button type="button" class="btn btn-primary btn-brand spara_sub_contractor_info" data_id="<?php echo $user->ID; ?>">Redigera</button>
                                <button type="button" class="btn btn-primary btn-brand delete_sub_contractor_info" data_id="<?php echo $user->ID; ?>"  data_name="<?php echo $user_info->user_firstname; ?>">Ta bort</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>


        </div>
    </div>
<?php wp_footer(); ?>