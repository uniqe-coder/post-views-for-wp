<?php

add_action( 'admin_menu', 'post_views_for_wp_admin_menu' );
function post_views_for_wp_admin_menu() { 

	add_options_page( __('Postviews options', 'postviews-for-wp'), __('PostViews for WP', 'postviews-for-wp'), 'manage_options', 'postview-settings', 'PostViews_for_wp_options' );
}

add_action( 'admin_init', 'post_views_for_wp_settings' );
function post_views_for_wp_settings() { 

	register_setting( 'pv_for_wp_page', 'pv_forwp_settings' );

	add_settings_section(
		'PostViews_for_wp_pg_p_section', 
		__( 'PostViews For WP options', 'postviews-for-wp' ), 
		'PostViews_for_wp_settings_caller', 
		'pv_for_wp_page'
	);
	add_settings_field( 
		'post_v_forwp_field_posttypes', 
		__( 'Select post types to render Views(on front end)', 'postviews-for-wp' ), 
		'PostViews_for_wp_posttypes_selector', 
		'pv_for_wp_page', 
		'PostViews_for_wp_pg_p_section' 
	);

	add_settings_field( 
		'post_v_forwp_field_IP_Filter', 
		__( 'Views filter on IP (If checked multiple views will not count From same IP)', 'postviews-for-wp' ), 
		'PostViews_for_wp_filter_ip_filter', 
		'pv_for_wp_page', 
		'PostViews_for_wp_pg_p_section' 
	);

	add_settings_field( 
		'post_v_forwp_field_IP_Timer', 
		__( 'IP Time Expiry(In Hours)', 'postviews-for-wp' ), 
		'PostViews_for_wp_IP_Timer', 
		'pv_for_wp_page', 
		'PostViews_for_wp_pg_p_section' 
	);

}

function PostViews_for_wp_posttypes_selector( ) {
	$pv_forwp_opt = get_option( 'pv_forwp_settings' );
	$pv_forwp_PostType = '';
	if (isset($pv_forwp_opt['post_v_forwp_field_posttypes'])) {
		$Postypes_opt = $pv_forwp_opt['post_v_forwp_field_posttypes'];
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $post_types as $in_types => $pos_t ) {
            if(!isset($Postypes_opt[$pos_t->name]))
			{
                $Postypes_opt[$pos_t->name] = '';
            }
                $pv_forwp_PostType = $Postypes_opt[$pos_t->name];
			?>
			<p><input type='checkbox' name='pv_forwp_settings[post_v_forwp_field_posttypes][<?php echo esc_attr($pos_t->name); ?>]' <?php checked( $pv_forwp_PostType == '1' ); ?> value='1' /> <?php echo esc_attr($pos_t->labels->name); ?></p>
			<?php
		}
	} else {
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $post_types as $in_types => $pos_t ) {
			?>
			<p><input type='checkbox' name='pv_forwp_settings[post_v_forwp_field_posttypes][<?php echo esc_attr($pos_t->name); ?>]' value='1' /> <?php echo esc_attr($pos_t->labels->name); ?></p>
			<?php
		}
	}
}

 function PostViews_for_wp_filter_ip_filter(  ) {
	    $pv_forwp_opt = get_option( 'pv_forwp_settings' );
        if(!isset($pv_forwp_opt['post_v_forwp_field_IP_Filter'])) 
            {
                $pv_forwp_opt['post_v_forwp_field_IP_Filter'] = '';
            }
	    $checkbox_val = $pv_forwp_opt['post_v_forwp_field_IP_Filter'];
	    ?>
	    <input type='checkbox' name='pv_forwp_settings[post_v_forwp_field_IP_Filter]' value="1" <?php checked( 1, $checkbox_val, true ); ?>>
	    <?php
	}

 function PostViews_for_wp_IP_Timer(  ) {
	    $pv_forwp_opt = get_option( 'pv_forwp_settings' );
	    $textbox_val = $pv_forwp_opt['post_v_forwp_field_IP_Timer'];
	    ?>
	    <input type="textbox" name='pv_forwp_settings[post_v_forwp_field_IP_Timer]' value="<?php echo esc_attr($textbox_val); ?>">
	    <?php
	}


function PostViews_for_wp_settings_caller() { 

	echo __( 'Few options to set up and running', 'postviews-for-wp' );

}


function PostViews_for_wp_options() { 

	?>
	<form action='options.php' method='post'>

		<?php
		settings_fields( 'pv_for_wp_page' );
		do_settings_sections( 'pv_for_wp_page' );
		submit_button();
		?>

	</form>
	<?php

}

 function options_page_pviews() {
	    ?>
	    <form action='options.php' method='post'>
	        <h2> Post Views for WP Settings </h2>
	        <?php
	        settings_fields( 'pvcPlugin' );
	        do_settings_sections( 'pvcPlugin' );
	        submit_button();
	        ?>
	    </form>
	    <?php
	}


function pv_for_wp_ttl_getter() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
    return "$count views";
}

add_filter( 'manage_posts_columns', 'pv_for_wp_posts_column_views' );
function pv_for_wp_posts_column_views( $columns ) {
    $columns['pv_forwp_p_views'] = 'Views';
    return $columns;
}

add_action( 'manage_posts_custom_column', 'pv_for_wp_column_views' );
function pv_for_wp_column_views( $column ) {
    if ( $column === 'pv_forwp_p_views') {
        echo pv_for_wp_ttl_getter();
    }
}

add_filter( 'manage_pages_columns', 'pv_for_wp_pages_column_views' );
function pv_for_wp_pages_column_views( $columns ) {
    $columns['pv_forwp_p_views'] = 'Views';
    return $columns;
}

add_action( 'manage_pages_custom_column', 'pv_for_wp_column_views_pages' );
function pv_for_wp_column_views_pages( $column ) {
    if ( $column === 'pv_forwp_p_views') {
        echo pv_for_wp_ttl_getter();
    }
}
