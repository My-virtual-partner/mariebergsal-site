<?php $recervation_methords = get_field('order_recervation_method', $_GET['order-id']);




$reservation_field = get_field('order_recervation_method',$_GET["order-id"]);
$order_recervation_method_id = get_field('order_recervation_method_id',$_GET["order-id"]);
$egen_reservation=get_field('order_recervation_method_egen',$_GET['order-id']);


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<label for="reservationer_type"><strong><?php echo __("Reservationer"); ?></strong></label>

<div style="margin-bottom: 10px;">
    <textarea name="reservation_egen_text" id="" cols="30" rows="5" class="reservationEgenText" 

	placeholder="Skriv in egen reservation"><?php echo get_field('order_recervation_method_egen',$_GET['order-id'])?></textarea>
</div>

	<div  class="reservationer-type">
            <select id="reservationer_type" name="reservationer_type[]" class="mdb-select form-control" multiple style="">
       
            <?php
		foreach(getReservartion() as $value){?>
		    <option id="<?php echo $value->id; ?>" value="<?php echo $value->id; ?>"
			<?php if($value->id == getReservartion($project_type_id)){ echo "selected";}?>
			<?php if(in_array($value->id,$order_recervation_method_id)){ echo "selected";}?> ><?php echo $value->name; ?></option>
		 <?}?>
     
    </select>

        </div> <?php //}  ?>

        <script>
        jQuery(document).ready(function(){
			
         jQuery('#reservationer_type').multiselect({
          nonSelectedText: 'Välj reservationer',
          nSelectedText: 'valda',
          enableFiltering: true,
          enableCaseInsensitiveFiltering: true,
          buttonWidth:'400px',
          placeholder : "Select Zone(s)"
         });
         
        
	jQuery('select#order_status_betainingstyp').change(function(){
		if(jQuery(this).val() == '7'){
 let saved_data = [31];
				jQuery('select[multiple]').each(function() {
  jQuery('option', this).filter((_, e) => saved_data.includes(+e.value)).prop('selected', true);

  jQuery(this).multiselect({
    texts: {
      placeholder: jQuery(this).attr("title")
    }
  });
});
  jQuery("#reservationer_type").multiselect('refresh');
		}
			
});
	 
   
         
         });
        </script>
