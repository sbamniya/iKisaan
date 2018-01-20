<?php

class MY_Controller extends CI_Controller

{
	public function __construct()
	{
		parent::__construct();
		
		$this->lang->load('en_lang', 'en');
	}
	public function encryptPassword($password, $key='')
	{
		$buffer = $password; 
	    
	    // very simple ASCII key and IV
	    if ($key=='') {
	    	$key = $this->createRandomString(24);
	    }
	    // hex encode the return value
	  	$ciphertext_dec = password_hash($buffer.'$'.$key, PASSWORD_DEFAULT);
	  	$returnData = array(
	  			'cipherText'=>$ciphertext_dec,
	  			'HashKey'=>$key
	  		);
	  	return $returnData;
	}
	public function varifyPassword($password, $key, $hash)
	{
		return password_verify($password.'$'.$key, $hash);
	}
	public function createRandomString($length)
	{
		$str = 'QWERTYUIOPLKJHGFDSAZXCVBNM!@#$%^&*()_+-=qwertyuioplkjhgfdsazxcvbnm1234567890';
		$shuffledStr = str_shuffle($str);
		return substr($shuffledStr, 0, $length);
	}

	public function isAuthenticated($userType, $redirectURL='')
	{ 
		if ($this->session->userdata($userType)) {
			return true;
		}else{
			redirect($redirectURL,'refresh');
		}
	}
	public function sendEmail($from='info@wiplly.com', $name="Wiplly", $to, $subject, $body)
	{
		$this->load->library('email'); // load email library
		$this->email->from($from, $name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($body);
		if ($this->email->send()){
			return true ;
		}else{
			return false ;
		}
	}

	function transformErrorsToArray ($errors) {
	    $errors = explode('</p>', $errors);
	    foreach ($errors as $index => $error) {
	        $error = str_replace('<p>', '', $error);
	        $error = trim($error);
	        if ($error!='') {
	        	$errors[$index] = $error;
	        }
	    }
	    array_pop($errors);
	    return $errors;
	}

	public function uploadImage($imageName, $config = array())
	{  
		if (empty($config)) {
			$this->upload->set_upload_path(base_url().'/uploads/');
			$this->upload->set_allowed_types('gif|jpg|png|jpeg');
			$this->upload->initialize($config);
		}
		if ( ! $this->upload->do_upload($imageName))

        {
        	return $this->upload->display_errors();
        }else{
        	return $this->upload->data();
        }
	}
	public function validateArray($var)
	{
		$error = 0;
		if (count($var)>0) {
			for ($i=0; $i <count($var) ; $i++) { 
				if ($var[$i]=='') {
					$error = 1;
				}
			}
		}
		return $error;
	}
	public function validateImage($var)
	{
		$error = 0;
		if (count($var['name'])>0) {
			for ($i=0; $i <count($var['name']) ; $i++) { 
				if ($var['name'][$i]=='') {
					$error = 1;
				}
			}
		}
		return $error;
	}
}
?>