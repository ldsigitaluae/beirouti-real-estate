<?php
/**
 * Fallback template for posts, pages and archives.
 * The home page and community guides are served from functions.php.
 *
 * @package Dubai_Real_Estate
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'dre-basic' ); ?>>
<?php wp_body_open(); ?>
<header>
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( has_custom_logo() ) {
			echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full' );
		} else {
			echo esc_html( dre_get( 'dre_brand_name' ) );
		}
		?>
	</a>
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'depth' => 1, 'fallback_cb' => false ) ); ?>
	<a class="call" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', dre_get( 'dre_phone' ) ) ); ?>"><?php echo esc_html( dre_get( 'dre_phone' ) ); ?></a>
</header>
<main>
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class(); ?>>
				<?php if ( is_singular() ) : ?>
					<h1><?php the_title(); ?></h1>
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large', array( 'class' => 'dre-cover' ) ); } ?>
					<?php the_content(); ?>
				<?php else : ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<article><h1><?php esc_html_e( 'Page not found', 'dubai-real-estate' ); ?></h1><p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return to the home page', 'dubai-real-estate' ); ?></a></p></article>
	<?php endif; ?>
</main>
<footer>
	<?php wp_nav_menu( array( 'theme_location' => 'footer_company', 'container' => 'nav', 'depth' => 1, 'fallback_cb' => false ) ); ?>
	&copy; <?php echo esc_html( gmdate( 'Y' ) . ' ' . dre_get( 'dre_brand_legal' ) ); ?> &middot; <?php echo esc_html( dre_get( 'dre_email' ) ); ?>
<p><?php echo esc_html( "License " . dre_get("dre_ded") . ". ORN " . dre_get("dre_orn") . ". " . dre_get("dre_copyright") ); ?></p>
<p class="footer-disclaimer"><?php echo esc_html( dre_get("dre_footer_disclaimer") ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
