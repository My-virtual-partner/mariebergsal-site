<?php
//$data = send_estimate($_GET['order-id']);
  

   
?>
<div id="sms_edits" class="modal fade" role="dialog">
    
    
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-loader"></div> 
                <input type="hidden" name="quick-order-handle" value="true">
                <input type="hidden" name="order_id" id="order_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Skicka affärsförslag per SMS" ); ?></h4>
                </div>
                <div class="modal-body setting-modal-body">
				<div class="col-lg-12">
                   <div class="col-md-4" ><?php echo __( "Telefonnummer (inkludera landskod, t.ex +46)" ); ?></div>
				   <input style="
    width: 30%;
" type="text" id="phone" value="">
				    <input type="hidden" id="links" value="">
				   </div>
				<div class="col-lg-12 top-buffer">
                   <div class="col-md-2">Meddelande</div>
				   <div class="col-md-7"><input  id="message" type="text" value="" maxlength="160"  style="border:0px solid	"/></div>
				   </div>
				   <div class="col-lg-12 top-buffer" >
				 <input type="button" style="width:30%" value="<?php echo __( "Skicka affärsförslag" ); ?>" id="smsid">
				 </div>
                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>