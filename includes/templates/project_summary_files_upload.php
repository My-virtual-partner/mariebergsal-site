
<label for="files_type"><strong><?php echo __("Ladda upp dokument synliga för kund på affärsförslaget"); ?></strong></label>
<div class="top-buffer-half" id="all_files_project" >

    <div class = "col-md-6 upload-form-order-files">
        <div class= "upload-response"></div>
        <div class = "form-group">
            <label><?php __('Välj filer:', 'cvf-upload'); ?></label>
            <input type = "file" name = "files[]" accept = "" class = "files-data form-control" multiple />
        </div>
        <div class = "form-group">
            <input type = "submit" value = "Ladda upp" class = "btn btn-brand btn-block top-buffer-half btn-upload-order" disabled/>
        </div>
    </div>

    <table class="table">
        <?php $table_name = "todo-order_files";
        $order_id = $_GET['order-id'];
        ?>
        <thead>
        <tr>
            <th class="sortable"
                onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Namn" ); ?></th>
            <th class="sortable"
                onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Ladda ner" ); ?></th>
            <th class="sortable"
                onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Ta bort" ); ?></th>

        </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
        <?php
        $i = 1;

        if( have_rows('filer_order',$order_id) ):

            // loop through the rows of data
            while ( have_rows('filer_order',$order_id) ) : the_row();
                // display a sub field value
                $namn = get_sub_field('namn');
                $url = get_sub_field('url');
                echo '<tr data_row="'.$i.'"><td>'.$namn.'</td><td><a href="'.$url.'" class="project_file_url" download>Ladda ner</a></td><td data_row="'.$i.'" class="tabort_repeater_row_offert" data_url="'.$url.'"><a href="#"  >Ta bort</a></td></tr>';
                $i++;
            endwhile;



        endif;
        ?>
        </tbody>
    </table>
    <hr>


</div>