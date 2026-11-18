<?php
/**
 * Demo Import: a permanent dashboard page to import, re-import or remove demo content.
 * Runs in small steps so it can be retried at any time if a step fails.
 *
 * @package Dubai_Real_Estate
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------------------------------------------------------------------------
 * Demo data
 * ------------------------------------------------------------------------- */

function dre_demo_area_slugs() {
	$slugs = array();
	foreach ( (array) glob( DRE_DIR . '/site/area/*.html' ) as $file ) { $slugs[] = basename( $file, '.html' ); }
	sort( $slugs );
	return $slugs;
}

function dre_demo_area_name( $slug ) {
	$name = ucwords( str_replace( '-', ' ', $slug ) );
	return str_replace( array( ' Jbr', ' Jlt', ' Jvc', ' And ' ), array( ' (JBR)', ' (JLT)', ' (JVC)', ' and ' ), $name );
}

function dre_demo_media_files() {
	$files = array( 'images/logo.png', 'images/hero-panel.jpg', 'images/hero.jpg', 'images/advisor.jpg', 'images/downtown.jpg', 'images/marina.jpg', 'images/palm.jpg', 'images/business-bay.jpg', 'images/dubai-hills.jpg' );
	foreach ( dre_demo_plan()['areas'] as $slug ) {
		if ( file_exists( DRE_DIR . '/site/images/areas/' . $slug . '.jpg' ) ) { $files[] = 'images/areas/' . $slug . '.jpg'; }
	}
	return $files;
}

function dre_demo_contact_block() {
	$phone = dre_get( 'dre_phone' );
	$wa    = preg_replace( '/\D/', '', dre_get( 'dre_whatsapp' ) );
	return '<h2>Talk to us</h2><p>Call <a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a> or message us on <a href="https://wa.me/' . esc_attr( $wa ) . '">WhatsApp</a>. Advice is free and there is no pressure.</p>';
}

function dre_demo_list( $items ) { return '<ul><li>' . implode( '</li><li>', $items ) . '</li></ul>'; }

function dre_demo_pages() {
	$c = dre_demo_contact_block();
	return array(
		'home' => array( 'Home', 'images/hero-panel.jpg', '' ),
		'buy' => array( 'Buy property in Dubai', 'images/downtown.jpg',
			'<p>We help you buy the right home or investment in Dubai. We show you real sale prices, service charges and rents before you decide.</p><h2>How we help</h2>' . dre_demo_list( array( 'We listen to your budget and goals', 'We send a short list of homes that fit', 'We check the title deed and the seller', 'We help you agree a fair price', 'We guide you to transfer at the Dubai Land Department' ) ) . '<h2>Costs to plan for</h2>' . dre_demo_list( array( 'Dubai Land Department fee: 4% of the price', 'Agency fee: usually 2%', 'Trustee office fee and title deed fee' ) ) . $c ),
		'latest-launches' => array( 'Latest launches', 'images/areas/dubai-creek-harbour.jpg',
			'<p>Off plan means you buy a home before it is built. You pay in parts while it is being built, often with a small first payment.</p><h2>Why people buy off plan</h2>' . dre_demo_list( array( 'Easy payment plans', 'New buildings with modern design', 'Prices are often lower at launch' ) ) . '<h2>How we keep you safe</h2>' . dre_demo_list( array( 'We only work with developers registered with RERA', 'Your money goes into an escrow account by law', 'We check the project is registered with the Dubai Land Department (Oqood)', 'We read the payment plan and handover date with you' ) ) . '<p>Ask us for the latest launches from Emaar, DAMAC, Sobha, Nakheel, Meraas, Ellington, Binghatti and Danube.</p>' . $c ),
		'services' => array( 'Our services', 'images/business-bay.jpg',
			'' . dre_demo_list( array( 'Buy and sell: ready homes and investments', 'Off plan: new launches from trusted developers', 'Leasing: homes to rent and tenants for landlords', 'Property management for owners who live abroad', 'Golden Visa and residency advice', 'Mortgage help with UAE banks' ) ) . $c ),
		'ready-properties' => array( 'Ready properties', 'images/dubai-hills.jpg',
			'<p>Ready homes are finished and you can move in or rent them out right away.</p>' . dre_demo_list( array( 'See the home before you pay', 'Earn rent from the first month', 'Know the real service charges' ) ) . $c ),
		'rent' => array( 'Rent a home in Dubai', 'images/marina.jpg',
			'<p>Looking for a flat or villa to rent? Tell us your budget, area and move-in date. We will find homes that fit.</p><h2>What you need</h2>' . dre_demo_list( array( 'Passport and visa copy', 'Emirates ID', 'Security deposit (usually 5% of yearly rent)', 'Rent cheques, often 1 to 4 per year' ) ) . '<p>Landlords get vetted tenants, and we collect and follow up on rent for them. We help tenants and landlords with Ejari.</p>' . $c ),
		'sell' => array( 'Sell or list your property', 'images/business-bay.jpg',
			'<p>Want to sell or rent out your property? We give you an honest price based on real recent sales.</p>' . dre_demo_list( array( 'Free valuation', 'Professional photos and listing', 'Form A and Trakheesi permit handled for you', 'Only bring you buyers who are ready to proceed' ) ) . $c ),
		'commercial' => array( 'Commercial property', 'images/areas/business-bay.jpg',
			'<p>We help with offices, shops and warehouses for sale or rent across Dubai.</p>' . dre_demo_list( array( 'Offices in Business Bay, JLT and Downtown', 'Shops and showrooms', 'Warehouses near Dubai South and Al Quoz' ) ) . $c ),
		'area-guides' => array( 'Area guides', 'images/palm.jpg', '[dre_area_guides]' ),
		'developers' => array( 'Developers', 'images/areas/emaar-beachfront.jpg',
			'<p>We work with Dubai\'s trusted developers. We help you compare their projects, quality and payment plans.</p>' . dre_demo_list( array( 'Emaar', 'DAMAC', 'Sobha Realty', 'Nakheel', 'Meraas', 'Ellington', 'Binghatti', 'Danube' ) ) . $c ),
		'property-management' => array( 'Property management', 'images/areas/jumeirah-lake-towers-jlt.jpg',
			'<p>Live abroad or just busy? We look after your property for you.</p>' . dre_demo_list( array( 'Find and check tenants', 'Collect rent', 'Fix problems quickly', 'Send you a clear monthly report' ) ) . $c ),
		'mortgage' => array( 'Mortgage help', 'images/advisor.jpg',
			'<p>We connect you with UAE banks and mortgage advisors so you can compare offers.</p>' . dre_demo_list( array( 'UAE residents can usually borrow up to 80% for a first home under AED 5 million', 'Non-residents can often borrow up to 50 to 60%', 'Get pre-approval before you make an offer' ) ) . $c ),
		'golden-visa' => array( 'Golden Visa', 'images/areas/palm-jumeirah.jpg',
			'<p>If you buy property worth AED 2 million or more, you may get a 10-year UAE Golden Visa.</p>' . dre_demo_list( array( 'Live in the UAE with your family', 'No local sponsor needed', 'We guide you through the steps' ) ) . '<p>Rules can change. We always check the latest rules with the authorities.</p>' . $c ),
		'about-us' => array( 'About us', 'images/advisor.jpg',
			'<p>Solara Bay Real Estate is a licensed real estate company based in Dubai. We help people buy, sell and invest in property across the UAE, and we help landlords and tenants find the right match. We explain every cost up front and give honest advice, even when the answer is to wait.</p><h2>What we believe</h2>' . dre_demo_list( array( 'Tell the truth, even when it is not what you want to hear', 'Show real numbers, not brochure numbers', 'Stay with you after the deal' ) ) . $c ),
		'fees' => array( 'Our fees', 'images/hero.jpg',
			'<p>We keep our fees simple and clear.</p>' . dre_demo_list( array( 'Buying: 2% agency fee', 'Renting: 5% of yearly rent', 'Selling: agreed with you before we start', 'Property management: a small monthly percentage of rent' ) ) . $c ),
		'faq' => array( 'Frequently asked questions', 'images/marina.jpg',
			'<h3>Can I buy property in Dubai as a foreigner?</h3><p>Non-residents can buy freehold property in designated areas, which include most major communities. We\'ll confirm this for every property you consider.</p><h3>Can I buy without travelling to Dubai?</h3><p>Yes. We offer live video viewings and digital signing, and can complete the transfer through a power of attorney. You only need to visit when you want to.</p><h3>Does buying property give me a UAE visa?</h3><p>Property worth AED 2 million or more can qualify you for the 10-year Golden Visa, and lower values can qualify for other residence visas. Rules change, so we\'ll confirm current requirements for your case.</p><h3>What will I pay on top of the property price?</h3><p>Budget for the 4% DLD transfer fee, trustee and registration charges, our commission plus VAT, and mortgage fees if you\'re financing. You\'ll get a full cost sheet before you make an offer.</p><h3>Is off plan safe?</h3><p>Payments for registered off plan projects go into a regulated escrow account, released as construction progresses. The real risks are delays and market changes, so we check each developer\'s delivery record first.</p><h3>How much rental income can I expect?</h3><p>It depends on the community, the unit and how it\'s managed. We base every estimate on current signed contracts in that building, not asking rents, and show you the figures.</p><h3>How quickly can you let my property?</h3><p>Well-priced homes in popular communities often let within two to four weeks. We\'ll give you a realistic rent on our first call.</p><h3>What deposit will I pay as a tenant?</h3><p>The deposit depends on the home and the tenancy agreement. We confirm the amount, payment terms and refund conditions before you sign.</p><h3>Who arranges Ejari for tenants and landlords?</h3><p>Ejari registers the tenancy contract in Dubai. We help tenants and landlords prepare the documents and confirm who will register it and pay the charges.</p><h3>How many rent cheques can I use?</h3><p>The number of cheques is agreed with the landlord. We confirm the payment schedule, cheque dates and any effect on the rent before you sign.</p><h3>What agency fee do tenants and landlords pay?</h3><p>Tenants usually pay 5% of the yearly rent plus VAT, as shown in our fees. Landlords receive a separate quote if they choose property management.</p><h3>Can you help me buy in other emirates?</h3><p>Yes. We help clients explore property across the UAE. Ownership rules, fees and buying steps vary by emirate, so we confirm the details for each property.</p>' . $c ),
		'market-insights' => array( 'Market insights', 'images/downtown.jpg', '' ),
		'careers' => array( 'Careers', 'images/advisor.jpg',
			'<p>We are always happy to meet honest, hard-working property advisors. Send your CV to ' . esc_html( dre_get( 'dre_email' ) ) . '.</p>' ),
		'contact' => array( 'Contact us', 'images/hero-panel.jpg',
			'<p>Tell us what you are looking for. We will do the searching.</p>' . dre_demo_list( array( 'Phone: ' . esc_html( dre_get( 'dre_phone' ) ), 'WhatsApp: ' . esc_html( dre_get( 'dre_whatsapp' ) ), 'Email: ' . esc_html( dre_get( 'dre_email' ) ), 'License ' . esc_html( dre_get( 'dre_ded' ) ) . ', ORN ' . esc_html( dre_get( 'dre_orn' ) ), 'Hours: ' . esc_html( dre_get( 'dre_hours' ) ) ) ) ),
		'privacy-policy' => array( 'Privacy policy', '', '<p>We only collect the details you share with us, such as your name, phone and email. We use them to help you with your property search. We never sell your details.</p>' ),
		'terms' => array( 'Terms of use', '', '<p>The information on this website is a guide only. Prices and availability can change. Please speak to us before making any decision.</p>' ),
	);
}

function dre_demo_posts() {
	return array(
		array( 'How to buy property in Dubai: a simple guide', 'images/downtown.jpg', '<p>Buying in Dubai has a few clear steps: choose a home, sign the agreement (Form F), pay the deposit, and transfer at the Dubai Land Department. We explain each step in plain words.</p>' ),
		array( 'Off plan or ready: which is right for you?', 'images/areas/dubai-creek-harbour.jpg', '<p>Off plan gives easy payment plans. Ready homes give rent from day one. Here is how to choose.</p>' ),
		array( 'Best Dubai areas for families', 'images/dubai-hills.jpg', '<p>Dubai Hills Estate, Arabian Ranches and Mudon are popular with families for schools, parks and space.</p>' ),
	);
}

function dre_demo_menus() {
	return array(
		'primary'         => array( 'Main navigation', array( 'about-us', 'services', 'latest-launches', 'area-guides', 'golden-visa', 'careers' ) ),
		'footer_services' => array( 'Footer services', array( 'buy', 'rent', 'sell', 'latest-launches', 'property-management', 'mortgage', 'golden-visa' ) ),
		'footer_company'  => array( 'Footer company', array( 'about-us', 'developers', 'market-insights', 'fees', 'faq', 'careers', 'privacy-policy' ) ),
	);
}

/* Import plan: which pages and communities the admin picked in the preview. */
function dre_demo_plan() {
	$plan = get_option( 'dre_demo_plan' );
	if ( ! is_array( $plan ) ) { $plan = array( 'pages' => array_keys( dre_demo_pages() ), 'areas' => dre_demo_area_slugs() ); }
	$plan['pages'] = array_values( array_unique( array_merge( array( 'home' ), (array) $plan['pages'] ) ) );
	return $plan;
}

/* Area guides list shortcode. */
function dre_area_guides_shortcode() {
	$map = get_option( 'dre_demo_media', array() );
	$out = '<p>Simple guides to Dubai\'s most popular communities.</p><div class="dre-grid">';
	$areas = get_option( 'dre_demo_areas' );
	$areas = is_array( $areas ) && $areas ? $areas : dre_demo_area_slugs();
	foreach ( $areas as $slug ) {
		$img = isset( $map[ 'images/areas/' . $slug . '.jpg' ] ) ? wp_get_attachment_image_url( $map[ 'images/areas/' . $slug . '.jpg' ], 'medium_large' ) : DRE_URI . '/site/images/areas/' . $slug . '.jpg';
		$out .= '<a class="dre-card" href="' . esc_url( home_url( '/area/' . $slug . '/' ) ) . '"><img loading="lazy" src="' . esc_url( $img ) . '" alt=""><span>' . esc_html( dre_demo_area_name( $slug ) ) . '</span></a>';
	}
	return $out . '</div>';
}
add_shortcode( 'dre_area_guides', 'dre_area_guides_shortcode' );

/* ---------------------------------------------------------------------------
 * Import steps
 * ------------------------------------------------------------------------- */

function dre_demo_log( $msg ) {
	$log   = (array) get_option( 'dre_demo_log', array() );
	$log[] = gmdate( 'Y-m-d H:i' ) . '  ' . $msg;
	update_option( 'dre_demo_log', array_slice( $log, -40 ), false );
}

function dre_demo_import_media_file( $rel ) {
	$map = (array) get_option( 'dre_demo_media', array() );
	if ( ! empty( $map[ $rel ] ) && get_post( $map[ $rel ] ) ) { return (int) $map[ $rel ]; }
	$src = DRE_DIR . '/site/' . $rel;
	if ( ! file_exists( $src ) ) { return new WP_Error( 'missing', 'Missing file ' . $rel ); }
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$tmp = wp_tempnam( basename( $src ) );
	if ( ! $tmp || ! copy( $src, $tmp ) ) { return new WP_Error( 'copy', 'Could not copy ' . $rel . '. Check that the uploads folder is writable.' ); }
	$name = ( false !== strpos( $rel, 'areas/' ) ? 'area-' : 'dre-' ) . basename( $src );
	$id   = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), 0, ucwords( str_replace( array( '-', '.jpg', '.png' ), array( ' ', '', '' ), basename( $src ) ) ) );
	if ( is_wp_error( $id ) ) { @unlink( $tmp ); return $id; }
	update_post_meta( $id, '_dre_demo', 1 );
	update_post_meta( $id, '_dre_demo_file', $rel );
	$map[ $rel ] = $id;
	update_option( 'dre_demo_media', $map, false );
	return (int) $id;
}

function dre_demo_find( $key ) {
	$q = get_posts( array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'any', 'meta_key' => '_dre_demo_key', 'meta_value' => $key, 'numberposts' => 1, 'fields' => 'ids' ) );
	return $q ? (int) $q[0] : 0;
}

function dre_demo_upsert( $key, $type, $title, $content, $image, $slug = '' ) {
	$map  = (array) get_option( 'dre_demo_media', array() );
	$id   = dre_demo_find( $key );
	$args = array( 'post_title' => $title, 'post_content' => $content, 'post_status' => 'publish', 'post_type' => $type );
	if ( $slug ) { $args['post_name'] = $slug; }
	if ( $id ) { $args['ID'] = $id; $id = wp_update_post( $args, true ); } else { $id = wp_insert_post( $args, true ); }
	if ( is_wp_error( $id ) ) { return $id; }
	update_post_meta( $id, '_dre_demo', 1 );
	update_post_meta( $id, '_dre_demo_key', $key );
	if ( $image && ! empty( $map[ $image ] ) ) { set_post_thumbnail( $id, $map[ $image ] ); }
	return $id;
}

function dre_demo_run_step( $step, $offset ) {
	switch ( $step ) {
		case 'plan':
			$pages = isset( $_POST['pages'] ) ? array_map( 'sanitize_key', (array) wp_unslash( $_POST['pages'] ) ) : array();
			$areas = isset( $_POST['areas'] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_POST['areas'] ) ) : array();
			$pages = array_values( array_intersect( $pages, array_keys( dre_demo_pages() ) ) );
			$areas = array_values( array_intersect( $areas, dre_demo_area_slugs() ) );
			update_option( 'dre_demo_plan', array( 'pages' => $pages, 'areas' => $areas ), false );
			return array( 'msg' => sprintf( 'Plan saved: %d pages and %d communities.', count( $pages ) + ( in_array( 'home', $pages, true ) ? 0 : 1 ), count( $areas ) ) );

		case 'reset':
			$ids = get_posts( array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'any', 'meta_key' => '_dre_demo', 'numberposts' => -1, 'fields' => 'ids' ) );
			foreach ( $ids as $id ) { wp_delete_post( $id, true ); }
			foreach ( dre_demo_menus() as $menu ) { $m = wp_get_nav_menu_object( $menu[0] ); if ( $m ) { wp_delete_nav_menu( $m->term_id ); } }
			return array( 'msg' => sprintf( 'Removed %d old demo pages and posts.', count( $ids ) ) );

		case 'media':
			$files = dre_demo_media_files();
			$batch = array_slice( $files, $offset, 5 );
			foreach ( $batch as $rel ) {
				$r = dre_demo_import_media_file( $rel );
				if ( is_wp_error( $r ) ) { return new WP_Error( 'media', $r->get_error_message() ); }
			}
			$next = $offset + count( $batch );
			return array( 'msg' => sprintf( 'Images: %d of %d', $next, count( $files ) ), 'next' => $next < count( $files ) ? $next : null );

		case 'pages':
			$chosen = dre_demo_plan()['pages'];
			foreach ( dre_demo_pages() as $slug => $p ) {
				if ( ! in_array( $slug, $chosen, true ) ) { continue; }
				$r = dre_demo_upsert( 'page-' . $slug, 'page', $p[0], $p[2], $p[1], $slug );
				if ( is_wp_error( $r ) ) { return $r; }
			}
			foreach ( dre_demo_posts() as $i => $p ) {
				$r = dre_demo_upsert( 'post-' . $i, 'post', $p[0], $p[2], $p[1] );
				if ( is_wp_error( $r ) ) { return $r; }
			}
			return array( 'msg' => sprintf( 'Created %d pages and %d articles.', count( $chosen ), count( dre_demo_posts() ) ) );

		case 'menus':
			$locations = (array) get_theme_mod( 'nav_menu_locations', array() );
			foreach ( dre_demo_menus() as $loc => $menu ) {
				$m = wp_get_nav_menu_object( $menu[0] );
				if ( $m ) { wp_delete_nav_menu( $m->term_id ); }
				$menu_id = wp_create_nav_menu( $menu[0] );
				if ( is_wp_error( $menu_id ) ) { return $menu_id; }
				foreach ( $menu[1] as $slug ) {
					$pid = dre_demo_find( 'page-' . $slug );
					$short = array( 'buy' => 'Buy', 'rent' => 'Rent', 'sell' => 'Sell', 'latest-launches' => 'Latest Launches', 'area-guides' => 'Area Guide', 'about-us' => 'About Us', 'services' => 'Services', 'golden-visa' => 'Golden Visa', 'careers' => 'Careers', 'contact' => 'Contact', 'property-management' => 'Property management', 'mortgage' => 'Mortgage', 'faq' => 'FAQ', 'fees' => 'Fees' );
					if ( $pid ) { wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => isset( $short[ $slug ] ) ? $short[ $slug ] : '', 'menu-item-object-id' => $pid, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) ); }
				}
				$locations[ $loc ] = $menu_id;
			}
			set_theme_mod( 'nav_menu_locations', $locations );
			return array( 'msg' => 'Main menu and footer menus are set.' );

		case 'settings':
			$map = (array) get_option( 'dre_demo_media', array() );
			if ( ! empty( $map['images/logo.png'] ) ) { set_theme_mod( 'custom_logo', $map['images/logo.png'] ); }
			if ( ! empty( $map['images/hero-panel.jpg'] ) ) { set_theme_mod( 'dre_hero_image', $map['images/hero-panel.jpg'] ); }
			$home = dre_demo_find( 'page-home' );
			$blog = dre_demo_find( 'page-market-insights' );
			if ( $home ) { update_option( 'show_on_front', 'page' ); update_option( 'page_on_front', $home ); }
			if ( $blog ) { update_option( 'page_for_posts', $blog ); }
			if ( ! get_option( 'permalink_structure' ) ) { update_option( 'permalink_structure', '/%postname%/' ); }
			dre_rewrites();
			flush_rewrite_rules();
			update_option( 'dre_demo_areas', dre_demo_plan()['areas'] );
			update_option( 'dre_demo_imported', gmdate( 'c' ) );
			return array( 'msg' => 'Logo, hero photo, home page and links are set. Import finished.' );

		case 'remove':
			dre_demo_run_step( 'reset', 0 );
			foreach ( (array) get_option( 'dre_demo_media', array() ) as $id ) { wp_delete_attachment( $id, true ); }
			delete_option( 'dre_demo_media' );
			delete_option( 'dre_demo_imported' );
			delete_option( 'dre_demo_areas' );
			if ( get_option( 'show_on_front' ) === 'page' ) { update_option( 'show_on_front', 'posts' ); }
			remove_theme_mod( 'custom_logo' );
			remove_theme_mod( 'dre_hero_image' );
			return array( 'msg' => 'All demo pages, menus and images were removed.' );
	}
	return new WP_Error( 'step', 'Unknown step.' );
}

function dre_demo_ajax() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_send_json_error( array( 'msg' => 'You do not have permission.' ), 403 ); }
	check_ajax_referer( 'dre_demo', 'nonce' );
	@set_time_limit( 300 );
	$step   = isset( $_POST['step'] ) ? sanitize_key( wp_unslash( $_POST['step'] ) ) : '';
	$offset = isset( $_POST['offset'] ) ? absint( $_POST['offset'] ) : 0;
	$r      = dre_demo_run_step( $step, $offset );
	if ( is_wp_error( $r ) ) { dre_demo_log( 'FAILED ' . $step . ': ' . $r->get_error_message() ); wp_send_json_error( array( 'msg' => $r->get_error_message() ) ); }
	if ( empty( $r['next'] ) ) { dre_demo_log( $r['msg'] ); }
	wp_send_json_success( $r );
}
add_action( 'wp_ajax_dre_demo_step', 'dre_demo_ajax' );

/* ---------------------------------------------------------------------------
 * Admin screen: Dashboard menu "Demo Import" + Appearance > Demo Import
 * ------------------------------------------------------------------------- */

function dre_demo_admin_menu() {
	add_menu_page( __( 'Demo Import', 'dubai-real-estate' ), __( 'Demo Import', 'dubai-real-estate' ), 'manage_options', 'dre-demo-import', 'dre_demo_screen', 'dashicons-download', 59 );
	add_theme_page( __( 'Demo Import', 'dubai-real-estate' ), __( 'Demo Import', 'dubai-real-estate' ), 'manage_options', 'dre-demo-import', 'dre_demo_screen' );
}
add_action( 'admin_menu', 'dre_demo_admin_menu' );

function dre_demo_screen() {
	$media    = (array) get_option( 'dre_demo_media', array() );
	$pages    = get_posts( array( 'post_type' => 'page', 'meta_key' => '_dre_demo', 'numberposts' => -1, 'fields' => 'ids' ) );
	$imported = get_option( 'dre_demo_imported' );
	$log      = array_reverse( (array) get_option( 'dre_demo_log', array() ) );
	$nonce    = wp_create_nonce( 'dre_demo' );
	?>
	<div class="wrap dre-demo">
		<h1><?php esc_html_e( 'Demo Import', 'dubai-real-estate' ); ?></h1>
		<p><?php esc_html_e( 'Import all demo pages, articles, menus, logo and images in one click. You can run it again at any time. It is safe to retry if something failed.', 'dubai-real-estate' ); ?></p>
		<table class="widefat striped" style="max-width:760px">
			<tbody>
				<tr><td><?php esc_html_e( 'Status', 'dubai-real-estate' ); ?></td><td><strong><?php echo $imported ? esc_html( sprintf( __( 'Imported on %s', 'dubai-real-estate' ), wp_date( 'j M Y, H:i', strtotime( $imported ) ) ) ) : esc_html__( 'Not imported yet', 'dubai-real-estate' ); ?></strong></td></tr>
				<tr><td><?php esc_html_e( 'Pages', 'dubai-real-estate' ); ?></td><td><?php echo esc_html( count( $pages ) . ' / ' . count( dre_demo_plan()['pages'] ) ); ?></td></tr>
				<tr><td><?php esc_html_e( 'Images and logo', 'dubai-real-estate' ); ?></td><td><?php echo esc_html( count( $media ) . ' / ' . count( dre_demo_media_files() ) ); ?></td></tr>
				<tr><td><?php esc_html_e( 'Community guides', 'dubai-real-estate' ); ?></td><td><?php echo esc_html( count( dre_demo_area_slugs() ) ); ?> <?php esc_html_e( '(built into the theme)', 'dubai-real-estate' ); ?></td></tr>
			</tbody>
		</table>
		<h2><?php esc_html_e( 'Import preview', 'dubai-real-estate' ); ?></h2>
		<p><?php esc_html_e( 'Review the demo content and untick anything you do not want. The home page is always included.', 'dubai-real-estate' ); ?></p>
		<?php $plan = dre_demo_plan(); ?>
		<div class="dre-box">
			<h3><?php esc_html_e( 'Pages', 'dubai-real-estate' ); ?> <small>(<span id="dre-pc">0</span>)</small> <a href="#" class="dre-all" data-g="pages"><?php esc_html_e( 'Select all', 'dubai-real-estate' ); ?></a> &middot; <a href="#" class="dre-none" data-g="pages"><?php esc_html_e( 'None', 'dubai-real-estate' ); ?></a></h3>
			<div class="dre-pages">
			<?php foreach ( dre_demo_pages() as $slug => $p ) : ?>
				<label class="dre-page"><input type="checkbox" name="pages" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, $plan['pages'], true ) ); disabled( 'home' === $slug ); ?>>
				<?php if ( $p[1] ) : ?><img src="<?php echo esc_url( DRE_URI . '/site/' . $p[1] ); ?>" alt="" loading="lazy"><?php else : ?><span class="dre-noimg"></span><?php endif; ?>
				<span><b><?php echo esc_html( $p[0] ); ?></b><em>/<?php echo esc_html( 'home' === $slug ? '' : $slug ); ?></em></span></label>
			<?php endforeach; ?>
			</div>
		</div>
		<div class="dre-box">
			<h3><?php esc_html_e( 'Communities', 'dubai-real-estate' ); ?> <small>(<span id="dre-ac">0</span>)</small> <a href="#" class="dre-all" data-g="areas"><?php esc_html_e( 'Select all', 'dubai-real-estate' ); ?></a> &middot; <a href="#" class="dre-none" data-g="areas"><?php esc_html_e( 'None', 'dubai-real-estate' ); ?></a></h3>
			<div class="dre-areas">
			<?php foreach ( dre_demo_area_slugs() as $slug ) : ?>
				<label class="dre-area"><input type="checkbox" name="areas" value="<?php echo esc_attr( $slug ); ?>" <?php checked( in_array( $slug, $plan['areas'], true ) ); ?>><img src="<?php echo esc_url( DRE_URI . '/site/images/areas/' . $slug . '.jpg' ); ?>" alt="" loading="lazy"><span><?php echo esc_html( dre_demo_area_name( $slug ) ); ?></span></label>
			<?php endforeach; ?>
			</div>
		</div>
		<style>.dre-box{background:#fff;border:1px solid #dcdcde;padding:16px 18px;margin:14px 0;max-width:1100px}.dre-box h3{margin:0 0 12px}.dre-box h3 a{font-size:12px;font-weight:400}.dre-pages,.dre-areas{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:10px}.dre-page,.dre-area{position:relative;display:flex;align-items:center;gap:10px;border:1px solid #e2e4e7;padding:6px;border-radius:4px;cursor:pointer}.dre-area{flex-direction:column;align-items:stretch;padding:0;overflow:hidden}.dre-page img,.dre-noimg{width:52px;height:40px;object-fit:cover;border-radius:3px;background:#eef4fa;flex:none}.dre-area img{width:100%;aspect-ratio:4/3;object-fit:cover}.dre-area span{padding:6px 8px;font-size:12px}.dre-page b{display:block;font-size:13px}.dre-page em{font-size:11px;color:#777;font-style:normal}.dre-page input,.dre-area input{position:absolute;top:6px;right:6px;margin:0}.dre-page input{position:static}.dre-page:has(input:not(:checked)),.dre-area:has(input:not(:checked)){opacity:.45}</style>
		<p><label><input type="checkbox" id="dre-replace"> <?php esc_html_e( 'Delete old demo pages and menus first (fresh import)', 'dubai-real-estate' ); ?></label></p>
		<p>
			<button class="button button-primary button-hero" id="dre-run"><?php echo $imported ? esc_html__( 'Re-import demo content', 'dubai-real-estate' ) : esc_html__( 'Import demo content', 'dubai-real-estate' ); ?></button>
			<button class="button button-link-delete" id="dre-remove" style="margin-left:12px"><?php esc_html_e( 'Remove all demo content', 'dubai-real-estate' ); ?></button>
		</p>
		<div id="dre-progress" style="max-width:760px;display:none"><div style="background:#e3f0fb;border-radius:4px;height:12px;overflow:hidden"><div id="dre-bar" style="background:#1f5f96;height:12px;width:0;transition:width .3s"></div></div><ul id="dre-steps"></ul></div>
		<?php if ( $log ) : ?>
			<h2><?php esc_html_e( 'Recent activity', 'dubai-real-estate' ); ?></h2>
			<pre style="max-width:760px;background:#fff;border:1px solid #dcdcde;padding:12px;max-height:220px;overflow:auto"><?php echo esc_html( implode( "\n", $log ) ); ?></pre>
		<?php endif; ?>
	</div>
	<script>
	(function(){
		var nonce=<?php echo wp_json_encode( $nonce ); ?>,ajax=<?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>;
		var list=document.getElementById('dre-steps'),bar=document.getElementById('dre-bar'),btns=document.querySelectorAll('#dre-run,#dre-remove');
		function add(t,cls){var li=document.createElement('li');li.textContent=t;if(cls)li.style.color=cls;list.appendChild(li);return li;}
		function picked(g){return Array.prototype.map.call(document.querySelectorAll('input[name="'+g+'"]:checked'),function(i){return i.value;});}
		function counts(){document.getElementById('dre-pc').textContent=picked('pages').length;document.getElementById('dre-ac').textContent=picked('areas').length;}
		document.querySelectorAll('input[name="pages"],input[name="areas"]').forEach(function(i){i.addEventListener('change',counts);});
		document.querySelectorAll('.dre-all,.dre-none').forEach(function(a){a.addEventListener('click',function(e){e.preventDefault();var on=a.classList.contains('dre-all');document.querySelectorAll('input[name="'+a.dataset.g+'"]:not(:disabled)').forEach(function(i){i.checked=on;});counts();});});
		counts();
		function call(step,offset){var f=new FormData();f.append('action','dre_demo_step');f.append('nonce',nonce);f.append('step',step);f.append('offset',offset||0);
			if(step==='plan'){picked('pages').forEach(function(v){f.append('pages[]',v);});f.append('pages[]','home');picked('areas').forEach(function(v){f.append('areas[]',v);});}
			return fetch(ajax,{method:'POST',body:f,credentials:'same-origin'}).then(function(r){return r.json().catch(function(){throw new Error('The server stopped responding (status '+r.status+'). Please click the button again to continue.');});})
			.then(function(j){if(!j.success)throw new Error(j.data&&j.data.msg?j.data.msg:'Step failed');return j.data;});}
		function run(steps){
			btns.forEach(function(b){b.disabled=true;});document.getElementById('dre-progress').style.display='block';list.innerHTML='';
			var i=0;
			function next(offset){
				if(i>=steps.length){add('Done. Reloading...','#008a20');setTimeout(function(){location.reload();},1200);return;}
				var s=steps[i],li=offset?list.lastChild:add('Working: '+s+'...');
				call(s,offset).then(function(d){li.textContent=d.msg;if(d.next){next(d.next);}else{i++;bar.style.width=Math.round(i/steps.length*100)+'%';next(0);}})
				.catch(function(e){li.textContent='Failed: '+e.message;li.style.color='#b32d2e';btns.forEach(function(b){b.disabled=false;});});
			}
			next(0);
		}
		document.getElementById('dre-run').addEventListener('click',function(e){e.preventDefault();var s=['media','pages','menus','settings'];if(document.getElementById('dre-replace').checked)s.unshift('reset');s.unshift('plan');run(s);});
		document.getElementById('dre-remove').addEventListener('click',function(e){e.preventDefault();if(confirm('Remove all demo pages, menus and images?'))run(['remove']);});
	})();
	</script>
	<?php
}

/* Reminder notice until the demo is imported, linking to the Demo Import screen. */
function dre_demo_notice() {
	if ( ! current_user_can( 'manage_options' ) || get_option( 'dre_demo_imported' ) ) { return; }
	$screen = get_current_screen();
	if ( $screen && false !== strpos( $screen->id, 'dre-demo-import' ) ) { return; }
	echo '<div class="notice notice-info"><p><strong>dubai realestate:</strong> ' . esc_html__( 'Import the demo pages, menus, logo and images.', 'dubai-real-estate' ) . ' <a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=dre-demo-import' ) ) . '">' . esc_html__( 'Open Demo Import', 'dubai-real-estate' ) . '</a></p></div>';
}
add_action( 'admin_notices', 'dre_demo_notice' );
