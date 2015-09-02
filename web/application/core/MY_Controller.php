<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require_once APPPATH . 'libraries/Entity.php';
require_once APPPATH . 'libraries/Unsecured_view_controller.php';
require_once APPPATH . 'libraries/Unsecured_data_controller.php';
require_once APPPATH . 'libraries/Secured_view_controller.php';
require_once APPPATH . 'libraries/Customer_unsecured_view_controller.php';
require_once APPPATH . 'libraries/Customer_secured_view_controller.php';


/**
 *
 * @author Maganiva
 */
class MY_Controller extends CI_Controller {

	// layout / autoview functionality
	protected $layout_view = 'standard_layout';

	protected $header_view = 'layouts/header_view';

	protected $menu_view = 'layouts/menu_view';

	protected $bodyOnLoad = null;

	protected $content_view = '';

	protected $footer_view = 'layouts/footer_view';

	protected $title = 'KinderGarten@maganiva';

	protected $view_data = array ();

	protected $json = false;

	protected $errorMessage = null;

	protected $successMessage = null;

	protected $scriptData = null;

	function __construct() {

		parent::__construct ();

		if ($this->_isSessionStarted () === FALSE) {
			session_start ();
		}

		$_SESSION ["no_image_path"] = RESOURCE_PATH . "images/noimage.png";
	}


	public function _output($output) {

		if ($this->json == true) {
			$contentview = json_encode ( $this->view_data ['JSON'] );
		} else {

			$this->view_data ['white_label'] = 'default';

			// set the default content view
			if ($this->content_view !== FALSE && empty ( $this->content_view ))
				$this->content_view = $this->router->class . '/' . $this->router->method;

			// render the content view
			$contentview = file_exists ( APPPATH . 'views/' . $this->content_view . EXT ) ? $this->load->view ( $this->content_view, $this->view_data, TRUE ) : FALSE;
			// render the layout
			if ($this->layout_view) {
				$contentview = $this->load->view ( 'layouts/' . $this->layout_view, array (
						'content_view' => $contentview,
						'title' => $this->title
				), TRUE );
			}
		}

		$this->output->renderView ( $contentview );

	}


	private function _isSessionStarted() {
		if (php_sapi_name () !== 'cli') {
			if (version_compare ( phpversion (), '5.4.0', '>=' )) {
				return session_status () === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id () === '' ? FALSE : TRUE;
			}
		}
		return FALSE;

	}

}