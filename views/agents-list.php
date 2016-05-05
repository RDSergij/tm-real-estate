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
    <?php foreach( $__data['agents'] as $agent ) : ?>
    <div class="agent-item" id="agent-<?php echo $agent->ID ?>">
        <a href="<?php echo $__data['agent_page']; ?>">
            <?php echo get_avatar( $agent->ID, 128 ); ?>
            <h4><?php echo $agent->display_name; ?></h4>
        </a>
    </div>
    <?php endforeach; ?>
</div>
