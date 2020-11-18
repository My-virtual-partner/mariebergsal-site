<?php
/**
 * Single To-do item modal. Opens by JS and show information/tools for To-do item. Populated by AJAX call.
 */
?>
<div id="prepayment-invoice-modal" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="prepayment-invoice" value="true">
                <input type="hidden" id="prepayment-invoice-order_id" name="prepayment-invoice-order_id" value="">
                <!--<input type="hidden" id="prepayment-invoice-project_id" name="prepayment-invoice-project_id" value="">-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __( "Skapa fakturaunderlag" ); ?></h4>
                    <strong><span>Här kan du skapa fakturaunderlag. Vid 100% skapas en faktura på hela beloppet. Vid exempelvis 35% skapas en faktura på 35% och en faktura på resterande 65%, dvs förskottsfaktura och slutfaktura.</span></strong>
                </div>
                <div class="modal-body">
                    <label
                            class='top-buffer-half'><?php echo __( 'Ange procent' ); ?></label>
                    <input type="number"
                           min="0"
                           value="35"
                           name="prepayment-invoice_percentage"
                           class="form-control"
                           id="">
                    <button type="submit" onclick="closeModalAndSendForm();"
                            class="btn btn-brand btn-block top-buffer-half">
                        <?php echo __("Skapa"); ?>
                    </button>
                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
            </form>
        </div>
    </div>
</div>
