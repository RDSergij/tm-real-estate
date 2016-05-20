<?php
/**
 * Property items View.
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<script>
	var property_items = <?php echo $__data['addresses_json']; ?>;
	var property_settings = <?php echo $__data['property_settings']; ?>;
</script>
<script type="text/template" id="info_window_content_tmpl">
	<span class="info-window" data-id="{{ id }}" data-url="{{ url }}">{{ content }}</span>
</script>
<div id="property_items<?php echo $__data['id_sufix']; ?>" class="tm-re-map"></div>
