
		<div class="panel panel-default">
			<div class="panel-heading">修改当前用户信息</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-12" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">用户名</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" value="<?php echo $info['name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="nick" class="col-sm-2 control-label">昵称</label>
						<div class="col-sm-10">
							<input class="form-control" name="nick" id="nick" value="<?php echo $info['nick']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">上传头像</label>
						<div class="col-sm-5">
							<input type="hidden" name="avatar" id="img" value="<?php echo $info['avatar']; ?>">
							<div id="fileList" class="uploader-list"></div>
							<div id="filePicker">选择图片</div>
						</div>
						<?php
						$avatar = $info['avatar'];
						echo $avatar;
						if(file_exists('../'.$avatar)):
						?>
						<div class="col-sm-5">
							已上传头像: <a href="<?php echo $site_url.$avatar; ?>" target="_blank"><img src="<?php echo $site_url.$avatar; ?>" width="100" height="100"></a>
						</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">密码</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password">
							<span class="label label-info">留空则不修改</span>
						</div>
					</div>
					<div class="form-group">
						<label for="repassword" class="col-sm-2 control-label">确认密码</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="repassword" id="repassword">
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">简介</label>
						<div class="col-sm-10">
							<input class="form-control" name="intro" id="intro" value="<?php echo $info['intro']; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-primary" onclick="save_user()">保存</button>
							<button type="reset" class="btn btn-danger">重置</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->

<!-- /.row -->

<!-- webuploader -->
<link rel="stylesheet" type="text/css" href="plugins/webuploader/webuploader.css">
<script src="plugins/webuploader/webuploader.min.js"></script>
<script>var dirr = 'avatar', flagg = '';</script>
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
			name: {
				validators: {
					notEmpty: {
						message: '用户名不能为空'
					}
				}
			},
			password: {
				validators: {
					identical: {
						field: 'repassword',
						message: '确认密码和密码不符'
					}
				}
			},
			repassword: {
				validators: {
					identical: {
						field: 'password',
						message: '确认密码和密码不符'
					}
				}
			}
		}
	});
});	
function save_user(){
	//验证表单
	var bootstrapValidator = $('form').data('bootstrapValidator');
	bootstrapValidator.validate();
	if(bootstrapValidator.isValid()){
		$.post(admin.url+'user/save_user',
		$('form').serialize(),
		function (d){
			d = $.parseJSON(d);
			if(d.status){
				layer.msg('添加成功', {icon: 1, time: 2000}, function(){
					location.href = admin.url+"login/logout";
				});
			}else{
				layer.msg(d.msg, {icon: 5, time: 2000});
			}
		})
	}
}

</script>