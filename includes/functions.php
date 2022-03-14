<?php
function ets_lifterlms_discord_pages_list( $ets_lifterlms_discord_redirect_page_id ){
    $args = array(
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'hierarchical' => 1,
    'exclude' => '',
    'include' => '',
    'meta_key' => '',
    'meta_value' => '',
    'exclude_tree' => '',
    'number' => '',
    'offset' => 0,
    'post_type' => 'page',
    'post_status' => 'publish'
    );
    $pages = get_pages($args);

    $options = '<option value="" disabled>-</option>';
    foreach($pages as $page){ 
    $selected = ( esc_attr( $page->ID ) === $ets_lifterlms_discord_redirect_page_id  ) ? ' selected="selected"' : '';
    $options .= '<option data-page-url="' . ets_get_lifterlms_discord_formated_discord_redirect_url ( $page->ID ) .'" value="' . esc_attr( $page->ID ) . '" '. $selected .'> ' . $page->post_title . ' </option>';
}

    // $options = '<option value="" disabled>-</option>';
    // foreach($pages as $page){ 
    //     $selected = ( esc_attr( $page->ID ) === $ets_lifterlms_discord_redirect_url  ) ? ' selected="selected"' : '';
    //     $options .= '<option value="' . esc_attr( $page->ID ) . '" '. $selected .'> ' . $page->post_title . ' </option>';
    // }
    
    return $options;
}

/**
 *  Get-URL 
 */
function ets_get_lifterlms_discord_formated_discord_redirect_url( $page_id ) {
    
    $url = esc_url( get_permalink( $page_id) );
	$parsed = parse_url( $url, PHP_URL_QUERY );
	if ( $parsed === null ) {
		return $url .= '?via=lifterlms-discord';
	} else {
		if ( stristr( $url, 'via=lifterlms-discord' ) !== false ) {
			return $url;
		} else {
			return $url .= '&via=lifterlms-discord';
		}
	}
}

function ets_lifterlms_discord_get_current_screen_url()
{
    $parts = parse_url( home_url() );
    $current_uri = "{$parts['scheme']}://{$parts['host']}" . ( isset( $parts['port'] ) ? ':' . $parts['port'] : '' ) . add_query_arg( null, null );
        return $current_uri;
}


?>