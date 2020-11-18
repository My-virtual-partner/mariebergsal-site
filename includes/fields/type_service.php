<?php 


/*echo $field = get_field_object('typ_av_service');
echo $value = get_field('typ_av_service');
echo $label = $field['Select'][ $value ];


echo $field = get_field_object('beskrivning');
echo $value = get_field('beskrivning');
echo $label = $field['Text Area'][ $value ];*/




 $service = get_post_meta($_GET['order-id'], 'type_of_service', true);

?>

<div class="drpdns">
<h4 class="type-service">typ av service:</h4>
        <select class="country" name="typeservice" id="typeservice" style="height: 35px;
    width: 300px;">
	
            
            <option <?php if($service == 'Service') echo "selected"; ?>>Service</option>
          <option <?php if($service == 'Reklamation') echo "selected"; ?>>Reklamation</option>
		  <option <?php if($service == 'Garanti') echo "selected"; ?>>Garanti</option>
        </select>
</div>
<div class="drpdns">
<h4 class="type-service">Kundens beskrivning av problemet:</h4>
<textarea name="beskrivning" id="beskrivning" style="height: 100px;
    width: 300px;"> <?php  echo get_post_meta( $_GET['order-id'], 'beskrivning',true); ?></textarea>

<input type ="hidden"  name="pid" id="pid" value="<?= $_GET['order-id']; ?>">
</div>
<!--<input type="button" id="svedaara" value="Save" style="background-color: #ff5912!important;
    color: #fafafa!important; margin-top: 20px;"> -->


                                     
