<?php
/**
 * Renders the designed HTML pages with the site owner's Customizer details.
 *
 * @package Dubai_Real_Estate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Capture the output of a hook.
 */
function dre_capture( $callback ) {
	ob_start();
	call_user_func( $callback );
	return ob_get_clean();
}

/**
 * Builds the logo markup (custom logo image or the default sun mark + name).
 */
function dre_logo_inner() {
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$src = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $src ) {
			return '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( dre_get( 'dre_brand_legal' ) ) . '" style="height:40px;width:auto;max-width:200px;object-fit:contain">';
		}
	}
	return null;
}

function dre_social_column() {
	$labels = array(
		'dre_instagram' => 'Instagram',
		'dre_facebook'  => 'Facebook',
		'dre_linkedin'  => 'LinkedIn',
		'dre_youtube'   => 'YouTube',
		'dre_tiktok'    => 'TikTok',
		'dre_x'         => 'X',
	);
	$items  = '';
	foreach ( $labels as $key => $label ) {
		$url = dre_get( $key );
		if ( $url ) {
			$items .= '<li><a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . esc_html( $label ) . '</a></li>';
		}
	}
	return $items ? '<div><h4>' . esc_html__( 'Follow', 'dubai-real-estate' ) . '</h4><ul>' . $items . '</ul></div>' : '';
}


function dre_menu_markup( $location, $fallback_items, $class = '' ) {
	if ( has_nav_menu( $location ) ) {
		$menu = wp_nav_menu( array( 'theme_location' => $location, 'container' => false, 'menu_class' => $class, 'echo' => false, 'fallback_cb' => false, 'depth' => 1 ) );
			return $menu;
	}
	$items = '';
	foreach ( $fallback_items as $label => $href ) { $tab = in_array($href,array('#buy','#sell','#rent'),true) ? ' data-tab="' . esc_attr(ltrim($href,'#')) . '"' : ''; $items .= '<li><a href="' . esc_attr( $href ) . '"' . $tab . '>' . esc_html( $label ) . '</a></li>'; }
	return '<ul class="' . esc_attr( $class ) . '">' . $items . '</ul>';
}

function dre_primary_menu() {
	$home = home_url( '/' );
	$fallback = array(
		dre_get('dre_nav_about') => '#about', dre_get('dre_nav_services') => '#services',
		dre_get('dre_nav_launches') => $home . 'latest-launches/', dre_get('dre_nav_areas') => '#area-guide',
		dre_get('dre_nav_visa') => $home . 'golden-visa/', dre_get('dre_nav_careers') => $home . 'careers/',
	);
	return dre_menu_markup( 'primary', $fallback, 'menu' );
}

function dre_footer_menu( $location ) {
	$fallback = 'footer_services' === $location
		? array( 'Buy'=>'#buy', 'Sell'=>'#sell', 'Rent'=>'#rent', dre_get('dre_nav_developers')=>'#developers' )
		: array( dre_get('dre_nav_about')=>'#about', dre_get('dre_nav_areas')=>'#area-guide', 'Fees'=>'#fees', 'FAQ'=>'#faq' );
	return dre_menu_markup( $location, $fallback );
}

/**
 * Load an HTML page and personalise it.
 *
 * @param string $file    Absolute path.
 * @param bool   $is_area Whether it's a community guide (one level deep).
 */
function dre_render_file( $file, $is_area ) {
	$html = file_get_contents( $file ); // phpcs:ignore WordPress.WP_Filesystem
	$home = trailingslashit( home_url() );
	$site = DRE_URI . '/site/';
	$host = wp_parse_url( home_url(), PHP_URL_HOST );

	$wa    = preg_replace( '/\D/', '', dre_get( 'dre_whatsapp' ) );
	$phone = dre_get( 'dre_phone' );
	$tel   = '+' . ltrim( preg_replace( '/[^\d]/', '', $phone ), '+' );
	$e     = function ( $v ) {
		return esc_html( $v );
	};

	// Always render two editable headline lines, preserving the default blue italic word.
	$l1 = trim( dre_get( 'dre_hero_line1' ) );
	$l2 = trim( dre_get( 'dre_hero_line2' ) );
	$line2 = 'thoughtfully advised' === $l2 ? '<em>thoughtfully</em> advised' : $e( $l2 );
	$h1 = '<h1 aria-label="' . esc_attr( $l1 . ' ' . $l2 ) . '"><span class="line" aria-hidden="true"><span style="--i:0">' . $e( $l1 ) . '</span></span><span class="line" aria-hidden="true"><span style="--i:1">' . $line2 . '</span></span></h1>';
	$html = preg_replace( '#<h1 aria-label="Dubai property, thoughtfully advised">.*?</h1>#s', $h1, $html, 1 );
	$license_line = $e( dre_get( 'dre_hero_eyebrow' ) ) . ' | Licence ' . $e( dre_get( 'dre_ded' ) ) . ' | ORN ' . $e( dre_get( 'dre_orn' ) );
	$html = preg_replace( '#(<p class="hx-eyebrow">).*?(</p>)#s', '$1' . $license_line . '$2', $html, 1 );
	$html = str_replace( 'We guide buyers, sellers, landlords, investors and tenants through every step, with clear numbers and honest advice.', $e( dre_get( 'dre_hero_sub' ) ), $html );
	$html = preg_replace_callback( '#(<section class="hx-quote".*?<blockquote>).*?(</blockquote>)#s', function( $m ) { return $m[1] . esc_html( dre_get( 'dre_hero_quote' ) ) . $m[2]; }, $html, 1 );
	$html = str_replace( 'The Solara Bay Team</p>', $e( dre_get( 'dre_hero_quote_by' ) ) . '</p>', $html );
	$hero_image_id = absint( dre_get( 'dre_hero_image' ) );
	if ( $hero_image_id ) { $hero_image = wp_get_attachment_image_url( $hero_image_id, 'full' ); if ( $hero_image ) { $html = preg_replace( '#src="[^"]*images/hero-panel.jpg"#', 'src="' . esc_url( $hero_image ) . '"', $html, 1 ); } }


	// Editable home page section headings and introductions.
	$html = strtr( $html, array(
		'How can we help you?' => $e(dre_get('dre_services_title')),
		
		"Dubai's top communities, explained." => $e(dre_get('dre_areas_title')),
		"Where to buy, rent or invest, from waterfront towers to family villa communities. Browse by lifestyle, or open any community for a full guide to living and investing there." => $e(dre_get('dre_areas_intro')),
		'New launches from our developer partners.' => $e(dre_get('dre_developers_title')),
		'Advice you can check, before you commit.' => $e(dre_get('dre_about_title')),
		'From first call to keys in four clear steps.' => $e(dre_get('dre_process_title')),
		'Clear fees, agreed in writing.' => $e(dre_get('dre_fees_title')),
		'Questions clients ask us.' => $e(dre_get('dre_faq_title')),
		"Tell us what you're looking for. We'll do the searching." => $e(dre_get('dre_contact_title')),
		'Talk to an advisor.' => $e(dre_get('dre_advisor_title')),
	) );

	$html = preg_replace_callback( '#(<div class="split-head"><h2.*?</h2><p class="lead"[^>]*>).*?(</p>)#s', function( $m ) { return $m[1] . esc_html( dre_get( 'dre_services_intro' ) ) . $m[2]; }, $html, 1 );
	$html = str_replace( 'Solara Bay Real Estate is a licensed real estate company based in Dubai. We help people buy, sell and invest in property across the UAE, and we help landlords and tenants find the right match. We explain every cost up front and give honest advice, even when the answer is to wait.', $e(dre_get('dre_about_intro')), $html );

	// WordPress menus and editable navigation labels.
	$html = preg_replace( '#<nav aria-label="Main"><ul class="menu">.*?</ul></nav>#s', '<nav aria-label="Main">' . dre_primary_menu() . '</nav>', $html, 1 );
	$drawer = preg_replace('#^<ul[^>]*>|</ul>$#','',dre_primary_menu());
	$drawer .= '<a href="#contact" class="btn btn-sun">' . $e(dre_get('dre_nav_contact')) . '</a>';
	$html = preg_replace( '#<div class="drawer" id="drawer".*?</div>#s', '<div class="drawer" id="drawer" aria-hidden="true">' . $drawer . '</div>', $html, 1 );
	$html = str_replace( 'Book a free consultation', $e( dre_get('dre_hero_cta') ), $html );
	$html = str_replace( 'class="nav-contact">Contact</a>', 'class="nav-contact">' . $e( dre_get('dre_nav_contact') ) . '</a>', $html );

	$html = preg_replace_callback( '#(<a[^>]*class="hx-btn hx-btn-line js-wa"[^>]*>.*?</svg>)Chat on WhatsApp(</a>)#s', function( $m ) { return $m[1] . esc_html( dre_get( 'dre_hero_whatsapp' ) ) . $m[2]; }, $html, 1 );

	// Logo.
	$logo = dre_logo_inner();
	if ( $logo ) {
		$html = preg_replace( '#(<a [^>]*class="logo"[^>]*>)<svg viewBox="0 0 40 40"[^>]*>.*?</svg><span><b>.*?</small></span>#s', '$1' . $logo, $html );
	}
	$html = str_replace( '<small>REAL ESTATE &middot; DUBAI</small>', '<small>' . $e( dre_get( 'dre_brand_tag' ) ) . '</small>', $html );
	$html = str_replace( 'A licensed Dubai brokerage helping investors, homebuyers and landlords buy, sell, let and manage property with clear advice and transparent fees.', $e( dre_get('dre_footer_about') ), $html );
	$html = str_replace( 'Monday to Saturday, 9:00 to 19:00', $e( dre_get('dre_hours') ), $html );
	$html = preg_replace( '#<div><h4>Services</h4><ul>.*?</ul></div>#s', '<div><h4>' . $e(dre_get('dre_footer_services_title')) . '</h4>' . dre_footer_menu('footer_services') . '</div>', $html, 1 );
	$html = preg_replace( '#<div><h4>Company</h4><ul>.*?</ul></div>#s', '<div><h4>' . $e(dre_get('dre_footer_company_title')) . '</h4>' . dre_footer_menu('footer_company') . '</div>', $html, 1 );

	// Contact, legal and brand details. Order matters: longest first.
	$html = strtr(
		$html,
		array(
			'info@solarabay.ae'               => $e( dre_get( 'dre_email' ) ),
			'+971 56 181 5038'                => $e( $phone ),
			'+971561815038'                   => esc_attr( $tel ),
			'971561815038'                    => esc_attr( $wa ),
			'Licence 1656071' => 'Licence ' . $e( dre_get( 'dre_ded' ) ),
			'License 1656071' => 'License ' . $e( dre_get( 'dre_ded' ) ),
			'ORN 64706' => 'ORN ' . $e( dre_get( 'dre_orn' ) ),
			'All rights reserved.'              => $e( dre_get( 'dre_copyright' ) ),
			'DED licence [000000]'            => 'DED licence ' . $e( dre_get( 'dre_ded' ) ),
			'ORN [00000]'                     => 'ORN ' . $e( dre_get( 'dre_orn' ) ),
			'Solara Bay Real Estate'          => $e( dre_get( 'dre_brand_legal' ) ),
			'Solara%20Bay'                    => rawurlencode( dre_get( 'dre_brand_name' ) ),
			'Solara Bay'                      => $e( dre_get( 'dre_brand_name' ) ),
			'https://solarabay.ae'            => untrailingslashit( $home ),
			'solarabay.ae'                    => $e( $host ),
		)
	);


	$html = str_replace( 'Information on this website is general guidance and may change. Please confirm details with us before making a decision.', $e(dre_get('dre_footer_disclaimer')), $html );

	// Social links.
	$html = str_replace( '<!-- Add a "Follow" column here once social accounts are live -->', dre_social_column(), $html );

	// Links and asset paths.
	$privacy = get_privacy_policy_url();
	$privacy = $privacy ? $privacy : $home;
	if ( $is_area ) {
		$html = str_replace(
			array( 'href="../index.html', 'href="../privacy.html"', 'src="../images/', 'href="../images/', 'src="../assets/', 'href="../assets/' ),
			array( 'href="' . $home, 'href="' . esc_url( $privacy ) . '"', 'src="' . $site . 'images/', 'href="' . $site . 'images/', 'src="' . $site . 'assets/', 'href="' . $site . 'assets/' ),
			$html
		);
		$html = preg_replace( '#href="([a-z0-9-]+)\.html"#', 'href="' . $home . 'area/$1/"', $html );
	} else {
		foreach ( array( 'latest-launches', 'golden-visa', 'careers' ) as $pslug ) { $pg = get_page_by_path( $pslug ); $html = str_replace( 'href="' . $pslug . '.html"', 'href="' . esc_url( $pg ? get_permalink( $pg ) : $home . $pslug . '/' ) . '"', $html ); }
		$html = str_replace(
			array( 'href="index.html', 'href="privacy.html"', 'src="images/', 'href="images/', "url('images/", 'url(images/', 'src="assets/', 'href="assets/' ),
			array( 'href="' . $home, 'href="' . esc_url( $privacy ) . '"', 'src="' . $site . 'images/', 'href="' . $site . 'images/', "url('" . $site . 'images/', 'url(' . $site . 'images/', 'src="' . $site . 'assets/', 'href="' . $site . 'assets/' ),
			$html
		);
		$html = preg_replace( '#href="area/([a-z0-9-]+)\.html"#', 'href="' . $home . 'area/$1/"', $html );
		$html = str_replace( 'area/${a.slug}.html', $home . 'area/${a.slug}/', $html );
		$html = str_replace( '"images/', '"' . $site . 'images/', $html );
	}
	// Partner logos.
	$html = preg_replace( '#/__l5e/assets-v1/[a-f0-9-]+/([a-z0-9.-]+)#', $site . 'assets/partners/$1', $html );

	// Colours.
	$css  = '<style id="dre-colors">:root{';
	$css .= '--ink:' . sanitize_hex_color( dre_get( 'dre_color_ink' ) ) . ';--on-sun:' . sanitize_hex_color( dre_get( 'dre_color_ink' ) ) . ';';
	$css .= '--sun:' . sanitize_hex_color( dre_get( 'dre_color_accent' ) ) . ';';
	$css .= '--sun-text:' . sanitize_hex_color( dre_get( 'dre_color_link' ) ) . ';--focus:' . sanitize_hex_color( dre_get( 'dre_color_link' ) ) . ';--hx-blue:' . sanitize_hex_color( dre_get( 'dre_color_link' ) ) . ';--cta:' . sanitize_hex_color( dre_get( 'dre_color_link' ) ) . ';';
	$css .= '--stone:' . sanitize_hex_color( dre_get( 'dre_color_wash' ) ) . ';}</style>';

	// Site icon.
	$icon = get_site_icon_url( 64 );
	if ( $icon ) {
		$html = preg_replace( '#<link rel="icon"[^>]*>#', '', $html );
		$css .= '<link rel="icon" href="' . esc_url( $icon ) . '">';
	}

	// WordPress hooks (plugins, analytics, admin bar).
	remove_action( 'wp_head', '_wp_render_title_tag', 1 );
	remove_action( 'wp_enqueue_scripts', 'dre_basic_assets' );
	$head   = dre_capture( 'wp_head' );
	$footer = dre_capture( 'wp_footer' );
	$html   = preg_replace( '#</head>#i', $css . $head . '</head>', $html, 1 );
	$pos    = strripos( $html, '</body>' );
	if ( false !== $pos ) {
		$html = substr_replace( $html, $footer . '</body>', $pos, 7 );
	}
	return $html;
}
