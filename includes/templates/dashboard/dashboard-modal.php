<?php
/**
 * Single invoice modal. Opens by JS and show information for selected invoice. Populated by AJAX call.
 */

global $current_user_role; ?>
<div id="settings-modal" class="modal fade" role="dialog">
    
    
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <form method="post" enctype="multipart/form-data">
                <div class="modal-loader"></div> 
                <input type="hidden" name="quick-order-handle" value="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Verktyg" ); ?></h4>
                </div>
                <div class="modal-body setting-modal-body">
                    
                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>