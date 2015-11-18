<?php
/* ==========================================================================
   ==========================================================================
   ==========================================================================
   Shared/Site-wide Functions
   - admin/font-end specific functions follow
   ==========================================================================
   ==========================================================================
   ========================================================================== */





/* ==========================================================================
   Disable XMLRPC
   ========================================================================== */
add_filter('xmlrpc_enabled', '__return_false');





/* ==========================================================================
   ==========================================================================
   ==========================================================================
   Admin Functions (back-end)
   ==========================================================================
   ==========================================================================
   ========================================================================== */





if(is_admin()){


    /**
     * Rename the Excerpt Metabox and Add Description
     *
     * Removes the default postexcerpt metabox and replaces it with a new
     * metabox with custom title and description. Handy for providing
     * instructions to the end user.
     *
     * @global $post    Wordpress post object.
     *
     * @return string   Original experpt metabox markup with custom title and description appended to it.
     *
     */
    function f5bb_excerpt_box_title() {
        $post_types = array('page', 'cars', 'trucks');
        foreach($post_types as $post_type){
            remove_meta_box( 'postexcerpt', $post_type, 'side' );
            add_meta_box('postexcerpt', __('Custom Excerpt', 'f5bb'), 'f5bb_post_excerpt_meta_box', $post_type, 'normal', 'high');
        }
    }
    function f5bb_post_excerpt_meta_box(){
      global $post;
      echo "<p>" . __('This field is not required. A post excerpt is automatically generated from the post content field abolve. If an excerpt is provided below, that custom excerpt will override the automatic excerpt.', 'f5bb') . "</p>";
      $orig_content = post_excerpt_meta_box($post);
      echo $orig_content;
    }


    /**
     * Page Name Class for Admin Body Tags
     *
     * Adds the "post_name" as a css class to the admin parent pages. Adds "parent-post_name"
     * as css class to the admin child pages.
     *
     * @global $post    Wordpress post object.
     *
     * @return string   The class name.
     *
     */
    function f5bb_admin_body_class(){
        global $post;
        $output = '';
        if(isset($post->post_name) && $post->post_name != ''){
            $output .= $post->post_name;
        }
        if(isset($post->post_parent) && $post->post_parent != 0){
            // get the post_name to use for the class name, rather than the id
            $p = get_post($post->post_parent);
            $output .= ' parent-' . $p->post_name;
        }
        return $output;
    }
    add_filter('admin_body_class', 'f5bb_admin_body_class');


    /**
     * Remove Meta Boxes
     *
     * Remove metaboxes from admin pages. Add another array item to $boxes and
     * include the id of the metabox and context (normal, advanced, or side).
     *
     * @global $post Wordpress post object.
     *
     */
    // function f5bb_remove_meta_boxes(){
    //     global $post;
    //     $boxes = array(
    //       array( 'id' => 'wpcf-marketing', 'context' => 'side' ),
    //       array( 'id' => 'revisionsdiv', 'context' => 'normal' ),
    //     );
    //     $post_type = get_post_type($post->ID);
    //     foreach($boxes as $box){
    //       remove_meta_box($box['id'], $post_type, $box['context']);
    //     }
    // }
    // add_action('admin_head', 'f5bb_remove_meta_boxes');


    /**
     * Reposition Meta Boxes
     *
     * Override meta box positions by removing the meta box, then adding it
     * again and then by setting the priority.
     *
     * @global $wp_meta_boxes       Wordpress meta box array, holds all the widgets for wp-admin.
     * @global $post                Wordpress post object.
     *
     */
    function f5bb_reposition_meta_boxes(){
        global $wp_meta_boxes;
        global $post;

        /**
         * Remove Meta Boxes
         */
        // // featured image box (default wp meta box)
        // remove_meta_box('postimagediv', 'page', 'side');
        // // featured video box (plugin meta box)
        // $featured_video_box = $wp_meta_boxes[$post->post_type]['side']['core']['featured_video_plus-box'];
        // unset($wp_meta_boxes[$post->post_type]['side']['core']['featured_video_plus-box']);
        /**
         * Add Meta Boxes
         */
        // // featured image
        // add_meta_box('postimagediv', __('Featured Image', 'f5bb'), 'post_thumbnail_meta_box', 'page', 'side', 'core');
        // // featured video
        // $wp_meta_boxes[$post->post_type]['side']['core']['featured_video_plus-box'] = $featured_video_box;

    }
    add_action('admin_head', 'f5bb_reposition_meta_boxes');


    /**
     * Remove Menu Items
     *
     * Removes links from the admin menu. Note that pages are still accessible, this simply removes the link.
     * I suggest using a plugin such as Advanced Access Manager or Toolset's Access plugin to manage
     * users, roles and capabilities.
     * You can find the file name for the link by inspecting the hyperlink tag.
     * For example, Media links to 'upload.php'
     *
     */
    function f5bb_remove_admin_bar_links(){
        remove_menu_page('edit.php');               // Posts
        remove_menu_page('edit-comments.php');      // Comments
    }
    add_action('admin_menu', 'f5bb_remove_admin_bar_links');


    /**
     * Settings Menu Item for Social Media Links
     *
     * Adds a section under Settings titled Social Media Settings.
     * Includes Facebook, Twitter, LinkedIn and Youtube.
     *
     */
    function f5bb_social_media_settings() { ?>
        <div id="theme-options-wrap">
            <h2><?php _e('Social Media Settings', 'f5bb'); ?></h2>
            <p><?php _e('URLs for your social media profiles.', 'f5bb'); ?></p>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php settings_fields('social_media_settings'); ?>
                <?php do_settings_sections(__FILE__); ?>
                <p class="submit">
                    <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
                </p>
            </form>
        </div>
    <?php
    }
    function register_and_build_fields() {
        register_setting('social_media_settings', 'social_media_settings', 'validate_setting');
        add_settings_section('general_settings', '', 'section_general', __FILE__);
    }
     function section_general(){
        add_settings_field('facebook', __('Facebook', 'f5bb'), 'facebook', __FILE__, 'general_settings', array('class' => 'regular-text'));
        add_settings_field('twitter', __('Twitter', 'f5bb'), 'twitter', __FILE__, 'general_settings', array('class' => 'regular-text'));
        add_settings_field('linkedin', __('LinkedIn', 'f5bb'), 'linkedin', __FILE__, 'general_settings', array('class' => 'regular-text'));
        add_settings_field('youtube', __('YouTube', 'f5bb'), 'youtube', __FILE__, 'general_settings', array('class' => 'regular-text'));
    }
    function validate_setting($social_media_settings) {
        $social_media_settings['facebook'] = trim($social_media_settings['facebook']);
        $social_media_settings['twitter'] = trim($social_media_settings['twitter']);
        $social_media_settings['linkedin'] = trim($social_media_settings['linkedin']);
        $social_media_settings['youtube'] = trim($social_media_settings['youtube']);
        return $social_media_settings;
    }
    function facebook(){
        $options = get_option('social_media_settings');
        $val = '';
        if(isset($options['facebook'])){ $val = $options['facebook']; }
        echo "<input name='social_media_settings[facebook]' type='text' value='$val' placeholder='" . __('Enter Facebook URL here', 'f5bb') . "' class='regular-text' />";
    }
    function twitter(){
        $options = get_option('social_media_settings');
        $val = '';
        if(isset($options['twitter'])){ $val = $options['twitter']; }
        echo "<input name='social_media_settings[twitter]' type='text' value='$val' placeholder='" . __('Enter Twitter URL here', 'f5bb') . "' class='regular-text' />";
    }
    function linkedin(){
        $options = get_option('social_media_settings');
        $val = '';
        if(isset($options['linkedin'])){ $val = $options['linkedin']; }
        echo "<input name='social_media_settings[linkedin]' type='text' value='$val' placeholder='" . __('Enter LinkedIn URL here', 'f5bb') . "' class='regular-text' />";
    }
    function youtube(){
        $options = get_option('social_media_settings');
        $val = '';
        if(isset($options['youtube'])){ $val = $options['youtube']; }
        echo "<input name='social_media_settings[youtube]' type='text' value='$val' placeholder='" . __('Enter Youtube URL here', 'f5bb') . "' class='regular-text' />";
    }
    function social_media_settings_page() {
        add_options_page('Theme Settings', 'Social Media URLs', 'administrator', __FILE__, 'f5bb_social_media_settings');
    }
    add_action('admin_init', 'register_and_build_fields');
    add_action('admin_menu', 'social_media_settings_page');





}else{





    /* ==========================================================================
       ==========================================================================
       ==========================================================================
       Template Functions (front-end)
       ==========================================================================
       ==========================================================================
       ========================================================================== */





    /**
     * Custom Excerpts
     *
     * Returns the exerpt of a string. The string, start position and excerpt
     * length are passed as parameters.
     *
     * @param string $str       The sting to trim for an excerpt.
     * @param int $startPos     The position to start the trim, typically 0.
     * @param int $max_length   The length of the string in characters.
     *
     * @return string
     *
     */
    function f5bb_get_excerpt($str, $startPos=0, $max_length=100){
        if(strlen($str) > $max_length) {
            $excerpt   = substr($str, $startPos, $max_length-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
        } else {
            $excerpt = $str;
        }
        return $excerpt;
    }


    /**
     * Page Body CSS Class
     *
     * Adds the page name to the body tag class.
     *
     * @global $wp_query        Wordpress query object.
     * @global $post            Wordpress post object.
     *
     * @return string
     *
     *
     *
     */
    function page_bodyclass() {
        global $wp_query;
        global $post;

        // echo 'parent: ' . $post->post_parent;

        $page = '';
        if (is_front_page() ) {
               $page = 'home';
        } elseif (is_page()) {
            $page = $wp_query->query_vars["pagename"];

        }elseif(is_404()){
            $page = 'error404';
        }elseif(is_archive()){
          $page = 'archive';
        }else{
            $page = $post->post_type;
        }
        echo 'class="' . $page . '"';
    }



        // if(isset($post->post_parent) && $post->post_parent != 0){
        //     // get the post_name to use for the class name, rather than the id
        //     $p = get_post($post->post_parent);
        //     $output .= ' parent-' . $p->post_name;
        // }




    /* ==========================================================================
       Return a List of Linked Terms
       ========================================================================== */
    function get_term_links($id, $taxonomy_slug, $before_link='', $after_link=''){

        $terms = get_the_terms($id, $taxonomy_slug);
        $output = '';

        if($terms){
          foreach($terms as $term){
              $term_url = get_term_link($term, 'news-category');
              $name = $term->name;

              if($before_link && $after_link) $output .= $before_link . "<a href='$term_url'>$name</a> " . $after_link;
              else $output .= "<a href='$term_url'>$name</a> ";
          }
          //trim the last comma and return the string
          return rtrim($output, ", ");

        }

    }


    /* ==========================================================================
       Override Search Functionatlity for Custom Post Types
       - case is the page name/slug
       - $search_type is the post type
       ========================================================================== */
    function custom_cpt_search_form( $form ) {

      global $post;
      $search_type = '';
      wp_reset_postdata();

      if(isset($post->post_name)){
        switch ($post->post_name) {
          case 'page-slug':
            $search_type = 'post-type';
            break;
        }
      }

      if($search_type != ''){

        $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
          <div class="search-field-wrapper">
            <span class="infield-label">
            <input type="text" value="" name="s" id="s" placeholder="Enter a Keyword...">
            </span>
          </div>
          <input type="hidden" value="' . $search_type . '" name="post_type" id="post_type" />
          <div class="clearfix"></div>
          </form>';

        return $form;
      }
    }
    add_filter( 'get_search_form', 'custom_cpt_search_form', 10, 1 );
    add_theme_support( 'html5', array( 'search-form' ) );


    /* ==========================================================================
       Get Related Content
       - the taxonomy name used is the post_type with "-tag" appended to it. For example,
       if the post_type is 'career', the taxonomy name should be 'career-tag'
       - must be echo'd
       ========================================================================== */
    function get_related($id=0, $post_type='', $box_title=''){

      global $post;

      //concat the post type following string for the taxonomy name
      $taxonomy = $post_type . '-tag';

      //the post's terms
      $custom_taxterms = wp_get_object_terms( $id, array($taxonomy), array('fields' => 'ids') );

      //if we have terms
      if($custom_taxterms){
        // arguments
        $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'orderby' => 'rand',
        'tax_query' => array(
          'relation' => 'OR',
            array(
              'taxonomy' => $taxonomy,
              'field' => 'id',
              'terms' => $custom_taxterms
            )
        ),
        'post__not_in' => array($id),
        );
        $related_items = new WP_Query( $args );

        if($related_items->have_posts()){

          $output = '<div class="row">';
          $output .= '<h4 class="sectionTitle">' . $box_title . '</h4>';

          while ( $related_items->have_posts() ) : $related_items->the_post();

            $output .= "<div class=' small-12 medium-4 columns'>";
            $output .= "<h2><a href='" . get_the_permalink() . "'>" . get_the_title() . "</a></h2>";
            $output .= get_term_links($post->ID, $taxonomy, '', '');
            $output .= "</div>";

          endwhile;

          $output .= '</div>';

          return $output;

        }
      }
    }


    /* ==========================================================================
       Get Featured Post Video or Image
       - video will take priority over the image
       $post_id = the post id
       $size = the wp image size
       $link = use permalink or not to link the image
       ========================================================================== */
    //echo
    function featured_video_image($post_id, $size, $link = false){
        if(has_post_video($post_id) && has_post_thumbnail()){
            the_post_video($size);
        }else if(has_post_video($post_id)){
            the_post_video($size);
        }else if(has_post_thumbnail()){
            if($link){
                echo "<div class='productBucketImage'>";
                echo "<a href='" . get_the_permalink($post_id) . "'>";
                $img_details = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
                echo "<img src='" . $img_details[0] . "' alt='" . get_the_title() . "' />";
                echo "</a>";
                echo "</div>";
            }else{
                the_post_thumbnail($size);
            }
        }
    }
    //no echo
    function get_featured_video_image($post_id, $size, $link = false){
        if(has_post_video($post_id) && has_post_thumbnail()){
            the_post_video($size);
        }else if(has_post_video($post_id)){
            the_post_video($size);
        }else if(has_post_thumbnail()){
            if($link){
                $output = '';
                $output = "<div class='productBucketImage'>";
                $output = "<a href='" . get_the_permalink($post_id) . "'>";
                $img_details = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
                $output = "<img src='" . $img_details[0] . "' alt='" . get_the_title() . "' />";
                $output = "</a>";
                $output = "</div>";
                return $output;
            }else{
                return get_the_post_thumbnail($post_id, $size);
            }
        }
    }


    /* ==========================================================================
       Track the Post Views for Most Popular Queries
       - this function will use a post meta variable to count the number of views
       - call set_post_views($post->ID) at the top of each template to increment the counte
       - call get_post_views($post-ID) to retrieve the current count
       ========================================================================== */
    function get_post_views($postID){
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 View";
        }
        return $count;
    }
    function set_post_views($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }


    /* ==========================================================================
       Allow Custom Post Types in date.php
       - this will allow the date template to use custom post typess
       - post types are set here: $query->set( 'post_type', array( 'cars', 'trucks' ) );
       ========================================================================== */
    function wpa_date_archive_post_types( $query ){
        if( $query->is_main_query() && $query->is_date() ):
            $query->set( 'post_type', array( 'cars', 'trucks' ) );
        endif;
    }
    add_action( 'pre_get_posts', 'wpa_date_archive_post_types' );

    /* ==========================================================================
       Yoast SEO Filters
       - remove default admin columns added by Yoast
       ========================================================================== */
    add_filter( 'wpseo_use_page_analysis', '__return_false' );
    add_filter('wpseo_metabox_prio', function(){ return 'low'; });

} // if(is_admin)










/* ==========================================================================
   ==========================================================================
   ==========================================================================
   Templating / File System
   ==========================================================================
   ==========================================================================
   ========================================================================== */


/* ==========================================================================
   Load Single Templates from Sub Directory
   ========================================================================== */
function f5bb_call_single_template_from_directory(){
    global $post;
    $post_type = $post->post_type;
    $template = get_template_directory() . "/templates-single/single-$post_type.php";
    if(file_exists($template)){
        // custom template
        load_template($template);
    }else{
        // default template
        load_template(get_template_directory() . "/single.php");
    }
}
add_filter('single_template', 'f5bb_call_single_template_from_directory');


/* ==========================================================================
   Load Taxonomy Templates from Sub Directory
   ========================================================================== */
function f5bb_call_taxonomy_template_from_directory(){
    global $post;
    $taxonomy_slug = get_query_var('taxonomy');
    $template = get_template_directory() . "/templates-taxonomy/taxonomy-$taxonomy_slug.php";
    if(file_exists($template)){
        // custom template
        load_template($template);
    }else{
        // default template
        load_template(get_template_directory() . "/taxonomy.php");
    }
}
add_filter('taxonomy_template', 'f5bb_call_taxonomy_template_from_directory');


/* ==========================================================================
   Custom Post ID Template
   - this will allow you to use a custom template for a specific post
   - the file name would look like 'single-12.php', where 12 is the post id
   ========================================================================== */
function single_id_template( $template ) {

    $post_id = get_the_ID();

    if ( is_single() &&  $post_id ) {
        $_template = locate_template( array( 'single-' . $post_id .'.php'  ) );
        $template = ( $_template ) ? $_template : $template;
    }

    return $template;
}
add_filter( 'template_include', 'single_id_template', 99 );







/* ==========================================================================
   ==========================================================================
   ==========================================================================
   Debug
   ==========================================================================
   ==========================================================================
   ========================================================================== */


/* ==========================================================================
   Write Debug Details to Log File ('wp-content/debug.log')
   ========================================================================== */
if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}










?>