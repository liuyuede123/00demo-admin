<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class single extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		parent::check_permission('single');
		$this->out_data['cur_f'] = 'single';
	}

	public function index()
	{
		$this->page_list();
	}

	function page_list()
	{
		$this->out_data['con_page'] = 'page_list';
		$this->out_data['page_list'] = $this->db->query("select id,title,url from {$this->db->dbprefix('single_page')}")->result_array();
		$this->load->view('default', $this->out_data);
	}

	function edit_page($page_id = 0)
	{
		$this->out_data['page_info'] = $this->db->query("select * from {$this->db->dbprefix('single_page')} where id={$page_id} limit 1")->row_array();
		$this->out_data['con_page'] = 'page_edit';
		$this->load->view('default', $this->out_data);
	}
	
	function del_page()
	{
		$id = (int)$this->input->post('id');
		$this->db->simple_query("delete from {$this->db->dbprefix('single_page')} where id={$id}");
	}

	function save_page()
	{
		$this->db->cache_delete_all();
		$info = array(
		'title' => $this->input->post('title'),
		'ename' => $this->input->post('ename'),
		'content' => $this->input->post('content'),
		'description' => $this->input->post('description'),
		'site_keywords' => $this->input->post('site_keywords'),
		'site_description' => $this->input->post('site_description'),
		'tpl' => $this->input->post('tpl'),
		'url' => $this->input->post('url'));
		$id = (int)$this->input->post('id');
		
		$cate_url_exist = $this->db->query("select id from {$this->db->dbprefix('category')} where url='".$info['url']."'")->num_rows();
		$single_url_exist = $this->db->query("select id from {$this->db->dbprefix('single_page')} where url='".$info['url']."' and id <> ".$id)->num_rows();
		if($cate_url_exist > 0 OR $single_url_exist > 0)
		{
			parent::result_msg(false, '你所输入的URL已存在，请重新输入');
		}
		
		if($id === 0){
			$this->db->insert('single_page', $info);
		}else{
			$this->db->where('id', $id);
		}
		parent::result_msg(true);
	}
}