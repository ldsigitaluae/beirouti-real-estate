<?php
/** dubai realestate theme bootstrap. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
define( 'DRE_VERSION', '3.0.1' );
define( 'DRE_DIR', get_template_directory() );
define( 'DRE_URI', get_template_directory_uri() );
require DRE_DIR . '/inc/customizer.php';
require DRE_DIR . '/inc/render.php';
require DRE_DIR . '/inc/demo-import.php';

function dre_setup() {
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
  add_theme_support( 'custom-logo', array( 'height'=>80, 'width'=>240, 'flex-height'=>true, 'flex-width'=>true ) );
  register_nav_menus( array(
    'primary' => __( 'Main navigation', 'dubai-real-estate' ),
    'footer_company' => __( 'Footer company links', 'dubai-real-estate' ),
    'footer_services' => __( 'Footer service links', 'dubai-real-estate' ),
  ) );
}
add_action( 'after_setup_theme', 'dre_setup' );

function dre_rewrites() { add_rewrite_rule( '^area/([a-z0-9-]+)/?$', 'index.php?dre_area=$matches[1]', 'top' ); }
add_action( 'init', 'dre_rewrites' );
function dre_query_vars( $vars ) { $vars[]='dre_area'; return $vars; }
add_filter( 'query_vars', 'dre_query_vars' );
function dre_activate() { dre_rewrites(); flush_rewrite_rules(); }
add_action( 'after_switch_theme', 'dre_activate' );

function dre_template_redirect() {
  $area=get_query_var('dre_area');
  if($area){$area=sanitize_title($area);$file=DRE_DIR.'/site/area/'.$area.'.html';if(!file_exists($file)){return;}status_header(200);global $wp_query;$wp_query->is_404=false;echo dre_render_file($file,true);exit;}
  if(is_page(array('latest-launches','golden-visa','careers'))){$file=DRE_DIR.'/site/'.get_post_field('post_name',get_queried_object_id()).'.html';if(file_exists($file)){echo dre_render_file($file,false);exit;}}
  if(is_front_page()&&!is_paged()){echo dre_render_file(DRE_DIR.'/site/index.html',false);exit;}
}
add_action( 'template_redirect', 'dre_template_redirect' );
function dre_basic_assets(){
  wp_enqueue_style('dre-fonts','https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400;1,6..96,400&family=Marcellus&display=swap',array(),null);
  wp_enqueue_style('dre-style',get_stylesheet_uri(),array(),DRE_VERSION);
}
add_action('wp_enqueue_scripts','dre_basic_assets');
