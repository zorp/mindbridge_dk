<?php

/**
 * Display File Change Log for Intrusion Detection Module
 *
 * @package    iThemes-Security
 * @subpackage Intrusion-Detection
 * @since      4.0
 */
final class ITSEC_File_Change_Log extends ITSEC_WP_List_Table {

	function __construct() {

		parent::__construct(
		      array(
			      'singular' => 'itsec_file_change_log_item',
			      'plural'   => 'itsec_file_change_log_items',
			      'ajax'     => true
		      )
		);

	}

	/**
	 * Define time column
	 *
	 * @param array $item array of row data
	 *
	 * @return string formatted output
	 *
	 **/
	function column_time( $item ) {

		return $item['time'];

	}

	/**
	 * Define added column
	 *
	 * @param array $item array of row data
	 *
	 * @return string formatted output
	 *
	 **/
	function column_added( $item ) {

		return $item['added'];

	}

	/**
	 * Define removed column
	 *
	 * @param array $item array of row data
	 *
	 * @return string formatted output
	 *
	 **/
	function column_removed( $item ) {

		return $item['removed'];

	}

	/**
	 * Define changed column
	 *
	 * @param array $item array of row data
	 *
	 * @return string formatted output
	 *
	 **/
	function column_changed( $item ) {

		return $item['changed'];

	}

	/**
	 * Define memory used column
	 *
	 * @param array $item array of row data
	 *
	 * @return string formatted output
	 *
	 **/
	function column_memory( $item ) {

		return $item['memory'] . __( 'MB', 'LION' );

	}

	/**
	 * Define detail column
	 *
	 * @param array $item array of row data
	 *
	 * @return string formatted output
	 *
	 **/
	function column_detail( $item ) {

		if ( $item['added'] > 0 || $item['removed'] > 0 || $item['changed'] > 0 ) {

			echo '<a href="itsec-log-file-change-row-' . $item['detail'] . '" class="dialog">' . __( 'Details', 'LION' ) . '</a>';

			$content = '<div id="itsec-log-file-change-row-' . $item['detail'] . '" style="display:none;">';

			$content .= '<h3>' . __( 'Files Added', 'LION' ) . '</h3>';

			$content .= '<ol class="file_change_detail_list">';

			foreach ( $item['added_detail'] as $file => $details ) {
				$content .= '<li class="file_change_detail"><strong>' . __( 'File', 'LION' ) . '</strong>: ' . $file . '<br /><strong>' . __( 'Date', 'LION' ) . '</strong>: ' . date( ' Y-m-d g:i a', $details['mod_date'] ) . '</li>';
			}

			$content .= '</ol>';

			$content .= '<h3>' . __( 'Files Removed', 'LION' ) . '</h3>';

			$content .= '<ol class="file_change_detail_list">';

			foreach ( $item['removed_detail'] as $file => $details ) {
				$content .= '<li class="file_change_detail"><strong>' . __( 'File', 'LION' ) . '</strong>:' . $file . '<br /><strong>' . __( 'Date', 'LION' ) . '</strong>: ' . date( ' Y-m-d g:i a', $details['mod_date'] ) . '</li>';
			}

			$content .= '</ol>';

			$content .= '<h3>' . __( 'Files Changed', 'LION' ) . '</h3>';

			$content .= '<ol class="file_change_detail_list">';

			foreach ( $item['changed_detail'] as $file => $details ) {
				$content .= '<li class="file_change_detail"><strong>' . __( 'File', 'LION' ) . '</strong>: ' . $file . '<br /><strong>' . __( 'Date', 'LION' ) . '</strong>: ' . date( ' Y-m-d g:i a', $details['mod_date'] ) . '</li>';
			}

			$content .= '</ol>';
			$content .= '</div>';

			echo $content;

		}

	}

	/**
	 * Define Columns
	 *
	 * @return array array of column titles
	 */
	public function get_columns() {

		return array(
			'time'    => __( 'Check Time', 'LION' ),
			'added'   => __( 'Files Added', 'LION' ),
			'removed' => __( 'Files Deleted', 'LION' ),
			'changed' => __( 'Files Changed', 'LION' ),
			'memory'  => __( 'Memory Used', 'LION' ),
			'detail'  => __( 'Details', 'LION' ),
		);

	}

	/**
	 * Prepare data for table
	 *
	 * @return void
	 */
	public function prepare_items() {

		global $itsec_logger;

		$columns               = $this->get_columns();
		$hidden                = array();
		$this->_column_headers = array( $columns, $hidden, false );

		$items = $itsec_logger->get_events( 'file_change' );

		$table_data = array();

		$count = 0;

		//Loop through results and take data we need
		foreach ( $items as $item ) {

			$data = maybe_unserialize( $item['log_data'] );

			$table_data[$count]['time']           = $item['log_date'];
			$table_data[$count]['detail']         = $item['log_id'];
			$table_data[$count]['added']          = isset( $data['added'] ) ? sizeof( $data['added'] ) : 0;
			$table_data[$count]['removed']        = isset( $data['removed'] ) ? sizeof( $data['removed'] ) : 0;
			$table_data[$count]['changed']        = isset( $data['changed'] ) ? sizeof( $data['changed'] ) : 0;
			$table_data[$count]['memory']         = isset( $data['memory'] ) ? $data['memory'] : 0;
			$table_data[$count]['added_detail']   = $data['added'];
			$table_data[$count]['removed_detail'] = $data['removed'];
			$table_data[$count]['changed_detail'] = $data['changed'];

			$count ++;

		}

		usort( $table_data, array( $this, 'sortrows' ) );

		$this->items = $table_data;

	}

	/**
	 * Sorts rows by count in descending order
	 *
	 * @param array $a first array to compare
	 * @param array $b second array to compare
	 *
	 * @return int comparison result
	 */
	function sortrows( $a, $b ) {

		// If no sort, default to count
		$orderby = 'time';

		// If no order, default to desc
		$order = 'desc';

		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );

		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : - $result;

	}

}