<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		parent::check_permission('user');
		$this->out_data['cur_f'] = 'user';
	}

	public function index()
	{
		$this->admin_list();
	}

	function admin_list()
	{
		$this->out_data['admin_list'] = $this->db->select('id,name,nick')->from('admin')->where("role != 'admin'")->get()->result_array();
		$this->out_data['con_page'] = 'admin_list';
		$this->load->view('default', $this->out_data);
	}

	function del_admin()
	{
		$id = (int)$this->input->post('id');
		$this->db->delete('admin', array('id' => $id));
	}

	function edit_admin($id = 0)
	{
		if($id == 0)
		{
			$this->out_data['admin'] = array('id' => 0, 'name' => '', 'nick' => '', 'role' => '', 'permission' => '', 'intro' => '');
		}
		else
		{
			$this->out_data['admin'] = $this->db->select('id,name,nick,role,permission,intro')->from('admin')->where('id', $id)->get()->row_array();
		}
		$this->out_data['con_page'] = 'admin_edit';
		$this->load->view('default', $this->out_data);
	}

	function save_admin()
	{
		$id = $this->input->post('id');
		$info = array('name' => $this->input->post('name'),
			'nick' => $this->input->post('nick'),
			'intro' => $this->input->post('intro'));

		$is_exist = $this->db->select('id')->from('admin')->where(array('name' => $info['name'], 'id <> '=> $id))->get()->num_rows();
		if($is_exist)
		{
			parent::result_msg(false, '该账号已存在，请重新输入');
		}

		$permission = $this->input->post('permission');
		if($permission) $permission = join(',', $permission);
		$info['permission'] = $permission;
		$password = $this->input->post('password');
		if($password) $info['password'] = md5($password);


		if($id == 0)
		{
			if(!$password) parent::result_msg(false, '密码不能为空！');
			$this->db->insert('admin', $info);
		}
		else
		{
			$this->db->update('admin', $info, array('id' => $id));
		}
		
		parent::result_msg(true);
	}
}