<?php
/**
 * Plugin Name: Post Language
 * Version: 0.1
 * Description: Implements the long lost language core feature for WordPress.
 * Author: Caspar Hübinger
 * Author URI: http://glueckpress.com/
 * Plugin URI: https://github.com/glueckpress/wordpress-post-language
 *
 * Text Domain: post-language
 * Domain Path: /lang
 *
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 *	This program is free software; you can redistribute it and/or
 *	modify it under the terms of the GNU General Public License
 *	as published by the Free Software Foundation; either version 2
 *	of the License, or (at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Version 0.1 of this plugin is a dummy.
 * It is supposed to demonstrate basic plugin architecture and
 * functionalities. Before the plugin can actually be tested, there are
 * at least the following tasks to be completed:
 *
 * @todo
 *
 * - Add default language object.
 *   Default languages are to be stored in an object cotaining
 *   relevant bits of data for each language such as iso codes,
 *   native names, english names etc,
 *
 * - Make default languages sortable and filterable.
 *   Default languages need to be sortable and modifyable through a filter.
 *
 * - Implement default language object calls into Post_Language class.
 *   The Post_Language class needs to operate on the default language object,
 *   particularly default_post_language(), get_select_html() and post_language().
 *
 * - Complete/enhance inline docs.
 */
add_action( 'plugins_loaded', array( 'Post_Language', 'init' ) );
register_uninstall_hook( __FILE__, array( 'Post_Language', 'uninstall' ) );


/**
 * Post_Language class.
 */
class Post_Language {

	/**
	 * init function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function init() {

		add_action( 'init', array( __CLASS__, 'load_textdomain' ) );

		if ( is_admin() ) {

			add_action( 'post_submitbox_misc_actions', array( __CLASS__, 'post_submitbox_misc_actions' ) );
			add_action( 'save_post', array( __CLASS__, 'register_post_language' ), 20, 2 );
		}
	}

	/**
	 * load_textdomain function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function load_textdomain() {

		return load_plugin_textdomain(
			'post-language',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/lang'
		);
	}

	/**
	 * post_submitbox_misc_actions function.
	 *
	 * @access public
	 * @static
	 * @return string
	 */
	public static function post_submitbox_misc_actions() {

		$post_types = apply_filters(
			'post_language_get_post_types',
			get_post_types( array( 'public'  => true, 'show_ui' => true ) )
		);
		$post = get_post();

		if ( ! in_array( $post->post_type, $post_types ) )
			return false;

		?>
		<div class="misc-pub-section post-language">
			<?php self::get_select_html( $post ); ?>
		</div>
		<?php
	}

	/**
	 * get_select_html function.
	 *
	 * @access private
	 * @static
	 * @param mixed $post
	 * @return string
	 */
	private static function get_select_html( $post ) {

		if ( empty( $post ) )
			$post = get_post();

		$post_language = self::get_post_language( $post->ID );

		// @todo Replace static dummy languages with to-be-created object data.

		?>
		<label><?php _e( 'This post is written in', 'post-language' ); ?></label>
		<select name="post_language" id="post-language">
			<option<?php selected( 'en_EN', $post_language ); ?> value="en_EN"><?php _e( 'English (US)',  'post-language' ) ?></option>
			<option<?php selected( 'en_GB', $post_language ); ?> value="en_GB"><?php _e( 'English (UK)',  'post-language' ) ?></option>
			<option<?php selected( 'de_DE', $post_language ); ?> value="de_DE"><?php _e( 'Deutsch (DE)',  'post-language' ) ?></option>
			<option<?php selected( 'de_CH', $post_language ); ?> value="de_CH"><?php _e( 'Deutsch (CH)',  'post-language' ) ?></option>
			<option<?php selected( 'fr_FR', $post_language ); ?> value="fr_FR"><?php _e( 'Français (FR)', 'post-language' )  ?></option>
			<option<?php selected( 'fr_CH', $post_language ); ?> value="fr_CH"><?php _e( 'Français (CH)', 'post-language' )  ?></option>
		</select>
		<?php
	}

	/**
	 * register_post_language function.
	 *
	 * @access private
	 * @static
	 * @param mixed $post_id
	 * @param mixed $post
	 * @return string
	 */
	public static function register_post_language( $post_id, $post ) {

		$post_language = self::get_post_language( $post_id );

		if ( ! empty( $_POST['post_language'] ) )
			$post_language = $_POST['post_language'];

		return self::set_post_language( $post_id, $post_language );
	}


	/**
	 * default_post_language function.
	 *
	 * @access public
	 * @static
	 * @return string
	 */
	public static function default_post_language() {

		global $locale;

		return $locale;
	}


	/**
	 * get_post_language function.
	 *
	 * @access public
	 * @static
	 * @param mixed $post_id
	 * @return string
	 */
	public static function get_post_language( $post_id ) {

		return get_post_meta( $post_id, '_post_language', true );
	}


	/**
	 * set_post_language function.
	 *
	 * @access public
	 * @static
	 * @param mixed $post_id
	 * @param string $post_language (default: '')
	 * @return string|bool
	 */
	public static function set_post_language( $post_id, $post_language = '' ) {

		$post_language = $post_language ? $post_language : self::default_post_language();

		return update_post_meta( $post_id, '_post_language', $post_language );
	}


	/**
	 * get_plugin_info function.
	 *
	 * @access private
	 * @static
	 * @param mixed $key (default: null)
	 * @return array|bool
	 */
	private static function get_plugin_info( $key = null ) {

		$plugin_data = get_plugin_data( __FILE__);
		if ( array_key_exists( $key, $plugin_data ) )
			return $plugin_data[ $key ];

		return false;
	}


	/**
	 * uninstall function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function uninstall() {

		delete_post_meta_by_key( '_post_language' );
	}
}

/**
 * Template tags
 */
if ( ! function_exists( 'get_the_post_language' ) ) {
	/**
	 * get_the_post_language function.
	 *
	 * @access public
	 * @param mixed $post_id
	 * @return string
	 */
	function get_the_post_language( $post_id ) {

		global $post;

		$post_id = $post_id ? $post_id : $post->ID;

		return apply_filters( 'the_post_language', Post_Language::get_post_language( $post_id ) );
	}
}

if ( ! function_exists( 'the_post_language' ) ) {
	/**
	 * the_post_language function.
	 *
	 * @access public
	 * @return string
	 */
	function the_post_language() {

		global $post;

		echo get_the_post_language( $post->ID );
	}
}

if ( ! function_exists( 'post_language' ) ) {
	/**
	 * post_language function.
	 *
	 * @access public
	 * @param string $lang (default: '')
	 * @param string $dir (default: '')
	 * @return string
	 */
	function post_language( $lang = '', $dir = '' ) {

		global $post;

		// @todo This is beyond incomplete and very wrong, obviously.

		$lang = $lang ? esc_attr( $lang ) : esc_attr( get_the_post_language( $post->ID ) );
		$dir  = $dir  ? esc_attr( $dir  ) : 'ltr';

		echo apply_filters( 'post_language', sprintf( 'lang="%1$s" dir="%2$s"', $lang, $dir ) );
	}
}