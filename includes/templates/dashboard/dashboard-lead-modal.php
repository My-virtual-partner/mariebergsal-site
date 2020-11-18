<?php
/**
 * Single lead modal. Opens by JS and show information for selected lead. Populated by AJAX call.
 */
?>
<div id="lead-modal" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="" value="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Verktyg för lead" ); ?></h4>
                </div>
                <div class="modal-body lead-modal-body">

                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>
