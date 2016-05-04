<?php
/**
 * View for options page
 *
 * @package  TM Real Estate
 * @author   Guriev Eugen & Sergyj Osadchij
 * @license  GPL-2.0+
 */
?>
<div class="wrap cherry-settings-page">
	<h2><?php echo $__data['title'] ?></h2>
	<?php if ( ! empty( $__data['page_before'] ) ) : ?>
	<div class="description"><?php echo $__data['page_before'] ?></div>
	<?php endif; ?>
	<div class="cherry-settings-tabs">
        <form action="">
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                    <tr>
                        <td class="manage-column">
                            <?php echo __( 'Photo', 'tm-real-estate' ); ?>
                        </td>
                        <td class="manage-column">
                            <?php echo __( 'Login', 'tm-real-estate' ); ?>
                        </td>
                        <td class="manage-column">
                            <?php echo __( 'First Name', 'tm-real-estate' ); ?>
                        </td>
                        <td class="manage-column">
                            <?php echo __( 'Last Name', 'tm-real-estate' ); ?>
                        </td>
                        <td class="manage-column">
                            <?php echo __( 'Email', 'tm-real-estate' ); ?>
                        </td>
                        <td class="manage-column">
                            <?php echo __( 'Action', 'tm-real-estate' ); ?>
                        </td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach( $__data['custom_data']['agents'] as $agent ) : ?>
                    <tr>
                        <td>
                            <?php echo $agent['user_id_html']; ?>
                            <?php echo $agent['photo_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent['user_login_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent['first_name_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent['last_name_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent['user_email_html']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr id="agent_new">
                        <?php $agent_new = $__data['custom_data']['agent_new']; ?>
                        <td>
                            <?php echo $agent_new['photo_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent_new['user_login_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent_new['first_name_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent_new['last_name_html']; ?>
                        </td>
                        <td>
                            <?php echo $agent_new['user_email_html']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
	</div>
	<?php if ( ! empty( $__data['page_after'] ) ) : ?>
	<div class="description"><?php echo $__data['page_after'] ?></div>
	<?php endif; ?>
</div>
