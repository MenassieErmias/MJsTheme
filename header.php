<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package meneth
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site container">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'meneth' ); ?></a>

	<header id="masthead" class="site-header">
	<nav id="menu" class="navbar navbar-expand-md navbar-light" role="navigation">
		<div class="site-branding navbar-brand">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$meneth_description = get_bloginfo( 'description', 'display' );
			if ( $meneth_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $meneth_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" 
		data-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<?php
		wp_nav_menu([
			'menu'	=>	'primary',
			'theme_location'	=>	'primary',
			'container'			=>	'div',
			'container_id'		=>	'bs4navbar',
			'container_class'	=>	'collapse navbar-collapse',
			'menu_id'			=>	'main-menu',
			'menu_class'		=>	'navbar-nav ml-auto',
			'depth'				=>	2,
			'fallback_cb'		=>	'bs4navwalker::fallback',
			'walker'			=>	new bs4navwalker()
		]);
		?>
		</nav>

		<?php
$slides = array(); 
$args = array( 'tag' => 'slide', 'nopaging'=>true, 'posts_per_page'=>5 );
$slider_query = new WP_Query( $args );
if ( $slider_query->have_posts() ) {
    while ( $slider_query->have_posts() ) {
        $slider_query->the_post();
        if(has_post_thumbnail()){
            $temp = array();
            $thumb_id = get_post_thumbnail_id();
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
            $thumb_url = $thumb_url_array[0];
            $temp['title'] = get_the_title();
            $temp['excerpt'] = get_the_excerpt();
            $temp['image'] = $thumb_url;
            $slides[] = $temp;
        }
    }
} 
wp_reset_postdata();
?>

<?php if(count($slides) > 0) { ?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    
    <ol class="carousel-indicators">
        <?php for($i=0;$i<count($slides);$i++) { ?>
        <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i ?>" <?php if($i==0) { ?>class="active"<?php } ?>></li>
        <?php } ?>
    </ol>

    <div class="carousel-inner" role="listbox">
        <?php $i=0; foreach($slides as $slide) { extract($slide); ?>
        <div class="carousel-item <?php if($i == 0) { ?>active<?php } ?>">
            <img src="<?php echo $image ?>" alt="<?php echo esc_attr($title); ?>">
            <div class="carousel-caption"><h3><?php echo $title; ?></h3><p><?php echo $excerpt; ?></p></div>
        </div>
        <?php $i++; } ?>
    </div>

    <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
    <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>

</div>

<?php } ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content row">
