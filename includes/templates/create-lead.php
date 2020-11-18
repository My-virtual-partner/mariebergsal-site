<?php
/**
 * Lead create form.
 * Simply creates a new lead when posted.
 */
include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
$lead_id = $_GET["lead-id"];
?>





    <div class="container">
        <div class="row">
		<form id="invoice-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="create_lead" value="true">

            <?php include_once('lead-form.php');?>
			 <?php if ($lead_id) { ?> 
                <div class="col-lg-6 top-buffer">
                <?php } else { ?>
                    <div class="col-lg-12 top-buffer">
                    <?php } ?>
                    <input value="<?php echo __("Spara"); ?>" type="submit" class="btn btn-brand btn-block" id="">

                </div>
                <?php if ($lead_id) { ?> 
                    <div class="col-lg-6 top-buffer">
                        <a href="<?php echo site_url() . "/new-project?lead-id=" . $lead_id; ?>" class="btn btn-brand btn-block"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Konvertera lead till projekt</font></font></a>


                    </div>
                <?php } ?>
			</form>
        </div>
    </div>

<?php wp_footer(); ?>