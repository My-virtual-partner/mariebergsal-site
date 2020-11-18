<div id="settings-mail-project" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
	 <a class="close" data-dismiss="modal">&times;</a>
        <div class="modal-content-mail">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="order_mail" value="true">
		<input type="hidden" id="brand_nameget" value="">

                <div class="modal-body setting-modal-project-body">
				  <div class="form-groupss col-md-6">
	
 	<label for="Leverantorens">Leverantorens e-post:</label><input type="text" id="supplier_email" value="" /> 
	</div>
		 <div class="form-groupss col-md-6">
	 <label for="Send">Skicka kopia till:</label>
	
	<input type="text" id="copy_email" value="order@mariebergs.com" />  
	</div>
	  <div class="row" style="width: 100%;   display: flex;">		 <div class="col-xs-1">	<label for="subject">Ämne</label></div>
<div class="col-xs-11">	<p contenteditable="true" id="newsubject"><?php //echo  $subject = __("Beställningsunderlag från ") . get_bloginfo('name'); ?><span id="user_subject"></span><?=" ".$fullname?></p>
</div>
</div>
<div id="user_texstarea" class="row">
<div class="col-xs-11"><p  id ="newofficeaddress" style="text-transform: none;"  contenteditable='true'><?=get_the_title($office_connection)?> beställer följande</p></div>

<div class="col-xs-12"><p id="newblock" contenteditable='true'>Följande beställning avser Kund <?=$fullname?>  och Projekt <span id="user_subject_middle"></span>  <span class="projectappend"></span></p><p class="newtitle" contenteditable='true'>Skorstensinfo</p><table id="otherinforadd"></table><br><p contenteditable='true'>Orderrader:</p><table id="product_data"><tr ><td style='padding: 4px;' contenteditable='true' >Produktnamn</td><td contenteditable='true' style='padding: 4px;'>Artikelnr</td><td contenteditable='true' style='padding: 4px;'>Antal</td></tr></table>	

<p  id ="pofficeaddress" contenteditable='true'> <span id="officeaddress"></span><br><?php echo " Telefonnr: ".$newaddress; ?> Märkning: <span id="user_subject_below"></span><?=" ".$fullname?></p>		</div>
			</div>
				<input type="button" style="width:30%" value="Skicka beställning" name="user_email" id="previewsent">
			<!---	<input type="button" style="width:30%" value="Preview mails" data-toggle="modal" data-target="#settings-mail-project_previewmode" name="user_email" id="previewallsent">-->
                </div>

            </form>
        </div>
    </div>
</div>