<?php
/** Company and page controls in Appearance > Customize. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
function dre_fields(){return array(
 'identity'=>array('title'=>__('Brand','dubai-real-estate'),'fields'=>array(
  'dre_brand_name'=>array(__('Company name','dubai-real-estate'),'Solara Bay','text'),
  'dre_brand_legal'=>array(__('Legal company name','dubai-real-estate'),'Solara Bay Real Estate','text'),
  'dre_brand_tag'=>array(__('Tagline under logo','dubai-real-estate'),'REAL ESTATE','text'),
  'dre_footer_about'=>array(__('Footer description','dubai-real-estate'),'A licensed Dubai property company offering clear advice for buyers, sellers, tenants and landlords.','textarea'),
  'dre_copyright'=>array(__('Copyright text','dubai-real-estate'),'All rights reserved.','text'),
 )),
 'contact'=>array('title'=>__('Contact details','dubai-real-estate'),'fields'=>array(
  'dre_phone'=>array(__('Phone shown on site','dubai-real-estate'),'+971 56 181 5038','text'),
  'dre_whatsapp'=>array(__('WhatsApp number with country code','dubai-real-estate'),'971561815038','text'),
  'dre_email'=>array(__('Email address','dubai-real-estate'),'info@solarabay.ae','email'),
  'dre_hours'=>array(__('Opening hours','dubai-real-estate'),'Monday to Saturday, 9:00 to 19:00','text'),
 )),
 'legal'=>array('title'=>__('Licences','dubai-real-estate'),'fields'=>array(
  'dre_ded'=>array(__('DED licence number','dubai-real-estate'),'1656071','text'),
  'dre_orn'=>array(__('RERA ORN number','dubai-real-estate'),'64706','text'),
 )),
 'hero'=>array('title'=>__('Opening section','dubai-real-estate'),'fields'=>array(
  'dre_hero_line1'=>array(__('Headline line 1','dubai-real-estate'),'Dubai property,','text'),
  'dre_hero_line2'=>array(__('Headline line 2','dubai-real-estate'),'thoughtfully advised','text'),
  'dre_hero_sub'=>array(__('Short introduction','dubai-real-estate'),'We guide buyers, sellers, landlords, investors and tenants through every step, with clear numbers and honest advice.','textarea'),
  'dre_hero_eyebrow'=>array(__('Small text above headline','dubai-real-estate'),'Licensed by the DLD','text'),
  'dre_hero_quote'=>array(__('Founder note below opening section','dubai-real-estate'),'Starting the company comes from a genuine passion for Dubai\'s real estate market and, most importantly, for working with people. Our aim is simple, to understand our clients, provide honest guidance, and make the property journey as clear and comfortable as possible. We are building this company one relationship at a time, with the hope that every client we work with feels comfortable, valued, and confident in their decisions. Thank you for trusting us to be part of your journey.','textarea'),
  'dre_hero_quote_by'=>array(__('Quote signature','dubai-real-estate'),'The Solara Bay Team','text'),
  'dre_hero_cta'=>array(__('Main button text','dubai-real-estate'),'Book a free consultation','text'),
  'dre_hero_whatsapp'=>array(__('WhatsApp button text','dubai-real-estate'),'Chat on WhatsApp','text'),
  'dre_hero_image'=>array(__('Opening image','dubai-real-estate'),0,'image'),
 )),
 'sections'=>array('title'=>__('Home page sections','dubai-real-estate'),'fields'=>array(
  'dre_services_title'=>array(__('Services heading','dubai-real-estate'),'How can we help you?','text'),'dre_services_intro'=>array(__('Services introduction','dubai-real-estate'),'','textarea'),
  'dre_areas_title'=>array(__('Area guide heading','dubai-real-estate'),"Dubai's top communities, explained.",'text'),'dre_areas_intro'=>array(__('Area guide introduction','dubai-real-estate'),"Where to buy, rent or invest, from waterfront towers to family villa communities. Browse by lifestyle, or open any community for a full guide to living and investing there.",'textarea'),
  'dre_developers_title'=>array(__('Developers heading','dubai-real-estate'),'New launches from our developer partners.','text'),'dre_about_intro'=>array(__('About introduction','dubai-real-estate'),'Solara Bay Real Estate is a licensed real estate company based in Dubai. We help people buy, sell and invest in property across the UAE, and we help landlords and tenants find the right match. We explain every cost up front and give honest advice, even when the answer is to wait.','textarea'),'dre_about_title'=>array(__('About heading','dubai-real-estate'),'Advice you can check, before you commit.','text'),
  'dre_process_title'=>array(__('Process heading','dubai-real-estate'),'From first call to keys in four clear steps.','text'),'dre_fees_title'=>array(__('Fees heading','dubai-real-estate'),'Clear fees, agreed in writing.','text'),
  'dre_faq_title'=>array(__('FAQ heading','dubai-real-estate'),'Questions clients ask us.','text'),'dre_contact_title'=>array(__('Contact form heading','dubai-real-estate'),"Tell us what you're looking for. We'll do the searching.",'text'),'dre_advisor_title'=>array(__('Advisor heading','dubai-real-estate'),'Talk to an advisor.','text'),
 )),
 'navigation'=>array('title'=>__('Navigation','dubai-real-estate'),'description'=>__('Choose full menus under Appearance > Menus. These labels are used until a menu is assigned.','dubai-real-estate'),'fields'=>array(
  'dre_nav_services'=>array(__('Services label','dubai-real-estate'),'Services','text'),'dre_nav_areas'=>array(__('Area guide label','dubai-real-estate'),'Area Guide','text'),'dre_nav_developers'=>array(__('Developers label','dubai-real-estate'),'Developers','text'),'dre_nav_about'=>array(__('About label','dubai-real-estate'),'About Us','text'),'dre_nav_launches'=>array(__('Latest launches label','dubai-real-estate'),'Latest Launches','text'),'dre_nav_visa'=>array(__('Golden Visa label','dubai-real-estate'),'Golden Visa','text'),'dre_nav_careers'=>array(__('Careers label','dubai-real-estate'),'Careers','text'),'dre_nav_contact'=>array(__('Contact label','dubai-real-estate'),'Contact','text'),'dre_nav_cta'=>array(__('Header button text','dubai-real-estate'),'Book a free consultation','text'),
 )),
 'footer'=>array('title'=>__('Footer','dubai-real-estate'),'fields'=>array(
  'dre_footer_disclaimer'=>array(__('General guidance disclaimer','dubai-real-estate'),'Information on this website is general guidance and may change. Please confirm details with us before making a decision.','textarea'),
  'dre_footer_company_title'=>array(__('Company links heading','dubai-real-estate'),'Company','text'),'dre_footer_services_title'=>array(__('Service links heading','dubai-real-estate'),'Services','text'),'dre_footer_contact_title'=>array(__('Contact heading','dubai-real-estate'),'Contact','text'),
 )),
 'social'=>array('title'=>__('Social links','dubai-real-estate'),'fields'=>array(
  'dre_instagram'=>array('Instagram URL','','url'),'dre_facebook'=>array('Facebook URL','','url'),'dre_linkedin'=>array('LinkedIn URL','','url'),'dre_youtube'=>array('YouTube URL','','url'),'dre_tiktok'=>array('TikTok URL','','url'),'dre_x'=>array('X URL','','url'),
 )),
 'colors'=>array('title'=>__('Colours','dubai-real-estate'),'fields'=>array(
  'dre_color_ink'=>array(__('Headings and dark colour','dubai-real-estate'),'#0E2B47','color'),'dre_color_accent'=>array(__('Accent colour','dubai-real-estate'),'#8EC5F0','color'),'dre_color_link'=>array(__('Link colour','dubai-real-estate'),'#1F5F96','color'),'dre_color_wash'=>array(__('Pale background','dubai-real-estate'),'#F0F7FD','color'),
 )),
);}
function dre_get($key){foreach(dre_fields() as $section){if(isset($section['fields'][$key]))return get_theme_mod($key,$section['fields'][$key][1]);}return '';}
function dre_customize_register($wp_customize){
 $wp_customize->add_panel('dre_company',array('title'=>__('dubai realestate Theme','dubai-real-estate'),'description'=>__('Edit your company, opening section, navigation, footer and colours.','dubai-real-estate'),'priority'=>25));
 foreach(dre_fields() as $id=>$section){$wp_customize->add_section('dre_'.$id,array('title'=>$section['title'],'description'=>isset($section['description'])?$section['description']:'','panel'=>'dre_company'));
  foreach($section['fields'] as $key=>$f){list($label,$default,$type)=$f;$sanitize='sanitize_text_field';if('html'===$type)$sanitize='wp_kses_post';elseif('textarea'===$type)$sanitize='sanitize_textarea_field';elseif('email'===$type)$sanitize='sanitize_email';elseif('url'===$type)$sanitize='esc_url_raw';elseif('color'===$type)$sanitize='sanitize_hex_color';elseif('image'===$type)$sanitize='absint';$wp_customize->add_setting($key,array('default'=>$default,'sanitize_callback'=>$sanitize,'transport'=>'refresh'));
   $args=array('label'=>$label,'section'=>'dre_'.$id,'type'=>('html'===$type?'textarea':$type));
   if('color'===$type)$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,$key,$args));elseif('image'===$type)$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize,$key,array_merge($args,array('mime_type'=>'image'))));else $wp_customize->add_control($key,$args);
  }
 }
}
add_action('customize_register','dre_customize_register');
