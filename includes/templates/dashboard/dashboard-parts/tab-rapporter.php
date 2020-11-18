<div id="rapporter_tab" class="tab-pane fade top-buffer-half">
    <?php
    $table_name = 'rapportTable';
    ?>
    <H1 class="uper-case">
        Rapporter

    </H1>
    <h4 class="uper-case" style="font-weight:bold" >Rapporttyp</h4>


    <label class="switch">
        <div class="Orde-lead">
            <select name="turn_around_time" id="turn_around_time" class="RapportFrom">
                <option value="Order" >Ordervärde</option>
				 <option value="tbkassa">Kassarapport</option>
				<option value="tbCost">TB rapport</option>
                <option value="leadTid">Ledtider</option>
				
            </select>
        </div>
    </label>

    <div class="row">
        <div class="col-md-3 top-buffer-half turn-off main_off">
            <label for="">Steg från</label>
            <select name="rapport_Step_from" id="rapport_Step_from"
                    class="RapportStepFrom  js-sortable-select">
                <option value="none" >Välj steg</option>
                <option value="leads_skapat_logs">Leads skapat</option>
                <option value="lead_to_prject_logs">Säljare Leads konverterat till projekt</option>
                <option value="offertTid">Säljare Skapat offert</option>
                <option value="order_accept_date">Kund accepterat / order skapad</option>
                <option value="kund_nekat_logs">Kund nekat</option>
                <option value="ekonomi_forskottsfaktura_logs">Ekonomi- Skapa fakturaunderlag</option>
                <option value="imm-sale_invoice_create_forts">Ekonomi - förskottsfaktura</option>
                <option value="imm-sale_invoice_create_slutfaktura">Ekonomi -  slutfaktura</option>
                <option value="material_order"> Order​​Beställt material</option>
                <option value="order_approval"> Ordererkännande</option>
                <option value="good_received"> Varor hemma</option>
                <option value="goods_delivered"> Levererat</option>
                <option value="good_rest_noted">Rest</option>
                <option value="Grovplanerad"> Planering - Grovplanerad</option>
                <option value="Preliminärplanerad"> Planering - Preliminärplanerad</option>
                <option value="Detaljplanerad"> Planering - Detaljplanerad</option>
                <option value="imm-project_order-completed">UE färdig/avslutad</option>
                <option value="projectcompleted"> Projekt avslutat</option>

            
            </select>
        </div>

        <div class="col-md-3 top-buffer-half turn-off main_off">
            <label for="">Steg till</label>
            <select name="rapport_Step_till" id="rapport_Step_till"
                    class="RapportStepTill  js-sortable-select">
                <option value="none" >Välj steg</option>
                <option value="leads_skapat_logs">Leads skapat</option>
                <option value="lead_to_prject_logs">Säljare Leads konverterat till projekt</option>
                <option value="offertTid">Säljare Skapat offert</option>
                <option value="order_accept_date">Kund accepterat / order skapad</option>
                <option value="kund_nekat_logs">Kund nekat</option>
                <option value="ekonomi_forskottsfaktura_logs">Ekonomi- Skapa fakturaunderlag</option>
                <option value="imm-sale_invoice_create_forts">Ekonomi - förskottsfaktura</option>
                <option value="imm-sale_invoice_create_slutfaktura">Ekonomi -  slutfaktura</option>
                <option value="material_order"> Order​​Beställt material</option>
                <option value="order_approval"> Ordererkännande</option>
                <option value="good_received"> Varor hemma</option>
                <option value="goods_delivered"> Levererat</option>
                <option value="good_rest_noted">Rest</option>
                <option value="Grovplanerad"> Planering - Grovplanerad</option>
                <option value="Preliminärplanerad"> Planering - Preliminärplanerad</option>
                <option value="Detaljplanerad"> Planering - Detaljplanerad</option>
                <option value="imm-project_order-completed">UE färdig/avslutad</option>
                <option value="projectcompleted"> Projekt avslutat</option>
				
   
            </select>
        </div>
	<div class="col-md-3 top-buffer-half tbcosthosw  main_off" style="display:none">
            <label for="">Avslutat datum från</label>
            <input type="text" class="finishedProjectfrom cstm_date_picker" placeholder="yyyy-mm-dd">
        </div>
		 <div class="col-md-3 top-buffer-half tbcosthosw  main_off" style="display:none">
            <label for="">Avslutat datum till</label>
            <input type="text" class="finishedProjectto cstm_date_picker" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-md-3 orderterm showkasa tbcosthosw top-buffer-half turn-off main_off">
            <label id="from" for="">Från</label>
            <input type="text" class="FromDateRapport cstm_date_picker" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-md-3 orderterm showkasa tbcosthosw top-buffer-half turn-off main_off">
            <label id="to" for="">Till</label>
            <input type="text" class="ToDateRapport cstm_date_picker" placeholder="yyyy-mm-dd">
        </div>
		 <div class="col-lg-3 col-md-3 col-sm-6 "><?php get_project_status_dropdownValue( "order-by-this-project-status_" . $project_status, $table_name, "top-buffer-half" ,'rapportTable',"Alla"); ?>
        </div>
        <div class="col-md-3 top-buffer-half no_kassa orderterm">
            <label for="project_type"><?php echo __("Typ av projekt") ?></label>

      <select id="project_type" name="project_type" class="form-control js-sortable-select" data-table_name="all-table">
                                     <option value='Alla'><?php echo __("Alla"); ?></option>
                                    <?php

//$projectype_search = array(1=>"Hembesök",2=>"Eldstad inklusive montage",3=>"Service och reservdelar",4=>"Kassa ",5=>"ÄTA",6=>"Självbyggare",7=>'Specialoffert',8=>'Solcellspaket');
                                    foreach (projectypeName() as $project_typekey => $project_typevalue) : ?>


                                        <option value="<?php echo $project_typekey; ?>"><?php echo $project_typevalue; ?>
                                        </option>


                                    <?php endforeach; ?>


                                </select>
        </div>

   

     <div class="col-md-3 top-buffer-half ">
            <label for="payment_type"><?php echo __("Betalningstyp"); ?></label>

            <select id="payment_type" name="payment_type" class="form-control js-sortable-select">
                <option value='Alla'><?php echo __("Alla"); ?></option>
                <?php
                $beta = paytemMethod();
                foreach ($beta as $key => $vali) {
                    ?>
                    <option value="<?php echo $key; ?>" <?php selected($beta_match, $vali); ?>><?php echo $vali; ?></option>
                <?php } ?>



            </select>
        </div>

        <div class="col-md-3 top-buffer-half ">
            <label for="">Säljare</label>
            <select name="rapportSeller" id="rapport_Seller"
                    class="RapportSeller  js-sortable-select">


                <?php
                get_all_sellers_dropdown();
                ?>
            </select>
        </div>
        <div class="col-md-3 top-buffer-half no_tbcost orderterm">
            <label for="">Status</label>
            <select name="statusRapport" id="statusRapport"
                    class="js-sortable-select ">
					<option value="alla" selected>Alla</option>	
					<?php foreach(orderstatusName() as $getKey => $getNameOrder){ ?>
					    <option value="<?=$getKey?>"><?=$getNameOrder?></option>
					<?php } ?>
				 
              
         
            </select>
        </div>

        <div class="col-md-3 top-buffer-half no_kassa" >
            <?php
            $current_user_role = get_user_role();
            get_internal_project_status_dropdown('alla', "internal_project_status_dropdown", 'rapportTable', "");
            ?>

        </div>


        <div class="col-md-3 top-buffer-half ">
            <?php
            get_office_dropdown("RapportoOfficeConnectionFilter", null, null, null, '');
            ?>
        </div>

        <div class="col-md-3 orderterm top-buffer-half turn-off main_off" >
            <label for="">Faktura 1 Synkstatus</label>
            <select id="syn_fortnox1" name="syn_fortnox1" class="form-control js-sortable-select">
                <option value="all">all</option>

                <option value="true">Synk</option>
                <option value="false">Ej Synk</option>
            </select>

        </div>

        <div class="col-md-3 orderterm top-buffer-half turn-off main_off" >
            <label for="">Faktura 2 Synkstatus</label>
            <select id="syn_fortnox2" name="syn_fortnox2" class="form-control js-sortable-select">
                <option value="all">all</option>
                <option value="true">Synk</option>
                <option value="false">Ej Synk</option>
            </select>

        </div>

        <div class="col-md-3 top-buffer-half ">
            <label for="" style="visibility: hidden">Sök</label>
            <input type="button" value="Sök" class="btn btn-beta btn-block btn-menu rapportTrigger">
        </div>
        <div class="col-md-3 top-buffer-half exportdata main_off" style='display: none;'>

            <form method='post' action=''>
                <label for="" style="visibility: hidden">Sök</label>
                <input type="hidden" value="exportreportdata" name="exportreportdata" />
                <textarea id="exportdatain" name='export_data' style='display: none;'></textarea>
                <input type="submit" value="Exportera till Excel"  class="btn btn-beta btn-block btn-menu ">
            </form>
			
        </div>
		    <div class="col-md-3 top-buffer-half kasa_exportdata main_off" style='display: none;'>

            <form method='post' action=''>
                <label for="" style="visibility: hidden">Sök</label>
                <input type="hidden" value="kasa_exportreportdata" name="kasa_exportreportdata" />
                <textarea id="kasa_export_data" name='kasa_export_data' style='display: none;'></textarea>
                <input type="submit" value="Exportera till Excel"  class="btn btn-beta btn-block btn-menu ">
            </form>
			
        </div>
<div class="col-md-3 top-buffer-half exportdata_tb main_off" style='display: none;'>
 <form method='post' action=''>
                <label for="" style="visibility: hidden">Sök</label>
                <input type="hidden" value="exportreportdata_tb" name="exportreportdata_tb" />
                <textarea id="exportdatain_tb" name='export_data_tb' style='display: none;'></textarea>
                <input type="submit" value="Exportera till Excel"  class="btn btn-beta btn-block btn-menu ">
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
						<th class="text-center nokasas  tbcost" style="display:none"><?php echo( "Avslutat datum" ); ?></th>
					
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
                        <th class="sortable projekttyp"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Intern Projektstatus"); ?></th>
						<th class="text-center nokasas tbcost" style="display:none"><?php echo( "Total summa" ); ?></th>
                        <th class="sortable time_around_text kasa_text"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Total summa ex moms"); ?></th>
						<th class="sortable showkasa hidefor" 
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Inkl. moms"); ?></th>
                        <th class="sortable  nottbcost"
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Faktura 1"); ?></th>
                        <th class="text-center nottbcost" ><?php echo( "Faktura 1 summa" ); ?></th>
                        <th class="sortable nottbcost "
                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Faktura 2"); ?></th>
                        <th class="text-center nottbcost"><?php echo( "Faktura 2 summa" ); ?></th>

						<th class="text-center nokasas tbcost" style="display:none"><?php echo( "Lev. fakt" ); ?></th>
												<th class="text-center nokasas tbcost" style="display:none"><?php echo( "TB" ); ?></th>
					
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