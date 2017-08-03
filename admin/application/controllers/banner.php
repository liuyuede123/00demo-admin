<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class banner extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->out_data['cur_f'] = 'banner';
	}

	public function index()
	{
		$this->banner_list();
	}

	function banner_list()
	{
		$this->out_data['con_page'] = 'banner_list';
		$this->out_data['banner_list'] = $this->db->query("select * from {$this->db->dbprefix('banner')} order by sort desc")->result_array();
		$this->load->view('default', $this->out_data);
	}

	function del_banner()
	{
		$id = (int)$this->input->post('id');
		$img = $this->db->query("select img from {$this->db->dbprefix('banner')} where id={$id} limit 1")->row()->img;
		$this->del_img($img);
		$this->db->simple_query("delete from {$this->db->dbprefix('banner')} where id={$id}");
	}

	function edit_banner($banner_id = 0)
	{
		$this->out_data['banner_info'] = $this->db->query("select * from {$this->db->dbprefix('banner')} where id={$banner_id} limit 1")->row_array();
		$this->out_data['con_page'] = 'banner_edit';
		$this->load->view('default', $this->out_data);
	}

	function save_banner()
	{
		$info = array(
		'title' => $this->input->post('title'),
		'url' => $this->input->post('url'),
		'sort' => (int)$this->input->post('sort'),
		'img' => $this->input->post('img'));
		$id = (int)$this->input->post('id');

		if(!$id){
			$this->db->insert('banner', $info);
		}else{
			$old_img = $this->db->query("select img from {$this->db->dbprefix('banner')} where id={$id} limit 1")->row()->img;
			$this->del_img($old_img);
			$this->db->where('id', $id);
			$this->db->update('banner', $info);
		}
	}
}