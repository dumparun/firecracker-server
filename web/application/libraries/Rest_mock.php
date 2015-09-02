<?php
class Rest_Mock extends REST{

	//private $_ci;
	private $_path;
	private $_contents;
	private $_filename;
	
	function __construct()	{
		log_message('debug', "Rest_Mock Class Initialized.");		
		//$this->_ci =& get_instance();		
		
		$this->_path = '/tmp/prime-test-data/';
		if ( ! is_dir($this->_path)){			
			show_error("Rest mock Path not found: $this->_path");
			//exit(10);
		}
	}
	function __destruct(){
		
	}
	
	/**
	 * Handale HTTP get Request
	 *
	 */
	public function get($uri, $params = array(), $format = NULL){
		log_message('debug',$uri);
		$response = $this->get_mock($uri);
		
		log_message("debug",$response);
		
		return json_decode(trim($response));
	}
	
	/**
	 * http Post request - create new entity
	 * how to handle postGet()?
	 *
	 */
	public function post($uri, $params = array(), $format = NULL, $is_array = false){
		log_message('debug',"Rest mock post - $uri");
		//generate random ID
		$random = substr(number_format(time() * rand(),0,'',''),0,10);
		$params->id = $random;
		$params->created_on = time();
		
		$params_json = $this->formatRequest($params, $format, $is_array);
		
		$uri = $uri.'/'.$random;		
		$this->write_mock($params_json,$uri);
		return $params;
	}
	
	/**
	 * Http Post request to get entities
	 *
	 */
	public function getBytPost($uri, $params = array(), $format = NULL, $is_array = false){
		return $this->get($uri,$params,$format,$is_array);
	}
	
	
	/**
	 * upload file to local filesystem
	 * call post with JSON data & return.
	 * 
	 */
	public function upload($uri, $params = array(), $format = NULL, $is_array = false)
	{
		//to do
	}
	
	/**
	 *
	 *
	 */
	public function put($uri, $params = array(), $format = NULL, $is_array = false)
	{
		$params = $this->formatRequest($params, $format,$is_array);
		$this->write_mock($params,"$uri");
		return $params;
	}
	
	/**
	 *
	 *
	 */
	public function delete($uri, $params = array(), $format = NULL)
	{
		
	}
	
	public function formatRequest($params, $format, $is_array){	
		//converting post type to json format. As of now, only two type supported. JSON or body form params. - Ramesh C
		if ($format !== NULL){
			if(strcmp($format,'json') == 0){				
				if($is_array){
					//$is_array && is_array($params)) - convert as json array type [10,20] or [{a=b},{x=y}]
					$params = json_encode($params);
				}else if(is_object($params) && !is_array($params)){
					$array = $this->objectToArray($params);
					$params = json_encode($array);
				}
			}
		}
		
		return $params;
	}
	
	/**
	 * Initialize mock object to empty
	 *
	 * @access	private
	 * @return	void
	 */
	private function _reset()
	{
		$this->_contents = NULL;
		$this->_filename = NULL;
	}
	
	
	protected function get_mock($filename = NULL)
	{
		// Check if cache was requested with the function or uses this object
		if ($filename !== NULL)
		{
			$this->_reset();
			$this->_filename = $filename;
		}
	
		// Check directory permissions
		if ( ! is_dir($this->_path) ){
			return FALSE;
		}
	
		// Build the file path.
		$filepath = $this->_path.$this->_filename.'.mock';
		log_message("debug","mock path : $filepath ");
		// Check if the cache exists, if not return FALSE
		if ( ! @file_exists($filepath))
		{
			return FALSE;
		}
	
		// Check if the cache can be opened, if not return FALSE
		if ( ! $fp = @fopen($filepath, FOPEN_READ))
		{
			return FALSE;
		}
	
		// Lock the cache
		flock($fp, LOCK_SH);
	
		// If the file contains data return it, otherwise return NULL
		if (filesize($filepath) > 0)
		{
			$this->_contents = fread($fp, filesize($filepath));
		}
		else
		{
			$this->_contents = NULL;
		}
	
		// Unlock the cache and close the file
		flock($fp, LOCK_UN);
		fclose($fp);

		// Cleanup the meta variables from the contents
		//$this->_contents = @$this->_contents['__cache_contents'];
	
		// Return the cache
		log_message('debug', "Mock retrieved: ".$filename);
		return $this->_contents;
	}
	
	/**
	 * Write Cache File
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @param	int
	 * @param	array
	 * @return	void
	 */
	protected function write_mock($contents = NULL, $filename = NULL, $expires = NULL, $dependencies = array())
	{
		log_message("debug", "Writing mock file". $filename);
		
		// Check if cache was passed with the function or uses this object
		if ($contents !== NULL)
		{
			$this->_reset();
			$this->_contents = $contents;
			$this->_filename = $filename;
		}
	
		// Check directory permissions
		if ( ! is_dir($this->_path) OR ! is_really_writable($this->_path))
		{
			return;
		}
	
		// check if filename contains dirs
		$subdirs = explode(DIRECTORY_SEPARATOR, $this->_filename);
		if (count($subdirs) > 1)
		{
			array_pop($subdirs);
			$test_path = $this->_path.implode(DIRECTORY_SEPARATOR, $subdirs);
	
			// check if specified subdir exists
			if ( ! @file_exists($test_path))
			{
				// create non existing dirs, asumes PHP5
				if ( ! @mkdir($test_path, DIR_WRITE_MODE, TRUE)) return FALSE;
			}
		}
	 
		// Set the path to the cachefile which is to be created
		$cache_path = $this->_path.$this->_filename.'.mock';
	
		// Open the file and log if an error occures
		if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
		{
			log_message('error', "Unable to write Cache file: ".$cache_path);
			return;
		}
	
		// Lock the file before writing or log an error if it failes
		if (flock($fp, LOCK_EX))
		{
			fwrite($fp, $this->_contents);
			flock($fp, LOCK_UN);
		}
		else
		{
			log_message('error', "Cache was unable to secure a file lock for file at: ".$cache_path);
			return;
		}
		fclose($fp);
		@chmod($cache_path, DIR_WRITE_MODE);
	
		// Log success
		log_message('debug', "Cache file written: ".$cache_path);
	
		// Reset values
		$this->_reset();
	}
	

	/**
	 * Delete Cache File
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	protected function delete_mock($filename = NULL)
	{
		if ($filename !== NULL) $this->_filename = $filename;
	
		$file_path = $this->_path.$this->_filename.'.mock';
	
		if (file_exists($file_path)) unlink($file_path);
	
		// Reset values
		$this->_reset();
	}
	
	/**
	 * Delete a group of cached files
	 *
	 * Allows you to pass a group to delete cache. Example:
	 *
	 * <code>
	 * $this->cache->write($data, 'nav_title');
	 * $this->cache->write($links, 'nav_links');
	 * $this->cache->delete_group('nav_');
	 * </code>
	 *
	 * @param 	string $group
	 * @return 	void
	 */
	public function delete_group($group = null)
	{
		if ($group === null)
		{
			return FALSE;
		}
	
		$this->_ci->load->helper('directory');
		$map = directory_map($this->_path, TRUE);
	
		foreach ($map AS $file)
		{
			if (strpos($file, $group)  !== FALSE)
			{
				unlink($this->_path.$file);
			}
		}
	
		// Reset values
		$this->_reset();
	}
	
	/**
	 * Delete Full Cache or Cache subdir
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function delete_all($dirname = '')
	{
		if (empty($this->_path))
		{
			return FALSE;
		}
	
		$this->_ci->load->helper('file');
		if (file_exists($this->_path.$dirname)) delete_files($this->_path.$dirname, TRUE);
	
		// Reset values
		$this->_reset();
	}
	
	function removeEmptySubFolders($path)
	{
		$empty=true;
		foreach (glob($path.DIRECTORY_SEPARATOR."*") as $file)
		{
			if (is_dir($file))
			{
				if (!removeEmptySubFolders($file)) $empty=false;
			}
			else
			{
				$empty=false;
			}
		}
		if ($empty) rmdir($path);
		return $empty;
	}
	
	/* protected function _call($method, $uri, $params = array(), $format = NULL, $is_array = false, $apiType = 'prime',$retry_count=0)
	{	
		log_message('debug', 'uri : '. $uri);
		log_message('debug', 'method : '. $method);
		log_message('debug', 'params : '. $params);
		
		return 'demo';
	} */
	
	
	
}