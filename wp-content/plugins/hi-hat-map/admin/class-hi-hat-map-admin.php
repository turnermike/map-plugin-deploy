<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/admin
 * @author     Your Name <email@example.com>
 */
class hi_hat_map_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $hi_hat_map    The ID of this plugin.
	 */
	private $hi_hat_map;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $hi_hat_map       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $hi_hat_map, $version ) {

		$this->hi_hat_map = $hi_hat_map;
		$this->version = $version;

		// add item to settings menu
		// add_action('admin_menu', array($this, 'add_menu_item'));

		add_action('admin_menu', array($this, 'add_to_menu'));

	}


	public function add_to_menu(){

		add_menu_page(
			'',
			'Locations Map ',
			'manage_options',
			'hi-hat-map/admin/partials/locations.php',
			'',
			'dashicons-location-alt',
			11
		);

		// rename first menu item from 'Locations Map' to 'Edit Locations'
		add_submenu_page(
			'hi-hat-map/admin/partials/locations.php',
			'Edit Locations',
			'Edit Locations',
			'manage_options',
			'hi-hat-map/admin/partials/locations.php',
			''
		);

		// add 'Add Locations' menu item
		add_submenu_page(
			'hi-hat-map/admin/partials/locations.php',
			'Add Location',
			'Add Location',
			'manage_options',
			'hi-hat-map/admin/partials/add_location.php',
			''
		);

		// add 'Settings' menu item
		add_submenu_page(
			'hi-hat-map/admin/partials/locations.php',
			'Settings',
			'Settings',
			'manage_options',
			'hi-hat-map/admin/partials/settings.php',
			// 'hi_hat_locations_form',
			array($this, 'hi_hat_locations_form_page_handler')
		);

	}








	/**
	 * Form page handler checks is there some data posted and tries to save it
	 * Also it renders basic wrapper in which we are callin meta box render
	 */
	function hi_hat_locations_form_page_handler()
	{
	    global $wpdb;
	    $table_name = $wpdb->prefix . 'hi_hat_map_settings'; // do not forget about tables prefix

	    $message = '';
	    $notice = '';

	    // // this is default $item which will be used for new records
	    // $default = array(
	    //     'id' => 0,
	    //     'option_name' => '',
	    //     'option_value' => '',
	    //     'date_modified' => date('Y-m-d H:i:s'),
	    // );

	    $default = array(
	        'mapboxAPIKey' => '',
	        'date_modified' => date('Y-m-d H:i:s'),
	    );

	    // here we are verifying does this request is post back and have correct nonce
	    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {

	        // combine our default item with request params
	        $item = shortcode_atts($default, $_REQUEST);

	        // validate data, and if all ok save item to database
	        // if id is zero insert otherwise update
	        $item_valid = $this->hi_hat_map_validate_setting($item);

	        if ($item_valid === true) {

	            if ($item['id'] == 0) {

	                $result = $wpdb->insert($table_name, $item);

	                echo "<pre>";
	                var_dump($item);
	                echo "</pre>";

	                $item['id'] = $wpdb->insert_id;

	                if ($result) {
	                    $message = __('Item was successfully saved', 'hi_hat_map');
	                } else {
	                    $notice = __('There was an error while saving item', 'hi_hat_map');
	                }

	            } else {

	                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
	                if ($result) {
	                    $message = __('Item was successfully updated', 'hi_hat_map');
	                } else {
	                    $notice = __('There was an error while updating item', 'hi_hat_map');
	                }
	            }

	        } else {

	            // if $item_valid not true it contains error message(s)
	            $notice = $item_valid;

	        }
	    }
	    else {
	        // if this is not post back we load item to edit or give new one to create
	        $item = $default;
	        if (isset($_REQUEST['id'])) {
	            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
	            if (!$item) {
	                $item = $default;
	                $notice = __('Item not found', 'hi_hat_map');
	            }
	        }
	    }

	    // here we adding our custom meta box
	    add_meta_box('persons_form_meta_box', 'Location Data', array($this, 'hi_hat_map_form_meta_box_handler'), 'person', 'normal', 'default');

	    ?>

		<div class="wrap">
		    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
		    <h2><?php _e('Hi-hat Map Settings', 'hi_hat_map')?>
		    	<a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=hi-hat-map%2Fadmin');?>"><?php _e('back to list', 'hi_hat_map')?></a>
		    </h2>

		    <?php if (!empty($notice)): ?>
		    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
		    <?php endif;?>
		    <?php if (!empty($message)): ?>
		    <div id="message" class="updated"><p><?php echo $message ?></p></div>
		    <?php endif;?>

		    <form id="form" method="POST">
		        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
		        <?php /* NOTICE: here we storing id to determine will be item added or updated */ ?>
		        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>

		        <div class="metabox-holder" id="poststuff">
		            <div id="post-body">
		                <div id="post-body-content">
		                    <?php /* And here we call our custom meta box */ ?>
		                    <?php do_meta_boxes('person', 'normal', $item); ?>
		                    <input type="submit" value="<?php _e('Save', 'hi_hat_map')?>" id="submit" class="button-primary" name="submit">
		                </div>
		            </div>
		        </div>
		    </form>
		</div>
	<?php
	}



	/**
	 * This function renders our custom meta box
	 * $item is row
	 *
	 * @param $item
	 */
	public function hi_hat_map_form_meta_box_handler($item)
	{
	    ?>

	<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
	    <tbody>
	    <tr class="form-field">
	        <th valign="top" scope="row">
	            <label for="mapboxAPIKey"><?php _e('Mapbox API Key', 'hi_hat_map')?></label>
	        </th>
	        <td>
	            <input id="mapboxAPIKey" name="mapboxAPIKey" type="text" style="width: 95%" value="<?php echo esc_attr($item['mapboxAPIKey'])?>"
	                   size="50" class="code" placeholder="<?php _e('Mapbox API Key', 'hi_hat_map')?>" required>
	        </td>
	    </tr>
	    <!--
	    <tr class="form-field">
	        <th valign="top" scope="row">
	            <label for="email"><?php _e('E-Mail', 'hi_hat_map')?></label>
	        </th>
	        <td>
	            <input id="email" name="email" type="email" style="width: 95%" value="<?php echo esc_attr($item['email'])?>"
	                   size="50" class="code" placeholder="<?php _e('Your E-Mail', 'hi_hat_map')?>" required>
	        </td>
	    </tr>
	    <tr class="form-field">
	        <th valign="top" scope="row">
	            <label for="age"><?php _e('Age', 'hi_hat_map')?></label>
	        </th>
	        <td>
	            <input id="age" name="age" type="number" style="width: 95%" value="<?php echo esc_attr($item['age'])?>"
	                   size="50" class="code" placeholder="<?php _e('Your age', 'hi_hat_map')?>" required>
	        </td>
	    </tr>
	    -->
	    </tbody>
	</table>
	<?php
	}


	/**
	 * Simple function that validates data and retrieve bool on success
	 * and error message(s) on error
	 *
	 * @param $item
	 * @return bool|string
	 */
	function hi_hat_map_validate_setting($item)
	{
	    $messages = array();

	    echo "<pre>";
	    var_dump($item);
	    echo "</pre>";

	    if (empty($item['mapboxAPIKey'])) $messages[] = __('Mapbox API Key is required.', 'hi_hat_map');
	    // if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'hi_hat_map');
	    // if (!ctype_digit($item['age'])) $messages[] = __('Age in wrong format', 'hi_hat_map');
	    // if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
	    // if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
	    // ...

	    if (empty($messages)) return true;
	    return implode('<br />', $messages);
	}
































	// public function add_menu_item(){
	// 	add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', array($this, 'my_plugin_options') );
	// }

	// public function my_plugin_options() {
	// 	if ( !current_user_can( 'manage_options' ) )  {
	// 		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	// 	}
	// 	echo '<div class="wrap">';
	// 	echo '<p>Here is where the form would go if I actually had options.</p>';
	// 	echo '</div>';
	// }









	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in hi_hat_map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The hi_hat_map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->hi_hat_map, plugin_dir_url( __FILE__ ) . 'css/hi-hat-map-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in hi_hat_map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The hi_hat_map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->hi_hat_map, plugin_dir_url( __FILE__ ) . 'js/hi-hat-map-admin.js', array( 'jquery' ), $this->version, false );

	}

}





