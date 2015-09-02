<?php
/**
 *
 * @author Maganiva
 *
 */
class ExceptionHandler
{
	public function SetExceptionHandler(){
		set_exception_handler(array($this, 'HandleExceptions'));
	}

	public function HandleExceptions($exception){
		if(strcmp(ENVIRONMENT, "production") == 0){
			$errorCode = $exception->getCode();
			$errorMsg = $exception->getMessage();
		} else{
			$errorMsg ='Exception of type \''.get_class($exception).'\' occurred with Message: '.$exception->getMessage(). ' and error code ' . $exception->getCode() . ' in File '.$exception->getFile().' at Line '.$exception->getLine();
			$errorMsg .= $exception->loggable_params;
			$errorMsg .="\r\n Backtrace \r\n";
			$errorMsg .=$exception->getTraceAsString();
		}

		log_message('error', $errorMsg, TRUE);

		if($exception instanceof HandledException){
			$this->CI =& get_instance();
			$this->CI->session->set_flashdata('error_msg', $errorMsg);
			redirect("errorz/show_error");
		}
		show_error($errorMsg);
	}
}