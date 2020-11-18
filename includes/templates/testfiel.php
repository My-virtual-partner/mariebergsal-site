<?php
	
	if ($_POST['step-heading'] == 'Arbetsorder' && empty($_POST['next_stepgo'])) {
	
        header('Location:' . "/order-steps?order-id=" . $project_id . "&step=" . $_GET['step']);
        exit;
    }
	