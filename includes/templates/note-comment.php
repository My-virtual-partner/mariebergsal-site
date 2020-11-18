<?php
//print_r($current_user_role);
$department = array('sale-administrator' => 'Administratör', 'sale-salesman' => 'Sälj', 'sale-economy' => 'Ekonomi', 'sale-project-management' => 'Projektplanering', 'sale-technician' => 'Tekniker', 'sale-sub-contractor' => 'Underentreprenör');
$tables = $wpdb->prefix . 'user_note';
if ($current_user_role == 'sale-sub-contractor') {
    $NoteQuery = $wpdb->get_results("select * from " . $tables . " where project_id = $project->ID and department='sale-sub-contractor'");
} else {
    $NoteQuery = $wpdb->get_results("select * from " . $tables . " where project_id = $project->ID");
}
?>
<section class="comments">
    <?php
    foreach ($NoteQuery as $valNote) {

        $CommentQuery = $wpdb->get_results("select * from " . $tables . " where comment_id = $valNote->comment_id");
        foreach ($CommentQuery as $val) {
            $added_user_name = $val->added_user_id;
            $user_name = getCustomerName($added_user_name);
            $time = $val->created_time;
            $ue_note = $val->ue_comment;

            if ($val->send_sms == '1' || $val->send_email == '1') {
                $label = 'Skickat till kund: ';
            } else {
                $label = '';
            }
            if (($val->send_sms == '1')) {
                $message1 = 'SMS';
            } else {
                $message1 = '';
            }
            if (($val->send_email == '1')) {
                $message2 = 'E-POST';
            } else {
                $message2 = '';
            }
		if ($val->send_email == '1' && $val->send_sms == '1') {
                $message2 = 'SMS och E-post';
$message1 = '';
            } 
            if ($ue_note == '1') {
                ?>
                <span style="font-size: initial;padding-left: 18px;">Underentreprenör<?php $label . $message1 . $message2; ?></span>
            <?php } elseif ($ue_note == '0') { ?>
                <span style="font-size: initial;padding-left: 18px;">Planning<?php $label . $message1 . $message2; ?></span>
            <?php } else { ?>
                <span style="font-size: initial;padding-left: 18px;"><?= $department[$val->department] . ' ' . $label . $message1 . $message2; ?></span>
            <?php } ?>
            <article class="comment">

                <div class="comment-body">
                    <div class="text">
                        <div><?= $valNote->comment ?></div>
                    </div>
                    <p class="attribution">Av <a href="#non"><?php echo $user_name ?></a> den <?php echo $time; ?> <a href="#" data-comment-id="<?php echo $val->comment_id; ?>"  id="removecomment" ><i class="fa fa-trash" aria-hidden="true"></i></a></p>
                </div>
            </article>
        <?php }
    }
    ?>

    <div class="addcomment">
<?php ?>
        <label class='top-buffer-half' for='project_department'><?php echo __("Skriv anteckning"); ?></label>
        <select name='project_department' class='form-control js-sortable-select' id='project_department'>

            <?php
            foreach ($department as $key => $value) {
                if ($key == $current_user_role) {
                    $selected = "selected=selected";
                } else {
                    $selected = "";
                }
                ?>
                <option <?php echo $selected; ?> value='<?php echo $key ?>'><?php echo $value; ?></option>
<?php } ?>
        </select><br>
        <textarea class="form-control" rows="5" name="user_comment"
                  id="user_comment"></textarea>
        <label for="Email">Skicka E-post till kund</label>
        <input type="checkbox" class="btn btn-primary btn-lg" name="send_email">
        <br>
        <label for="SMS">Skicka SMS till kund</label>
        <input type="checkbox" class="btn btn-primary btn-lg" name="send_sms">
        <br>
        <input type="submit" value="Spara anteckning" class="btn-brand top-buffer-half">
    </div>
</section>
<hr>


<?php // include( "dashboard/send_invoice_email.php" );  ?>
<?php // include( "dashboard/send_invoice_sms.php" );   ?>
<style>
    .text span {
        font-size: 10px;
        float: right;
    }
    .addcomment{margin:0px 9px;}
    a#removecomment {
        float: right;
    }
    .comment {
        overflow: hidden;
        padding: 0 0 1em;
        border-bottom: 1px solid #ddd;
        margin: 0 0 1em;
        *zoom: 1;
    }



    .comment-body {
        overflow: hidden;
        margin: 0 13px;
    }

    .comment .text {
        padding: 10px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        background: #fff;
    }

    .comment .text p:last-child {
        margin: 0;
    }

    .comment .attribution {
        margin: 0.5em 0 0;
        font-size: 14px;
        color: #666;
    }

    /* Decoration */

    .comments,
    .comment {
        position: relative;
    }

    .comments:before,
    .comment:before,
    .comment .text:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
    }

    /*.comments:before {
        width: 3px;
        top: -20px;
        bottom: -20px;
        background: rgba(0,0,0,0.1);
    }*/

    .comment:before {
        width: 9px;
        height: 9px;
        border: 3px solid #fff;
        border-radius: 100px;
        margin: 16px 0 0 -6px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.2), inset 0 1px 1px rgba(0,0,0,0.1);
        background: #ccc;
    }

    .comment:hover:before {
        background: orange;
    }

    .comment .text:before {
        top: 18px;
        left: 9px;
        width: 9px;
        height: 9px;
        border-width: 0 0 1px 1px;
        border-style: solid;
        border-color: #e5e5e5;
        background: #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
    }
</style>  