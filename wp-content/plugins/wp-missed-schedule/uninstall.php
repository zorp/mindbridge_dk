<?php 

	/**
	 * @package     WordPress Plugin
	 * @subpackage  WP Missed Schedule
	 * @description Uninstall Module
	 * @development Code in Becoming!
	 * @license     GPLv2 or later
	 *
	 * @gnu         www.gnu.org/licenses/gpl-2.0.html
	 * @humans      humanstxt.org/Standard.html
	 * @indentation www.gnu.org/prep/standards/standards.html
	 *
	 * @github      github.com/sLaNGjI/wp-missed-schedule
	 * @website     slangji.wordpress.com/wp-missed-schedule
	 * @wordpress   wordpress.org/plugins/wp-missed-schedule
	 *
	 * @author      sLaNGjIs @ slangji.wordpress.com
	 * @contact     slangji.wordpress.com/contact
	 * @donate      slangji.wordpress.com/donate
	 * @support     slangji.wordpress.com/support
	 * @translation slangji.wordpress.com/translations
	 *
	 * @build       2016-01-06
	 * @requires    WordPress 2.7+
	 * @since       WordPress 2.7+
	 * @tested      WordPress 3.7+
	 * @compatible  WordPress 4.5-alpha
	 */

	defined ( 'WP_UNINSTALL_PLUGIN' ) OR exit;

	$option_names = array( 
			'byrev_fixshedule_next_verify',
			'missed_schedule',
			'scheduled_post_guardian_next_run',
			'simpul_missed_schedule',
			'wpt_scheduled_check',
			'wp_missed_schedule',
			'wp_scheduled_missed',
			'wp_scheduled_missed_options',
	);

	global $wp_version;

	if ( $wp_version >= 3.0 )
		{
			if ( ! is_multisite() )
				{
					foreach ( $option_names as $option_name )
						{
							delete_option( $option_name );
						}
				}

			if ( is_multisite() )
				{
					foreach ( $option_names as $option_name )
						{
							delete_option( $option_name );
						}

					global $wpdb;

					$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
					$original_blog_id = get_current_blog_id();

					foreach ( $blog_ids as $blog_id )
						{
							switch_to_blog( $blog_id );

							foreach ( $option_names as $option_name )
								{
									delete_site_option( $option_name );
								}
						}
					switch_to_blog( $original_blog_id );
				}
		}
?>