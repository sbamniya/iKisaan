<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	/******************************
	Function: Index
	Role: Show Dashboard Page
	Owner: Sonu Bamniya
	Created At: 14/06/2017
	*******************************/
	public function index()
	{
		$this->isAuthenticated('admin');
	
		$this->data['title'] = 'Users List';
		$this->data['activeTab'] = 'dashboard';
		$this->data['siteName'] = $this->Mod_Common->getConfigValueByKey('SITE_NAME');
		$sql = 'SELECT u.*, DATE_FORMAT(u.user_dob, "%d %b, %Y") as user_dob, DATE_FORMAT(u.user_reg_date, "%d %b, %Y %h:%i %p") as user_reg_date, (case when user_enable = 0 then "Disabled" else "Enabled" end) as user_enable_str, ist.state_name, ist.state_code, id.district_name, id.district_code, it.tehsil_name, it.tehsil_code, iv.village_name, iv.village_code FROM ik_user u LEFT JOIN ik_state ist on ist.state_id = u.state_id LEFT JOIN ik_district id on id.district_id = u.district_id left JOIN ik_tehsil it on it.tehsil_id = u.tehsil_id left JOIN ik_village iv on iv.village_id = u.village_id order by u.user_id desc';
		$this->data['users'] = $this->Mod_Common->customQuery($sql);
		$this->template->load('default', 'dashboard', $this->data);
	}
}
