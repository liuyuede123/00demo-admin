
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="admin/">管理员列表</a> >> <?php echo $admin['id'] === 0 ? '添加管理员' : '编辑管理员--'.$admin['nick']; ?>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<form class="form-horizontal col-lg-8" role="form">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">账号</label>
						<div class="col-sm-10">
							<input class="form-control" name="name" id="name" value="<?php echo $admin['name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">密码</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" id="password">
							<?php if($admin['id'] != 0): ?>
							<span class="label label-info">留空则不修改密码</span>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="nick" class="col-sm-2 control-label">昵称</label>
						<div class="col-sm-10">
							<input class="form-control" name="nick" id="nick" value="<?php echo $admin['nick']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="intro" class="col-sm-2 control-label">简介</label>
						<div class="col-sm-10">
							<input class="form-control" name="intro" id="intro" value="<?php echo $admin['intro']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="permission" class="col-sm-2 control-label">权限</label>
						<div class="col-sm-10">
							<div class="btn-group" >
								<?php $permission = explode(',', $admin['permission']); ?>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="category" <?php if(in_array('category', $permission)): ?>checked<?php endif; ?>> 分类管理</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="category" <?php if(in_array('article', $permission)): ?>checked<?php endif; ?>> 文章管理</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="single" <?php if(in_array('single', $permission)): ?>checked<?php endif; ?>> 单页面管理</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="user" <?php if(in_array('user', $permission)): ?>checked<?php endif; ?>> 用户管理</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="banner" <?php if(in_array('user', $permission)): ?>checked<?php endif; ?>> 轮播图管理</label>
								<label class="btn btn-success"><input type="checkbox" name="permission[]" value="flink" <?php if(in_array('user', $permission)): ?>checked<?php endif; ?>> 友情链接管理</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
							<button type="button" class="btn btn-primary" onclick="save_admin()">保存</button>
							<button type="reset" class="btn btn-danger">重置</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->


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
						message: '账号不能为空'
					}
				}
			},
			'permission[]': {
				validators: {
					notEmpty: {
						message: '权限不能为空'
					}
				}
			}
		}
			
	});
});	

function save_admin(){
	//验证表单
	var bootstrapValidator = $('form').data('bootstrapValidator');
	bootstrapValidator.validate();
	if(bootstrapValidator.isValid()){
		$.post(admin.url+'admin/save_admin',
		$('form').serialize(),
		function (result){
			result = $.parseJSON(result);
			if(result.status){
				layer.msg('保存成功！', {icon: 1}, function(){
					location.href = admin.url+"admin/";
				});
			}else{
				layer.msg(result.msg, {icon: 5});
			}
		})
	}

}

</script>