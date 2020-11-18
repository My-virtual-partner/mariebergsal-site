<div id="rapporter_tab" class="tab-pane fade top-buffer-half">
    <?php
    $table_name = 'rapportTable';
    ?>
    <H1 class="uper-case">
        Rapporter

    </H1>
    <h4 class="uper-case" style="font-weight:bold" >Rapporttyp</h4>
    <!--<label class="switch">
      <input type="checkbox" id="turn_around_time">
      <span class="slider round"></span>
    </label>-->

    <label class="switch">
        <div class="Orde-lead">
            <select name="turn_around_time" id="turn_around_time" class="RapportFrom">
                <option value="Order" >Ordervärde</option>
                <option value="leadTid">Ledtider</option>
            </select>
        </div>
    </label>

    <div class="row">
        <div class="col-md-3 top-buffer-half turn-off">
            <label for="">Steg från</label>
            <select name="rapport_Step_from" id="rapport_Step_from"
                    class="RapportStepFrom  js-sortable-select">
                <option value="none" >Välj steg</option>
                <option value="leadTid">Leads skapat</option>
                <option value="projectTid">Säljare Leads konverterat till projekt</option>
                <option value="offertTid">Säljare Skapat offert</option>
                <option value="AcceptTid">Kund accepterat / order skapad</option>
                <option value="DenyTid">Kund nekat</option>
                <option value="ekoForskottfaktura">Ekonomi- Skapa fakturaunderlag</option>
                <option value="sendadvancedfortnox">Ekonomi - förskottsfaktura</option>
                <option value="sendfinalfortnox">Ekonomi -  slutfaktura</option>
                <option value="material_order"> Order​​Beställt material</option>
                <option value="order_approval"> Ordererkännande</option>
                <option value="good_received"> Varor hemma</option>
                <option value="goods_delivered"> Levererat</option>
                <option value="good_rest_noted">Rest</option>
                <option value="Grovplanerad"> Planering - Grovplanerad</option>
                <option value="Preliminärplanerad"> Planering - Preliminärplanerad</option>
                <option value="Detaljplanerad"> Planering - Detaljplanerad</option>
                <option value="comp_subcontractors">UE färdig/avslutad</option>
                <option value="projectcompleted"> Projekt avslutat</option>

                <!--      <option value="">Planering - beställt material</option>
         <option value=""> Planering - Grovplanerad</option>
         <option value=""> Planering - Preliminärplanerad</option>
         <option value="">Planering - Detaljplanerad</option>

         <option value="">Restjobb</option>
         <option value="">Projekt avslutat</option>
                -->
            </select>
        </div>

        <div class="col-md-3 top-buffer-half turn-off">
            <label for="">Steg till</label>
            <select name="rapport_Step_till" id="rapport_Step_till"
                    class="RapportStepTill  js-sortable-select">
                <option value="none" >Välj steg</option>
                <option value="leadTid">Leads skapat</option>
                <option value="projectTid">Säljare Leads konverterat till projekt</option>
                <option value="offertTid">Säljare Skapat offert</option>   
                <option value="AcceptTid">Kund accepterat / order skapad</option>
                <option value="DenyTid">Kund nekat</option>
                <option value="ekoForskottfaktura">Ekonomi- Skapa fakturaunderlag</option>
                <option value="sendadvancedfortnox">Ekonomi - förskottsfaktura</option>
                <option value="sendfinalfortnox">Ekonomi -  slutfaktura</option>
                <option value="material_order"> Order​​Beställt material</option>
                <option value="order_approval"> Ordererkännande</option>
                <option value="good_received"> Varor hemma</option>
                <option value="goods_delivered"> Levererat</option>
                <option value="good_rest_noted">Rest</option>

                <option value="Grovplanerad"> Planering - Grovplanerad</option>
                <option value="Preliminärplanerad"> Planering - Preliminärplanerad</option>
                <option value="Detaljplanerad"> Planering - Detaljplanerad</option>
                <option value="comp_subcontractors">UE färdig/avslutad</option>
                <option value="projectcompleted"> Projekt avslutat</option>
                <!--     <option value="">Planering - beställt material</option>
                 <option value=""> Planering - Grovplanerad</option>
                 <option value=""> Planering - Preliminärplanerad</option>
                 <option value="">Planering - Detaljplanerad</option>
                 <option value="">UE färdig/avslutad</option>
                 <option value="">Restjobb</option>
                 <option value="">Projekt avslutat</option>
                -->
            </select>
        </div>

        <div class="col-md-3 top-buffer-half">
            <label for="">Från</label>
            <input type="text" class="FromDateRapport cstm_date_picker" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-md-3 top-buffer-half">
            <label for="">Till</label>
            <input type="text" class="ToDateRapport cstm_date_picker" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-md-3 top-buffer-half">
            <label for="project_type"><?php echo __("Typ av projekt") ?></label>

            <select id="projecttype" name="projecttype" class="form-control js-sortable-select" data-table_name="rapportTable">
                <option value='Alla'><?php echo __("Alla"); ?></option>
                <?php
                $current_user_role = get_user_role();
               $project_roles_steps = modify_projectType();
                foreach ($project_roles_steps as $key => $value) :
                    ?>


                <option <?php
                    ?>
                    value="<?php echo $key; ?>"><?php echo get_option('options_' . $value . '_0_project_type_name', 'options'); ?>
                    </option>


                    <?php endforeach; ?>


            </select>
        </div>

        <div class="col-md-3 top-buffer-half">
            <label for="payment_type"><?php echo __("Betalningstyp"); ?></label>

            <select id="payment_type" name="payment_type" class="form-control js-sortable-select">
                <option value='Alla'><?php echo __("Alla"); ?></option>
                <?php
                $beta = array('Kortbetalning', 'Delbetalas med kort i kassan', 'Swish', 'Faktura', 'Förskottsfaktura och slutfaktura', 'Ecster privatlån', 'Betalas vid hämtning');
                foreach ($beta as $vali) {
                    ?>
                    <option value="<?php echo $vali; ?>" <?php selected($beta_match, $vali); ?>><?php echo $vali; ?></option>
                <?php } ?>



            </select>
        </div>

    </div>
    <div class="row">


        <div class="col-md-3 top-buffer-half">
            <label for="">Säljare</label>
            <select name="rapportSeller" id="rapport_Seller"
                    class="RapportSeller  js-sortable-select">


                <?php
                get_all_sellers_dropdown();
                ?>
            </select>
        </div>
        <div class="col-md-3 top-buffer-half">
            <label for="">Status</label>
            <select name="statusRapport" id="statusRapport"
                    class="js-sortable-select">
                <option value="true">Order bekräftad</option>
                <option value="false">Nekats</option>
                <option value="Kundfråga">Kundfråga</option>
                <option value="archieved">Arkiverad kopia</option>
                <option value="">Väntar</option>
                <option value="Acceptavkund">Accepterad av kund</option>
                <option value="alla" selected>Alla</option>
            </select>
        </div>

        <div class="col-md-3 top-buffer-half" >
            <?php
            $current_user_role = get_user_role();
            get_internal_project_status_dropdown('alla', "internal_project_status_dropdown", 'rapportTable', "");
            ?>

        </div>


        <div class="col-md-3 top-buffer-half">
            <?php
            get_office_dropdown("RapportoOfficeConnectionFilter", null, null, null, '');
            ?>
        </div>

        <div class="col-md-3 top-buffer-half" >
            <label for="">Faktura 1 Synkstatus</label>
            <select id="syn_fortnox1" name="syn_fortnox1" class="form-control js-sortable-select">
                <option value="all">all</option>

                <option value="0">Synk</option>
                <option value="1">Ej Synk</option>
            </select>

        </div>

        <div class="col-md-3 top-buffer-half" >
            <label for="">Faktura 2 Synkstatus</label>
            <select id="syn_fortnox2" name="syn_fortnox2" class="form-control js-sortable-select">
                <option value="all">all</option>
                <option value="0">Synk</option>
                <option value="1">Ej Synk</option>
            </select>

        </div>

        <div class="col-md-3 top-buffer-half">
            <label for="" style="visibility: hidden">Sök</label>
            <input type="button" value="Sök" class="btn btn-beta btn-block btn-menu rapportTrigger">
        </div>
        <div class="col-md-3 top-buffer-half">

            <form method='post' action=''>
                <label for="" style="visibility: hidden">Sök</label>
                <input type="hidden" value="exportreportdata" name="exportreportdata" />
                <textarea id="exportdatain" name='export_data' style='display: none;'></textarea>
                <input type="submit" value="Exportera till Excel" style='display: none;' class="btn btn-beta btn-block btn-menu exportdata">
            </form>
        </div>

    </div>
    <div class="top-buffer-half row">
        <table class="table ">
            <table class="table ">
                <thead>
                    <tr>
                        <th></th>
                        <th class="sortable"
                            onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Order"); ?></th>
                        <th class="sortable"
                            onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Skapat"); ?></th>
                        <th class="sortable"
                            onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Orderdatum"); ?></th>


            <!---    <th class="sortable"
                    onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Lead tid"); ?></th>
                <th class="sortable"
                    onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Project tid"); ?></th>

                <th class="sortable"
                    onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Accept tid"); ?></th>

                <th class="sortable"
                    onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Neckat  tid"); ?></th> -->

                        <th class="sortable"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Status"); ?></th>

                        <th class="sortable"
                            onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Projekt id"); ?></th>

                        <th class="sortable"
                            onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Kund"); ?></th>

                        <th class="sortable"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Säljare"); ?></th>
                        <th class="sortable"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Butik"); ?></th>
                        <th class="sortable"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Betalningstyp"); ?></th>
                        <th class="sortable"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Intern Projektstatus"); ?></th>

                        <th class="sortable time_around_text"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Total summa ex moms"); ?></th>
                        <th class="sortable time_around_text"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Faktura 1"); ?></th>
                        <th class="text-center"><?php echo( "Faktura 1 summa" ); ?></th>
                        <th class="sortable time_around_text"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Faktura 2"); ?></th>
                        <th class="text-center"><?php echo( "Faktura 2 summa" ); ?></th>
                    </tr>
                </thead>


                <tbody id="<?php echo $table_name ?>">


                </tbody>

            </table>
            <table class="table ">
                <table class="table ">
                    <thead>

                    </thead>


                    <tbody class="report_table">


                    </tbody>

                </table>
                </div>
                </div>
                <script>
                    jQuery(document).ready(function () {
                        jQuery(".cstm_date_picker").datepicker();
                    });</script>