<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'siteorigin-corp-style','siteorigin-corp-style','siteorigin-corp-icons' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

function add_aos_library() {
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css');
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), null, true);
    wp_add_inline_script('aos-js', 'window.addEventListener("load", function(){ AOS.init({ duration: 800, once: true }); });');
}
add_action('wp_enqueue_scripts', 'add_aos_library');

// END ENQUEUE PARENT ACTION

/* ==========================================================================
 * Clazar-style blog helpers (added to the official SiteOrigin Corp child theme)
 * ========================================================================== */

/**
 * Reading time ("X min read") based on post word count.
 */
if ( ! function_exists( 'clz_reading_time' ) ) {
    function clz_reading_time( $post_id = null ) {
        $post_id = $post_id ? $post_id : get_the_ID();
        $content = get_post_field( 'post_content', $post_id );
        $content = strip_shortcodes( $content );
        $words   = str_word_count( wp_strip_all_tags( $content ) );
        $minutes = max( 1, (int) ceil( $words / 200 ) );

        return $minutes . ' min read';
    }
}

/**
 * Category pills (limited) for a post.
 */
if ( ! function_exists( 'clz_categories' ) ) {
    function clz_categories( $limit = 3 ) {
        $cats = get_the_category();
        if ( empty( $cats ) ) {
            return '';
        }
        $out = '';
        $i   = 0;
        foreach ( $cats as $cat ) {
            if ( $i >= $limit ) {
                break;
            }
            $out .= '<a class="clz-tag" href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>';
            $i++;
        }
        return $out;
    }
}

/**
 * Author row (avatar + name).
 */
if ( ! function_exists( 'clz_author' ) ) {
    function clz_author( $size = 32 ) {
        $out  = '<span class="clz-author">';
        $out .= get_avatar( get_the_author_meta( 'ID' ), $size, '', '', array( 'class' => 'clz-avatar' ) );
        $out .= '<span class="clz-author-name">' . esc_html( get_the_author() ) . '</span>';
        $out .= '</span>';
        return $out;
    }
}

/*
 * Featured image sizing note: the Clazar-style 16:9 crops are enforced with
 * CSS (aspect-ratio + object-fit) so they work identically for existing and
 * newly uploaded images — no thumbnail regeneration needed.
 */
