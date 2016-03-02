<?php
/**
 * Blocks/Search form view
 *
 * @package photolab
 */
?>

 <form role="search" method="get" class="search-form-header" action="<?php echo home_url( '/' ); ?>">
    <input type="search" class="search-field"
        placeholder="<?php echo esc_attr_x( 'Search...', 'blogetti' ) ?>"
        value="<?php echo get_search_query() ?>" name="s"
        title="<?php echo esc_attr_x( 'Search...', 'blogetti' ) ?>" />
    <div><button type="submit" class="search-submit"><i class="fa fa-search"></i></button></div>
</form>