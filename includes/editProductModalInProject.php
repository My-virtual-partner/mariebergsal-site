<div class="modal fade" id="findProdcutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ändra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                /**
                 * Lead create form.
                 * Simply creates a new lead when posted.
                 */
                include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
                $params = array(
                    'posts_per_page' => 10,
                    'post_type'      => 'product',

                );

                $brand     = 'item';
                $orderby      = 'name';
                $hierarchical = 1;      // 1 for yes, 0 for no

                $args_brand = array(
                    'taxonomy'     => $brand,
                    'orderby'      => $orderby,
                    'hierarchical' => $hierarchical,

                );

                $all_categories_brand = get_categories( $args_brand );

                $wc_query = new WP_Query( $params );

                ?>
                <div class="col-md-4 col-sm-12">
                    <label class="top-buffer-half" for="imm-sale-search"><?php echo __( "Sökning" ) ?></label>
                    <input value="" type="text" name="imm-sale-search" class="form-control" id="imm-sale-search"
                           placeholder="<?php echo __( "Sök efter artikel..." ); ?>">
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 top-buffer-half" id="product_display">
                    <div class="row">

                        <?php
                        while ( $wc_query->have_posts() ) :
                            $wc_query->the_post();
                            include( 'fields/artikelar_products_list.php' );
                        endwhile; ?>



                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>