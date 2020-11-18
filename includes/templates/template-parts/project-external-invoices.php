<?php
$external_invoices_json = get_post_meta( $project_id, 'external_invoices_json', true );
//$external_invoices      = return_array_from_json( $external_invoices_json );
$external_invoices = getCostSupplier($project_id);
?>

<table id="externalInvoiceTable" class=" table order-list">
	<thead>
	<tr>
		<td class="col-sm-2"><strong><?php echo __( "Fakturanummer" ); ?></strong></td>
		<td class="col-sm-2"><strong><?php echo __( "Bokf. datum" ); ?></strong></td>
		<td class="col-sm-3"><strong><?php echo __( "Beskrivning" ); ?></strong></td>
		<td class="col-sm-2"><strong><?php echo __( "Pris" ); ?></strong></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 0;
	foreach ( $external_invoices as $external_invoice ) : ?>
		<tr>
			<td class="col-sm-2">
				<input type="text" value="<?php echo $external_invoice->invoice_number ?>" name="external_invoice[<?php echo $i ?>][invoice_number]" class="form-control"/>
			</td>
			<td class="col-sm-2">
				<input type="text" value="<?php echo $external_invoice->invoice_date ?>" name="external_invoice[<?php echo $i ?>][invoice_date]" class="form-control"/>
			</td>
			<td class="col-sm-3">
				
				<input type="text" value="<?php echo ($external_invoice->invoice_description) ?>" name="external_invoice[<?php echo $i ?>][invoice_description]" class="form-control"/>
			</td>
			<td class="col-sm-2">
				<input type="text" value="<?php echo $external_invoice->invoice_price ?>" name="external_invoice[<?php echo $i ?>][invoice_price]" class="form-control"/>
			</td>
			
			<td class="col-sm-1"><input type="button" class="ibtnDel btn btn-alpha btn-block" value="Ta bort">

			</td>
		</tr>
		<?php
		$i++;
	endforeach; ?>
	</tbody>
	
	<tbody>
            <?php
	$counter = count($external_invoices); 
	if($i == 0){	 ?>
		<tr>
			<td class="col-sm-2">
				<input type="text" name="external_invoice[<?php echo $counter ?>][invoice_number]" class="form-control"/>
			</td>
			<td class="col-sm-2">
				
				<input type="text" name="external_invoice[<?php echo $counter ?>][invoice_date]" class="form-control"/>
			</td>
			<td class="col-sm-3">
				
				<input type="text" name="external_invoice[<?php echo $counter ?>][invoice_description]" class="form-control"/>
			</td>
			<td class="col-sm-2">
				<input type="number" name="external_invoice[<?php echo $counter ?>][invoice_price]" class="form-control"/>
			</td>
			<td class="col-sm-1"><input type="button" class="ibtnDel btn btn-alpha btn-block" value="Ta bort">

			</td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr>
		<td style="text-align: left;">
			<input type="button" class="btn btn-brand btn-block " id="addExternalInvoiceTableRow"
			       value="<?php echo __( "Lägg till rad" ); ?>"/>
		</td>
       <td><button type="submit" class="btn btn-brand btn-block " id="leverantörsfaturor_submit"><?php echo __( "Spara och uppdatera projekt"); ?></button></td>
	 <?php if($current_user_role == 'sale-administrator'){ ?>

	 <td><button type="button" class="btn btn-brand btn-block "  data-toggle="modal" data-target="#importExcel"><?php echo __( "Synka leverantörsfakturor"); ?></button></td>
	 <?php } ?>
	</tr>
	<tr>
	</tr>
	</tfoot>
</table>


<script type="text/javascript">


    jQuery(document).ready(function ($) {

        var counter = <?php echo count($external_invoices); ?>;

        $("#addExternalInvoiceTableRow").on("click", function () {
            var newRow = $("<tr>");
            var cols = "";

            cols += '<td class="col-sm-2"><input type="text" class="form-control" name="external_invoice[' + counter + '][invoice_number]"/></td>';
			cols += '<td class="col-sm-2"><input type="text" class="form-control" name="external_invoice[' + counter + '][invoice_date]"/></td>';
            cols += '<td class="col-sm-3"><input type="text" class="form-control" name="external_invoice[' + counter + '][invoice_description]"/></td>';
            cols += '<td class="col-sm-2"><input type="number" class="form-control" name="external_invoice[' + counter + '][invoice_price]"/></td>';

            cols += '<td class="col-sm-1"><input type="button" class="ibtnDel btn btn-alpha btn-block"  value="Ta bort"></td>';
            newRow.append(cols);
            $("table.order-list").append(newRow);
            counter++;
        });


        $("table.order-list").on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();
            counter -= 1
        });


    });

</script>