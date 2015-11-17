<?php
/*
 *
 * Default Taxonomy Template
 *
 */
?>
<?php get_header(); ?>
    <section class="row">

        <div class="small-12 medium-9 columns">

            <div class="row">

                <div class="small-12 medium-8 columns">
                    <?php
                        // display the the title (taxonomy term)
                        $term_slug = get_query_var('term');
                        $taxonomy_slug = get_query_var('taxonomy');
                        $current_term = get_term_by('slug', $term_slug, $taxonomy_slug);
                        if(isset($current_term->name) && $current_term->name != '') echo "<h1>" . $current_term->name . "</h1>";

                        // // get a list of the taxonomy terms for the drop down menu
                        // $args = array(
                        //     'orderby'   => 'name',
                        //     'order'     => 'DESC'
                        // );
                        // $terms = get_terms(array($taxonomy_slug), $args);

                        // if($terms){
                        //     // we have some terms, build the dropdown
                        //     echo "<p>Filter by Category</p>";
                        //     echo "<form class='category-select-form' action='" . esc_url(home_url('/')) . "' method='get'>";
                        //     echo "<select class='category-select'>";
                        //     foreach($terms as $term){
                        //         // loop each taxonomy term and find the current one, mark it as selected
                        //         $selected = '';
                        //         if($current_term->slug == $term->slug) $selected = 'selected="selected "';
                        //         echo "<option value='/" . $taxonomy_slug . "/" . $term->slug . "/' " . $selected . ">" . $term->slug . " - " . $current_term->slug . "</option>";
                        //     }
                        //     echo "</select>";
                        //     echo "</form>";
                        // }

                        if(have_posts()) :
                            // the taxonomy has posts

                            echo "<ul class='small-block-grid-1 medium-block-grid-2'>";

                            while(have_posts()) : the_post();
                                //loop each post and display the data
                                echo "<li>";
                                // get the data
                                $date = mysql2date('F j, Y', $post->post_date);
                                $post_url = get_the_permalink();
                                $title = get_the_title();
                                $excerpt = get_the_excerpt();
                                //present the data
                                if(isset($date) && $date != '') echo "<p class='date'>$date</p>";
                                if(isset($title) && $title != '') echo "<h2><a href='$post_url'>$title</a></h2>";
                                if(isset($excerpt) && $excerpt != '') echo wpautop($excerpt);
                                echo "</li>";
                            endwhile;

                            echo "</ul>";

                        endif; // have_posts()

                    ?>
                </div>

                <div class="small-12 medium-4 columns">
                    <?php get_template_part('templates-sidebar/sidebar-buyers-sellers-secondary'); ?>
                </div>

            </div>

        </div>

        <div class="small-12 medium-3 columns">
            <?php get_template_part('templates-sidebar/sidebar-buyers-sellers-primary'); ?>
        </div>

    </section>

(-- taxonomy.php --)

<?php get_footer(); ?>
