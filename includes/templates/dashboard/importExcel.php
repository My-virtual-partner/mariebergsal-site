<style>
#importExcel .modal-xl {
    width:600px !important;
    max-width: 1200px!important;
}
#importExcel .modal-content {
    height: 23em;
    /* text-align: center; */
}
</style>
<div id="importExcel" class="modal fade" role="dialog">
    
    
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <form method="post"  enctype="multipart/form-data">
			
                <div class="modal-loader"></div> 
           
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Ladda upp csv från Fortnox" ); ?></h4>
                </div>
                <div class="modal-body setting-modal-body">
<div class="container">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

       <div class="form-group">
        
            <input type="file" name="importExcelfile" class="custom-file-input" id="customFile">
        </div>

 
   <div class="mt-3"> <input type="submit" class="btn btn-primary" name="importExcel" value="Importera" /></div>
</form>

</div>
                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>