<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class category extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		parent::check_permission('category');
		$this->out_data['cur_f'] = 'category';
	}

	public function index()
	{
		$this->manage_cate();
	}
	
	/* 分类列表 */
	function manage_cate()
	{
		$this->out_data['con_page'] = 'category_list';
		$this->load->view('default', $this->out_data);
	}

	/* 输出编辑分类页面 */
	function edit_cate($cate_id = 0)
	{
		$cate_id = (int)$cate_id;
		$this->out_data['cate_info'] = array('id' => 0);
		if($cate_id){
			$this->out_data['cate_info'] = $this->get_category($cate_id);
		}
		$this->out_data['con_page'] = 'category_edit';
		$this->load->view('default', $this->out_data);
	}
	
	/* 保存分类 */
	function save_cate()
	{
		$category = $this->input->post('title');
		$ename = $this->input->post('ename');
		$url = $this->input->post('url');
		$id = (int)$this->input->post('id');
		$info = array('title' => $category,
			'ename' => $ename,
			'intro' => $this->input->post('intro'),
			'site_title' => $this->input->post('site_title'),
			'site_keywords' => $this->input->post('site_keywords'),
			'site_description' => $this->input->post('site_description'),
			'tpl' => $this->input->post('tpl'),
			'arc_tpl' => $this->input->post('arc_tpl'),
			'url' => $url);
		$this->save_categery($id, $info);
	}

	/* 删除分类 */
	function del_cate()
	{
		$id = (int)$this->input->post('id');
	
		$arc_num = $this->db->query("select count(id) as num from {$this->db->dbprefix('article')} where cate_id={$id}")->row()->num;
		$album_num = $this->db->query("select count(id) as num from {$this->db->dbprefix('cate_album')} where cate_id={$id}")->row()->num;
		if($arc_num > 0){
			parent::result_msg(false, '该分类下还有文章，请清空文章后再试');
		}
		if($album_num > 0){
			parent::result_msg(false, '该分类下还有相册，请清空相册后再试');
		}
		
		$this->db->cache_delete_all();
		$this->db->simple_query("delete from {$this->db->dbprefix('category')} where id={$id}");
		parent::result_msg(true);
	}
	
	/* 分类相册编辑页面 */
	function edit_album($cate_id = 0)
	{
		//相册列表
		$this->out_data['album_list'] = $this->db->query("select id,img,text from {$this->db->dbprefix('cate_album')} where cate_id={$cate_id} order by id desc")->result_array();
		$this->out_data['cate_info'] = $this->get_category($cate_id);//分类信息
		$this->out_data['con_page'] = 'edit_album';
		$this->load->view('default', $this->out_data);
		
	}
	
	/* 保存相册描述 */
	function album_save_text()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$text = $this->input->post('text');
		$this->db->where('id', $id);
		$this->db->update('cate_album', array('text' => $text));
	}
	
	/* 删除相册图片 */
	function del_album()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$tb_album = $this->db->dbprefix('cate_album');
		$img = $this->db->query("select img from {$tb_album} where id={$id} limit 1")->row()->img;
		unlink('../upload/img/'.$img);
		$this->db->simple_query("delete from {$tb_album} where id={$id}");
	}
	
	/* 查看文章列表 */
	function article_list($cate_id = 0, $page = 1)
	{
		$this->out_data['cur_f'] = 'article_'.$cate_id;
		$this->out_data['cate_info'] = $this->get_category($cate_id);//分类信息

		$page = (int)$page;
		$limit = 10;
		$start = ($page - 1)*$limit;
		$this->out_data['article_list'] = $this->db->query("select id,title,click from {$this->db->dbprefix('article')} where cate_id={$cate_id} order by create_date desc,id desc limit {$start},{$limit}")->result_array();//
		$article_count = count($this->db->query("select id from {$this->db->dbprefix('article')} where cate_id={$cate_id}")->result_array());//当前分类文章总数
		$this->out_data['pagin'] = parent::get_pagin(base_url().'category/article_list/'.$cate_id.'/', $article_count, $limit, 4);
		$this->out_data['con_page'] = 'article_list';
		$this->out_data['cate_id'] = $cate_id;
		$this->load->view('default', $this->out_data);
	}
	
	/* 编辑文章 */
	function edit_article($cate_id = 0, $article_id = 0)
	{
		$this->out_data['cur_f'] = 'article_'.$cate_id;
		$this->out_data['flag_list'] = $this->db->query("select id,name,flag from {$this->db->dbprefix('arc_flag')}")->result_array();

		$article_info = $this->db->query("select * from {$this->db->dbprefix('article')} where id={$article_id} limit 1")->row_array();
		if(!$article_info){
			$article_info['cate_id'] = $cate_id;
		}
		$this->out_data['article_info'] = $article_info;
		$this->out_data['con_page'] = 'article_edit';
		$this->load->view('default', $this->out_data);
	}
	
	/* 保存文章 */
	function save_article()
	{
		$this->db->cache_delete_all();
		$info = array('cate_id' => (int)$this->input->post('cate_id'),
		'title' => $this->input->post('title'),
		'content' => $this->input->post('content'),
		'site_title' => $this->input->post('site_title'),
		'site_keywords' => $this->input->post('site_keywords'),
		'site_description' => $this->input->post('site_description'),
		'tags' => $this->input->post('tags'),
		'intro' => $this->input->post('intro'),
		'img' => $this->input->post('img'),
		'attach' => $this->input->post('soft'),
		'flag' => '');
		if($this->input->post('flag'))
		{
			$info['flag'] = join(',', $this->input->post('flag'));
		}
		$id = (int)$this->input->post('id');
		
		$info['update_date'] = date('Y-m-d');

		if(!$id)
		{
			$info['create_date'] = date('Y-m-d');
			$this->db->insert('article', $info);
		}
		else
		{
			$file = $this->db->query("select img,attach from {$this->db->dbprefix('article')} where id={$id} limit 1")->row();
			if($file->img != $info['img']){
				$this->del_img($file->img);
			}else if($file->attach != $info['attach']){
				$this->del_file($file->attach);
			}

			$this->db->where('id', $id);
			$this->db->update('article', $info);
		}
	}
	
	/* 删除文章 */
	function del_article()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$file = $this->db->query("select img,attach from {$this->db->dbprefix('article')} where id={$id} limit 1")->row();
		
		//删除文章下图片和文件
		$this->del_img($file->img);
		$this->del_file($file->attach);

		$this->db->simple_query("delete from {$this->db->dbprefix('article')} where id={$id}");
	}
	
	/* 编辑文章相册 */
	function edit_art_album($art_id = 0)
	{
		$this->out_data['art_list'] = $this->db->query("select id,art_id,img,text from {$this->db->dbprefix('art_img')} where art_id={$art_id}")->result_array();
		$this->out_data['art_info'] = $this->db->query("select * from {$this->db->dbprefix('article')} where id={$art_id} limit 1")->row_array();
		$this->out_data['con_page'] = 'edit_art_album';
		$this->load->view('default', $this->out_data);
	}
	
	/* 删除文章相册 */
	function del_art_album()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$tb_album = $this->db->dbprefix('art_img');
		$img = $this->db->query("select img from {$tb_album} where id={$id} limit 1")->row()->img;
		unlink('../'.$img);
		$this->db->simple_query("delete from {$tb_album} where id={$id}");
	}

	/* 保存文章相册介绍 */
	function save_art_text()
	{
		$this->db->cache_delete_all();
		$id = (int)$this->input->post('id');
		$text = $this->input->post('text');
		$this->db->where('id', $id);
		$this->db->update('art_img', array('text' => $text));
	}
	
	/* 获取单个分类信息 */
	private function get_category($catid = 0)
	{
		$cat = $this->db->query("select id,title,ename,site_title,site_keywords,site_description,url,intro,tpl,arc_tpl from {$this->db->dbprefix('category')} where id={$catid} limit 1")->row_array();
		if($cat){
			return $cat;
		}else{
			redirect('category');
		}
	}
	
	/* 保存分类信息 */
	private function save_categery($id, $info)
	{
		$cate_url_exist = $this->db->query("select id from {$this->db->dbprefix('category')} where url='{$info['url']}' and id <> {$id}")->num_rows();
		$single_url_exist = $this->db->query("select id from {$this->db->dbprefix('single_page')} where url='{$info['url']}'")->num_rows();
		if($cate_url_exist > 0 OR $single_url_exist > 0){
			parent::result_msg(false, '你所输入的分类URL已存在，请重新输入！');
		}
		
		if($id === 0){
			$this->db->insert('category', $info);
		}else{
			$this->db->where('id', $id);
			$this->db->update('category', $info);
		}
		
		$this->db->cache_delete_all();
		parent::result_msg(true);
	}

}