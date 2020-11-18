<?php
/**
 * Single product modal. Opens by JS and show information for product. Populated by AJAX call.
 */
?>
<div id="product-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title product-title"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="product-id" value="">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="col-lg-6 col-md-6 col-sm-6 text-center">
						<p id="prdouct_title" style="font-weight:bold;font-size: 20px;"></p>
                            <img id="product-image" src="">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <ul class="list-unstyled">
                                <li>

                                    <h4 class="product-title"></h4>
                                    <p class="product_category"></p>

                                </li>
                                <li ><strong>Artikelnummer : </strong><span class="artikle_nummer_pr"></span></li>
                                <!--<li><a id="product-webshop-url" href=""-->
                                       <!--target="_blank"><?php // echo __('Visa artikel i webbshop'); ?></a></li>-->
                                
                                <li> <div class="productPrice"
                                     style="background-color:#ff5912;color:#fafafa;padding: 5px;margin-bottom: 5px;"></div> </li>
                                <li><div class="ReaproductPrice"></div> </li>
                            </ul>
                            <hr>
                            <div id="product-content">
							
							</div>
							<p id="shortdescription"></p>
							<p id="fulldescription"></p>
                            <hr>

                            <?php
                            $current_step = $_GET["step"];
                            if ($current_step == 0){ ?>
                                <input title="<?php echo __("Huvudartikel") ?>" type="checkbox" class="head_product"
                                       name="head_product" id="" checked>

                                <?php

                            }else{

                            ?>
                            <input title="<?php echo __("Huvudartikel") ?>" type="checkbox" class="head_product"
                                   name="head_product" id="">
                            <?php    }

                            ?>

                            <label for="head_product"><?php echo __("Huvudartikel") ?></label>
							<div id="checksale">
									<input type="checkbox" id="not_sale" value="1">
								   <label for="head_product"><?php echo __("Använd ord. pris") ?></label>		</div>
                            <br>
                            <label for="quantity"><?php echo __("Antal") ?></label>
                            <input type="number" value="1" name="quantity" id="quantity">
                            <label class="top-buffer-half"
                                   for="line_item_special_note"><?php echo __("Anteckningar för denna artikel"); ?></label>
                            <input type="text" name="line_item_special_note" id="line_item_special_note">
                            <hr>
                            <div id="product-attributes">

                            </div>

                            <hr>
                            <input type="hidden" id="product-variation-id">
                            <button
                                    data-product-id=""
                                    class="btn btn-brand btn-block top-buffer add-to-invoice"><?php echo __("Lägg till") ?>
                            </button>

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>