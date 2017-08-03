<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->out_data['cur_f'] = 'my';
	}

	function index()
	{
		$this->edit();
	}

	function edit()
	{
		$this->out_data['info'] = $this->db->select('name,nick,intro,avatar')->from('admin')->where('id', $this->session->userdata('id'))->get()->row_array();
		$this->out_data['con_page'] = 'edit_my';
		$this->load->view('default', $this->out_data);
	}

	function save_user()
	{
		$name = $this->input->post('name');
		$nick = $this->input->post('nick');
		$avatar = $this->input->post('avatar');
		$intro = $this->input->post('intro');
		$password = $this->input->post('password');
		$id = $this->session->userdata('id');
		$is_exist = $this->db->select('id')->from('admin')->where("id <> {$id} and name='{$name}'")->get()->num_rows();
		if($is_exist > 0)
		{
			parent::result_msg(false, '该用户名已存在，请重新输入');
		}
		
		$update = array('name' => $name, 'nick' => $nick, 'intro' => $intro );
		if( !empty($password) )
		{
			$update['password'] = md5($password);
		}

		/*上传头像*/
		$query = $this->db->select('avatar')->from('admin')->where( array('id' => $id) )->get();
		if($query->num_rows() > 0)
		{
			$old_avatar = $query->row()->avatar;
			if($old_avatar AND file_exists('../'.$old_avatar)) unlink('../'.$old_avatar);
		}
		$update['avatar'] = $avatar;
		

		$this->db->update('admin', $update, "id = {$id}");
		
		parent::result_msg(true);
	}

}