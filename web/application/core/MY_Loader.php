<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );


/**
 *
 * @author Maganiva
 */

/**
 * Sparks
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package CodeIgniter
 * @author CodeIgniter Reactor Dev Team
 * @author Kenny Katzgrau <katzgrau@gmail.com>
 * @since CodeIgniter Version 1.0
 * @filesource
 *
 */

/**
 * Loader Class
 *
 * Loads views and files
 *
 * @package CodeIgniter
 * @subpackage Libraries
 * @author CodeIgniter Reactor Dev Team
 * @author Kenny Katzgrau <katzgrau@gmail.com>
 * @category Loader
 * @link http://codeigniter.com/user_guide/libraries/loader.html
 */
class MY_Loader extends CI_Loader {

	/**
	 * Keep track of which sparks are loaded.
	 * This will come in handy for being
	 * speedy about loading files later.
	 *
	 * @var array
	 */
	var $_ci_loaded_sparks = array ();

	/**
	 */
	var $_ci_services = array ();


	/**
	 * Constructor.
	 * Define SPARKPATH if it doesn't exist, initialize parent
	 */
	function __construct() {

		if (! defined ( 'SPARKPATH' )) {
			define ( 'SPARKPATH', '../codeigniter-2.1.0/sparks/' );
		}
		
		parent::__construct ();
	
	}


	public function initialize() {

		$this->_ci_autoloader ();
	
	}


	/**
	 */
	public function service($service, $name = '') {

		if (is_array ( $service )) {
			foreach ( $service as $babe ) {
				$this->model ( $babe );
			}
			return;
		}
		
		if ($service == '') {
			return;
		}
		
		$path = '';
		
		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos ( $service, '/' )) !== FALSE) {
			// The path is in front of the last slash
			$path = substr ( $service, 0, $last_slash + 1 );
			
			// And the model name behind it
			$service = substr ( $service, $last_slash + 1 );
		}
		
		if ($name == '') {
			$name = $service;
		}
		
		if (in_array ( $name, $this->_ci_services, TRUE )) {
			return;
		}
		
		$CI = & get_instance ();
		if (isset ( $CI->$name )) {
			show_error ( 'The service name you are loading is the name of a resource that is already being used: ' . $name );
		}
		
		$service = strtolower ( $service );
		$service_path = BASE_APPPATH . 'services/';
		
		if (! file_exists ( $service_path . $path . $service . '.php' )) {
			show_error ( 'Unable to locate the service you have specified: ' . $service );
		}
		
		require_once ($service_path . $path . $service . '.php');
		
		$service = ucfirst ( $service );
		
		$CI->$name = new $service ();
		
		$this->_ci_services [] = $name;
		return;
	
	}


	/**
	 * Load a spark by it's path within the sparks directory defined by
	 * SPARKPATH, such as 'markdown/1.0'
	 * 
	 * @param string $spark
	 *        	The spark path withint he sparks directory
	 * @param <type> $autoload
	 *        	An optional array of items to autoload
	 *        	in the format of:
	 *        	array (
	 *        	'helper' => array('somehelper')
	 *        	)
	 * @return <type>
	 */
	function spark($spark, $autoload = array()) {

		if (is_array ( $spark )) {
			foreach ( $spark as $s ) {
				$this->spark ( $s );
			}
		}
		
		$spark = ltrim ( $spark, '/' );
		$spark = rtrim ( $spark, '/' );
		
		$spark_path = SPARKPATH . $spark . '/';
		$parts = explode ( '/', $spark );
		$spark_slug = strtolower ( $parts [0] );
		
		// If we've already loaded this spark, bail
		if (array_key_exists ( $spark_slug, $this->_ci_loaded_sparks )) {
			return true;
		}
		
		// Check that it exists. CI Doesn't check package existence by itself
		if (! file_exists ( $spark_path )) {
			show_error ( "Cannot find spark path at $spark_path" );
		}
		
		if (count ( $parts ) == 2) {
			$this->_ci_loaded_sparks [$spark_slug] = $spark;
		}
		
		$this->add_package_path ( $spark_path );
		
		foreach ( $autoload as $type => $read ) {
			if ($type == 'library')
				$this->library ( $read );
			elseif ($type == 'model')
				$this->model ( $read );
			elseif ($type == 'config')
				$this->config ( $read );
			elseif ($type == 'helper')
				$this->helper ( $read );
			elseif ($type == 'view')
				$this->view ( $read );
			else
				show_error ( "Could not autoload object of type '$type' ($read) for spark $spark" );
		}
		
		// Looks for a spark's specific autoloader
		$this->_ci_autoloader ( $spark_path );
		
		return true;
	
	}


	/**
	 * Specific Autoloader (99% ripped from the parent)
	 *
	 * The config/autoload.php file contains an array that permits sub-systems,
	 * libraries, and helpers to be loaded automatically.
	 *
	 * @access protected
	 * @param
	 *        	array
	 * @return void
	 */
	function _ci_autoloader($basepath = NULL) {

		if ($basepath !== NULL) {
			$autoload_path = $basepath . 'config/autoload.php';
		} else {
			$autoload_path = APPPATH . 'config/autoload.php';
		}
		
		if (! file_exists ( $autoload_path )) {
			return FALSE;
		}
		
		include_once ($autoload_path);
		
		if (! isset ( $autoload )) {
			return FALSE;
		}
		// Autoload packages
		if (isset ( $autoload ['packages'] )) {
			foreach ( $autoload ['packages'] as $package_path ) {
				$this->add_package_path ( $package_path );
			}
		}
		
		// Autoload sparks
		if (isset ( $autoload ['sparks'] )) {
			foreach ( $autoload ['sparks'] as $spark ) {
				$this->spark ( $spark );
			}
		}
		
		if (isset ( $autoload ['config'] )) {
			// Load any custom config file
			if (count ( $autoload ['config'] ) > 0) {
				$CI = & get_instance ();
				foreach ( $autoload ['config'] as $key => $val ) {
					$CI->config->load ( $val );
				}
			}
		}
		
		// Autoload helpers and languages
		foreach ( array (
				'helper',
				'language' 
		) as $type ) {
			if (isset ( $autoload [$type] ) and count ( $autoload [$type] ) > 0) {
				$this->$type ( $autoload [$type] );
			}
		}
		
		// A little tweak to remain backward compatible
		// The $autoload['core'] item was deprecated
		if (! isset ( $autoload ['libraries'] ) and isset ( $autoload ['core'] )) {
			$autoload ['libraries'] = $autoload ['core'];
		}
		
		// Load libraries
		if (isset ( $autoload ['libraries'] ) and count ( $autoload ['libraries'] ) > 0) {
			// Load the database driver.
			if (in_array ( 'database', $autoload ['libraries'] )) {
				$this->database ();
				$autoload ['libraries'] = array_diff ( $autoload ['libraries'], array (
						'database' 
				) );
			}
			
			// Load all other libraries
			foreach ( $autoload ['libraries'] as $item ) {
				$this->library ( $item );
			}
		}
		
		// Autoload models
		if (isset ( $autoload ['model'] )) {
			$this->model ( $autoload ['model'] );
		}
	
	}

}