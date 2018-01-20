<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	public function index()
	{
		//$this->template->load('default','')
	}
	public function activateUser($id)
	{
		$id = base64_decode(urldecode($id));
		$this->Mod_Common->updateData('ik_user', array('user_id'=>$id), array('user_enable'=>1));
		$this->session->set_flashdata('success_message', "User enabled successfully !");
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function deactivateUser($id)
	{
		$id = base64_decode(urldecode($id));
		$this->Mod_Common->updateData('ik_user', array('user_id'=>$id), array('user_enable'=>0));
		$this->session->set_flashdata('success_message', "User disbabled successfully !");
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function listPosts()
	{
		$this->isAuthenticated('admin');
	
		$this->data['title'] = 'Ad Post List';
		$this->data['activeTab'] = 'post';
		$this->data['siteName'] = $this->Mod_Common->getConfigValueByKey('SITE_NAME');
		$sql = 'SELECT ia.*,iat.ad_type_description, iat.ad_type_charges, DATE_FORMAT(iat.ad_type_duration, "%d %b, %Y") as ad_type_duration,  (SELECT GROUP_CONCAT(ad_image_path) from ik_ad_image WHERE 1) as ad_images, u.user_name, ic.category_name as category_name, isc.category_name as sub_category, ics.category_name as co_sub_category, DATE_FORMAT(ia.ad_publise_date, "%d %b, %Y") as ad_publise_date, (case when ia.ad_enable = 0 then "Disabled" else "Enabled" end) as ad_enable_str, ist.state_name, ist.state_code, id.district_name, id.district_code, it.tehsil_name, it.tehsil_code, iv.village_name, iv.village_code from ik_ad ia INNER JOIN ik_user u on u.user_id = ia.user_id INNER JOIN ik_category ic on ic.category_id = ia.category_id LEFT JOIN ik_category isc on ia.sub_category_id = isc.category_id LEFT JOIN ik_category ics on ics.category_id = ia.perent_category_id LEFT JOIN ik_ad_type iat on iat.ad_id = ia.ad_id LEFT JOIN ik_ad_image iai on iai.ad_id = ia.ad_id LEFT JOIN ik_state ist on ist.state_id = ia.state_id LEFT JOIN ik_district id on id.district_id = ia.district_id left JOIN ik_tehsil it on it.tehsil_id = ia.tehsil_id left JOIN ik_village iv on iv.village_id = ia.village_id group by ia.ad_id order by ia.ad_id desc';
		$this->data['posts'] = $this->Mod_Common->customQuery($sql);
		$this->template->load('default', 'posts', $this->data);
	}
	public function activatePost($id)
	{
		$id = base64_decode(urldecode($id));
		$this->Mod_Common->updateData('ik_ad', array('ad_id'=>$id), array('ad_enable'=>1));
		$this->session->set_flashdata('success_message', "Ad enabled successfully !");
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function deactivatePost($id)
	{
		$id = base64_decode(urldecode($id));
		$this->Mod_Common->updateData('ik_ad', array('ad_id'=>$id), array('ad_enable'=>0));
		$this->session->set_flashdata('success_message', "Ad disbabled successfully !");
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function updateDuration($id)
	{
		$id = base64_decode(urldecode($id));
		$date = $this->input->post('duration_date');
		if ($date=='') {
			$this->session->set_flashdata('success_message', "Date field is required !");
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data = $this->Mod_Common->rowData('ik_ad_type',array('ad_id'=>$id));
		if (count($data)>0) {
			$this->Mod_Common->updateData('ik_ad_type', array('ad_id'=>$id), array('ad_type_duration'=>date('Y-m-d', strtotime($date))));
		}else{
			$data = array(
				'ad_type_duration'=>date('Y-m-d', strtotime($date)),
				'ad_id'=>$id
			);
			/*Insert data in database*/
			$this->Mod_Common->insertData('ik_ad_type', $data);
		}
		$this->session->set_flashdata('success_message', "Ad duration updated successfully !");
		redirect($_SERVER['HTTP_REFERER']);
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */