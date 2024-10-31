<?php
/*
Adapted from a code sample by Ohad Raz, http://generatewp.com
*/
class GWP_agenda_note_shortcode {
	/**
	 * $shortcode_tag
	 * holds the name of the shortcode tag
	 *
	 * @var string
	 */
	public $shortcode_tag = 'agenda_note';

	/**
	 * __construct
	 * class constructor will set the needed filter and action hooks
	 *
	 * @param array $args
	 */
	function __construct( $args = array() ) {
		// add shortcode
		// add_shortcode( $this->shortcode_tag, array( $this, 'shortcode_handler' ) );

		if ( is_admin() ) {
			add_action( 'admin_head', array( $this, 'admin_head' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		}
	}

	/**
	 * admin_head
	 * calls your functions into the correct filters
	 *
	 * @return void
	 */
	function admin_head() {
		// check user permissions
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		// check if WYSIWYG is enabled
		if ( 'true' == get_user_option( 'rich_editing' ) && ! function_exists( 'do_blocks' ) ) {
			add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) );
			add_filter( 'mce_buttons', array( $this, 'mce_buttons' ) );
		}
	}

	/**
	 * mce_external_plugins
	 * Adds our tinymce plugin
	 *
	 * @param  array $plugin_array
	 * @return array
	 */
	function mce_external_plugins( $plugin_array ) {
		global $post;
		if ( empty( $post->post_type ) || $post->post_type != 'rsvpmaker' || function_exists( 'do_blocks' ) ) {
			return $plugin_array;
		}
		$plugin_array[ $this->shortcode_tag ] = plugins_url( 'mce/mce-button.js?v=4', __FILE__ );
		$plugin_array['toastmaster']          = plugins_url( 'mce/toastmaster-mce.js?v=3', __FILE__ );
		return $plugin_array;
	}

	/**
	 * mce_buttons
	 * Adds our tinymce button
	 *
	 * @param  array $buttons
	 * @return array
	 */
	function mce_buttons( $buttons ) {
		global $post;
		if ( empty( $post->post_type ) || ( $post->post_type != 'rsvpmaker' ) || function_exists( 'do_blocks' ) ) {
			return $buttons;
		}
		array_push( $buttons, $this->shortcode_tag );
		array_push( $buttons, 'toastmaster' );
		return $buttons;
	}

	/**
	 * admin_enqueue_scripts
	 * Used to enqueue custom styles
	 *
	 * @return void
	 */
	function admin_enqueue_scripts() {
		 wp_enqueue_style( 'agenda_note_shortcode', plugins_url( 'mce/mce-button.css', __FILE__ ) );
	}
}//end class

new GWP_agenda_note_shortcode();
