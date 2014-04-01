<?php

/**
 * iThemes file handler.
 *
 * Writes to core files including wp-config.php, htaccess and nginx.conf.
 *
 * @package iThemes_Security
 *
 * @since   4.0
 */
final class ITSEC_Files {

	private
		$rewrite_rules,
		$wpconfig_rules,
		$rewrites_changed,
		$config_changed;

	/**
	 * Create and manage wp_config.php or .htaccess/nginx rewrites.
	 *
	 * Executes primary file actions at plugins_loaded.
	 *
	 * @since  4.0
	 *
	 * @access private
	 *
	 * @return void
	 */
	function __construct() {

		$this->rewrites_changed = false;
		$this->config_changed   = false;

		//Add the metabox
		add_action( 'itsec_add_admin_meta_boxes', array( $this, 'add_admin_meta_boxes' ) );
		add_action( 'plugins_loaded', array( $this, 'file_writer_init' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );

	}

	/**
	 * Add meta boxes to primary options pages.
	 *
	 * @since 4.0
	 *
	 * @return void
	 */
	function add_admin_meta_boxes() {

		add_meta_box(
			'itsec_rewrite',
			__( 'Rewrite Rules', 'LION' ),
			array( $this, 'rewrite_metabox' ),
			'toplevel_page_itsec',
			'bottom',
			'core'
		);

		add_meta_box(
			'itsec_wpconfig',
			__( 'wp-config.php Rules', 'LION' ),
			array( $this, 'config_metabox' ),
			'toplevel_page_itsec',
			'bottom',
			'core'
		);

	}

	/**
	 * Processes file writing after saving options.
	 *
	 * @since 4.0
	 *
	 * @return false
	 */
	public function admin_init() {

		if ( $this->rewrites_changed === true ) {

			do_action( 'itsec_pre_save_rewrites' );

			$rewrites = $this->save_rewrites();

			if ( is_array( $rewrites ) ) {

				if ( $rewrites['success'] === false ) {

					$type    = 'error';
					$message = $rewrites['text'];

					add_settings_error( 'itsec', esc_attr( 'settings_updated' ), $message, $type );

				} elseif ( $rewrites['text'] !== true ) {

					$type    = 'updated';
					$message = $rewrites['text'];

					add_settings_error( 'itsec', esc_attr( 'settings_updated' ), __( 'Settings Updated', 'LION' ) . '<br />' . $message, $type );

				}

			} else {

				add_site_option( 'itsec_manual_update', true );

			}

		}

		if ( $this->config_changed === true ) {

			do_action( 'itsec_pre_save_configs' );

			$configs = $this->save_wpconfig();

			if ( is_array( $configs ) ) {

				if ( $configs['success'] === false ) {

					$type    = 'error';
					$message = $configs['text'];

					add_settings_error( 'itsec', esc_attr( 'settings_updated' ), $message, $type );

				}

			} else {

				add_site_option( 'itsec_manual_update', true );

			}

		}

	}

	/**
	 * Builds server appropriate rewrite rules.
	 *
	 * Build the actually rewrite rules that can be written to the server or
	 * echoed to the user.
	 *
	 * @since  4.0
	 *
	 * @access private
	 *
	 * @return array|bool The rewrite rules to use or false if there are none
	 */
	private function build_rewrites() {

		$out_values    = array();
		$rewrite_rules = $this->rewrite_rules; //only get the htaccess portion

		uasort( $rewrite_rules, array( $this, 'priority_sort' ) ); //sort by priority

		foreach ( $rewrite_rules as $key => $value ) {

			if ( is_array( $value['rules'] ) && sizeof( $value['rules'] ) > 0 ) {

				$out_values[] = "\t# BEGIN " . $value['name']; //add section header

				foreach ( $value['rules'] as $rule ) {

					$out_values[] = "\t\t" . $rule; //write all the rules

				}

				$out_values[] = "\t# END " . $value['name']; //add section footer

			}

		}

		if ( sizeof( $out_values ) > 0 ) {
			return $out_values;
		} else {
			return false;
		}

	}

	/**
	 * Calls config metabox action.
	 *
	 * @since 4.0
	 *
	 * @return void
	 */
	public function config_metabox() {

		do_action( 'itsec_wpconfig_metabox' );

	}

	/**
	 * Echos content metabox contents.
	 *
	 * @since 4.0
	 *
	 * @return void
	 */
	public function config_metabox_contents() {

		$rules_to_write = ''; //String of rules to insert into wp-config

		//build the rules we need to write, replace or delete
		foreach ( $this->wpconfig_rules as $section_rule ) {

			if ( is_array( $section_rule['rules'] ) ) {

				foreach ( $section_rule['rules'] as $rule ) {

					if ( ( isset( $rule['type'] ) && $rule['type'] === 'add' ) && $rule['rule'] !== false ) { //new rule or replacing a rule that doesn't exist

						$rules_to_write .= $rule['rule'] . PHP_EOL;

					}

				}

			}

		}

		if ( strlen( $rules_to_write ) > 1 ) {

			echo '<div class="itsec_rewrite_rules">' . highlight_string( $rules_to_write, true ) . '</div>';

		} else {

			_e( 'There are no rules to write.', 'LION' );

		}

	}

	/**
	 * Delete htaccess rules when plugin is deactivated.
	 *
	 * Deletes existing rules from .htaccess allowing for a  "clean slate"
	 * for writing the new rules.
	 *
	 * @since  4.0
	 *
	 * @access private
	 *
	 * @return bool true on success of false
	 */
	private function delete_rewrites() {

		global $wp_filesystem;

		$rule_open  = array( '# BEGIN iThemes Security', '# BEGIN Better WP Security' );
		$rule_close = array( '# END iThemes Security', '# END Better WP Security' );

		$url = wp_nonce_url( 'options.php?page=itsec_creds', 'itsec_write_wpconfig' );

		$form_fields = array( 'save' );
		$method      = '';

		if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, $form_fields ) ) ) {
			return false; // stop the normal page form from displaying
		}

		if ( ! WP_Filesystem( $creds ) ) {
			// our credentials were no good, ask the user for them again
			request_filesystem_credentials( $url, $method, true, false, $form_fields );

			return false;
		}

		$htaccess_file = ITSEC_Lib::get_htaccess();

		//Make sure we can write to the file
		$perms = substr( sprintf( '%o', @fileperms( $htaccess_file ) ), - 4 );

		if ( $perms == '0444' ) {
			@chmod( $htaccess_file, 0644 );
		}

		//make sure the file exists and create it if it doesn't
		if ( ! $wp_filesystem->exists( $htaccess_file ) ) {

			$wp_filesystem->touch( $htaccess_file );

		}

		$htaccess_contents = $wp_filesystem->get_contents( $htaccess_file ); //get the contents of the htaccess or nginx file

		if ( $htaccess_contents === false ) { //we couldn't get the file contents

			return false;

		} else { //write out what we need to.

			$lines = explode( PHP_EOL, $htaccess_contents ); //create an array to make this easier
			$state = false;

			foreach ( $lines as $line_number => $line ) { //for each line in the file

				if ( in_array( trim( $line ), $rule_open ) !== false ) { //if we're at the beginning of the section
					$state = true;
				}

				if ( $state == true ) { //as long as we're not in the section keep writing

					unset( $lines[$line_number] );

				}

				if ( in_array( trim( $line ), $rule_close ) !== false ) { //see if we're at the end of the section
					$state = false;
				}

			}

			$htaccess_contents = implode( PHP_EOL, $lines );

			if ( ! $wp_filesystem->put_contents( $htaccess_file, $htaccess_contents, FS_CHMOD_FILE ) ) {
				return false;
			}

		}

		//reset file permissions if we changed them
		if ( $perms == '0444' ) {
			@chmod( $htaccess_file, 0444 );
		}

		return true;

	}

	/**
	 * Execute activation functions.
	 *
	 * Writes necessary information to wp-config and .htaccess upon plugin activation.
	 *
	 * @since  4.0
	 *
	 * @return void
	 */
	public function do_activate() {

		$this->save_wpconfig();
		$this->save_rewrites();

	}

	/**
	 * Execute deactivation functions.
	 *
	 * Writes necessary information to wp-config and .htaccess upon plugin deactivation.
	 *
	 * @since  4.0
	 *
	 * @return void
	 */
	public function do_deactivate() {

		$this->delete_rewrites();
		$this->save_wpconfig();

	}

	/**
	 * Initialize file writer and rules arrays.
	 *
	 * Sets up initial information such as file locations and more to make
	 * calling quicker.
	 *
	 * @since  4.0
	 *
	 * @return void
	 */
	public function file_writer_init() {

		global $itsec_globals;

		if ( isset( $itsec_globals['settings']['write_files'] ) && $itsec_globals['settings']['write_files'] === true && ( get_site_option( 'itsec_config_changed' ) == '1' || get_site_option( 'itsec_rewrites_changed' ) == '1' ) && isset( $_GET['page'] ) && sanitize_text_field( $_GET['page'] ) == 'toplevel_page_itsec_settings' && isset( $_GET['settings-updated'] ) && sanitize_text_field( $_GET['settings-updated'] ) == 'true' ) {

			$this->rewrites_changed = get_site_option( 'itsec_rewrites_changed' ) == '1' ? true : false;
			$this->config_changed   = get_site_option( 'itsec_config_changed' ) == '1' ? true : false;

			delete_site_option( 'itsec_rewrites_changed' );
			delete_site_option( 'itsec_config_changed' );

		}

		$all_rules            = array(); //initialize rules array
		$this->rewrite_rules  = array(); //rewrite rules that will need to be written
		$this->wpconfig_rules = array(); //wp-config rules that will need to be written

		$all_rules = apply_filters( 'itsec_file_rules', $all_rules );

		if ( sizeof( $all_rules ) > 0 ) {

			foreach ( $all_rules as $rule ) {

				if ( $rule['type'] === 'htaccess' ) {

					$this->rewrite_rules[] = $rule;

				} elseif ( $rule['type'] === 'wpconfig' ) {

					$this->wpconfig_rules[] = $rule;

				}

			}

		}

	}

	/**
	 * Attempt to get a lock for atomic operations.
	 *
	 * @since  4.0
	 *
	 * @param string $lock_file file name of lock
	 * @param int    $exp       seconds until lock expires
	 *
	 * @return bool true if lock was achieved, else false
	 */
	public function get_file_lock( $lock_file, $exp = 180 ) {

		global $itsec_globals;

		clearstatcache();

		$lock_file = $itsec_globals['ithemes_dir'] . '/' . sanitize_text_field( $lock_file ) . '.lock';
		$dir_age   = @filectime( $lock_file );

		if ( @mkdir( $lock_file ) === false ) {

			if ( $dir_age !== false ) {

				if ( ( time() - $dir_age ) > intval( $exp ) ) { //see if the lock has expired

					@rmdir( $lock_file );
					@mkdir( $lock_file );

				} else { //couldn't get the lock

					return false;

				}

			}

		}

		return true; //file lock was achieved

	}

	/**
	 * Sorts given arrays py priority key
	 *
	 * @since  4.0
	 *
	 * @param  string $a value a
	 * @param  string $b value b
	 *
	 * @return int    -1 if a less than b, 0 if they're equal or 1 if a is greater
	 */
	private function priority_sort( $a, $b ) {

		if ( isset( $a['priority'] ) && isset( $b['priority'] ) ) {

			if ( $a['priority'] == $b['priority'] ) {
				return 0;
			}

			return $a['priority'] > $b['priority'] ? 1 : - 1;

		} else {
			return 1;
		}

	}

	public static function quick_ban( $host ) {

		$host = trim( $host );

		if ( ITSEC_Lib::validates_ip_address( trim( $host ) ) ) {

			$rule_open = array( '# BEGIN iThemes Security', '# BEGIN Better WP Security' );

			$htaccess_file = ITSEC_Lib::get_htaccess();

			if ( ITSEC_Lib::get_server() === 'nginx' ) { //NGINX rules
				$host_rule = "\tdeny " . $host . ';' . PHP_EOL;
			} else { //rules for all other servers
				$host_rule = 'Deny from ' . trim( $host ) . PHP_EOL;
			}

			//Make sure we can write to the file
			$perms = substr( sprintf( '%o', @fileperms( $htaccess_file ) ), - 4 );

			@chmod( $htaccess_file, 0644 );

			$htaccess_contents = @file( $htaccess_file );

			$test = 1;

			$has_itsec = false; //assume itsec hasn't written anything to htaccess

			foreach ( $htaccess_contents as $line_number => $line ) {

				if ( in_array( trim( $line ), $rule_open ) ) {
					$has_itsec = $line_number;
				}

			}

			if ( $has_itsec === false ) {

				array_unshift(
					$htaccess_contents,
					'# BEGIN iThemes Security' . PHP_EOL,
					$host_rule,
					'# END iThemes Security' . PHP_EOL
				);

				$content = implode( '', $htaccess_contents );

			} else {

				$content = implode( '', $htaccess_contents );
				$content = str_replace( '# BEGIN iThemes Security' . PHP_EOL, '# BEGIN iThemes Security' . PHP_EOL . $host_rule, $content );

			}

			if ( ! $f = @fopen( $htaccess_file, 'w+' ) ) {

				return false; //we can't write to the file

			}

			@fwrite( $f, $content );

			@fclose( $f );

			//reset file permissions if we changed them
			if ( $perms == '0444' ) {
				@chmod( $htaccess_file, 0444 );
			}

		}

		return true;

	}

	/**
	 * Release the lock.
	 *
	 * Releases a file lock to allow others to use it.
	 *
	 * @since  4.0
	 *
	 * @param string $lock_file file name of lock
	 *
	 * @return bool true if released, false otherwise
	 */
	public function release_file_lock( $lock_file ) {

		global $itsec_globals;

		$lock_file = $itsec_globals['ithemes_dir'] . '/' . sanitize_text_field( $lock_file ) . '.lock';

		return @rmdir( $lock_file );

	}

	/**
	 * Calls rewrite metabox action.
	 *
	 * @since 4.0
	 *
	 * @return void
	 */
	public function rewrite_metabox() {

		do_action( 'itsec_rewrite_metabox' );

	}

	/**
	 * Echos rewrite metabox content.
	 *
	 * @since 4.0
	 *
	 * @return void
	 */
	public function rewrite_metabox_contents() {

		$rewrite_rules = $this->build_rewrites();

		if ( is_array( $rewrite_rules ) && sizeof( $rewrite_rules ) > 0 ) {

			echo '<div class="itsec_rewrite_rules" readonly>';
			echo highlight_string( '# BEGIN iThemes Security', true ) . PHP_EOL;

			foreach ( $rewrite_rules as $rule ) {
				echo highlight_string( $rule, true ) . PHP_EOL;
			}

			echo highlight_string( '# END iThemes Security', true ) . PHP_EOL;

			echo '</div>';

		} else {

			_e( 'There are no rules to write.', 'LION' );

		}

	}

	/**
	 * Saves all rewrite rules to htaccess or similar file.
	 *
	 * Gets a file lock for .htaccess and calls the writing function if successful.
	 *
	 * @since  4.0
	 *
	 * @return mixed array or false if writing disabled or error message
	 */
	public function save_rewrites() {

		global $itsec_globals;

		if ( ITSEC_Lib::get_server() == 'nginx' || ( isset( $itsec_globals['settings']['write_files'] ) && $itsec_globals['settings']['write_files'] === true ) ) {

			if ( $this->get_file_lock( 'htaccess' ) ) {

				$success = $this->write_rewrites(); //save the return value for success/error flag

				$release = $this->release_file_lock( 'htaccess' );

				if ( $success === true && $release === true ) {

					if ( ITSEC_Lib::get_server() == 'nginx' ) {

						return array(
							'success' => true,
							'text'    => sprintf(
								'%s %s. %s',
								__( 'Your rewrite rules have been saved to', 'LION' ),
								$itsec_globals['settings']['nginx_file'],
								__( 'You must restart your NGINX server for the settings to take effect', 'LION' )
							),
						);

					} else {

						return array(
							'success' => true,
							'text'    => true,
						);

					}

				} elseif ( $success === true && $release === false ) {

					return array(
						'success' => false,
						'text'    => __( 'Unable to release a lock on your .htaccess or nginx.conf file. If the problem persists contact support.', 'LION' ),
					);

				} else {

					return array(
						'success' => false,
						'text'    => __( 'Unable to write to your .htaccess or nginx.conf file. If the problem persists contact support.', 'LION' ),
					);

				}

			} else { //return false if we can't get a file lock

				return array(
					'success' => false,
					'text'    => __( 'WordPress was unable to save the your options to .htaccess or nginx.conf file. It looks like another process might already be working on the file. Please wait a few minutes and try again or contact support if the problem persists.', 'LION' ),
				);

			}

		} else {

			return false;

		}

	}

	/**
	 * Saves all wpconfig rules to wp-config.php.
	 *
	 * Gets a file lock for wp-config.php and calls the writing function if successful.
	 *
	 * @since  4.0
	 *
	 * @return mixed array or false if writing disabled or error message
	 */
	public function save_wpconfig() {

		global $itsec_globals;

		if ( isset( $itsec_globals['settings']['write_files'] ) && $itsec_globals['settings']['write_files'] === true ) {

			if ( $this->get_file_lock( 'wpconfig' ) ) {

				$success = $this->write_wpconfig(); //save the return value for success/error flag

				$release = $this->release_file_lock( 'wpconfig' );

				if ( $success === true && $release === true ) {

					return array(
						'success' => true,
						'text'    => true,
					);

				} elseif ( $success === true && $release === false ) {

					return array(
						'success' => false,
						'text'    => __( 'Unable to release a lock on your wp-config.php file. If the problem persists contact support.', 'LION' ),
					);;

				} else {

					return array(
						'success' => false,
						'text'    => __( 'Unable to write to your wp-config.php file. If the problem persists contact support.', 'LION' ),
					);

				}

			} else { //return false if we can't get a file lock

				return array(
					'success' => false,
					'text'    => __( 'WordPress was unable to save the your options to wp-config.php. It looks like another process might already be working on the file. Please wait a few minutes and try again or contact support if the problem persists.', 'LION' ),
				);

			}

		} else {

			return false;

		}

	}

	/**
	 * Sets rewrite rules (if updated after initialization).
	 *
	 * @since  4.0
	 *
	 * @param array $rules array of rules to add or replace
	 *
	 * @return void
	 */
	public function set_rewrites( $rules ) {

		if ( is_array( $rules ) ) {

			//Loop through each rule we send and have to find duplicates
			foreach ( $rules as $rule ) {

				$found = false;

				if ( is_array( $rule ) ) {

					if ( sizeof( $this->rewrite_rules ) > 0 ) {

						foreach ( $this->rewrite_rules as $key => $rewrite_rule ) {

							if ( $rule['name'] == $rewrite_rule['name'] ) {

								$found                     = true;
								$this->rewrite_rules[$key] = $rule;

							}

							if ( $found === true ) { //don't keep looping if we don't have to
								break;
							}

						}

					}

					if ( $found === false ) {

						$this->rewrite_rules[] = $rule;

					} else {

						break;

					}

				}

			}

		}

	}

	/**
	 * Sets wp-config.php rules (if updated after initialization).
	 *
	 * @since  4.0
	 *
	 * @param rules $rules array of rules to add or replace
	 */
	public function set_wpconfig( $rules ) {

		if ( is_array( $rules ) ) {

			//Loop through each rule we send and have to find duplicates
			foreach ( $rules as $rule ) {

				$found = false;

				if ( is_array( $rule ) ) {

					if ( sizeof( $this->wpconfig_rules ) > 0 ) {

						foreach ( $this->wpconfig_rules as $key => $wpconfig_rule ) {

							if ( $rule['name'] == $wpconfig_rule['name'] ) {

								$found                      = true;
								$this->wpconfig_rules[$key] = $rule;

							}

							if ( $found === true ) { //don't keep looping if we don't have to
								break;
							}

						}

					}

					if ( $found === false ) {

						$this->wpconfig_rules[] = $rule;

					} else {

						break;

					}

				}

			}

		}

	}

	/**
	 * Writes given rules to htaccess or related file
	 *
	 * @since  4.0
	 *
	 * @access private
	 *
	 * @return bool true on success, false on failure
	 */
	private function write_rewrites() {

		global $wp_filesystem;

		$rules_to_write = $this->build_rewrites(); //String of rules to insert into

		if ( $rules_to_write === false ) { //if there is nothing to write make sure we clean up the file

			return $this->delete_rewrites();

		}

		$rule_open  = array( '# BEGIN iThemes Security', '# BEGIN Better WP Security' );
		$rule_close = array( '# END iThemes Security', '# END Better WP Security' );

		$url = wp_nonce_url( 'options.php?page=itsec_creds', 'itsec_write_wpconfig' );

		$form_fields = array( 'save' );
		$method      = '';

		if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, $form_fields ) ) ) {
			return false; // stop the normal page form from displaying
		}

		if ( ! WP_Filesystem( $creds ) ) {
			// our credentials were no good, ask the user for them again
			request_filesystem_credentials( $url, $method, true, false, $form_fields );

			return false;
		}

		$htaccess_file = ITSEC_Lib::get_htaccess();

		//Make sure we can write to the file
		$perms = substr( sprintf( '%o', @fileperms( $htaccess_file ) ), - 4 );

		@chmod( $htaccess_file, 0644 );

		//make sure the file exists and create it if it doesn't
		if ( ! $wp_filesystem->exists( $htaccess_file ) ) {

			$wp_filesystem->touch( $htaccess_file );

		}

		$htaccess_contents = $wp_filesystem->get_contents( $htaccess_file ); //get the contents of the htaccess or nginx file

		$htaccess_contents = preg_replace( "/(\\r\\n|\\n|\\r)+/", PHP_EOL, $htaccess_contents );

		if ( $htaccess_contents === false ) { //we couldn't get the file contents

			return false;

		} else { //write out what we need to.

			$lines = explode( PHP_EOL, $htaccess_contents ); //create an array to make this easier
			$state = false;

			foreach ( $lines as $line_number => $line ) { //for each line in the file

				if ( in_array( $line, $rule_open ) !== false ) { //if we're at the beginning of the section
					$state = true;
				}

				if ( $state == true ) { //as long as we're not in the section keep writing

					unset( $lines[$line_number] );

				}

				if ( in_array( $line, $rule_close ) !== false ) { //see if we're at the end of the section
					$state = false;
				}

			}

			if ( sizeof( $rules_to_write ) > 0 ) { //make sure we have something to write

				$htaccess_contents = $rule_open[0] . PHP_EOL . implode( PHP_EOL, $rules_to_write ) . PHP_EOL . $rule_close[0] . PHP_EOL . implode( PHP_EOL, $lines );

			}

			//Actually write the new content to wp-config.
			if ( $htaccess_contents !== false ) {

				if ( ! $wp_filesystem->put_contents( $htaccess_file, $htaccess_contents, FS_CHMOD_FILE ) ) {
					return false;
				}

			}

		}

		//reset file permissions if we changed them
		if ( $perms == '0444' ) {
			@chmod( $htaccess_file, 0444 );
		}

		return true;

	}

	/**
	 * Writes given rules to wp-config.php.
	 *
	 * @since  4.0
	 *
	 * @access private
	 *
	 * @return bool true on success, false on failure
	 */
	private function write_wpconfig() {

		global $wp_filesystem;

		$url = wp_nonce_url( 'options.php?page=itsec_creds', 'itsec_write_wpconfig' );

		$form_fields = array( 'save' );
		$method      = '';

		if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, $form_fields ) ) ) {
			return false; // stop the normal page form from displaying
		}

		if ( ! WP_Filesystem( $creds ) ) {

			// our credentials were no good, ask the user for them again
			request_filesystem_credentials( $url, $method, true, false, $form_fields );

			return false;

		}

		$config_file = ITSEC_Lib::get_config();

		//Make sure we can write to the file
		$perms = substr( sprintf( '%o', @fileperms( $config_file ) ), - 4 );

		@chmod( $config_file, 0644 );

		if ( $wp_filesystem->exists( $config_file ) ) { //check wp-config.php exists where we think it should

			$config_contents = $wp_filesystem->get_contents( $config_file ); //get the contents of wp-config.php

			//$config_contents = preg_replace( "/(\\r\\n|\\n|\\r)+/", PHP_EOL, $config_contents );

			if ( ! $config_contents ) { //we couldn't get wp-config.php contents

				return false;

			} else { //write out what we need to.

				$rules_to_write  = ''; //String of rules to insert into wp-config
				$rule_to_replace = ''; //String containing a rule to be replaced
				$rules_to_delete = false; //assume we're not deleting anything to start
				$replace         = false; //assume we're note replacing anything to start with

				//build the rules we need to write, replace or delete
				foreach ( $this->wpconfig_rules as $section_rule ) {

					if ( is_array( $section_rule['rules'] ) ) {

						foreach ( $section_rule['rules'] as $rule ) {

							$found = false;

							if ( ( $rule['type'] === 'add' ) && $rule['rule'] !== false ) { //new rule or replacing a rule that doesn't exist

								$rules_to_write .= $rule['rule'] . PHP_EOL;

							} elseif ( $rule['type'] === 'replace' && $rule['rule'] !== false && strpos( $config_contents, $rule['search_text'] ) !== false ) {

								//Replacing a rule that does exist. Note this will only work on one rule at a time
								$replace = $rule['search_text'];
								$rule_to_replace .= $rule['rule'];
								$found = true;

							}

							if ( $found !== true ) {

								//deleting a rule.
								if ( $rules_to_delete === false ) {
									$rules_to_delete = array();
								}

								$rules_to_delete[] = $rule;

							}

						}

					}

				}

				//deleting a rule.
				if ( $rules_to_delete === false ) {
					$rules_to_delete = array();
				}

				$rules_to_delete[]['search_text'] = "BWPS_FILECHECK";
				$rules_to_delete[]['search_text'] = "BWPS_AWAY_MODE";

				//delete and replace
				if ( $replace !== false || is_array( $rules_to_delete ) ) {

					$config_array = explode( PHP_EOL, $config_contents );

					if ( is_array( $rules_to_delete ) ) {
						$delete_count = 0;
						$delete_total = sizeof( $rules_to_delete );
					} else {
						$delete_total = 0;
						$delete_count = 0;
					}

					foreach ( $config_array as $line_number => $line ) {

						if ( strpos( $line, $replace ) !== false ) {
							$config_array[$line_number] = $rule_to_replace;
						}

						if ( $delete_count < $delete_total ) {

							foreach ( $rules_to_delete as $rule ) {

								if ( strpos( $line, $rule['search_text'] ) !== false ) {

									unset( $config_array[$line_number] );

									//delete the following line(s) if they is blank
									$count = 1;
									while ( isset( $config_array[$line_number + $count] ) && strlen( trim( $config_array[$line_number + $count] ) ) < 1 ) {

										unset( $config_array[$line_number + 1] );

									}

									$delete_count ++;

								}

							}

						}

					}

					$config_contents = implode( PHP_EOL, $config_array );

				}

				//Adding a new rule or replacing rules that don't exist
				if ( strlen( $rules_to_write ) > 1 ) {
					$config_contents = str_replace( '<?php' . PHP_EOL, '<?php' . PHP_EOL . $rules_to_write . PHP_EOL, $config_contents );
				}

			}

		}

		//Actually write the new content to wp-config.
		if ( $config_contents !== false ) {

			if ( ! $wp_filesystem->put_contents( $config_file, $config_contents, FS_CHMOD_FILE ) ) {
				return false;
			}

		}

		//reset file permissions if we changed them
		if ( $perms == '0444' ) {
			@chmod( $config_file, 0444 );
		}

		return true;

	}

}