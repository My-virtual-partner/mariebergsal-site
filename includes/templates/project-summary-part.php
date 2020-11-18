<?php
/**
 * Part of the project summary view.
 */

$order_summary_heading     = get_field( 'order_summary_heading', $order->ID );
$order_summary_description = get_field( 'order_summary_description', $order->ID );

$order_summary_addon_heading     = get_field( 'order_summary_addon_heading', $order->ID );
$order_summary_addon_description = get_field( 'order_summary_addon_description', $order->ID );


$affarsforslaget_gallertom = get_field( 'affarsforslaget_gallertom', $order->ID );

if ( ! $order_summary_description ) {
	$order_summary_description = get_field( 'order_summary_description', 'options' );
}

?>
<input value="<?php echo $order_summary_heading; ?>" type='text' class='form-control' name='project_heading'
       id='project_heading' onChange="save(event)">
<input type="hidden" name="order-id" id="order-id" value="<?php echo $order->ID;?>">


<label class='top-buffer-half'
       for='project_description'><strong><?php echo __( 'Beskrivning av projektet' ); ?></strong></label>
<textarea class='form-control' rows='10' name='project_description'
          id='project_description' onChange="save(event)"><?php echo $order_summary_description; ?></textarea>

<hr>
<label class='top-buffer-half' for='order_summary_addon_heading'><strong><?php echo __( 'Underrubrik' ); ?></strong></label>
<input value="<?php echo $order_summary_addon_heading; ?>" type='text' class='form-control' name='order_summary_addon_heading'
       id='order_summary_addon_heading' onChange="save(event)">


<label class='top-buffer-half'
       for='order_summary_addon_description'><strong><?php echo __( 'Beskrivning' ); ?></strong></label>
<textarea class='form-control' rows='10' name='order_summary_addon_description'
          id='order_summary_addon_description' onChange="save(event)"><?php echo $order_summary_addon_description; ?></textarea>


<label class='top-buffer-half' for='affarsforslaget_gallertom' ><strong><?php echo __( 'Gäller t.o.m' ); ?></strong></label>
<input value="<?php echo $affarsforslaget_gallertom; ?>" type='date' class='form-control' name='affarsforslaget_gallertom'
       id='affarsforslaget_gallertom' onChange="save(event)">

<hr>