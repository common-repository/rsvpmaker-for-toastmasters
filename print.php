<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
</head>
<style>
    main#main {
        width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<body>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<h3><?php echo get_bloginfo('name'); ?></h3>
			<?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php endwhile; // End of the loop. ?>
		</main><!-- #main -->
	</div><!-- #primary -->
</body>
</html>