<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public $out_data;
	/**
	 * this is the base controller
	 * all the controller must extends base controller explect login
	 */
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Chongqing');
		self::check_login();
		$this->out_data['site_url'] = $this->get_site_url();
		$this->out_data['cate_list'] = $this->get_category_s();
		$this->out_data['cur_f'] = '';
		$this->load->database();
		$this->out_data['permission'] = $this->db->query("select permission from {$this->db->dbprefix('admin')} where id='{$this->session->userdata('id')}' limit 1")->row_array();
		if(!$this->out_data['permission']) redirect(base_url()."login/logout");
	}
	
	/* 检查是否登陆 */
	private function check_login()
	{
		$admin_login = $this->session->userdata('admin_login');
		if(!$admin_login)
		{
			header("Location:".base_url()."login");
		}
	}

	/*检查管理员权限*/
	protected function check_permission($permission = '')
	{
		if($this->session->userdata('role') == 'admin') return true;

		$admin_allow = explode(',', $this->out_data['permission']['permission']);
		if( in_array($permission, $admin_allow) ) return true;
		else header("Location:".base_url());
	}
	
	/* 获取网站跟目录 */
	protected function get_site_url()
	{
		$admin_url = base_url();
		$pos = strripos($admin_url, '/',-2);
		return substr($admin_url, 0, $pos).'/';
	}

	/* 获取siderbar分类信息 */
	protected function get_category_s()
	{
		return $this->db->query("select id,title,url from {$this->db->dbprefix('category')}")->result_array();
	}

	/* 是否是post发送的数据 */
	protected function is_post()
	{
		return $_SERVER['REQUEST_METHOD' ] === 'POST' ? true : false;
	}
	
	/* 返回结果信息 */
	protected function result_msg($status, $msg = '')
	{
		$result = array('status' => $status, 'msg' => $msg);
		echo json_encode($result);
		exit;
		
	}
	
	/* 删除文件夹下的图片 */
	protected function del_img($img_path)
	{
		$img_path = '../'.$img;
		if($img_path and file_exists($img_path))
		{
			unlink($img_path);
		}
	}

	/* 删除文件夹下的文件	*/
	protected function del_file($soft_path)
	{
		$soft_path = '../'.$soft;
		if($soft_path and file_exists($soft_path))
		{
			unlink($soft_path);
		}
	}

	protected function get_pagin($base_url, $total_rows, $limit = 10, $uri_segment = 3)
	{
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$config['use_page_numbers'] = TRUE;
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config); 

		return $this->pagination->create_links();
	}
	
	//积分分页
	protected function get_integral_pagin($base_url, $total_rows, $limit = 10, $uri_segment = 3,$page_query_string = false)
	{
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = $page_query_string;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config); 

		return $this->pagination->create_links();
	}
}