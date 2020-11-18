
<div id="estimate_edits" class="modal fade" role="dialog">
    
    
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-loader"></div> 
                <input type="hidden" name="quick-order-handle" value="true">
                <input type="hidden" name="order_id" id="order_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Skicka affärsförslag per epost" ); ?></h4>
                </div>
                <div class="modal-body setting-modal-body">
				
				<div class="col-lg-12">
                   <div class="col-md-1" >Mottagare</div>
				   <div class="col-md-11">
				   <input type="text" name="receipt" id="receipt" data-role="tagsinput">
				   </div>
				   </div>
				
				<div class="col-lg-12">
                   <div class="col-md-1" >Ämne</div>
				   <div class="col-md-7" contenteditable='true' id="subject"></div>
				   </div>
				<div class="col-lg-12 top-buffer">
                   <div class="col-md-1">Meddelande</div>
				   <div class="col-md-7" id="message"></div>
				   </div>
				 <input type="button" style="width:30%" value="<?php echo __( "Skicka affärsförslag" ); ?>" name="user_email" id="esimateid">
                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js
"></script>