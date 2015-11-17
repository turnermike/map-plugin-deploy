<!doctype html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php wp_title(''); ?></title>
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="msapplication-TileColor" content="#f01d4f">
        <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
        <?php
            //prep open graph data
            setup_postdata($post);
            if(function_exists('get_the_title')){ $title = get_the_title(); }
            if(function_exists('get_the_content')){ $content = wp_strip_all_tags(get_the_content()); }
            if(function_exists('get_the_permalink')){ $url = get_the_permalink(); }
            if(function_exists('has_post_thumbnail')){
                if(has_post_thumbnail()){
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'original' );
                }
            }
            if(isset($title)){ echo "<meta property='og:title' content='$title'/>"; }
            if(isset($content)){ echo "<meta property='og:description' content='$content'/>"; }
            if(isset($thumb)){ echo "<meta property='og:image' content='$thumb[0]'/>"; }
            if(isset($url)){ echo "<meta property='url' content='$url' />"; }
            wp_reset_postdata();
        ?>
        <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon.png">
        <!--[if IE]>
            <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon.ico">
        <![endif]-->
        <!-- scripts/styles enqueued via library/bones.php -->
        <?php wp_head(); ?>

	</head>

	<body <?php page_bodyclass(); ?> itemscope itemtype="http://schema.org/WebPage">

		<div id="container">

			<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

				<div id="inner-header" class="wrap cf">

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<p id="logo" class="h1" itemscope itemtype="http://schema.org/Organization"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p>

					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>


					<nav role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
						<?php
                            wp_nav_menu(array(
                                'container' => false,                           // remove nav container
                                'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                                'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
                                'menu_class' => 'nav top-nav cf',               // adding custom nav class
                                'theme_location' => 'primary',                  // where it's located in the theme
                                'before' => '',                                 // before the menu
                                'after' => '',                                  // after the menu
                                'link_before' => '',                            // before each link
                                'link_after' => '',                             // after each link
                            ));
                        ?>

					</nav>

				</div>

			</header>
