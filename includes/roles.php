<?php
add_role('sale-administrator', __(
                'IMM Administratör'), array(
    'read' => true, // Allows a user to read
    'create_posts' => true, // Allows user to create new posts
    'edit_posts' => true, // Allows user to edit their own posts
    'edit_others_posts' => true, // Allows user to edit others posts too
    'publish_posts' => true, // Allows the user to publish posts
    'manage_categories' => true, // Allows user to manage post categories
        )
);

remove_role('sale-salesman');
add_role('sale-salesman', __(
                'IMM Säljare'), array(
    'read' => false, // Allows a user to read
    'create_posts' => true, // Allows user to create new posts
    'edit_posts' => true, // Allows user to edit their own posts
    'edit_others_posts' => true, // Allows user to edit others posts too
    'publish_posts' => true, // Allows the user to publish posts
    'user_can_access_admin_page' => false
        )
);

remove_role('sale-economy');
add_role('sale-economy', __(
                'IMM Ekonomi'), array(
    'read' => false, // Allows a user to read
    'create_posts' => true, // Allows user to create new posts
    'edit_posts' => true, // Allows user to edit their own posts
    'edit_others_posts' => true, // Allows user to edit others posts too
    'publish_posts' => true, // Allows the user to publish posts
    'manage_categories' => true, // Allows user to manage post categories
        )
);
remove_role('sale-technician');
add_role('sale-technician', __(
                'IMM Tekniker'), array(
    'read' => false, // Allows a user to read
    'create_posts' => true, // Allows user to create new posts
    'edit_posts' => true, // Allows user to edit their own posts
    'edit_others_posts' => true, // Allows user to edit others posts too
    'publish_posts' => true, // Allows the user to publish posts
    'manage_categories' => true, // Allows user to manage post categories
        )
);

remove_role('sale-project-management');
add_role('sale-project-management', __(
                'IMM Projektplanering'), array(
    'read' => false, // Allows a user to read
    'create_posts' => true, // Allows user to create new posts
    'edit_posts' => true, // Allows user to edit their own posts
    'edit_others_posts' => true, // Allows user to edit others posts too
    'publish_posts' => true, // Allows the user to publish posts
    'manage_categories' => true, // Allows user to manage post categories
        )
);

remove_role('sale-sub-contractor');
add_role('sale-sub-contractor', __(
                'IMM Underentreprenör'), array(
    'read' => false, // Allows a user to read
    'create_posts' => true, // Allows user to create new posts
    'edit_posts' => true, // Allows user to edit their own posts
    'edit_others_posts' => true, // Allows user to edit others posts too
    'publish_posts' => true, // Allows the user to publish posts
    'manage_categories' => true, // Allows user to manage post categories
        )
);


// Hooks near the bottom of profile page (if current user)
add_action('show_user_profile', 'custom_user_profile_fields');

// Hooks near the bottom of the profile page (if not current user)
add_action('edit_user_profile', 'custom_user_profile_fields');

// @param WP_User $user
function custom_user_profile_fields($user) {
    ?>
    <h2><?php echo __("UE Kontaktinformation") ?></h2>
    <table class="form-table">
        <tr>
            <th>
                <label for="ue_company"><?php _e('UE Företag'); ?></label>
            </th>
            <td>
                <input type="text" name="sale-sub-contractor_company" id="sale-sub-contractor_company"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'sale-sub-contractor_company', true)); ?>"
                       class="regular-text"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="ue_shortname"><?php _e('UE kort namn'); ?></label>
            </th>
            <td>
                <input type="text" name="sale-sub-contractor_shortname" id="sale-sub-contractor_shortname"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'sale-sub-contractor_shortname', true)); ?>"
                       class="regular-text"/>
            </td>
        </tr>
    </table>

    <h2><?php echo __("Personal Kontaktinformation") ?></h2>
    <table class="form-table">
        <tr>
            <th>
                <label for="personal_company"><?php _e('Företag'); ?></label>
            </th>
            <td>
                <input type="text" name="personal_company" id="personal_company"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'personal_company', true)); ?>"
                       class="regular-text"/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="personal_phone"><?php _e('Telefonnummer'); ?></label>
            </th>
            <td>
                <input type="text" name="personal_phone" id="personal_phone"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'personal_phone', true)); ?>"
                       class="regular-text"/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="customer_company_private"><?php _e('Privatperson/Företag'); ?></label>
            </th>
            <td>
                <input type="text" name="customer_company_private" id="customer_company_private"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'customer_company_private', true)); ?>"
                       class="regular-text"/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="customer_kontaktperson"><?php _e('Kontaktperson'); ?></label>
            </th>
            <td>
                <input type="text" name="customer_kontaktperson" id="customer_kontaktperson"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'customer_kontaktperson', true)); ?>"
                       class="regular-text"/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="user_kontakt_person"><?php _e('Ansvarig säljare'); ?></label>
            </th>
            <td>
                <input type="text" name="user_kontakt_person" id="user_kontakt_person"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'user_kontakt_person', true)); ?>"
                       class="regular-text"/>
            </td>
        </tr>
    </table>
    <?php
}

// Hook is used to save custom fields that have been added to the WordPress profile page (if current user)
add_action('personal_options_update', 'update_extra_profile_fields');

// Hook is used to save custom fields that have been added to the WordPress profile page (if not current user)
add_action('edit_user_profile_update', 'update_extra_profile_fields');

function update_extra_profile_fields($user_id) {
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'sale-sub-contractor_company', $_POST['sale-sub-contractor_company']);
        update_user_meta($user_id, 'sale-sub-contractor_shortname', $_POST['sale-sub-contractor_shortname']);
    }
    update_user_meta($user_id, 'personal_company', $_POST['personal_company']);
    update_user_meta($user_id, 'personal_phone', $_POST['personal_phone']);
    update_user_meta($user_id, 'customer_company_private', $_POST['customer_company_private']);
    update_user_meta($user_id, 'user_kontakt_person', $_POST['user_kontakt_person']);
    update_user_meta($user_id, 'customer_kontaktperson', $_POST['customer_kontaktperson']);
    update_user_meta($user_id, 'customer_name', $firstname . ' ' . $lastname);
    update_user_meta($user_id, 'customer_name_backup', $firstname . ' ' . $lastname);
    update_user_meta($user_id, 'salesman_name', $firstname . ' ' . $lastname);
}
