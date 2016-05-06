<?php
/**
 * Agents list view
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<div class="tm-re-agents-list">
	<?php if ( count( $__data['agents'] ) > 0 ) : ?>
		<?php foreach ( $__data['agents'] as $agent ) : ?>
		<div class="agent-item" id="agent-<?php echo $agent->ID; ?>">
			<a href="<?php echo $agent->agent_page; ?>">
				<img src="<?php echo $agent->photo_url; ?>">
				<h4><?php echo $agent->display_name; ?></h4>
			</a>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
