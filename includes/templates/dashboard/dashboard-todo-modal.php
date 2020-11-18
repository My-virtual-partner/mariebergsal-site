<?php
/**
 * Single To-do item modal. Opens by JS and show information/tools for To-do item. Populated by AJAX call.
 */
?>
<div id="todo-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="" value="true">
                <div class="modal-header">
				
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Uppgift" ); ?></h4>
				
                </div>
                <div class="modal-body todo-modal-body">

                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>
