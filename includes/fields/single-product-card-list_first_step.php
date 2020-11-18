<?php

/**
 * Single product card. Used to populate product grid in field-product-list.php
 */
//$mainid =  get_the_ID();
$product = new WC_Product(get_the_ID());
$image   = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );

$image_url = $image[0];
if ( ! $image ) {
    $image_url = get_field( 'product_placeholder', 'options' );
}


$attributes = $product->get_attributes();
$regular_price=$product->get_regular_price()*25/100;
$total_price=$product->get_regular_price()+$regular_price;
$attributes_for_json = array();

if ( $attributes ) {
    foreach ( $attributes as $key => $value ) {

        if ( $value['is_taxonomy'] ) {
            $attribute_names = wc_get_product_terms( $product->ID, $value['name'], array( 'fields' => 'names' ) );
        } else {
            $attribute_names = array_map( 'trim', explode( WC_DELIMITER, $value['value'] ) );
        }
        $name  = $value['name'];
        $title = wc_attribute_label( $value["name"] ) ;

        array_push( $attributes_for_json, array(
            'title'   => $title,
            'id'      => $value["id"],
            'name'    => $name,
            'options' => $attribute_names
        ) );
    }
    $json_attributes = htmlspecialchars( json_encode( $attributes_for_json, JSON_UNESCAPED_UNICODE ) );

}

?>

        <tr>
            <td width="15%">

                <img class="img-product" src="<?php echo $image_url; ?>" alt="" style="width: auto;max-height: 40px;">

            </td>
            <td width="25%" style="text-align: left">
                <p style=""><?php echo $product->get_title(); ?></p>
            </td>


            <td  width="15%">
                <strong style="text-align: center;">
                    <?php


                    if($product > 0){

                 if ($product->get_sale_price()) {
		$fromDate =  get_post_meta($product->get_id(),'_sale_price_dates_from',true);
  $toDate =get_post_meta($product->get_id(),'_sale_price_dates_to',true);
  if(empty($fromDate) && empty($toDate)){
	   $p_regular_price_decemal = '<i class="fa fa-certificate" style="color:red"></i> '.wc_price($product->get_sale_price());
  }else{
$_sale_price_dates_from = date('Y-m-d', $fromDate);
if(!empty($_sale_price_dates_from)){ 
  $Begin_date = date('Y-m-d', strtotime($_sale_price_dates_from . ' +1 day'));
}
$_sale_price_dates_to = date('Y-m-d',$toDate);
if(!empty($_sale_price_dates_to)){ 
 $End_date = date('Y-m-d', strtotime($_sale_price_dates_to . ' +1 day'));
}else{
	if(!empty($_sale_price_dates_from)){ 
	$End_date = date('Y-m-d', strtotime("+1 day"));
	}
}
  $today = date("Y-m-d");

     if($Begin_date <= $today && $today <= $End_date) {
		 $p_regular_price_decemal = '<i class="fa fa-certificate" style="color:red"></i> '.wc_price($product->get_sale_price());
        
    }else{
   $p_regular_price_decemal = wc_price($product->get_regular_price());
    } 
  }


                        } else {

                            $p_regular_price_decemal = wc_price($product->get_regular_price());
                        }

                        $p_price_null = '0';

                        echo  '<p
                                            
                                          
                                            class=""
                                            id="" style="text-align: left;">'.$p_regular_price_decemal.' 
                                        </p>';
                    }else{
                        echo '<p
                                            
                                          
                                            class="btn-brand btn-block top-buffer-half "
                                            id="" style="text-align: left;"> 0 kr
                                        </p>';
                    }

                    ?>
                </strong>
            </td>

            <td  width="15%">
                <strong style="text-align: center;">
                    <?php
                    if($product > 0){
                        $p_regular_price_decemal = wc_price($product->get_price_including_tax());

                        $p_price_null = '0';

                        echo  '<p
                                            
                                          
                                            class=""
                                            id="" style="text-align: left;">'.$p_regular_price_decemal.'
                                        </p>';
                    }else{
                        echo '<p
                                            
                                          
                                            class="btn-brand btn-block top-buffer-half "
                                            id="" style="text-align: left;"> 0 kr
                                        </p>';
                    }

                    ?>
                </strong>
            </td>

		<?php if ($product->get_sale_price()) { $classget =  "getUp"; } 	?>	
<td width="15%" id="checksaleon" class="<?php echo $classget; ?>"><?php if ($product->get_sale_price()) { echo  wc_price($total_price); }  
			?></td>
            <td  width="15%">
                <button
                    type="button"
                    data-toggle="modal"
                    data-product-sku="<?php echo $product->get_sku(); ?>"
                    data-product-id="<?php the_ID(); ?>"
                    data-product-image-url="<?php echo $image_url; ?>"
                    data-product-title="<?php the_title(); ?>"
                    data-product-webshop-url="<?php the_permalink(); ?>"
                    data-product-description="<?php //the_content(); ?>"
                    data-product-sale-price="<?php $sale_price='1';if( $product->is_on_sale() ) { echo $sale_price;
                        }else{echo "";}?>"

                   data-product-regular-price="<?php 
                            echo $product->get_price_including_tax().' kr';
?>"
                    <?php
						$regular_price;
                        $total_price;
                        ?> 
                        data-product-rea-price="<?php echo $total_price;?>"


                    data-terms = "<?php $term = wc_get_product_term_ids( $product->get_id(),'product_cat' );
                    $i=0;
                    $len = count($term);

                    foreach($term as $term_s){
                        $cat = get_term_by( 'id', $term_s, 'product_cat' );
                        if($cat->name != 'Uncategorized'):
                            echo $cat->name;
                            if ($i !== $len - 1){
                                echo '->';
                            }
                        endif;
                        $i++;
                    }; ?>"


                    <?php if ( $attributes ) : ?>
                        data-product-attributes="<?php echo addslashes( $json_attributes ); ?>"
                    <?php endif; ?>
                    data-target="#product-modal"
                    class="btn btn-alpha btn-block top-buffer-half toggle-product-modal"
                    id=""  style="width: 120px;float:right; "><?php echo __( "Mer info" ); ?>
                </button>

            </td>
            <td width="15%">

                <?php


                if ( ! $attributes ) : ?>

                    <button
                            type="button"
                            data-product-id="<?php the_ID(); ?>"
                            class="btn btn-brand btn-block top-buffer-half add-to-invoice-quick " data-head="true"
                            id="" style="width: 120px;float:right;"><?php echo __( "Lägg till" ); ?>
                    </button>

                <?php endif; ?>
            </td>

  </tr>
