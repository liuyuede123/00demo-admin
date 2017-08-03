
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="banner/">Banner图片列表</a> >> <?php echo isset($banner_info['title']) ? $banner_info['title'] : '添加Banner'; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">标题</label>
						<div class="col-sm-10">
							<input class="form-control" name="title" id="name" value="<?php echo my_echo($banner_info['title']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-sm-2 control-label">链接</label>
						<div class="col-sm-10">
							<input class="form-control" name="url" id="url" value="<?php echo my_echo($banner_info['url']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="sort" class="col-sm-2 control-label">排序</label>
						<div class="col-sm-10">
							<input class="form-control" name="sort" id="sort" value="<?php echo my_echo($banner_info['sort']); ?>" placeholder="数字越大，排序越靠前">
						</div>
					</div>
					<div class="form-group">
						<label for="img" class="col-sm-2 control-label">轮播图片</label>
						<div class="col-sm-10">
							<input type="hidden" name="img" id="img" value="<?php echo my_echo($banner_info['img']); ?>">
							<div id="fileList" class="uploader-list"></div>
							<div id="filePicker">选择图片</div>
						</div>
					</div>
					<?php
					if(isset($banner_info['img']) and file_exists('../'.$banner_info['img'])):
					?>
					<div class="form-group">
						<label for="img" class="col-sm-2 control-label">已上传图片</label>
						<div class="col-sm-10">
							<a href="<?php echo $site_url.$banner_info['img']; ?>" target="_blank"><img src="<?php echo $site_url.$banner_info['img']; ?>" width="400" height="auto"></a>
						</div>
					</div>
					<?php endif ?>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" id="id" value="<?php echo my_echo($banner_info['id'], 0); ?>">
							<button type="button" class="btn btn-primary" onclick="save_banner()">保存</button>
							<button type="reset" class="btn btn-danger">重置</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->


<!-- webuploader -->
<link rel="stylesheet" type="text/css" href="plugins/webuploader/webuploader.css">
<script src="plugins/webuploader/webuploader.min.js"></script>
<script>var dirr = 'banner', flagg = '';</script>
<script src="plugins/webuploader/webuploader.config.js"></script>

<script>

$(function () {
	$('form').bootstrapValidator({
	　　　message: 'This value is not valid',
		　feedbackIcons: {
			　　　　　　　　valid: 'glyphicon glyphicon-ok',
			　　　　　　　　invalid: 'glyphicon glyphicon-remove',
			　　　　　　　　validating: 'glyphicon glyphicon-refresh'
		　　　　　　　　   },
		fields: {
			title: {
				validators: {
					notEmpty: {
						message: '标题不能为空'
					}
				}
			},
			img: {
				validators: {
					notEmpty: {
						message: '图片不能为空'
					}
				}
			}
		}
			
	});
});	

function save_banner(){
	//验证表单
	var bootstrapValidator = $('form').data('bootstrapValidator');
	bootstrapValidator.validate();
	if(bootstrapValidator.isValid()){ 
		if(!$('#img').val()){
			layer.msg('请选择上传图片', {icon: 5});
		}else{
			$.post(admin.url+'banner/save_banner',
			$('form').serialize(),
			function (id){
				layer.msg('保存成功！', {icon: 1}, function(){
					location.href = admin.url+"banner";
				});
			})
		}
		
		
	}
}

</script>