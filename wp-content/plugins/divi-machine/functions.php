<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'load-post.php', 'setup_divi_machine_meta_boxes' );
add_action( 'load-post-new.php', 'setup_divi_machine_meta_boxes' );

add_action( 'save_post', 'divi_machine_save_post_meta', 10, 2 );

function setup_divi_machine_meta_boxes() {
	add_action( 'add_meta_boxes', 'add_divi_machine_post_meta_boxes' );
}

function divi_machine_save_post_meta( $post_id, $post ) {

	$post_type = get_post_type_object( $post->post_type );

	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    	return $post_id;

	if ( $post->post_type == 'dmach_post' ) {
		if ( !isset( $_POST['dmach_post_nonce'] ) || !wp_verify_nonce( $_POST['dmach_post_nonce'], 'dmach_post_nonce' ) )
			return $post_id;

		$dmach_post_values = array(
			'divi-machine_dmach_name_singular',
			'divi-machine_dmach_post_type_key',
			'divi-machine_dmach_description',
			'divi-machine_dmach_public',
			'divi-machine_dmach_public_queryable',
			'divi-machine_dmach_show_in_admin_sidebar',
			'divi-machine_dmach_show_admin_sidebar_postion',
			'divi-machine_dmach_show_admin_sidebar_icon',
			'divi-machine_dmach_show_in_admin_bar',
			'divi-machine_dmach_show_in_nav_menus',
			'divi-machine_dmach_taxonomies',
			'divi-machine_dmach_supports',
			'divi-machine_dmach_gutenberg',
			'divi-machine_dmach_prettify_post',
			'divi-machine_dmach_exclude_from_search',
			'divi-machine_dmach_enable_archives',
			'divi-machine_dmach_custom_archive_slug',
			'divi-machine_dmach_custom_post_slug',
			'divi-machine_dmach_hierarchical',
			'divi-machine_dmach_rewrite',
			'divi-machine_dmach_rewrite_withfront',
			'divi-machine_dmach_name_plural',
			'divi-machine_dmach_menu_name',
			'divi-machine_dmach_admin_bar_name',
			'divi-machine_dmach_all_items',
			'divi-machine_dmach_add_new_item',
			'divi-machine_dmach_add_new',
			'divi-machine_dmach_new_item',
			'divi-machine_dmach_edit_item',
			'divi-machine_dmach_update_item',
			'divi-machine_dmach_view_item',
			'divi-machine_dmach_view_items',
			'divi-machine_dmach_search_item'
		);

		$dmach_checkbox_post_values = array(
			'divi-machine_dmach_public',
			'divi-machine_dmach_public_queryable',
			'divi-machine_dmach_show_in_admin_sidebar',
			'divi-machine_dmach_show_in_admin_bar',
			'divi-machine_dmach_show_in_nav_menus',
			'divi-machine_dmach_gutenberg',
			'divi-machine_dmach_prettify_post',
			'divi-machine_dmach_exclude_from_search',
			'divi-machine_dmach_hierarchical'
		);

		$dmach_array_post_values = array(
			'divi-machine_dmach_taxonomies',
			'divi-machine_dmach_supports'
		);

		foreach ( $dmach_post_values as $dmach_post_meta_key ) {
			if ( in_array( $dmach_post_meta_key, $dmach_array_post_values ) ) {
				$new_meta_value = isset( $_POST[ $dmach_post_meta_key ] ) ? $_POST[ $dmach_post_meta_key ] : array();
			} else if ( in_array( $dmach_post_meta_key, $dmach_checkbox_post_values ) ) { 
				$new_meta_value = isset( $_POST[ $dmach_post_meta_key ] ) ? sanitize_text_field( $_POST[ $dmach_post_meta_key ] ) : '0';

				if ( $new_meta_value == 'true' ||  $new_meta_value == 'on' ) {
					$new_meta_value = '1';
				} else if ( $new_meta_value == 'false' || $new_meta_value == 'off') {
					$new_meta_value = '0';
				}
			} else {
				$new_meta_value = isset( $_POST[ $dmach_post_meta_key ] ) ? sanitize_text_field( $_POST[ $dmach_post_meta_key ] ) : '';

				if ( $dmach_post_meta_key == 'divi-machine_dmach_post_type_key' ) {
					$new_meta_value = remove_accents( $new_meta_value );
				}

				if ( $new_meta_value == 'true' ||  $new_meta_value == 'on' ) {
					$new_meta_value = '1';
				} else if ( $new_meta_value == 'false' || $new_meta_value == 'off') {
					$new_meta_value = '0';
				}
			}

			update_post_meta( $post_id, $dmach_post_meta_key, $new_meta_value );
		}

	} else if ( $post->post_type == 'dmach_tax' ) {
		if ( !isset( $_POST['dmach_tax_nonce'] ) || !wp_verify_nonce( $_POST['dmach_tax_nonce'], 'dmach_tax_nonce' ) )
			return $post_id;

		$dmach_tax_values = array(
			'divi-machine_dmach_tax_slug',
			'divi-machine_dmach_tax_plural',
			'divi-machine_dmach_tax_single',
			'divi-machine_dmach_tax_post_type',
			'divi-machine_dmach_tax_menu_name',
			'divi-machine_dmach_tax_all_items',
			'divi-machine_dmach_tax_edit_item',
			'divi-machine_dmach_tax_view_item',
			'divi-machine_dmach_tax_update_item',
			'divi-machine_dmach_tax_add_new',
			'divi-machine_dmach_tax_new_item',
			'divi-machine_dmach_tax_parent',
			'divi-machine_dmach_tax_parent_colon',
			'divi-machine_dmach_tax_search',
			'divi-machine_dmach_tax_popular',
			'divi-machine_dmach_tax_seperate_commas',
			'divi-machine_dmach_tax_add_remove',
			'divi-machine_dmach_tax_most_used',
			'divi-machine_dmach_tax_notfound',
			'divi-machine_dmach_tax_noterms',
			'divi-machine_dmach_tax_item_list_nav',
			'divi-machine_dmach_tax_item_list',
			'divi-machine_dmach_tax_public',
			'divi-machine_dmach_tax_public_queryable',
			'divi-machine_dmach_tax_hierarchical',
			'divi-machine_dmach_tax_show_ui',
			'divi-machine_dmach_tax_show_in_menu',
			'divi-machine_dmach_tax_show_nav_menu',
			'divi-machine_dmach_tax_rewrite',
			'divi-machine_dmach_tax_query_rewrite_custom',
			'divi-machine_dmach_tax_rewrite_front',
			'divi-machine_dmach_tax_rewrite_hierarchical'
		);

		foreach ( $dmach_tax_values as $dmach_tax_meta_key ) {

			$new_meta_value = isset( $_POST[ $dmach_tax_meta_key ] ) ? sanitize_text_field( $_POST[ $dmach_tax_meta_key ] ) : '';

			if ( $dmach_tax_meta_key == 'divi-machine_dmach_tax_slug' ) {
				$new_meta_value = remove_accents( $new_meta_value );
			}

			update_post_meta( $post_id, $dmach_tax_meta_key, $new_meta_value );
		}
	}
}

function add_divi_machine_post_meta_boxes() {
	add_meta_box(
		'dmach_post_save_top',
		esc_html__( "Save Settings", 'divi-machine' ),
		'dmach_post_save_meta_box',
		'dmach_post',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_post_general',
		esc_html__( "General Settings", 'divi-machine' ),
		'dmach_post_general_meta_box',
		'dmach_post',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_post_visibility',
		esc_html__( "Post Visibility", 'divi-machine' ),
		'dmach_post_visibility_meta_box',
		'dmach_post',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_post_advanced',
		esc_html__( "Advanced Options", 'divi-machine' ),
		'dmach_post_advanced_meta_box',
		'dmach_post',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_post_labels',
		esc_html__( "Labels", 'divi-machine' ),
		'dmach_post_labels_meta_box',
		'dmach_post',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_post_save_bottom',
		esc_html__( "Save Settings", 'divi-machine' ),
		'dmach_post_save_meta_box',
		'dmach_post',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_post_save_top',
		esc_html__( "Save Settings", 'divi-machine' ),
		'dmach_post_save_meta_box',
		'dmach_tax',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_tax_general',
		esc_html__( "General Settings", 'divi-machine' ),
		'dmach_tax_general_meta_box',
		'dmach_tax',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_tax_labels',
		esc_html__( "Labels", 'divi-machine' ),
		'dmach_tax_labels_meta_box',
		'dmach_tax',
		'normal',
		'low'
	);

	add_meta_box(
		'dmach_tax_advanced',
		esc_html__( "Advanced Options", 'divi-machine' ),
		'dmach_tax_advanced_meta_box',
		'dmach_tax',
		'normal',
		'low'
	);


	add_meta_box(
		'dmach_post_save_bottom',
		esc_html__( "Save Settings", 'divi-machine' ),
		'dmach_post_save_meta_box',
		'dmach_tax',
		'normal',
		'low'
	);
}

function dmach_post_save_meta_box( $post ) {
	$dmach_name_singular = get_post_meta( $post->ID, 'divi-machine_dmach_name_singular', true );

 if (isset($dmach_name_singular) && $dmach_name_singular == '') {
	$button_name = 'Create Post';
} else if (!isset($dmach_name_singular)) {
	$button_name = 'Create Post';
} else {
	$button_name = 'Update Post';
}
?> 
<a href="#" class="button dmach_submit"><?php esc_attr_e( $button_name ); ?></a>

<?php
}


function dmach_post_general_meta_box( $post ) {
	wp_nonce_field( 'dmach_post_nonce', 'dmach_post_nonce' );

    $dmach_name_singular = get_post_meta( $post->ID, 'divi-machine_dmach_name_singular', true );
    $dmach_post_type_key = get_post_meta( $post->ID, 'divi-machine_dmach_post_type_key', true );
    $dmach_post_type_desc = get_post_meta( $post->ID, 'divi-machine_dmach_description', true );

?>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="row-1 odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_name_singular"><?php echo esc_html__( "Post Type Name", 'divi-machine' );?></label>
				</th>
				<td class="second tf-text">
					<input class="regular-text" name="divi-machine_dmach_name_singular" placeholder="" maxlength="" id="divi-machine_dmach_name_singular" type="text" value="<?php echo $dmach_name_singular;?>">
					<p class="description"><?php echo esc_html__( "Set unique name for your post type. Eg. `Projects`", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="row-2 even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_post_type_key"><?php echo esc_html__( "Post Type Slug", 'divi-machine' );?></label>
				</th>
				<td class="second tf-text">
					<input class="regular-text" name="divi-machine_dmach_post_type_key" placeholder="" maxlength="" id="divi-machine_dmach_post_type_key" type="text" value="<?php echo $dmach_post_type_key;?>">
					<p class="description"><?php echo esc_html__( "Set slug for your post type. Slugs should only contain alphanumeric, latin characters. Underscores should be used in place of spaces.", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="row-3 odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_description"><?php echo esc_html__( "Description", 'divi-machine' );?></label>
				</th>
				<td class="second tf-text">
					<input class="regular-text" name="divi-machine_dmach_description" placeholder="" maxlength="" id="divi-machine_dmach_description" type="text" value="<?php echo $dmach_post_type_desc;?>"> 			
					<p class="description"><?php echo esc_html__( "A short descriptive summary of the post type.", 'divi-machine' );?></p>
				</td>
			</tr>
		</tbody>
	</table>

<?php
}

function dmach_post_visibility_meta_box( $post ) {

    $dmach_public = str_replace("on", "1", get_post_meta( $post->ID, 'divi-machine_dmach_public', true ) );
    $dmach_public_queryable = str_replace("on", "1", get_post_meta( $post->ID, 'divi-machine_dmach_public_queryable', true ) );
    $dmach_show_in_admin_sidebar = str_replace("on", "1", get_post_meta( $post->ID, 'divi-machine_dmach_show_in_admin_sidebar', true ) );
    $dmach_show_admin_sidebar_postion = get_post_meta( $post->ID, 'divi-machine_dmach_show_admin_sidebar_postion', true );
    $dmach_show_admin_sidebar_icon = get_post_meta( $post->ID, 'divi-machine_dmach_show_admin_sidebar_icon', true ) ?: 'dashicons-admin-generic';
    $dmach_show_in_admin_bar = str_replace("on", "1", get_post_meta( $post->ID, 'divi-machine_dmach_show_in_admin_bar', true ) );
    $dmach_show_in_nav_menus = str_replace("on", "1", get_post_meta( $post->ID, 'divi-machine_dmach_show_in_nav_menus', true ) );

    if ( $dmach_public == "" ) $dmach_public = "1";
    if ( $dmach_public_queryable == "" ) $dmach_public_queryable = "1";
    if ( $dmach_show_in_admin_sidebar == "" ) $dmach_show_in_admin_sidebar = "1";
    if ( $dmach_show_in_admin_bar == "" ) $dmach_show_in_admin_bar = "1";
    if ( $dmach_show_in_nav_menus == "" ) $dmach_show_in_nav_menus = "1";

?>
	<table class="form-table" id="epanel">
	    <tbody>
	        <tr valign="top" class="row-15 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_public"><?php echo esc_html__( "Public", 'divi-machine' );?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
		            	<input type="checkbox" class="et-checkbox yes_no_button" name="divi-machine_dmach_public" id="divi-machine_dmach_public" value="1" <?php checked( $dmach_public, '1');?> />
		            </div>
		            <p class="description"><?php echo esc_html__( "Show post type in the admin UI.", 'divi-machine' );?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-16 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_public_queryable"><?php echo esc_html__( "Public Queryable", 'divi-machine' );?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
		                <input name="divi-machine_dmach_public_queryable" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_public_queryable" value="1" <?php checked( $dmach_public_queryable, '1');?>>
		            </div>
		            <p class="description"><?php echo esc_html__( "Disable endpoints like the single page and archive page.", 'divi-machine' );?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-17 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_show_in_admin_sidebar"><?php echo esc_html__( "Show in Admin Sidebar", 'divi-machine' );?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
		                <input name="divi-machine_dmach_show_in_admin_sidebar" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_show_in_admin_sidebar" value="1" <?php checked( $dmach_show_in_admin_sidebar, '1');?>>
		            </div>
		            <p class="description"><?php echo esc_html__( "Show post type in admin sidebar.", 'divi-machine' );?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-18 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_show_admin_sidebar_postion"><?php echo esc_html__( "Show in Admin Sidebar Position", 'divi-machine' );?></label>
	            </th>
	            <td class="second tf-select">
	                <select name="divi-machine_dmach_show_admin_sidebar_postion" tabindex="-1" class="" aria-hidden="true">
	                    <option value="5" <?php selected( $dmach_show_admin_sidebar_postion, "5");?>><?php echo esc_html__( "5 - below Posts", 'divi-machine' );?></option>
	                    <option value="10" <?php selected( $dmach_show_admin_sidebar_postion, "10");?>><?php echo esc_html__( "10 - below Media", 'divi-machine' );?></option>
	                    <option value="15" <?php selected( $dmach_show_admin_sidebar_postion, "15");?>><?php echo esc_html__( "15 - below Links", 'divi-machine' );?></option>
	                    <option value="20" <?php selected( $dmach_show_admin_sidebar_postion, "20");?>><?php echo esc_html__( "20 - below Pages", 'divi-machine' );?></option>
	                    <option value="25" <?php selected( $dmach_show_admin_sidebar_postion, "25");?>><?php echo esc_html__( "25 - below Comments", 'divi-machine' );?></option>
	                    <option value="60" <?php selected( $dmach_show_admin_sidebar_postion, "60");?>><?php echo esc_html__( "60 - below first separator", 'divi-machine' );?></option>
	                    <option value="65" <?php selected( $dmach_show_admin_sidebar_postion, "65");?>><?php echo esc_html__( "65 - below Plugins", 'divi-machine' );?></option>
	                    <option value="70" <?php selected( $dmach_show_admin_sidebar_postion, "70");?>><?php echo esc_html__( "70 - below Users", 'divi-machine' );?></option>
	                    <option value="75" <?php selected( $dmach_show_admin_sidebar_postion, "75");?>><?php echo esc_html__( "75 - below Tools", 'divi-machine' );?></option>
	                    <option value="80" <?php selected( $dmach_show_admin_sidebar_postion, "80");?>><?php echo esc_html__( "80 - below Settings", 'divi-machine' );?></option>
	                    <option value="100" <?php selected( $dmach_show_admin_sidebar_postion, "100");?>><?php echo esc_html__( "100 - below second separator", 'divi-machine' );?></option>
	                </select>
	                <p class="description"><?php echo esc_html__( "Show post type in admin sidebar position.", 'divi-machine' );?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-19 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_show_admin_sidebar_icon"><?php echo esc_html__( "Admin Sidebar Icon", 'divi-machine' );?></label>
	            </th>
	            <td class="second">
	                <input class="regular-text" name="divi-machine_dmach_show_admin_sidebar_icon" placeholder="" maxlength="" id="divi-machine_dmach_show_admin_sidebar_icon" type="text" value="<?php echo $dmach_show_admin_sidebar_icon;?>"> 			
	                <p class="description"><?php echo esc_html__( "Post type icon. Use", 'divi-machine' );?> <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank"> <?php echo esc_html__( "dashicon name", 'divi-machine' );?></a>.</p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-20 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_show_in_admin_bar"><?php echo esc_html__( "Show in Admin Bar", 'divi-machine' );?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
		                <input name="divi-machine_dmach_show_in_admin_bar" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_show_in_admin_bar" value="1" <?php checked( $dmach_show_in_admin_bar, '1');?>>
		            </div>
		            <p class="description"><?php echo esc_html__( "Show post type in admin bar.", 'divi-machine' );?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-21 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_show_in_nav_menus"><?php echo esc_html__( "Show in Navigation Menus", 'divi-machine' );?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
		                <input name="divi-machine_dmach_show_in_nav_menus" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_show_in_nav_menus" value="1" <?php checked( $dmach_show_in_nav_menus, '1');?>>
		            </div>
		            <p class="description"><?php echo esc_html__( "Show post type in Navigation Menus.", 'divi-machine' );?></p>
	            </td>
	        </tr>
	    </tbody>
	</table>

	<script type="text/template" id="epanel-yes-no-button-template">
	<div class="et_pb_yes_no_button_wrapper">
		<div class="et_pb_yes_no_button"><!-- .et_pb_on_state || .et_pb_off_state -->
			<span class="et_pb_value_text et_pb_on_value"><?php esc_html_e( 'Enabled', 'divi-machine' ); ?></span>
			<span class="et_pb_button_slider"></span>
			<span class="et_pb_value_text et_pb_off_value"><?php esc_html_e( 'Disabled', 'divi-machine' ); ?></span>
		</div>
	</div>
	</script>
<?php    
}

function dmach_post_advanced_meta_box( $post ) {

	$dmach_taxonomies = maybe_unserialize(get_post_meta( $post->ID, 'divi-machine_dmach_taxonomies', true ));
    $dmach_supports = maybe_unserialize(get_post_meta( $post->ID, 'divi-machine_dmach_supports', true ));
    $dmach_gutenberg = str_replace("on", "1", get_post_meta( $post->ID, 'divi-machine_dmach_gutenberg', true ) );
    $dmach_prettify_post = get_post_meta( $post->ID, 'divi-machine_dmach_prettify_post', true );
    $dmach_exclude_from_search = get_post_meta( $post->ID, 'divi-machine_dmach_exclude_from_search', true );
    $dmach_enable_archives = get_post_meta( $post->ID, 'divi-machine_dmach_enable_archives', true );
    $dmach_custom_archive_slug = get_post_meta( $post->ID, 'divi-machine_dmach_custom_archive_slug', true );
    $dmach_custom_post_slug = get_post_meta( $post->ID, 'divi-machine_dmach_custom_post_slug', true );
    $dmach_hierarchical = str_replace("on", "1", get_post_meta( $post->ID, 'divi-machine_dmach_hierarchical', true ) );
    $dmach_rewrite = get_post_meta( $post->ID, 'divi-machine_dmach_rewrite', true );
    $dmach_rewrite_withfront = get_post_meta( $post->ID, 'divi-machine_dmach_rewrite_withfront', true );

    if ( !is_array($dmach_taxonomies) && $dmach_taxonomies == "" ) {
    	$dmach_taxonomies = array( 'category', 'tag' );
    }

    if ( !is_array($dmach_supports) && $dmach_supports == "" ) {
    	$dmach_supports = array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes', 'excerpt' );
    }
?>
	<table class="form-table" id="epanel">
	    <tbody>
	        <tr valign="top" class="row-4 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_taxonomies"><?php esc_html_e( 'Taxonomies', 'divi-machine' );?></label>
	            </th>
	            <td class="second">
	                <p class="description"><?php esc_html_e( 'Enable if you want our custom categories and tags to be created for the posts. These are essentially custom taxonomies, but can do more with our modules if you create it this way.', 'divi-machine' );?></p>
	                <label for="divi-machine_dmach_taxonomiescategory">
	                	<input id="divi-machine_dmach_taxonomiescategory" type="checkbox" name="divi-machine_dmach_taxonomies[]" value="category" <?php echo in_array('category', $dmach_taxonomies)?'checked':'';?>>
	                	<?php esc_html_e( 'Categories', 'divi-machine');?>
	                </label>
	                <br>
	                <label for="divi-machine_dmach_taxonomiestag">
	                	<input id="divi-machine_dmach_taxonomiestag" type="checkbox" name="divi-machine_dmach_taxonomies[]" value="tag" <?php echo in_array('tag', $dmach_taxonomies)?'checked':'';?>>
	                	<?php esc_html_e( 'Tags', 'divi-machine');?>
	                </label>
	                <br>
	            </td>
	        </tr>
	        <tr valign="top" class="row-5 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_supports"><?php esc_html_e( 'Supports', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	                <p class="description"><?php esc_html_e( 'Check what you want the custom post to support', 'divi-machine');?></p>
	                <label for="divi-machine_dmach_supportstitle">
	                	<input id="divi-machine_dmach_supportstitle" type="checkbox" name="divi-machine_dmach_supports[]" value="title" <?php echo in_array('title', $dmach_supports)?'checked':'';?>>
	                	<?php esc_html_e( 'Title', 'divi-machine');?>
	                </label>
	                <br>
	                <label for="divi-machine_dmach_supportseditor">
	                	<input id="divi-machine_dmach_supportseditor" type="checkbox" name="divi-machine_dmach_supports[]" value="editor" <?php echo in_array('editor', $dmach_supports)?'checked':'';?>>
	                	<?php esc_html_e( 'Content (editor)', 'divi-machine');?>
	                </label>
	                <br>
	                <label for="divi-machine_dmach_supportsexcerpt">
	                	<input id="divi-machine_dmach_supportsexcerpt" type="checkbox" name="divi-machine_dmach_supports[]" value="excerpt" <?php echo in_array('excerpt', $dmach_supports)?'checked':'';?>>
	                	<?php esc_html_e( 'Excerpt', 'divi-machine');?>
	                </label>
	                <br>
	                <label for="divi-machine_dmach_supportsauthor">
	                	<input id="divi-machine_dmach_supportsauthor" type="checkbox" name="divi-machine_dmach_supports[]" value="author" <?php echo in_array('author', $dmach_supports)?'checked':'';?>>
	                	<?php esc_html_e( 'Author', 'divi-machine');?>
	                </label>
	                <br>
	                <label for="divi-machine_dmach_supportsthumbnail">
	                	<input id="divi-machine_dmach_supportsthumbnail" type="checkbox" name="divi-machine_dmach_supports[]" value="thumbnail" <?php echo in_array('thumbnail', $dmach_supports)?'checked':'';?>>
	                	<?php esc_html_e( 'Featured Image', 'divi-machine'); ?>
	                </label>
	                <br>
	                <label for="divi-machine_dmach_supportscomments">
	                	<input id="divi-machine_dmach_supportscomments" type="checkbox" name="divi-machine_dmach_supports[]" value="comments" <?php echo in_array('comments', $dmach_supports)?'checked':'';?>>
	                	<?php esc_html_e( 'Comments', 'divi-machine');?>
	                </label>
	                <br>
	                <label for="divi-machine_dmach_supportstrackbacks">
	                	<input id="divi-machine_dmach_supportstrackbacks" type="checkbox" name="divi-machine_dmach_supports[]" value="trackbacks" <?php echo in_array('trackbacks', $dmach_supports)?'checked':'';?>>
	                	<?php esc_html_e( 'Trackbacks', 'divi-machine');?>
	               	</label>
	               	<br>
	               	<label for="divi-machine_dmach_supportsrevisions">
	               		<input id="divi-machine_dmach_supportsrevisions" type="checkbox" name="divi-machine_dmach_supports[]" value="revisions" <?php echo in_array('revisions', $dmach_supports)?'checked':'';?>>
	               		<?php esc_html_e( 'Revisions', 'divi-machine');?>
	               	</label>
	               	<br>  
	               	<label for="divi-machine_dmach_supportscustom-fields">
	               		<input id="divi-machine_dmach_supportscustom-fields" type="checkbox" name="divi-machine_dmach_supports[]" value="custom-fields" <?php echo in_array('custom-fields', $dmach_supports)?'checked':'';?>>
	               		<?php esc_html_e( 'Custom Fields', 'divi-machine');?>
	               	</label>
	               	<br>
	               	<label for="divi-machine_dmach_supportspage-attributes">
	               		<input id="divi-machine_dmach_supportspage-attributes" type="checkbox" name="divi-machine_dmach_supports[]" value="page-attributes" <?php echo in_array('page-attributes', $dmach_supports)?'checked':'';?>>
	               		<?php esc_html_e( 'Page Attributes', 'divi-machine');?>
	               	</label>
	               	<br>
	               	<label for="divi-machine_dmach_supportspost-formats">
	               		<input id="divi-machine_dmach_supportspost-formats" type="checkbox" name="divi-machine_dmach_supports[]" value="post-formats" <?php echo in_array('post-formats', $dmach_supports)?'checked':'';?>>
	               		<?php esc_html_e( 'Post Formats', 'divi-machine');?>
	               	</label>
	               	<br>
	            </td>
	        </tr>
	        <tr valign="top" class="row-6 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_gutenberg"><?php esc_html_e( 'Enable Gutenberg', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
	                	<input name="divi-machine_dmach_gutenberg" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_gutenberg" value="1" <?php checked( $dmach_gutenberg, '1');?>>
	                </div>
	                <p class="description"><?php esc_html_e( 'Enable the Gutenberg Builder?', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-7 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_prettify_post"><?php esc_html_e( 'Prettify URL', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
	                	<input name="divi-machine_dmach_prettify_post" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_prettify_post" value="1" <?php checked( $dmach_prettify_post, '1');?>>
	                </div>
	                <p class="description"><?php esc_html_e( 'If you want to prettify the URL, enable this. It will change the URL to be post-type/category/single instead of /post-type_category/single. NOTE: Does not work with Hierarchical categories', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-8 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_exclude_from_search"><?php esc_html_e( 'Exclude From Search', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
	                	<input name="divi-machine_dmach_exclude_from_search" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_exclude_from_search" value="1" <?php checked( $dmach_exclude_from_search, '1');?>>
	                </div>
	                <p class="description"><?php esc_html_e( 'Posts of this type should be excluded from search results.', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-9 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_enable_archives"><?php esc_html_e( 'Enable Archives', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	                <select name="divi-machine_dmach_enable_archives" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_enable_archives, "1");?>><?php esc_html_e( 'Yes (use default slug)', 'divi-machine');?></option>
	                    <option value="true_custom" <?php selected( $dmach_enable_archives, "true_custom");?>><?php esc_html_e( 'Yes (set a custom archive slug - below)', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_enable_archives, "0");?>><?php esc_html_e( 'No (prevent archive pages)', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( 'Enables post type archives. Post type key is used as default archive slug.', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-10 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_custom_archive_slug"><?php esc_html_e( 'Custom Archive Slug', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	                <input class="regular-text" name="divi-machine_dmach_custom_archive_slug" placeholder="" maxlength="" id="divi-machine_dmach_custom_archive_slug" type="text" value="<?php echo $dmach_custom_archive_slug;?>"> 
	                <p class="description"><?php esc_html_e( 'Set custom archive slug.', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-11 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_custom_post_slug"><?php esc_html_e( 'Custom Post Slug', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	                <input class="regular-text" name="divi-machine_dmach_custom_post_slug" placeholder="" maxlength="" id="divi-machine_dmach_custom_post_slug" type="text" value="<?php echo $dmach_custom_post_slug;?>"> 		
	                <p class="description"><?php esc_html_e( 'Set custom post slug. Leave it blank if you don\'t want to use custom slug.', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-12 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_hierarchical"><?php esc_html_e( 'Hierarchical', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	            	<div class="et-box-content">
	                	<input name="divi-machine_dmach_hierarchical" type="checkbox" class="et-checkbox yes_no_button" id="divi-machine_dmach_hierarchical" value="1" <?php checked( $dmach_hierarchical, '1');?>>
	                </div>
	                <p class="description"><?php esc_html_e( 'If you want your posts to have descendants (like pages) where you have parent and children posts - enable this.', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-13 odd">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_rewrite"><?php esc_html_e( 'Rewrite', 'divi-machine');?></label>
	            </th>
	            <td class="second">
	                <select name="divi-machine_dmach_rewrite" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_rewrite, "1");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_rewrite, "0");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( 'Whether or not WordPress should use rewrites for this post type.', 'divi-machine');?></p>
	            </td>
	        </tr>
	        <tr valign="top" class="row-14 even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_rewrite_withfront"><?php esc_html_e( 'With Front', 'divi-machine');?></label>
	            </th>
	            <td class="second tf-select">
	                <select name="divi-machine_dmach_rewrite_withfront" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true"  <?php selected( $dmach_rewrite_withfront, "1");?>>True</option>
	                    <option value="false" <?php selected( $dmach_rewrite_withfront, "0");?>>False</option>
	                </select>
	                <p class="description"><?php esc_html_e( 'Should the permalink structure be prepended with the front base. (example: if your permalink structure is /blog/, then your links will be: false->/cars/, true->/blog/cars/).', 'divi-machine');?></p>
	            </td>
	        </tr>
	    </tbody>
	</table>
<?php    
}

function dmach_post_labels_meta_box( $post ) {

    $dmach_name_plural = get_post_meta( $post->ID, 'divi-machine_dmach_name_plural', true );
    $dmach_menu_name = get_post_meta( $post->ID, 'divi-machine_dmach_menu_name', true );
    $dmach_admin_bar_name = get_post_meta( $post->ID, 'divi-machine_dmach_admin_bar_name', true );
    $dmach_all_items = get_post_meta( $post->ID, 'divi-machine_dmach_all_items', true );
    $dmach_add_new_item = get_post_meta( $post->ID, 'divi-machine_dmach_add_new_item', true );
    $dmach_add_new = get_post_meta( $post->ID, 'divi-machine_dmach_add_new', true );
    $dmach_new_item = get_post_meta( $post->ID, 'divi-machine_dmach_new_item', true );
    $dmach_edit_item = get_post_meta( $post->ID, 'divi-machine_dmach_edit_item', true );
    $dmach_update_item = get_post_meta( $post->ID, 'divi-machine_dmach_update_item', true );
    $dmach_view_item = get_post_meta( $post->ID, 'divi-machine_dmach_view_item', true );
    $dmach_view_items = get_post_meta( $post->ID, 'divi-machine_dmach_view_items', true );
    $dmach_search_item = get_post_meta( $post->ID, 'divi-machine_dmach_search_item', true );

?>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_name_plural"><?php echo esc_html__( "Name (Plural)", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_name_plural" placeholder="" maxlength="" id="divi-machine_dmach_name_plural" type="text" value="<?php echo $dmach_name_plural;?>">
					<p class="description"><?php echo esc_html__( "Post type plural name. e.g. Products, Events or Movies.", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_menu_name"><?php echo esc_html__( "Menu Name", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_menu_name" placeholder="" maxlength="" id="divi-machine_dmach_menu_name" type="text" value="<?php echo $dmach_menu_name;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_admin_bar_name"><?php echo esc_html__( "Admin Bar Name", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_admin_bar_name" placeholder="" maxlength="" id="divi-machine_dmach_admin_bar_name" type="text" value="<?php echo $dmach_admin_bar_name;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_all_items"><?php echo esc_html__( "All Items", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_all_items" placeholder="" maxlength="" id="divi-machine_dmach_all_items" type="text" value="<?php echo $dmach_all_items;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_add_new_item"><?php echo esc_html__( "Add New Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_add_new_item" placeholder="" maxlength="" id="divi-machine_dmach_add_new_item" type="text" value="<?php echo $dmach_add_new_item;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_add_new"><?php echo esc_html__( "Add New", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_add_new" placeholder="" maxlength="" id="divi-machine_dmach_add_new" type="text" value="<?php echo $dmach_add_new;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_new_item"><?php echo esc_html__( "New Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_new_item" placeholder="" maxlength="" id="divi-machine_dmach_new_item" type="text" value="<?php echo $dmach_new_item;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_edit_item"><?php echo esc_html__( "Edit Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_edit_item" placeholder="" maxlength="" id="divi-machine_dmach_edit_item" type="text" value="<?php echo $dmach_edit_item;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_update_item"><?php echo esc_html__( "Update Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_update_item" placeholder="" maxlength="" id="divi-machine_dmach_update_item" type="text" value="<?php echo $dmach_update_item;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_view_item"><?php echo esc_html__( "View Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_view_item" placeholder="" maxlength="" id="divi-machine_dmach_view_item" type="text" value="<?php echo $dmach_view_item;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_view_items"><?php echo esc_html__( "View Items", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_view_items" placeholder="" maxlength="" id="divi-machine_dmach_view_items" type="text" value="<?php echo $dmach_view_items;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_search_item"><?php echo esc_html__( "Search Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_search_item" placeholder="" maxlength="" id="divi-machine_dmach_search_item" type="text" value="<?php echo $dmach_search_item;?>">
				</td>
			</tr>
		</tbody>
	</table>
<?php    
}

function dmach_tax_general_meta_box( $post ) {
	wp_nonce_field( 'dmach_tax_nonce', 'dmach_tax_nonce' );

    $dmach_tax_slug = get_post_meta( $post->ID, 'divi-machine_dmach_tax_slug', true );
    $dmach_tax_plural = get_post_meta( $post->ID, 'divi-machine_dmach_tax_plural', true );
    $dmach_tax_single = get_post_meta( $post->ID, 'divi-machine_dmach_tax_single', true );
    $dmach_tax_post_type = get_post_meta( $post->ID, 'divi-machine_dmach_tax_post_type', true );
    $dmach_posts = get_all_post_types();

?>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="row-1 odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_slug"><?php echo esc_html__( "Taxonomy Slug", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_slug" placeholder="" maxlength="" id="divi-machine_dmach_tax_slug" type="text" value="<?php echo $dmach_tax_slug;?>">
					<p class="description"><?php echo esc_html__( "Set slug for your taxonomy. Slugs should only contain alphanumeric, latin characters. Underscores should be used in place of spaces.", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="row-2 even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_plural"><?php echo esc_html__( "Name (Plural)", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_plural" placeholder="" maxlength="" id="divi-machine_dmach_tax_plural" type="text" value="<?php echo $dmach_tax_plural;?>">
					<p class="description"><?php echo esc_html__( "Used for the taxonomy admin menu item.", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="row-3 odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_single"><?php echo esc_html__( "Name (Single)", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_single" placeholder="" maxlength="" id="divi-machine_dmach_tax_single" type="text" value="<?php echo $dmach_tax_single;?>"> 			
					<p class="description"><?php echo esc_html__( "Used when a singular label is needed.", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="even">
	            <th scope="row" class="first">
	                <label for="divi-machine_dmach_tax_post_type"><?php echo esc_html__( "Attach to Post Type", 'divi-machine' );?></label>
	            </th>
	            <td class="second tf-select">
	                <select name="divi-machine_dmach_tax_post_type" tabindex="-1" class="" aria-hidden="true">
			<?php 	foreach( $dmach_posts as $post_key => $post_type) { ?>
	                    <option value="<?php echo $post_key;?>" <?php selected( $dmach_tax_post_type, $post_key);?>><?php echo esc_html__( $post_type, 'divi-machine' );?></option>
			<?php  	} ?>
	                </select>
	                <p class="description"><?php echo esc_html__( "Add the post type for the taxonomy to attach to", 'divi-machine' );?></p>
	            </td>
	        </tr>
		</tbody>
	</table>
<?php    
}

function dmach_tax_labels_meta_box( $post ) {

    $dmach_tax_menu_name 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_menu_name', true );
    $dmach_tax_all_items 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_all_items', true );
    $dmach_tax_edit_item 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_edit_item', true );
    $dmach_tax_view_item 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_view_item', true );
    $dmach_tax_update_item 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_update_item', true );
    $dmach_tax_add_new 			= get_post_meta( $post->ID, 'divi-machine_dmach_tax_add_new', true );
    $dmach_tax_new_item 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_new_item', true );
    $dmach_tax_parent 			= get_post_meta( $post->ID, 'divi-machine_dmach_tax_parent', true );
    $dmach_tax_parent_colon 	= get_post_meta( $post->ID, 'divi-machine_dmach_tax_parent_colon', true );
    $dmach_tax_search 			= get_post_meta( $post->ID, 'divi-machine_dmach_tax_search', true );
    $dmach_tax_popular 			= get_post_meta( $post->ID, 'divi-machine_dmach_tax_popular', true );
    $dmach_tax_seperate_commas 	= get_post_meta( $post->ID, 'divi-machine_dmach_tax_seperate_commas', true );
    $dmach_tax_add_remove 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_add_remove', true );
    $dmach_tax_most_used 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_most_used', true );
    $dmach_tax_notfound 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_notfound', true );
    $dmach_tax_noterms	 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_noterms', true );
    $dmach_tax_item_list_nav	= get_post_meta( $post->ID, 'divi-machine_dmach_tax_item_list_nav', true );
    $dmach_tax_item_list 		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_item_list', true );

?>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_menu_name"><?php echo esc_html__( "Menu Name", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_menu_name" placeholder="" maxlength="" id="divi-machine_dmach_tax_menu_name" type="text" value="<?php echo $dmach_tax_menu_name;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_all_items"><?php echo esc_html__( "All Items", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_all_items" placeholder="" maxlength="" id="divi-machine_dmach_tax_all_items" type="text" value="<?php echo $dmach_tax_all_items;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_edit_item"><?php echo esc_html__( "Edit Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_edit_item" placeholder="" maxlength="" id="divi-machine_dmach_tax_edit_item" type="text" value="<?php echo $dmach_tax_edit_item;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_view_item"><?php echo esc_html__( "View Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_view_item" placeholder="" maxlength="" id="divi-machine_dmach_tax_view_item" type="text" value="<?php echo $dmach_tax_view_item;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_update_item"><?php echo esc_html__( "Update Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_update_item" placeholder="" maxlength="" id="divi-machine_dmach_tax_update_item" type="text" value="<?php echo $dmach_tax_update_item;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_add_new"><?php echo esc_html__( "Add New", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_add_new" placeholder="" maxlength="" id="divi-machine_dmach_tax_add_new" type="text" value="<?php echo $dmach_tax_add_new;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_new_item"><?php echo esc_html__( "New Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_new_item" placeholder="" maxlength="" id="divi-machine_dmach_tax_new_item" type="text" value="<?php echo $dmach_tax_new_item;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_parent"><?php echo esc_html__( "Parent Item", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_parent" placeholder="" maxlength="" id="divi-machine_dmach_tax_parent" type="text" value="<?php echo $dmach_tax_parent;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_parent_colon"><?php echo esc_html__( "Parent Item Colon", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_parent_colon" placeholder="" maxlength="" id="divi-machine_dmach_tax_parent_colon" type="text" value="<?php echo $dmach_tax_parent_colon;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_search"><?php echo esc_html__( "Search Items", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_search" placeholder="" maxlength="" id="divi-machine_dmach_tax_search" type="text" value="<?php echo $dmach_tax_search;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_popular"><?php echo esc_html__( "Popular Items", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_popular" placeholder="" maxlength="" id="divi-machine_dmach_tax_popular" type="text" value="<?php echo $dmach_tax_popular;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_seperate_commas"><?php echo esc_html__( "Separate Items with Commas", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_seperate_commas" placeholder="" maxlength="" id="divi-machine_dmach_tax_seperate_commas" type="text" value="<?php echo $dmach_tax_seperate_commas;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_add_remove"><?php echo esc_html__( "Add or Remove Items", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_add_remove" placeholder="" maxlength="" id="divi-machine_dmach_tax_add_remove" type="text" value="<?php echo $dmach_tax_add_remove;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_most_used"><?php echo esc_html__( "Choose From Most Used", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_most_used" placeholder="" maxlength="" id="divi-machine_dmach_tax_most_used" type="text" value="<?php echo $dmach_tax_most_used;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_notfound"><?php echo esc_html__( "Not found", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_notfound" placeholder="" maxlength="" id="divi-machine_dmach_tax_notfound" type="text" value="<?php echo $dmach_tax_notfound;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_noterms"><?php echo esc_html__( "No terms", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_noterms" placeholder="" maxlength="" id="divi-machine_dmach_tax_noterms" type="text" value="<?php echo $dmach_tax_noterms;?>">
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_item_list_nav"><?php echo esc_html__( "Items List Navigation", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_item_list_nav" placeholder="" maxlength="" id="divi-machine_dmach_tax_item_list_nav" type="text" value="<?php echo $dmach_tax_item_list_nav;?>">
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_item_list"><?php echo esc_html__( "Items List", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_item_list" placeholder="" maxlength="" id="divi-machine_dmach_tax_item_list" type="text" value="<?php echo $dmach_tax_item_list;?>">
				</td>
			</tr>
		</tbody>
	</table>
<?php    
}

function dmach_tax_advanced_meta_box( $post ) {

    $dmach_tax_public				= get_post_meta( $post->ID, 'divi-machine_dmach_tax_public', true );
    $dmach_tax_public_queryable		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_public_queryable', true );
    $dmach_tax_hierarchical			= get_post_meta( $post->ID, 'divi-machine_dmach_tax_hierarchical', true );
    $dmach_tax_show_ui				= get_post_meta( $post->ID, 'divi-machine_dmach_tax_show_ui', true );
    $dmach_tax_show_in_menu			= get_post_meta( $post->ID, 'divi-machine_dmach_tax_show_in_menu', true );
    $dmach_tax_show_nav_menu		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_show_nav_menu', true );
    $dmach_tax_rewrite				= get_post_meta( $post->ID, 'divi-machine_dmach_tax_rewrite', true );
    $dmach_tax_query_rewrite_custom	= get_post_meta( $post->ID, 'divi-machine_dmach_tax_query_rewrite_custom', true );
    $dmach_tax_rewrite_front		= get_post_meta( $post->ID, 'divi-machine_dmach_tax_rewrite_front', true );
    $dmach_tax_rewrite_hierarchical	= get_post_meta( $post->ID, 'divi-machine_dmach_tax_rewrite_hierarchical', true );

?>
	<table class="form-table">
		<tbody>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_public"><?php echo esc_html__( "Public", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_public" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_public, "1");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_public, "0");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( "(default: true) Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users.", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_public_queryable"><?php echo esc_html__( "Public Queryable", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_public_queryable" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_public_queryable, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_public_queryable, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: value of "public" setting) Whether or not the taxonomy should be publicly queryable.', 'divi-machine');?></p>
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_hierarchical"><?php echo esc_html__( "Hierarchical", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_hierarchical" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_hierarchical, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_hierarchical, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: false) Whether the taxonomy can have parent-child relationships.', 'divi-machine');?></p>
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_show_ui"><?php echo esc_html__( "Show UI", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_show_ui" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_show_ui, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_show_ui, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: true) Whether to generate a default UI for managing this custom taxonomy.', 'divi-machine');?></p>
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_show_in_menu"><?php echo esc_html__( "Show In Menu", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_show_in_menu" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_show_in_menu, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_show_in_menu, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: value of show_ui) Whether to show the taxonomy in the admin menu.', 'divi-machine');?></p>
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_show_nav_menu"><?php echo esc_html__( "Show In Nav Menus", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_show_nav_menu" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_show_nav_menu, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_show_nav_menu, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: value of public) Whether to make the taxonomy available for selection in navigation menus.', 'divi-machine');?></p>
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_rewrite"><?php echo esc_html__( "Rewrite", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_rewrite" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_rewrite, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_rewrite, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: true) Whether or not WordPress should use rewrites for this taxonomy.', 'divi-machine');?></p>
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_query_rewrite_custom"><?php echo esc_html__( "Custom Rewrite String", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<input class="regular-text" name="divi-machine_dmach_tax_query_rewrite_custom" placeholder="" maxlength="" id="divi-machine_dmach_tax_query_rewrite_custom" type="text" value="<?php echo $dmach_tax_query_rewrite_custom;?>">
					<p class="description"><?php echo esc_html_e( "Custom taxonomy rewrite slug.", 'divi-machine' );?></p>
				</td>
			</tr>
			<tr valign="top" class="odd">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_rewrite_front"><?php echo esc_html__( "Rewrite With Front", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_rewrite_front" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_rewrite_front, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_rewrite_front, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: true) Should the permastruct be prepended with the front base.', 'divi-machine');?></p>
				</td>
			</tr>
			<tr valign="top" class="even">
				<th scope="row" class="first">
					<label for="divi-machine_dmach_tax_rewrite_hierarchical"><?php echo esc_html__( "Rewrite Hierarchical", 'divi-machine' );?></label>
				</th>
				<td class="second">
					<select name="divi-machine_dmach_tax_rewrite_hierarchical" tabindex="-1" class="" aria-hidden="true">
	                    <option value="true" <?php selected( $dmach_tax_rewrite_hierarchical, "true");?>><?php esc_html_e( 'Yes', 'divi-machine');?></option>
	                    <option value="false" <?php selected( $dmach_tax_rewrite_hierarchical, "false");?>><?php esc_html_e( 'No', 'divi-machine');?></option>
	                </select>
	                <p class="description"><?php esc_html_e( '(default: false) Should the permastruct allow hierarchical urls.', 'divi-machine');?></p>
				</td>
			</tr>
		</tbody>
	</table>
<?php    
}

add_action( 'wp_dashboard_setup', 'dm_check_validation' );

function dm_check_validation() {
    if (defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}

	$a_result = '';

	$de_su = 'https://diviengine.com/';

	$de_su_json = $de_su . 'wp-json/de_plugins/products';

	$site_url = get_option( 'siteurl' );
	$site_url = str_replace( 'https://', '', $site_url );
	$site_url = str_replace( 'http://', '', $site_url );
	$site_url = rtrim( $site_url, '/' );

	$aj_gaket = get_option( 'et_automatic_updates_options' );
    $aj_gaket_val = is_array( $aj_gaket ) ? trim($aj_gaket['api_key']) : null;
	$code_l = get_option('divi_machine_license');
	$code_d = "Y";

	if ( isset( $code_l['key'] ) && $code_l['key'] !== '' ) {
		$code_d = $code_l['key'];
	}

	//$product_id = '58499';
	$et_status = 'N';

	if ( DE_DM_P == 'm_a' && $aj_gaket_val != '' ) {
		/*$json = file_get_contents('https://www.elegantthemes.com/marketplace/index.php/wp-json/api/v1/check_subscription/product_id/'.$product_id.'/api_key/'.$aj_gaket_val);
        $data = json_decode($json);
        $code_m = $data->code;
        if ( $code_m != 'no_billing_records') {
			$et_status = 'Y';
        }*/
	}

	$secure_string = $site_url . '|' . 'de_dm' . '|' . DE_DM_P . '|' . $code_d . '|' . $et_status;
	$file = DE_DMACH_PATH . '/key.rem';
	$de_keys = get_option( 'de_keys', array() );

	if ( !file_exists( $file ) ) {
		if ( !empty( $de_keys['de_dm'] ) ) {
			$keypair = $de_keys['de_dm'];
			file_put_contents($file, $keypair);
		} else {
			$keypair = md5( $site_url );
			file_put_contents($file, $keypair);
			$de_keys['de_dm'] = $keypair;
			update_option( 'de_keys', $de_keys );
		}
	} else {
		$keypair = file_get_contents( $file );
		$de_keys['de_dm'] = $keypair;
		update_option( 'de_keys', $de_keys );
	}

	$body = array(
		'keypair'	=> $keypair,
		'secure_str'	=> base64_encode( $secure_string )
	);

	$args = array(
		'body'        => $body,
	);

	$response = wp_remote_post( $de_su_json, $args );
	$a_result = str_replace('"', '', wp_remote_retrieve_body( $response ));

	if ( $a_result == 'msg_ok' ) {
		return true;
	} else {
	
		return false;
	}
}

add_action('wp_ajax_divi_machine_export_action', 'divi_machine_export_action');

function divi_machine_export_action() {
    // Do something
    $mydata = get_option('divi-machine_options');
    $mydata = maybe_unserialize($mydata);
    $export_data = [];

    foreach ($mydata as $key => $value) {
      $data_val = str_ireplace("\n", "<br/>", $value);
      $export_data[] = array($key, $data_val);
    }

    wp_send_json_success(__($export_data, 'default'));
}

add_action('wp_ajax_divi_machine_import_action', 'divi_machine_import_action');

function divi_machine_import_action() {
	global $deGlobalOptions;
	$setting_csv = file_get_contents( $_REQUEST['file_id'] ); // phpcs:ignore
	$lines = explode("\n", $setting_csv); // split data by new lines
	$linevalues = [];
	foreach ($lines as $i => $line) {

		$values = explode(',', $line);
		$key = $values[0];
		$value = $values[1];
		if (count($values) > 2) {
			unset($values[0]);
			$value = implode( ",", $values );
			$value = trim( $value,'"');
		}
		$linevalues[$key] = str_ireplace( "<br/>", "\n", trim($value, '"') );
	}

	$deGlobalOptions[ 'divi-machine' ] = $linevalues;

	$linevalues = serialize($linevalues);

	update_option('divi-machine_options', $linevalues);
	wp_send_json_success(__('Successfully imported', 'default'));
}

if ( !function_exists( 'de_change_locale' ) ) {
    add_filter('determine_locale', 'de_change_locale', 9999, 1);
    function de_change_locale( $locale ) {
    	
	    if ( wp_doing_ajax() && isset($_REQUEST['action']) && $_REQUEST['action'] == 'divi_filter_ajax_handler' ) {
		    if ( $_REQUEST['action'] == 'divi_filter_ajax_handler' ) {
                $locale = get_locale();
            }
	    }

        return $locale;
    }
}