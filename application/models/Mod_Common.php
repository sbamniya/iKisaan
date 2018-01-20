<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Mod_Common extends CI_Model {
		/******************************
		Function: create_unique_slug
		Role: Create unique slug for every title
		Owner: Rudratosh Shashtri
		Created At: 21 March, 2017
		*******************************/
		
		function create_unique_slug($string,$table,$field='slug',$key=NULL,$value=NULL)
		{
			$checLang = $this->clean($string); 
		    $slug = url_title($string); 
		    if ($checLang!='') {
		    	$slug = strtolower($slug);
		    }
		    $i = 0;
		    $params = array ();
		    $params[$field] = $slug;
		 
		    if($key)$params["$key !="] = $value;
		 
		    while ($this->db->where($params)->get($table)->num_rows())
		    {  
		        if (!preg_match ('/-{1}[0-9]+$/', $slug ))
		            $slug .= '-' . ++$i;
		        else
		            $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
		         
		        $params [$field] = $slug;
		    }  
		    return $slug;  
		} 
		public function clean($string) {
		   return preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars.
		}
		/******************************
		Function: selectData
		Role: select data from given table with specific conditions
		Owner: Sonu Bamniya
		Created At: 18 March, 2017
		*******************************/
		public function selectData($tableName, $condition=array(), $fields='*', $offset=0, $limit=0)
		{
			$this->db->select($fields);

			/*Check for Condition*/
			if ($condition!='' || !empty($condition)) {
				$this->db->where($condition);
			}
			if($limit!=0){
				$this->db->offset($offset);
				$this->db->limit($limit);
			}
			/*Get Data form table*/
			$this->db->from($tableName);

			$query = $this->db->get();	
			$result = $query->result();

			return $result;
		}
		public function rowData($tableName, $condition=array(), $fields='*')
		{
			$this->db->select($fields);

			/*Check for Condition*/
			if ($condition!='' || !empty($condition)) {
				$this->db->where($condition);
			}

			/*Get Data form table*/
			$this->db->from($tableName);

			$query = $this->db->get();	
			$result = $query->row();

			//echo $this->db->last_query();
			return $result;
		}
		public function countRows($tableName, $condition=array(), $fields='*')
		{
			$this->db->select($fields);

			/*Check for Condition*/
			if ($condition!='' || !empty($condition)) {
				$this->db->where($condition);
			}

			/*Get Data form table*/
			$this->db->from($tableName);

			$query = $this->db->get();	
			$result = $query->num_rows();

			return $result;
		}
		/******************************
		Function: insertData
		Role: Insert given data in given table
		Owner: Sonu Bamniya
		Created At: 18 March, 2017
		*******************************/
		public function insertData($tableName, $data)
		{

			$this->db->insert($tableName, $data);
			
			return $this->db->insert_id();
		}
		/******************************
		Function: admin_profile
		Role: Update data in given table with specific condition
		Owner: Sonu Bamniya
		Created At: 18 March, 2017
		*******************************/
		public function updateData($tableName, $condition=array(), $data)
		{
			if ($condition!='' || !empty($condition)) {
				$this->db->where($condition);
			}
			$this->db->update($tableName, $data);
			return true;
		}
		/******************************
		Function: admin_profile
		Role: Run and return result for the given query
		Owner: Sonu Bamniya
		Created At: 18 March, 2017
		*******************************/
		public function customQuery($query)
		{
			$query = $this->db->query($query);
			$result = $query->result();
			
			return $result;
		}
		/******************************
		Function: admin_profile
		Role: Run and return result for the given query
		Owner: Sonu Bamniya
		Created At: 18 March, 2017
		*******************************/
		public function customQueryGetRow($query)
		{
			$query = $this->db->query($query);
			$result = $query->row();
			
			return $result;
		}
		public function alterDbQuery($query)
		{
			$query = $this->db->query($query);
			return true;
		}
	
		public function deleteData($tableName, $condition=array())
		{
			if (!empty($condition) && $condition!='')  {
				$this->db->where($condition);
			}
			$this->db->delete($tableName);
			return true;
		}
		public function getConfigValueByKey($key)
		{
			if ($key=='SITE_NAME') {
				return 'IKisaan';
				die();
			}
			$this->db->select('metaValue');
			$this->db->from('site_config');
			$this->db->where('metaKey', $key);
			$query = $this->db->get();	
			$result = $query->row();
			if (!empty($result)) {
				$r = explode(',', $result->metaValue);
				if (count($r)>1) {
					$result = $r;
				}else{
					$result = $result->metaValue;
				}
			}
			
			return $result;
		}
		public function getHeaderData($tableName='', $condition=array())
		{
			$condiPostLang = isset($_SESSION['langId']) ? $_SESSION['langId'] : 7;

			$data['meta'] = new stdClass;

			if ($tableName == 'usermaster') {
				$data['meta'] = $this->getUserPageMeta($tableName, $condition);
			}
			if ($tableName == 'category_master') {
				$data['meta'] = $this->getCategoryPageMeta($tableName, $condition);
			}

			if ($tableName == 'post_master') {
				$data['meta'] = $this->getSinglePostPageMeta($tableName, $condition);
			}

			/*$data['frontAvailLanguages']= json_decode(file_get_contents(base_url().'api/v1.0.0/get-all-languages'));*/
			$data['breakingNews'] = json_decode(file_get_contents(base_url().'api/v1.0.0/breaking-news?langId='.$condiPostLang));
			/*$data['menuOrder'] = json_decode(file_get_contents(base_url().'api/v1.0.0/menu-order'));*/
			$data['siteLogo'] = json_decode(file_get_contents(base_url().'api/v1.0.0/get-sitelogo'));
			$data['siteName'] = json_decode(file_get_contents(base_url().'api/v1.0.0/get-sitename'));
			
			return $data;	
		}
		public function getUserPageMeta($tableName, $condition=array())
		{	
			$data = new stdClass;
			$data->metaKeyword = '';
			$data->metaDescription = '';

			if ($tableName !='') {
				if (!empty($condition) || $condition!='') {
					$this->db->where($condition);
				}
				$this->db->from($tableName);
				$q = $this->db->get();
				
				$d = $q->row();
				if (!empty($d)) {
					$data->metaKeyword = $d->userName.', '.$d->firstName.' '.$d->lastName.', '.$d->currentLocation;
					$data->metaDescription = $d->bio;
				}
			}
			return $data;
		}
		public function getCategoryPageMeta($tableName, $condition=array())
		{
			$data = new stdClass;
			$data->metaKeyword = '';
			$data->metaDescription = '';

			if ($tableName !='') {
				if (!empty($condition) || $condition!='') {
					$this->db->where($condition);
				}
				$this->db->from($tableName);
				$q = $this->db->get();
				
				$d = $q->row();
				if (!empty($d)) {
					$data->metaKeyword = $d->catTags;
					$data->metaDescription = $d->catDescription;
				}
			}
			return $data;
		}
		public function getSinglePostPageMeta($tableName, $condition=array())
		{
			$data = new stdClass;
			$data->metaKeyword = '';
			$data->metaDescription = '';

			if ($tableName !='') {
				if (!empty($condition) || $condition!='') {
					$this->db->where($condition);
				}
				$this->db->from($tableName);
				$q = $this->db->get();
				
				$d = $q->row();
				if (!empty($d)) {
					$data->metaKeyword = ($d->metaKeyword=='') ? $d->tags : $d->metaKeyword;
					$data->metaDescription = ($d->metaDescription=='') ? $d->shortDescription : $d->metaDescription;
				}
			}
			return $data;
		}
		public function getSideBarData($value='')
		{
			$condiPostLang = isset($_SESSION['langId']) ? $_SESSION['langId'] : 7;

			$data['topMostVideo'] = json_decode(file_get_contents(base_url().'api/v1.0.0/top-most-video'));
			$data['recentPosts'] = json_decode(file_get_contents(base_url().'api/v1.0.0/recent-posts?langId='.$condiPostLang));
			$data['popularPosts'] = json_decode(file_get_contents(base_url().'api/v1.0.0/popular-posts?langId='.$condiPostLang));
			$data['hotPosts'] = json_decode(file_get_contents(base_url().'api/v1.0.0/hot-posts?langId='.$condiPostLang));
			$data['sideBanner'] = json_decode(file_get_contents(base_url().'api/v1.0.0/banner-image?key=LeftRight'));
			return $data;	
		}
		public function adPost($arr_post=array(),$arr_add=array())
		{
			$cnt=0;$pst_cnt=0;$ad_cnt=0;$new_ad_cnt=1;$new_pst_cnt=3;$cnt1=0;
			$html1 = '';$html2 = '';$html3 = '';
			if(count($arr_post)>0)
			{
				if(count($arr_post) >= 4)
				{
					 $postCounter = 1;
				}
				else
				{
					 $postCounter = 0;
				}	
		        while($pst_cnt <= (count($arr_post)+$postCounter))
		        {
					if($pst_cnt<5)
					{
						if($pst_cnt==0)
						{	
							if(!empty($arr_post[$cnt1]))
							$html1.=$arr_post[$cnt1];
							$cnt1++;
						}
						else if($pst_cnt==1)
						{
							if(!empty($arr_post[$cnt1]))
							$html2.=$arr_post[$cnt1];
							$cnt1++;
						}
						else if($pst_cnt==2)
						{
							if(!empty($arr_post[$cnt1]))
							$html3.=$arr_post[$cnt1];
							$cnt1++;
						}
						else if($pst_cnt==3)
						{
							if(!empty($arr_post[$cnt1]))
							$html1.=$arr_post[$cnt1];
							$cnt1++;
						}
						else if($pst_cnt==4)
						{
							$html2.=$arr_add[$cnt];
							$cnt++;$ad_cnt++;
						}
					}
					else
					{
					   if($new_ad_cnt==5)
					   {
							if($ad_cnt==1)
							{
								if(!empty($arr_add[$cnt]))
								$html1.=$arr_add[$cnt];
								$new_ad_cnt=1;
							}
							else if($ad_cnt==2)
							{
								if(!empty($arr_add[$cnt]))
								$html2.=$arr_add[$cnt];
								$new_ad_cnt=1;
							}
							else if($ad_cnt==3)
							{
								if(!empty($arr_add[$cnt]))
								$html3.=$arr_add[$cnt];
								$new_ad_cnt=1;
							}
							$ad_cnt--;
							if($ad_cnt==0)
							{
								$ad_cnt=3;
							}
							$cnt++;
							$new_pst_cnt++;
					   }
					   else
					   {
							if($new_pst_cnt%3==1)
							{
								if(!empty($arr_post[$cnt1]))
								$html1.=$arr_post[$cnt1];
							}
							else if($new_pst_cnt%3==2)
							{
								if(!empty($arr_post[$cnt1]))
								$html2.=$arr_post[$cnt1];
							}
							else if($new_pst_cnt%3==0)
							{
								if(!empty($arr_post[$cnt1]))
								$html3.=$arr_post[$cnt1];
							}
							$new_pst_cnt++;$new_ad_cnt++;
							$cnt1++;
					   }
					}
					$pst_cnt++;	
		        }
			}

			return array($html1,$html2,$html3);
		}
		
	}
	
	/* End of file Mod_Common.php */
	/* Location: ./application/controllers/Mod_Common.php */
 ?>