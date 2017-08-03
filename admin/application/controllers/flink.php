<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class flink extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->out_data['cur_f'] = 'flink';
	}

	public function index()
	{
		$this->flink_list();
	}

	function flink_list()
	{
		$this->out_data['con_page'] = 'flink_list';
		$this->out_data['flink_list'] = $this->db->query("select * from {$this->db->dbprefix('flink')} order by sort desc")->result_array();
		$this->load->view('default', $this->out_data);
	}

	function del_flink()
	{
		$id = (int)$this->input->post('id');
		$img = $this->db->query("select img from {$this->db->dbprefix('flink')} where id={$id} limit 1")->row()->img;
		$this->del_img($img);
		$this->db->simple_query("delete from {$this->db->dbprefix('flink')} where id={$id}");
	}

	function edit_flink($flink_id = 0)
	{
		$this->out_data['flink_info'] = $this->db->query("select * from {$this->db->dbprefix('flink')} where id={$flink_id} limit 1")->row_array();
		$this->out_data['con_page'] = 'flink_edit';
		$this->load->view('default', $this->out_data);
	}

	function save_flink()
	{
		$info = array(
		'name' => $this->input->post('name'),
		'url' => $this->input->post('url'),
		'sort' => (int)$this->input->post('sort'),
		'img' => $this->input->post('img'));
		$id = (int)$this->input->post('id');

		if(!$id){
			$this->db->insert('flink', $info);
		}else{
			$old_img = $this->db->query("select img from {$this->db->dbprefix('flink')} where id={$id} limit 1")->row()->img;
			$this->del_img($old_img);
			$this->db->where('id', $id);
			$this->db->update('flink', $info);
		}
	}
}