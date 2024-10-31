<?php
/**
 * Agenda layout blocks
 * @package           wp4toastmasters
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function wp4toastmasters_agenda_layout_block_init() {
	register_block_type( __DIR__ . '/build/agendamain' );
	register_block_type( __DIR__ . '/build/meetingdate' );
	register_block_type( __DIR__ . '/build/officers' );
}
add_action( 'init', 'wp4toastmasters_agenda_layout_block_init' );
