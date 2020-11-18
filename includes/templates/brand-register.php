<?php
/**
 * Template used to display a brand register.
 * URL PATH: $_SERVER['REQUEST_URI'], '/brand-register'
 */

include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
$table_name = "brand-register-table";
?>
    <div class="container-db top-buffer-half">
        <div class="row">
            <div class="col-lg-12">


                <table class="table top-buffer-half">
                    <thead>
                    <tr>
                        <th class="sortable"
                            onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Leverantör" ); ?></th>
                        <th class="sortable"
                            onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( 'Uppgifter' ); ?></th>
                        <th class="sortable"
                            onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( 'Order Email' ); ?></th>

                    </tr>

                    </thead>
                    <tbody id="<?php echo $table_name ?>">

					<?php
					$taxonomies = get_terms('item', array('hide_empty' => 0, 'parent' =>0));
//print_r($taxonomies);
					if ( $taxonomies ) {
						foreach ( $taxonomies as $taxonomy ) : 
						
	
						?>
                            <tr>
                                <td><?php echo $taxonomy->name; ?></td>
<td><?php echo the_field('leverantor', 'item_'.$taxonomy->term_id); ?></td>

                                <td><?php echo the_field('order_emailid', 'item_'.$taxonomy->term_id); ?></td>

                            </tr>
						<?php
						endforeach;
					}
					?>


                    </tbody>
                </table>
            </div>


        </div>
    </div>
<?php wp_footer(); ?>