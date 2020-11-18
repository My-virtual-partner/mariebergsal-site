<?php
/**
 * Single project modal. Opens by JS and show information for project. Populated by AJAX call.
 */

global $current_user_role; ?>
<div id="settings-modal-project" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="quick-project-handle" value="true">
                <div class="modal-header bg-project">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Verktyg för projekt" ); ?></h4>
                </div>
                <div class="modal-body setting-modal-project-body">
                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>