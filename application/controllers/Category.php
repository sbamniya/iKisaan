<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	/******************************
	Function: Index
	Role: Show All Catergories List
	Owner: Sonu Bamniya
	Created At: 14/06/2017
	*******************************/
	public function index()
	{
		$this->isAuthenticated('admin');
		$this->data['activeTab'] = 'catagories';
		$this->data['title'] = 'All Catergories';

		$this->data['siteName'] = $this->Mod_Common->getConfigValueByKey('SITE_NAME');
		
		$sql ="SELECT cm.category_name as catName, cm.cat_slug as catSlug, cm.category_enable as catStatus, c.category_name as parentCat from ik_category cm left join ik_category c on c.category_id=cm.parent_id order by cm.category_id desc";

		$this->data['AllCategories'] = $this->Mod_Common->customQuery($sql);

		$this->template->load('default', 'cat/all', $this->data);
	}
	/******************************
	Function: addCategory
	Role: Show Add Category Form
	Owner: Sonu Bamniya
	Created At: 14/06/2017
	*******************************/
	public function addCategory()
	{
		$this->isAuthenticated('admin');
	
		$this->data['title'] = 'Add Catergory';
		$this->data['activeTab'] = 'catagories';
		$this->data['siteName'] = $this->Mod_Common->getConfigValueByKey('SITE_NAME');
		$this->data['AllCategories'] = $this->Mod_Common->selectData('ik_category', 'category_enable=1');
		$this->template->load('default', 'cat/add', $this->data);
	}
	/******************************
	Function: addCategoryProcess
	Role: Add Category Form Proccess
	Owner: Sonu Bamniya
	Created At: 15/06/2017
	*******************************/
	public function addCategoryProcess()
	{
		$this->isAuthenticated('admin');
		/*Set Server side form validations*/
		$this->form_validation->set_rules('catName', 'Category Name', 'trim|required|is_unique[ik_category.category_name]');
		$this->form_validation->set_rules('parentID', 'Parent Category', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			/*Set form errors to show user & redirect to add page*/
			//$errors = $this->transformErrorsToArray(validation_errors());
			$this->session->set_flashdata('error_message', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			/*Get data from form*/
			$catName = $this->input->post('catName');
			$parentID = $this->input->post('parentID');
			/*Create Categoty Slug*/
			$catSlug = $this->Mod_Common->create_unique_slug($catName,'ik_category','category_name');
			if ($parentID == 0) $parentID = null;
			$catData = array(
					'category_name' => $catName,
					'cat_slug' => $catSlug,
					'parent_id' =>$parentID,
					'category_enable' =>1
				);
						
			/*Insert data in database*/
			$this->Mod_Common->insertData('ik_category', $catData);
			$this->session->set_flashdata('success_message', 'Category Added Successfully !');
			redirect(ADMIN_URL.'categories');
		}
	}
	/******************************
	Function: blockCategory
	Role: Block/Inactive Category
	Owner: Sonu Bamniya
	Created At: 15/06/2017
	*******************************/
	public function blockCategory($catSlug)
	{
		$this->isAuthenticated('admin');
		/*Get User Name from URL*/
		$catSlug = urldecode($catSlug);
		
		/*Update User Details*/
		$this->Mod_Common->updateData('ik_category', array('cat_slug'=>$catSlug), array('category_enable'=>0));

		$this->session->set_flashdata('success_message', 'Category Inactive Successfully !');
		redirect($_SERVER['HTTP_REFERER']);
	}
	/******************************
	Function: activateCategory
	Role: Activate Category
	Owner: Sonu Bamniya
	Created At: 15/06/2017
	*******************************/
	public function activateCategory($catSlug)
	{
		$this->isAuthenticated('admin');
		/*Get User Name from URL*/
		$catSlug = urldecode($catSlug);
		
		/*Update User Details*/
		$this->Mod_Common->updateData('ik_category', array('cat_slug'=>$catSlug), array('category_enable'=>1));

		$this->session->set_flashdata('success_message', 'Category Activated Successfully !');
		redirect($_SERVER['HTTP_REFERER']);
	}
	/******************************
	Function: updateCategory
	Role: Update Category Page
	Owner: Sonu Bamniya
	Created At: 15/06/2017
	*******************************/
	public function updateCategory($catSlug)
	{
		$this->isAuthenticated('admin');
		/*Get User Name from URL*/
		$catSlug = urldecode($catSlug);
		
		$cat = $this->Mod_Common->rowData('ik_category', array('cat_slug'=>$catSlug), 'category_id as catID, category_name as catName, cat_slug as catSlug, parent_id as parentID');
		if (!count($cat)) {
			redirect(ADMIN_URL.'categories','refresh');
		}

		$this->data['title'] = $cat->catName.' | Edit ';
		$this->data['siteName'] = $this->Mod_Common->getConfigValueByKey('SITE_NAME');

		$this->data['cat'] = $cat;
		$this->data['catSlug'] = $catSlug;
		$this->data['AllCategories'] = $this->Mod_Common->selectData('ik_category', 'category_enable=1 and category_id !='.$cat->catID);
		$this->data['activeTab'] = 'catagories';
		$this->template->load('default', 'cat/edit', $this->data);
	}
	/******************************
	Function: updateCategoryProccess
	Role: Update Category Page Process(Action)
	Owner: Sonu Bamniya
	Created At: 15/06/2017
	*******************************/
	public function updateCategoryProccess($catSlug)
	{
		$this->isAuthenticated('admin');

		$this->form_validation->set_rules('catName', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('parentID', 'Parent Category', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			/*Set form errors to show user & redirect to add page*/
			//$errors = $this->transformErrorsToArray(validation_errors());
			$this->session->set_flashdata('error_message', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$catSlug = urldecode($catSlug);
			$slugFromForm = urldecode($this->input->post('catSlug'));

			if ($catSlug != $slugFromForm) {
				$this->session->set_flashdata('error_message', 'Invalid Action !');
				redirect($_SERVER['HTTP_REFERER']);
			}

			/*Get data from form*/
			$catName = $this->input->post('catName');

			$catData = $this->Mod_Common->rowData('ik_category', array('category_name'=>$catName));
			if (count($catData)) {
				$this->session->set_flashdata('error_message', 'Category with same name already exist !');
				redirect($_SERVER['HTTP_REFERER']);
			}

			$parentID = $this->input->post('parentID');
			/*Get Admin Id*/
			if ($parentID == 0) $parentID = null;
			$catData = array(
					'category_name' => $catName,
					'parent_id' =>$parentID
				);
						
			/*Insert data in database*/
			$this->Mod_Common->updateData('ik_category', array('cat_slug'=>$catSlug), $catData);

			$this->session->set_flashdata('success_message', 'Category Updated Successfully !');
			redirect(ADMIN_URL.'categories');
		}
	}
}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */