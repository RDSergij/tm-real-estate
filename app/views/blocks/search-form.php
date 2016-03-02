<?php
/**
 * Blocks/Search form view
 *
 * @package photolab
 */
?>

 <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <input type="search" class="search-field"
            placeholder="<?php echo esc_attr_x( 'Enter keyword', 'blogetti' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Enter keyword', 'blogetti' ) ?>" />
    </label>
    <input class="search-submit" value="<?php echo esc_attr_x( 'Search', 'blogetti' ) ?>" type="submit">
</form>