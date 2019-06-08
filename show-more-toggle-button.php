<?php
/*
Plugin Name: Show More Toggle Button
Plugin URI:
Description: This is a plugin to make toggle button for show more section.
Version: 1.0.0
Author: Yuta Omori
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ShowMoreToggleButton
 *
 * Show more toggle button.
 */
class ShowMoreToggleButton {
	/**
	 * Instance of ShowMoreToggleButton.
	 *
	 * @var ShowMoreToggleButton
	 */
	protected static $_instance = null;
	/**
	 * Make instance of this class once(Singleton).
	 *
	 * @return ShowMoreToggleButton
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * ShowMoreToggleButton constructor.
	 */
	public function __construct() {
		add_shortcode( 'show-more-button-open', [ $this, 'show_more_button_open' ] );
		add_shortcode( 'show-more-button-close', [ $this, 'show_more_button_close' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_css_and_js' ] );
		add_action( 'admin_menu', [ $this, 'add_explanation_page' ] );
	}

	/**
	 * Open tag of show more button.
	 *
	 * @param string[] $args link text.
	 * @return string open HTML tag.
	 */
	public function show_more_button_open( $args ) {
		extract(
			shortcode_atts(
				[
					'text'             => '',
					'color'            => '',
					'background_color' => '',
					'size'             => '',
				],
				$args
			)
		);
		$html = '<div class="show-more-wrapper"><button class="show-more-toggle-button toggle-btn-basic toggle-btn-' . esc_html( $size ) . '" style="color: ' . esc_html( $color ) . '; background-color: ' . esc_html( $background_color ) . '; border-color: ' . esc_html( $background_color ) . '">' . esc_html( $text ) . '</button><div class="show-more-area">';
		return $html;
	}

	/**
	 * Close tag of show more button.
	 *
	 * @return string close HTML tag.
	 */
	public function show_more_button_close() {
		return '</div></div>';
	}

	/**
	 * Enqueue js and css.
	 */
	public function enqueue_css_and_js() {
		wp_enqueue_script( 'toggle_button_js', plugin_dir_url( __FILE__ ) . 'js/toggle-button.js', [ 'jquery' ], '', true );
		wp_enqueue_style( 'show_more_css', plugin_dir_url( __FILE__ ) . 'css/toggle-button.css', [], '' );
	}

	/**
	 * Add explanation page.
	 */
	public function add_explanation_page() {
		add_options_page(
			'About Show More Toggle Button',
			'Show more toggle button',
			'edit_posts',
			'show_more_toggle_button',
			[ $this, 'show_explanation_of_toggle_button' ]
		);
	}

	/**
	 * Show explanation of toggle button.
	 */
	public function show_explanation_of_toggle_button() {
		?>
		<h1>About Show More Toggle Button</h1>
		<p>You can use this plugin like this.</p>
		<code>
			[show-more-button-open text="Show More" color="white" background-color="orange" size="medium"]
				The area that you want to toggle.
			[show-more-button-close]
		</code>

		<p>Default text color is white.And default backgroud color is orange.</p>
		<p>Default size is medium.</p>
		<h2>Color Options & Background Color Options</h2>
		<p>You can choose color code that you like.</p>
		<p>You can use color name or Hexadecimal.</p>
		<p>For exemple red, green, blue or #000000, #228B22 etc.</p>
		<h2>Size Options</h2>
		<p>You can use three sizes below.</p>
		<code>
			large
			medium
			small
		</code>
		<?php
	}
}
ShowMoreToggleButton::instance();
