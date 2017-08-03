<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		show_404();
	}

	function upload_img($dirr = 'img')
	{
		$site_url = parent::get_site_url();
		$allowed = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/bmp', 'image/png');
		if (in_array($_FILES['file']['type'], $allowed))
		{
			if ($_FILES["file"]["error"] === 0)
			{
				if($_FILES["file"]['size'] > 300*1024){
					parent::result_msg(false, '图片限制300k以内！');
				}
				$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
				$img = time().rand(100,999).'.'.$ext;
				
				$folder = 'upload/'.$dirr.'/'.date("Y-m-d").'/';
				if(!file_exists('../'.$folder)) mkdir('../'.$folder, 0777, true);
				
				move_uploaded_file($_FILES["file"]["tmp_name"], '../'.$folder.$img);
				
				if($dirr == 'album'){
					//如果是相册添加图片，不通过前端提交，直接存数据库
					if(my_echo($_POST['cate_id'])){//分类的相册
						$tbname = 'cate_album';
						$idname = 'cate_id';
					}else if(my_echo($_POST['art_id'])){//文章的相册
						$tbname = 'art_img';
						$idname = 'art_id';
					}
					$this->db->insert($tbname, array("{$idname}" => (int)$_POST["{$idname}"], 'img' => $folder.$img));
				}
				
				parent::result_msg(true, $folder.$img);
			}
			else
			{
				parent::result_msg(false, $_FILES["file"]["error"]);
			}
		}
		else
		{
			parent::result_msg(false, '不支持的图片格式');
		}
	}

	function upload_file()
	{
		$site_url = parent::get_site_url();

		if ($_FILES["file"]["error"] === 0)
		{
			$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
			$file = time().rand(100,999).'.'.$ext;
			
			$folder = 'upload/soft/'.date("Y-m-d").'/';
			if(!file_exists('../'.$folder)) mkdir('../'.$folder, 0777, true);
			
			move_uploaded_file($_FILES["file"]["tmp_name"], '../'.$folder.$file);
				
			parent::result_msg(true, $folder.$file);
		}
		else
		{
			parent::result_msg(false, $_FILES["file"]["error"]);
		}
	}

}