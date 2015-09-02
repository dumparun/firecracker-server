<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 *
 * @author Maganiva
 *        
 *        
 */

require_once APPPATH . 'utilities/cookie_utility.php';
require_once APPPATH . 'utilities/file_utility.php';

require_once APPPATH . 'libraries/Entity.php';
require_once APPPATH . 'libraries/Handled_exception.php';


class Unsecured_View_Controller extends My_Controller {
	// layout / autoview functionality
	protected $layout_view = 'standard_layout';

	protected $partial_view = false;

	protected $header_view = 'layouts/header_view';

	protected $menu_view = 'layouts/menu_view';

	protected $content_view = '';

	protected $footer_view = 'layouts/footer_view';

	protected $view_data = array ();

	protected $is_json = false;


	function __construct() {

		parent::__construct ();
			
	}


	public function _output($output) {
		
		if((isset($this->session)) && $this->session->flashdata('errorMessage')){
			$this->errorMessage = $this->session->flashdata('errorMessage');
			$this->session->set_flashdata('errorMessage', '');
		}
		
		if((isset($this->session)) && $this->session->flashdata('successMessage')){
			$this->successMessage = $this->session->flashdata('successMessage');
			$this->session->set_flashdata('successMessage', '');
		}
		
		// set the default content view
		if ($this->content_view !== FALSE && empty ( $this->content_view ))
			$this->content_view = $this->router->class . '/' . $this->router->method;
		
		// render the content view
		$contentview = file_exists ( APPPATH . 'views/' . $this->content_view . '.php' ) ? $this->load->view ( $this->content_view, $this->view_data, TRUE ) : FALSE;
		$headerview = file_exists ( APPPATH . 'views/' . $this->header_view . '.php' ) ? $this->load->view ( $this->header_view, null, TRUE ) : FALSE;
		$menuview = file_exists ( APPPATH . 'views/' . $this->menu_view . '.php' ) ? $this->load->view ( $this->menu_view, array (), TRUE ) : FALSE;
		$footerview = file_exists ( APPPATH . 'views/' . $this->footer_view . '.php' ) ? $this->load->view ( $this->footer_view, $this->view_data, TRUE ) : FALSE;
		// render the layout
		if ($this->layout_view && ! $this->is_json) {
			$contentview = $this->load->view ( 'layouts/' . $this->layout_view, array (
					'content_view' => $contentview,
					'header_view' => $headerview,
					'menu_view' => $menuview,
					'footer_view' => $footerview,
					'title' => $this->title,
					'error_message' => $this->errorMessage,
					'success_message' => $this->successMessage,
					'script_data' => $this->scriptData,
					'body_on_load' => $this->bodyOnLoad 
			), TRUE );
		}
		
		$this->errorMessage = null;
		$this->successMessage = null;
		$this->output->renderView ( $contentview );
	
	}
}
