
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="category/article_list/5">文章列表</a> >> <?php echo '编辑文章相册--'.$art_info['title']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="jumbotron"> 
					<input type="hidden" value="<?php echo $art_info['id']; ?>" id="art_id">
					<div id="fileList" class="uploader-list"></div>
					<div id="filePicker">点击上传图片</div>
				</div>
				<div class="row">
				<?php foreach($art_list as $v): ?>
					<div class="col-lg-3">
						<div class="panel panel-default">
							<div class="panel-body">
								<a href="<?php echo $site_url.$v['img']; ?>"  target="_blank"><img src="<?php echo $site_url.$v['img']; ?>" class="img-responsive album"></a>
							</div>
							<div class="panel-footer">
								<div class="input-group">
									<input type="text" class="form-control" value="<?php echo $v['text']; ?>" id="text_<?php echo $v['id']; ?>"  placeholder="一句话介绍图片">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" onclick="save_text(<?php echo $v['id']; ?>)">保存</button>
										<button class="btn btn-default" type="button" onclick="del_picture(<?php echo $v['id']; ?>)">删除</button>
									</span>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
				</div>

			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->


<!-- webuploader -->
<link rel="stylesheet" type="text/css" href="plugins/webuploader/webuploader.css">
<script src="plugins/webuploader/webuploader.min.js"></script>
<script>var dirr = 'album', flagg = 'art';</script>
<script src="plugins/webuploader/webuploader.config.js"></script>

<script>
	
function save_text(id){
	var text = $('#text_'+id).val();
	$.post(admin.url+'category/save_art_text',
	{id:id, text:text},
	function (){
		layer.msg('保存成功', {icon: 1}, function(){
			location.reload();
		});
	})
}

function del_picture(id){
	layer.confirm('确认删除该图片？该操作不可恢复，请谨慎操作！', {
	  btn: ['确认','取消'] //按钮
	}, function(){
		$.post(admin.url+'category/del_art_album',
		{id:id},
		function (){
			layer.msg("删除成功", {icon: 1}, function(){
				location.reload();
			});
		})
	})
}

</script>