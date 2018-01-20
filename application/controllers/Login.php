<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Login extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
			//Do your magic here
		}
		/******************************
		Function: Index
		Role: Show login page
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/
		public function index()
		{
			/*Check for already logged in*/
			if ($this->session->userdata('admin')) {
				redirect(ADMIN_URL.'dashboard');
			}
			$data['title'] = 'Login';
			$this->load->view('admin/auth/login', $data);
		}
		/******************************
		Function: loginProcess
		Role: Login form Process
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/
		public function loginProcess()
		{
			/*Get data from form*/
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$Remember = $this->input->post('Remember');
		 
			/*Check for User Existance*/
			$userData = $this->Mod_Common->rowData('ik_admin', '(user_name = "'.$username.'" OR email="'.$username.'") and (status = 1)');

			if (!empty($userData) && count($userData)>0) {
				
				/*Check User Status*/
				if ($userData->status!=1) {

					$this->session->set_flashdata('error_message', "User Not Authenticate !");

					redirect(base_url(ADMIN_URL));
				}else{

					/*Create Hash*/
					$encData = $this->varifyPassword($password, $userData->hash_key, $userData->password);
					
					/*Check Password*/
					if ($encData==1) {
						/*Update Last Login*/
						$condition = array('admin_id'=>$userData->admin_id);
						$updateData = array('lastLoginAt'=>date('Y-m-d H:i:s'), 'lastLoginIP'=>$_SERVER['REMOTE_ADDR'], 'loginCount'=>'loginCount+1');
						$this->Mod_Common->updateData('ik_admin', $condition, $updateData);
						
						/*Assign Session Data*/
						$array['userData'] = array(
							'userID' => $userData->admin_id,
							'userName' => $userData->user_name,
							'firstName' =>$userData->first_name,
							'lastName'=>$userData->last_name,
							'email' => $userData->email,
							'fullName' => $userData->first_name.' '.$userData->last_name,
							'userType'=>1
						);

						$array['userType'] = 'admin'; 

						if ($Remember!='') {
							/*Set Cookies*/
							set_cookie('admin', $array, 86400);
						}

						/*Set Session*/
						$this->session->set_userdata('admin', $array );
						/*Redirect To Dashboard*/
						redirect(ADMIN_URL.'dashboard');
					}else{
						$this->session->set_flashdata('error_message', "Incorrect Password !");
						redirect(base_url(ADMIN_URL));
					}
				}
			}
			else{
				$this->session->set_flashdata('error_message', "User Not Found !");
				redirect(base_url(ADMIN_URL));
			}
		}
		/******************************
		Function: forgetPassword
		Role: Show forget password page
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/
		public function forgetPassword()
		{
			$this->load->view('admin/auth/forget_password');
		}
		/******************************
		Function: Logout
		Role: Logout User and unset data from session
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/
		public function logout()
		{
			/*Unset Session Data*/
			$this->session->unset_userdata('admin');
			$this->session->unset_userdata('AdminDetails');
			redirect(base_url(ADMIN_URL));
		}
		/******************************
		Function: forgetPasswordProcess
		Role: Forget Password Form Action
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/		
		public function forgetPasswordProcess()
		{
			$this->form_validation->set_rules('userNameOrEmail', 'Username or Email', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error_message', 'Username or Email Required !');
				redirect($_SERVER['HTTP_REFERER']);
			}
	
			$userName = $this->input->post('userNameOrEmail');

			$sql = 'SELECT * from user_master where (userName = "'.$userName.'" or email = "'.$userName.'") and userType = 2';

			$userData = $this->Mod_Common->customQuery($sql);
			
			if (count($userData)>0) {
				$userData = current($userData);
				if ($userData->userStatus==1) {
					$email = $userData->email;
					/*Send details to user*/
					//$getEmailTemplate = $this->Mod_Common->rowData('email_templates', array('mail_for'=>'Forget Password', 'mail_template_status'=>1));
					$getEmailTemplate = array();
					/*crate a random temprary otp for reset password*/
					$otp = rand(100000,999999);
					
					if (count($getEmailTemplate)>0) 
					{
						$subject = $getEmailTemplate->mail_subject;
						$message1 = str_replace("FullName", $firstName.' '.$lastName, $getEmailTemplate->mail_message); 
						$message2 = str_replace("UserName", $userName, $message1);
						$message = str_replace("Pwd", $password, $message2);
					}
					else
					{
						$subject = "Account Created on Wipply By Admin";
						$message = "Hello ".$userData->firstName." ".$userData->lastName."!<br>Your one time password for reset password is  <b>".$otp."<b><br><b>Note :</b> This code is valid only for 2 hours.<br>Thank You";
					}		

					//$this->sendEmail('info@wiplly.com', 'Wiplly', $email, $subject, $message);

					$dbData = array(
							'resetToken'=>$otp,
						);
					$this->Mod_Common->updateData('user_master', array('userID'=>$userData->userID), $dbData);
					$this->session->set_flashdata('success_massage', 'OTP has been sent to your email. Please enter the same below.');
					redirect(ADMIN_URL.'verify-otp/'.$userName);
					
				}else{
					$this->session->set_flashdata('error_message', 'Account Inactive!');
						redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				$this->session->set_flashdata('error_message', 'User Not Found !');
						redirect($_SERVER['HTTP_REFERER']);
			}
		}
		/******************************
		Function: verifyOtp
		Role: Enter OTP for verify
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/	
		public function verifyOtp($unm)
		{
			$data['unm']=$unm;

			$this->load->view('admin/auth/otp',$data);
		}
		/******************************
		Function: varifyOtpProcess
		Role: Confirm OTP
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/
		public function varifyOtpProcess()
		{
			$this->form_validation->set_rules('otpName', 'OTP', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_message', 'OTP Is Required !');
			redirect($_SERVER['HTTP_REFERER']);
			}

			$otp = $this->input->post('otpName');
			$userName = $this->input->post('userNameOrEmail');


			$sql = 'SELECT TIMESTAMPDIFF(minute, lastUpdatedAt,CURRENT_TIMESTAMP) as minuteDiff, resetToken from user_master where userName="'.$userName.'" or email="'.$userName.'" and userType = 2';
			$userData = $this->Mod_Common->customQuery($sql);
			if (count($userData)>0) {
				$userData = current($userData);
				if ($userData->resetToken==$otp) {
					if ($userData->minuteDiff<=120) {

						$this->session->set_flashdata('success_massage', 'OTP Varified Succesfully !');

						 redirect(ADMIN_URL.'new-password/'.$userName);
					}else{
						$this->session->set_flashdata('error_message', 'OTP Expired Please Crete New OTP !');
						redirect($_SERVER['HTTP_REFERER']);

					}
				}else{
					$this->session->set_flashdata('error_message', 'Incorrect OTP !');
						redirect($_SERVER['HTTP_REFERER']);
				}
			}else{

				$this->session->set_flashdata('error_message', 'User Not Found !');
						redirect($_SERVER['HTTP_REFERER']);
			}
		}
		/******************************
		Function: newPassword
		Role: Set New password Form
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/
		public function newPassword($uname)
		{
			$data['uname'] = $uname;

			$this->load->view('admin/auth/password_change', $data);
		}
		/******************************
		Function: changePasswordProcess
		Role: Set New password Form Action
		Owner: Sonu Bamniya
		Created At: 14/06/2017
		*******************************/
		public function changePasswordProcess()
		{

			$this->form_validation->set_rules('newpass', 'Password', 'trim|required');
			$this->form_validation->set_rules('cpass', 'Confirm Password', 'trim|required|matches[newpass]');

			if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error_message', 'Password Do Not Match Required !');
			redirect($_SERVER['HTTP_REFERER']);
			}

			$newpass = $this->input->post('newpass');
			$cpass = $this->input->post('cpass');
			$userName = $this->input->post('userNameOrEmail');

			
		
				$sql = 'SELECT userID, hashKey from user_master where userName="'.$userName.'" or email="'.$userName.'" and userType = 2';
				$userData = $this->Mod_Common->customQuery($sql);
			if (count($userData)>0) {
				$userData = current($userData);
				$encData = $this->encryptPassword($newpass);
				$d = array(
							'password'=> $encData['cipherText'],
							'hashKey'=> $encData['HashKey']
						);
				$this->Mod_Common->updateData('user_master', array('userID'=>$userData->userID), $d);

				$this->session->set_flashdata('success_massage', 'Password Changed Succesfully !');

				redirect(ADMIN_URL);


			}else{
				$this->session->set_flashdata('error_message', 'User Not Found !');
				redirect($_SERVER['HTTP_REFERER']);
			}
		  
		}
	}

	/* End of file Login.php */
	/* Location: ./application/controllers/Login.php */
?>