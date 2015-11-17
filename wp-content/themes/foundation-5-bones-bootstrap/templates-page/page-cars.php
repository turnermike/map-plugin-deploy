<?php
 /*
  * Template Name: Cars Page
  *
  *
  */
?>
<?php get_header(); ?>

    <div class="row">
      <div class="large-12 columns">
        <h1><?php the_title(); ?></h1>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
        <div class="panel">
            <?php the_content(); ?>

            <?php
                // get all cars
                $args = array(
                    'post_type'             => 'car',
                    'post_status'           => 'publish',
                    'posts_per_page'        => -1,
                    'orderby'               => 'post_date',
                    'order'                 => 'DESC'
                );
                $results = new WP_Query($args);

                if($results->have_posts()){

                    echo '<ul>';

                    while($results->have_posts()) : $results->the_post();

                        echo '<li>';
                        the_title();
                        the_excerpt();
                        echo '</li>';

                    endwhile;

                    echo '</ul>';

                }
            ?>
            <div class="row">
                <div class="large-4 medium-4 columns">
                <p><a href="http://foundation.zurb.com/docs">Foundation Documentation</a><br />Everything you need to know about using the framework.</p>
            </div>
                <div class="large-4 medium-4 columns">
                    <p><a href="http://github.com/zurb/foundation">Foundation on Github</a><br />Latest code, issue reports, feature requests and more.</p>
                </div>
                <div class="large-4 medium-4 columns">
                    <p><a href="http://twitter.com/foundationzurb">@foundationzurb</a><br />Ping us on Twitter if you have questions. If you build something with this we'd love to see it (and send you a totally boss sticker).</p>
                </div>
            </div>
        </div>
      </div>
    </div>

<?php get_footer(); ?>

(page-cars.php)
