<?php
/**
 * The header for the system.
 * Includes the navigation and some modals.
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( wp_login_url() );
}
wp_head();?>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css' type='text/css' />
<?php $logotype_url = get_option( 'logotype_image_url' );
global $current_user;
global $current_user_role;

$current_user_role = get_user_role();
$current_user      = wp_get_current_user();

?>

<header class="clearfix">
    <nav class="navbar navbar-default ">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo site_url(); ?>/system-dashboard">
                    <img class="sale-logo" src="<?php echo $logotype_url; ?>" alt="logotype">
                </a>
            </div>
			<?php
			if ( $current_user instanceof WP_User ) : ?>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav list-inline">
                        <li>
                            <a href="<?php echo site_url(); ?>/system-dashboard" type="button"
                               class="btn btn-beta btn-block btn-menu"><i class="fa fa-television"
                                                                          aria-hidden="true"></i> <?php echo __( "Min panel" ); ?>
                            </a>
                        </li>
                        <li>
                            <button type="button"
                                    class="btn btn-beta btn-block btn-menu toggle-todo-modal"><i class="fa fa-list-ol"
                                                                                                 aria-hidden="true"></i> <?php echo __( "Skapa uppgift" ); ?>
                            </button>
                        </li>

                        <li><a href="<?php echo site_url() ?>/new-lead" type="button"
                               class="btn btn-beta btn-block btn-menu"><i class="fa fa-paper-plane-o"
                                                                          aria-hidden="true"></i> <?php echo __( "Skapa lead" ); ?>
                            </a>
                        </li>
                        <?php if ($current_user_role != 'sale-sub-contractor') : ?>
                        <li><a href="<?php echo site_url() ?>/articlar" type="button"
                               class="btn btn-beta btn-block btn-menu"><i class="fa fa-tint"
                                                                          aria-hidden="true"></i> <?php echo __( "Artiklar" ); ?>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo site_url() ?>/customer-register" type="button"
                               class="btn btn-beta btn-block btn-menu"><i class="fa fa-address-book"
                                                                          aria-hidden="true"></i> <?php echo __( "Kundregister" ); ?>
                            </a>
                        </li>


                        <li>
                            <a href="<?php echo site_url() ?>/sub-contractor-register" type="button"
                               class="btn btn-beta btn-block btn-menu"><i class="fa fa-address-book"
                                                                          aria-hidden="true"></i> <?php echo __( "UE register" ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url() ?>/brand-register" type="button"
                               class="btn btn-beta btn-block btn-menu"><i class="fa fa-address-book"
                                                                          aria-hidden="true"></i> <?php echo __( "Leverantörer" ); ?>
                            </a>
                        </li>
                         <?php endif; ?>

                    </ul>
                </div>

                <span class="user-name text-right"><?php echo __( "Inloggad som " ) . showName($current_user->ID); ?>
                        | <a  href="<?php echo wp_logout_url(); ?>"><i class="fa fa-sign-out"
                                                                       aria-hidden="true"></i> <?php echo __( "Logga ut" ); ?>
                            </a>
                </span>
			<?php endif; ?>
        </div>
    </nav>
	<?php include( "dashboard/dashboard-todo-modal.php" ); ?>
	<?php include( "dashboard/dashboard-lead-modal.php" ) ?>

</header>
